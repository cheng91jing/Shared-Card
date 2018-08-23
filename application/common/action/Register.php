<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/21
 * Time: 11:28
 * Email: 654807719@qq.com
 */

namespace app\common\action;
use app\common\library\AuthHandler;
use app\common\model\AdminUser;

/**
 * 注册
 * Class Register
 * @author Chen <654807719@qq.com>
 * @package app\common\action
 */
class Register
{
    public static function adminRegister()
    {
        $user_model = new AdminUser();
        $user_model->username = 'admin';
        $user_model->mobile = '18423031505';
//        $user_model->partner_id =
//        $user_model->identity_id =
        $user_model->auth_code = generate_rand_str(10, true);

        $user_model->password = AuthHandler::generateHash('admin', [$user_model->auth_code]);
        $user_model->save();
        return $user_model;
    }

    public static function register($mobile)
    {

    }
}