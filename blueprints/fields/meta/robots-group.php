<?php

use FabianMichael\Meta\Helper;
use Kirby\Cms\App as Kirby;

return function (Kirby $kirby): array {
    $getOptions = function (string $name) use ($kirby): array {
        $globalValue = $kirby
            ->site()
            ->content()
            ->get($name)
            ->or($kirby->option('fabianmichael.meta.' . str_replace('_', '.', $name)))
            ->toBool();

        $configDefaultLabel = tt('fabianmichael.meta.global_default_value.label', [
            'state' => ($globalValue === true ? t('fabianmichael.meta.state.on') : t('fabianmichael.meta.state.off')),
        ]);

        return [
            'options' => [
                [
                    'value' => '',
                    'text' => $configDefaultLabel,
                ],
                [
                    'value' => '1',
                    'text' => t('fabianmichael.meta.state.on'),
                    'icon' => 'check',
                ],
                [
                    'value' => '0',
                    'text' => t('fabianmichael.meta.state.off'),
                    'icon' => 'cancel',
                ],
            ],
            'type' => 'toggles',
            'reset' => false,
            'translate' => false,
            'width' => '1/2',
        ];
    };

    return [
        'type' => 'group',
        'fields' => [
            'robots_headline' => [
                'type' =>  'headline',
                'label' => t('fabianmichael.meta.robots.headline'),
                'help' =>  t('fabianmichael.meta.robots.help'),
                'numbered' => false,
            ],
            'robots_index' => [
                'label' => t('fabianmichael.meta.robots_index.label'),
                'type' => 'meta-robots-index-toggles',
                'reset' => false,
                'options' => [
                    [
                        'value' => '',
                        'text' => 'page status',
                    ],
                    [
                        'value' => '1',
                        'text' => t('fabianmichael.meta.state.on'),
                        'icon' => 'check',
                    ],
                    [
                        'value' => '0',
                        'text' => t('fabianmichael.meta.state.off'),
                        'icon' => 'cancel',
                    ],
                ],
                'help' => t('fabianmichael.meta.robots_index.help'),
                'translate' => false,
            ],
            'robots_follow' => array_merge([
                'label' => t('fabianmichael.meta.robots_follow.label'),
                'help' => t('fabianmichael.meta.robots_follow.help'),
            ], $getOptions('robots_follow')),
            'robots_archive' => array_merge([
                'label' => t('fabianmichael.meta.robots_archive.label'),
                'help' => t('fabianmichael.meta.robots_archive.help'),
            ], $getOptions('robots_archive')),
            'robots_imageindex' => array_merge([
                'label' => t('fabianmichael.meta.robots_imageindex.label'),
                'help' => t('fabianmichael.meta.robots_imageindex.help'),
            ], $getOptions('robots_imageindex')),
            'robots_snippet' => array_merge([
                'label' => t('fabianmichael.meta.robots_snippet.label'),
                'help' => t('fabianmichael.meta.robots_snippet.help'),
            ], $getOptions('robots_snippet')),
        ],
    ];
};
