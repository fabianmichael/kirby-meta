<?php if ($robots = $meta->robots()): ?>
    <meta name="robots" content="<?= $robots ?>">
<?php endif ?>

<?php if ($kirby->option('fabianmichael.meta.robots.canonical') !== false): ?>
    <link rel="canonical" href="<?= html($meta->canonicalUrl()) ?>">
<?php endif ?>
