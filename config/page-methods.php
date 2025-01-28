<?php

use FabianMichael\Meta\PageMeta;

return [
    'meta' => function (?string $languageCode = null) {
        return PageMeta::of($this, $languageCode);
    },

    'metaDefaults' => function(?string $lang = null): array {
        return [];
    },

    'metaOverrides' => function(?string $lang = null): array {
        return [
            // 'robots.index' => false
        ];
    },

    'isIndexible' => function (): bool {
        return $this->meta()->robots('index');
    },

    'isIndexibleStatusText' => function (): string {
        return r($this->isIndexible(), 'indexible', 'not indexible');
    },

    'isIndexibleStatusIcon' => function (): string {
        return r($this->isIndexible(), 'meta-eye', 'meta-eye-off');
    },

    'isIndexibleTheme' => function (): string {
        return r($this->isIndexible(), 'info-icon', 'warning-icon');
    },
];
