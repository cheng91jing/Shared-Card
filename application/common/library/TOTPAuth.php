<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/27
 * Time: 10:43
 * Email: 654807719@qq.com
 */

namespace app\common\library;


use app\common\library\totp\Base32;
use app\common\library\totp\Google2FA;

class TOTPAuth
{
    /**
     * 获取当前 6 位动态口令
     *
     * @param $secret
     *
     * @return string
     * @throws \think\Exception
     */
    public static function getDynamicCode($secret)
    {
        $TimeStamp = Google2FA::get_timestamp();
        return Google2FA::oath_hotp($secret, $TimeStamp);
    }

    public static function verifySecret($secret, $dynamic)
    {
        $base32 = str_replace('=', '', Base32::encode($secret));
        return Google2FA::verify_key($base32, $dynamic);
    }
}