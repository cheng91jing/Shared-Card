<?php
namespace app\index\controller;

use app\common\controller\IndexBase;
use think\Exception;
use \app\common\model\User;

class Index extends IndexBase
{
    public function index()
    {
        $param = $this->request->get();
        //校验授权
        if($this->verifyParam($param) && !$this->isLogin){
            if(!empty($param['mobile']) && is_numeric($param['mobile']) && strlen($param['mobile']) === 11){
                try{
                    //登录用户获取注册
                    $user = User::get(['mobile' => $param['mobile']]);
                    if(empty($user)) $user = (new User)->account($param['mobile']);
                    $this->login($user);
                }catch (Exception $e){

                }
            }
        }
        $this->redirect('index/user/center');
    }

    private function verifyParam($param)
    {
        $config = config('customize.hngs_auth');
        //参数为 access_key agent_id mobile
        try{
            if($param['agent'] != $config['agent_id']) throw new Exception('未知的第三方');
            if(empty($param['agent']) || empty($param['noncestr']) ||
                empty($param['time']) || /*empty($param['mobile']) ||*/
                empty($param['sign'])) throw new Exception('不是从授权的第三方跳转！');
            if(intval($param['time']) > time() || time() - intval($param['time']) > 30) throw new Exception('参数错误！');
            $checkSign = $this->getSignature($param, $config['access_key']);
            if($checkSign != $param['sign']) throw new Exception('授权检测失败！');
        }catch (Exception $e){
            return false;
        }
        return true;
    }

    /**
     * 获取签名
     *
     * @param $params
     * @param $key
     *
     * @return string
     */
    private function getSignature($params, $key)
    {
        ksort($params);
        $buff = "";
        foreach ($params as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        $stringToBeSigned =  $buff . '&key=' . $key;
        return strtoupper(md5($stringToBeSigned));
    }
}
