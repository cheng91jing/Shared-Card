<?php

namespace app\common\model;

use app\common\library\Sms;
use think\Exception;
use think\Model;

/**
 * Class ExpressDelivery
 * @property int $sms_id
 * @property string $phone 手机号
 * @property string $code 验证码
 * @property int $last_time 验证码最后发送时间
 */
class SendSms extends Model
{
    protected $autoWriteTimestamp = false;

    //短信发送间隔
    const SEND_INTERVAL = 60;
    //验证码有效期间隔
    const VALID_INTERVAL = 300;


    /**
     * @author Chen <654807719@qq.com>
     *
     * @param $mobile
     *
     * @return \app\common\model\SendSms|null
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    protected static function sendSaveCode($mobile)
    {

        $model = self::get(['phone' => $mobile]);
        if (empty($model)) {
            $model = new self(['phone' => $mobile]);
        }else{
            $interval = time() - $model->last_time;
            if($interval < self::SEND_INTERVAL) throw new Exception('每 '. self::SEND_INTERVAL .' 秒才能发送一次短信，剩余：' . $interval . ' 秒');
        }
        $code             = mt_rand(100000, 999999);
        $model->code      = $code;
        $model->last_time = time();
        if (!$model->save()) throw new Exception('保存信息失败');
        return $model;
    }

    /**
     * 检查手机号与验证码是否匹配
     * @param $mobile
     * @param $code
     *
     * @return bool
     * @throws \think\exception\DbException
     */
    public static function checkCode($mobile, $code)
    {
        $sms = self::get(['phone' => $mobile]);
        return (empty($sms) || $sms->code != $code || (time() - $sms->last_time) > self::VALID_INTERVAL) ? false : true;
    }

    /**
     * 发送登录短信
     *
     * @param $mobile
     * @return bool
     */
    public static function sendLoginCode($mobile)
    {
        try {
            $model = self::sendSaveCode($mobile);
            Sms::sendLogin($model->code, $model->phone);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}