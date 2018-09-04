<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Bill as BillModel;


class Bill extends AdminBase
{
    protected $beforeActionList = [
        'checkLogin',
    ];

    protected function _initialize()
    {
        parent::_initialize();
        if($this->role->is_partner) $this->throwPageException('商家身份无权访问');
    }

    public function index()
    {
        $this->canThrowException('member-bill-list');
        if ($this->request->isAjax()) {
            $data = BillModel::paginateScope([], [], ['user']);
            return json($data);
        }
        return $this->fetch();
    }
}
