<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/20
 * Time: 15:23
 */

namespace app\weixin\controller;

use think\Config;
use think\Controller;
use app\weixin\controller\WeiXinPublic;
use think\Db;
use think\Request;

class Index extends Controller
{
    public function queryNotice()
    {
        $res = Db::table('notice')->where(['is_roof' => 1, 'is_del' => 0])->find();
        if (empty($res) || sizeof($res == 0)) {
            $res = '暂无公告!';
        } else {
            $res = $res['content'];
        }
        return return_success($res, '查询成功!');
    }

    public function editPassword(Request $request)
    {
        $id = $request->param('id', 0);
        $old = $request->param('old', '');
        $new = $request->param('new', '');
        $true_new = $request->param('true_new', '');
        if (empty($old) || empty($new) || empty($true_new) || empty($id)) {
            return return_error('请完善信息!');
        }
        //查询信息
        $info = Db::table('emp')->where(['id' => $id])->find();
        if (empty($info) || sizeof($info) == 0) {
            return return_error('参数错误,未查询到该员工信息!');
        }
        $pass = $info['password'];
        $salt = Config::get('salt');
        $old = md5($salt . $old);
        if ($pass != $old) {
            return return_error('旧密码输入错误!');
        }
        if ($new != $true_new) {
            return return_error('新密码和确认密码输入不一致!');
        }
        $new = md5($salt . $new);
        $res = Db::table('emp')->where(['id' => $id])->update(['password' => $new]);
        if (false === $res) {
            return return_error('修改失败');
        }
        return return_success([], '修改成功!');
    }
}