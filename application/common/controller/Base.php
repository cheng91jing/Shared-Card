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
use think\Controller;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\Response;

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
     * @var mixed|\app\common\model\AdminUser 登录用户数据
     */
    public $user = null;

    /**
     * @var null|APIFormatResponse API返回类型
     */
    public $jsonReturn = null;

    public function _initialize()
    {
        //设置API返回数据格式类，用作后台AJAX，或者前端API等
        $this->jsonReturn = new APIFormatResponse();
        //TODO: 全局控制器初始化基本操作
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
}