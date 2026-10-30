<?php

use FabianMichael\Meta\Fields\MetaFilesField;
use FabianMichael\Meta\Fields\MetaRangeField;
use FabianMichael\Meta\Fields\MetaRobotsIndexTogglesField;
use FabianMichael\Meta\Fields\MetaSelectField;
use FabianMichael\Meta\Fields\MetaSharePreviewField;
use FabianMichael\Meta\Fields\MetaTextField;
use FabianMichael\Meta\Fields\MetaUrlField;

return [
    'meta-text' => MetaTextField::class,
    'meta-range' => MetaRangeField::class,
    'meta-select' => MetaSelectField::class,
    'meta-robots-index-toggles' => MetaRobotsIndexTogglesField::class,
    'meta-url' => MetaUrlField::class,
    'meta-files' => MetaFilesField::class,
    'meta-share-preview' => MetaSharePreviewField::class,
];
