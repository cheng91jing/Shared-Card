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
    public function _initialize()
    {
        //TODO: 后台用户验证等
        parent::_initialize();
        //用户自动登陆
        $this->autoLogin();
    }

    //验证用户自动登陆
    protected function autoLogin()
    {
        $session_user = Session::get('admin_user');
        if($session_user && !empty($session_user['admin_id']) && !empty($session_user['access_token'])){
            try{
                $user = AdminUser::get($session_user['admin_id']);
                if(empty($user)) throw new Exception('未知用户');
                $approved = AuthHandler::verify($user->admin_id, $session_user['access_token'], [$user->auth_code, $user->login_code]);
                if(!$approved) throw new Exception('登陆验证失败');
                $this->initUserInfo($user);
            }catch (Exception $e){

            }
        }
    }

    //用户登陆操作
    protected function login(AdminUser $user)
    {
        //用户登陆数据更新
        $admin_user = $user->login();
        //记录session
        $login_session = [
            'admin_id' => $admin_user->admin_id,
            'access_token' => AuthHandler::generateHash($admin_user->admin_id, [$admin_user->login_code, $admin_user->auth_code]),
        ];
        Session::set('admin_user', $login_session);

        $this->initUserInfo($admin_user);
    }

    //系统初始化用户信息，权限等
    protected function initUserInfo(AdminUser $user)
    {
        $this->isLogin = true;
        $this->user = $user;
        //权限加载
        $permissions = [];
        $this->loadPermission($permissions);
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

    //清除登陆状态
    protected function clearLogin()
    {
        $this->user = null;
        $this->isLogin = false;
        Session::clear();
    }
}