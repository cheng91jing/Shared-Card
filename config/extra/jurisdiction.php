<?php
/**
 * 权限列表
 */
return [
    [
        'name'  => '会员',
        'id'    => 'member',
        'nav'   => true,
        'icon'  => 'fa fa-users-cog',
        'news'  => '管理员专属',
        'special' => 2,
        'child' => [
            [
                'name'       => '用户管理',
                'id'         => 'member-user',
                'nav'        => true,
                'href'       => 'admin/member',
                'permission' => [
                    [
                        'name' => '列表',
                        'id'   => 'member-user-list',
                    ],
                    [
                        'name' => '新增',
                        'id'   => 'member-user-add',
                    ],
                    [
                        'name' => '信息',
                        'id'   => 'member-user-info',
                    ],
                ],
            ],
            [
                'name'       => '用户账单',
                'id'         => 'member-bill',
                'nav'        => true,
                'href'       => 'admin/bill',
                'permission' => [
                    [
                        'name' => '列表',
                        'id'   => 'member-bill-list',
                    ]
                ],
            ],
        ],
    ],
    [
        'name'  => '商家',
        'id'    => 'merchant',
        'nav'   => true,
        'icon'  => 'fa fa-hotel',
        'news'  => '管理员专属',
        'special' => 2,
        'child' => [
            [
                'name'       => '商家管理',
                'id'         => 'merchant-partner',
                'nav'        => true,
                'href'       => 'admin/merchant',
                'permission' => [
                    [
                        'name' => '列表',
                        'id'   => 'merchant-partner-list',
                    ],
                    [
                        'name' => '信息[增/改]',
                        'id'   => 'merchant-partner-info',
                    ],
                    [
                        'name' => '状态修改',
                        'id'   => 'merchant-partner-status',
                    ],
                    [
                        'name' => '删除',
                        'id'   => 'merchant-partner-del',
                    ],
                ],
            ],
        ],
    ],
    [
        'name'  => '商品',
        'id'    => 'goods',
        'nav'   => true,
        'icon'  => 'fa fa-shopping-cart',
        'child' => [
            [
                'name'       => '商品管理',
                'id'         => 'goods-goods',
                'nav'        => true,
                'href'       => 'admin/goods',
                'permission' => [
                    [
                        'name' => '商品列表',
                        'id'   => 'goods-goods-list',
                    ],
                    [
                        'name' => '商品信息',
                        'id'   => 'goods-goods-info',
                        'news'  => '商家专属',
                        'special' => 1,
                    ],
                ],
            ],
            [
                'name'       => '商品分类',
                'id'         => 'goods-category',
                'nav'        => true,
                'href'       => 'admin/goods_cat',
                'news'  => '管理员专属',
                'special' => 2,
                'permission' => [
                    [
                        'name' => '分类列表',
                        'id'   => 'goods-category-list',
                    ],
                    [
                        'name' => '分类信息[增/改]',
                        'id'   => 'goods-category-info',
                    ],
                    [
                        'name' => '分类删除',
                        'id'   => 'goods-category-del',
                    ],
                ],
            ],
            [
                'name'       => '酒店管理',
                'id'         => 'goods-hotel',
                'nav'        => true,
                'href'       => 'admin/hotel',
//                'news'  => '管理员专属',
//                'special' => 2,
                'permission' => [
                    [
                        'name' => '酒店列表',
                        'id'   => 'goods-hotel-table',
                        'news'  => '管理员专属',
                        'special' => 2,
                    ],
                    [
                        'name' => '酒店信息[增/改]',
                        'id'   => 'goods-hotel-info',
                    ],
                    [
                        'name' => '酒店删除',
                        'id'   => 'goods-hotel-del',
                    ],
                ],
            ],
        ],
    ],
    [
        'name'  => '交易',
        'id'    => 'trade',
        'nav'   => true,
        'icon'  => 'fa fa-hand-holding-usd',
        'child' => [
            [
                'name'       => '线下消费',
                'id'         => 'trade-offline',
                'nav'        => true,
                'href'       => 'admin/offline',
                'news'  => '商家专属',
                'special' => 1,
                'permission' => [
                    [
                        'name' => '扣款操作',
                        'id'   => 'trade-offline-reduce',
                    ],
                ],
            ],
            [
                'name'       => '订单管理',
                'id'         => 'trade-order',
                'nav'        => true,
                'href'       => 'admin/order',
                'permission' => [
                    [
                        'name' => '订单列表',
                        'id'   => 'trade-order-list',
                    ],
                    [
                        'name' => '订单详情',
                        'id'   => 'trade-order-info',
                    ],
                ],
            ],
        ],
    ],
    [
        'name'  => '会员卡',
        'id'    => 'card',
        'nav'   => true,
        'icon'  => 'fa fa-address-card',
        'news'  => '管理员专属',
        'special' => 2,
        'child' => [
            [
                'name'       => '会员卡分类',
                'id'         => 'card-category',
                'nav'        => true,
                'href'       => 'admin/card',
                'permission' => [
                    [
                        'name' => '列表',
                        'id'   => 'card-category-list',
                    ],
                    [
                        'name' => '信息[增/改]',
                        'id'   => 'card-category-info',
                    ],
                    [
                        'name' => '状态修改',
                        'id'   => 'card-category-status',
                    ],
                    [
                        'name' => '删除',
                        'id'   => 'card-category-del',
                    ],
                ],
            ],
            [
                'name'       => '用户会员卡',
                'id'         => 'card-user',
                'nav'        => true,
                'href'       => 'admin/card_user',
                'permission' => [
                    [
                        'name' => '列表',
                        'id'   => 'card-user-list',
                    ],
                    [
                        'name' => '信息',
                        'id'   => 'card-user-info',
                    ],
                    [
                        'name' => '批量发放',
                        'id'   => 'card-user-grant',
                    ],
                    [
                        'name' => '批量生成',
                        'id'   => 'card-user-batch',
                    ],
                    [
                        'name' => '状态修改',
                        'id'   => 'card-user-status',
                    ],
                    [
                        'name' => '删除',
                        'id'   => 'card-user-del',
                    ],
                ],
            ],
        ],
    ],
    [
        'name'  => '系统',
        'id'    => 'system',
        'nav'   => true,
        //        'href' => '#',
        'icon'  => 'fa fa-cogs',
        'child' => [
            [
                'name'       => '后台账号管理',
                'id'         => 'system-administrator',
                'nav'        => true,
                'href'       => 'admin/administrator',
                'permission' => [
                    [
                        'name' => '管理员列表',
                        'id'   => 'system-administrator-list',
                    ],
                    [
                        'name' => '管理员信息[增/改]',
                        'id'   => 'system-administrator-info',
                    ],
                    [
                        'name' => '管理员商家设置',
                        'id'   => 'system-administrator-partner',
                    ],
                    [
                        'name' => '管理员权限分配',
                        'id'   => 'system-administrator-permission',
                    ],
                    [
                        'name' => '删除管理员',
                        'id'   => 'system-administrator-del',
                    ],
                ],
            ],
            [
                'name'       => '后台角色管理',
                'id'         => 'system-role',
                'nav'        => true,
                'href'       => 'admin/jurisdiction',
                'news'  => '管理员专属',
                'special' => 2,
                'permission' => [
                    [
                        'name' => '角色列表',
                        'id'   => 'system-role-list',
                    ],
                    [
                        'name' => '角色信息[增/改]',
                        'id'   => 'system-role-info',
                    ],
                    [
                        'name' => '角色权限分配',
                        'id'   => 'system-role-permission',
                    ],
                    [
                        'name' => '删除角色',
                        'id'   => 'system-role-del',
                    ],
                ],
            ],
            //            [
            //                'name' => '数据库操作',
            //                'id' => 'admin/database',
            //                'nav' => true,
            //                'href' => 'admin/database',
            //                'permission' => [
            //                    [
            //                        'name' => '备份文件列表',
            //                        'id' => 'admin/database/index',
            //                    ],
            //                    [
            //                        'name' => '数据库表列表',
            //                        'id' => 'admin/database/manualbackup',
            //                    ],
            //                    [
            //                        'name' => '手动备份',
            //                        'id' => 'admin/database/runbackup',
            //                    ],
            //                    [
            //                        'name' => '删除备份',
            //                        'id' => 'admin/database/delbackup',
            //                    ],
            //                    [
            //                        'name' => '下载备份文件',
            //                        'id' => 'admin/database/downloadbackup',
            //                    ],
            //                ],
            //            ],
        ],
    ],
];