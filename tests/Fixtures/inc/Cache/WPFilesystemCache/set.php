<?php
return [
    'shouldSetTheValue' => [
        'config' => [
              'key' => 'key',
              'value' => 'value',
              'ttl' => null,
              'properties' => [
                  'root_directory' => 'root_directory'
              ]
        ],
        'expected' => [
            'directory' => 'root_directory',
            'path' => 'root_directory/key.html',
            'content' => 'value',
        ]
    ],

];
