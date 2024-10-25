<?php
return [
    'doesNotExistsShouldReturnDefault' => [
        'config' => [
              'default' => null,
              'exists' => false,
              'content' => 'content',
              'key' => 'key',
              'properties' => [
                  'root_directory' => 'root_directory'
              ]
        ],
        'expected' => [
              'result' => null,
              'path' => 'root_directory/key.html',
        ]
    ],
    'existsShouldReturnValue' => [
        'config' => [
            'default' => null,
            'exists' => true,
            'content' => 'content',
            'key' => 'key',
            'properties' => [
                'root_directory' => 'root_directory'
            ]
        ],
        'expected' => [
            'result' => 'content',
            'path' => 'root_directory/key.html',
        ]
    ],

];
