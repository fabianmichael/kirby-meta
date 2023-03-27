<?php

use Kirby\Toolkit\Html;

// this template needs to exists, because otherwise content
// representations do not work properly (tested with Kirby v3.9.2)

echo Html::link($page->url() . '.xml', $page->title());
