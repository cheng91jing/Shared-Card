<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Goods as GoodsModel;
use app\common\model\GoodsCategory;
use think\Exception;

class Goods extends AdminBase
{
    protected $beforeActionList = [
        'checkLogin',
    ];

    public function index()
    {
        $this->canThrowException('goods-goods-list');
        if ($this->request->isAjax()) {
            $where = !empty($this->role->is_partner) ? !empty($this->partner) ? ['partner_id' => $this->partner->id] : '1 = 2' : [];
            $data = GoodsModel::paginateScope($where, [], ['cat', 'partner']);
            return json($data);
        }
        return $this->fetch();
    }

    public function info($goods_id = null)
    {
        if(! $this->partner) $this->throwPageException('只能商家才能访问!');
        $this->canThrowException('goods-goods-info');
        if (empty($goods_id)) {
            $goods = new GoodsModel([
                'cat_id' => 0,
                'goods_price' => 0.00,
                'goods_number' => 0.00,
                'goods_discount' => 0,
                'discount_type' => 0,
                'discount_number' => 0.00,
            ]);
        } else {
            $goods = GoodsModel::get($goods_id);
            if(empty($goods)) $this->error('未知的商品');
            if($goods->partner_id !== $this->partner->id) $this->error('不能访问非本商家的商品！');
        }
        if ($this->request->isAjax()) {
            try {
                $data = $this->request->post('', '', 'trim');
                if(empty($data['goods_name']) || empty($data['cat_id']) || empty($data['goods_price'])) throw new Exception('缺少参数');
                $cat = GoodsCategory::get($data['cat_id']);
                if(empty($cat)) throw new Exception('未知的分类！');
                $goods->goods_name = $data['goods_name'];
                $goods->cat_id = $cat->cat_id;
                $goods->goods_price = $data['goods_price'];
                $goods->partner_id = $this->partner->id;
                $goods->goods_discount = !empty($data['goods_discount']) ? true : false;
                if(!! $goods->goods_discount){
//                    $goods->discount_type = (isset($data['discount_type']) && is_numeric(['discount_type'])) ? intval($data['discount_type']) : 0;
                    if(!isset($data['discount_type']) || ! array_key_exists($data['discount_type'], $goods->dt_name))
                        throw new Exception('优惠类型错误');
                    $goods->discount_type = intval($data['discount_type']);
                    if(!isset($data['discount_number']) || ! is_numeric($data['discount_number']) || $data['discount_number'] < 0)
                        throw new Exception('优惠数量错误');
                    if($goods->discount_type === GoodsModel::DT_DISCOUNT && $data['discount_number'] > 1) throw new Exception('优惠数量错误');
                    $goods->discount_number = number_format($data['discount_number'], 2, '.', '');
                }
                $goods->add_time = date('Y-m-d H:i:s');
                $goods->save();
            } catch (Exception $e) {
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }
        $can_discount = ($this->partner && $this->partner->goods_discount) ? true : false;
        return $this->fetch('info', compact('goods', 'can_discount'));
    }

    public function children($parent_id, $goods = false)
    {
        try{
            if(!$this->request->isPost()) throw new Exception('请求方式错误!');
            if(!is_numeric($parent_id)) throw new Exception('参数错误!');
            $parent_id = empty($parent_id) ? 0 : intval($parent_id);
            $cat_list = (new GoodsCategory)->where('parent_id', $parent_id)->order('cat_sort')->select();
            $goods_list = [];
            if(!! $goods){
                $goods_list = GoodsModel::getCatAllGoods($parent_id, $this->partner ? $this->partner->id : null);
            }
            $this->setReturnJsonData(['cat_list' => $cat_list, 'goods_list' => $goods_list]);
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }
}
