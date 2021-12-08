<title><?= $meta->title()->html() ?></title>

<meta name="description" content="<?= $meta->description()->html() ?>">

<?php if ($themeColor = option('fabianmichael.meta.theme.color')): ?>
    <meta name="theme-color" content="<?= $themeColor ?>">
<?php endif ?>
