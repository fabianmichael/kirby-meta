<title><?= $meta->title()->html() ?></title>

<?php if ($meta->description()->isNotEmpty()): ?>
    <meta name="description" content="<?= $meta->description()->escape('attr') ?>">
<?php endif ?>

<?php if ($themeColor = \FabianMichael\Meta\Helper::themeColor()): ?>
    <meta name="theme-color" content="<?= esc($themeColor, 'attr') ?>">
<?php endif ?>
