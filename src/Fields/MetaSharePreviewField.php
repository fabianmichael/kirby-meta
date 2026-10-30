<?php

namespace FabianMichael\Meta\Fields;

use Kirby\Cms\Page;
use Kirby\Form\Field\DisplayField;

class MetaSharePreviewField extends DisplayField
{
    public function props(): array
    {
        /** @var Page $page */
        $page = $this->model();

        return [
            ...parent::props(),
            'is_homepage' => $page->isHomePage(),
            'title_separator' => option('fabianmichael.meta.title.separator'),

            // overrides
            'override_og_title' => $page->meta()->override('og_title'),
            'override_og_description' => $page->meta()->override('og_description'),
            'override_og_image' => $page->meta()->ogImage(
                defaultFallback: false,
                siteFallback: false,
                respectOverrides: true,
                content: false
            )?->crop(1200, 630)->toArray(),

            // defaults
            'default_og_title' => $page->meta()->ogTitle(
                defaultFallback: true,
                respectOverrides: false,
                content: false
            ),
            'default_og_description' => $page->meta()->ogDescription(
                defaultFallback: true,
                siteFallback: true,
                respectOverrides: false,
                content: false
            ),
            'default_og_image' => $page->meta()->ogImage(
                defaultFallback: true,
                siteFallback: false,
                respectOverrides: false,
                content: false
            )?->crop(1200, 630)->toArray(),

            // site defaults
            'og_site_name' => $page->meta()->ogSiteName(),
            'site_og_image' => $page->meta()->ogImage(
                defaultFallback: false,
                siteFallback: true,
                respectOverrides: false,
                content: false
            )?->crop(1200, 630)->toArray(),
        ];
    }
}
