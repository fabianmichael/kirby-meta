<?php

use FabianMichael\Meta\PageMeta;

return [
    'meta' => function (?string $languageCode = null) {
        return PageMeta::of($this, $languageCode);
    },

    'metaDefaults' => function(?string $lang = null): array {
        return [];
    },

    'isIndexible' => function (): bool {
        return $this->meta()->robots('index');
    },
];
