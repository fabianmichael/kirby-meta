<?php


return [
    'metaPanelWarning' => function (string $type) {
        $text = '';

        if ($type === 'no_og_image_fallback') {
            if (site()->og_image()->toFile() === null) {
                $text = tt('fabianmichael.meta.no_og_image_fallback', [
                    'link' => $this->panelUrl() . '?tab=meta',
                ]);
            }
        }

        if (empty($text) === false) {
            return '<span data-theme="notice" class="k-meta-warning-box">' . $text . '</span>';
        }
    },
];
