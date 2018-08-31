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

use think\Exception;

/**
 * 用户表
 * Class AdminUser
 * @package app\common\model
 *
 * @property integer $id
 * @property string $mobile 手机号
 * @property string $auth_code 鉴权随机字符串
 * @property string $login_code 登录状态鉴权随机数
 * @property string $create_time 创建时间
 * @property string $login_time 上次登录时间
 * @property string $login_ip 登录IP
 */
class User extends BaseUser
{
    protected $append = [
        'mobile_show'
    ];

    public function getMobileShowAttr($value, $data)
    {
        return $this->mobile ? substr_replace($this->mobile, '****', 3, 4) : '';
    }

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
     *
     * @return $this
     * @throws Exception
     * @throws \think\exception\DbException
     */
    public function account($mobile)
    {
        if(empty($this->mobile) || $this->getAttr('mobile') !== $mobile){
            $user_mobile = self::get(['mobile' => $mobile]);
            if($user_mobile) throw new Exception('手机号已被使用！');
        }
        $this->mobile = $mobile;
        $this->auth_code = generate_rand_str(10, true);
        if(! $this->create_time) $this->create_time = date('Y-m-d H:i:s');
        $this->save();
        return $this;
    }

    /**
     * 校验手机号与验证码用户
     * @param $mobile
     * @param $code
     *
     * @return $this|null|static
     * @throws Exception
     * @throws \think\exception\DbException
     */
    public static function verifyMobileCode($mobile, $code)
    {
        $user = self::get(['mobile' => $mobile]);
        if(empty($user)) $user = (new self)->account($mobile);
        //验证短信验证码
        if(! SendSms::checkCode($mobile, $code)) throw new Exception('验证码错误！');
        return $user;
    }
}