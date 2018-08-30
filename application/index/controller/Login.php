<?php
namespace app\index\controller;


use app\common\controller\IndexBase;
use think\Exception;
use app\common\model\User;

class Login extends IndexBase
{
    /**
     * 登录页面
     */
    public function index()
    {
        if($this->isLogin) $this->redirect( 'index/user/center');
        if($this->request->isPost()){
            try{
                $mobile = $this->request->post('sms_mobile');
                $code = $this->request->post('sms_code');
                if(empty($mobile) || empty($code)) throw new Exception('缺少参数！');
                $user = User::verifyMobileCode($mobile, $code);
                if(empty($user)) throw new Exception('登陆失败！');
                $this->login($user);
            }catch (Exception $e){
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }
        return $this->fetch();
    }

    public function logout()
    {
        $this->clearLogin();
        return redirect('index',302);
    }
}
