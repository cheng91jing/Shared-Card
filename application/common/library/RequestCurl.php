<?php

namespace app\common\library;

/**
 * Class RequestCurl 远程curl请求
 */
class RequestCurl
{
    const CURL_TIMEOUT = 30;

    /**
     * 远程POST请求
     * @author Chen <654807719@qq.com>
     *
     * @param $url string 请求URL
     * @param $post_data array|string 发送的POST数据
     * @return mixed
     */
    public static function toPostUrl($url, $post_data)
    {
        //支持json数据数据提交
        //if($data_type == 'json'){
        //if ($post_data)
//        $post_string = json_encode($post_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        //}else if(is_array($post_data)){
//        	$post_string = http_build_query($post_data, '', '&');
        //}else {
        //	$post_string = $post_data;
        //}
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::CURL_TIMEOUT);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::CURL_TIMEOUT);		//超时
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array($header)); //模拟的header头
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    /**
     * 暂时用不着
     * @param $url
     * @param $post_data array $k => $v
     * @return bool|mixed
     */
    public static function toPostArrUrl($url, $post_data)
    {
        if(!is_array($post_data)) return false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::CURL_TIMEOUT);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::CURL_TIMEOUT);		//超时
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array($header)); //模拟的header头
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    /**
     * 远程GET请求
     *
     * @param $url
     * @param null $data
     *
     * @return mixed
     */
    public static function toGetUrl($url, $data = null)
    {
        if(is_array($data)) $data = http_build_query($data);
        if($data !== null)
            $url .= (substr_count($url, '?') > 0 ? '' : '?') . $data;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, self::CURL_TIMEOUT);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //运行curl，获取结果
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, true);
    }
}