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

    protected function _initialize()
    {
        parent::_initialize();
        if($this->role->is_partner) $this->throwPageException('商家身份无权访问！');
    }


    public function index()
    {
        $this->canThrowException('card-category-list');
        if ($this->request->isAjax()) {
            $data = CardCategory::paginateScope();
            return json($data);
        }
        return $this->fetch();
    }

    public function add($cat_id = null)
    {
        $this->canThrowException('card-category-info');
        if (empty($cat_id)) {
            $cat = new CardCategory([
                'period_start' => CardCategory::PS_FIRST,
                'period_type' => CardCategory::PT_MONTH,
                'discount_type' => CardCategory::DT_DISCOUNT,
            ]);
        } else {
            $cat = CardCategory::get($cat_id);
        }
        if ($this->request->isAjax()) {
            try {
                $cat->infoOfAddAndUpdate($this->request->post('', '', 'trim'));
            } catch (Exception $e) {
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }
        return $this->fetch('info', compact('cat'));
    }

    public function status($id, $status)
    {
        $this->canThrowException('card-category-status');
        try{
            if(!$this->request->isPost()) throw new Exception('请求错误');
            $cat = CardCategory::get($id);
            if(empty($cat)) throw new Exception('不存在的类型');
            $cat->status = $status ? true : false;
            $cat->save();
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }
}
