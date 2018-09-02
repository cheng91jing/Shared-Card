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
}