<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/19
 * Time: 17:04
 */

namespace app\index\controller;

use app\index\controller\Web;
use app\index\model\SiteModel;
use think\Db;
use think\Exception;
use think\Request;

class  Site extends Web
{
    public function index()
    {
        $res = SiteModel::queryList();
        return $this->fetch('index', ['data' => $res]);
    }

    public function del(Request $request)
    {
        $id = $request->param('id', 0);
        if (!$id) {
            return return_error('参数错误!');
        }
        $res = SiteModel::del($id);
        if (false === $res) {
            return return_error('删除失败!');
        }
        return return_success([], '删除成功!');
    }

    public function add(Request $request)
    {
        if ($this->request->isPost()) {
            $name = $request->param('name', '');
            if (empty($name)) {
                $this->error('请输入站点名称!');
            }
            $res = Db::table('site')->insert(['name' => $name]);
            if (false === $res) {
                $this->error('新增失败!');
            }
            $this->success('新增成功!', url('index'));
        }
        return $this->fetch('add');
    }

    //查询路线列表
    public function release(Request $request)
    {
        //查询线路列表
        $data = SiteModel::queryLineList();
        return $this->fetch('release', ['data' => $data]);
    }

    //删除路线
    public function delSiteLine(Request $request)
    {
        $id = $request->param('id', 0);
        if (!$id) {
            $this->error('参数错误,请刷新页面再试!');
        }
        //查询线路列表
        $data = SiteModel::delSiteLine($id);
        if (false === $data) {
            return return_error('删除失败!');
        }
        return return_success([], '删除成功!');
    }

    //查询路线详情
    public function querySiteLineInfo(Request $request)
    {
        $id = $request->param('id', 0);
        if (!$id) {
            $this->error('参数错误,请刷新页面再试!');
        }
        //查询线路列表
        $data = SiteModel::queryLineInfo($id);
        return $this->fetch('site/info', ['data' => $data, 'id' => $id]);
    }

    //修改路线
    public function editSiteLine(Request $request)
    {
        $id = $request->param('id', 0);
        $arr = $request->param('arr', '');
        if (!$id) {
            $this->error('参数错误,请刷新页面再试!');
        }
        //修改路线
        $data = SiteModel::editSiteLine($id, $arr);
        if (false === $data) {
            return return_error('修改失败!');
        }
        return return_success([], '修改成功!');

    }

    //查询路线统计详情
    public function querySiteLineCount(Request $request)
    {
        //查询线路列表
        $data = SiteModel::queryLineList();
        return $this->fetch('site/site_count', ['data' => $data]);
    }

    //查询路线统计详情
    public function querySiteLineCountInfo(Request $request)
    {
        $id = $request->param('id', 0);
        if (!$id) {
            $this->error('参数错误,请刷新页面再试!');
        }
        $data = SiteModel::querySiteLineCountInfo($id);
        return $this->fetch('site/site_count_info', ['data' => $data]);
    }

    //新增路线
    public function addSiteLine(Request $request)
    {
        if ($this->request->isPost()) {
            $apply_time = $request->param('apply_time', '');
            $end_time = $request->param('end_time', '');
            $arr = $request->param('arr', '');
            if (empty($apply_time) || empty($end_time) || empty($arr)) {
                return return_error('请完善信息');
            }
            $arr = explode('-', $arr);
            //开启事务
            Db::startTrans();
            try {
                //检测开车时间是否已经存在
                $is_have = Db::table('site_line')->where(['apply_time' => $apply_time])->find();
                if (sizeof($is_have) > 0 && !empty($is_have)) {
                    throw  new Exception('已存在相同的开车时间的记录!');
                }
                //先插入路线
                $site_line_id = Db::table('site_line')->insertGetId(['add_time' => date('Y-m-d H:i:s', time()), 'end_time' => $end_time, 'apply_time' => $apply_time]);
                if (!$site_line_id) {
                    throw  new Exception('新增失败!');
                }
                //处理数组
                if (!empty($arr) && sizeof($arr) > 0) {
                    foreach ($arr as $v) {
                        $inser[] = ['site_id' => $v, 'site_line_id' => $site_line_id];
                    }
                    $res = Db::table('site_line_list')->insertAll($inser);
                    if (!$res) {
                        throw  new Exception('新增失败!');
                    }
                }
                Db::commit();
                return return_success([], '新增成功!');
            } catch (Exception $e) {
                Db::rollback();
                return return_error($e->getMessage());
            }
        }
        //查询站点列表
        $data = SiteModel::queryList();
        return $this->fetch('site/add_site_line', ['data' => $data]);
    }
}