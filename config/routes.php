<?php

use FabianMichael\Meta\SiteMeta;
use Kirby\Cms\App;
use Kirby\Cms\Page;
use Kirby\Http\Remote;

return function (App $kirby) {
    $routes = [];

    if ($kirby->option('fabianmichael.meta.robots') !== false) {
        $routes[] = [
            'pattern' => 'robots.txt',
            'method' => 'ALL',
            'action' => function () use ($kirby) {
                $robots = [];

                if ($token = $kirby->option('fabianmichael.meta.darkvisitors.token')) {
                    $cache = $kirby->cache('fabianmichael.meta');
                    $agentTypes = $kirby->option('fabianmichael.meta.darkvisitors.agentTypes');
                    $cacheKey = 'darkvisitors-' . hash('crc32', implode(' ', $agentTypes));

                    if (! $darkvisitors = $cache->get($cacheKey)) {
                        $response = Remote::request('https://api.darkvisitors.com/robots-txts', [
                            'method' => 'POST',
                            'headers' => [
                                "Authorization: Bearer {$token}",
                            ],
                            'data' => [
                                'agent_types' => $agentTypes,
                                'disallow' => '/',
                            ],
                        ]);

                        if ($response->code() === 200) {
                            $darkvisitors = $response->content();
                            $cache->set($cacheKey, $darkvisitors, 1440); // 24 hours
                        } else {
                            // API error, only safe for one hour
                            $darkvisitors = '';
                            $cache->set($cacheKey, $darkvisitors, 60); // 1 hour
                        }
                    }

                    $robots = array_merge($robots, explode("\n", $darkvisitors));
                }

                $robots[] = '';
                $robots[] = 'User-agent: *';
                $robots[] = 'Allow: /';

                if ($kirby->option('fabianmichael.meta.sitemap') === true && SiteMeta::robots('index') === true) {
                    $robots[] = '';
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
