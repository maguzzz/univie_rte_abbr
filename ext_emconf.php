<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'CKEditor Abbreviation',
    'description' => 'Independent TYPO3 13 / CKEditor 5 fork of Studio Mitte rte_ckeditor_abbr. Insert abbreviations in the rich-text editor.',
    'category' => 'be',
    'state' => 'stable',
    'author' => 'Maguzzz',
    'version' => '1.2.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
            'rte_ckeditor' => '12.4.0-13.4.99',
        ],
    ],
];