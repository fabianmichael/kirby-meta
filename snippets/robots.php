<?php if (option('fabianmichael.meta.robots.forceNoIndex')): ?>
    <!-- this site is in stealth mode and will always tell search
    engines to not index it. The actual robots value for this
    particular page would be: "<?= html($meta->robots()) ?>" -->
    <meta name="robots" content="none">
<?php else: ?>
    <meta name="robots" content="<?= html($meta->robots()) ?>">
<?php endif ?>

<?php if ($kirby->option('fabianmichael.meta.robots.canonical') !== false): ?>
    <link rel="canonical" href="<?= html($meta->canonicalUrl()) ?>">
<?php endif ?>
