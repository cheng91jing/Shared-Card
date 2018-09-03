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
        $this->canThrowException('trade-order-list');
        if ($this->request->isAjax()) {
            $where = !empty($this->role->is_partner) ? !empty($this->partner) ? ['partner_id' => $this->partner->id] : '1 = 2' : [];
            $data = OrderModel::paginateScope($where, [], ['user', 'partner', 'goods'], 'id DESC');
            return json($data);
        }
        return $this->fetch();
    }

    public function info($order_id)
    {
        $this->canThrowException('trade-order-info');
        $order = OrderModel::get($order_id);
        if(empty($order)) $this->error('未知的订单！');
        if($this->role->is_partner && $order->partner_id !== $this->partner->id) $this->error('不能访问非本商家的订单！');

        return $this->fetch('info', compact('order'));
    }

}
