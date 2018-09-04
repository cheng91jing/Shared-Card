<?php

namespace app\common\model;


/**
 * Class Bill
 * @property int id
 * @property integer user_id 用户ID
 * @property integer admin_id 管理员ID
 * @property int bill_type 类型
 * @property int is_consume 支出/收入
 * @property float amount 金额
 * @property string add_time 时间
 * @property string note 内容
 */
class Bill extends Base
{
    protected $autoWriteTimestamp = false;
    //账单类型
    const BT_ORDER_PAYMENT = 0;
    const BT_ORDER_REFUND = 1;

    public static $bt_name = [
        self::BT_ORDER_PAYMENT => '订单付款',
        self::BT_ORDER_REFUND => '订单退款',
    ];

    public static $note_format = [
        self::BT_ORDER_PAYMENT => '订单付款 - 订单号：%s：现金：%s；余额：%s',
        self::BT_ORDER_REFUND => '订单退款 - 订单号：%s；退款单号：%s：现金：%s；余额：%s',
    ];

    protected $append = [
        'type_show'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function getAddTimeAttr($value, $data)
    {
        return date('Y-m-d H:i:s', $value);
    }

    protected function getTypeShowAttr($value, $data)
    {
        return self::$bt_name[$this->bill_type];
    }

    /**
     * 订单账单
     *
     * @param Order $order 订单
     * @param float $balance 余额金额
     * @param float $cash 现金金额
     *
     * @return bool
     */
    public static function isOrderPay(Order $order, $balance, $cash = 0.00)
    {
        $bill = new self;
        $bill->note = sprintf(self::$note_format[self::BT_ORDER_PAYMENT], $order->order_sn, $cash, $balance);
        $bill->user_id = $order->user_id;
        $bill->admin_id = $order->offline_admin;
        $bill->bill_type = self::BT_ORDER_PAYMENT;
        $bill->is_consume = true;
        $bill->amount = $balance + $cash;
        $bill->add_time = time();
        $bill->save();
        return true;
    }
}