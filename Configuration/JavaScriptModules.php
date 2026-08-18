<?php

return [
    'dependencies' => ['backend', 'rte_ckeditor'],
    'tags' => [
        'backend.form',
    ],
    'imports' => [
        '@univie/rte-ckeditor-abbr/abbreviation.js' => 'EXT:univie_rte_abbr/Resources/Public/JavaScript/abbreviation.js',
    ],
];
