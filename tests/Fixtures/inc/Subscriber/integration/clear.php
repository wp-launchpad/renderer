<?php
return [
    'vfs_dir' => '/',
    'structure' => [
        'cache' => [],
        'templates' => [
            'my-view.php' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/templates/my-view.php')
        ],
    ],
    'test_data' => [
        'launchpad_clean_all_templatesShouldClean' => [
            'config' => [
                'hook' => 'launchpad_clean_all_templates',
                'cache' => [
                    'cache/my-view-d751713988987e9331980363e24189ce.html' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/my-view-d751713988987e9331980363e24189ce.html'),
                    'cache/my-view-d751713988987e9331980363e24189ced.html' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/my-view-d751713988987e9331980363e24189ce.html')
                ]
            ],
            'expected' => [
                'files' => [
                    'cache/my-view-d751713988987e9331980363e24189ce.html' => [
                        'exists' => false,
                    ],
                    'cache/my-view-d751713988987e9331980363e24189ced.html' => [
                        'exists' => false,
                    ],
                ],
            ]
        ],
        'prefix_clean_all_templatesShouldClean' => [
            'config' => [
                'hook' => 'prefix_clean_all_templates',
                'cache' => [
                    'cache/my-view-d751713988987e9331980363e24189ce.html' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/my-view-d751713988987e9331980363e24189ce.html'),
                    'cache/my-view-d751713988987e9331980363e24189ced.html' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/my-view-d751713988987e9331980363e24189ce.html')
                ]
            ],
            'expected' => [
                'files' => [
                    'cache/my-view-d751713988987e9331980363e24189ce.html' => [
                        'exists' => false,
                    ],
                    'cache/my-view-d751713988987e9331980363e24189ced.html' => [
                        'exists' => false,
                    ],
                ],
            ]
        ]
    ],
];