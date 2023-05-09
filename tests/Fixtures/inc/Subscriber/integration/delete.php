<?php
return [
    'vfs_dir' => '/',
    'structure' => [
        'templates' => [
            'my-view.php' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/templates/my-view.php')
        ],
    ],
    'test_data' => [
        'NotExistShouldDoNothing' => [
            'config' => [
                'template' => 'my-view',
                'configurations' => [

                ],
                'cache' => [
                    'my-view-d751713988987e9331980363e24189ced.html' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/my-view-d751713988987e9331980363e24189ce.html')
                ]
            ],
            'expected' => [
                'files' => [
                    'my-view-d751713988987e9331980363e24189ce.html' => [
                        'exists' => false,
                    ],
                    'my-view-d751713988987e9331980363e24189ced.html' => [
                        'exists' => true,
                        'content' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/my-view-d751713988987e9331980363e24189ce.html')
                    ],
                ],
            ]
        ],
        'ExistingShouldClean' => [
            'config' => [
                'template' => 'my-view',
                'configurations' => [

                ],
                'cache' => [
                    'my-view-d751713988987e9331980363e24189ce.html' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/my-view-d751713988987e9331980363e24189ce.html'),
                    'my-view-d751713988987e9331980363e24189ced.html' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/my-view-d751713988987e9331980363e24189ce.html')
                ]
            ],
            'expected' => [
                'files' => [
                    'my-view-d751713988987e9331980363e24189ce.html' => [
                        'exists' => false,
                    ],
                    'my-view-d751713988987e9331980363e24189ced.html' => [
                        'exists' => true,
                        'content' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/my-view-d751713988987e9331980363e24189ce.html')
                    ],
                ],
            ]
        ]
    ],
];