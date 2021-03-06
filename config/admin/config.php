<?php
//后台模块配置

return [
    //会话设置
    'session'                => [
        'prefix'         => 'admin',
        'type'           => '',
        'auto_start'     => true,
    ],
    'template'               => [
        'taglib_pre_load'     =>    'app\common\library\tag\Auth',
    ],

    // +----------------------------------------------------------------------
    // | Cookie设置
    // +----------------------------------------------------------------------
//    'cookie'                 => [
//        // cookie 名称前缀
//        'prefix'    => '',
//        // cookie 保存时间
//        'expire'    => 0,
//        // cookie 保存路径
//        'path'      => '/',
//        // cookie 有效域名
//        'domain'    => '',
//        //  cookie 启用安全传输
//        'secure'    => false,
//        // httponly设置
//        'httponly'  => '',
//        // 是否使用 setcookie
//        'setcookie' => true,
//    ],
];
