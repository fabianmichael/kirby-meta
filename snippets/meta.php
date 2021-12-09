<?php

$meta = $page->meta();
$data = [
    'meta' => $meta,
];

snippet('meta/general', $data);

if ($meta->isIndexible() === true || $meta->robots('index') === false) {
    return;
}

if ($kirby->option('fabianmichael.meta.robots') !== false) {
    snippet('meta/robots', $data);
}

if ($kirby->option('fabianmichael.meta.social') !== false) {
    snippet('meta/social', $data);
}

if ($kirby->option('fabianmichael.meta.schema') !== false) {
    snippet('meta/schema', $data);
}
