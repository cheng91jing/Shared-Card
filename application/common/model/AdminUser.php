<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/20
 * Time: 16:14
 * Email: 654807719@qq.com
 */

namespace app\common\model;
use app\common\library\PasswordHandler;

/**
 * 后台用户表
 * Class AdminUser
 * @author Chen <654807719@qq.com>
 * @package app\common\model
 *
 * @property integer $admin_id
 * @property string $username 用户名
 * @property string $mobile 手机号
 * @property integer $partner_id 合伙人ID（商家ID）
 * @property integer $identity_id 身份ID
 * @property string $permission_ids 权限ID组
 * @property string $password 密码
 * @property string auth_code 鉴权随机字符串
 * @property string $login_code 登录状态鉴权随机数
 * @property string $create_time 创建时间
 * @property string $login_time 上次登录时间
 * @property string $login_ip 登录IP
 */
class AdminUser extends Base
{
    public static function getUserForLogin($username, $password)
    {
        $user = self::where(['username|mobile' => $username])->find();
//        if(!empty($user)){
//            if(PasswordHandler::verify($password))
//        }
        return false;
    }
}