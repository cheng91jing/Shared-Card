<?php
namespace app\index\controller;

use app\common\controller\IndexBase;

class Index extends IndexBase
{
    public function index()
    {
        $param = $this->request->param();
        //跳转接口
        
    }

    private function verfiyParam($param)
    {
        $config = config('customize.hngs_auth');
        //参数为 access_key agent_id mobile
    }
}
