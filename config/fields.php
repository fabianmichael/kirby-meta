<?php

use FabianMichael\Meta\SiteMeta;
use Kirby\Cms\Site;

return [
    'meta-title-preview' => [
        'computed' => [
            'siteTitle' => function () {
                return $this->model->site()->title()->toString();
            },
            'separator' => function () {
                return SiteMeta::titleSeparator();
            },
            'modelTitle' => function () {
                if ($this->model instanceof Site) {
                    return null;
                }

                return $this->model->title()->toString();
            },
            'isHomePage' => function () {
                return $this->model->isHomePage();
            },
        ],
        'save' => false,
    ],
];
