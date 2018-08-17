<?php
namespace app\index\controller;

use app\common\controller\IndexBase;
use think\Config;

class Index extends IndexBase
{
    public function index()
    {
        return json(Config::get('customize.aaa'));
    }
}
