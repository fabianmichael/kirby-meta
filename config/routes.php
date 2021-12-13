<?php

use FabianMichael\Meta\Sitemap;
use FabianMichael\Meta\SiteMeta;
use Kirby\Cms\App as Kirby;
use Kirby\Filesystem\F;
use Kirby\Http\Response;


return function (Kirby $kirby) {
    $routes = [];

    $indexingAllowed = $kirby->option('fabianmichael.meta.sitemap') !== false && SiteMeta::robots('index') === true;

    if ($kirby->option('fabianmichael.meta.robots') !== false) {
        // Only register robots.txt route, if activated in plugin config

        $routes[] = [
            'pattern' => 'robots.txt',
            'method' => 'ALL',
            'action' => function () use ($kirby, $indexingAllowed) {
                $robots = [
                    'User-agent: *',
                    'Allow: /',
                ];

                if ($indexingAllowed === true) {
                    $robots[] = 'Sitemap: ' . url('sitemap.xml');
                }

                return $kirby
                    ->response()
                    ->type('text')
                    ->body(implode(PHP_EOL, $robots));
            },
        ];
    }

    if ($indexingAllowed === true) {
        // Only register sitemap.xml route, if activated in plugin config

        $routes[] = [
            'pattern' => 'sitemap.xml',
            'action' => function () use ($kirby) {
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
    }

    return $routes;
};
