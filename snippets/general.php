<title><?= $meta->title()->html() ?></title>

<?php if ($meta->description()->isNotEmpty()): ?>
    <?php if (\FabianMichael\Meta\Helper::isSmartyPantsEnabled()): ?>
        <meta name="description" content="<?= $meta->description()->smartypants() ?>">
    <?php else: ?>
        <meta name="description" content="<?= html($meta->description()) ?>">
    <?php endif ?>
<?php endif ?>

<?php if ($themeColor = \FabianMichael\Meta\Helper::themeColor()): ?>
    <meta name="theme-color" content="<?= html($themeColor) ?>">
<?php endif ?>