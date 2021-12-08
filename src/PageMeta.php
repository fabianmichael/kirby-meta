<?php

namespace FabianMichael\Meta;

use Kirby\Cms\App as Kirby;
use Kirby\Cms\Field;
use Kirby\Cms\File;
use Kirby\Cms\Page;

class PageMeta
{
    protected Page $page;
    protected Kirby $kirby;
    protected array $metadata = [];

    public function __call($name, $arguments): mixed
    {
        return $this->get(strtolower($name), ...$arguments);
    }

    protected function __construct(Page $page)
    {
        $this->kirby = $page->kirby();
        $this->page  = $page;

        // Get metadata from page, if possible
        if (method_exists($this->page, 'metadata') === true) {
            $this->metadata = $this->page->metadata();
        }

        // Allow other plugins/config to alter metadata after load
        $this->metadata = $this->kirby->apply(
            'meta.load:after',
            [
                'metadata' => $this->metadata,
                'page'     => $this->page,
            ],
            'metadata'
        );
    }

    public function canonicalUrl(): string
    {
        return $this->meta_canonical_url()
            ->or($this->metadata('canonical_url'))
            ->or($this->page->url())
            ->toString();
    }

    public function changefreq(): ?string
    {
        $changefreq = $this->get('sitemap_changefreq', true, true, false);

        return $changefreq->isNotEmpty()
            ? $changefreq->toString()
            : null;
    }

    public function description(): Field
    {
        return $this->get('meta_description', true, true, false);
    }

    public function get(
        string $key,
        bool $metadataFallback = true,
        bool $siteFallback = false,
        bool $configFallback = false,
        mixed $fallback = null): Field
    {
        // From content file ...
        $field = $this->page->content()->get($key);

        if ($field->isNotEmpty() === true) {
            return $field;
        }

        // From page model metadata ...
        if ($metadataFallback === true && array_key_exists($key, $this->metadata) === true) {
            $value = $this->metadata[$key];

            if (is_callable($value) === true) {
                $value = $value->call($this->page);
            }

            return is_a($value, Field::class) === true
                ? $value
                : new Field($this->page, $key, $value);
        }

        // From site as fallback ...
        if ($siteFallback === true) {
            $value = $this->page->site()->content()->get($key);

            if ($value->isNotEmpty()) {
                return $value;
            }
        }

        // From config as fallback ...
        if ($configFallback === true) {
            $value = option('fabianmichael.meta.' . str_replace('_', '.', $key));

            if ($value !== null) {
                return new Field($this->page, $key, $value);
            }
        }

        // Nothing found, return final fallback value
        return new Field($this->page, $key, $fallback);
    }

    public function jsonld(): array
    {
        $graph = [];
        $site  = $this->page->site();

        $websiteId = url('/#website');
        $ownerId   = url('/#owner');

        // Website

        $website = [
            '@type' => 'WebSite',
            '@id'   => $websiteId,
            'url'   => url(),
            'name'  => $site->title()->toString(),
            'description' => $site->meta_description()->toString(),
        ];

        if ($locale = $this->locale()) {
            $website['inLanguage'] = $locale;
        }

        $graph[] = $website;

        // Website owner

        $owner = $site->meta_website_owner()->toString();

        if ($owner === 'org') {
            $org = [
                '@type' => 'Organization',
                '@id'   => $ownerId,
                'name'  => $site->meta_org_name()->toString(),
                'url' => url(),
                // 'sameAs' => [
                //     'https://twitter.com/getkirby',
                //     'https://instagram.com/getkirby',
                // ],
            ];

            if ($logo = $site->meta_org_logo()->toFile()) {
                $org['logo'] = $logo->url();
            }

            $graph[] = $org;
        } else if ($owner === 'person' && ($user = $site->meta_person()->toUser())) {
            $person = [
                '@type' => 'Person',
                '@id'   => url('/#owner'),
                'name' => $user->name()->toString(),
                'email' => $user->email(),
            ];

            if ($avatar = $user->avatar()) {
                $person['image'] = $avatar->url();
            }

            $graph[] = $person;
        }

        // Merge with page metadata …
        $graph = array_merge($graph, $this->metadata('@graph', []));

        $json = [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];

        // Hook
        $json = $this->kirby->apply(
            'meta.jsonld:after',
            [
                'json'      => $json,
                'meta'      => $this,
                'page'      => $this->page,
            ],
            'json'
        );

        return $json;
    }

    public function locale(): ?string
    {
        if ($language = $this->page->kirby()->language()) {
            return $language->code();
        } else if ($locale = $this->page->kirby()->option('locale')) {
            return preg_replace('/^([^.]+)\:/is', '$1', $locale);
        }

        return null;
    }

    public function metadata(string $name, mixed $fallback = null): mixed
    {
        return array_key_exists($name, $this->metadata) === true
            ? $this->metadata[$name]
            : $fallback;
    }

    public static function of(Page $site): static
    {
        return new static($site);
    }

    public function priority(): ?float
    {
        $priority = $this->get('sitemap_priority', true, true, false, 0.5)->toFloat();
        return (float) max(0, min(1, $priority)); // 0 <= value <= 1
    }

    public function robots(?string $name = null): bool|string|null
    {
        if (is_string($name) === true) {
            // single robots value of page as boolean

            // if page is not in sitemap, it will also not be indexible
            if ($name === 'index' && Sitemap::isPageIndexible($this->page) === false) {
                return false;
            }

            // load from content/fallback
            return $this
                ->content()
                ->get("robots_{$name}")
                ->or(SiteMeta::robots($name))
                ->toBool();
        } else {
            // robots value for metatag as string|null
            $robots = [];

            foreach (['index', 'follow', 'archive', 'imageindex', 'snippet', 'translate'] as $prop) {
                if ($this->robots($prop) === false) {
                    $robots[] = "no{$prop}";
                }
            }

            return sizeof($robots) > 0
                ? implode(', ', $robots)
                : null;
        }
    }

    public function social(): array
    {
        $social = [];
        $site = $this->page->site();

        // OpenGraph

        $locale = $this->locale();

        if ($locale !== null) {
            $social[] = [
                'property' => 'og:locale',
                'content'  => $locale,
            ];
        }

        $social[] = [
            'property' => 'og:site_name',
            'content'  => $site->og_site_name()->or($site->title())->toString(),
        ];

        $social[] = [
            'property' => 'og:url',
            'content'  => $this->canonicalUrl(),
        ];

        $social[] = [
            'property' => 'og:type',
            'content'  => 'website', // TODO: make overridable from metadata() method
        ];

        $social[] = [
            'property' => 'og:title',
            'content'  => $this->get('og_title')->or($this->page->title()),
        ];

        $description = $this->get('og_description', true, false)
            ->or($this->get('meta_description', true, true));

        if ($description->isNotEmpty() === true) {
            $social[] = [
                'property' => 'og:description',
                'content'  => $description->toString(),
            ];
        }

        // Social image

        if ($image = $this->og_image()) {
            $extension = $image->extension();
            $thumb     = $image->thumb([
                'width'  => 1200,
                'height' => 630,
                'crop'   => true,
                'format' => in_array($extension, ['jpeg', 'jpg', 'png']) === false ? 'jpg' : null,
            ]);

            $social[] = [
                'property' => 'og:image',
                'content' => $thumb->url(),
            ];

            $social[] = [
                'property' => 'og:image:width',
                'content' => $thumb->width(),
            ];

            $social[] = [
                'property' => 'og:image:height',
                'content' => $thumb->height(),
            ];

            if ($image->alt()->isNotEmpty()) {
                $social[] = [
                    'property' => 'og:image:alt',
                    'content' => $thumb->alt()->toString(),
                ];
            }
        }

        // Twitter

        $social[] = [
            'name' => 'twitter:card',
            'content' => 'summary_large_image', // TODO: make overridable from metadata() method
        ];

        $twitterSite = $this->get('twitter_site', false, true);
        if ($twitterSite->isNotEmpty() === true) {
            $social[] = [
                'name' => 'twitter:site',
                'content' => '@' . ltrim($twitterSite->toString(), '@'),
            ];
        }

        $twitterCreator = $this->get('twitter_creator', true, true);
        if ($twitterCreator->isNotEmpty() === true) {
            $social[] = [
                'name' => 'twitter:creator',
                'content' => '@' . ltrim($twitterCreator->toString(), '@'),
            ];
        }

        // Additional metadata from page model
        $social = array_merge($social, $this->metadata('@social', []));

        // Hook
        $social = $this->kirby->apply(
            'meta.social:after',
            [
                'social'   => $social,
                'meta'     => $this,
                'page'     => $this->page,
            ],
            'social'
        );

        return $social;
    }

    public function title(): Field
    {
        $title = [];

        if ($this->page->isHomePage() === false) {
            // Todo: Support pagination
            $title[] = $this->page->content()->get('meta_title')
                ->or($this->page->title())->toString();

            $title[] = SiteMeta::titleSeparator();
        }

        $title[] = $this->page->site()->title()->toString();

        return new Field($this->page, 'title', implode('' , $title));
    }

    public function og_image(bool $fallback = true): ?File
    {
        // Overrule auto-generated image if custom one is set:
        // In content file ...
        if ($image = $this->get('og_image', false)->toFile()) {
            return $image;
        }

        // Search in page model ...
        if ($image = $this->metadata('og_image')) {
            return $image;
        }

        // Fallback to global thumbnail
        if ($fallback === true && ($image = $this->page->site()->content()->get('og_image')->toFile())) {
            return $image;
        }

        return null;
    }
}