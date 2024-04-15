<?php

namespace FabianMichael\Meta;

use DOMDocument;
use DOMElement;
use Kirby\Cms\App;
use Kirby\Cms\Languages;
use Kirby\Cms\Page;

class Sitemap
{
    protected App $kirby;
    protected bool $isMultilang;
    protected Languages $languages;

    public function __construct() {
        $this->kirby = kirby();
        $this->isMultilang = $this->kirby->multilang();
        $this->languages   = $this->kirby->languages();
    }

    public static function factory(...$args): static
    {
        return new static(...$args);
    }

    public function generate(): string
    {
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->formatOutput = true;

        $root = $doc->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'urlset');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xhtml', 'http://www.w3.org/1999/xhtml');

        // Allow hook to change $doc and $root, e.g. adding namespaces or other attributes.
        $this->kirby->trigger('meta.sitemap:before', [
            'kirby' => $this->kirby,
            'doc' => $doc,
            'root' => $root
        ]);

        foreach ($this->kirby->site()->index() as $page) {
            $this->urlsForPage($page, $doc, $root);
        }

        $root = $doc->appendChild($root);

        // Allow hook to alter the DOM
        $this->kirby->trigger('meta.sitemap:after', [
            'kirby' => $this->kirby,
            'doc' => $doc,
            'root' => $root
        ]);

        return $doc->saveXML();
    }

    protected function urlsForPage(
        Page $page,
        DOMDocument $doc,
        DOMElement $root
    ): void {
        $meta = $page->meta();

        if ($page->isIndexible() === false) {
            return;
        }

        $url = $doc->createElement('url');
        $url->appendChild($doc->createElement('loc', $page->url()));

        if ($this->kirby->option('fabianmichael.meta.sitemap.detailSettings') !== false) {
            $priority = $meta->priority();

            if ($priority !== null) { // could be 0.0, so has to be checked against NULL
                $url->appendChild($doc->createElement('priority', number_format($priority, 1, '.', '')));
            }

            if ($changefreq = $meta->changefreq()) {
                $url->appendChild($doc->createElement('changefreq', $changefreq));
            }
        }

        if ($this->isMultilang && $this->languages->count() > 1) {
            // only generate links to translations, if is are more
            // than one language defined
            foreach ($this->languages as $language) {
                $linkEl = $doc->createElement('xhtml:link');
                $linkEl->setAttribute('rel', 'alternate');
                $linkEl->setAttribute('hreflang', $code = $language->code());
                $linkEl->setAttribute('href', $page->url($code));
                $url->appendChild($linkEl);
            }
        }

        // Add lastmod date either from metadata or from modified date of page
        $url->appendChild($doc->createElement('lastmod', date('Y-m-d', $meta->lastmod())));

        // Allow hook to alter the DOM
        if ($this->kirby->apply('meta.sitemap.url', [
            'kirby' => $this->kirby,
            'page' => $page,
            'meta' => $meta,
            'doc' => $doc,
            'url' => $url,
            'include' => true,
        ], 'include') !== false) {
            $root->appendChild($url);
        }
    }
}
