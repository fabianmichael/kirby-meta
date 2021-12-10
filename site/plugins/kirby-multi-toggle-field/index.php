<?php

use Kirby\Cms\App as Kirby;

Kirby::plugin('fabianmichael/kirby-multi-toggle-field', [
    'fields' => [
        'multi-toggle' => [
            'mixins' => ['options'],
            'props' => [
                /**
                 * Unset inherited props
                 */
                'after'       => null,
                'before'      => null,
                'icon'        => null,
                'placeholder' => null,
                'columns'     => null,

                'textLabels' => function (bool $textLabels = true) {
                    return $textLabels;
                },
                'reset' => function (bool $reset = true) {
                    return $reset;
                },
                'equalize' => function (bool $equalize = true) {
                    return $equalize;
                }
            ],
            'computed' => [
                'default' => function () {
                    return $this->sanitizeOption($this->default);
                },
                'value' => function () {
                    return $this->sanitizeOption($this->value) ?? '';
                },
            ],
        ],
    ],
    'translations' => [
        'en' => require __DIR__ . '/translations/en.php',
        'de' => require __DIR__ . '/translations/de.php',
    ],
]);
