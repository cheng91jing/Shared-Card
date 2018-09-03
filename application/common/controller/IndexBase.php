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

/**
 * 前端控制器基类
 * @author Chen <654807719@qq.com>
 * @package app\common\controller
 */
class IndexBase extends Base
{

    protected $user_model = '\app\common\model\User';

    public function _initialize()
    {
        //TODO: 前端用户验证等
        parent::_initialize();
        if(! $this->request->isMobile()) $this->throwPageException('访问出错！请使用手机端打开该页面！');
    }
}