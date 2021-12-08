<?php

use FabianMichael\Meta\PageMeta;

return [
    'meta' => function () {
        return PageMeta::of($this);
    },
];
