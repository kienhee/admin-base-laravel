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
    ],
    [
        'title' => 'Bán hàng',
        'icon' => 'bx-cart-alt',
        'children' => [
            [
                'title' => 'Thêm mới',
                'url' => 'admin.ecommerce.create',
            ],
        ],
    ],
    [
        'title' => 'Media',
        'icon' => 'bx-image',
        'url' => 'admin.media',
    ],

];
