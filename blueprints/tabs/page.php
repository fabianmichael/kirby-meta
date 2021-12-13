<?php

use Kirby\Cms\App as Kirby;

return function (Kirby $kirby) {

    $columns  = [];
    $fields   = [];
    $sections = [];

    // main column

    $fields['meta_general'] = 'fields/meta/general-group';

    if ($kirby->option('fabianmichael.meta.social') !== false) {
        $fields  ['meta_opengraph']       = 'fields/meta/opengraph-group';
        $fields  ['meta_twitter']         = 'fields/meta/twitter-group';
        $sections['meta_files']           = 'sections/meta/files';
        $sections['meta_sharing_preview'] = 'sections/meta/share-preview';
    }

    // robots

    if ($kirby->option('fabianmichael.meta.robots') !== false) {
        $fields['meta_robots'] = 'fields/meta/robots-group';
    }

    // compose columns

    $columns['meta_main'] = [
        'width' => '2/3',
        'fields' => $fields,
    ];

    if (sizeof($sections) > 0) {
        $columns['meta_sidebar'] = [
            'sticky' => 'true',
            'width' => '1/3',
            'sections' => $sections,
        ];
    }

    return [
        'icon' => 'search',
        'label' => t('fabianmichael.meta.tab.label'),
        'columns' => $columns,
    ];

};
