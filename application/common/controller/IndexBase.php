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

    public function _initialize()
    {
        //TODO: 前端用户验证等
        parent::_initialize();
    }
}