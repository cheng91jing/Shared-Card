<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/17
 * Time: 10:05
 * Email: 654807719@qq.com
 */

namespace app\common\controller;


use think\Controller;

/**
 * 全局控制器基类
 * @author Chen <654807719@qq.com>
 * @package app\common\controller
 */
class Base extends Controller
{
    /**
     * @var bool 是否登录
     */
    public $isLogin = false;

    /**
     * @var mixed 登录用户数据
     */
    public $user = null;

    public function _initialize()
    {
        //TODO: 全局控制器初始化基本操作
    }
}