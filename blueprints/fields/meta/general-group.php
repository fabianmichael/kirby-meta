<?php

use Kirby\Cms\App as Kirby;

return function (Kirby $kirby) {

    // basic metadata

    $fields = [
        'meta_general_headline' => [
            'type'     => 'headline',
            'label'    => t('fabianmichael.meta.general.headline'),
            'numbered' => false,
        ],
        'meta_description' => [
            'type'        => 'text',
            'label'       => t('fabianmichael.meta.description.label'),
            'placeholder' => '{{ page.meta.get("meta_description", true, true) }}',
            'help'        => t('fabianmichael.meta.description.help'),
        ],
        'meta_title' => [
            'type'        => 'text',
            'label'       => t('fabianmichael.meta.title.label'),
            'placeholder' => '{{ page.meta.panelTitlePlaceholder }}',
            'help'        => t('fabianmichael.meta.title.help'),
        ],
        'meta_title_preview' => [
            'type' => 'meta-title-preview',
            'label' => t('fabianmichael.meta.title_preview.label'),
        ],
    ];

    // robots

    if ($kirby->option('fabianmichael.meta.robots') !== false && $kirby->option('fabianmichael.meta.robots.canonical') !== false) {
        $fields['meta_canonical_url'] = [
            'type' => 'url',
            'label' => t('fabianmichael.meta.canonical_url.label'),
            'placeholder' => '{{ page.url }}',
            'help' => t('fabianmichael.meta.canonical_url.help'),
        ];
    }

    // sitemap

    if ($kirby->option('fabianmichael.meta.sitemap') !== false
        && $kirby->option('fabianmichael.meta.sitemap.detailSettings') !== false) {
        $fields['sitemap_priority'] = [
            'extends' => 'fields/meta/sitemap-priority',
            'width' => '1/2',
        ];
        $fields['sitemap_changefreq'] = [
            'extends' => 'fields/meta/sitemap-changefreq',
            'width' => '1/2',
        ];
    }


    return [
        'type' => 'group',
        'fields' => $fields,
    ];
};
