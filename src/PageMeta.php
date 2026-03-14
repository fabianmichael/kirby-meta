<?php

namespace FabianMichael\Meta;

use Kirby\Cms\App as Kirby;
use Kirby\Content\Field;
use Kirby\Cms\File;
use Kirby\Cms\Language;
use Kirby\Cms\Page;
use Kirby\Cms\Site;
use Kirby\Toolkit\A;

class PageMeta
{
    /**
     * Dimensions for the OpenGraph image crop
     */
    public const OG_IMAGE_CROP_WIDTH = 1200;
    public const OG_IMAGE_CROP_HEIGHT = 630;

    protected Kirby $kirby;
    protected Site $site;
    protected Page $page;
    protected ?string $languageCode;

    protected array $defaults = [];
    protected array $overrides = [];

    /**
     * Create a new PageMeta instance for a given page and optional language code.
     *
     * @param Page $page The page to create the PageMeta instance for.
     * @param ?string $languageCode The language code to create the PageMeta instance for.
     * @return void
     */
    protected function __construct(Page $page, ?string $languageCode = null)
    {
        $this->kirby = $page->kirby();
        $this->site = $page->site();
        $this->languageCode = $languageCode;
        $this->page = $page;

        // Get metadata from page, if possible
        $this->defaults = $this->page->metaDefaults($languageCode);
        $this->overrides = $this->page->metaOverrides($languageCode);
    }

    /**
     * Get the canonical URL for this pageto be used in the canonical link tag.
     *
     * @param bool $content Whether to use the content value if available.
     * @return string The canonical URL.
     */
    public function canonicalUrl(bool $content = true): string
    {
        return $this->get('meta_canonical_url',
            defaultFallback: true,
            siteFallback: false,
            configFallback: false,
            respectOverrides: true,
            content: $content,
            fallback: $this->page->url()
        ) ?: $this->page->url();
    }

    /**
     * Get the changefreq for this page to be used in the XML sitemap.
     *
     * @param bool $content Whether to use the content value if available.
     * @return ?string The changefreq.
     */
    public function sitemapChangefreq(bool $content = true): ?string
    {
        return $this->get('sitemap_changefreq',
                defaultFallback: true,
                siteFallback: true,
                configFallback: false,
                respectOverrides: true,
                content: $content,
                fallback: null
            );
    }

    /**
     * Get the meta description as Field object for this page.
     *
     * @param bool $content Whether to use the content value if available.
     * @return Field The meta description field.
     */
    public function description(bool $content = true): ?string
    {
        return $this->get('meta_description',
            defaultFallback: true,
            siteFallback: true,
            configFallback: false,
            respectOverrides: true,
            content: $content,
            fallback: null
        );
    }

    /**
     * Get a meta value for this page by key. The value can be retrieved from
     * overrides, content, defaults, site or config or fallback value in that
     * particular order.
     *
     * @param string $key The key of the meta value.
     * @param bool $defaultFallback Whether to use the default fallback value.
     * @param bool $siteFallback Whether to use the site fallback value.
     * @param bool $configFallback Whether to use the config fallback value.
     * @param bool $respectOverrides Whether to respect overrides.
     * @param bool $content Whether to use the content value if available.
     * @param mixed $fallback The fallback value.
     * @return Field The meta value.
     */
    public function get(
        string $key,
        bool $defaultFallback = true,
        bool $siteFallback = false,
        bool $configFallback = false,
        bool $respectOverrides = true,
        bool $content = true,
        mixed $fallback = null
    ): mixed {
        // Overrides always take precedence over other values
        if ($respectOverrides === true && $this->hasOverride($key)) {
            return $this->override($key);
        }

        // Look in page content
        if ($content === true) {
            $field = $this->page->content($this->languageCode)->get($key);

            if ($field->isNotEmpty() === true) {
                return $field;
            }
        }

        // Look in page model defaults
        if ($defaultFallback === true && $this->hasDefault($key)) {
            $value = $this->default($key);

            if (is_callable($value) === true) {
                $value = $value->call($this->page);
            }

            return $value;
        }

        // From site as fallback ...
        if ($siteFallback === true) {
            $field = $this->site->content($this->languageCode)->get($key);

            if ($field->isNotEmpty()) {
                return $field->value();
            }
        }

        // From config as fallback ...
        if ($configFallback === true) {
            $value = option('fabianmichael.meta.' . str_replace('_', '.', $key));

            if ($value !== null) {
                return $value;
            }
        }

        // Nothing found, return final fallback value
        return $fallback;
    }

    /**
     * Get the JSON-LD data for this page.
     *
     * @return array The JSON-LD data.
     */
    public function jsonld(): array
    {
        $graph = [];

        $websiteId = url('/#website');
        $ownerId = url('/#owner');

        // Website

        $website = [
            '@type' => 'WebSite',
            '@id'   => $websiteId,
            'url'   => $this->site->url(),
            'name'  => $this->site->title()->toString(),
            'description' => $this->site->meta_description()->toString(),
        ];

        if ($locale = $this->locale()) {
            $website['inLanguage'] = $locale;
        }

        $graph[] = $website;

        // Website owner

        $owner = $this->site->meta_website_owner()->toString();

        if ($owner === 'org') {
            $org = [
                '@type' => 'Organization',
                '@id'   => $ownerId,
                'name'  => $this->site->meta_org_name()->toString(),
                'url'   => $this->site->url(),
            ];

            if ($logo = $this->site->meta_org_logo()->toFile()) {
                $org['logo'] = $logo->url();
            }

            $graph[] = $org;
        } elseif ($owner === 'person' && ($user = $this->site->meta_person()->toUser())) {
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

    /**
     * Get the language object for this page.
     *
     * @return ?Language The language object.
     */
    public function language(): ?Language
    {
        return empty($this->languageCode) === false
            ? $this->kirby->language($this->languageCode)
            : null;
    }

    /**
     * Get the language code for this page.
     *
     * @return ?string The language code.
     */
    public function languageCode(): ?string
    {
        return $this->languageCode;
    }

    /**
     * Get the last modified date for this page.
     *
     * @return int The last modified date.
     */
    public function lastmod()
    {
        return (int)$this->get('lastmod',
            defaultFallback: true,
            siteFallback: false,
            configFallback: false,
            respectOverrides: true,
            content: false,
            fallback: $this->page->modified('U', 'date')
        );
    }

    /**
     * Get the locale for this page.
     *
     * @return ?string The locale.
     */
    public function locale(): ?string
    {
        if ($language = $this->page->kirby()->language()) {
            return $language->code();
        } elseif ($locale = $this->page->kirby()->option('locale')) {
            return preg_replace('/^([^.]+)\:/is', '$1', $locale); // get everything before the first colon
        }

        return null;
    }

    /**
     * Get the default value for a given key.
     *
     * @param string $key The key of the default value.
     * @param mixed $fallback The fallback value.
     * @return mixed The default value.
     */
    public function default(string $key, mixed $fallback = null): mixed
    {
        return A::get($this->defaults, $key, $fallback);
    }

    /**
     * Check if a default value exists for a given key and is not null.
     *
     * @param string $key The key of the default value.
     * @return bool True if a default value exists, false otherwise.
     */
    public function hasDefault(string $key): bool
    {
        return A::get($this->defaults, $key) !== null;
    }

    /**
     * Get the override value for a given key.
     *
     * @param string $key The key of the override value.
     * @param mixed $fallback The fallback value.
     * @return mixed The override value.
     */
    public function override(string $key, mixed $falllback = null): mixed
    {
        return A::get($this->overrides, $key, $falllback);
    }

    /**
     * Check if an override value exists for a given key and is not null.
     *
     * @param string $key The key of the override value.
     * @return bool True if an override value exists, false otherwise.
     */
    public function hasOverride(string $key): bool
    {
        return A::get($this->overrides, $key) !== null;
    }

    /**
     * Create a new PageMeta instance for a given page and language code.
     *
     * @param Page $page The page to create the PageMeta instance for.
     * @param ?string $languageCode The language code to create the PageMeta instance for.
     * @return static The PageMeta instance.
     */
    public static function of(Page $page, ?string $languageCode = null): static
    {
        return new static($page, $languageCode);
    }

    /**
     * Get the priority for this page to be used in the XML sitemap.
     *
     * @param bool $content Whether to use the content value.
     * @return ?float The priority.
     */
    public function sitemapPriority(bool $content = true): ?float
    {
        $priority = $this->get('sitemap_priority',
            defaultFallback: true,
            siteFallback: true,
            configFallback: false,
            respectOverrides: true,
            content: $content,
            fallback: 0.5
        );

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

            if ($name === 'index' && $this->page->isDraft() || $this->page->isErrorPage()) {
                // if page is a draft or error, always return false
                return false;
            }

            // from overrides
            if ($this->hasOverride("robots_{$name}")) {
                return (bool)$this->override("robots_{$name}");
            }

            // from content
            $field = $this->page->content($this->languageCode)->get("robots_{$name}");

            if ($field->isNotEmpty()) {
                return $field->toBool();
            }

            // from defaults
            if ($this->hasDefault("robots_{$name}")) {
                return $this->default("robots_{$name}");
            }

            return SiteMeta::robots($name);
        }

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

    /**
     * Get the social metadata for this page for the OpenGraph protocol.
     *
     * @return array The social metadata.
     */
    public function social(): array
    {
        $social = [];

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
            'content'  => $this->ogSiteName(),
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
            'content'  => $this->ogTitle(),
        ];

        if ($ogDescription = $this->ogDescription()) {
            $social[] = [
                'property' => 'og:description',
                'content'  => $ogDescription,
            ];
        }

        // Social image

        if ($image = $this->ogImage()) {
            $extension = $image->extension();

            if ($image->exists()) {
                $thumb = $image->thumb([
                    'width'  => static::OG_IMAGE_CROP_WIDTH,
                    'height' => static::OG_IMAGE_CROP_HEIGHT,
                    'crop'   => true,
                    'format' => !in_array($extension, ['jpeg', 'jpg', 'png']) ? 'jpg' : $extension,
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
    public function title(): string
    {
        $title = [];
        $siteTitle = $this->page->site()->title();

        if ($this->hasOverride('meta_title')) {
            return $this->override('meta_title');
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

        return implode(' ', $title);
    }

    public function ogSiteName(): string
    {
        return $this->site->content()->get('og_site_name')
        ->or($this->site->title())->value();
    }

    public function ogDescription(bool $content = true): string
    {
        return $this->get('og_description',
            defaultFallback: true,
            siteFallback: true,
            configFallback: false,
            respectOverrides: true,
            content: $content,
            fallback: $this->description()
        );
    }

    public function ogImage(bool $fallback = true): ?File
    {
        if ($image = $this->get('og_image',
            siteFallback: true,
        )) {
            if ($image instanceof File) {
                return $image;
            }

            if ($image instanceof Field && ($image = $image->toFile())) {
                return $image;
            }
        }

        // Search in page model ...
        if ($image = $this->default('og_image')) {
            if ($image instanceof File) {
                return $image;
            } elseif ($image instanceof Field && ($image = $image->toFile())) {
                return $image;
            }
        }

        // Fallback to global thumbnail
        if ($fallback === true && ($image = $this->page->site()->content($this->languageCode)->get('og_image')->toFile())) {
            return $image;
        }

        return null;
    }

    /**
     * Get the OpenGraph title for this page.
     *
     * @param bool $content Whether to lookup in page content.
     * @return string The OpenGraph title.
     */
    public function ogTitle(bool $content = true): ?string
    {
        return $this->get('og_title',
            defaultFallback: true,
            siteFallback: true,
            configFallback: false,
            respectOverrides: true,
            content: $content,
            fallback: null
        ) ?: $this->page->title()->toString();
    }

    /**
     * Get the after text for the panel title field.
     *
     * @return ?string The after text for the panel title.
     */
    public function panelTitleAfter(): ?string {
        if (!$this->page->isHomePage()) {
            return option('fabianmichael.meta.title.separator') . ' ' . $this->page->kirby()->site()->title();
        }

        return null;
    }

    /**
     * Get the placeholder text for the panel title field.
     *
     * @return ?string The placeholder text for the panel title.
     */
    public function panelTitlePlaceholder(): ?string
    {
        if ($this->page->isHomePage()) {
            return $this->site->title()->toString();
        }

        return $this->get('meta_title',
            defaultFallback: true,
            siteFallback: false,
            configFallback: false,
            respectOverrides: true,
            content: false,
            fallback: null
        ) ?: $this->page->title()->toString();
    }

    /**
     * Get the reports for the status section of this page.
     *
     * @return array The reports.
     */
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
