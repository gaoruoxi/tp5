<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/18
 * Time: 15:25
 */

namespace app\index\model;

use think\Db;
use think\Model;

class FoodModel extends Model
{
    public static function index()
    {
        return Db::table('food_menu')->where(['is_del' => 0])->select();
    }

    //查询入库的菜品
    public static function queryFoodList()
    {
        return Db::table('food')->where(['is_del' => 0, 'is_save' => 1])->select();
    }

    /**
     * @description 删除
     *
     */
    public static function del($id)
    {
        return Db::table('food')->where(['id' => $id])->update(['is_del' => 1]);
    }

    /**
     * @description 菜品入库
     *
     */
    public static function saves($id)
    {
        return Db::table('food')->where(['id' => $id])->update(['is_save' => 1]);
    }
    /**
     * @description 菜品取消入库
     *
     */
    public static function cancleSave($id)
    {
        return Db::table('food')->where(['id' => $id])->update(['is_save' => 0]);
    }

    /**
     * @description 详情
     *
     */
    public static function info($id)
    {
        //查询菜单数数据
        $info = Db::table('food_menu')->where(['id' => $id])->find();
        $info['food_list'] = json_decode($info['food_list'], true);
        //查询投票情况
        $count = Db::table('food_count')->where(['fs_id' => $id])->find();
        if (sizeof($count) == 0) {
            $count = 0;
        } else {
            $count = $count['count'];
        }
        $info['count'] = $count;
        return $info;
    }

    /**
     * @description 新增
     *
     */
    public static function addFood($data)
    {

    }

    /**
     * @description 查询今天的菜单列表
     *
     */
    public static function querySaveFoodMenu()
    {
        $res = Db::table('food_menu')->field("id,end_time")->where(['add_time' => date('Y-m-d', time()), 'is_del' => 0])->find();
        $res['food_list'] = Db::table('food_menu_list')->alias('a')->field('a.food_id,b.name as food_name')->join('food b', 'a.food_id=b.id', 'left')->where(['a.menu_id' => $res['id'], 'a.is_del' => 0])->select();
        return $res;
    }
}