<?php

namespace FabianMichael\Meta;

use DOMDocument;
use Kirby\Cms\Page;
use Kirby\Cms\App as Kirby;

class Sitemap
{
    public static function generate(Kirby $kirby): string
    {
        $languages = $kirby->languages();

        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->formatOutput = true;
        $root = $doc->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9','urlset');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xlink', 'http://www.w3.org/1999/xlink');
        $root = $doc->appendChild($root);

        foreach ($kirby->site()->index() as $item) {
            $meta = $item->meta();

            if (static::isPageIndexible($item) === false || $meta->robots('index') === false) {
                // Exclude page, if explicitly excluded in page settings
                // for global settings
                continue;
            }

            $url = $doc->createElement('url');
            $url->appendChild($doc->createElement('loc', $item->url()));

            $priority = $meta->priority();

            if ($priority !== null) { // could be 0.0, so has to be checked against NULL
                $url->appendChild($doc->createElement('priority', number_format($priority, 1, '.', '')));
            }

            if ($changefreq = $meta->changefreq()) {
                $url->appendChild($doc->createElement('changefreq', $changefreq));
            }

            foreach ($languages as $language) {
                if ($language->isDefault() === true) {
                    continue;
                }

                $linkEl = $doc->createElement('xhtml:link');
                $linkEl->setAttribute('rel', 'alternate');
                $linkEl->setAttribute('hreflang', $code = $language->code());
                $linkEl->setAttribute('href', $item->url($code));
                $url->appendChild($linkEl);
            }

            $url->appendChild($doc->createElement('lastmod', date('Y-m-d', $meta->lastmod())));

            $root->appendChild($url);
        }

        return $doc->saveXML();
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

        if (($page->isHomePage() === false && $page->status() === 'unlisted')
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

        if ($page->parent() !== null) {
            // Test indexability of parent pages as well
            return static::isPageIndexible($page->parent());
        }

        return true;
    }
}
