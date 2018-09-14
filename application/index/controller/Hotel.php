<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/9/14
 * Time: 15:06
 * Email: 654807719@qq.com
 */

namespace app\index\controller;

use app\common\controller\IndexBase;

class Hotel extends IndexBase
{
    public function index()
    {
        return $this->fetch();
    }

    public function yunhu()
    {
        $hotel = [
            'title' => '琼中云湖酒店',
            'type' => '高档型',
            'open_time' => '2017年装修 2017年开业',
            'header_img' => '/static/img/hotel/yunhu_header.jpg',
            'address' => '海南省琼中黎族苗族自治县琼万公路五公里处云湖度假酒店',
            'detail_img' => '/static/img/hotel/yunhu_detail.jpg',
            'mobile' => '0898-86398000'
        ];
        return $this->fetch('info', compact('hotel'));
    }

    public function haidb()
    {
        $hotel = [
            'title' => '民宿高端酒店',
            'type' => '高档型',
            'open_time' => '2018年装修 2018年开业',
            'header_img' => '/static/img/hotel/haidb_header.jpg',
            'address' => '海口市滨江路老铁桥处琼洲文化风情街',
            'detail_img' => '/static/img/hotel/haidb_detail.jpg',
            'mobile' => ''
        ];
        return $this->fetch('info', compact('hotel'));
    }
}