<?php

namespace FabianMichael\Meta;

use Kirby\Cms\App as Kirby;
use Kirby\Content\Field;
use Kirby\Cms\File;
use Kirby\Cms\Language;
use Kirby\Cms\Page;
use Kirby\Toolkit\A;

class PageMeta
{
    public const OG_IMAGE_CROP_WIDTH = 1200;
    public const OG_IMAGE_CROP_HEIGHT = 630;

    protected Page $page;
    protected Kirby $kirby;
    protected ?string $languageCode;
    protected array $defaults = [];
    protected array $overrides = [];

    public function __call($name, $arguments): mixed
    {
        return $this->get(strtolower($name), ...$arguments);
    }

    protected function __construct(Page $page, ?string $languageCode = null)
    {
        $this->kirby = $page->kirby();
        $this->languageCode = $languageCode;
        $this->page = $page;

        // Get metadata from page, if possible
        $this->defaults = $this->page->metaDefaults($languageCode);
        $this->overrides = $this->page->metaOverrides($languageCode);
    }

    /**
     * Get the canonical URL for this pageto be used in the canonical link tag.
     *
     * @return string The canonical URL.
     */
    public function canonicalUrl(): string
    {
        return $this->get('meta_canonical_url',
            defaultFallback: true,
            siteFallback: false,
            configFallback: false,
            respectOverrides: true,
            fallback: $this->page->url()
        )->toString() ?: $this->page->url();
    }

    /**
     * Get the changefreq for this page to be used in the XML sitemap.
     *
     * @return ?string The changefreq.
     */
    public function sitemapChangefreq(): ?string
    {
        return $this->get('sitemap_changefreq',
                defaultFallback: true,
                siteFallback: true,
                configFallback: false,
                respectOverrides: true,
                fallback: null
            )->or(null)->value();
    }

    /**
     * Get the meta description as Field object for this page.
     *
     * @return Field The meta description field.
     */
    public function description(): Field
    {        return $this->get('meta_description',
            defaultFallback: true,
            siteFallback: true,
            configFallback: false,
            respectOverrides: true,
            fallback: null
        );
    }

    /**
     * Get a meta value for this page.
     *
     * @param string $key The key of the meta value.
     * @param bool $defaultFallback Whether to use the default fallback value.
     * @param bool $siteFallback Whether to use the site fallback value.
     * @param bool $configFallback Whether to use the config fallback value.
     * @param bool $respectOverrides Whether to respect overrides.
     * @param mixed $fallback The fallback value.
     * @return Field The meta value.
     */
    public function get(
        string $key,
        bool $defaultFallback = true,
        bool $siteFallback = false,
        bool $configFallback = false,
        bool $respectOverrides = true,
        mixed $fallback = null
    ): Field {
        // Overrides always take precedence
        if ($respectOverrides === true && $this->hasOverride($key)) {
            return new Field($this->page, $key, $this->override($key));
        }

        // From content file ...
        $field = $this->page->content($this->languageCode)->get($key);

        if ($field->isNotEmpty() === true) {
            return $field;
        }

        // From page model metadata ...
        if ($defaultFallback === true && array_key_exists($key, $this->defaults) === true) {
            $value = $this->defaults[$key];

            if (is_callable($value) === true) {
                $value = $value->call($this->page);
            }

            return is_a($value, Field::class) === true
                ? $value
                : new Field($this->page, $key, $value);
        }

        // From site as fallback ...
        if ($siteFallback === true) {
            $field = $this->page->site()->content($this->languageCode)->get($key);

            if ($field->isNotEmpty()) {
                return $field;
            }
        }

        // From config as fallback ...
        if ($configFallback === true) {
            $value = option('fabianmichael.meta.' . str_replace('_', '.', $key));

            if ($value !== null) {
                return new Field($this->page, $key, $value);
            }
        }

        // Nothing found, return final fallback value
        return new Field($this->page, $key, $fallback);
    }

    public function jsonld(): array
    {
        $graph = [];
        $site = $this->page->site();

        $websiteId = url('/#website');
        $ownerId = url('/#owner');

        // Website

        $website = [
            '@type' => 'WebSite',
            '@id'   => $websiteId,
            'url'   => $site->url(),
            'name'  => $site->title()->toString(),
            'description' => $site->meta_description()->toString(),
        ];

        if ($locale = $this->locale()) {
            $website['inLanguage'] = $locale;
        }

        $graph[] = $website;

        // Website owner

        $owner = $site->meta_website_owner()->toString();

        if ($owner === 'org') {
            $org = [
                '@type' => 'Organization',
                '@id'   => $ownerId,
                'name'  => $site->meta_org_name()->toString(),
                'url'   => $site->url(),
            ];

            if ($logo = $site->meta_org_logo()->toFile()) {
                $org['logo'] = $logo->url();
            }

            $graph[] = $org;
        } elseif ($owner === 'person' && ($user = $site->meta_person()->toUser())) {
            $person = [
                '@type' => 'Person',
                '@id'   => $ownerId,
                'name' => $user->name()->toString(),
                'email' => $user->email(),
            ];

            if ($avatar = $user->avatar()) {
                $person['image'] = $avatar->url();
            }

            $graph[] = $person;
        }

        // Merge with page metadata …
        $graph = array_merge($graph, $this->default('@graph', []));

        $json = [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];

        // Hook
        $json = $this->kirby->apply(
            'meta.jsonld:after',
            [
                'json'      => $json,
                'meta'      => $this,
                'page'      => $this->page,
            ],
            'json'
        );

        return $json;
    }

    public function language(): ?Language
    {
        return empty($this->languageCode) === false
            ? $this->kirby->language($this->languageCode)
            : null;
    }

    public function languageCode(): ?string
    {
        return $this->languageCode;
    }

    public function lastmod()
    {
        return (int) $this->default('lastmod', $this->page->modified('U', 'date'));
    }

    public function locale(): ?string
    {
        if ($language = $this->page->kirby()->language()) {
            return $language->code();
        } elseif ($locale = $this->page->kirby()->option('locale')) {
            return preg_replace('/^([^.]+)\:/is', '$1', $locale);
        }

        return null;
    }

    public function default(string $key, mixed $fallback = null): mixed
    {
        return A::get($this->defaults, $key, $fallback);
    }

    public function override(string $key, mixed $falllback = null): mixed
    {
        return A::get($this->overrides, $key, $falllback);
    }

    public function hasOverride(string $key): bool
    {
        return array_key_exists($key, $this->overrides) === true;
    }

    public static function of(Page $page, ?string $languageCode = null): static
    {
        return new static($page, $languageCode);
    }

    /**
     * Get the priority for this page to be used in the XML sitemap.
     *
     * @return ?float The priority.
     */
    public function sitemapPriority(): ?float
    {
        $priority = $this->get('sitemap_priority', true, true, false, 0.5)->toFloat();

        return (float) max(0, min(1, $priority)); // 0 <= value <= 1
    }

    /**
     * Get the robots value for this page. If the `$name` parameter is provided,
     * the value will be returned as boolean. If no `$name` parameter is provided,
     * the computed value for the meta tag will be returnedas string.
     *
     * @param ?string $name The name of the robots value.
     * @return bool|string The robots value.
     */
    public function robots(?string $name = null): bool|string
    {
        if (is_string($name)) {
            // single robots value of page as boolean

            if ($name === 'index' && ($this->page->isDraft() || $this->page->isErrorPage())) {
                // if page is a draft or error, always return false
                return false;
            }

            // load from overrrides
            if ($name === 'index') {
                if ($this->hasOverride("robots_{$name}")) {
                    return (bool)$this->override("robots_{$name}");
                }
            }

            // load from content
            $field = $this->page->content($this->languageCode)->get("robots_{$name}");

            if ($field->isNotEmpty()) {
                return $field->toBool();
            }

            // load from model
            $default = $this->default("robots_{$name}");

            if (!is_null($default)) {
                return $default;
            }

            return SiteMeta::robots($name);

        } else {
            // robots value for meta tag as string
            $robots = [];

            foreach (['index', 'follow', 'archive', 'imageindex', 'snippet', 'translate'] as $prop) {
                if ($this->robots($prop) === false) {
                    $robots[] = "no{$prop}";
                }
            }

            $result = sizeof($robots) > 0
                ? implode(', ', $robots)
                : 'all';

            if ($result === 'noindex, nofollow') {
                return 'none';
            }

            return $result;
        }
    }

    /**
     * Get the social metadata for this page for the OpenGraph protocol.
     *
     * @return array The social metadata.
     */
    public function social(): array
    {
        $social = [];
        $site = $this->page->site();

        // OpenGraph

        $locale = $this->locale();

        if ($locale !== null) {
            $social[] = [
                'property' => 'og:locale',
                'content'  => $locale,
            ];
        }

        $social[] = [
            'property' => 'og:site_name',
            'content'  => $site->content()->get('og_site_name')
                ->or($site->title())->toString(),
        ];

        $social[] = [
            'property' => 'og:url',
            'content' => $this->canonicalUrl(),
        ];

        $social[] = [
            'property' => 'og:type',
            'content'  => 'website',
        ];

        $social[] = [
            'property' => 'og:title',
            'content'  => $this->og_title()->toString(),
        ];

        $description = $this->og_description();

        if ($description->isNotEmpty() === true) {
            $social[] = [
                'property' => 'og:description',
                'content'  => $description->toString(),
            ];
        }

        // Social image

        if ($image = $this->og_image()) {
            $extension = $image->extension();

            if ($image->exists()) {
                $thumb = $image->thumb([
                    'width'  => static::OG_IMAGE_CROP_WIDTH,
                    'height' => static::OG_IMAGE_CROP_HEIGHT,
                    'crop'   => true,
                    'format' => in_array($extension, ['jpeg', 'jpg', 'png']) === false ? 'jpg' : null,
                ]);
            } else {
                $thumb = $image;
            }

            $social[] = [
                'property' => 'og:image',
                'content' => $thumb->url(),
            ];

            $social[] = [
                'property' => 'og:image:width',
                'content' => $thumb->width(),
            ];

            $social[] = [
                'property' => 'og:image:height',
                'content' => $thumb->height(),
            ];

            if ($image->alt()->isNotEmpty()) {
                $social[] = [
                    'property' => 'og:image:alt',
                    'content' => $thumb->alt()->toString(),
                ];
            }
        }

        // Additional metadata from page model
        $social = array_merge($social, $this->default('@social', []));

        // Hook
        $social = $this->kirby->apply(
            'meta.social:after',
            [
                'social'   => $social,
                'meta'     => $this,
                'page'     => $this->page,
            ],
            'social'
        );

        return $social;
    }

    /**
     * Get the title for this page to be used in the title tag.
     *
     * @return Field The title field.
     */
    public function title(): Field
    {
        $title = [];
        $siteTitle = $this->page->site()->title();

        if ($this->hasOverride('meta_title')) {
            return new Field($this->page, 'title', $this->override('meta_title'));
        }

        if ($this->page->isHomePage() === true) {
            $title[] = $this->page->content($this->languageCode)->get('meta_title')
                ->or($siteTitle)->toString();
        } else {
            $title[] = $this->page->content($this->languageCode)->get('meta_title')
                ->or($this->page->title())->toString();

            $title[] = option('fabianmichael.meta.title.separator');
            $title[] = $siteTitle->toString();
        }

        return new Field($this->page, 'title', implode(' ', $title));
    }

    public function og_description(): Field
    {
        return $this
            ->get('og_description', true, false)
            ->or($this->gdescription());
    }

    public function og_image(bool $fallback = true): ?File
    {
        if ($this->hasOverride('og_image')) {
            $image = $this->override('og_image');

            if ($image instanceof File) {
                return $image;
            } elseif ($image instanceof Field) {
                return $image->toFile();
            }
        }

        // Overrule auto-generated image if custom one is set:
        // In content file ...
        if ($image = $this->get('og_image', defaultFallback: false, respectOverrides: false)->toFile()) {
            return $image;
        }

        // Search in page model ...
        if ($image = $this->default('og_image')) {
            if ($image instanceof File) {
                return $image;
            } elseif ($image instanceof Field) {
                return $image->toFile();
            }
        }

        // Fallback to global thumbnail
        if ($fallback === true && ($image = $this->page->site()->content($this->languageCode)->get('og_image')->toFile())) {
            return $image;
        }

        return null;
    }

    public function og_title(): Field
    {
        $titlePrefix = $this->get(key: 'og_title_prefix', fallback: '');
        $title = $this->get('og_title')->or($this->title());

        return new Field($this->page, 'og_title', $titlePrefix . $title);
    }

    public function panelTitleAfter(): ?string {
        if ($this->hasOverride('meta_title')) {
            return null;
        }

        if (!$this->page->isHomePage()) {
            return option('fabianmichael.meta.title.separator') . ' ' . $this->page->kirby()->site()->title();
        }

        return null;
    }

    public function panelTitlePlaceholder(): ?string
    {
        if ($this->page->isHomePage()) {
            return $this->page->content($this->languageCode)->get('meta_title')
            ->or($this->page->site()->title())->toString();
        }

        return $this->page->title();
    }

    public function reports(): array
    {
        $isIndexible = $this->page->isIndexible();

        return [
            [
                'value' => $isIndexible
                    ? t('fabianmichael.meta.search_engines.visibility.visible')
                    : t('fabianmichael.meta.search_engines.visibility.hidden'),
                'label' => 'fabianmichael.meta.search_engines.visibility.label',
                'info'  => $isIndexible
                    ? t('fabianmichael.meta.search_engines.visibility.yes')
                    : t('fabianmichael.meta.search_engines.visibility.no'),
                'theme' => $isIndexible ? 'positive' : 'negative',
            ],
        ];
    }
}
