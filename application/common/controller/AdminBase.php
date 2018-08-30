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

use app\common\library\AuthHandler;
use app\common\model\AdminUser;
use think\Session;
use think\Exception;

/**
 * 后台控制器基类
 * @author Chen <654807719@qq.com>
 * @package app\common\controller
 */
class AdminBase extends Base
{
    protected $user_model = '\app\common\model\AdminUser';

    public function _initialize()
    {
        //TODO: 后台用户验证等
        parent::_initialize();
    }
}