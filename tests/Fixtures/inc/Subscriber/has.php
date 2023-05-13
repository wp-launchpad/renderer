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
            'cache_parameters' => [],
            'json' => 'json',
              'hash' => 'hash',
            'has_cache_hit' =>  false,
        ],
        'expected' => [
            'result' => false,
            'parameters' => [

            ],
            'json' => 'json',
            'key' => 'view-d751713988987e9331980363e24189ce'
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
            'cache_parameters' => [],
            'json' => 'json',
            'hash' => 'hash',
            'has_cache_hit' =>  true,
        ],
        'expected' => [
            'result' => true,
            'parameters' => [

            ],
            'json' => 'json',
            'key' => 'view-d751713988987e9331980363e24189ce'
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
            'cache_parameters' => [],
            'json' => 'json',
            'hash' => 'hash',
            'has_cache_hit' =>  false,
        ],
        'expected' => [
            'result' => false,
            'parameters' => [

            ],
            'json' => 'json',
            'key' => 'view-d751713988987e9331980363e24189ce'
        ]
    ],

];
