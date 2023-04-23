<?php
return [
    'shouldDeletePath' => [
        'config' => [
            'properties' => [
                'root_directory' => 'root_directory'
            ],
            'key' => 'key'
        ],
        'expected' => [
            'path' => 'root_directory/key.html'
        ]
    ],

];
