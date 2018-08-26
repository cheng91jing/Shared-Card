<?php

namespace app\common\model;

use think\Db;
use think\Exception;

/**
 * 订单
 * Class Order
 * @package app\common\model
 *
 * @property integer id
 * @property string order_sn 订单号
 * @property integer partner_id 所属合作商
 * @property integer user_id 用户id
 * @property integer card_id 会员卡ID
 * @property integer order_status 订单状态
 * @property integer pay_status 付款状态
 * @property integer order_type 订单类型(0：线下直扣，1：线下商品，2：线上预定)
 * @property integer offline_admin 线下管理员
 * @property string offline_note 线下备注
 * @property integer goods_id 商品id
 * @property float total_money 订单总金额
 * @property float cash_money 现金支付
 * @property float card_money 会员卡支付
 * @property float goods_price 商品单价
 * @property integer goods_number 商品数量
 * @property string create_time 创建时间
 * @property string pay_time 支付时间
 * @property string end_time 完成/结束时间
 * @property string buyer_remark 买家备注
 */
class Order extends Base
{
    /**
     * 订单状态
     */
    const OS_CONFIRM       = 0;   //订单确认
    const OS_FINISH        = 1;   //完成
    const OS_USER_CANCEL   = 2;   //用户取消
    const OS_SYS_CANCEL    = 3;   //系统取消
    const OS_SELLER_CANCEL = 4;   //卖家取消
    /**
     * 付款状态
     */
    const PS_UNPAID = 0;
    const PS_PAID   = 1;
    /**
     * 订单类型
     */
    const OT_OFFLINE_REDUCE = 0;    //线下直扣
    const OT_OFFLINE_GOODS  = 1;    //线下商品
    const OT_ONLINE_GOODS   = 2;    //线上购买
    //订单状态名称
    public $os_name = [
        self::OS_CONFIRM       => '订单确认',
        self::OS_FINISH        => '订单完成',
        self::OS_USER_CANCEL   => '用户取消',
        self::OS_SYS_CANCEL    => '系统取消',
        self::OS_SELLER_CANCEL => '卖家取消',
    ];
    //付款状态
    public $ps_name = [
        self::PS_UNPAID => '未付款',
        self::PS_PAID   => '已付款',
    ];
    //订单类型名称
    public $ot_name = [
        self::OT_OFFLINE_REDUCE => '线下直扣',
        self::OT_OFFLINE_GOODS  => '线下商品',
        self::OT_ONLINE_GOODS   => '线上购买',
    ];

    protected $autoWriteTimestamp = 'datetime';
    protected $createTime         = 'create_time';
    protected $updateTime         = false;
    protected $append             = [];



    /**
     * 生成订单号
     *
     * @param int $business 业务代码 11 微信小程序
     *
     * @return false|string
     */
    public static function generateOrderSn($business = 11)
    {
        return $business . date('ymd') . substr(time(), -5) . substr(microtime(), 2, 5);
    }
}