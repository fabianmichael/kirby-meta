<?php

namespace FabianMichael\Meta;

use Kirby\Cms\App;

class Helper
{
    public static function themeColor(): ?string
    {
        return kirby()->apply('meta.theme.color', [
            'color' => option('fabianmichael.meta.theme.color'),
        ], 'color');
    }

    public static function isSmartyPantsEnabled(): bool
    {
        return option('smartypants', false) === true;
    }
}
