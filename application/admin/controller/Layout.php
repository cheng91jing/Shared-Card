<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/17
 * Time: 9:54
 * Email: 654807719@qq.com
 */

namespace app\admin\controller;


use app\common\controller\AdminBase;
use think\Config;

class Layout extends AdminBase
{
    public function index()
    {
        $user_nav = Config::get('jurisdiction');    //获取用户导航
        return $this->fetch('', compact('user_nav'));
    }

    public function home()
    {
        return $this->fetch();
    }
}