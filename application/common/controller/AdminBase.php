<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/17
 * Time: 10:05
 * Email: 654807719@qq.com
 */

namespace app\common\controller;

use app\common\model\AdminIdentity;
use app\common\model\Partner;

/**
 * 后台控制器基类
 * @author Chen <654807719@qq.com>
 * @package app\common\controller
 */
class AdminBase extends Base
{
    protected $user_model = '\app\common\model\AdminUser';

    /**
     * @var null|\app\common\model\Partner 商家
     */
    protected $partner = null;

    /**
     * @var bool 是否商家管理账号
     */
    protected $isPartnerAdmin = false;

    /**
     * @var null|\app\common\model\AdminIdentity 角色信息
     */
    protected $role = null;

    protected function _initialize()
    {
        //TODO: 后台用户验证等
        parent::_initialize();
        //初始化商家信息
        $this->_initPartner();
        //初始化角色信息
        $this->_initRole();
    }

    private function _initPartner()
    {
        if(!empty($this->user)){
            if($this->user->partner_id > 0){
                $partner = Partner::get($this->user->partner_id);
                if(!empty($partner)) $this->partner = $partner;
            }
            if($this->partner && $this->user->partner_id == $this->partner->id) $this->isPartnerAdmin = true;
        }
    }

    private function _initRole()
    {
        if(!empty($this->user) && $this->user->identity_id > 0){
            $role = AdminIdentity::get($this->user->identity_id);
            if(!empty($role)) $this->role = $role;
        }
    }



}