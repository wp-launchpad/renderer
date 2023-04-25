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
    'structure' => [],
    'test_data' => [
        '' => [
            'config' => [
                'template' => 'my-view',
                'configurations' => [

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
        ]
    ]
];