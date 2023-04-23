<?php
return [
    'getShouldReturnValues' => [
        'config' => [
              'default' => null,
              'values' => [
                  'key',
                  'key1'
              ],
        ],
        'expected' => [
            'values' => [
                'key' => null,
                'key1' => 'value'
            ],
            'default' => null,
            'results' => [
                'key' => null,
                'key1' => 'value'
            ]
        ]
    ],

];
