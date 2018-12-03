<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\library\PermissionHandler;
use app\common\model\AdminIdentity;
use app\common\model\AdminUser;
use think\Config;
use think\Exception;

class Jurisdiction extends AdminBase
{
    protected $beforeActionList = [
        'checkLogin',
    ];

    protected function _initialize()
    {
        parent::_initialize();
        if($this->role->is_partner) $this->throwPageException('商家身份无权访问！');
    }


    public function index()
    {
        $this->canThrowException('system-role-list');
        if ($this->request->isAjax()) {
            $data = AdminIdentity::paginateScope();
            return json($data);
        }
        return $this->fetch();
    }

    public function add($identity_id = null)
    {
        $this->canThrowException('system-role-info');
        if (empty($identity_id)) {
            $identity = new AdminIdentity();
        } else {
            $identity = AdminIdentity::get($identity_id);
        }
        if ($this->request->isAjax()) {
            try {
                $is_partner    = $this->request->post('is_partner', false);
                $identity_name = $this->request->post('identity_name', '');
                if (empty($identity_name)) throw new Exception('缺少参数');
                $identity->identity_name = $identity_name;
                $identity->is_partner = $is_partner ? true : false;
                $identity->save();
            } catch (Exception $e) {
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }

        return $this->fetch('info', compact('identity'));
    }

    /**
     *
     * @param $id int ID
     * @param int $type 类型 1:角色权限 0:账号权限
     *
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function permission($id, $type = 1)
    {
        $type ? $this->canThrowException('system-role-permission') : $this->canThrowException('system-administrator-permission');
        $model = $type ? AdminIdentity::get($id) : AdminUser::get($id);
        if (empty($model)) $this->error('未知的角色或管理员');
        $owned = explode('|', $model->permission_ids);
        if(in_array('all', $owned)) $this->error('ALL 权限的角色或管理员权限不可更改！');
        if($this->request->isAjax()){
            try{
                $model->permission_ids = implode('|', $this->request->post('permission/a', []));
                $model->save();
            }catch (Exception $e){
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }
        $special = $this->role->is_partner ? 1 : 2; //特殊标记，1：商家；2：管理员
        $jurisdiction = Config::get('jurisdiction');
        return $this->fetch('permission', compact('model', 'jurisdiction', 'owned', 'special'));
    }

    public function del($role_id)
    {
    }

}
