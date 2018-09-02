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
        if(! PermissionHandler::can('all')) $this->throwPageException('无权访问');
    }


    public function index()
    {
        $cat_list = GoodsCategory::getRelationList();
//        print_r($cat_list);
        return $this->fetch('', compact('cat_list'));
    }

    public function add($name)
    {
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

    public function children($parent_id)
    {
        try{
            if(!$this->request->isPost()) throw new Exception('请求方式错误!');
            if(!is_numeric($parent_id)) throw new Exception('参数错误!');
            $parent_id = empty($parent_id) ? 0 : intval($parent_id);
            $cat_list = (new GoodsCategory)->where('parent_id', $parent_id)->order('cat_sort')->select();
            $this->setReturnJsonData($cat_list);
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }
}
