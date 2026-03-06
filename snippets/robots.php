<?php if (option('fabianmichael.meta.robots.forceNoIndex')): ?>
    <meta name="robots" content="none">
<?php else: ?>
    <meta name="robots" content="<?= html($meta->robots()) ?>">
<?php endif ?>


<?php if ($kirby->option('fabianmichael.meta.robots.canonical') !== false): ?>
    <link rel="canonical" href="<?= html($meta->canonicalUrl()) ?>">
<?php endif ?>
