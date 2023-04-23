<?php
return [
    'vfs_dir' => '/',
    'structure' => [
        'view.php' => file_get_contents(__DIR__ . '/content.php')
    ],
    'test_data' => [
        '' => [
            'config' => [
                  'template' => 'view',
                  'parameters' => [
                      'title' =>  'My title',
                      'description' => 'My body'
                  ],
            ],
            'expected' => file_get_contents(__DIR__ . '/output.html'),
        ],
    ],
];
