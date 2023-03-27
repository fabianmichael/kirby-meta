<?php

$kirby->response()->type('application/xml');

echo FabianMichael\Meta\Sitemap::factory()->generate();

if ($kirby->option('cache.page.active') && $kirby->option('cache.page.type') === 'static') {
    echo PHP_EOL;
    echo '<!-- static ' . date('c') . ' -->';
}
