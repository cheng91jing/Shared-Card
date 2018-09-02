<?php
/**
 * Created by PhpStorm.
 * User: chenjing
 * Date: 2018/8/21
 * Time: 下午9:01
 */

namespace app\common\library;


use app\common\model\AdminIdentity;

/**
 * 权限助手
 * Class PermissionHandler
 * @package app\common\library
 * @method static PermissionHandler can($action)
 * @method public PermissionHandler can($action)
 */
class PermissionHandler
{
    public static $instance = [];
    //权限
    protected $permissions = [];
    //导航
    protected $nav = [];

    protected $user = null;

    /**
     * PermissionHandler constructor.
     * @param $user \app\common\model\AdminUser
     */
    private function __construct($user)
    {
        $user_permission = explode('|',$user->permission_ids);
        $identity_permission = ($user->identity_id > 0) ? AdminIdentity::getIdentityPermission($user->identity_id) : [];
        $permissions = array_unique(array_merge($user_permission, $identity_permission));
        $this->permissions = $permissions;
        $this->user = $user;

//        $jurisdiction = Config::get('jurisdiction');
//        foreach ($jurisdiction as $jur){
//            if(!empty($jur['nav'])){
//                if(in_array('all', $permissions) || in_array($jur['id'], $permissions))
//                    $this->nav = [];
//            }else{
//
//            }
//        }
    }

    /**
     * @param $user \app\common\model\AdminUser|null
     * @return \app\common\library\PermissionHandler|array
     */
    public static function getInstance($user = null)
    {
        if($user === null){
            $user = AuthHandler::$user;
        }
        if(empty($user)) return null;
        if(empty(self::$instance[$user->id])){
            self::$instance[$user->id] = new self($user);
        }
        return self::$instance[$user->id];
    }

    public function getPermissionAction()
    {
        return $this->permissions;
    }

    public function canAction($actions)
    {
        if(in_array('all', $this->permissions)) return true;
        if(is_array($actions)){
            foreach ($actions as $action){
                if(is_array($action)){
                    foreach ($action as $a){
                        if(!in_array($a, $this->permissions)) return false;
                    }
                }else{
                    if(!in_array($action, $this->permissions)) return false;
                }
            }
            return true;
        }else{
            return  in_array($actions, $this->permissions);
        }
    }

    public function adminAction()
    {
        return $this->user->role->is_partner ? false : true;
    }

    public function cannotAction($action)
    {

    }

    public static function __callStatic($name, $arguments)
    {
        $self = self::getInstance();
        $method = $name . 'Action';
        if($self && method_exists($self, $method)){
            return $self->{$method}($arguments);
        }else{
            return false;
        }
    }

    public function __call($name, $arguments)
    {
        $self = self::getInstance();
        $method = $name . 'Action';
        if($self && method_exists($self, $method)){
            return $self->{$method}($arguments);
        }else{
            return false;
        }
    }
    
}