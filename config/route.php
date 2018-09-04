<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

/**
 * 定义路由
 */
//路由规则
Route::pattern([
    'id' => '\d+',
]);
//后台路由
Route::group('admin', function (){
    //架构页面
    Route::any('home', 'admin/layout/index');
});

//Route::group('index', function (){
//    Route::any('home', 'index/user/center');
//});

return [

];
