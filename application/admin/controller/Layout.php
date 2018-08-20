<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/17
 * Time: 9:54
 * Email: 654807719@qq.com
 */

namespace app\admin\controller;


use app\common\controller\AdminBase;

class Layout extends AdminBase
{
    public function index()
    {
        return $this->fetch();
    }

    public function home()
    {
        return $this->fetch();
    }
}