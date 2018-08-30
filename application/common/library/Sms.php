<?php
/**
 * 短信发送
 */

namespace app\common\library;


use think\Exception;

class Sms
{
    private static $access_key = null;
    private static $access_key_secret = null;
    const GATEWAY_URL = "http://gw.api.taobao.com/router/rest";
    const API_VERSION = '2.0';
    const API_METHOD = 'alibaba.aliqin.fc.sms.num.send';

    private static function init()
    {
        if(empty(self::$access_key) || empty(self::$access_key_secret)){
            $config = config('customize.aliyun_sms');
            self::$access_key = $config['access_key'];
            self::$access_key_secret = $config['access_key_secret'];
        }
    }

    public static function sendLogin($code, $phone)
    {
        self::init();

        $sysParams = self::getSysParam();
        //短信模板参数设置
//        $apiParams['extend'] = '';
        $apiParams['sms_type'] = 'normal';
        $apiParams['sms_free_sign_name'] = '海南故事';
        $apiParams['sms_param'] = "{code:'{$code}',product:'共享家园'}";
        $apiParams['rec_num'] = $phone;
        $apiParams['sms_template_code'] = 'SMS_60695386';

        //签名
        $sysParams["sign"] = self::generateSign(array_merge($apiParams, $sysParams));
        $requestUrl = self::GATEWAY_URL . '?';
        foreach ($sysParams as $sysParamKey => $sysParamValue)
        {
            $requestUrl .= "{$sysParamKey}=" . urlencode($sysParamValue) . "&";
        }
        $requestUrl = trim($requestUrl, '&');
        $resp = RequestCurl::toPostUrl($requestUrl, $apiParams);
        foreach ($resp as $res){
            $resp = $res;
        }
        if(isset($resp['code']))
            throw new Exception($resp['msg']);
        return true;
    }

    private static function getSysParam()
    {
        $sysParams["app_key"] = self::$access_key;
        $sysParams["v"] = self::API_VERSION;
        $sysParams["format"] = 'json';
        $sysParams["sign_method"] = 'md5';
        $sysParams["method"] = self::API_METHOD;
        $sysParams["timestamp"] = date("Y-m-d H:i:s");
        return $sysParams;
    }

    private static function generateSign($params)
    {
        ksort($params);
        $stringToBeSigned = self::$access_key_secret;
        foreach ($params as $k => $v)
        {
            if(is_string($v) && "@" != substr($v, 0, 1))
            {
                $stringToBeSigned .= "$k$v";
            }
        }
        unset($k, $v);
        $stringToBeSigned .= self::$access_key_secret;
        return strtoupper(md5($stringToBeSigned));
    }

}