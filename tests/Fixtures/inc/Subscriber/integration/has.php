<?php
return [
    'vfs_dir' => '/',
    'structure' => [
        'templates' => [
            'my-view.php' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/templates/my-view.php')
        ],
    ],
    'test_data' => [
        'noCacheShouldReturnFalse' => [
            'config' => [
                'template' => 'my-view',
                'configurations' => [

                ],
                'cache' => [
                ]
            ],
            'expected' => [
                'files' => [
                    'my-view-d751713988987e9331980363e24189ce.html' => [
                        'exists' => false,
                    ],
                ],
                'output' => false
            ]
        ],
        'CacheShouldReturnTrue' => [
            'config' => [
                'template' => 'my-view',
                'configurations' => [

                ],
                'cache' => [
                    'my-view-d751713988987e9331980363e24189ce.html' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/my-view-d751713988987e9331980363e24189ce.html')
                ]
            ],
            'expected' => [
                'files' => [
                    'my-view-d751713988987e9331980363e24189ce.html' => [
                        'exists' => true,
                        'content' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/my-view-d751713988987e9331980363e24189ce.html')
                    ],
                ],
                'output' => true
            ]
        ]
    ],
];