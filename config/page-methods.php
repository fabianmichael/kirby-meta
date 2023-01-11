<?php

use FabianMichael\Meta\PageMeta;
use FabianMichael\Meta\SiteMap;

return [
    'meta' => function (?string $languageCode = null) {
        return PageMeta::of($this, $languageCode);
    },

    'isIndexedByMeta' => function(){
        return Sitemap::isPageIndexible( $this );
    },
];
