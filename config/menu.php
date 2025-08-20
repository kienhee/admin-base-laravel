<?php
return [
    [
        'title' => 'Dashboard',
        'icon' => 'bx-home-circle',
        'url' => 'admin.dashboard.analytics',
        'badge' => 1,
    ],
    [
        'title' => 'Bài viết',
        'icon' => 'bx-file',
        'children' => [
            [
                'title' => 'Danh sách',
                'url' => 'admin.blog.list',
            ],
            [
                'title' => 'Thêm mới',
                'url' => 'admin.blog.create',
            ],
        ],
    ]

];
