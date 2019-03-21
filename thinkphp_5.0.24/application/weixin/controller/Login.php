<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/20
 * Time: 10:55
 */

namespace app\weixin\controller;

use think\Controller;
use think\Config;
use think\Cache;
use think\Db;
use think\Request;

class Login extends Controller
{
    /**
     * @description 登录接口
     * @param type    登录类型    是    1-    账号密码登录
     * 2-    微信登录
     * phone    手机号    否    这两个参数只是type 为1的时候传递
     * password    密码    否
     * open_id    微信的openid    否    该参数只在type为2的时候传递
     * @time 2019-3-20
     * @author hezw
     */
    public function login(Request $request)
    {
        $phone = $request->param('phone', '');
        $password = $request->param('password', '');
        if (empty($type)) {
            return return_error('参数错误');
        }
        if (1 == $type && (empty($phone) || empty($password))) {
            return return_error('参数错误');
        }
        if (2 == $type && empty($opend_id)) {
            return return_error('参数错误');
        }
        //查询
        $info = Db::table('emp')->where(['phone' => $phone, 'password' => $password])->find();
        if (!empty($info) && sizeof($info) > 0) {
            //生成token
            $token = setAppLoginToken($phone);
            //设置缓存
            Cache::set($info['id'], $token);
            $info['token'] = $token;
            unset($info['password']);
            unset($info['type']);
            unset($info['weixin_nickname']);
            unset($info['open_id']);
            $info['gender'] = 1 == $info['gender'] ? '男' : '女';
            return return_success($info, '登录成功!');
        }
        return return_error('账号或密码错误!');
    }
}