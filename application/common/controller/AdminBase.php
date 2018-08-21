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
use app\common\model\AdminUser;
use think\Session;

/**
 * 后台控制器基类
 * @author Chen <654807719@qq.com>
 * @package app\common\controller
 */
class AdminBase extends Base
{
    public function _initialize()
    {
        //TODO: 后台用户验证等
        parent::_initialize();
    }

    protected function login(AdminUser $user)
    {
        $this->isLogin = true;
        $this->user = $user;
    }

    protected function checkLogin()
    {
        if(! $this->isLogin){
            if($this->request->isAjax()){
                $this->throwJsonException($this->jsonReturn->getSetParameterToArray([
                    'error_code' => -1,
                    'error_message' => '登录已失效！'
                ]));
            }else{
                $this->throwRedirectException('admin/login/logout');
            }
        }
    }
}