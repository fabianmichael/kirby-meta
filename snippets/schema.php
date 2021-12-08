<?php if (($json = $meta->jsonld()) && empty($json) === false): ?>
<script type="application/ld+json">
<?= json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?>
</script>
<?php endif ?>
