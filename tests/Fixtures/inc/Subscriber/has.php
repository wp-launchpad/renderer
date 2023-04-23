<?php
return [
    'cacheDisabledShouldReturnFalse' => [
        'config' => [
              'template' => 'view',
              'configurations' => [],
              'renderer_cache_enabled' => false,
              'properties' => [
                  'renderer_cache_enabled' => false,
              ],
              'json' => 'json',
              'hash' => 'hash',
            'has_cache_hit' =>  false,
        ],
        'expected' => [
            'result' => false,
            'parameters' => [

            ],
            'json' => 'json',
            'key' => 'view-hash'
        ]
    ],
    'cacheEnabledAndHitShouldReturnTrue' => [
        'config' => [
            'template' => 'view',
            'configurations' => [],
            'renderer_cache_enabled' => true,
            'properties' => [
                'renderer_cache_enabled' => true,
            ],
            'json' => 'json',
            'hash' => 'hash',
            'has_cache_hit' =>  true,
        ],
        'expected' => [
            'result' => true,
            'parameters' => [

            ],
            'json' => 'json',
            'key' => 'view-hash'
        ]
    ],
    'cacheEnabledWithoutHitShouldReturnFalse' => [
        'config' => [
            'template' => 'view',
            'configurations' => [],
            'renderer_cache_enabled' => true,
            'properties' => [
                'renderer_cache_enabled' => true,
            ],
            'json' => 'json',
            'hash' => 'hash',
            'has_cache_hit' =>  false,
        ],
        'expected' => [
            'result' => false,
            'parameters' => [

            ],
            'json' => 'json',
            'key' => 'view-hash'
        ]
    ],

];
