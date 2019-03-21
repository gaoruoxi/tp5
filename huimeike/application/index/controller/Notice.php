<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/20
 * Time: 13:26
 */

namespace app\index\controller;

use app\index\controller\Web;
use think\Controller;
use think\Db;
use think\Request;

class Notice extends Controller
{
    //查询公告主页
    public function index()
    {
        $res = Db::table('notice')->where(['is_del' => 0])->order('id desc')->select();
        return $this->fetch('notice/index', ['data' => $res]);
    }

    //删除公告
    public function del(Request $request)
    {
        $id = $request->param('id', 0);
        if (empty($id)) {
            $this->error('参数错误!');
        }
        $res = Db::table('notice')->where(['id' => $id])->update(['is_del' => 1]);
        if (false == $res) {
            $this->error('删除失败!');
        }
        $this->success('删除成功!');
    }

    //公告置顶
    public function roof(Request $request)
    {
        $id = $request->param('id', 0);
        if (empty($id)) {
            $this->error('参数错误!');
        }
        //查询是否已经存在置顶的公告
        $is_have = Db::table('notice')->where(['is_del' => 0, 'is_roof' => 1])->find();
        if (sizeof($is_have) > 0) {
            $this->error('已经存在置顶的公告!');
        }
        $res = Db::table('notice')->where(['id' => $id])->update(['is_roof' => 1]);
        if (false == $res) {
            $this->error('置顶失败!');
        }
        $this->success('置顶成功!');
    }

    //取消公告置顶
    public function cancle_roof(Request $request)
    {
        $id = $request->param('id', 0);
        if (empty($id)) {
            $this->error('参数错误!');
        }
        $res = Db::table('notice')->where(['id' => $id])->update(['is_roof' => 0]);
        if (false == $res) {
            $this->error('取消置顶失败!');
        }
        $this->success('取消置顶成功!');
    }

    //新增公告
    public function add(Request $request)
    {
        if ($this->request->isPost()) {
            $content = $request->param('content', '');
            $is_roof = $request->param('is_roof', 0);
            if (empty($content)) {
                $this->error('参数错误!');
            }
            //查询是否已经存在置顶的公告
            $is_have = Db::table('notice')->where(['is_del' => 0, 'is_roof' => 1])->find();
            if (sizeof($is_have) > 0) {
                $this->error('已经存在置顶的公告!');
            }
            $res = Db::table('notice')->insert(['content' => $content, 'is_roof' => $is_roof]);
            if (false == $res) {
                $this->error('新增失败!');
            }
            $this->success('新增成功!', url('/index/notice/index'));
        }
        return $this->fetch('notice/add');
    }

    //编辑公告
    public function edit(Request $request)
    {
        if ($this->request->isPost()) {
            $content = $request->param('content', '');
            $is_roof = $request->param('is_roof', 0);
            $id = $request->param('id', 0);
            if (empty($content) || empty($id)) {
                $this->error('参数错误!');
            }
            //查询是否已经存在置顶的公告
            $is_have = Db::table('notice')->where(['is_del' => 0, 'is_roof' => 1])->select();
            if (sizeof($is_have) > 0) {
                $is_have = array_values(array_column($is_have, 'id'));
                $keys = array_search($id, $is_have);
                unset($is_have[$keys]);
                if (in_array($id, $is_have)) {
                    $this->error('已经存在置顶的公告!');
                }
            }
            $res = Db::table('notice')->where(['id' => $id])->update(['content' => $content, 'is_roof' => $is_roof]);
            if (false == $res) {
                $this->error('编辑失败!');
            }
            $this->success('编辑成功!', url('/index/notice/index'));
        }
        $id = $request->param('id', 0);
        if (empty($id)) {
            $this->error('参数错误!');
        }
        //查询数据
        $data = Db::table('notice')->where(['id' => $id])->find();
        return $this->fetch('notice/edit', ['data' => $data]);
    }
}