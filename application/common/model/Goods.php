<?php

namespace app\common\model;


/**
 * Class Goods
 * @property int goods_id
 * @property integer goods_name 商品名称
 * @property integer partner_id 所属合作商
 * @property integer cat_id 商品类型
 * @property float goods_price 商品单价
 * @property integer goods_number 商品库存
 * @property integer goods_discount 是否开启商品优惠
 * @property integer discount_type 优惠类型
 * @property float discount_number 优惠额度
 * @property integer goods_status 商品状态
 * @property string add_time 内容
 * @property \app\common\model\GoodsCategory|null $cat 分类
 * @property \app\common\model\Partner|null $partner 商家
 */
class Goods extends Base
{
    protected $autoWriteTimestamp = false;

    protected $append = [
        'discount_type_show'
    ];

    //优惠类型
    const DT_DISCOUNT = 0;  //打折
    const DT_REDUCE   = 1;  //直减

    public $dt_name = [
        self::DT_DISCOUNT => '打折',
        self::DT_REDUCE   => '直减',
    ];

    public function cat()
    {
        return $this->hasOne(GoodsCategory::class, 'cat_id', 'cat_id');
    }

    public function partner()
    {
        return $this->hasOne(Partner::class, 'id', 'partner_id');
    }

    public function getDiscountTypeShowAttr($value, $data)
    {
//        return $this->dt_name[$data['discount_type']];
        return $this->dt_name[$this->discount_type];
    }

    /**
     * 获取当前分类及子分类下的所有商品
     *
     * @param $cat_id integer 分类ID
     * @param null $partner_id 商家ID
     *
     * @return array|false|static[]
     * @throws \think\exception\DbException
     */
    public static function getCatAllGoods($cat_id, $partner_id = null)
    {
        $cat = GoodsCategory::get($cat_id);
        if(empty($cat)) return [];
        //获取该分类下的所有分类
        $ids_2 = [];
        $ids_3 = [];
        if($cat->cat_level == 1){
            $ids_2 = GoodsCategory::where('parent_id', $cat->cat_id)->column('cat_id');
            if(!empty($ids_2))
                $ids_3 = GoodsCategory::where('parent_id', 'in', $ids_2)->column('cat_id');
        }elseif($cat->cat_level == 2){
            $ids_3 = GoodsCategory::where('parent_id', $cat->cat_id)->column('cat_id');
        }
        $cat_ids = array_merge([$cat->cat_id], $ids_2, $ids_3);
        $where['cat_id'] = ['in', $cat_ids];
        if(!empty($partner_id)) $where['partner_id'] = $partner_id;
        return self::all($where);
    }
}