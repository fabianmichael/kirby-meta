<title><?= html($meta->title()) ?></title>

<?php if ($description = $meta->description()): ?>
    <meta name="description" content="<?= html($description) ?>">
<?php endif ?>

<?php if ($themeColor = \FabianMichael\Meta\Helper::themeColor()): ?>
    <meta name="theme-color" content="<?= html($themeColor) ?>">
<?php endif ?>
