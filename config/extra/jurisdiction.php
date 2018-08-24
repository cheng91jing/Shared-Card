<?php
/**
 * 权限列表
 */
return [
    [
        'name' => '会员',
        'id' => 'member',
        'nav' => true,
        'icon' => 'fa fa-users-cog',
        'child' => [
            [
                'name' => '用户管理',
                'id' => 'member-user',
                'nav' => true,
                'href' => 'admin/member',
                'permission' => [
                    [
                        'name' => '用户列表',
                        'id' => 'member-user-list',
                    ],
                ],
            ],
        ]
    ],
    [
        'name' => '商家',
        'id' => 'merchant',
        'nav' => true,
        'icon' => 'fa fa-hotel',
        'child' => [
            [
                'name' => '商家管理',
                'id' => 'merchant-partner',
                'nav' => true,
                'href' => 'admin/merchant',
                'permission' => [
                    [
                        'name' => '商家列表',
                        'id' => 'merchant-partner-list',
                    ],
                ],
            ],
        ]
    ],
    [
        'name' => '交易',
        'id' => 'trade',
        'nav' => true,
        'icon' => 'fa fa-hand-holding-usd',
        'child' => [
            [
                'name' => '订单管理',
                'id' => 'trade-order',
                'nav' => true,
                'href' => 'admin/order',
                'permission' => [
                    [
                        'name' => '订单列表',
                        'id' => 'trade-order-list',
                    ],
                ],
            ],
        ]
    ],
    [
        'name' => '会员卡',
        'id' => 'card',
        'nav' => true,
        'icon' => 'fa fa-address-card',
        'child' => [
            [
                'name' => '会员卡分类',
                'id' => 'card-category',
                'nav' => true,
                'href' => 'admin/card',
                'permission' => [
                    [
                        'name' => '会员卡分类列表',
                        'id' => 'card-category-list',
                    ],
                ],
            ],
        ]
    ],
    [
        'name' => '系统',
        'id' => 'system',
        'nav' => true,
//        'href' => '#',
        'icon' => 'fa fa-cogs',
        'child' => [
            [
                'name' => '后台账号管理',
                'id' => 'system-administrator',
                'nav' => true,
                'href' => 'admin/administrator',
                'permission' => [
                    [
                        'name' => '管理员列表',
                        'id' => 'system-administrator-list',
                    ],
                    [
                        'name' => '新增管理员',
                        'id' => 'system-administrator-add',
                    ],
                    [
                        'name' => '修改管理员',
                        'id' => 'system-administrator-update',
                    ],
                    [
                        'name' => '删除管理员',
                        'id' => 'system-administrator-del',
                    ],
                ],
            ],
            [
                'name' => '后台角色管理',
                'id' => 'system-role',
                'nav' => true,
                'href' => 'admin/jurisdiction',
                'permission' => [
                    [
                        'name' => '权限列表',
                        'id' => 'system-role-list',
                    ],
                    [
                        'name' => '新增身份',
                        'id' => 'system-role-add',
                    ],
                    [
                        'name' => '修改身份',
                        'id' => 'system-role-update',
                    ],
                    [
                        'name' => '删除身份',
                        'id' => 'system-role-del',
                    ],
                ],
            ],
            [
                'name' => '数据库操作',
                'id' => 'admin/database',
                'nav' => true,
                'href' => 'admin/database',
                'permission' => [
                    [
                        'name' => '备份文件列表',
                        'id' => 'admin/database/index',
                    ],
                    [
                        'name' => '数据库表列表',
                        'id' => 'admin/database/manualbackup',
                    ],
                    [
                        'name' => '手动备份',
                        'id' => 'admin/database/runbackup',
                    ],
                    [
                        'name' => '删除备份',
                        'id' => 'admin/database/delbackup',
                    ],
                    [
                        'name' => '下载备份文件',
                        'id' => 'admin/database/downloadbackup',
                    ],
                ],
            ],
        ],
    ]
];