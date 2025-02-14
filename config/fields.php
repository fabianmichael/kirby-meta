<?php

return [
    'meta-robots-index-toggles' => [
        'extends' => 'toggles',
        'props' => [
            'disabled' => function (bool $disabled = null): bool {
                [, $prop] = explode('_', $this->name);

                if ($this->model->meta()->hasOverride("robots.{$prop}")) {
                    return true;
                }

                return $disabled ?? false;
            }
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
            'help' => function (string $help = null) {
                if ($this->disabled) {
                    return t('fabianmichael.meta.has-override.help');
                }

                return $help;
            },
        ],
    ],
];
