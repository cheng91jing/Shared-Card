<?php

namespace app\common\model;

use app\common\library\EncryptAndDecrypt;
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
 */
class UserCard extends Base
{
    protected $append = [
        'enable_show',
        //        'activating_show',
    ];

    const UCS_INVALID = 0;
    const UCS_VALID   = 1;

    const UCE_NOT_ENABLE = 0;
    const UCE_ENABLE     = 1;

    const UCA_INACTIVATED = 0;
    const UCA_ACTIVATION  = 1;

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


    /**
     * @param $query \think\db\Query
     */
    public function scopeValid($query)
    {
        $now = date('Y-m-d H:i:s');
        $query->where([
            'status'            => self::UCS_VALID,
            'activating_status' => self::UCA_ACTIVATION,
        ])->where("IF(enable = " . self::UCE_ENABLE . ", regular_start < '{$now}' AND regular_end > '{$now}', 1 = 1)");
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
        //检测该用户下是否有能使用的会员卡
        if (self::existsCard($user->id)) throw new Exception("用户：{$user->mobile} 已经有会员卡了");
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
        if($card->activating_status == self::UCA_ACTIVATION || !empty($card->user_id)) throw new Exception('该会员卡已被使用！');
        if($card->status == self::UCS_INVALID) throw new Exception('该会员卡已被禁用，不可激活！');
        //校验卡密
        if(! self::verifyCardPassword($card, $password)) throw new Exception('卡密错误！');
        $cat = CardCategory::get($card->cat_id);
        if($cat->isInvalid()) throw new Exception('当前会员卡类型无效，不可激活！');
        if(self::existsCard($user->id)) throw new Exception('该用户已有正在使用的会员卡！');

        $card->user_id = $user->id;
        $card->user_id = $user->id;
        if ($cat->period_start == CardCategory::PS_REGULAR) {
            $card->enable        = self::UCE_ENABLE;
            $card->regular_start = $cat->regular_start;
            $card->regular_end   = $cat->regular_end;
        }
        $card->open_time = date('Y-m-d H:i:s');
        $card->activating_status = self::UCA_ACTIVATION;
//        $card->denomination = $cat->denomination;
//        $card->balance = $cat->denomination;
        $card->save();
    }

    /**
     * 获取会员卡密码
     * @param UserCard $card
     *
     * @return int|string
     */
    public static function getCardPassword(UserCard $card)
    {
        if(!empty($card->activating_status) || empty($card->activating_code)) return '';
        $code = str_split($card->activating_code);
        $number_code_arr = array_map(function ($v){
            return ord($v);
        }, $code);
        $number_string = implode($number_code_arr);
        $str = EncryptAndDecrypt::str_baseconvert($number_string);
        return $str;
    }

    /**
     * 校验会员卡密码
     * @param UserCard $card
     * @param $password
     *
     * @return bool
     */
    public static function verifyCardPassword(UserCard $card, $password)
    {
        if(!empty($card->activating_status) || empty($card->activating_code)) return false;
        $number_string = EncryptAndDecrypt::str_baseconvert($password, 36, 10);
        $number_arr = str_split($number_string, 2);
        $code_arr = array_map(function ($v){
            return chr($v);
        }, $number_arr);
        $code = implode($code_arr);
        return $code == $card->activating_code;
    }

    /**
     * 判断用户下是否有可用的会员卡
     * @param $user_id
     *
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function existsCard($user_id)
    {
        $exist_card = self::scope(['valid'])->where('user_id', $user_id)->find();
        return !empty($exist_card) ? true : false;
    }

    //生成会员编码
    public static function generatorNumber($prefix)
    {
        $last_card  = (new self)->order('id DESC')->find();
        $number     = ! empty($last_card) ? intval($last_card->id) + 1 : 1;
        $number_str = str_pad($number, 6, '0', STR_PAD_LEFT);
        return $prefix . date('Y') . $number_str;
    }
}