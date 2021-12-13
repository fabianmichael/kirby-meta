<?php

use FabianMichael\Meta\PageMeta;

return [
    'meta' => function (?string $languageCode = null) {
        return PageMeta::of($this, $languageCode);
    },
];
