<?php

use Kirby\Cms\Page;
use Kirby\Cms\Site;
use Kirby\Toolkit\I18n;

return [
    'meta-text' => [
        'extends' => 'text',
        'props' => [
            'disabled' => function (bool $disabled = false): bool {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model->meta()->hasOverride($this->name)) {
                    return true;
                }

                return $disabled ?? false;
            },
            'help' => function (): ?string {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model->meta()->hasOverride($this->name)) {
                    return
                        '<span><svg class="k-icon" aria-hidden="true" data-type="lock" style="display: inline-block; --icon-size: 1em; vertical-align: -.1em;"><use xlink:href="#icon-lock"/></svg> ' .
                        t('fabianmichael.meta.override.help') . '</span>';
                }

                return I18n::translate($this->help, $this->help);
            },
        ],
        'computed' => [
            'value' => function (): ?string {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model->meta()->hasOverride($this->name)) {
                    return (string)$model->meta()->override($this->name);
                }

                return (string)$this->value;
            },
        ],
        'save' => function (mixed $value) {
            // get old value from model if disabled
            return $this->isDisabled()
                ? $this->model()->content()->get($this->name)->value()
                : $value;
        },
    ],
    'meta-range' => [
        'extends' => 'range',
        'props' => [
            'disabled' => function (bool $disabled = false): bool {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model instanceof Page && $model->meta()->hasOverride($this->name)) {
                    return true;
                }

                return $disabled ?? false;
            },
            'help' => function (): ?string {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model instanceof Page && $model->meta()->hasOverride($this->name)) {
                    return
                        '<span><svg class="k-icon" aria-hidden="true" data-type="lock" style="display: inline-block; --icon-size: 1em; vertical-align: -.1em;"><use xlink:href="#icon-lock"/></svg> ' .
                        t('fabianmichael.meta.override.help') . '</span>';
                }

                return I18n::translate($this->help, $this->help);
            },
            'value' => function ($value = null) {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model instanceof Page && $model->meta()->hasOverride($this->name)) {
                    $value = $model->meta()->override($this->name);
                }

                return $this->toNumber($value) ?? $this->emptyValue();
            },
        ],
        'save' => function (mixed $value) {
            // get old value from model if disabled
            return $this->isDisabled()
                ? $this->model()->content()->get($this->name)->value()
                : $value;
        },
    ],
    'meta-select' => [
        'extends' => 'select',
        'props' => [
            'disabled' => function (bool $disabled = false): bool {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model instanceof Page && $model->meta()->hasOverride($this->name)) {
                    return true;
                }

                return $disabled ?? false;
            },
            'help' => function (): ?string {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model instanceof Page && $model->meta()->hasOverride($this->name)) {
                    return
                        '<span><svg class="k-icon" aria-hidden="true" data-type="lock" style="display: inline-block; --icon-size: 1em; vertical-align: -.1em;"><use xlink:href="#icon-lock"/></svg> ' .
                        t('fabianmichael.meta.override.help') . '</span>';
                }

                return I18n::translate($this->help, $this->help);
            },
            'value' => function ($value = null) {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model instanceof Page && $model->meta()->hasOverride($this->name)) {
                    return (string)$model->meta()->override($this->name);
                }

                return $value;
            },
        ],
        'save' => function (mixed $value) {
            // get old value from model if disabled
            return $this->isDisabled()
                ? $this->model()->content()->get($this->name)->value()
                : $value;
        },
    ],
    'meta-robots-index-toggles' => [
        'extends' => 'toggles',
        'props' => [
            'disabled' => function (): bool {
                /** @var Site|Page $model */
                $model = $this->model;

                return $model->meta()->hasOverride($this->name);
            },
            'help' => function (): ?string {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model instanceof Page && $model->meta()->hasOverride($this->name)) {
                    return
                        '<span><svg class="k-icon" aria-hidden="true" data-type="lock" style="display: inline-block; --icon-size: 1em; vertical-align: -.1em;"><use xlink:href="#icon-lock"/></svg> ' .
                        t('fabianmichael.meta.override.help') . '</span>';
                }

                return I18n::translate($this->help, $this->help);
            },
        ],
        'computed' => [
            'options' => function (): array {
                $model = $this->model;

                return array_map(function ($option) use ($model) {
                    if ($option['value'] !== '') {
                        return $option;
                    }

                    $option['text'] = tt('fabianmichael.meta.robots_index.auto', [
                        'state' => $model->isIndexible()
                            ? t('fabianmichael.meta.state.on')
                            : t('fabianmichael.meta.state.off')
                    ]);
                    $option['icon'] = "status-{$model->status()}";

                    return $option;
                }, $this->getOptions());
            },
            'value' => function (): ?string {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model->meta()->hasOverride($this->name)) {
                    return (string)$model->meta()->override($this->name);
                }

                return (string)$this->value;
            },
        ],
        'save' => function (mixed $value) {
            // get old value from model if disabled
            return $this->isDisabled()
                ? $this->model()->content()->get($this->name)->value()
                : $value;
        },
    ],
    'meta-url' => [
        'extends' => 'url',
        'props' => [
            'disabled' => function (bool $disabled = false): bool {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model->meta()->hasOverride($this->name)) {
                    return true;
                }

                return $disabled ?? false;
            },
            'help' => function (): ?string {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model->meta()->hasOverride($this->name)) {
                    return
                        '<span><svg class="k-icon" aria-hidden="true" data-type="lock" style="display: inline-block; --icon-size: 1em; vertical-align: center;"><use xlink:href="#icon-lock"/></svg> ' .
                        t('fabianmichael.meta.override.help') . '</span>';
                }

                return I18n::translate($this->help, $this->help);
            },
            'value' => function (): ?string {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model->meta()->hasOverride($this->name)) {
                    return (string)$model->meta()->override($this->name);
                }

                return (string)$this->value;
            },
        ],
        'save' => function (mixed $value) {
            // get old value from model if disabled
            return $this->isDisabled()
                ? $this->model()->content()->get($this->name)->value()
                : $value;
        },
    ],
    'meta-files' => [
        'extends' => 'files',
        'props' => [
            'disabled' => function (bool $disabled = false): bool {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model instanceof Page && $model->meta()->hasOverride($this->name)) {
                    return true;
                }

                return $disabled ?? false;
            },
            'help' => function (): ?string {
                /** @var Site|Page $model */
                $model = $this->model;

                if ($model->meta()->hasOverride($this->name)) {
                    return
                        '<span><svg class="k-icon" aria-hidden="true" data-type="lock" style="display: inline-block; --icon-size: 1em; vertical-align: center;"><use xlink:href="#icon-lock"/></svg> ' .
                        t('fabianmichael.meta.override.help') . '</span>';
                }

                return I18n::translate($this->help, $this->help);
            },
        ],
    ]
];
