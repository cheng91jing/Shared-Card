<?php
namespace app\index\controller;

use app\common\controller\IndexBase;

class Login extends IndexBase
{
    /**
     * 登录页面
     */
    public function index()
    {
        return $this->fetch();
    }
}
