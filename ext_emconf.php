<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'CKEditor Plugin for abbr tag',
    'description' => 'Add Abbreviations information through the ckeditor',
    'category' => 'be',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'author' => 'Georg Ringer',
    'author_email' => 'gr@studiomitte.com',
    'version' => '1.0.4',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
            'rte_ckeditor' => '12.4.0-13.4.99'
        ],
    ],
];
