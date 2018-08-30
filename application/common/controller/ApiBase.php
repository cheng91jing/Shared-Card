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
use app\common\model\BaseUser;

/**
 * 接口控制器基类
 * @author Chen <654807719@qq.com>
 * @package app\common\controller
 */
class ApiBase extends Base
{

    protected $user_model = '\app\common\model\User';

    public function _initialize()
    {
        //TODO: 前端用户验证等
        parent::_initialize();
    }

    /**
     * Api接口需要重写 自动登录接口
     */
    protected function autoLogin()
    {
        //TODO:
    }

    /**
     * API接口需要重写 手动登录接口
     * @param \app\common\model\BaseUser $user
     */
    protected function login(BaseUser $user)
    {
        //TODO:
    }

    /**
     * 清空登录状态
     */
    protected function clearLogin()
    {
        //TODO:
    }
}