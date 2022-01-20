<?php if (($json = $meta->jsonld()) && empty($json) === false): ?>
<script type="application/ld+json"><?php
echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | (option('debug') ? JSON_PRETTY_PRINT : 0));
?></script>
<?php endif ?>
