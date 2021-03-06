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
 * @property integer $is_real 是否实名
 * @property string $real_name 真实姓名
 * @property string $id_code 身份证号
 * @property string $auth_code 鉴权随机字符串
 * @property string $login_code 登录状态鉴权随机数
 * @property string $create_time 创建时间
 * @property string $login_time 上次登录时间
 * @property string $login_ip 登录IP
 */
class User extends BaseUser
{
    protected $append = [
        'mobile_show',
        'real_name_show',
        'id_code_show',
    ];

    public function getMobileShowAttr($value, $data)
    {
        return $this->mobile ? substr_replace($this->mobile, '****', 3, 4) : '';
    }

    public function getRealNameShowAttr($value, $data)
    {
        if(empty($this->real_name)) return null;
        return str_repeat('*', mb_strlen($this->real_name, 'utf-8') - 1) . mb_substr($this->real_name, -1, null, 'utf-8');
    }

    public function getIdCodeShowAttr($value, $data)
    {
        if(empty($this->id_code)) return null;
        return substr($this->id_code, 0, 1) . str_repeat('*', strlen($this->id_code) - 5) . substr($this->id_code, -4);
    }

    /**
     * @return \think\model\relation\HasMany
     */
    public function cards()
    {
        return $this->hasMany(UserCard::class, 'user_id', 'id');
    }

    /**
     * 前端用户账户信息创建
     *
     * @param string $mobile 手机号
     * @param array $real 实名数组
     *
     * @return $this
     * @throws Exception
     * @throws \think\exception\DbException
     */
    public function account($mobile, array $real = [])
    {
        if(empty($this->mobile) || $this->getAttr('mobile') !== $mobile){
            $user_mobile = self::get(['mobile' => $mobile]);
            if($user_mobile) throw new Exception('手机号已被使用！');
        }
        $this->mobile = $mobile;
        $this->auth_code = generate_rand_str(10, true);
        $this->create_time = date('Y-m-d H:i:s');
        if(!empty($real) && !empty($real['real_name']) &&
            !empty($real['id_code']) && strlen($real['id_code']) === 18){
            $this->real_name = $real['real_name'];
            $this->id_code = $real['id_code'];
            $this->is_real = true;
        }
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