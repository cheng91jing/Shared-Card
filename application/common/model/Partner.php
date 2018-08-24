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
 * @property integer $admin_id 所属后台用户
 * @property integer partner_type 类型
 * @property integer partner_cat 分类
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
    public function admin()
    {
        return $this->hasOne(AdminUser::class, 'id', 'admin_id');
    }

    /**
     * 商家基础信息
     * @param array $param [admin_id, admin_mobile, partner_type, partner_cat, name]
     *
     * @return $this
     * @throws Exception
     * @throws \think\exception\DbException
     */
    public function InfoBase(array $param)
    {
        //如果传入 admin_id 或 admin_mobile 绑定用户
        if(!empty($param['admin_id']) || !empty($param['admin_mobile'])){
            $condition = !empty($param['admin_id']) ? $param['admin_id'] : ['mobile' => $param['admin_mobile']];
            $admin = AdminUser::get($condition);
            if(empty($admin)) throw new Exception('未找到该用户');
//            if(!empty($this->admin_id) && $this->admin_id !== $admin->id){
//                $new_admin = self::get($admin->id);
//                if(!empty($new_admin)) throw new Exception('该用户已经绑定过商家，如果需要绑定，请先解除该用户所绑定的商家！');
//            }
            $this->admin_id = $admin->id;
        }else{  //不绑定用户
            $this->admin_id = 0;
        }
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
        $this->partner_name = $param['partner_name'];
        $this->save();
        return $this;
    }
}