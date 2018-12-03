<?php

namespace app\common\model;

/**
 * Class Hotel
 * @property integer $id ID
 * @property integer $partner_id 所属商家ID
 * @property string $hotel_name 酒店名
 * @property string $api_url API接口地址
 * @property string $hotel_key 酒店KEY
 * @property string $chain_code 连锁代码
 * @property string $hotel_code_room 酒店代码[房态
 * @property string $hotel_code_base 酒店代码[基础
 * @property integer $status 开启状态
 * @property integer $is_show 是否显示
 */
class Hotel extends Base
{
    protected $autoWriteTimestamp = false;
    protected $append = [];

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'id');
    }
}