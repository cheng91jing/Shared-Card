<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/17
 * Time: 9:54
 * Email: 654807719@qq.com
 */

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\library\AuthHandler;
use app\common\model\AdminIdentity;
use app\common\model\AdminUser;
use app\common\model\Partner;
use think\Exception;


class Administrator extends AdminBase
{
    protected $beforeActionList = [
        'checkLogin',
    ];

    protected function _initialize()
    {
        parent::_initialize();
        if(!empty($this->role->is_partner) && !empty($this->partner)) $this->throwPageException('商家身份需先绑定商家才能操作');
    }


    public function index()
    {
        if($this->request->isAjax()){
            $where = !empty($this->role->is_partner) ? !empty($this->partner) ? ['partner_id' => $this->partner->id] : '1 = 2' : [];
            $data = AdminUser::paginateScope($where, [], ['role', 'partner']);
            return json($data);
        }
        return $this->fetch();
    }

    public function info($admin_id = null)
    {
        if(!empty($admin_id)){
            $admin = AdminUser::get($admin_id);
            if(empty($admin)) $this->error('未知的管理员');
            if($this->partner && $admin->partner_id != $this->partner->id) $this->error('不可操作非自身商家管理员！');
        }else{
            $admin = new AdminUser();
        }
        if($this->request->isAjax()){
            try {
                $post = $this->request->post('', '', 'trim');
                $result = $this->validate($post, [
                    'username' => 'require|length:2,20|unique:admin_user,username' . (!empty($admin->id) ? ",{$admin->id},id" : ''),
                    'mobile' => 'require|length:11|number|unique:admin_user,mobile' . (!empty($admin->id) ? ",{$admin->id},id" : ''),
                    'identity_id' => 'require|number',
                    'password' => 'length:6,20' . (!empty($admin->id) ? '' : '|require'),
                ]);
                if($result !== true) throw new Exception($result);
                $identity = AdminIdentity::get($post['identity_id']);
                if(empty($identity)) throw new Exception('身份错误!');
                if($this->partner && ! $identity->is_partner) throw new Exception('商家不可选择非商家身份！');

                $admin->username = $post['username'];
                $admin->mobile = $post['mobile'];
                $admin->identity_id = $identity->identity_id;
                if(empty($admin->id))
                    $admin->auth_code = generate_rand_str(10, true);
                if(!empty($post['password']))
                    $admin->password = AuthHandler::generateHash($post['password'], [$admin->auth_code]);
                if(!empty($this->partner)) $admin->partner_id = $this->partner->id;
                $admin->save();
            } catch (Exception $e) {
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }
        $identity_arr = AdminIdentity::all(function ($query) use($admin) {
            if(!! $this->partner) $query->where('is_partner', true);
        });

        return $this->fetch('', compact('admin','identity_arr'));
    }

    public function assignPartner($partner_id, $admin_id)
    {
        try{
            if(! $this->request->isPost()) throw new Exception('请求错误！');
            $partner = Partner::get($partner_id);
            $admin = AdminUser::get($admin_id);
            if(empty($partner)) throw new Exception('未知的商家');
            if(empty($admin)) throw new Exception('未知的管理员');
            $admin->partner_id = $partner->id;
            $admin->save();
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }

    public function remove($id)
    {
        try{
            if(! $this->request->isPost()) throw new Exception('请求错误！');
            $admin = AdminUser::get($id);
            if(empty($admin)) throw new Exception('未知的管理员');
            $admin->partner_id = 0;
            $admin->save();
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }

    public function search($partner_name)
    {
        try{
            if(! $this->request->isPost()) throw new Exception('请求错误！');
            $partners = Partner::all(['partner_name' => ['LIKE' , "%{$partner_name}%"]]);
            if(empty($partners)) throw new Exception('未找到该商家');
            $this->setReturnJsonData($partners);
        }catch (Exception $e){
            $this->setReturnJsonError($e->getMessage());
        }
        return json($this->jsonReturn);
    }
}