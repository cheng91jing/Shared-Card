<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/17
 * Time: 9:54
 * Email: 654807719@qq.com
 */

namespace app\admin\controller;


use app\common\controller\AdminBase;
use app\common\model\AdminUser;
use think\Exception;

class Login extends AdminBase
{
    public function index()
    {
        if($this->request->isPost()){
            $username = $this->request->post('username', null);
            $password = $this->request->post('password', null);
            try{
                if(empty($username) || empty($password)) throw new Exception('请输入账号和密码！');
//                $user = AdminUser::

            }catch (Exception $e){
                $this->jsonReturn->error_code = -1;
                $this->jsonReturn->error_message = $e->getMessage();
            }
            return json($this->jsonReturn);
        }
        return $this->fetch();
    }
}