<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/18
 * Time: 11:30
 */

namespace app\index\controller;

use think\Session;
use think\Controller;

class Web extends Controller
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        //获取session
        $username = Session::get('username');
        $password = Session::get('password');
        if(empty($username)||empty($password)){
            $this->error('请先登录',url('/index/login/login'));
        }
    }
}