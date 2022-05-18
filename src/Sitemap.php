<?php

namespace FabianMichael\Meta;

use DOMDocument;
use DOMElement;
use Kirby\Cms\App as Kirby;
use Kirby\Cms\Page;

class Sitemap
{
    public static function generate(Kirby $kirby): string
    {
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->formatOutput = true;

        $root = $doc->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'urlset');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xhtml', 'http://www.w3.org/1999/xlink');

        // Allow hook to change $doc and $root, e.g. adding namespaces or other attributes.
        $kirby->trigger('meta.sitemap:before', compact('kirby', 'doc', 'root'));

        foreach ($kirby->site()->index() as $page) {
            static::urlsForPage($kirby, $page, $doc, $root);
        }

        $root = $doc->appendChild($root);

        // Allow hook to alter the DOM
        $kirby->trigger('meta.sitemap:after', compact('kirby', 'doc', 'root'));

        return $doc->saveXML();
    }

    protected static function urlsForPage(Kirby $kirby, Page $page, DOMDocument $doc, DOMElement $root, ?string $languageCode = null)
    {
        $meta = $page->meta($languageCode);

        if (static::isPageIndexible($page) === false || $meta->robots('index') === false) {
            // Exclude page, if explicitly excluded in page settings
            // for global settings
            return;
        }

        $url = $doc->createElement('url');
        $url->appendChild($doc->createElement('loc', $page->url($languageCode)));

        $priority = $meta->priority();

        if ($priority !== null) { // could be 0.0, so has to be checked against NULL
            $url->appendChild($doc->createElement('priority', number_format($priority, 1, '.', '')));
        }

        if ($changefreq = $meta->changefreq()) {
            $url->appendChild($doc->createElement('changefreq', $changefreq));
        }

        foreach ($kirby->languages() as $language) {
            $linkEl = $doc->createElement('xhtml:link');
            $linkEl->setAttribute('rel', 'alternate');
            $linkEl->setAttribute('hreflang', $code = $language->code());
            $linkEl->setAttribute('href', $page->url($code));
            $url->appendChild($linkEl);
        }

        // Add lastmod date either from metadata or from modified date of page
        $url->appendChild($doc->createElement('lastmod', date('Y-m-d', $meta->lastmod())));

        // Allow hook to alter the DOM
        $kirby->trigger('meta.sitemap.url', compact('kirby', 'page', 'meta', 'doc', 'url', 'languageCode'));

        $root->appendChild($url);
    }

    public static function isPageIndexible(Page $page): bool
    {
        // pages have to pass a set of for being indexible. If any test
        // fails, the page is excluded from index

        $templatesExclude = option('fabianmichael.meta.sitemap.templates.exclude', []);
        $templatesExcludeRegex = '!^(?:' . implode('|', $templatesExclude) . ')$!i';

        $templatesIncludeUnlisted = option('fabianmichael.meta.sitemap.templates.includeUnlisted', []);
        $templatesIncludeUnlistedRegex = '!^(?:' . implode('|', $templatesIncludeUnlisted) . ')$!i';

        $pagesExclude = option('fabianmichael.meta.sitemap.pages.exclude', []);
        $pagesExcludeRegex = '!^(?:' . implode('|', $pagesExclude) . ')$!i';

        $pagesIncludeUnlisted = option('fabianmichael.meta.sitemap.pages.includeUnlisted', []);
        $pagesIncludeUnlistedRegex = '!^(?:' . implode('|', $pagesIncludeUnlisted) . ')$!i';

        if ($page->isErrorPage()) {
            // error page is always excluded from sitemap
            return false;
        }


        if (! $page->isHomePage() && $page->status() === 'unlisted') {
            if (preg_match($templatesIncludeUnlistedRegex, $page->intendedTemplate()->name()) !== 1
                && preg_match($pagesIncludeUnlistedRegex, $page->id()) !== 1) {
                // unlisted pages are only indexible, if exceptions are
                // defined for them based on page id or template
                return false;
            }
        }

        if (preg_match($templatesExcludeRegex, $page->intendedTemplate()->name()) === 1) {
            // page is in exclude-list of templates
            return false;
        }

        if (preg_match($pagesExcludeRegex, $page->id()) === 1) {
            // page is in exclude-list of page IDs
            return false;
        }

        if (! is_null($page->parent())) {
            // test indexability of parent pages as well
            return static::isPageIndexible($page->parent());
        }

        return true;
    }
}
