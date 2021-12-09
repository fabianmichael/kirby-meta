<title><?= $meta->title()->html() ?></title>

<?php if ($meta->description()->isNotEmpty()): ?>
<meta name="description" content="<?= $meta->description()->html() ?>">
<?php endif ?>

<?php if ($themeColor = option('fabianmichael.meta.theme.color')): ?>
<meta name="theme-color" content="<?= $themeColor ?>">
<?php endif ?>
