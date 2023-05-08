<?php
return [
    'onNoCacheShouldReturnContent' => [
        'config' => [
              'properties' => [
                  'renderer_cache_enabled' => false,
              ],
              'template' => 'view',
              'configurations' => [],
              'renderer_cache_enabled' => false,
              'has_cache_hit' => false,
              'cached_content' => 'cached_content',
              'content' => 'content',
              'json' => 'json',
              'hash' => 'hash',
        ],
        'expected' => [
            'content' => 'content',
            'key' => 'view-d751713988987e9331980363e24189ce',
            'json' => 'json',
            'template' => 'view',
            'parameters' => [

            ],
        ]
    ],
    'onCacheWithHitShouldReturnCachedContent' => [
        'config' => [
            'properties' => [
                'renderer_cache_enabled' => true,
            ],
            'template' => 'view',
            'configurations' => [],
            'renderer_cache_enabled' => true,
            'has_cache_hit' => true,
            'cached_content' => 'cached_content',
            'content' => 'content',
            'json' => 'json',
            'hash' => 'hash',
        ],
        'expected' => [
            'content' => 'cached_content',
            'key' => 'view-d751713988987e9331980363e24189ce',
            'json' => 'json',
            'template' => 'view',
            'parameters' => [

            ],
        ]
    ],
    'onCacheWithoutHitShouldReturnContent' => [
        'config' => [
            'properties' => [
                'renderer_cache_enabled' => true,
            ],
            'template' => 'view',
            'configurations' => [],
            'renderer_cache_enabled' => true,
            'has_cache_hit' => false,
            'cached_content' => 'cached_content',
            'content' => 'content',
            'json' => 'json',
            'hash' => 'hash',
        ],
        'expected' => [
            'content' => 'content',
            'key' => 'view-d751713988987e9331980363e24189ce',
            'json' => 'json',
            'template' => 'view',
            'parameters' => [

            ],
        ]
    ],

];
