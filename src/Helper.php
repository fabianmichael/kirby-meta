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
}
