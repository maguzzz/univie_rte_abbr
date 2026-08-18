<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'CKEditor Abbreviation (TYPO3 13 fork)',
    'description' => 'Independent TYPO3 13 / CKEditor 5 fork of Studio Mitte rte_ckeditor_abbr. Original work by Georg Ringer and Wolfgang Höller. Licensed under GPL-2.0-or-later.',
    'category' => 'be',
    'state' => 'stable',
    'author' => 'Georg Ringer, Wolfgang Höller',
    'version' => '1.2.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
            'rte_ckeditor' => '12.4.0-13.4.99'
        ],
    ],
];
