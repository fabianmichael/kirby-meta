<?php

use FabianMichael\Meta\Sitemap;
use Kirby\Cms\Url;

return [
    [
        'pattern' => 'meta',
        'action'  => function () {
            $pages = [];

            $index = site()->index();

            if (is_callable($filter = option('fabianmichael.meta.panel.view.filter', null))) {
                $index = $index->filter($filter);
            }

            foreach ($index as $page) {
                $meta = $page->meta();

                if ($og_image = $meta->og_image()) {
                    if ($og_image->exists() === true) {
                        // Only resize, if given image does actually exists
                        // and is accessible
                        $og_image_url = $og_image->crop(192, 101)->url();
                    } else {
                        // Probably a virtual file
                        $og_image_url = $og_image->url();
                    }
                } else {
                    $og_image_url = null;
                }

                $pages[] = [
                    'title' => $page->title()->value(),
                    'meta_title' => $meta->get('meta_title')->value(),
                    'icon'  => $page->blueprint()->icon(),
                    'is_indexible' => $page->isIndexible(),
                    'status'  => $page->status(),
                    'id' => $page->id(),
                    'url' => $page->url(),
                    'shortUrl' => Url::short($page->url()),
                    'template' => $page->template()->name(),
                    'panelUrl' => $page->panel()->url(),
                    'meta_description' => $meta->meta_description()->value(),
                    'robots' => $meta->robots(),
                    'og_title' => $meta->og_title()->value(),
                    'og_description' => $meta->get('og_description', true, false)->value(),
                    'og_image_url' => $og_image_url,
                    'og_image_alt' => $og_image?->alt()->value(),
                ];
            }

            return [
                'component' => 'k-meta-view',
                'props' => [
                    'pages' => $pages,
                ],
            ];
        },
    ],
];
