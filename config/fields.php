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
        // 'props' => [
        //     'disabled' => function (bool $disabled = null): bool {
        //         if ($disabled === true && $this->model->metadata
        //     }
        // ],
        'computed' => [
            'options' => function (): array {
                $model = $this->model;

                return array_map(function ($option) use ($model) {
                    if ($option['value'] !== '') {
                        return $option;
                    }

                    $option['text'] = tt('fabianmichael.meta.robots_index.auto', [
                        'state' => $model->isListed()
                            ? t('fabianmichael.meta.state.on')
                            : t('fabianmichael.meta.state.off')
                    ]);
                    $option['icon'] = "status-{$model->status()}";

                    return $option;
                }, $this->getOptions());
            },
            // 'help' => function (string $help = null) {
            //     return "bla {$this->disabled}";
            // },
        ],
    ],
];
