<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\library\AuthHandler;
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
                if(empty($mobile)) throw new Exception('未填写手机号');
                if(empty($user->id) && empty($password)) throw new Exception('创建账号密码必须填写');
                $user->mobile = $mobile;
                if(empty($user->auth_code))
                    $user->auth_code = generate_rand_str(10, true);
                if(!empty($password))
                    $user->password = AuthHandler::generateHash($password, [$user->auth_code]);
                $user->save();
            } catch (Exception $e) {
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }

        return $this->fetch('info', compact('user'));
    }


}
