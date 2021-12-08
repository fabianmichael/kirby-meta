<?php

namespace FabianMichael\Meta;

use Kirby\Cms\Page;
use Kirby\Toolkit\Xml;


class Sitemap
{
    public static function generate(): string
    {
        $sitemap[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach (site()->index() as $item) {
            if (static::isPageIndexible($item) === false) {
                // Test general indexability
                continue;
            }

            $meta = $item->meta();

            if ($meta->robots('index') === false) {
                // Exclude page, if explicitly excluded in page settings
                // for global settings
                return false;
            }

            $sitemap[] = '<url>';
            $sitemap[] = '  <loc>' . Xml::encode($item->url()) . '</loc>';

            $priority = $meta->priority();

            if ($priority !== null) {
                $sitemap[] = '  <priority>' . number_format($priority, 1, '.', '') . '</priority>';
            }

            if ($changefreq = $meta->changefreq()) {
                $sitemap[] = '  <changefreq>' . $changefreq . '</changefreq>';
            }

            $sitemap[] = '</url>';
        }

        $sitemap[] = '</urlset>';


        return implode(PHP_EOL, $sitemap);
    }

    public static function isPageIndexible(Page $page): bool
    {
        $templatesExclude = option('fabianmichael.meta.sitemap.templates.exclude', []);
        $templatesExcludeRegex = '!^(?:' . implode('|', $templatesExclude) . ')$!i';

        $templatesIncludeUnlisted = option('fabianmichael.meta.sitemap.includeUnlisted', []);
        $templatesIncludeUnlistedRegex = '!^(?:' . implode('|', $templatesIncludeUnlisted) . ')$!i';

        $pagesExclude = option('fabianmichael.meta.sitemap.pages.exclude', []);
        $pagesExcludeRegex = '!^(?:' . implode('|', $pagesExclude) . ')$!i';

        $pagesIncludeUnlisted = option('fabianmichael.meta.sitemap.pages.includeUnlisted', []);
        $pagesIncludeUnlistedRegex = '!^(?:' . implode('|', $pagesIncludeUnlisted) . ')$!i';

        if ($page->isErrorPage() === true) {
            // Error page is always excluded
            return false;
        }

        if ($page->status() === 'unlisted'
            && preg_match($templatesIncludeUnlistedRegex, $page->intendedTemplate()->name()) !== 1
            && preg_match($pagesIncludeUnlistedRegex, $page->id()) !== 1
        ) {
            // Unlisted pages are only indexible, if exceptions are
            // defined for them based on page id or template.
            return false;
        }

        if (preg_match($templatesExcludeRegex, $page->intendedTemplate()->name()) === 1) {
            // Page is in exclude-list of templates
            return false;
        }

        if (preg_match($pagesExcludeRegex, $page->id()) === 1) {
            // Page is in exclude-list of page IDs
            return false;
        }

        return true;
    }
}
