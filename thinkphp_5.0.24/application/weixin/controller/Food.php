<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/20
 * Time: 15:31
 */

namespace app\weixin\controller;

use app\weixin\controller\WeiXinPublic;
use think\Db;
use think\Request;

class Food extends WeiXinPublic
{
    //菜谱选择
    public function queryFoodList(Request $request)
    {
        $emp_id = $request->param('id', 0);
        //查询今天的菜单
        $res = Db::table('food_menu')->where(['is_del' => 0, 'add_time' => date('Y-m-d', time())])->find();
        if (!empty($res) && sizeof($res) > 0) {
            $res['end_time'] = strtotime($res['end_time']);
            unset($res['is_del']);
            //查询菜单
            $list = Db::query("select food_id,menu_id,(select name from food where food.id=food_menu_list.food_id) as name  from food_menu_list where is_del=0 and menu_id={$res['id']}");
            if (!empty($list) && sizeof($list)) {
                //查询用户已经选择的菜品
                $today = Db::table('vote')->where(['is_del' => 0, 'menu_id' => $res['id'], 'emp_id' => $emp_id])->select();
                $res['is_select'] = 0;
                if (!empty($today) && sizeof($today) > 0) {
                    $res['is_select'] = 1;
                    $today = array_values(array_column($today, 'food_id'));
                } else {
                    $today = [];
                }
                foreach ($list as &$v) {
                    if (in_array($v['food_id'], $today)) {
                        $v['is_select'] = 1;
                    } else {
                        $v['is_select'] = 0;
                    }
                }
                $res['food'] = $list;

            } else {
                $res['food'] = '';
            }
            return return_success($res, '查询成功!');
        }
        return return_error('今天无菜单!');
    }

    //菜谱选择
    public function foodVote(Request $request)
    {
        $id = $request->param('id', 0);
        $food_id = $request->param('food_id', '');
        $menu_id = $request->param('menu_id', 0);
        if (empty($id) || empty($food_id) || empty($menu_id)) {
            return return_error('参数错误!');
        }
        $food_id = explode('-', $food_id);
        foreach ($food_id as $v) {
            $insert[] = ['menu_id' => $menu_id, 'food_id' => $v, 'emp_id' => $id, 'add_time' => date('Y-m-d H:i:s', time())];
        }
        if (isset($insert) && sizeof($insert) > 0) {
            $res = Db::table('vote')->insertAll($insert);
            if (!$res) {
                return return_success('投票失败!');
            }
        }
        return return_success([], '投票成功!');
    }
}