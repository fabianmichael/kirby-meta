<?php

use FabianMichael\Meta\Sitemap;
use FabianMichael\Meta\SiteMeta;
use Kirby\Cms\App as Kirby;
use Kirby\Filesystem\F;
use Kirby\Http\Response;


return function (Kirby $kirby) {
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

                if ($kirby->option('fabianmichael.meta.sitemap') !== false && SiteMeta::robots('index') === true) {
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

            if ($kirby->option('fabianmichael.meta.sitemap') === false && SiteMeta::robots('index') === false) {
                $this->next();
            }

            $sitemap  = [];
            $cache    = $kirby->cache('pages');
            $cacheKey = 'sitemap.xml';

            if (option('debug') === true || !($sitemap = $cache->get($cacheKey))) {
                $sitemap = Sitemap::generate($kirby);
                $cache->set($cacheKey, $sitemap);
            }

            return new Response($sitemap, 'application/xml');
        },
    ];

    return $routes;
};
