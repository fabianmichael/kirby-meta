<?php

return [
    'fabianmichael.meta.tab.label' => 'Metadata (SEO)',
    'fabianmichael.meta.page_title.placeholder' => 'Page title',
    'fabianmichael.meta.title_preview.label' => 'Title preview',
    'fabianmichael.meta.global_settings.headline' => 'Global settings',
    'fabianmichael.meta.global_general.headline' => 'General settings',
    'fabianmichael.meta.general.headline' => 'Basic meta information',
    'fabianmichael.meta.title.label' => 'Title (Override)',
    'fabianmichael.meta.title.help' => 'The page title as it should be displayed on search engines. Will default to Kirby page title when this field is empty.',
    'fabianmichael.meta.title_separator.label' => 'Title Separator',
    'fabianmichael.meta.title_separator.help' => 'Separator to be displayed between page and site title.',

    'fabianmichael.meta.robots.headline' => 'Search engines',
    'fabianmichael.meta.robots.help' => 'Detailed instructions for how search engines should handle this page.',
    'fabianmichael.meta.robots_index.label' => 'Indexing',
    'fabianmichael.meta.robots_index.help' => 'Search engines are allowed to index this page.',
    'fabianmichael.meta.robots_follow.label' => 'Follow links',
    'fabianmichael.meta.robots_follow.help' => 'Search engines will follow links on this page.',
    'fabianmichael.meta.robots_archive.label' => 'Archiving',
    'fabianmichael.meta.robots_archive.help' => 'Search engines will cache this page.',
    'fabianmichael.meta.robots_imageindex.label' => 'Image indexing',
    'fabianmichael.meta.robots_imageindex.help' => 'Search engines will associate this page with image search results.',
    'fabianmichael.meta.robots_snippet.label' => 'Snippets',
    'fabianmichael.meta.robots_snippet.help' => 'Search engines will display description snippets for this page.',

    'fabianmichael.meta.global_robots.headline' => 'Search engine settings',
    'fabianmichael.meta.global_robots.help' => 'Detailed instructions for how search engines should handle pages of this site by default. Pages can have their individual settings to override these defaults.',
    'fabianmichael.meta.global_robots_index.label' => 'Indexing',
    'fabianmichael.meta.global_robots_index.help' => 'Search engines are allowed to index this site.',
    'fabianmichael.meta.global_robots_follow.label' => 'Follow links',
    'fabianmichael.meta.global_robots_follow.help' => 'Search engines will follow links on this site.',
    'fabianmichael.meta.global_robots_archive.label' => 'Archiving',
    'fabianmichael.meta.global_robots_archive.help' => 'Search engines will cache pages on this site.',
    'fabianmichael.meta.global_robots_imageindex.label' => 'Image indexing',
    'fabianmichael.meta.global_robots_imageindex.help' => 'Search engines will associate pages with image search results.',
    'fabianmichael.meta.global_robots_snippet.label' => 'Snippets',
    'fabianmichael.meta.global_robots_snippet.help' => 'Search engines will display description snippets for pages.',

    'fabianmichael.meta.description.label' => 'Description',
    'fabianmichael.meta.description.help' => 'A short description of the page that will be displayed underneath the page title by search engines.',
    'fabianmichael.meta.global_description.help' => 'The global description will be used as fallback for all pages, that don’t have a dedicated description.',
    'fabianmichael.meta.canonical_url.label' => 'Canonical URL',
    'fabianmichael.meta.canonical_url.help' => 'The canonical URL of the page. Will default to page URL when this field is empty.',
    'fabianmichael.meta.global_default_value.label' => 'Site ({ state })',
    'fabianmichael.meta.config_default_value.label' => 'Config ({ state })',
    'fabianmichael.meta.state.on' => 'on',
    'fabianmichael.meta.state.off' => 'off',
    'fabianmichael.meta.state.unset' => 'not set',
    'fabianmichael.meta.og.headline' => 'Social media sharing',
    'fabianmichael.meta.og.help' => '[Open Graph](https://ogp.me/) metadata is consumed by social networks (e.g. Facebook, Twitter) and most messenger apps (e.g. Signal, Telegram, iMessage).',
    'fabianmichael.meta.og_site_name.label' => 'Share site name',
    'fabianmichael.meta.og_site_name.help' => 'The name which should be displayed for the overall site for social media sharing. Will use site title as fallback.',
    'fabianmichael.meta.global_og_image.label' => 'Default share image',
    'fabianmichael.meta.global_og_image.help' => 'An image which should represent your shared links within social media websites and apps. Will be cropped automatically. This global image is used as a fallback for pages, that do not have a dedicated image.<br><br>**Recommended size:** 1200&thinsp;&times;&thinsp;630&nbsp;px<br>**Formats:** JPEG, PNG, GIF, WebP, AVIF',
    'fabianmichael.meta.og_image.label' => 'Share Image',
    'fabianmichael.meta.og_image.help' => 'An image which should represent your shared links within social media websites and apps. Will be cropped automatically. Will use the globally defined fallback image as fallback.<br><br>**Recommended size:** 1200&thinsp;&times;&thinsp;630&nbsp;px<br>**Formats:** JPEG, PNG, GIF, WebP, AVIF {< site.metaPanelWarning("no_og_image_fallback") >}',
    'fabianmichael.meta.og_title.label' => 'Share title (override)',
    'fabianmichael.meta.og_title.help' => 'The title of your page as it should appear when shared. Will use **Title (override)** and page title as fallback.',
    'fabianmichael.meta.og_description.label' => 'Share description',
    'fabianmichael.meta.og_description.help' => 'A one to two sentence description of your object. Will use page description and site description as fallbacks.',

    'fabianmichael.meta.image.empty' => 'No image selected yet',
    'fabianmichael.meta.files.headline' => 'Files',

    'fabianmichael.meta.sitemap.priority.label' => 'Sitemap priority',
    'fabianmichael.meta.sitemap.priority.help' => 'Relative priority compared to other pages on your site.',
    'fabianmichael.meta.sitemap.global_priority.help' => 'Default priority for all pages of this site. Setting a priority gives a hint to search engines about the relative importance of your pages in comparison to each other.',
    'fabianmichael.meta.sitemap.changefreq.label' => 'Change frequency',
    'fabianmichael.meta.sitemap.changefreq.help' => 'Tells search engines, how often the content changes.',
    'fabianmichael.meta.sitemap.changefreq.always' => 'Always',
    'fabianmichael.meta.sitemap.changefreq.hourly' => 'Hourly',
    'fabianmichael.meta.sitemap.changefreq.daily' => 'Daily',
    'fabianmichael.meta.sitemap.changefreq.weekly' => 'Weekly',
    'fabianmichael.meta.sitemap.changefreq.monthly' => 'Monthly',
    'fabianmichael.meta.sitemap.changefreq.yearly' => 'Yearly',
    'fabianmichael.meta.sitemap.changefreq.never' => 'Never',

    'fabianmichael.meta.twitter.headline' => 'Twitter',
    'fabianmichael.meta.twitter.site.label' => 'Twitter username of website',
    'fabianmichael.meta.twitter.creator.label' => 'Twitter username of content creator',

    'fabianmichael.meta.no_og_image_fallback' => 'No global fallback image defined. Please go to <a href="{ link }">global metadata settings</a> and upload one.',

    'fabianmichael.meta.schema.person_privacy_notice.label' => 'Privacy notice',
    'fabianmichael.meta.schema.person_privacy_notice.text' => 'By selecting a user, you will expose personal information such as the email address and profile image to search engines, other crawlers and everyone who reads the source code of your website.',
    'fabianmichael.meta.sharing_preview.headline' => 'Share preview',
    'fabianmichael.meta.description_missing' => '[Share Description and fallback Description Missing]',
    'fabianmichael.meta.source.og_image' => 'Source: Share Image',
    'fabianmichael.meta.source.metadata' => 'Source: Page thumbnail',
    'fabianmichael.meta.source.site' => 'Source: Fallback thumbnail',
    'fabianmichael.meta.og_image.missing' => 'Image missing',

    'fabianmichael.meta.schema.headline' => 'Structured data',
    'fabianmichael.meta.schema.help' => 'This data is based on the [Schema.org](https://schema.org) standard and can be picked up by search engines such as [Google](https://google.com)’s knowledge graph for better understanging your organization or person.',
    'fabianmichael.meta.schema.website_owner.label' => 'Website owner',
    'fabianmichael.meta.schema.website_owner.help' => 'Select wether your website represents an organisation or individual person.',
    'fabianmichael.meta.schema.org_name.label' => 'Organization name',
    'fabianmichael.meta.schema.org_logo.label' => 'Organization logo',
    'fabianmichael.meta.schema.meta_person.label' => 'Person',
    'fabianmichael.meta.schema.meta_person.empty' => 'No user selected yet',
    'fabianmichael.meta.schema.meta_person.help' => 'Select a user who represents this website.',

    'fabianmichael.meta.status.label' => 'Status',
    'fabianmichael.meta.search_engines.visibility.visible' => 'Visible',
    'fabianmichael.meta.search_engines.visibility.hidden' => 'Hidden',
    'fabianmichael.meta.search_engines.visibility.label' => 'Search engine visbility',
    'fabianmichael.meta.search_engines.visibility.yes' => 'This page is indexed by search engines and may appear in search results',
    'fabianmichael.meta.search_engines.visibility.no' => 'This page is hidden from search results',
];
