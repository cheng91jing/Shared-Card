<?php
namespace app\index\controller;

use app\common\controller\IndexBase;
use app\common\library\Barcode;
use app\common\model\Bill;
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
        $user = $this->user;
        //获取用户会员卡
        $card = UserCard::getExistsCard($user->id);
        //会员卡图片
        $card_image = !empty($card->cat->image) ? $card->cat->image : '/static/img/center/card_ordinary.png';
        //计算期限
        $regular_days = false;
        if(empty($card)) {
            $regular = '无';
        }elseif (! $card->enable){
            $regular = '未启用';
        }elseif (strtotime($card->regular_start) > time()){
            $regular = '期限未至';
        }else{
            $regular = Carbon::createFromTimeString($card->regular_end)->diffInDays();
            $regular_days = true;
        }

        return $this->fetch('', compact('user', 'card', 'card_image', 'regular', 'regular_days'));
    }

    public function code()
    {
        $user = $this->user;
        //获取用户会员卡
        $card = UserCard::getExistsCard($user->id);

        return $this->fetch('', compact('user', 'card'));
    }

    public function paymentCode()
    {
        try{
            if(! $this->request->isPost()) throw new Exception('请求失败！');
            $user = $this->user;
            //获取用户会员卡
            $card = UserCard::getExistsCard($user->id);
            if(empty($card)) throw new Exception('您还没有会员卡！');
            $payment_code = $card->getPaymentCode1();
            if(empty($payment_code)) throw new Exception('生成付款码失败！');
            $bar = Barcode::getBarCode($payment_code);
            $qr = Barcode::getQrCode($payment_code);
            if(empty($bar) || empty($qr)) throw new Exception('生成失败！');
            $head_string = substr($payment_code, 0, 12);
            $tail_string = substr($payment_code, -6);
            $head_str = implode(' ', str_split($head_string, 4));

            $this->setReturnJsonData([
                'bar' => $bar,
                'qr' => $qr,
                'code' => $head_str . ' ' . $tail_string,
                'init_code' => '**** **** **** ' . $tail_string
            ]);
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }

    public function bill()
    {
        if($this->request->isAjax()){
            try{
                $bill_list = Bill::paginateScope(['user_id' => $this->user->id], [], [], 'add_time DESC');
                $this->setReturnJsonData($bill_list);
            }catch (Exception $e){
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }
        return $this->fetch();
    }

    public function activating()
    {
        $user = $this->user;
        //获取用户会员卡
        $card = UserCard::getExistsCard($user->id);
        return $this->fetch('', compact('user', 'card'));
    }

    public function real()
    {
        $user = $this->user;
        if($this->request->isPost()){
            try{
                $param = $this->request->post('', null, 'trim');
                if(empty($param['real_name']) || empty($param['id_code']) || strlen($param['id_code']) !== 18)
                    throw new Exception('参数错误！');
                //实名认证
                $user->is_real = true;
                $user->real_name = $param['real_name'];
                $user->id_code = $param['id_code'];
                $user->save();
            }catch (Exception $e){
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }
        return $this->fetch('', compact('user'));
    }
}
