<?php

use Kirby\Cms\Html;

foreach ($meta->social() as $tag) {
    echo Html::tag('meta', '', $tag) . PHP_EOL;
}
