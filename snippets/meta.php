<?php

$data = [
    'meta' => $page->meta(),
];

snippet('meta/general', $data);

if ($kirby->option('fabianmichael.meta.robots') !== false) {
    snippet('meta/robots', $data);
}

if ($kirby->option('fabianmichael.meta.social') !== false) {
    snippet('meta/social', $data);
}

if ($kirby->option('fabianmichael.meta.schema') !== false) {
    snippet('meta/schema', $data);
}
