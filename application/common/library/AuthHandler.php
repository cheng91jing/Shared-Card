<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/20
 * Time: 17:15
 * Email: 654807719@qq.com
 */

namespace app\common\library;

use Exception;

class AuthHandler
{
    /**
     * 生成密码哈希散列
     * @param $password
     * @param array $otherImplode
     *
     * @return bool|string
     * @throws Exception
     */
    public static function generateHash($password, array $otherImplode = [])
    {
        $otherString = implode("", $otherImplode);
        $encryptString = $password .$otherString;
        $hash = password_hash($encryptString, PASSWORD_DEFAULT);
        if($hash === false) throw new Exception('密码加密失败！');
        return $hash;
    }

    /**
     * 验证用户密码
     * @param $password
     * @param $hash
     * @param array $otherImplode
     *
     * @return bool
     */
    public static function verify($password, $hash, array $otherImplode = [])
    {
        $otherString = implode("", $otherImplode);
        $encryptString = $password .$otherString;
        return password_verify($encryptString, $hash);
    }
}