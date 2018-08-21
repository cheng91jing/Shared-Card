<?php
/**
 * Created by PhpStorm.
 * User: chenjing
 * Date: 2018/8/21
 * Time: 下午9:01
 */

namespace app\common\library;

/**
 * 权限助手
 * Class PermissionHandler
 * @package app\common\library
 */
class PermissionHandler
{
    public static $instance = null;
    //导航
    public $permissions = [];
    //权限
    public $nav = [];

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    //设置多个权限
    public function init(array $permissions)
    {
        
    }

    //新增权限
    public function push($action)
    {
        
    }

    public function del($action)
    {
        
    }

    public function can($action)
    {

    }

    public function cannot($action)
    {

    }

    public static function __callStatic($name, $arguments)
    {
        if(self::$instance === null){
            self::$instance = new self();
        }
        $self = self::getInstance();
        if(method_exists($self, $name)){
            return $self->{$name}($arguments[0]);
        }
    }


}