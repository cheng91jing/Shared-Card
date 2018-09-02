<?php
/**
 * Created by PhpStorm.
 * User: chenjing
 * Date: 2018/9/2
 * Time: 下午8:13
 */

namespace app\common\exception;

use Exception;
use think\exception\Handle;
use think\exception\ValidateException;
use think\exception\HttpException as ThinkHttpException;

class HttpException extends Handle
{
    public function render(Exception $e)
    {
        // 参数验证错误
        if ($e instanceof ValidateException) {
            return json($e->getError(), 422);
        }
        // 请求异常
        if ($e instanceof ThinkHttpException) {
            if(request()->module() == 'api'){
                return json([
                    'error_msg' => $e->getMessage(),
                    'error_code' => -1,
                    'data' => ''
                ], $e->getStatusCode());
            }
            if(request()->isAjax()){
                return json([
                    'error_message' => $e->getMessage(),
                    'error_code' => -1,
                    'data' => ''
                ]);
            }
        }

        return parent::render($e);
    }
}