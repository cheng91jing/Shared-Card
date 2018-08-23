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
            $data = Partner::paginateScope();
            return json($data);
        }
        return $this->fetch();
    }

    public function add($partner_id = null)
    {
        if (empty($partner_id)) {
            $partner = new Partner();
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
            if(empty($admin)) throw new Exception('未找到该用户');
            $this->setReturnJsonData($admin);
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }
}
