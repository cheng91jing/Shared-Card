<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/20
 * Time: 16:14
 * Email: 654807719@qq.com
 */

namespace app\common\model;

/**
 * 用户表
 * Class AdminUser
 * @package app\common\model
 *
 * @property integer $id
 * @property string $mobile 手机号
 * @property string $password 密码
 * @property string $auth_code 鉴权随机字符串
 * @property string $login_code 登录状态鉴权随机数
 * @property string $create_time 创建时间
 * @property string $login_time 上次登录时间
 * @property string $login_ip 登录IP
 */
class User extends Base
{

}