<?php

namespace FabianMichael\Meta;

use Kirby\Cms\App;

class Helper
{
    public static function toggleFieldType(): string
    {
        static $type;

        if (! is_null($type)) {
            return $type;
        }

        if (version_compare(App::version(), '3.7.0-rc.1', '>=')) {
            return $type = 'toggles';
        }

        if (App::plugin('fabianmichael/kirby-multi-toggle-field')) {
            return $type = 'multi-toggle';
        }

        return $type = 'select';
    }
}
