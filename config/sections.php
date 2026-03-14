<?php

use FabianMichael\Meta\SiteMeta;
use Kirby\Cms\File;
use Kirby\Content\Field;
use Kirby\Toolkit\I18n;

return [
    'meta-share-preview' => [
        'mixins' => [
            'label',
        ],
        'props' => [
            'label' => function (string $label): string {
                return I18n::translate($label, $label);
            },
        ],
        'computed' => [
            'is_homepage' => function (): bool {
                return $this->model()->isHomePage();
            },
            'title_separator' => function (): string {
                return option('fabianmichael.meta.title.separator');
            },

            // overrides
            'override_og_title' => function (): ?string {
                return $this->model()->meta()->override('og_title');
            },
            'override_og_description' => function (): ?string {
                return $this->model()->meta()->override('og_description');
            },
            'override_og_image' => function (): ?array {
                return $this->model()->meta()->ogImage(
                    defaultFallback: false,
                    siteFallback: false,
                    respectOverrides: true,
                    content: false
                )?->crop(1200, 630)->toArray();
            },

            // defaults
            'default_og_title' => function (): ?string {
                return $this->model()->meta()->ogTitle(
                    defaultFallback: true,
                    respectOverrides: false,
                    content: false
                );
            },
            'default_og_description' => function (): ?string {
                return $this->model()->meta()->ogDescription(
                    defaultFallback: true,
                    siteFallback: true,
                    respectOverrides: false,
                    content: false
                );
            },
            'default_og_image' => function (): ?array {
                return $this->model()->meta()->ogImage(
                    defaultFallback: true,
                    siteFallback: false,
                    respectOverrides: false,
                    content: false
                )
                    ?->crop(1200, 630)->toArray();
            },

            // site defaults
            'og_site_name' => function (): ?string {
                return $this->model()->meta()->ogSiteName();
            },
            'site_og_image' => function (): ?array {
                return $this->model()->meta()->ogImage(
                    defaultFallback: false,
                    siteFallback: true,
                    respectOverrides: false,
                    content: false
                )?->crop(1200, 630)->toArray();
            },
        ],
    ],
];
