<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\AdminUser;
use app\common\model\Partner;
use think\Exception;


class Merchant extends AdminBase
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
        $this->canThrowException('merchant-partner-list');
        if ($this->request->isAjax()) {
            $data = Partner::paginateScope();
            return json($data);
        }
        return $this->fetch();
    }

    public function add($partner_id = null)
    {
        $this->canThrowException('merchant-partner-info');
        if (empty($partner_id)) {
            $partner = new Partner([
                'goods_discount' => 0
            ]);
        } else {
            $partner = Partner::get($partner_id);
        }
        if ($this->request->isAjax()) {
            try {
                $partner_name = $this->request->post('partner_name', null, 'trim');
                $goods_discount = ! $this->request->post('goods_discount', null) ? false : true;
                $partner->InfoBase(['partner_name' => $partner_name, 'goods_discount' => $goods_discount]);
            } catch (Exception $e) {
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }

        return $this->fetch('info', compact('partner'));
    }

//    public function search($admin_mobile)
//    {
//        try{
//            $admin = AdminUser::get(['mobile' => $admin_mobile]);
//            if(empty($admin)) throw new Exception('未找到该用户');
//            $partner = $admin->partner()->column('partner_name');
//            if(!$admin->role || ! $admin->role->is_partner) throw new Exception('管理员身份不符！');
//            $this->setReturnJsonData(compact('admin', 'partner', 'role'));
//        }catch (Exception $e){
//            $this->setReturnJsonError($e->getMessage());
//        }
//        return json($this->jsonReturn);
//    }

    public function status($id, $status)
    {
        $this->canThrowException('merchant-partner-status');
        try{
            if(!$this->request->isPost()) throw new Exception('请求错误');
            $partner = Partner::get($id);
            if(empty($partner)) throw new Exception('不存在的商家');
            $partner->status = $status ? true : false;
            $partner->save();
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }
}
