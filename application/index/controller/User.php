<?php
namespace app\index\controller;

use app\common\controller\IndexBase;

class User extends IndexBase
{
    protected $beforeActionList = [
        'checkLogin'
    ];
    
    public function guest()
    {
        echo '<h1>访客</h1>';
        return json([]);
    }

    /**
     * 用户个人中心
     */
    public function center()
    {
        return $this->fetch();
    }
}
