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
    'meta-robots-index-toggles' => [
        'extends' => 'toggles',
        'props' => [
            'help' => function (string $help = null) {
                return "bla";
            }
        ],
        'computed' => [
            'options' => function (): array {
                $model = $this->model;
                return array_map(function ($option) use ($model) {
                    if ($option['value'] !== '') {
                        return $option;
                    }

                    $option['text'] = $model->status();
                    $option['icon'] = "status-{$model->status()}";

                    return $option;
                }, $this->getOptions());
            }
        ],
    ],
];
