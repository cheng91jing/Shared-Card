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

    public function getSetParameterToArray(array $parameters)
    {
        return $this->setParameter($parameters)->transformArray();
    }
}