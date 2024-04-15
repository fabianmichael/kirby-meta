<?php

namespace FabianMichael\Meta;

class SiteMeta
{
    public static function changefreq(): string|null
    {
        $changefreq = site()
            ->content()
            ->get('sitemap_changefreq')
            ->toString();

        return empty($changefreq) === false
            ? $changefreq
            : null;
    }

    public static function robots(string $name): bool
    {
        return site()
            ->content()
            ->get("robots_{$name}")
            ->or(option("fabianmichael.meta.robots.{$name}"))
            ->toBool();
    }

    public static function titleSeparator()
    {
        return site()->meta_title_separator()->or('|')->toString();
    }
}
