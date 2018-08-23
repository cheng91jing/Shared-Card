<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\library\PermissionHandler;
use app\common\model\AdminIdentity;
use app\common\model\AdminUser;
use think\Config;
use think\Exception;

class Jurisdiction extends AdminBase
{
    protected $beforeActionList = [
        'checkLogin',
    ];

    public function index()
    {
        if ($this->request->isAjax()) {
            $data = AdminIdentity::paginateScope();
            return json($data);
        }
        return $this->fetch();
    }

    public function identityDetail($identityId)
    {
        if (!Request::instance()->isAjax()) {
            $identity_arr = Db::table('identity')->where(['identityId' => $identityId])->find();
            if (!$identity_arr) $this->error('未发现该身份');
            $admin_jurisdiction = json_decode($identity_arr['jurisdiction'], true);

            $jurisdiction_List = \JurisdictionHelper::identityJurisdictionJudge($admin_jurisdiction);

            $this->assign('jurisdiction_List', json_encode($jurisdiction_List));
            $this->assign('identity_arr', $identity_arr);

            return $this->fetch();
        } else {
            $msg = ['error' => false, 'msg' => '修改成功'];
            try {
                $PostData     = Request::instance()->post();
                $jurisdiction = isset($PostData['jurisdiction']) ? $PostData['jurisdiction'] : [];
                //$identityId = $PostData['identityId'];
                $identity_name = $PostData['identity_name'];

                if (empty($identityId) || empty($identity_name)) throw new \Exception('系统数据不完整，请重试');
                $identity_arr = Db::table('identity')->where(['identityId' => $identityId])->find();
                if (!$identity_arr) throw new \Exception('该身份不存在！');
                if ($identity_name != $identity_arr['identity_name']) {
                    $identity_other = Db::table('identity')->where(['identity_name' => $identity_name])->find();
                    if ($identity_other) throw new \Exception('该身份名称已存在！');
                }

                $rows = Db::table('identity')->where(['identityId' => $identityId])->update(['jurisdiction' => json_encode($jurisdiction), 'identity_name' => $identity_name]);
                if (!$rows) {
                    $msg['msg'] = '没有任何修改';
                } else {
                    //重新注册当前权限
                    $user_identityId = session('administrator.identityId', '', 'think');
                    if ($identityId == $user_identityId)
                        session('administrator.jurisdiction', $jurisdiction, 'think');
                }

            } catch (\Exception $e) {
                $msg['error'] = true;
                $msg['msg']   = $e->getMessage();
            }
            return json($msg);
        }
    }

    public function add($identity_id = null)
    {
        if (empty($identity_id)) {
            $identity = new AdminIdentity();
        } else {
            $identity = AdminIdentity::get($identity_id);
        }
        if ($this->request->isAjax()) {
            try {
                $partner_id    = $this->request->post('partner_id', null);
                $identity_name = $this->request->post('identity_name', '');
                if (empty($identity_name)) throw new Exception('缺少参数');
                $identity->identity_name = $identity_name;
                if (!empty($partner_id)) {
                    $identity->partner_id = $this->request->post('partner_id');
                }
                $identity->save();
            } catch (Exception $e) {
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }

        return $this->fetch('info', compact('identity'));
    }

    /**
     * @author Chen <654807719@qq.com>
     *
     * @param $id int ID
     * @param int $type 类型 1:角色权限 0:账号权限
     *
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function permission($id, $type = 1)
    {
        $model = $type ? AdminIdentity::get($id) : AdminUser::get($id);
        if (empty($model)) $this->error('未知的角色或管理员');
        if($this->request->isAjax()){
            try{
                $model->permission_ids = implode('|', $this->request->post('permission/a', []));
                $model->save();
            }catch (Exception $e){
                $this->setReturnJsonError($e->getMessage());
            }
            return json($this->jsonReturn);
        }
        $owned = explode('|', $model->permission_ids);

        $jurisdiction = Config::get('jurisdiction');
        return $this->fetch('permission', compact('model', 'jurisdiction', 'owned'));
    }

    public function del($identityId)
    {
    }

}
