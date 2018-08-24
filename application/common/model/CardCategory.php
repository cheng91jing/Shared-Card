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
 * @property string image 图片
 */
class CardCategory extends Base
{
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


}