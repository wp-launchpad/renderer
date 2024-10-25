<?php

$html = <<<HTML
<html>
<head>test</head>
<body>

</body>
</html>
HTML;


return [
    'vfs_dir' => '/',
    'structure' => [
        'templates' => [
            'my-view.php' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/templates/my-view.php')
        ],
    ],
    'test_data' => [
        'ShouldRenderAndCreateCacheWhenNoCache' => [
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
                        'exists' => true,
                        'content' => $html
                    ],
                ],
                'print' => $html
            ]
        ],
        'ShouldPrintCacheWhenCache' => [
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
                'print' => file_get_contents(LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/my-view-d751713988987e9331980363e24189ce.html')
            ]
        ],
    ]
];