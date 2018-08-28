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

    public function index()
    {
        if ($this->request->isAjax()) {
            $data = Partner::paginateScope([], [], ['admin']);
            return json($data);
        }
        return $this->fetch();
    }

    public function add($partner_id = null)
    {
        if (empty($partner_id)) {
            $partner = new Partner([
                'admin_id' => 0
            ]);
        } else {
            $partner = Partner::get($partner_id);
        }
        if ($this->request->isAjax()) {
            try {
                $admin_mobile = $this->request->post('admin_mobile', null, 'trim');
                $partner_name = $this->request->post('partner_name', null, 'trim');
                $partner->InfoBase(['admin_mobile' => $admin_mobile, 'partner_name' => $partner_name]);
            } catch (Exception $e) {
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }

        return $this->fetch('info', compact('partner'));
    }

    public function search($admin_mobile)
    {
        try{
            $admin = AdminUser::get(['mobile' => $admin_mobile]);
            $partners = $admin->partners()->column('partner_name');
            if(empty($admin)) throw new Exception('未找到该用户');
            $this->setReturnJsonData(['admin' => $admin, 'partners' => $partners]);
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }

    public function status($id, $status)
    {
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
