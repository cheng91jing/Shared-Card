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
 * 后台身份表
 * Class AdminIdentity
 * @author Chen <654807719@qq.com>
 * @package app\common\model
 *
 * @property integer $identity_id
 * @property string $identity_name 身份名称
 * @property string $permission_ids 权限ID组
 * @property integer is_partner 是否合伙人
 */
class AdminIdentity extends Base
{
    public $append = [
        'is_partner_show'
    ];

    public function getIsPartnerShowAttr($value, $data)
    {
        return $this->is_partner ? '是' : '否';
    }
    
    //获取身份的权限
    public static function getIdentityPermission($identity_id)
    {
        $identity = self::get($identity_id);
        return $identity ? explode('|', $identity->permission_ids) : [];
    }

    
}