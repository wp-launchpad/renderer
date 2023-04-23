<?php
return [
    'shouldReturnEvents' => [
        'config' => [
            'properties' => [
                'prefix' => 'lchpd',
            ]
        ],
        'expected' => [
                "lchpd_has_template" => ['has', 10, 2],
                "lchpd_render_template" => ['render', 10 , 2],
                "lchpd_delete_template" => ['delete', 10, 2],
                "lchpd_clean_all_templates" => 'clear',
                'launchpad_clean_all_templates' => 'clear',
        ]
    ],

];
