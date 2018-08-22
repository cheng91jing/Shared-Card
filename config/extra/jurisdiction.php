<?php
/**
 * 权限列表
 */
return [
    [
        'name' => '系统',
        'id' => 'system',
        'nav' => true,
//        'href' => '#',
        'icon' => 'fa fa-cogs',
        'child' => [
            [
                'name' => '管理员操作记录',
                'id' => 'admin/operation',
                'nav' => true,
                'href' => 'admin/operation',
                'permission' => [
                    [
                        'name' => '管理员操作列表',
                        'id' => 'admin/operation/index',
                    ],
                ],
            ],
            [
                'name' => '分润参数管理',
                'id' => 'admin/parameters',
                'nav' => true,
                'href' => 'admin/parameters',
                'permission' => [
                    [
                        'name' => '分润参数列表',
                        'id' => 'admin/parameters/index',
                    ],
                    [
                        'name' => '分润参数修改',
                        'id' => 'admin/parameters/updateparams',
                    ],
                ],
            ],
            [
                'name' => '后台账号管理',
                'id' => 'system-administrator',
                'nav' => true,
                'href' => 'admin/administrator',
                'permission' => [
                    [
                        'name' => '管理员列表',
                        'id' => 'admin/administrator/index',
                    ],
                    [
                        'name' => '新增管理员',
                        'id' => 'admin/administrator/addadmin',
                    ],
                    [
                        'name' => '修改管理员',
                        'id' => 'admin/administrator/updateadmin',
                    ],
                    [
                        'name' => '删除管理员',
                        'id' => 'admin/administrator/deladmin',
                    ],
                ],
            ],
            [
                'name' => '后台角色管理',
                'id' => 'admin/jurisdiction',
                'nav' => true,
                'href' => 'admin/jurisdiction',
                'permission' => [
                    [
                        'name' => '权限列表',
                        'id' => 'admin/jurisdiction/index',
                    ],
                    [
                        'name' => '新增身份',
                        'id' => 'admin/jurisdiction/addidentity',
                    ],
                    [
                        'name' => '修改身份',
                        'id' => 'admin/jurisdiction/identitydetail',
                    ],
                    [
                        'name' => '删除身份',
                        'id' => 'admin/jurisdiction/delidentity',
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