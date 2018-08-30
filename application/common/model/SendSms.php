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
        }
        $code             = mt_rand(100000, 999999);
        $model->code      = $code;
        $model->last_time = time();
        if (!$model->save()) throw new Exception('保存信息失败');
        return $model;
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