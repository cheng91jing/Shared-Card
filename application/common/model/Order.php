<?php

namespace app\common\model;

use app\common\library\AuthHandler;
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
 * @property float discount_money 优惠总金额
 * @property integer discount_type 优惠类型
 * @property float discount_number 优惠额度
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

    //优惠类型
    const DT_DISCOUNT = 0;  //打折
    const DT_REDUCE   = 1;  //直减

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

    public $dt_name = [
        self::DT_DISCOUNT => '打折',
        self::DT_REDUCE   => '直减',
    ];

    protected $autoWriteTimestamp = false;
    protected $append             = [
        'order_status_show',
        'pay_status_show',
        'order_type_show',
    ];

    public function getOrderStatusShowAttr($value, $data)
    {
        return $this->os_name[$this->order_status];
    }

    public function getPayStatusShowAttr($value, $data)
    {
        return $this->ps_name[$this->pay_status];
    }

    public function getOrderTypeShowAttr($value, $data)
    {
        return $this->ot_name[$this->order_type];
    }

    //商家
    public function partner()
    {
        return $this->hasOne(Partner::class, 'id', 'partner_id');
    }

    //买家
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    //会员卡
    public function card()
    {
        return $this->hasOne(UserCard::class, 'id', 'card_id');
    }

    //管理员
    public function admin()
    {
        return $this->hasOne(AdminUser::class, 'id', 'offline_admin');
    }


    /**
     * 线下付款
     *
     * @param array $param
     *
     * @throws Exception
     */
    public static function offlineOrder(array $param)
    {
        Db::startTrans();
        try {
            if (! isset($param['order_type']) || strlen($param['order_type']) == 0) throw new Exception('缺少订单类型参数！');
            if (empty($param['total_money']) || ! is_numeric($param['total_money']) || $param['total_money'] <= 0 ||
                empty($param['goods_price']) || ! is_numeric($param['goods_price']) || $param['goods_price'] <= 0 ||
                empty($param['goods_number']) || ! is_numeric($param['goods_number']) || $param['goods_number'] <= 0)
                throw new Exception('参数不合法');
            if (empty($param['payment_code'])) throw new Exception('请输入付款码！');
            //判断合作商
            $admin = AuthHandler::$user;
            if (empty($admin)) throw new Exception('管理员未登陆！');
            $partner = Partner::get($admin->partner_id);
            if (empty($partner) || ! $partner->status) throw new Exception('当前管理员不是商家，不可发起退款！');
            //获取用户
            $card = UserCard::verifyPaymentCode1($param['payment_code']);
            if (! $card) throw new Exception('付款码已失效！');
            if ($card->isInvalid()) throw new Exception('该会员卡不可使用！');
            $user = User::get($card->user_id);
            if (empty($user)) throw new Exception('未找到用户！');

            $order              = new static();
            $order->partner_id  = $partner->id;
            $order->user_id     = $user->id;
            $order->card_id     = $card->id;
            $order->total_money = round($param['total_money'], 2);
            $order->create_time = date('Y-m-d H:i:s');
            switch ($param['order_type']) {
                case self::OT_OFFLINE_REDUCE:   //直扣
                    if (empty($param['remark'])) throw new Exception('线下直扣，备注信息必须填写');
                    $order->offline_note  = $param['remark'];
                    $order->offline_admin = $admin->id;
                    $order->goods_price   = round($param['goods_price'], 2);
                    $order->goods_number  = intval($param['goods_number']);

                    break;
                case self::OT_OFFLINE_GOODS:    //商品
                    $order->offline_admin = $admin->id;
                    throw new Exception('暂未开放！');
                    break;
                default:
                    throw new Exception('未知的订单类型！');
            }
            $order->order_sn = self::generateOrderSn($param['order_type']);
            //获取订单优惠相关信息
            $discount_info          = self::getDiscount($order->total_money, $card);
            $order->discount_type   = $discount_info['discount_type'];
            $order->discount_number = $discount_info['discount_number'];
            //判断支付金额
            if ($card->balance < $discount_info['pay']) throw new Exception("当前会员卡余额不足，最多可支付 {$discount_info['max_pay']}");
            //会员卡支付
            $order->card_money = $discount_info['pay'];
            //优惠金额
            $order->discount_money = $order->total_money - $discount_info['pay'];
            $order->order_status = Order::OS_FINISH;
            $order->pay_status   = Order::PS_PAID;
            $order->pay_time     = date('Y-m-d H:i:s');
            $order->end_time     = date('Y-m-d H:i:s');
            $order->save();
            //扣款操作
            if ($order->card_money > 0)
                $card->cardBalanceConsume($order->card_money);
            //会员账单 - 订单付款记录
            Bill::isOrderPay($order, $order->card_money);
            Db::commit();
        } catch (Exception $e) {
            Db::rollback();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 获取优惠相关信息
     *
     * @param $total float 总金额
     * @param UserCard $card 用户会员卡
     * @param null $goods 商品
     *
     * @return array
     * @throws Exception
     */
    private static function getDiscount($total, UserCard $card, $goods = null)
    {
        //按照会员卡优惠计算

        //优惠类型
        $discount_type = $card->discount_type;
        //优惠额度
        $discount_number = $card->discount_number;

        if ($discount_type == CardCategory::DT_DISCOUNT) {
            //折扣
            $discount    = (1 - floatval($discount_number));
            $pay_balance = $total * ($discount > 1 ? 1 : ($discount < 0 ? 0 : $discount));
            $max_pay     = floor($card->balance / $discount);
        } else if ($discount_type == UserCard::UDT_REDUCE) {
            //直减
            $discount    = floatval($discount_number);
            $pay_balance = $total - ($discount < 0 ? 0 : $discount);
            if ($pay_balance < 0) $pay_balance = $total;
            $max_pay = $card->balance + ($discount < 0 ? 0 : $discount);
        } else {
            throw new Exception('未知类型');
        }
        return [
            'discount_type'   => $discount_type,    //优惠类型
            'discount_number' => $discount_number,  //优惠额度
            'pay'             => $pay_balance,      //需要支付金额
            'max_pay'         => $max_pay,          //余额最多可支付金额
        ];
    }

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