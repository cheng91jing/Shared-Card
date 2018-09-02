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
        if(! PermissionHandler::can('all')) $this->throwPageException('无权访问');
    }


    public function index()
    {
        if ($this->request->isAjax()) {
            $data = AdminIdentity::paginateScope();
            return json($data);
        }
        return $this->fetch();
    }

    public function add($identity_id = null)
    {
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
        $model = $type ? AdminIdentity::get($id) : AdminUser::get($id);
        if (empty($model)) $this->error('未知的角色或管理员');
        if($this->request->isAjax()){
            try{
                $model->permission_ids = implode('|', $this->request->post('permission/a', []));
                $model->save();
            }catch (Exception $e){
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }
        $owned = explode('|', $model->permission_ids);

        $jurisdiction = Config::get('jurisdiction');
        return $this->fetch('permission', compact('model', 'jurisdiction', 'owned'));
    }

    public function del($identityId)
    {
    }

}
