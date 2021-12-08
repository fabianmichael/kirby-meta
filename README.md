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

- 🌍 Compability with multilanguage setups
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

## Credits

This is partly based on an older version of the meta plugin, that I had initially
developed for [getkirby.com](https://getkirby.com). I liked the idea so much,
that I wanted to adapt it for general use on other websites.

It took a lot of inspiration (and some code) from other existing Kirby plugins,
like [MetaKnight](https://github.com/diesdasdigital/kirby-meta-knight/)
by [diesdas ⚡️ digital](https://www.diesdas.digital/)
and [Meta Tags](https://github.com/pedroborges/kirby-meta-tags)
by [Pedro Borges](https://github.com/pedroborges).
