<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\User;
use think\Exception;

class Member extends AdminBase
{
    protected $beforeActionList = [
        'checkLogin',
    ];

    public function index()
    {
        if ($this->request->isAjax()) {
            $data = User::paginateScope();
            return json($data);
        }
        return $this->fetch();
    }

    public function add($user_id = null)
    {
        if (empty($user_id)) {
            $user = new User();
        } else {
            $user = User::get($user_id);
        }
        if ($this->request->isAjax()) {
            try {
                $mobile = $this->request->post('mobile', null, 'trim');
                $password = $this->request->post('new_password', null);
                $user->account($mobile, $password);
            } catch (Exception $e) {
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }

        return $this->fetch('info', compact('user'));
    }


}
