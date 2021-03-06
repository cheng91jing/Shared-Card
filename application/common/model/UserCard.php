<?php

namespace app\common\model;

use app\common\library\EncryptAndDecrypt;
use app\common\library\TOTPAuth;
use think\Db;
use think\Exception;

/**
 * 用户卡
 * Class UserCard
 * @package app\common\model
 *
 * @property integer id
 * @property string card_number 编号
 * @property integer user_id 所属用户
 * @property integer cat_id 会员卡类型
 * @property integer status 普通状态
 * @property integer enable 是否启用
 * @property string regular_start 有效期开始时间
 * @property string regular_end 有效期结束时间
 * @property string open_time 开卡时间
 * @property integer activating_status 激活状态
 * @property string activating_code 激活鉴权码
 * @property float denomination 面额
 * @property float balance 余额
 * @property int discount_type 折扣类型(0-百分比/1-直减)
 * @property float discount_number 优惠数量(减去数量)
 * @property CardCategory|null $cat
 */
class UserCard extends Base
{
    const CARD_NUMBER_TRANSFORM = '6790348512';
    //动态码最大值，根据动态码的最大位数【建议为7位才能生成18位数字】
    const MAX_DYNAMIC_NUMBER = '9999999';

    const UCS_INVALID = 0;
    const UCS_VALID   = 1;

    const UCE_NOT_ENABLE = 0;
    const UCE_ENABLE     = 1;

    const UCA_INACTIVATED = 0;
    const UCA_ACTIVATION  = 1;

    //优惠类型
    const UDT_DISCOUNT = 0;  //打折
    const UDT_REDUCE   = 1;  //直减

    public $ucs_name = [
        self::UCS_INVALID => '禁用',
        self::UCS_VALID   => '有效',
    ];

    public $uce_name = [
        self::UCE_NOT_ENABLE => '未启用',
        self::UCE_ENABLE     => '已启用',
    ];

    public $uca_name = [
        self::UCA_INACTIVATED => '未激活',
        self::UCA_ACTIVATION  => '已激活',
    ];

    public $udt_name = [
        self::UDT_DISCOUNT => '打折',
        self::UDT_REDUCE   => '直减',
    ];

    protected $append = [
        'enable_show',
        'discount_type_show'
        //        'activating_show',
    ];

    public function getEnableShowAttr($value, $data)
    {
        return $this->uce_name[$this->enable];
    }

    public function getActivatingShowAttr($value, $data)
    {
        return $this->uca_name[$this->activating_status];
    }

    public function getStatusShowAttr($value, $data)
    {
        return $this->ucs_name[$this->status];
    }

    public function getDiscountTypeShowAttr($value, $data)
    {
        return $this->udt_name[$this->discount_type];
    }


    /**
     * @param $query \think\db\Query
     */
    public function scopeValid($query)
    {
        $now = date('Y-m-d H:i:s');
        $query->where([
            'status'            => self::UCS_VALID,
            'activating_status' => self::UCA_ACTIVATION,
        ])->where("IF(enable = " . self::UCE_ENABLE . ", IF(regular_start > '{$now}', 1 = 1, regular_start < '{$now}' AND regular_end > '{$now}'), 1 = 1)");
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function cat()
    {
        return $this->hasOne(CardCategory::class, 'cat_id', 'cat_id');
    }

    /**
     * 发会员卡
     *
     * @param User $user 会员
     * @param CardCategory $cat 类型
     *
     * @return UserCard
     * @throws Exception
     */
    public static function grant(User $user, CardCategory $cat)
    {
        $userCard          = new static();
        $userCard->user_id = $user->id;
        $userCard->cat_id  = $cat->cat_id;
        if(! $user->is_real) throw new Exception("用户：{$user->mobile} 还未实名认证，不能发卡！");
        //检测该用户下是否有能使用的会员卡
        if (! ! self::getExistsCard($user->id)) throw new Exception("用户：{$user->mobile} 已经有会员卡了");
        if ($cat->isInvalid()) throw new Exception("会员卡类型：{$cat->cat_name} 不可用!");

        $userCard->status = self::UCS_VALID;
        if ($cat->period_start == CardCategory::PS_REGULAR) {
            $userCard->enable        = self::UCE_ENABLE;
            $userCard->regular_start = $cat->regular_start;
            $userCard->regular_end   = $cat->regular_end;
        }
        $userCard->card_number       = self::generatorNumber($cat->prefix);
        $userCard->open_time         = date('Y-m-d H:i:s');
        $userCard->activating_status = self::UCA_ACTIVATION;
        $userCard->activating_code   = strtoupper(generate_rand_str(6));
        $userCard->denomination      = $cat->denomination;
        $userCard->balance           = $cat->denomination;
        $userCard->discount_type     = $cat->discount_type;
        $userCard->discount_number      = $cat->discount_number;
        $userCard->save();
        return $userCard;
    }

    /**
     * 批量生成卡密
     *
     * @param CardCategory $cat
     * @param $number
     *
     * @return bool
     * @throws Exception
     */
    public static function batch(CardCategory $cat, $number)
    {
        Db::startTrans();
        try {
            if (! is_numeric($number) || $number <= 0) throw new Exception('生成数量参数错误！');
            if ($cat->isInvalid()) throw new Exception("会员卡类型：{$cat->cat_name} 不可用!");

            do {
                $card                    = new static;
                $card->card_number       = self::generatorNumber($cat->prefix);
                $card->cat_id            = $cat->cat_id;
                $card->status            = self::UCS_VALID;
                $card->activating_status = self::UCA_INACTIVATED;
                $card->activating_code   = strtoupper(generate_rand_str(6));
                $card->denomination      = $cat->denomination;
                $card->balance           = $cat->denomination;
                $card->discount_type     = $cat->discount_type;
                $card->discount_number      = $cat->discount_number;
                $card->save();
                $number--;
            } while ($number > 0);
            Db::commit();

            return true;
        } catch (Exception $e) {
            Db::rollback();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 激活会员卡
     *
     * @param User $user 用户
     * @param UserCard $card 会员卡
     * @param $password string 密码
     *
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function activation(User $user, UserCard $card, $password)
    {
        if ($card->activating_status == self::UCA_ACTIVATION || ! empty($card->user_id)) throw new Exception('该会员卡已被使用！');
        if ($card->status == self::UCS_INVALID) throw new Exception('该会员卡已被禁用，不可激活！');
        //校验卡密
        if (! self::verifyCardPassword($card, $password)) throw new Exception('卡密错误！');
        $cat = CardCategory::get($card->cat_id);
        if ($cat->isInvalid()) throw new Exception('当前会员卡类型无效，不可激活！');
        if(! $user->is_real) throw new Exception("用户：{$user->mobile} 还未实名认证，不能发卡！");
        if (! ! self::getExistsCard($user->id)) throw new Exception('该用户已有正在使用的会员卡！');

        $card->user_id = $user->id;
        $card->user_id = $user->id;
        if ($cat->period_start == CardCategory::PS_REGULAR) {
            $card->enable        = self::UCE_ENABLE;
            $card->regular_start = $cat->regular_start;
            $card->regular_end   = $cat->regular_end;
        }
        $card->open_time         = date('Y-m-d H:i:s');
        $card->activating_status = self::UCA_ACTIVATION;
//        $card->denomination = $cat->denomination;
//        $card->balance = $cat->denomination;
        $card->save();
    }

    /**
     * 获取会员卡密码
     *
     * @param UserCard $card
     *
     * @return int|string
     */
    public static function getCardPassword(UserCard $card)
    {
        if (! empty($card->activating_status) || empty($card->activating_code)) return '';
        $code            = str_split($card->activating_code);
        $number_code_arr = array_map(function ($v) {
            return ord($v);
        }, $code);
        $number_string   = implode($number_code_arr);
        $str             = EncryptAndDecrypt::str_baseconvert($number_string);
        return $str;
    }

    /**
     * 校验会员卡密码
     *
     * @param UserCard $card
     * @param $password
     *
     * @return bool
     */
    public static function verifyCardPassword(UserCard $card, $password)
    {
        if (! empty($card->activating_status) || empty($card->activating_code)) return false;
        $number_string = EncryptAndDecrypt::str_baseconvert($password, 36, 10);
        $number_arr    = str_split($number_string, 2);
        $code_arr      = array_map(function ($v) {
            return chr($v);
        }, $number_arr);
        $code          = implode($code_arr);
        return $code == $card->activating_code;
    }

    /**
     * 获取付款码 方案1 （建议动态码位数位9位）
     * @return string
     */
    public function getPaymentCode1()
    {
        try {
            $user = User::get($this->user_id);
            if (! $user || empty($user->login_code)) throw new Exception('未知的用户或者用户未登陆！');
            $secret                = self::getSecret($this, $user->login_code);
            $dynamic_code          = TOTPAuth::getDynamicCode($secret);
            $card_number_transform = $this->cat_id . substr($this->card_number, -8);
            $transform             = self::getTransformNumber($card_number_transform);
            return $transform . $dynamic_code;
        } catch (Exception $e) {

        }
        return '';
    }

    /**
     * 获取付款码 方案2（建议动态码生成位数位7位 才能生成18位码）
     * @return string
     */
    public function getPaymentCode2()
    {
        try {
            $user = User::get($this->user_id);
            if (! $user || empty($user->login_code)) throw new Exception('未知的用户或者用户未登陆！');
            $secret       = self::getSecret($this, $user->login_code);
            $dynamic_code = TOTPAuth::getDynamicCode($secret);
            //使用用户手机号 * 动态码位数的最大值 + 动态码
            $payment_code = intval($user->mobile) * self::MAX_DYNAMIC_NUMBER + intval($dynamic_code);
            return strval($payment_code);
        } catch (Exception $e) {

        }
        return '';
    }

    /**
     * 校验会员卡的付款码 方案1 （建议动态码位数位9位）
     *
     * @param $payment_code
     *
     * @return UserCard|bool
     */
    public static function verifyPaymentCode1($payment_code)
    {
        try {
            $transform_number = substr($payment_code, 0, -9);
            //动态口令
            $dynamic_code = substr($payment_code, -9);
            //原始会员卡编号
            $original = self::getOriginalNumber($transform_number);
            //会员卡类型ID
            $cat_id = substr($original, 0, 1);
            $cat    = CardCategory::get($cat_id);
            if (empty($cat)) return false;
            $card_number = $cat->prefix . substr($original, 1);
            $card        = self::get(['card_number' => $card_number]);
            if (empty($card)) return false;
            $user = User::get($card->user_id);
            if (! $user || empty($user->login_code)) throw new Exception('未知的用户或者用户未登陆！');
            $secret = self::getSecret($card, $user->login_code);
            if (TOTPAuth::verifySecret($secret, $dynamic_code)) return $card;
        } catch (Exception $e) {

        }
        return false;
    }

    /**
     * 校验会员卡的付款码 方案2 （建议动态码生成位数位7位 才能生成18位码）
     *
     * @param $payment_code
     *
     * @return UserCard|bool
     */
    public static function verifyPaymentCode2($payment_code)
    {
        try {
            //获取动态码和用户手机号
            $user_mobile  = intval($payment_code / self::MAX_DYNAMIC_NUMBER);
            $dynamic_code = intval($payment_code % self::MAX_DYNAMIC_NUMBER);
            //获取用户最后有效的会员卡
            $user = User::get(['mobile' => $user_mobile]);
            if (empty($user)) return false;
            $card = self::getExistsCard($user->id);
            if (empty($card)) return false;
            $secret = self::getSecret($card, $user->login_code);
            if (TOTPAuth::verifySecret($secret, $dynamic_code)) return $card;
        } catch (Exception $e) {

        }
        return false;
    }

    /**
     * 获取会员卡秘钥
     *
     * @param \app\common\model\UserCard $card
     * @param $user_login_code string 用户登陆鉴权码
     *
     * @return string
     */
    public static function getSecret(UserCard $card, $user_login_code)
    {
        if (! $user_login_code) return '';
        return strtoupper($user_login_code . $card->card_number . $card->activating_code);
    }

    /**
     * 判断用户下是否有可用的会员卡
     *
     * @param $user_id
     *
     * @return bool|UserCard
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getExistsCard($user_id)
    {
        $exist_card = self::scope(['valid'])->where('user_id', $user_id)->find();
        return ! empty($exist_card) ? $exist_card : false;
    }

    /**
     * 获取字符串对应转换后的数字字符串
     *
     * @param $card_number
     *
     * @return string
     */
    public static function getTransformNumber($card_number)
    {
        $arr = array_map(function ($v) {
            return stripos(self::CARD_NUMBER_TRANSFORM, $v);
        }, str_split($card_number));
        return implode($arr);
    }

    /**
     * 获取原始会员卡ID
     *
     * @param $transform_str
     *
     * @return string
     */
    public static function getOriginalNumber($transform_str)
    {
        $arr = array_map(function ($v) {
            return substr(self::CARD_NUMBER_TRANSFORM, $v, 1);
        }, str_split($transform_str));
        return implode($arr);
    }

    /**
     * 会员卡余额变动
     *
     * @param float $money
     * @param bool $is_consume 是否为消耗,反之为收入
     */
    public function cardBalanceConsume($money, $is_consume = true)
    {
        if (! $this->enable && $is_consume) $this->enableCard();
        if($is_consume){
            $this->balance -= $money;
        }else{
            $this->balance += $money;
        }
        $this->save();
    }

    /**
     * 启用
     */
    public function enableCard()
    {
        if (! ! $this->enable) return;
        $cat = CardCategory::get($this->cat_id);
        if ($cat->period_start !== CardCategory::PS_REGULAR) {
            $this->regular_start = date('Y-m-d H:i:s');
            if ($cat->period_type == CardCategory::PT_DAY) {
                $end_time = strtotime("+{$cat->period_number} day");
            } else {
                $end_time = strtotime("+{$cat->period_number} month");
            }
            $this->regular_end = date('Y-m-d H:i:s', $end_time);
        }
        $this->enable = self::UCE_ENABLE;
        $this->save();
    }

    /**
     * 判断该卡是否可用
     * @return bool
     */
    public function isInvalid()
    {
        if (! $this->status) return true;
        if (! $this->activating_status) return true;
        $regular_start_timestamp = ! empty($this->regular_start) ? strtotime($this->regular_start) : 0;
        $regular_end_timestamp   = ! empty($this->regular_end) ? strtotime($this->regular_end) : 0;
        if (! ! $this->enable && ($regular_start_timestamp > time() || $regular_end_timestamp < time())) return true;
        return false;
    }

    //生成会员编码
    public static function generatorNumber($prefix)
    {
        $last_card  = (new self)->order('id DESC')->find();
        $number     = ! empty($last_card) ? intval($last_card->id) + 1 : 1;
        $number_str = str_pad($number, 6, '0', STR_PAD_LEFT);
        return $prefix . date('y') . $number_str;
    }
}