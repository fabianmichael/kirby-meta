<?php

use FabianMichael\Meta\PageMeta;
use FabianMichael\Meta\SiteMap;

return [
    'meta' => function (?string $languageCode = null) {
        return PageMeta::of($this, $languageCode);
    },

    'isIndexible' => function (): bool {
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

        if ($this->isErrorPage()) {
            // error page is always excluded from sitemap
            return false;
        }

        if ($this->isDraft()) {
            // draft pages are never indexible
            return false;
        }

        if (! $this->isHomePage() && $this->status() === 'unlisted') {
            if (preg_match($templatesIncludeUnlistedRegex, $this->intendedTemplate()->name()) !== 1
                && preg_match($pagesIncludeUnlistedRegex, $this->id()) !== 1) {
                // unlisted pages are only indexible if exceptions are
                // defined for them based on page id or template
                return false;
            }
        }

        if (preg_match($templatesExcludeRegex, $this->intendedTemplate()->name()) === 1) {
            // page is in exclude-list of templates
            return false;
        }

        if (preg_match($pagesExcludeRegex, $this->id()) === 1) {
            // page is in exclude-list of page IDs
            return false;
        }

        return true;
    },
];
