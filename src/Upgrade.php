<?php

namespace FabianMichael\Meta;

use Kirby\CLI\CLI;
use Kirby\Cms\App;
use Kirby\Cms\ModelWithContent;
use Kirby\Cms\Page;
use Kirby\Content\Version;
use Kirby\Filesystem\Dir;
use Kirby\Filesystem\F;

class Upgrade
{
    protected array $messages = [];

    protected array $codeHits = [];

    /**
     * Patterns that still need a manual code or config edit after 2.x → 3.0.
     *
     * @var array<string, string>
     */
    protected const CODE_PATTERNS = [
        'isIndexible' => 'Rename isIndexible() to isIndexable()',
        'function metadata' => 'Rename metadata() to metaDefaults() / metaOverrides()',
        'meta.load:after' => 'Remove the meta.load:after hook',
        '->changefreq(' => 'Rename changefreq() to sitemapChangefreq()',
        '->priority(' => 'Rename priority() to sitemapPriority()',
        'og_title(' => 'Rename og_title() to ogTitle()',
        'og_description(' => 'Rename og_description() to ogDescription()',
        'og_image(' => 'Rename og_image() to ogImage()',
        'og_title_prefix' => 'Remove og_title_prefix; handle prefixes in metaDefaults()/metaOverrides()',
        'canonical_url' => 'Rename model key canonical_url to meta_canonical_url',
        'forceNoIndex' => 'Rename robots.forceNoIndex to stealthMode',
        'titleSeparator' => 'Use option fabianmichael.meta.title.separator instead of titleSeparator()',
        'title.separators' => 'Remove title.separators; use title.separator',
        'fields/meta/twitter' => 'Remove Twitter blueprint extends',
        'darkvisitors' => 'Remove Dark Visitors config',
    ];

    public function __construct(
        protected App $kirby,
        protected bool $apply = false,
        protected bool $shouldMigrateIndexing = false,
    ) {
    }

    public function run(CLI $cli): void
    {
        $cli->out($this->apply === true
            ? 'Applying Meta 2.x → 3.0 content upgrades…'
            : 'Dry-run: Meta 2.x → 3.0 content upgrades (pass --apply to write)');

        if ($this->shouldMigrateIndexing === true) {
            $this->migrateIndexing();
        } else {
            $this->messages[] = 'Indexing conversion skipped (pass --migrate-indexing to preserve 2.x sitemap rules via robots_index).';
        }

        $this->removeTwitterFields();
        $this->reportTitleSeparator();
        $this->reportStealthMode();
        $this->reportObsoleteSitemapOptions();
        $this->scanCode();

        foreach ($this->messages as $message) {
            $cli->out($message);
        }

        if ($this->codeHits !== []) {
            $cli->br();
            $cli->out('Manual code / config review:');

            foreach ($this->codeHits as $hit) {
                $cli->out('  ' . $hit);
            }
        }

        $cli->br();

        if ($this->apply === true) {
            $cli->success('Content upgrade finished.');
        } else {
            $cli->success('Dry-run finished. Re-run with --apply to write content changes.');
        }
    }

    /**
     * Replicates the 2.0 Sitemap::isPageIndexible() rules and writes robots_index=0
     * for pages that those rules would have excluded.
     */
    protected function migrateIndexing(): void
    {
        $pages = $this->kirby->site()->index();
        $updated = 0;
        $skipped = 0;

        foreach ($pages as $page) {
            if ($this->wasIndexableInV2($page) === true) {
                continue;
            }

            $language = $this->defaultLanguageCode();

            if ($this->needsRobotsIndexOff($page, $language) === false) {
                $skipped++;
                continue;
            }

            $this->messages[] = sprintf(
                '%s robots_index → 0 on %s (excluded by 2.x sitemap rules)',
                $this->apply === true ? 'Set' : 'Would set',
                $page->id()
            );

            if ($this->apply === true) {
                $this->updateVersions($page, ['robots_index' => '0'], [$language]);
            }

            $updated++;
        }

        $this->messages[] = sprintf(
            'Indexing: %d page(s) %s robots_index=0%s.',
            $updated,
            $this->apply === true ? 'updated to' : 'would get',
            $skipped > 0 ? sprintf(', %d already off', $skipped) : ''
        );
    }

    /**
     * 2.0 Sitemap::isPageIndexible() logic, reading exclude/include options from
     * project config (plugin defaults have been removed).
     */
    protected function wasIndexableInV2(Page $page): bool
    {
        $templatesExclude = option('fabianmichael.meta.sitemap.templates.exclude', []);
        $templatesExcludeRegex = '!^(?:' . implode('|', $templatesExclude) . ')$!i';

        $templatesIncludeUnlisted = option('fabianmichael.meta.sitemap.templates.includeUnlisted', []);
        $templatesIncludeUnlistedRegex = '!^(?:' . implode('|', $templatesIncludeUnlisted) . ')$!i';

        $pagesExclude = option('fabianmichael.meta.sitemap.pages.exclude', []);
        $pagesExcludeRegex = '!^(?:' . implode('|', $pagesExclude) . ')$!i';

        $pagesIncludeUnlisted = option('fabianmichael.meta.sitemap.pages.includeUnlisted', []);
        $pagesIncludeUnlistedRegex = '!^(?:' . implode('|', $pagesIncludeUnlisted) . ')$!i';

        if ($page->isErrorPage() === true) {
            return false;
        }

        if ($page->isHomePage() === false && $page->status() === 'unlisted') {
            if (
                preg_match($templatesIncludeUnlistedRegex, $page->intendedTemplate()->name()) !== 1
                && preg_match($pagesIncludeUnlistedRegex, $page->id()) !== 1
            ) {
                return false;
            }
        }

        if (preg_match($templatesExcludeRegex, $page->intendedTemplate()->name()) === 1) {
            return false;
        }

        if (preg_match($pagesExcludeRegex, $page->id()) === 1) {
            return false;
        }

        if ($page->parent() !== null) {
            return $this->wasIndexableInV2($page->parent());
        }

        return true;
    }

    protected function needsRobotsIndexOff(Page $page, string $language): bool
    {
        foreach (['latest', 'changes'] as $versionId) {
            $version = $page->version($versionId);

            if ($version->exists($language) === false) {
                continue;
            }

            $raw = array_change_key_case($version->read($language) ?? [], CASE_LOWER);
            $value = $raw['robots_index'] ?? null;

            if ($value !== '0' && $value !== 0) {
                return true;
            }
        }

        return false;
    }

    protected function removeTwitterFields(): void
    {
        $fields = [
            'twitter_site' => null,
            'twitter_creator' => null,
        ];
        $languages = $this->languageCodes();
        $touched = 0;

        $site = $this->kirby->site();

        if ($this->modelHasAnyField($site, array_keys($fields), $languages) === true) {
            $this->messages[] = sprintf(
                '%s Twitter fields from site content',
                $this->apply === true ? 'Removed' : 'Would remove'
            );

            if ($this->apply === true) {
                $this->updateVersions($site, $fields, $languages);
            }

            $touched++;
        }

        foreach ($this->kirby->site()->index(true) as $page) {
            if ($this->modelHasAnyField($page, array_keys($fields), $languages) === false) {
                continue;
            }

            $this->messages[] = sprintf(
                '%s Twitter fields from %s',
                $this->apply === true ? 'Removed' : 'Would remove',
                $page->id()
            );

            if ($this->apply === true) {
                $this->updateVersions($page, $fields, $languages);
            }

            $touched++;
        }

        if ($touched === 0) {
            $this->messages[] = 'Twitter fields: none found in content.';
        } else {
            $this->messages[] = sprintf(
                'Twitter fields: %d model(s) %s.',
                $touched,
                $this->apply === true ? 'cleaned' : 'would be cleaned'
            );
        }
    }

    protected function reportTitleSeparator(): void
    {
        $found = false;

        foreach ($this->languageCodes() as $language) {
            $version = $this->kirby->site()->version('latest');

            if ($version->exists($language) === false) {
                continue;
            }

            $raw = array_change_key_case($version->read($language) ?? [], CASE_LOWER);
            $value = $raw['meta_title_separator'] ?? null;

            if ($value === null || $value === '') {
                continue;
            }

            $found = true;
            $this->messages[] = sprintf(
                'Manual config: copy site meta_title_separator (%s) → fabianmichael.meta.title.separator = %s, then remove the content field.',
                $language,
                $value
            );
        }

        if ($found === false) {
            $this->messages[] = 'Title separator: no meta_title_separator content field found.';
        }
    }

    protected function reportStealthMode(): void
    {
        $forceNoIndex = option('fabianmichael.meta.robots.forceNoIndex');

        if ($forceNoIndex === true) {
            $this->messages[] = 'Manual config: rename fabianmichael.meta.robots.forceNoIndex to fabianmichael.meta.stealthMode.';
        } else {
            $this->messages[] = 'Stealth mode: robots.forceNoIndex is not set to true.';
        }
    }

    protected function reportObsoleteSitemapOptions(): void
    {
        $keys = [
            'fabianmichael.meta.sitemap.pages.exclude',
            'fabianmichael.meta.sitemap.pages.includeUnlisted',
            'fabianmichael.meta.sitemap.templates.exclude',
            'fabianmichael.meta.sitemap.templates.includeUnlisted',
        ];

        $present = [];

        foreach ($keys as $key) {
            $value = option($key);

            if ($value !== null && $value !== []) {
                $present[] = $key;
            }
        }

        if ($present === []) {
            $this->messages[] = 'Sitemap exclude options: none set in project config (safe to ignore).';

            return;
        }

        foreach ($present as $key) {
            $this->messages[] = sprintf(
                'Manual config: after this upgrade, delete %s from your config (no longer used).',
                $key
            );
        }
    }

    protected function scanCode(): void
    {
        $roots = array_filter([
            $this->kirby->root('templates'),
            $this->kirby->root('snippets'),
            $this->kirby->root('models'),
            $this->kirby->root('controllers'),
            $this->kirby->root('blueprints'),
            $this->kirby->root('config'),
            $this->kirby->root('plugins'),
        ]);

        $pluginRoot = realpath(dirname(__DIR__));

        foreach ($roots as $root) {
            if (is_dir($root) === false) {
                continue;
            }

            foreach ($this->phpAndYmlFiles($root) as $file) {
                $real = realpath($file);

                if ($real !== false && $pluginRoot !== false && str_starts_with($real, $pluginRoot) === true) {
                    continue;
                }

                $contents = F::read($file);

                if ($contents === false || $contents === '') {
                    continue;
                }

                foreach (self::CODE_PATTERNS as $needle => $hint) {
                    if ($this->contentsMatch($contents, $needle) === false) {
                        continue;
                    }

                    $relative = str_replace($this->kirby->root() . DIRECTORY_SEPARATOR, '', $file);
                    $this->codeHits[] = sprintf('%s — %s (%s)', $relative, $hint, $needle);
                }
            }
        }
    }

    protected function contentsMatch(string $contents, string $needle): bool
    {
        // Avoid flagging the 3.0 key meta_canonical_url when scanning for canonical_url
        if ($needle === 'canonical_url') {
            return preg_match('/(?<!meta_)canonical_url/', $contents) === 1;
        }

        return str_contains($contents, $needle);
    }

    /**
     * @return list<string>
     */
    protected function phpAndYmlFiles(string $root): array
    {
        $files = [];

        foreach (Dir::index($root, true) as $relative) {
            $path = $root . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relative);

            if (is_file($path) === false) {
                continue;
            }

            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

            if (in_array($ext, ['php', 'yml', 'yaml'], true) === true) {
                $files[] = $path;
            }
        }

        return $files;
    }

    /**
     * @param list<string> $keys
     * @param list<string> $languages
     */
    protected function modelHasAnyField(
        ModelWithContent $model,
        array $keys,
        array $languages
    ): bool {
        foreach (['latest', 'changes'] as $versionId) {
            foreach ($languages as $language) {
                $version = $model->version($versionId);

                if ($version->exists($language) === false) {
                    continue;
                }

                // Use read() so multilang fallback fields are not treated as present
                $raw = array_change_key_case($version->read($language) ?? [], CASE_LOWER);

                foreach ($keys as $key) {
                    if (array_key_exists(strtolower($key), $raw) === true) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param array<string, mixed> $fields Null values remove keys from content.
     * @param list<string> $languages
     */
    protected function updateVersions(
        ModelWithContent $model,
        array $fields,
        array $languages
    ): void {
        foreach ($languages as $language) {
            foreach (['latest', 'changes'] as $versionId) {
                $version = $model->version($versionId);

                if ($version->exists($language) === false) {
                    continue;
                }

                $this->writeVersionFields($version, $fields, $language);
            }
        }
    }

    /**
     * @param array<string, mixed> $fields
     */
    protected function writeVersionFields(
        Version $version,
        array $fields,
        string $language
    ): void {
        $merged = [
            ...($version->read($language) ?? []),
            ...$fields,
        ];

        foreach ($fields as $key => $value) {
            if ($value === null) {
                unset($merged[$key]);
            }
        }

        $version->replace($merged, $language);
    }

    protected function defaultLanguageCode(): string
    {
        if ($this->kirby->multilang() === true) {
            return $this->kirby->defaultLanguage()->code();
        }

        return 'default';
    }

    /**
     * @return list<string>
     */
    protected function languageCodes(): array
    {
        if ($this->kirby->multilang() === true) {
            return $this->kirby->languages()->codes();
        }

        return ['default'];
    }
}
