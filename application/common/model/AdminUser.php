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

use app\common\library\AuthHandler;
use think\Request;

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
    /**
     * 获取后台登陆用户
     *
     * @param $username
     * @param $password
     *
     * @return bool|null|static
     * @throws \think\exception\DbException
     */
    public static function verificationOfLogin($username, $password)
    {
        $user = self::get(['username|mobile' => $username]);
        if (! empty($user)) {
            if (AuthHandler::verify($password, $user->password, [$user->auth_code])) {
                return $user;
            }
        }
        return false;
    }

    //用户登陆
    public function login()
    {
        //生成登陆鉴权码
        $this->login_code = generate_rand_str(10, true);
        $this->login_ip   = Request::instance()->ip();
        $this->login_time = date('Y-m-d H:i:s');
        $this->save();

        return $this;
    }
}