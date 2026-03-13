<?php

use Kirby\Cms\App as Kirby;

return function (Kirby $kirby) {

    // basic metadata

    $fields = [
        'meta_general_headline' => [
            'type' => 'headline',
            'label' => t('fabianmichael.meta.global_general.headline'),
            'numbered' => false,
        ],
        'meta_description' => [
            'type' => 'text',
            'label' => t('fabianmichael.meta.description.label'),
            'help' => t('fabianmichael.meta.global_description.help'),
        ],
    ];

    // sitemap

    if ($kirby->option('fabianmichael.meta.sitemap') !== false
        && $kirby->option('fabianmichael.meta.sitemap.detailSettings') !== false) {
        $fields['sitemap_priority'] = [
            'extends' => 'fields/meta/sitemap-priority',
            'help' => t('fabianmichael.meta.sitemap.global_priority.help'),
            'width' => '1/2',
        ];
        $fields['sitemap_changefreq'] = [
            'extends' => 'fields/meta/global-sitemap-changefreq',
            'width' => '1/2',
        ];
    }

    return [
        'type' => 'group',
        'fields' => $fields,
    ];
};
