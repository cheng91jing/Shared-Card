<?php
namespace app\index\controller;

use app\common\controller\IndexBase;
use app\common\model\UserCard;
use Carbon\Carbon;
use think\Exception;

class User extends IndexBase
{
    protected $beforeActionList = [
        'checkLogin'
    ];
    
    public function guest()
    {
        echo '<h1>访客</h1>';
        return json([]);
    }

    /**
     * 用户个人中心
     */
    public function center()
    {
        //获取用户会员卡
        $card = UserCard::getExistsCard($this->user->id);
        //会员卡图片
        $card_image = !empty($card->cat->image) ? $card->cat->image : '/static/img/center/card_ordinary.png';
        //计算期限
        $regular_days = false;
        if(empty($card)){
            $regular = '无';
        }elseif (strtotime($card->regular_start) > time()){
            $regular = '期限未至';
        }else{
            $regular = Carbon::createFromTimeString($card->regular_end)->diffInDays();
            $regular_days = true;
        }

        return $this->fetch('', compact('card', 'card_image', 'regular', 'regular_days'));
    }
}
