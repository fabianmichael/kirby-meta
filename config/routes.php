<?php

use FabianMichael\Meta\SiteMeta;
use Kirby\Cms\App;
use Kirby\Cms\Page;

return function (App $kirby) {
    $routes = [];

    if ($kirby->option('fabianmichael.meta.robots') !== false) {
        $routes[] = [
            'pattern' => 'robots.txt',
            'method' => 'ALL',
            'action' => function () use ($kirby) {
                $robots = [
                    'User-agent: *',
                    'Allow: /',
                ];

                if ($kirby->option('fabianmichael.meta.sitemap') === true && SiteMeta::robots('index') === true) {
                    $robots[] = 'Sitemap: ' . url('sitemap.xml');
                }

                return $kirby
                    ->response()
                    ->type('text')
                    ->body(implode(PHP_EOL, $robots));
            },
        ];
    }

    $routes[] = [
        'pattern' => 'sitemap.xml',
        'action' => function () use ($kirby) {
            if ($kirby->option('fabianmichael.meta.sitemap') === false || SiteMeta::robots('index') === false) {
                $this->next();
            }

            return Page::factory([
                'slug' => 'sitemap',
                'template' => 'sitemap',
                'model' => 'sitemap',
                'content' => [
                    'title' => 'XML Sitemap',
                ],
            ])->render(contentType: 'xml');
        },
    ];

    return $routes;
};
