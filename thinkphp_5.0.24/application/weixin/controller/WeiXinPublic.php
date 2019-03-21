<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/20
 * Time: 10:55
 */

namespace app\weixin\controller;

use think\Cache;
use think\Controller;

class WeiXinPublic extends Controller
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        //获取session
        $id = request()->param('id', 0);
        $tokens = request()->param('token', '');
        if (empty($id)) {
            return return_error('登录超时,请先登录!', -100);
        }
        $token = Cache::get('id');
        if (empty($token)) {
            return return_error('登录超时,请先登录!', -100);
        }
        if ($token != $tokens) {
            return return_error('登录超时,请先登录!', -100);
        }
    }
}