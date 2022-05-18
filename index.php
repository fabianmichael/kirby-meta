<?php

use Kirby\Cms\App as Kirby;

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('fabianmichael/meta', [
    'options' => [
        'sitemap' => true,
        'sitemap.pages.exclude' => [],
        'sitemap.pages.includeUnlisted' => [],
        'sitemap.templates.exclude' => [],
        'sitemap.templates.includeUnlisted' => [],

        'schema' => true,
        'social' => true,

        'robots' => true,
        'robots.canonical' => true,
        'robots.index' => true,
        'robots.follow' => true,
        'robots.archive' => true,
        'robots.imageindex' => true,
        'robots.snippet' => true,
        'robots.translate' => true,

        'theme.color' => null,

        'panel.view.filter' => null,
    ],

    'api' => require __DIR__ . '/config/api.php',

    'areas' => [
        'meta' => [
            'label' => 'Metadata',
            'icon'  => 'search',
            'menu'  => true,
            'views' => require __DIR__ . '/config/views.php',
        ],
    ],

    'blueprints' => [
        'fields/meta/general-group'             => require __DIR__ . '/blueprints/fields/meta/general-group.php',
        'fields/meta/global-general-group'      => require __DIR__ . '/blueprints/fields/meta/global-general-group.php',
        'fields/meta/global-opengraph-group'    => __DIR__ . '/blueprints/fields/meta/global-opengraph-group.yml',
        'fields/meta/global-robots-group'       => require __DIR__ . '/blueprints/fields/meta/global-robots-group.php',
        'fields/meta/global-schema-group'       => __DIR__ . '/blueprints/fields/meta/global-schema-group.yml',
        'fields/meta/global-sitemap-changefreq' => require __DIR__ . '/blueprints/fields/meta/global-sitemap-changefreq.php',
        'fields/meta/global-twitter-group'      => __DIR__ . '/blueprints/fields/meta/global-twitter-group.yml',
        'fields/meta/og-image'                  => __DIR__ . '/blueprints/fields/meta/og-image.yml',
        'fields/meta/opengraph-group'           => __DIR__ . '/blueprints/fields/meta/opengraph-group.yml',
        'fields/meta/robots-group'              => require __DIR__ . '/blueprints/fields/meta/robots-group.php',
        'fields/meta/sitemap-changefreq'        => require __DIR__ . '/blueprints/fields/meta/sitemap-changefreq.php',
        'fields/meta/sitemap-priority'          => __DIR__ . '/blueprints/fields/meta/sitemap-priority.yml',
        'fields/meta/twitter-group'             => __DIR__ . '/blueprints/fields/meta/twitter-group.yml',
        'files/meta-logo'                       => __DIR__ . '/blueprints/files/meta-logo.yml',
        'files/meta-og-image'                   => __DIR__ . '/blueprints/files/meta-og-image.yml',
        'sections/meta/files'                   => __DIR__ . '/blueprints/sections/files.yml',
        'sections/meta/share-preview'           => __DIR__ . '/blueprints/sections/share-preview.yml',
        'tabs/meta/page'                        => require __DIR__ . '/blueprints/tabs/page.php',
        'tabs/meta/site'                        => require __DIR__ . '/blueprints/tabs/site.php',
    ],
    'fields' => require __DIR__ . '/config/fields.php',
    'filesMethods' => require __DIR__ . '/config/files-methods.php',
    'hooks' => require __DIR__ . '/config/hooks.php',
    'routes' => require __DIR__ . '/config/routes.php',
    'pageMethods' => require __DIR__ . '/config/page-methods.php',
    'sections' => require __DIR__ . '/config/sections.php',
    'siteMethods' => require __DIR__ . '/config/site-methods.php',
    'snippets' => [
        'meta' => __DIR__ . '/snippets/meta.php',
        'meta/general' => __DIR__ . '/snippets/general.php',
        'meta/robots'  => __DIR__ . '/snippets/robots.php',
        'meta/social'  => __DIR__ . '/snippets/social.php',
        'meta/schema'  => __DIR__ . '/snippets/schema.php',
    ],
    'translations' => [
        'de' => require __DIR__ . '/translations/de.php',
        'en' => require __DIR__ . '/translations/en.php',
    ],
]);
