<?php

use Kirby\Cms\App as Kirby;

return function (Kirby $kirby): array {
    $getOptions = function (string $name) use ($kirby): array {
        $optionValue = $kirby->option('fabianmichael.meta.' . str_replace('_', '.', $name));
        $configDefaultLabel = tt('fabianmichael.meta.config_default_value.label', [
            'state' => ($optionValue === true ? t('fabianmichael.meta.state.on') : t('fabianmichael.meta.state.off')),
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
            'reset' => false,
            'grow' => false,
            'type' => 'toggles',
            'translate' => false,
            'width' => '1/2',
        ];
    };

    return [
        'type' => 'group',
        'fields' => [
            'robots_headline' => [
                'type' =>  'headline',
                'label' => t('fabianmichael.meta.global_robots.headline'),
                'help' =>  t('fabianmichael.meta.global_robots.help'),
                'numbered' => false,
            ],
            'robots_index' => array_merge([
                'label' => t('fabianmichael.meta.global_robots_index.label'),
                'help' => t('fabianmichael.meta.global_robots_index.help'),
            ], $getOptions('robots_index')),
            'robots_follow' => array_merge([
                'label' => t('fabianmichael.meta.global_robots_follow.label'),
                'help' => t('fabianmichael.meta.global_robots_follow.help'),
            ], $getOptions('robots_follow')),
            'robots_archive' => array_merge([
                'label' => t('fabianmichael.meta.global_robots_archive.label'),
                'help' => t('fabianmichael.meta.global_robots_archive.help'),
            ], $getOptions('robots_archive')),
            'robots_imageindex' => array_merge([
                'label' => t('fabianmichael.meta.global_robots_imageindex.label'),
                'help' => t('fabianmichael.meta.global_robots_imageindex.help'),
            ], $getOptions('robots_imageindex')),
            'robots_snippet' => array_merge([
                'label' => t('fabianmichael.meta.global_robots_snippet.label'),
                'help' => t('fabianmichael.meta.global_robots_snippet.help'),
            ], $getOptions('robots_snippet')),
        ],
    ];
};
