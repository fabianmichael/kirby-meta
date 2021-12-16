<?php

use FabianMichael\Meta\Meta;
use FabianMichael\Meta\SiteMeta;
use Kirby\Cms\File;
use Kirby\Toolkit\Str;

return [
    // 'meta' =>
    // [
    //     'props' => [
    //         'headline' => function ($headline = 'Metadata') {
    //             return $headline;
    //         }
    //     ],
    //     'computed' => [],
    //     // 'computed' => [
    //     //     'title' => function () {
    //     //         return $this->model()->title();
    //     //     },
    //     //     'url' => function () {
    //     //         return $this->model()->url();
    //     //     },
    //     //     'siteTitleAfterPageTitle' => function () {
    //     //         return option('diesdasdigital.meta-knight.siteTitleAfterPageTitle', true);
    //     //     }
    //     // ]
    // ],
    'meta-share-preview' => [
        'props' => [
            'headline' => function (?string $headline = null): string {
                return $headline ?? t('fabianmichael.meta.sharing_preview.headline');
            },
        ],
        'computed' => [
            'metadata_og_image' => function (): ?array {
                $image = $this->model()->meta()->metadata('og_image');
                return $image ? $image->crop(1200, 630)->toArray() : null;
            },
            'page_is_homepage' => function(): bool {
                return $this->model()->isHomePage();
            },
            'page_title' => function (): ?string {
                return $this->model()->title()->value();
            },
            'page_metadata_description' => function(): ?string {
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
            'url' => function (): string {
                return $this->model()->url();
            },
        ],
    ],
];
