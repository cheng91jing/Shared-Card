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
use think\Exception;

/**
 * 用户表
 * Class AdminUser
 * @package app\common\model
 *
 * @property integer $id
 * @property string $mobile 手机号
 * @property string $password 密码
 * @property string $auth_code 鉴权随机字符串
 * @property string $login_code 登录状态鉴权随机数
 * @property string $create_time 创建时间
 * @property string $login_time 上次登录时间
 * @property string $login_ip 登录IP
 */
class User extends BaseUser
{
    /**
     * @return \think\model\relation\HasMany
     */
    public function cards()
    {
        return $this->hasMany(UserCard::class, 'user_id', 'id');
    }
    
    /**
     * 前端用户账户信息创建更新
     * @param string $mobile 手机号
     * @param null|string $password 密码
     *
     * @return $this
     * @throws Exception
     * @throws \think\exception\DbException
     */
    public function account($mobile, $password = null)
    {
        if(empty($mobile)) throw new Exception('未填写手机号');
        if(empty($this->id) && empty($password)) throw new Exception('创建账号密码必须填写');
        if(!empty($this->mobile) && $this->getAttr('mobile') !== $mobile){
            $user_mobile = self::get(['mobile' => $mobile]);
            if($user_mobile) throw new Exception('手机号已被使用！');
        }
        $this->mobile = $mobile;
        if(empty($this->auth_code))
            $this->auth_code = generate_rand_str(10, true);
        if(!empty($password))
            $this->password = AuthHandler::generateHash($password, [$this->auth_code]);
        $this->save();
        return $this;
    }
}