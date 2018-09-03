<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\library\PermissionHandler;
use app\common\model\GoodsCategory;
use think\Db;
use think\Exception;

class GoodsCat extends AdminBase
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
        $this->canThrowException('goods-category-list');
        $cat_list = GoodsCategory::getRelationList();
//        print_r($cat_list);
        return $this->fetch('', compact('cat_list'));
    }

    public function add($name)
    {
        $this->canThrowException('goods-category-info');
        try{
            if(!$this->request->isPost()) throw new Exception('请求方式错误!');
            $cat_name = trim($name);
            if(empty($cat_name)) throw new Exception('分类名称不能为空');
            $cat_exists = GoodsCategory::get(['cat_name' => $cat_name]);
            if(!empty($cat_exists)) throw new Exception('该名称已重复！');
            $cat = new GoodsCategory(['cat_name' => $cat_name]);
            $cat->save();
            $this->setReturnJsonData($cat);
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }

    public function operating()
    {
        $this->canThrowException('goods-category-info');
        Db::startTrans();
        try{
            if(!$this->request->isPost()) throw new Exception('请求方式错误!');
            $data = $this->request->post('data/a');
            if(!empty($data))
                GoodsCategory::catListChange($data);
            Db::commit();
        }catch (Exception $e){
            Db::rollback();
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }

    public function del()
    {
        $this->canThrowException('goods-category-del');
    }
}
