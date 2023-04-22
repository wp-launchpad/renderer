<?php
return [
    'vfs_dir' => '/',
    'structure' => [
        'view.php' => file_get_contents(__DIR__ . '/content.php')
    ],
    'test_data' => [
        '' => [
            'config' => [
                  'template' => '',
                  'parameters' => [],

            ],
            'expected' => [

            ]
        ],
    ],
];
