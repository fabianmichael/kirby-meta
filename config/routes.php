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
            $cache = $kirby->cache('fabianmichael.meta');
            $cacheKey = 'sitemap.xml';
            $version = $kirby->plugin('fabianmichael/meta')->version();

            if ($kirby->option('debug') === true || ! ($sitemap = $cache->get($cacheKey)) || A::get($sitemap, 'version') !== $version) {
                $created = time();

                $xml = Sitemap::factory()->generate();
                $xml .= PHP_EOL . '<!-- created ' . date('c', $created) . ' -->';

                $sitemap = [
                    'version' => $version,
                    'xml' => $xml,
                    'created' => $created,
                ];

                $cache->set($cacheKey, $sitemap);
            }

            return new Response(A::get($sitemap, 'xml'), 'application/xml');
        },
    ];

    return $routes;
};
