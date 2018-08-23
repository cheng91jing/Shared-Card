<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/20
 * Time: 16:47
 * Email: 654807719@qq.com
 */

namespace app\common\library;

/**
 * API 响应格式
 * Class APIFormatResponse
 * @author Chen <654807719@qq.com>
 * @package app\common\library
 */
class APIFormatResponse
{
    /**
     * @var int 错误代码
     */
    public $error_code = 0;
    /**
     * @var string 错误消息
     */
    public $error_message = '';
    /**
     * @var null 返回数据
     */
    public $data = null;

    public function setParameter(array $parameters)
    {
        foreach ($parameters as $k => $v){
            $this->$k = $v;
        }
        return $this;
    }

    public function transformArray()
    {
        return json_decode(json_encode($this), true);
    }

//    public function getSetParameterToArray(array $parameters)
//    {
//        return $this->setParameter($parameters)->transformArray();
//    }
    /**
     * 设置错误代码
     *
     * @param $error_code
     *
     * @return $this
     */
    public function setErrorCode($error_code)
    {
        $this->error_code = $error_code;
        return $this;
    }

    /**
     * 设置错误信息
     *
     * @param $error_message
     *
     * @return $this
     */
    public function setErrorMessage($error_message)
    {
        $this->error_message = $error_message;
        return $this;
    }

    /**
     * 设置数据
     *
     * @param $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}