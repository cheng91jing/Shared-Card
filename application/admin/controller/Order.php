<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Order as OrderModel;

class Order extends AdminBase
{
    protected $beforeActionList = [
        'checkLogin',
    ];

    public function index()
    {
        if ($this->request->isAjax()) {
            $data = OrderModel::paginateScope();
            return json($data);
        }
        return $this->fetch();
    }

    public function info($order_id)
    {
        $order = OrderModel::get($order_id);
        if(empty($order)) $this->error('未知的订单！');



        return $this->fetch('info', compact('cat'));
    }

}
