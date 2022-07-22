<?php

use FabianMichael\Meta\SiteMeta;

return [
    'meta-share-preview' => [
        'mixins' => [
            'headline',
        ],
        'computed' => [
            'metadata_og_image' => function (): ?array {
                $image = $this->model()->meta()->metadata('og_image');

                return $image ? $image->crop(1200, 630)->toArray() : null;
            },
            'page_is_homepage' => function (): bool {
                return $this->model()->isHomePage();
            },
            'page_title' => function (): ?string {
                return $this->model()->title()->value();
            },
            'page_metadata_description' => function (): ?string {
                return $this->model()->meta()->metadata('meta_description');
            },
            'site_meta_description' => function (): ?string {
                return $this->model()->site()->content()->get('meta_description')->value();
            },
            'site_name' => function (): ?string {
                $site = $this->model()->site();

                return $site->og_site_name()->or($site->title())->value();
            },
            'site_og_image' => function (): ?array {
                $image = $this->model()->site()->content()->get('og_image')->toFile();

                return $image ? $image->crop(1200, 630)->toArray() : null;
            },
            'site_title' => function (): ?string {
                return $this->model()->site()->title()->value();
            },
            'title_separator' => function (): string {
                return SiteMeta::titleSeparator();
            },
            'og_title_prefix' => function (): ?string {
                return $this->model()->meta()->get('og_title_prefix')->value();
            },
            'url' => function (): string {
                return $this->model()->url();
            },
        ],
    ],
];
