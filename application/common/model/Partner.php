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
 * 用户表
 * Class AdminUser
 * @package app\common\model
 *
 * @property integer $id
 * @property integer partner_type 类型
 * @property integer partner_cat 分类
 * @property integer goods_discount 是否可以设置商品优惠
 * @property integer status 状态
 * @property string partner_name 名称
 * @property string address 地址
 * @property string create_time 创建时间
 * @property string simply_introduce 简介
 * @property string detail_introduce 详细介绍
 * @property string tel 电话
 */
class Partner extends Base
{
    public function admins()
    {
        return $this->hasMany(AdminUser::class, 'partner_id', 'id');
    }

    /**
     * 商家基础信息
     * @param array $param [partner_type, partner_cat, name]
     *
     * @return $this
     * @throws Exception
     * @throws \think\exception\DbException
     */
    public function InfoBase(array $param)
    {
        //类型
        if(!empty($param['partner_type'])){

        }
        //分类
        if(!empty($param['partner_cat'])){

        }
        if(empty($param['partner_name'])) throw new Exception('商家名称必填！');
        if(!empty($this->partner_name) && $this->partner_name !== $param['partner_name']){
            $new_name = self::get(['partner_name' => $param['partner_name']]);
            if(!empty($new_name)) throw new Exception('该名称已经被使用，请更换名称后再试！');
        }
        $this->goods_discount = !empty($param['goods_discount']) ? true : false;
        $this->partner_name = $param['partner_name'];
        $this->status = true;
        $this->save();

        return $this;
    }
}