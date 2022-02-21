<?php

use Kirby\Cms\App as Kirby;

return function (Kirby $kirby) {
    $fields = [
        'meta_global_general' => 'fields/meta/global-general-group',
    ];

    if ($kirby->option('fabianmichael.meta.schema') !== false) {
        $fields['meta_global_schema'] = 'fields/meta/global-schema-group';
    }

    if ($kirby->option('fabianmichael.meta.social') !== false) {
        $fields['meta_global_ogengraph'] = 'fields/meta/global-opengraph-group';
        $fields['meta_global_twitter']   = 'fields/meta/global-twitter-group';
    }

    if ($kirby->option('fabianmichael.meta.robots') !== false) {
        $fields['meta_global_robots'] = 'fields/meta/global-robots-group';
    }

    return [
        'icon' => 'search',
        'label' => t('fabianmichael.meta.tab.label'),
        'columns' => [
            'meta_main' => [
                'width' => '2/3',
                'fields' => $fields,
            ],
            'meta_sidebar' => [
                'sticky' => true,
                'width' => '1/3',
                'sections' => [
                    'meta_files' => 'sections/meta/files',
                ],
            ],
        ],
    ];
};
