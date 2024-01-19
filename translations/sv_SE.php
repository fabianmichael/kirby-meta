<?php

return [
    'fabianmichael.meta.tab.label' => 'Metadata (SEO)',
    'fabianmichael.meta.page_title.placeholder' => 'Sidtitel',
    'fabianmichael.meta.title_preview.label' => 'Titelförhandsgranskning',
    'fabianmichael.meta.global_settings.headline' => 'Globala inställningar',
    'fabianmichael.meta.global_general.headline' => 'Allmänna inställningar',
    'fabianmichael.meta.general.headline' => 'Grundläggande meta-information',
    'fabianmichael.meta.title.label' => 'Titel (Prioriterad)',
    'fabianmichael.meta.title.help' => 'Sidans titel som den ska visas i sökmotorer. Kommer att använda Kirbys sidtitel som standard när detta fält är tomt.',
    'fabianmichael.meta.title_separator.label' => 'Titelseparator',
    'fabianmichael.meta.title_separator.help' => 'Separator som ska visas mellan sid- och webbplatsens titel.',

    'fabianmichael.meta.robots.headline' => 'Sökmotorer',
    'fabianmichael.meta.robots.help' => 'Detaljerade instruktioner om hur sökmotorer ska hantera denna sida.',
    'fabianmichael.meta.robots_index.label' => 'Indexering',
    'fabianmichael.meta.robots_index.help' => 'Sökmotorer får indexera denna sida.',
    'fabianmichael.meta.robots_follow.label' => 'Följ länkar',
    'fabianmichael.meta.robots_follow.help' => 'Sökmotorer kommer att följa länkar på denna sida.',
    'fabianmichael.meta.robots_archive.label' => 'Arkivering',
    'fabianmichael.meta.robots_archive.help' => 'Sökmotorer kommer att cachelagra denna sida.',
    'fabianmichael.meta.robots_imageindex.label' => 'Bildindexering',
    'fabianmichael.meta.robots_imageindex.help' => 'Sökmotorer kommer att associera denna sida med bildsökresultat.',
    'fabianmichael.meta.robots_snippet.label' => 'Snippets',
    'fabianmichael.meta.robots_snippet.help' => 'Sökmotorer kommer att visa beskrivning för denna sida.',

    'fabianmichael.meta.global_robots.headline' => 'Inställningar för sökmotorer',
    'fabianmichael.meta.global_robots.help' => 'Detaljerade instruktioner om hur sökmotorer ska hantera sidor på denna webbplats som standard. Sidor kan ha sina individuella inställningar som åsidosätter dessa standarder.',
    'fabianmichael.meta.global_robots_index.label' => 'Indexering',
    'fabianmichael.meta.global_robots_index.help' => 'Sökmotorer får indexera denna webbplats.',
    'fabianmichael.meta.global_robots_follow.label' => 'Följ länkar',
    'fabianmichael.meta.global_robots_follow.help' => 'Sökmotorer kommer att följa länkar på denna webbplats.',
    'fabianmichael.meta.global_robots_archive.label' => 'Arkivering',
    'fabianmichael.meta.global_robots_archive.help' => 'Sökmotorer kommer att cachelagra sidor på denna webbplats.',
    'fabianmichael.meta.global_robots_imageindex.label' => 'Bildindexering',
    'fabianmichael.meta.global_robots_imageindex.help' => 'Sökmotorer kommer att associera sidor med bildsökresultat.',
    'fabianmichael.meta.global_robots_snippet.label' => 'Snippets',
    'fabianmichael.meta.global_robots_snippet.help' => 'Sökmotorer kommer att visa beskrivningar för sidor.',

    'fabianmichael.meta.description.label' => 'Beskrivning',
    'fabianmichael.meta.description.help' => 'En kort beskrivning av sidan som kommer att visas under sidtiteln av sökmotorer.',
    'fabianmichael.meta.global_description.help' => 'Den globala beskrivningen kommer att användas som fallback för alla sidor som inte har en dedikerad beskrivning.',
    'fabianmichael.meta.canonical_url.label' => 'Kanonisk URL',
    'fabianmichael.meta.canonical_url.help' => 'Sidans kanoniska URL. Kommer att använda sidans URL som standard när detta fält är tomt.',
    'fabianmichael.meta.global_default_value.label' => 'Webbplats ({ state })',
    'fabianmichael.meta.config_default_value.label' => 'Konfiguration ({ state })',
    'fabianmichael.meta.state.on' => 'på',
    'fabianmichael.meta.state.off' => 'av',
    'fabianmichael.meta.state.unset' => 'inte satt',
    'fabianmichael.meta.og.headline' => 'Dela på sociala medier',
    'fabianmichael.meta.og.help' => '[Open Graph](https://ogp.me/) metadata används av sociala nätverk (t.ex. Facebook, Twitter) och de flesta meddelandeappar (t.ex. Signal, Telegram, iMessage).',
    'fabianmichael.meta.og_site_name.label' => 'Dela webbplatsnamn',
    'fabianmichael.meta.og_site_name.help' => 'Namnet som ska visas för hela webbplatsen vid delning på sociala medier. Kommer att använda webbplatsens titel som fallback.',
    'fabianmichael.meta.global_og_image.label' => 'Standard delningsbild',
    'fabianmichael.meta.global_og_image.help' => 'En bild som ska representera dina delade länkar på sociala medier och appar. Kommer att beskäras automatiskt. Denna globala bild används som fallback för sidor som inte har en dedikerad bild.<br><br>**Rekommenderad storlek:** 1200&thinsp;&times;&thinsp;630&nbsp;px<br>**Format:** JPEG, PNG, GIF, WebP, AVIF',
    'fabianmichael.meta.og_image.label' => 'Delbild',
    'fabianmichael.meta.og_image.help' => 'En bild som ska representera dina delade länkar på sociala medier och appar. Kommer att beskäras automatiskt. Kommer att använda den globalt definierade fallbackbilden som fallback.<br><br>**Rekommenderad storlek:** 1200&thinsp;&times;&thinsp;630&nbsp;px<br>**Format:** JPEG, PNG, GIF, WebP, AVIF {< site.metaPanelWarning("no_og_image_fallback") >}',
    'fabianmichael.meta.og_title.label' => 'Del-titel (överstyrning)',
    'fabianmichael.meta.og_title.help' => 'Titeln på din sida som den ska visas vid delning. Kommer att använda **Titel (överstyrning)** och sidtitel som fallback.',
    'fabianmichael.meta.og_description.label' => 'Del-beskrivning',
    'fabianmichael.meta.og_description.help' => 'En till två meningars beskrivning av objektet. Kommer att använda sidbeskrivning och webbplatsbeskrivning som fallbacks.',

    'fabianmichael.meta.image.empty' => 'Ingen bild vald ännu',
    'fabianmichael.meta.files.headline' => 'Filer',

    'fabianmichael.meta.sitemap.priority.label' => 'Prioritet i sitemap',
    'fabianmichael.meta.sitemap.priority.help' => 'Relativ prioritet jämfört med andra sidor på din webbplats.',
    'fabianmichael.meta.sitemap.global_priority.help' => 'Standardprioritet för alla sidor på denna webbplats. Att ange en prioritet ger en ledtråd till sökmotorer om den relativa vikten av dina sidor i jämförelse med varandra.',
    'fabianmichael.meta.sitemap.changefreq.label' => 'Ändringsfrekvens',
    'fabianmichael.meta.sitemap.changefreq.help' => 'Berättar för sökmotorer hur ofta innehållet ändras.',
    'fabianmichael.meta.sitemap.changefreq.always' => 'Alltid',
    'fabianmichael.meta.sitemap.changefreq.hourly' => 'Varje timme',
    'fabianmichael.meta.sitemap.changefreq.daily' => 'Dagligen',
    'fabianmichael.meta.sitemap.changefreq.weekly' => 'Veckovis',
    'fabianmichael.meta.sitemap.changefreq.monthly' => 'Månadsvis',
    'fabianmichael.meta.sitemap.changefreq.yearly' => 'Årligen',
    'fabianmichael.meta.sitemap.changefreq.never' => 'Aldrig',

    'fabianmichael.meta.twitter.headline' => 'Twitter',
    'fabianmichael.meta.twitter.site.label' => 'Twitter-användarnamn för webbplatsen',
    'fabianmichael.meta.twitter.creator.label' => 'Twitter-användarnamn för innehållsskapare',

    'fabianmichael.meta.no_og_image_fallback' => 'Ingen global reservbild definierad. Gå till <a href="{ link }">globala metadatinställningar</a> och ladda upp en.',

    'fabianmichael.meta.schema.person_privacy_notice.label' => 'Integritetsmeddelande',
    'fabianmichael.meta.schema.person_privacy_notice.text' => 'Genom att välja en användare kommer du att exponera personlig information som e-postadress och profilbild för sökmotorer, andra webbskrapor och alla som läser källkoden till din webbplats.',
    'fabianmichael.meta.sharing_preview.headline' => 'Delningsförhandsvisning',
    'fabianmichael.meta.description_missing' => '[Delbeskrivning och fallback-beskrivning saknas]',
    'fabianmichael.meta.source.og_image' => 'Källa: Delbild',
    'fabianmichael.meta.source.metadata' => 'Källa: Sidminiatyr',
    'fabianmichael.meta.source.site' => 'Källa: Fallback-miniatyr',
    'fabianmichael.meta.og_image.missing' => 'Bild saknas',

    'fabianmichael.meta.schema.headline' => 'Strukturerad data',
    'fabianmichael.meta.schema.help' => 'Denna data är baserad på standarden [Schema.org](https://schema.org) och kan plockas upp av sökmotorer som [Googles](https://google.com) kunskapsgraf för bättre förståelse av din organisation eller person.',
    'fabianmichael.meta.schema.website_owner.label' => 'Webbplatsägare',
    'fabianmichael.meta.schema.website_owner.help' => 'Välj om din webbplats representerar en organisation eller individuell person.',
    'fabianmichael.meta.schema.org_name.label' => 'Organisationsnamn',
    'fabianmichael.meta.schema.org_logo.label' => 'Organisationslogo',
    'fabianmichael.meta.schema.meta_person.label' => 'Person',
    'fabianmichael.meta.schema.meta_person.empty' => 'Ingen användare vald ännu',
    'fabianmichael.meta.schema.meta_person.help' => 'Välj en användare som representerar denna webbplats.',

    'fabianmichael.meta.status.label' => 'Status',
    'fabianmichael.meta.search_engines.visibility.visible' => 'Synlig',
    'fabianmichael.meta.search_engines.visibility.hidden' => 'Dold',
    'fabianmichael.meta.search_engines.visibility.label' => 'Sökmotorvisibilitet',
    'fabianmichael.meta.search_engines.visibility.yes' => 'Denna sida är indexerad av sökmotorer och kan visas i sökresultat',
    'fabianmichael.meta.search_engines.visibility.no' => 'Denna sida är dold från sökresultat',
];