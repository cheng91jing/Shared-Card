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


use app\common\action\Register;
use app\common\controller\AdminBase;
use think\Request;

class Administrator extends AdminBase
{
    protected $beforeActionList = [
//        'checkLogin',
//        'verifyauthority' => ['only' => 'index,updateadmin,addadmin,deladmin'],
    ];

    public function index()
    {
        return $this->fetch();
    }
    public function getList()
    {
        $PostData = Request::instance()->post();
        $SQL_start = ($PostData['page'] - 1) * $PostData['rows'];
        $records = Db::table('identity')->count();      //总记录数
        $totalPage = ceil($records/$PostData['rows']);  //总页码数
        if(!empty($PostData['sidx'])){
            $SQL_order = $PostData['sidx'] . ' ' . $PostData['sord'];
        }else{
            $SQL_order = 'identityId '. $PostData['sord'];
        }
        $identity_arr = Db::table('admin a')
            ->join('identity b', 'a.identityId = b.identityId')
            ->field('a.*,a.adminId as operation,b.identity_name')
            ->order($SQL_order)
            ->limit($SQL_start, $PostData['rows'])
            ->select();
        $result = ['page' => $PostData['page'], 'total' => $totalPage, 'records' => $records, 'rows'=>$identity_arr];
        return json($result);
    }
    public function updateAdmin($adminId)
    {
        if(!Request::instance()->isAjax()) {
            $admin_arr = Db::table('admin a')
                ->join('identity b', 'a.identityId = b.identityId')
                ->field('a.*,b.identity_name')
                ->where(['adminId' => $adminId])
                ->find();
            if (!$admin_arr) $this->error('未发现该管理员');
            $identity_arr = Db::table('identity')->select();
            $this->assign('admin_arr', $admin_arr);
            $this->assign('identity_arr', $identity_arr);
            return $this->fetch();
        }else{
            $msg = ['error' => false, 'msg' => '修改成功'];
            try{
                $PostData = Request::instance()->post();
                if(empty($PostData['identityId']) || empty($PostData['username']) || empty($PostData['adminId']))
                    throw new \Exception('系统数据不完整，请重试');
                $admin_arr = Db::table('admin')->where(['adminId' => $adminId])->find();
                if(!$admin_arr) throw new \Exception('该管理员不存在！');
                $identity_arr = Db::table('identity')->where(['identityId' => $PostData['identityId']])->find();
                if(!$identity_arr) throw new \Exception('该身份不存在！');
                if($PostData['username'] != $admin_arr['username']){
                    $admin_other = Db::table('admin')->where(['username' => $PostData['username']])->find();
                    if($admin_other) throw new \Exception('该用户名已存在！');
                }
                $update_arr = [];
                $update_arr['identityId'] = $PostData['identityId'];
                $update_arr['username'] = $PostData['username'];
                if(!empty($PostData['password'])) $update_arr['password'] = md5($PostData['password']);
                $rows = Db::table('admin')->where(['adminId' => $adminId])->update($update_arr);
                if(!$rows) $msg['msg'] = '没有任何修改';
            }catch (\Exception $e){
                $msg['error'] = true;
                $msg['msg'] = $e->getMessage();
            }
            return json($msg);
        }
    }
    public function createUser()
    {
//        if(Request::instance()->isAjax()){
            $msg = ['error' => false, 'msg' => '新增成功'];
            try{
                $user = Register::adminRegister();
                if(!$user) throw new \Exception('新增失败！');
            }catch (\Exception $e){
                $msg['error'] = true;
                $msg['msg'] = $e->getMessage();
            }
            return json($msg);
//        }
        return $this->fetch();
    }
    public function delAdmin($adminId)
    {
        $msg = ['error' => false, 'msg' => '删除成功'];
        try{
            $admin_arr = Db::table('admin')->where(['adminId' => $adminId])->find();
            if(!$admin_arr) throw new \Exception('该管理员不存在！');
            $rows = Db::table('admin')->where('adminId', $adminId)->delete();
            if(!$rows) throw new \Exception('删除失败！');
        }catch (\Exception $e){
            $msg['error'] = true;
            $msg['msg'] = $e->getMessage();
        }
        return json($msg);
    }
}