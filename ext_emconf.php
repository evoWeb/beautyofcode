<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'beautyOfCode Syntax Highlighter',
    'description' => 'This plugin provides Java-Script based, state-of-the-art, feature rich syntax highlighting by using SyntaxHighlighter or Prism. t3editor enabled.',
    'category' => 'plugin',
    'shy' => 0,
    'version' => '4.0.0-dev',
    'priority' => '',
    'loadOrder' => '',
    'module' => '',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearcacheonload' => 0,
    'lockType' => '',
    'author' => 'Felix Nagel',
    'author_email' => 'info@felixnagel.com',
    'constraints' => [
        'depends' => [
            'php' => '7.2.0-7.2.99',
            'typo3' => '9.5.0-9.5.99',
            't3editor' => '9.5.0-9.5.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
];
