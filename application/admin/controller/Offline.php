<?php

namespace app\admin\controller;


use app\common\controller\AdminBase;
use app\common\model\Order;
use think\Exception;

class Offline extends AdminBase
{
    protected $beforeActionList = [
        'checkLogin',
    ];

    public function index()
    {
        $order = new Order([
            'goods_price' => 0,
            'goods_number' => 0,
            'total_money' => 0,
        ]);
        return $this->fetch('', compact('order'));
    }

    public function deduction()
    {
        try{
            if(!$this->request->isPost()) throw new Exception('请求方式错误!');

            $this->setReturnJsonData($this->request->post());
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }

}
