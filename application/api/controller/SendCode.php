<?php

namespace app\api\controller;

use app\common\controller\ApiBase;
use app\common\model\SendSms;
use think\Exception;

/**
 * Class SendCode
 * @package app\api\controller
 */
class SendCode extends ApiBase
{
    /**
     * 发送手机验证码
     *
     * @param $sms_mobile
     * @return \app\common\library\APIFormatResponse|null
     */
    public function mobile($sms_mobile)
    {
        try{
            if(strlen($sms_mobile) !== 11 || !is_numeric($sms_mobile)) throw new Exception('参数错误！');
            if(! SendSms::sendLoginCode($sms_mobile)) throw new Exception('发送短信失败！');
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return $this->jsonReturn;
    }
}