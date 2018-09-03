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
    public function info()
    {
        $this->canThrowException('member-user-info');
    }
    
    public function add($user_id = null)
    {
        throw new Exception('已关闭后台会员新增功能');
        if (empty($user_id)) {
            $user = new User();
        } else {
            $user = User::get($user_id);
        }
        if ($this->request->isAjax()) {
            try {
                $mobile = $this->request->post('mobile', null, 'trim');
                $user->account($mobile);
            } catch (Exception $e) {
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }

        return $this->fetch('info', compact('user'));
    }


}
