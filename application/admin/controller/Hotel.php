<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Partner;
use think\Exception;
use app\common\model\Hotel as HotelModel;

class Hotel extends AdminBase
{
    protected $beforeActionList = [
        'checkLogin',
    ];

    public function index()
    {
//        $this->canThrowException('goods-goods-list');
        return $this->isPartnerAdmin ? $this->info() : $this->table();
    }

    public function table()
    {
        $this->canThrowException('goods-hotel-table');
        if($this->isPartnerAdmin) $this->error('商家管理员账号不可访问!');
        if ($this->request->isAjax()) {
            $data = HotelModel::paginateScope([], [], ['partner']);
            return json($data);
        }
        return $this->fetch('table');
    }

    public function info($partner = null)
    {
        $this->canThrowException('goods-hotel-info');
        if($partner == null && $this->isPartnerAdmin) $partner = $this->partner->id;
        $partner_model = Partner::get($partner);
        if(!$partner_model) $this->error('参数错误，未知的商家！');
        if($this->isPartnerAdmin && $this->partner->id != $partner_model->id) $this->error('商家不能查看非自己的酒店配置');
        $hotel = HotelModel::get(['partner_id' => $partner_model->id]);
        if(empty($hotel)) $hotel = new HotelModel(['partner_id' => $partner_model->id]);

        return $this->fetch('info', compact('hotel'));
    }
}
