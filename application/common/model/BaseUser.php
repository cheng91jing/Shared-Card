<?php

namespace app\common\model;

use think\Request;

/**
 * 用户模型基类
 * @property integer $id
 * @property string $auth_code 鉴权码
 * @property string $login_code 登录鉴权码
 * @property string $login_ip 登录UP
 * @property string $login_time 登录时间
 */
abstract class BaseUser extends Base
{
    /**
     * 用户登录
     * @author Chen <654807719@qq.com>
     * @return $this
     */
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