<?php


return [
    'metaPanelOgImageWarning' => function (string $type) {
        $text = '';

        if ($type === 'no_og_image_fallback') {
            if (site()->og_image()->toFile() === null) {
                $text = tt('fabianmichael.meta.no_og_image_fallback', [
                    'link' => $this->panel()->url() . '?tab=meta',
                ]);
            }
        }

        if (empty($text) === false) {
            return '<span class="k-meta-warning-box"><svg class="k-icon" aria-hidden="true" data-type="alert" style="display: inline-block; --icon-size: 1em; vertical-align: -.12em;"><use xlink:href="#icon-alert"/></svg> ' . $text . '</span>';
        }
    },
    'indexedPages' => function () {
        return $this->index()->filterBy('isIndexible', '==', true);
    },
];
