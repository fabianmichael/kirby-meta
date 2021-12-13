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
        'meta_title_separator' => [
            'type' => 'select',
            'label' => t('fabianmichael.meta.title_separator.label'),
            'default' => '',
            'placeholder' => '|',
            'options' => ["~" , "-" , "–" , "—" , ":" , "/" , "⋆" , "·" , "•" , "~" , "×" , "*" , "‣", "→", "←", "<" , ">" , "«" , "»" , "‹" , "›", "♠︎", "♣︎", "♥︎", "♦︎", "☙", "❦", "❧", "☭"],
            'width' => '1/3',
            'help' => t('fabianmichael.meta.title_separator.help'),
        ],
        'meta_title_preview' => [
            'type' => 'meta-title-preview',
            'label' => 'Preview',
            'width' => '2/3',
        ],
    ];

    // sitemap

    if ($kirby->option('fabianmichael.meta.sitemap') !== false) {
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
