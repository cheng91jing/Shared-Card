<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function generate_rand_str($length = 32, $inSymbol = false){
    $str = '';
    if($inSymbol){
        for ($i = 0; $i < $length; $i++) {
            $str .= chr(mt_rand(33, 126));    //Ascii码
        }
    }else{
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters_index = strlen($characters) - 1;
        for($i = $length; $i > 0; $i--){
            $str .= $characters[mt_rand(0, $characters_index)];
        }
//        $str = substr(str_shuffle($characters), 0 - $length);
    }
    return $str;
}