<?php

return [
    'ckeditor' => [
        // CKEditor core script (full distribution stays in each app's public/packages/ckeditor).
        'editor_url' => 'packages/ckeditor/ckeditor.js',
    ],
    'backup' => [
        'exclude_tables' => env('AMPLIFY_BACKUP_EXCLUDE_TABLES', ''),
    ],
];
