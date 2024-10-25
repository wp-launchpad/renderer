<?php
return [
    '' => [
        'config' => [
              'values' => [
                  'key' => 'value',
                  'key2' => 'value2',
              ],
              'ttl' => null,
        ],
        'expected' => [
            'values' => [
                'key' => 'value',
                'key2' => 'value2',
            ],
            'ttl' => null,
        ]
    ],

];
