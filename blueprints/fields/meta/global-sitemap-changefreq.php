<?php

use Kirby\Cms\App as Kirby;

return function(Kirby $kirby) {
    return [
        'type' => 'select',
        'label' => t('fabianmichael.meta.sitemap.changefreq.label'),
        'options' => [
            [
                'value' => 'always',
                'text' => t('fabianmichael.meta.sitemap.changefreq.always'),
            ],
            [
                'value' => 'hourly',
                'text' => t('fabianmichael.meta.sitemap.changefreq.hourly'),
            ],
            [
                'value' => 'daily',
                'text' => t('fabianmichael.meta.sitemap.changefreq.daily'),
            ],
            [
                'value' => 'weekly',
                'text' => t('fabianmichael.meta.sitemap.changefreq.weekly'),
            ],
            [
                'value' => 'monthly',
                'text' => t('fabianmichael.meta.sitemap.changefreq.monthly'),
            ],
            [
                'value' => 'yearly',
                'text' => t('fabianmichael.meta.sitemap.changefreq.yearly'),
            ],
            [
                'value' => 'never',
                'text' => t('fabianmichael.meta.sitemap.changefreq.never'),
            ],
        ],
        'help' => t('fabianmichael.meta.sitemap.changefreq.help'),
    ];
};
