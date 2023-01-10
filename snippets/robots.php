<meta name="robots" content="<?= esc($meta->robots(), 'attr') ?>">

<?php if ($kirby->option('fabianmichael.meta.robots.canonical') !== false): ?>
    <link rel="canonical" href="<?= esc($meta->canonicalUrl(), 'attr') ?>">
<?php endif ?>
