<?php
/**
 * 自定义配置示例
 * 所有配置仅支持二级读取  customize.aaa
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/17
 * Time: 10:30
 * Email: 654807719@qq.com
 */

use think\Env;

return [
    /**
     * 阿里云短信配置
     */
    'aliyun_sms' => [
        'access_key' => Env::get('aliyun_sms_key', null),
        'access_key_secret' => Env::get('aliyun_sms_secret', null),
    ],
];