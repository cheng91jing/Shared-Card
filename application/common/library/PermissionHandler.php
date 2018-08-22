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

    public function getPermission()
    {
        return $this->permissions;
    }

    //新增权限
    public function pushAction($action)
    {
        
    }

    public function delAction($action)
    {
        
    }

    public function canAction($action)
    {
        return in_array('all', $this->permissions) || in_array($action, $this->permissions);
    }

    public function cannotAction($action)
    {

    }

    public static function __callStatic($name, $arguments)
    {
        $self = self::getInstance();
        $method = $name . 'Action';
        if($self && method_exists($self, $method)){
            return $self->{$method}($arguments[0]);
        }else{
            return false;
        }
    }

    public function __call($name, $arguments)
    {
        $self = self::getInstance();
        $method = $name . 'Action';
        if($self && method_exists($self, $method)){
            return $self->{$method}($arguments[0]);
        }else{
            return false;
        }
    }
    
}