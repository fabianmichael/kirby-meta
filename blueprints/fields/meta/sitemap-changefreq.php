<?php

use FabianMichael\Meta\SiteMeta;
use Kirby\Cms\App as Kirby;

return function (Kirby $kirby) {

    $defaultState = SiteMeta::changefreq();
    $defaultState = $defaultState !== null
        ? t("fabianmichael.meta.sitemap.changefreq.{$defaultState}")
        : t('fabianmichael.meta.state.unset');

    $placeholder = tt('fabianmichael.meta.global_default_value.label', [
        'state' => $defaultState,
    ]);

    return [
        'type' => 'select',
        'label' => t('fabianmichael.meta.sitemap.changefreq.label'),
        'placeholder' => $placeholder,
        'translate' => false,
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
