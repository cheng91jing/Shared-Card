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
use app\common\library\ApiAuthHandler;
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
        $this->authorization();
    }

    /**
     * 验证授权
     */
    protected function authorization()
    {
        if($web_token = $this->request->header('WEB-CSRF-TOKEN')){
            //前端网页调用API鉴权
            if(! ApiAuthHandler::verifyWebToken($web_token))
                $this->throwJsonException($this->setReturnJsonError('非法请求！')->transformArray());
        }elseif ($this->request->has('access_token')){
            //用户校验
        }else{
            $this->throwJsonException($this->setReturnJsonError('非法请求！')->transformArray());
        }
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