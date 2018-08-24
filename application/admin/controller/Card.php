<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\CardCategory;
use think\Exception;


class Card extends AdminBase
{
    protected $beforeActionList = [
        'checkLogin',
    ];

    public function index()
    {
        if ($this->request->isAjax()) {
            $data = CardCategory::paginateScope();
            return json($data);
        }
        return $this->fetch();
    }

    public function add($cate_id = null)
    {
        if (empty($cate_id)) {
            $cat = new CardCategory();
        } else {
            $cat = CardCategory::get($cate_id);
        }
        if ($this->request->isAjax()) {
            try {

                $this->setReturnJsonData($this->request->post());
            } catch (Exception $e) {
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }
        return $this->fetch('info', compact('cat'));
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
