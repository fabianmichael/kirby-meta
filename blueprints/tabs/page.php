<?php

use Kirby\Cms\App as Kirby;

return function (Kirby $kirby) {
    $columns = [];
    $fields = [];
    $sections = [];

    // main column

    $fields['meta_general'] = 'fields/meta/general-group';

    if ($kirby->option('fabianmichael.meta.social') !== false) {
        $fields  ['meta_opengraph'] = 'fields/meta/opengraph-group';

        if ($kirby->option('fabianmichael.meta.twitter')) {
            $fields['meta_twitter'] = 'fields/meta/twitter-group';
        }

        $sections['meta_sharing_preview'] = 'sections/meta/share-preview';
        $sections['meta_files'] = 'sections/meta/files';
    }

    // robots

    if ($kirby->option('fabianmichael.meta.robots') !== false) {
        $fields['meta_robots'] = 'fields/meta/robots-group';
    }

    // stats (only Kirby 3.7+)

    if ($kirby->extension('sections', 'stats')) {
        $sections['meta_status'] = 'sections/meta/status';
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
