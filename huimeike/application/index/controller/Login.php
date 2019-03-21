<?php

namespace app\index\controller;

use think\Controller;
use think\Config;
use think\Request;
use  think\Session;
use app\index\model\LoginModel;

class Login extends Controller
{
    public function login(Request $request)
    {
        if ($this->request->isPost()) {
            $username = $request->param('username', '');
            $password = $request->param('password', '');
            $code = $request->param('code', '');
            if (empty($username) || empty($password) || empty($code)) {
                $this->error('请完善信息!');
            }
            if (!captcha_check($code)) {
                //验证失败
                $this->error('验证码错误!');
            };
            //密码加密
            $salt = Config::get('salt');
            $password = md5($salt . md5($password));
            $res = LoginModel::login($username, $password);
            if ($res) {
                Session::set('username', $username);
                Session::set('password', $password);
                Session::set('is_super', $res['is_super']);
                $this->success('登录成功,即将跳转', url('/index/index'));
            }
            $this->error('账号或密码错误!');
        }
        $this->view->engine->layout(false);
        return $this->fetch('login/login');
    }

    public function Captcha()
    {
        $captcha = new Captcha();
        return $captcha->entry();
    }
}
