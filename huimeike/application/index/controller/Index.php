<?php

namespace app\index\controller;

use app\index\controller\Web;
use think\Db;
use think\Request;
use think\Session;

class Index extends Web
{
    public function index()
    {
        //查询权限列表
        $is_super = Session::get('is_super');
        if (1 == $is_super) {
            $sql = "select a.*,b.url,b.c_name,b.id as c_id,b.c_lev from (select id,menu_name,lev,icon from huimeike_menu where is_del=0 and lev=1) a left join (select id,p_id,url,menu_name as c_name,lev as c_lev  from huimeike_menu where is_del=0 and lev=2) b on a.id=b.p_id";
            $res = Db::query($sql);
        } else {

        }
        if (!empty($res) && sizeof($res) > 0) {
            foreach ($res as $v){
                $new[$v['id']][]=$v;
            }
            //遍历新数组
            foreach ($new as $k=>$v){
                $menu[$k]=['id'=>$v['id'],'menu_name'=>$v['menu_name']];
            }
        }
        $this->view->engine->layout(false);
        return $this->fetch('index/layout_index');
    }

    public function welcome()
    {
        $this->view->engine->layout(false);
        return $this->fetch('welcome');
    }

    public function logout()
    {
        Session::destroy();
        $this->success('退出成功!');
    }
}
