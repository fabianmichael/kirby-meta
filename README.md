# Kirby Meta

⚠️ This plugin is in early alpha state. Documentation and implementation are still incomplete.

This plugins handles the generation of meta tags for search engines, social networks,
browsers and beyond.

**Key features:**

- 🔎 All-in-one solution for SEO and social media optimization
- 📱 Support for OpenGraph, Twitter Cards and Schema.org markup
- 🚀 Customizable Metadata for auto-generated metadata from page contents
- 💻 Extensive panel UI including social media previews
- 🦊 Easy-to-understand language in the panel, providing a good middle ground between simplicity and extensive control options.
- 🌍 All blueprints are fully translatable

**Future plans:**

- 📋 Dedicated panel area for debugging site-wide meta information
- ✅ Live-check of metadata with hints in the panel

## How it works

The plugin tries looks for metadata from a pages content file (e.g. article.txt) by
the corrsponding key. If the page does not contain the specific field, it looks for a metadata.
Method on the current page model, which can return an array metadata for the current page
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

### Available configuration options

The options below have to be set in your `config.php`. Please note that every option has to be prifixed with the plugin namespace, e.g. `sitemap` => `fabianmichael.meta.sitemap`.

| Key | Type | Default | Description |
|:----|:-----|:--------|:------------|
| `sitemap` | `bool` | `true` | When true, will generate an XML sitemap for search engines. The sitemap includes all listed pages by default. |
| `sitemap.pages.exclude` | `array` | `[]` | An array of page IDs to exlude from the sitemap. Values are treated as regular expressions, so they can include wildcards like e.g. `about/.*`. The error page is always excluded. |
| `sitemap.pages.includeUnlisted` | `array` | `[]` | An array of page IDs to include in the sitemap, even if their status is `unlisted`. Values are treated as regular expressions, so they can include wildcards like e.g. `about/.*`. |
| `sitemap.templates.exclude` | `array` | `[]` | An array of template names to exlude from the sitemap. Values are treated as regular expressions, so they can include wildcards like e.g. `article-(internal|secret)` |
| `sitemap.templates.includeUnlisted` | `array` | `[]` | An array of templates to include in the sitemap, even if their status is `unlisted`. Values are treated as regular expressions. |
| `schema` | `bool` | `true` | Generate [Schema.org](https://schema.org/) markup as [JSON-LD](https://json-ld.org/).
| `social` | `bool` | `true` | Generate [OpenGraph](https://ogp.me/) and [Twitter Cards](https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/abouts-cards) markup.
| `robots` | `bool` | `true` | Generate the `robots` metatag and serve [robots.txt](https://developers.google.com/search/docs/advanced/robots/intro) at `http(s)://yourdomain.com/robots.txt`.
| `robots.canonical` | `bool` | `true` | Generate canonical url meta tag. Requires `robots` option to be `true`. |
| `robots.index` | `bool` | `true` | Allows crawlers to index pages. Can be overriden in global or page-specidic settings from the panel. Requires `robots` option to be `true` for having an effect. If a page is excluded from the sitemap or unlisted, the robots meta tag will always contain `noindex`. |
| `robots.follow` | `bool` | `true` | Allows crawlers to follow links on pages. Can be overriden in global or page-specidic settings from the panel. Requires `robots` option to be `true` for having an effect. |
| `robots.archive` | `bool` | `true` | Allows crawlers to serve a cached version of pages. Can be overriden in global or page-specidic settings from the panel. Requires `robots` option to be `true` for having an effect. |
| `robots.imageindex` | `bool` | `true` | Allows crawlers to include images to appear in search results. Can be overriden in global or page-specidic settings from the panel. Requires `robots` option to be `true` for having an effect. |
| `robots.snippet` | `bool` | `true` | Allows crawlers to generate snippets from page content. Can be overriden in global or page-specidic settings from the panel. Requires `robots` option to be `true` for having an effect. |
| `robots.translate` | `bool` | `true` | Allows crawlers offer automated translation of your content. Can be overriden in global or page-specidic settings from the panel. Requires `robots` option to be `true` for having an effect. |
| `theme.color` | `string|null` | `null` | If not empty, will generate a corresponding meta tag used by some browsers for coloring the UI. |

### Blueprint setup

Meta comes with predefined tab blueprints to be added to your site and page blueprints:

```yaml
# site/blueprints/site.yml
[…]
tabs:
  […]
  meta: tabs/meta/site

# site/blueprints/pages/default.yml
[…]
tabs:
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

Now you are ready to add/editr metadata from the panel.

## Advanced usage

### Providing metadata from page models

meta_description string
og_image File
@graph array
@social array

### Using hooks

the meta plugin provides a set of handy hooks, allowing you to further add/remove/modify metadata without overriding the built-in snippets or having to set up a page model for every template.

⚠️ Hooks are a powerful tool that can break the plugin’s expected behavior for editors working on the panel. Use with care!

| Hook | Parameters | Description |
|:-----|:-----------|:------------|
| `meta.load:after` | `array $metadata`, `Page $page` | After metadata has been loaded by calling the `$page->metadata()` method on a model. This allows you to inject additional data. |
| `meta.jsonld:after` | `array $json`, `PageMeta $meta`, `Page $page` | After the Schema.org graph has been generated. This allows you to pass additional data to the array. |
| `meta.social:after` | `array $social`, `PageMeta $meta`, `Page $page` | Allows you to alter the OpenGraph/Twitter card data. |

## License

This plugin is under the MIT license (see LICENSE file for details).

## Credits

This is partly based on an older version of the meta plugin, that I had initially
developed for [getkirby.com](https://getkirby.com). I liked the idea so much,
that I wanted to adapt it for general use on other websites.

It took a lot of inspiration (and some code) from other existing Kirby plugins,
like [MetaKnight](https://github.com/diesdasdigital/kirby-meta-knight/)
by [diesdas ⚡️ digital](https://www.diesdas.digital/)
and [Meta Tags](https://github.com/pedroborges/kirby-meta-tags)
by [Pedro Borges](https://github.com/pedroborges).


<!--
## Available keys

**Description:** The description field is used for search engines as a plain meta tag
and additionally added as an OpenGraph meta tag, which is used by social media networks
like e.g. Facebook or Twitter.

**Thumbnail:** The thumbnail for sharing the page in a social network. If defining a
custom thumbnail for a page, you should make sure to also add a text file containing
an `alt` text for the corresponding image, because it is also used by social networks.

**Twittercard:** Defaults to the value set in `site.txt` and is "summary_large_image"
by default. Set this to "summary", if you don’t want to display a large preview image.

**Robots:** Generates the "robots" meta tag, that gives specifix instructions to crawlers.
By default, this tag is not preset, unless a default value is defined in `site.txt`.
Use a value, that you would also use if you wrote the markup directly (e.g. `noindex, nofollow`)

**Title and Ogtitle:** By default, the metadata plugin will use the page’s `title` field. You can override this by defining an `ogtitle` field for a specific page. The `ogtitle` will
then be used for OpenGraph metadata instead of the page title.

**Twittersite:** The twitter account, which the site belongs to.

**Twittercreator:** The twitter account, who created the current page.

**Priority:** The priority for telling search engines about the importance
of pages of your site. Must be a float value between 0.0 and 1.0. This value will
not fall back to `site.txt`, but rather use 0.5 as default, if not explicit
priority was found in the page’s content or returned by its model.

**Changefreq:** Optional parameter, telling search engines how often a page changes.
Possible values can be found in the (sitemaps protocol specification)[https://www.sitemaps.org/protocol.html].

## Using page models to automatically generate meta data

You might not want to enter all meta data manually, so page models are your friend. This holds
especially true for pages, where you don’t want to Copy existing fields or where an
excerpt of the actual page content would not be suitable for generating meta data.

The following example adds a `metadata()` method to all Kosmos episodes, that takes
care of generating useful metadata, if a Kosmos issue is shared in a social network and
also provides an automatically generated description for search engines. All keys returned
by the `metadata()` method must be lowercase. Any arry item can be a value of a closure,
that will be called on the `$page` object, so you can use `$this` within the closure to
refer to the current page.

You can still override values (e.g. `description`) by adding a descriptiokn field to
an episode’s `issue.txt` file if you want to customize any of these values.

```php
class IssuePage extends Page
{

    public function metadata(): array
    {
        return [
            'description' => function () {
                return 'Read issue no. ' . $this->uid() . ' of our montly newsletter online.';
            },
            'thumbnail' => function() {
                return $this->image();
            },
            'ogtitle' => 'Kirby Kosmos Episode ' . $this->uid(),
        ];
    }
}
```

## Debug View

You can get an overview of the meta data assigned to pages by visiting <http(s)://[your site’s url]/meta-debug>. The debug page is only accessible, when Kirby’s `debug` option is set to true.

-->
