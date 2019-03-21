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

        $this->view->engine->layout(false);
        return $this->fetch('index/layout_index');
    }

    public function welcome()
    {
        //查询统计信息
        $sql = "select name,ifnull(b.counts,0) as counts from (select id,name from food where is_del=0)a left join
    (select food_id,count(1) as counts from vote where is_del=0 group by food_id) b on a.id=b.food_id order by counts+0 desc";
        $food = Db::query($sql);
        //查询站点统计
        $sql = "select name,ifnull(b.counts,0) as counts from (select id,name from site where is_del=0)a left join
                                                  (select site_id,sum(num) as counts from site_vote where is_del=0 group by site_id) b on a.id=b.site_id order by counts+0 desc";
        $site = Db::query($sql);
        $this->view->engine->layout(false);
        return $this->fetch('welcome', ['food' => $food, 'site' => $site]);
    }

    public function logout()
    {
        Session::destroy();
        $this->success('退出成功!');
    }
}
