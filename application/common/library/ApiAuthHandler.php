<?php

namespace app\common\library;

use think\Session;

/**
 * Class ApiAuthHandler
 * API授权助手
 * @package app\common\library
 */
class ApiAuthHandler
{
    /**
     * 获取验证的session
     * @return mixed
     */
    public static function getWebToken()
    {
        if(! Session::has('index_web_token', 'common'))
            Session::set('index_web_token', generate_rand_str(40), 'common');
        return Session::get('index_web_token', 'common');
    }


    /**
     * 验证token
     * @param $token
     * @return bool
     */
    public static function verifyWebToken($token)
    {
        if(Session::has('index_web_token', 'common')){
            return Session::get('index_web_token', 'common') === $token;
        }
        return false;
    }
}