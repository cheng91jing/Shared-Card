<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\library\PermissionHandler;
use app\common\model\User;
use think\Exception;

class Member extends AdminBase
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
        $this->canThrowException('member-user-list');
        if ($this->request->isAjax()) {
            $data = User::paginateScope();
            return json($data);
        }
        return $this->fetch();
    }

    //用户信息
    public function info($user_id)
    {
        $this->canThrowException('member-user-info');
        $user = User::get($user_id);
        if(empty($user)) $this->error('未找到该用户');
        return $this->fetch('', compact('user'));
    }
    
    public function add()
    {
        $this->canThrowException('member-user-add');
        if ($this->request->isAjax()) {
            try {
                $mobile = $this->request->post('mobile', null, 'trim');
                $real_name = $this->request->post('real_name', null, 'trim');
                $id_code = $this->request->post('id_code', null, 'trim');
                $real = (!empty($real_name) && !empty($id_code) && strlen($id_code) === 18)
                    ? compact('real_name', 'id_code')
                    : [];
                (new User)->account($mobile, $real);
            } catch (Exception $e) {
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }
    }


}
