<?php

namespace app\admin\controller;


use app\common\controller\AdminBase;
use app\common\model\Order;

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

}
