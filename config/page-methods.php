<?php

use FabianMichael\Meta\PageMeta;
use FabianMichael\Meta\SiteMap;

return [
    'meta' => function (?string $languageCode = null) {
        return PageMeta::of($this, $languageCode);
    },

    'isIndexible' => function(){
        return Sitemap::isPageIndexible( $this );
    },
];
