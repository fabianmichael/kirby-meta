<?php

use FabianMichael\Meta\PageMeta;
use Kirby\Cms\Page;

return [
    /**
     * Get the page meta object for this page.
     *
     * @param ?string $languageCode The language code to get the meta for. If null, the current language will be used.
     * @return PageMeta The page meta object.
     */
    'meta' => function (?string $languageCode = null): PageMeta {
        return PageMeta::of($this, $languageCode);
    },

    /**
     * Get the default meta values for this page.
     *
     * @param ?string $lang The language code to get the defaults for. If null, the current language will be used.
     * @return array The default meta values.
     */
    'metaDefaults' => function (?string $lang = null): array {
        /** @var Page $this */

        return [
            // 'meta_title' => null,
            // 'meta_canonical_url' => null,
            // 'meta_description' => null,

            // 'sitemap_priority' => null,
            // 'sitemap_changefreq' => null,

            // 'robots_index' => null,
            // 'robots_follow' => null,
            // 'robots_archive' => null,
            // 'robots_imageindex' => null,
            // 'robots_snippet' => null,
            // 'robots_translate' => null,

            // 'og_title' => null,
            // 'og_description' => null,
            // 'og_image' => null,

            // '@graph' => [],
            // '@social' => [],

            // 'lastmod' => null, // unix timestamp expected
        ];
    },

    /**
     * Get the override meta values for this page. These values can be use to
     * force-override the default meta values and even user-defined values.
     *
     * @param ?string $lang The language code to get the overrides for. If null, the current language will be used.
     * @return array The override meta values.
     */
    'metaOverrides' => function (?string $lang = null): array {
        /** @var Page $this */

        return [
            // insert overrides here when overriding this method
        ];
    },

    /**
     * Check if the page is indexible, i.e. if the value of `robots.index` is true.
     * You can customize the behavior of this method by adding it to your page
     * models. This is mainly used for generating the sitemap and for the the
     * panel view to show the indexibility status of the page.
     *
     * @return bool True if the page is indexible, false otherwise.
     */
    'isIndexible' => function (): bool {
        /** @var Page $this */

        return $this->meta()->robots('index');
    },

    /**
     * Get the status text for the indexibility of the page for the panel.
     *
     * @return string The status text.
     */
    'isIndexibleStatusText' => function (): string {
        /** @var Page $this */

        return r($this->isIndexible(), 'indexible', 'not indexible');
    },

    /**
     * Get the status icon for the indexibility of the page for the panel.
     *
     * @return string The status icon.
     */
    'isIndexibleStatusIcon' => function (): string {
        /** @var Page $this */

        return r($this->isIndexible(), 'meta-eye', 'meta-eye-off');
    },

    /**
     * Get the status theme for the indexibility of the page for the panel.
     *
     * @return string The status theme.
     */
    'isIndexibleTheme' => function (): string {
        /** @var Page $this */

        return r($this->isIndexible(), 'positive-icon', 'empty');
    },
];
