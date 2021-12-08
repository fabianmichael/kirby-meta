<?php

use Kirby\Cms\Files;

return [
    'metaFilterOgImages' => function (): Files {
        return $this
            ->filterBy('mime', 'in', [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/avif',
                'image/gif'
            ])
            ->filterBy('width', '>=', 300)
            ->filterBy('height', '>=', 157);
    },
];
