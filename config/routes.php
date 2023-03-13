<?php

use FabianMichael\Meta\Sitemap;
use FabianMichael\Meta\SiteMeta;
use Kirby\Cms\App;
use Kirby\Http\Response;
use Kirby\Toolkit\A;

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

            $sitemap = [];
            // $cache = $kirby->cache('fabianmichael.meta');
            $cache = $kirby->cache('pages');
            $cacheKey = 'sitemap.xml';
            // $version = $kirby->plugin('fabianmichael/meta')->version();

            if (!($sitemap = $cache->get($cacheKey))) {
                $created = time();

                $xml = Sitemap::factory()->generate();
                // $xml .= PHP_EOL . '<!-- created ' . date('c', $created) . ' -->';

                $sitemap = [
                    'html' => $xml,
                ];

                $cache->set($cacheKey, $sitemap);
            }

            return new Response(A::get($sitemap, 'html'), 'application/xml');
        },
    ];

    return $routes;
};
