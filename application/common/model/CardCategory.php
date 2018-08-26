<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/20
 * Time: 16:14
 * Email: 654807719@qq.com
 */

namespace app\common\model;


use think\Exception;


/**
 * 卡类别/分类
 * Class AdminUser
 * @package app\common\model
 *
 * @property integer cat_id
 * @property string cat_name 名称
 * @property integer status 状态
 * @property integer period_start 期限开始类型(0-首次消费/1-开卡日/2-固定时限)
 * @property integer period_type 期限类型(0-按月/1-按天)
 * @property integer period_number 期限量
 * @property string regular_start 定期开始时间
 * @property string regular_end 定期结束时间
 * @property int discount_type 折扣类型(0-百分比/1-直减)
 * @property float discount_number 优惠数量(减去数量)
 * @property float denomination 面额
 * @property string image 图片
 * @property string prefix 前缀
 */
class CardCategory extends Base
{
    protected $append = [
        'period_start_show',
        'discount_type_show',
    ];

    //期限开始类型
    const PS_FIRST   = 0;
    const PS_OPEN    = 1;
    const PS_REGULAR = 2;

    //期限类型
    const PT_MONTH = 0;
    const PT_DAY   = 1;

    //优惠类型
    const DT_DISCOUNT = 0;
    const DT_REDUCE   = 1;

    //状态
    const CS_INVALID = 0;
    const CS_VALID   = 1;

    public $ps_name = [
        self::PS_FIRST   => '首次消费',
        self::PS_OPEN    => '开卡日',
        self::PS_REGULAR => '固定期限',
    ];

    public $pt_name = [
        self::PT_MONTH => '按月',
        self::PT_DAY => '按天'
    ];

    public $dt_name = [
        self::DT_DISCOUNT => '打折',
        self::DT_REDUCE => '直减',
    ];

    public $cs_name = [
        self::CS_INVALID => '无效',
        self::CS_VALID => '有效'
    ];

    public function getPeriodStartShowAttr($value, $data)
    {
        return $this->ps_name[$this->period_start];
    }

    public function getDiscountTypeShowAttr($value, $data)
    {
//        return $this->dt_name[$data['discount_type']];
        return $this->dt_name[$this->discount_type];
    }

    /**
     * @param $query \think\db\Query
     */
    public function scopeAvailable($query)
    {
        $now = date('Y-m-d H:i:s');
        $query->where('status', self::CS_VALID)
            ->where("IF(period_start = ".self::PS_REGULAR.", regular_start < '{$now}' AND regular_end > '{$now}', 1 = 1)");
    }

    /**
     * 检测当前会员卡类型是否有效
     * @return bool
     */
    public function isInvalid()
    {
        if(!$this->status) return true;
        $regular_start_timestamp = !empty($this->regular_start) ? strtotime($this->regular_start) : 0;
        $regular_end_timestamp = !empty($this->regular_end) ? strtotime($this->regular_end) : 0;
        if($this->period_start == self::PS_REGULAR && ($regular_start_timestamp > time() || $regular_end_timestamp < time()))
            return true;
        return false;
    }
    
    /**
     * 会员卡信息创建/修改
     * @param array $param
     *
     * @return $this
     * @throws Exception
     * @throws \think\exception\DbException
     */
    public function infoOfAddAndUpdate(array $param)
    {
        if(empty($param['cat_name'])) throw new Exception('名称必填！');
        if(!empty($this->cat_name) && $this->cat_name !== $param['cat_name']){
            $new_name = self::get(['cat_name' => $param['cat_name']]);
            if(!empty($new_name)) throw new Exception('该名称已被使用');
        }
        $this->cat_name = $param['cat_name'];
        $this->status = true;
//        if(empty($param['period_start']) || ! array_key_exists($param['period_start'], $this->ps_name))
//            throw new Exception('期限开始类型错误');
        switch ($param['period_start']){
            case self::PS_FIRST:
            case self::PS_OPEN:
                if(!isset($param['period_type']) || ! array_key_exists($param['period_type'], $this->pt_name))
                    throw new Exception('当前期限开始类型，必须选择一种期限类型');
                $this->period_type = $param['period_type'];
                $this->period_number = intval(isset($param['period_number']) ? $param['period_number'] : 0);
                break;
            case self::PS_REGULAR:
                if(empty($param['datetime_range'])) throw new Exception('当前期限开始类型，必须选择定期的日期范围！');
                $range = explode(' - ', $param['datetime_range']);
                if(empty($range[0]) || empty($range[1])) throw new Exception('时间范围格式不符合要求');
                $this->regular_start = $range[0];
                $this->regular_end = $range[1];
                break;
            default:
                throw new Exception('期限开始类型错误!');
        }
        $this->period_start = $param['period_start'];
        if(!isset($param['discount_type']) || ! array_key_exists($param['discount_type'], $this->dt_name))
            throw new Exception('优惠类型错误');
        $this->discount_type = intval($param['discount_type']);
        if(!isset($param['discount_number']) || ! is_numeric($param['discount_number']) || $param['discount_number'] < 0)
            throw new Exception('优惠数量错误');
        if($this->discount_type === self::DT_DISCOUNT && $param['discount_number'] > 1) throw new Exception('优惠数量错误');
        $this->discount_number = number_format($param['discount_number'], 2, '.', '');
        if(!isset($param['denomination']) || ! is_numeric($param['denomination']) || $param['denomination'] < 0)
            throw new Exception('面额错误');
        $this->denomination = number_format($param['denomination'], 2, '.', '');
        if(!empty($param['prefix'])) $this->prefix = strtoupper($param['prefix']);
        $this->save();
        return $this;
    }

}