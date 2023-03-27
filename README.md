# Kirby Meta

⚠️ **Warning:** This plugin is in beta state. Documentation and implementation are still incomplete.

This piece of code handles the generation of meta tags for search engines, social networks,
browsers and beyond.

![Screenshot 2022-01-14 at 09-57-24 Mirin Avo’s Kitchen](https://user-images.githubusercontent.com/395617/149487743-576e7dca-0f66-41d0-821d-42f3581f5e7f.png)

**Key features:**

- 🔎 All-in-one solution for SEO and social media optimization
- 📱 Support for OpenGraph and Schema.org (JSON-LD) markup
- 🚀 Customizable metadata for auto-generated metadata from page contents
- 💻 Extensive panel UI including social media previews
- 🦊 Easy-to-understand language in the panel, providing a good middle ground between simplicity and extensive control options.
- 🧙‍♂️ Most features can be enabled/disabled in config, panel UI only shows enabled features (thanks to dynamic blueprints)
- 🪝 Hooks for altering the plugin's behavior
- 🌍 All blueprints are fully translatable (*English, German and French translations are included*)

**Future plans:**

- ✅ Live-check of metadata with hints in the panel

> This plugin is completely free and published under the MIT license. However, if you are using it in a commercial project and want to help me keep up with maintenance, please consider to **[❤️ sponsor me](https://github.com/sponsors/fabianmichael)** for securing the continued development of the plugin.

## Requirements

- PHP 8.0+
- Kirby 3.6.0+

## How it works

The plugin looks for metadata from a page's content file (e.g. `article.txt`) by
the corresponding key. If the page does not contain the specific field, it looks for a metadata
method on the current page model, which can return an array of metadata for the current page.
If that also fails, it will fall back to default metadata, as stored in the
`site.txt` file at the top-level of the content directory.

That way, every page will always be able to serve default values, even if the specific
page or its model does not contain information like e.g. a thumbnail or a dedicated
description.

## Installation & Setup

**Install using composer (recommended):**

```
composer require fabianmichael/kirby-meta
```

**Alternative download methods:**

You can also download this repository as ZIP or add the whole repo as a submodule.
To run from source, you need to install the dependencies : `composer install`.

### Available configuration options

The options below have to be set in your `config.php`. Please note that every option has to be prefixed with the plugin namespace, e.g. `sitemap` => `fabianmichael.meta.sitemap`.

| Key | Type | Default | Description |
|:----|:-----|:--------|:------------|
| `sitemap` | `bool` | `true` | When `true`, will generate an XML sitemap for search engines. The sitemap includes all listed pages by default. ⚠️ If you disable the `robots` setting, no robots.txt will be served to tell search engines where your sitemap is located. |
| `sitemap.detailSettings` | `bool` | `false` | When ´true`, the `<changefreq>` and `<priority>` tags are included in the sitemap and their corresponding fields are displayed in the panel. |
| `sitemap.pages.exclude` | `array` | `[]` | An array of page IDs to exlude from the sitemap. Values are treated as regular expressions, so they can include wildcards like e.g. `about/.*`. The error page is always excluded. |
| `sitemap.pages.includeUnlisted` | `array` | `[]` | An array of page IDs to include in the sitemap, even if their status is `unlisted`. Values are treated as regular expressions, so they can include wildcards like e.g. `about/.*`. |
| `sitemap.templates.exclude` | `array` | `[]` | An array of template names to exlude from the sitemap. Values are treated as regular expressions, so they can include wildcards like e.g. `article-(internal|secret)` |
| `sitemap.templates.includeUnlisted` | `array` | `[]` | An array of templates to include in the sitemap, even if their status is `unlisted`. Values are treated as regular expressions. |
| `schema` | `bool` | `true` | Generates [Schema.org](https://schema.org/) markup as [JSON-LD](https://json-ld.org/).
| `social` | `bool` | `true` | Generates [OpenGraph](https://ogp.me/) markup.
| `twitter` | `bool` | `true` | Generates [Twitter Cards](https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/abouts-cards) markup.  Only has an effect, if `social` is also enabled. Since `0.2.0-beta` (⚠️ deprecated).
| `robots` | `bool` | `true` | Generates the `robots` metatag and serve [robots.txt](https://developers.google.com/search/docs/advanced/robots/intro) at `http(s)://yourdomain.com/robots.txt`.
| `robots.canonical` | `bool` | `true` | Generates canonical url meta tag. Requires `robots` option to be `true`. |
| `robots.index` | `bool` | `true` | Allows crawlers to index pages. Can be overriden in global or page-specific settings from the panel. Requires `robots` option to be `true` for having an effect. If a page is excluded from the sitemap or unlisted, the robots meta tag will always contain `noindex`. |
| `robots.follow` | `bool` | `true` | Allows crawlers to follow links on pages. Can be overriden in global or page-specific settings from the panel. Requires `robots` option to be `true` for having an effect. |
| `robots.archive` | `bool` | `true` | Allows crawlers to serve a cached version of pages. Can be overriden in global or page-specific settings from the panel. Requires `robots` option to be `true` for having an effect. |
| `robots.imageindex` | `bool` | `true` | Allows crawlers to include images to appear in search results. Can be overriden in global or page-specific settings from the panel. Requires `robots` option to be `true` for having an effect. |
| `robots.snippet` | `bool` | `true` | Allows crawlers to generate snippets from page content. Can be overriden in global or page-specific settings from the panel. Requires `robots` option to be `true` for having an effect. |
| `robots.translate` | `bool` | `true` | Allows crawlers offer automated translation of your content. Can be overriden in global or page-specific settings from the panel. Requires `robots` option to be `true` for having an effect. |
| `title.separators` | `array` | `["~" , "-" , "–" , "—" , ":" , "/", …]` | List of available separator options for the `<title>` tag. The separator can be selected in the panel and is placed between page title and site title. |
| `theme.color` | `string\|null` | `null` | If not empty, will generate a corresponding meta tag used by some browsers for coloring the UI. |
| `panel.view.filter` | Provides a filter function for hiding certain pages from the metadata debug view in the panel. See the Kirby docs on [`$pages->filter()`](https://getkirby.com/docs/reference/objects/cms/pages/filter) for details. |

### Blueprint setup

Your site and page blueprints need to use [tabs](https://getkirby.com/docs/guide/blueprints/layout#tabs), as the plugin's input fields all come in a tab. Meta comes with tab blueprints that need to be added to your site and page blueprints accordingly:

```yaml
# site/blueprints/site.yml
[…]
tabs:
  structure:
    label: Structure
    columns:
      […]
  meta: tabs/meta/site

# site/blueprints/pages/default.yml
[…]
tabs:
  content:
    label: Content
    columns:
      […]
  meta: tabs/meta/page
```

### Template setup

Include the `meta` snippet within your `<head>` element, preferably before
loading any scripts or stylesheets:

```php
<!doctype html>
<html>
<head>
  <?php snippet('meta') ?>
  […]
</head>
[…]
```

Now you are ready to add/edit metadata from the panel.

## Advanced usage

### Providing metadata from page models

Sometimes, you want special behavior for certain templates. The easiest way to achieve this is by creating a page model and implementing a `$page->metadata()` method, that returns an array some or even all of the following keys:

| Key | Type | Description |
|:----|:-----|:------------|
| `meta_description` | `string` | Provide a default description that is used, when the user had not entered a dedicated description for this page. This could e.g. be a truncated version of the page's text content. |
| `og_title_prefix` | `string` | Will be put in front of the page's OpenGraph title, e.g. `'ℹ️ '` or `'[Recipe ]` |
| `og_image File` | `Kirby\Cms\File` | A `File` object, that sets the default OpenGraph image for this page. You can even generate custom images programatically and Wrap them in a `File` object, e.g. for the docs of your product (getkirby.com does this for the reference pages).
| `@graph` | `array` | Things to add to the JSON-LD metadata in the page's head. If you need to reference the organization or person behind the website, use `url('/#owner')`. If you need to reference the website itself, use `url('/#website')`. |
| `@social` | `array` | Extend the social meta tags generated by the plugin. |

### Using hooks

the meta plugin provides a set of handy hooks, allowing you to further add/remove/modify metadata without overriding the built-in snippets or having to set up a page model for every template.

⚠️ Hooks are a powerful tool that can break the plugin's expected behavior for editors working on the panel. Use with care!

#### `meta.load:after`

After metadata has been loaded by calling the `$page->metadata()` method on a model. This allows you to inject additional data.

```php
return [
  'meta.load:after' => function (
    array $metadata,
    Kirb\Cms\Page $page,
    ?string $languageCode
  ) {
    // set `thumbnail.png` as default share image for all pages,
    // if not other image was already set by a page model
    if (empty($metadata['og_image']) === true) {
      $metadata['og_image'] = $page->image('thumbnail.png');
    }
    return $metadata;
  },
];
```

#### `meta.jsonld:after` hook

After the Schema.org graph has been generated. This allows you to pass additional data to the array.

```php
return [
  'meta.jsonld:after' => function (
    array $json,
    FabianMichael\Meta\PageMeta $meta,
    Kirb\Cms\Page $page
  ) {
    // add breadcrumb to JSON-LD graph
    $items = [];

    $parents = $page->parents();

    if ($parents->count() === 0) {
      return $json;
    }

    $i = 0;

    foreach ($parents->flip() as $parent) {
      $items[] = [
        '@type' => 'ListItem',
        'position' => ++$i,
        'item' => [
          '@id' => $parent->url(),
          'name' => $parent->title()->toString(),
        ],
      ];
    }

    $json['@graph'][] = [
      '@type' => 'BreadcrumbList',
      'itemListElement' => $items,
    ];

    return $json;
  },
];
```

#### `meta.social:after`

Allows you to alter the OpenGraph/Twitter card data.

```php
return [
  'meta.social:after' => function (
    array $social,
    FabianMichael\Meta\PageMeta $meta,
    Kirby\Cms\Page $page
  ) {
    // add first video file of page to OpenGraph markup
    if ($page->hasVideos()) {
      $social[] = [
        'property' => 'og:video',
        'content'  => $page->videos()->first()->url(),
      ];
    }
    return $social;
  },
];
```


#### `'meta.sitemap…` hooks

These hooks allow you to completely alter the way how the sitemap is being generated. These functions are meant to manipulate the provided DOM document and elements directly and should not return anything.

```php
return [
  'hooks' => [
    'meta.sitemap:before' => function (
      Kirby $kirby,
      DOMDocument $doc,
      DOMElement $root
    ) {
      // add namespace for image sitemap
      $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:image', 'http://www.google.com/schemas/sitemap-image/1.1');
    },

    'meta.sitemap.url' => function (
      Kirby $kirby,
      Page $page,
      PageMeta $meta,
      DOMDocument $doc,
      DOMElement $url) {
      foreach ($page->images() as $image) {
        // add all images from page to image sitemap.
        $imageEl = $doc->createElement('image:image');
        $imageEl->appendChild($doc->createElement('image:loc', $image->url()));

        if ($image->alt()->isNotEmpty()) {
          $imageEl->appendChild($doc->createElement('image:caption', $image->alt()));
        }

        $url->appendChild($imageEl);
      }
    },

    'meta.sitemap:after' => function (
      Kirby $kirby,
      DOMDocument $doc,
      DOMElement $root
    ) {
      foreach ($root->getElementsByTagName('url') as $url) {
        if ($lastmod = $url->getElementsByTagName('lastmod')[0] ?? null) {
          // remove lastmod date from sitemap entries for some reason …
          $url->removeChild($lastmod);
        }
      }
    },

    'meta.theme.color' => function (
      ?string $color
    ) {
      return '#ff0000';
    }
  ],
];
```

### Manipulating indexed pages
A few helpers are available for manipulating pages:

### Page Method
If you'd like to know if a page is indexed in the sitemap, you can use `$page->isIndexible()` (returns a `bool`).

### Site Method
To get all indexed pages according to your settings, you can use : `$site->indexedPages()` (returns a `Kirby\Cms\Collection` of pages).

## Credits

This is partly based on an older version of the meta plugin, that I had initially
developed for [getkirby.com](https://getkirby.com). I liked the idea so much,
that I wanted to adapt it for general use on other websites.

It took a lot of inspiration (and some code) from other existing Kirby plugins,
like [MetaKnight](https://github.com/diesdasdigital/kirby-meta-knight/)
by [diesdas ⚡️ digital](https://www.diesdas.digital/)
and [Meta Tags](https://github.com/pedroborges/kirby-meta-tags)
by [Pedro Borges](https://github.com/pedroborges).
