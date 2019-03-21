<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/18
 * Time: 10:51
 */

namespace app\index\model;

use think\Db;
use think\Model;

class LoginModel extends Model
{
    //登录
    public static function login($username = '', $password = '')
    {
        if (empty($username) || empty($password)) {
            return false;
        }
        $info = Db::table('admin')->where(array('username' => $username, 'password' => $password))->find();
        return $info;
    }
}