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


use app\common\library\APIFormatResponse;
use app\common\library\AuthHandler;
use app\common\library\PermissionHandler;
use app\common\model\BaseUser;
use Carbon\Carbon;
use think\Controller;
use think\Exception;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\Response;
use think\Session;

/**
 * 全局控制器基类
 * @author Chen <654807719@qq.com>
 * @package app\common\controller
 */
abstract class Base extends Controller
{
    /**
     * @var bool 是否登录
     */
    public $isLogin = false;

    /**
     * @var mixed|\app\common\model\BaseUser|\app\common\model\AdminUser|\app\common\model\User 登录用户数据
     */
    public $user = null;

    /**
     * @var null|\app\common\library\PermissionHandler 权限助手
     */
//    public $permission = null;

    /**
     * @var null|APIFormatResponse API返回类型
     */
    public $jsonReturn = null;

    /**
     * @var string  登录失效的跳转链接
     */
    protected $logout_redirect = null;

    /**
     * @var string 用户模型名称(默认为前端User模型)
     */
    protected $user_model = '\app\common\model\User';



    protected function _initialize()
    {
        //设置API返回数据格式类，用作后台AJAX，或者前端API等
        $this->jsonReturn = new APIFormatResponse();
        //用户自动登陆
        $this->autoLogin();
        //设置 Carbon 包的语言环境
        Carbon::setLocale('zh');
    }

    /**
     * 用户自动登录操作
     */
    protected function autoLogin()
    {
        $session_user = Session::get('user');
        if($session_user && !empty($session_user['id']) && !empty($session_user['access_token'])){
            try{
                //使用用户模型获取用户数据
                $model = $this->user_model;
                $user = $model::get($session_user['id']);
                if(empty($user)) throw new Exception('未知用户');
                $approved = AuthHandler::verify($user->id, $session_user['access_token'], [$user->auth_code, $user->login_code]);
                if(!$approved) throw new Exception('登陆验证失败');
                $this->initUserInfo($user);
            }catch (Exception $e){
            }
        }
    }

    /**
     * 检查登录状态 并跳转到当前模型的 login 控制器 index 方法
     */
    protected function checkLogin()
    {
        if(! $this->isLogin){
            if($this->request->isAjax()){
                $this->throwJsonException($this->setReturnJsonError('登录已失效', -1)->transformArray());
            }else{
                //清空登录状态
                $this->clearLogin();
                //跳转
                $redirect_url = $this->logout_redirect !== null ? $this->logout_redirect : $this->request->module() .'/login/index';
                $this->throwRedirectException($redirect_url);
            }
        }
    }

    /**
     * 手动登录
     * @param \app\common\model\BaseUser $user
     *
     * @throws \think\Exception
     */
    protected function login(BaseUser $user)
    {
        //用户登陆数据更新
        $user = $user->login();
        //记录session
        $login_session = [
            'id' => $user->id,
            'access_token' => AuthHandler::generateHash($user->id, [$user->login_code, $user->auth_code]),
        ];
        Session::set('user', $login_session);
        $this->initUserInfo($user);
    }

    //清除登陆状态
    protected function clearLogin()
    {
        $this->user = null;
        $this->isLogin = false;
        Session::clear();
    }

    //判断权限
    protected function can($action)
    {
        if($this->isLogin){
            return PermissionHandler::can($action);
        }
        return false;
    }

    protected function canThrowException($action)
    {
        if(!$this->can($action)){
            if($this->request->isAjax()){
                $this->throwJsonException($this->setReturnJsonError("权限不足！ACTION: {$action}", -1)->transformArray());
            }else{
                $this->throwPageException("权限不足！ACTION: {$action}");
            }
        }
    }

    //系统初始化用户信息，权限等
    protected function initUserInfo(BaseUser $user)
    {
        $this->isLogin = true;
        $this->user = $user;
        AuthHandler::$user = $user;
    }

    /**
     * 抛出Json异常
     * @param $data array 数据
     * @param int $statusCode 状态嘛
     */
    protected function throwJsonException(array $data, $statusCode = 200)
    {
        throw new HttpResponseException(Response::create($data, 'json', $statusCode));
    }

    /**
     * 抛出跳转异常
     * @param $url string 跳转链接
     */
    protected function throwRedirectException($url)
    {
        throw new HttpResponseException(redirect($url));
    }

    /**
     * 抛出页面异常
     * @param string $message 消息
     * @param int $statusCode 状态码
     */
    protected function throwPageException($message = '', $statusCode = 404)
    {
        throw new HttpException($statusCode, $message);
    }

    /**
     * 设置Json返回数据
     *
     * @param $data
     *
     * @return APIFormatResponse
     */
    protected function setReturnJsonData($data)
    {
        return $this->jsonReturn->setData($data);
    }

    /**
     * 设置Json返回错误信息
     *
     * @param $error_message
     * @param int $error_code
     * @param null $data
     *
     * @return APIFormatResponse
     */
    protected function setReturnJsonError($error_message, $error_code = -1, $data = null)
    {
        return $this->jsonReturn->setErrorMessage($error_message)->setErrorCode($error_code)->setData($data);
    }
}