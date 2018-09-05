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
use app\common\library\PermissionHandler;
use think\Config;

class Layout extends AdminBase
{
    protected $beforeActionList = [
        'checkLogin'
    ];
    public function index()
    {
        $user_nav = Config::get('jurisdiction');    //获取用户导航
        $user = $this->user;
        $is_partner = $this->isPartnerAdmin;
        $homeURL = $is_partner ? '/admin/offline' : '/admin/layout/home';
        $permission = PermissionHandler::getInstance();
        return $this->fetch('', compact('user_nav', 'user', 'permission', 'homeURL', 'is_partner'));
    }

    public function home()
    {
        return $this->fetch();
    }
}