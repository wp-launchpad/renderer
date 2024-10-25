<?php
return [
    'shouldReturnResult' => [
        'config' => [
            'properties' => [
                'root_directory' => 'root_directory'
            ],
            'key' => 'key',
            'result' => false,
        ],
        'expected' => [
            'path' => 'root_directory/key.html',
            'result' => false,
        ]
    ],

];
