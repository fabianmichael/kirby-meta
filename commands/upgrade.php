<?php

use FabianMichael\Meta\Upgrade;
use Kirby\CLI\CLI;

return [
    'description' => 'Upgrade Meta content from 2.x to 3.0',
    'args' => [
        'apply' => [
            'prefix' => 'a',
            'longPrefix' => 'apply',
            'description' => 'Write content changes (default is dry-run)',
            'noValue' => true,
        ],
        'migrate-indexing' => [
            'longPrefix' => 'migrate-indexing',
            'description' => 'Opt in: set robots_index=0 on pages that 2.x excluded from the sitemap (unlisted, exclude lists, non-indexable parents)',
            'noValue' => true,
        ],
    ],
    'command' => function (CLI $cli): void {
        $upgrade = new Upgrade(
            $cli->kirby(),
            apply: $cli->arg('apply') === true,
            shouldMigrateIndexing: $cli->arg('migrate-indexing') === true,
        );

        $upgrade->run($cli);
    },
];
