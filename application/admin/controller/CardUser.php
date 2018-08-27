<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\CardCategory;
use app\common\model\User;
use app\common\model\UserCard;
use think\Db;
use think\Exception;


class CardUser extends AdminBase
{
    protected $beforeActionList = [
        'checkLogin',
    ];

    public function index()
    {
        if ($this->request->isAjax()) {
            $data = UserCard::paginateScope([], [], ['user', 'cat']);
            return json($data);
        }
        //有效的卡类型
        $card_cat = CardCategory::scope(['available'])->select();
        return $this->fetch('', compact('card_cat'));
    }

    public function info($id)
    {
        if (empty($id)) {
            return $this->error('未知的会员卡');
        } else {
            $user_card = UserCard::get($id);
            if(empty($user_card)) return $this->error('未知的会员卡');
        }
        if ($this->request->isAjax()) {
            try {
                throw new Exception('暂不支持修改');
            } catch (Exception $e) {
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }
        if(!$user_card->activating_status){
            $user_card->password = UserCard::getCardPassword($user_card);
        }
        dump($user_card->getPaymentCode());
        return $this->fetch('info', compact('user_card'));
    }

    public function grant()
    {
        if($this->request->isAjax()){
            Db::startTrans();
            try{
                $user_mobiles = $this->request->post("user_mobile", null);
                $cat_id = $this->request->post("cat_id", null);
                $cat = CardCategory::get($cat_id);
                if(empty($cat)) throw new Exception('该会员卡类型不存在');
                $user_mobiles = array_filter(explode('|', $user_mobiles));
                if(empty($user_mobiles)) throw new Exception('请输入用户手机号！');
                foreach ($user_mobiles as $mobile){
                    $user = User::get(['mobile' => $mobile]);
                    if(empty($user)) throw new Exception("用户：{$mobile} 未找到");
                    UserCard::grant($user, $cat);
                }
                Db::commit();
            }catch (Exception $e){
                Db::rollback();
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }
        return $this->fetch('', []);
    }

    //批量生成卡密
    public function batch()
    {
        try{
            if(!$this->request->isPost()) throw new Exception('请求错误');
            $cat_id = $this->request->post("cat_id", null);
            $number = $this->request->post("number", 0);
            if(empty($cat_id) || !is_numeric($number) || $number <= 0) throw new Exception('请求参数错误！');

            $cat = CardCategory::get($cat_id);
            if(empty($cat)) throw new Exception('该会员卡类型不存在');
            UserCard::batch($cat, $number);
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }

    public function status($id, $status)
    {
        try{
            if(!$this->request->isPost()) throw new Exception('请求错误');
            $cat = UserCard::get($id);
            if(empty($cat)) throw new Exception('不存在的会员卡');
            $cat->status = $status ? true : false;
            $cat->save();
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }
}
