<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/18
 * Time: 15:22
 */

namespace app\index\controller;

use app\index\controller\Web;
use app\index\model\FoodModel;
use think\Db;
use think\Exception;
use think\Request;

class Food extends Web
{
    public function index()
    {
        $res = FoodModel::querySaveFoodMenu();
        $food = FoodModel::queryFoodList();
        return $this->fetch('food/index', ['data' => $res, 'food' => $food]);
    }

    public function queryFoodList()
    {
        $res = FoodModel::queryFoodList();
        return return_success($res);
    }

    /**
     * @description 删除
     *
     */
    public function delete(Request $request)
    {
        $id = $request->param('id', 0);
        if (!$id) {
            $this->error('系统错误,请稍后再试!');
        }
        $res = FoodModel::del($id);
        if (false === $res) {
            $this->error('删除失败');
        }
        $this->success('删除成功!');
    }

    /**
     * @description 入库
     *
     */
    public function save(Request $request)
    {
        $id = $request->param('id', 0);
        if (!$id) {
            $this->error('系统错误,请稍后再试!');
        }
        $res = FoodModel::saves($id);
        if (false === $res) {
            $this->error('入库失败');
        }
        $this->success('入库成功!');
    }

    /**
     * @description 取消入库
     *
     */
    public function cancleSave(Request $request)
    {
        $id = $request->param('id', 0);
        if (!$id) {
            $this->error('系统错误,请稍后再试!');
        }
        $res = FoodModel::cancleSave($id);
        if (false === $res) {
            $this->error('取消入库失败');
        }
        $this->success('取消入库成功!');
    }

    /**
     * @description 详情
     *
     */
    public function info(Request $request)
    {
        $id = $request->param('id', 0);
        if (!$id) {
            $this->error('系统错误,请稍后再试!');
        }
        $res = FoodModel::info($id);
        if (false === $res) {
            $this->error('未查询到数据');
        }
        return $this->fetch('info', ['info' => $res]);
    }

    /**
     * @description 新增/修改
     *
     */
    public function menu(Request $request)
    {
        $id = $request->param('id', 0);
        $name_arr = $request->param('name_arr', '');
        $id_arr = $request->param('id_arr', '');
        $time = $request->param('time', '');
        if (empty($name_arr) && empty($id_arr) && empty($time)) {
            return return_error('系统错误!');
        }
        //开启事务
        Db::startTrans();
        try {
            if (empty($id)) {
                $id = Db::table('food_menu')->insertGetId(['add_time' => date('Y-m-d H:i:s', time()), 'end_time' => $time]);
                if (!$id) {
                    throw new \Exception('操作失败');
                }
            } else {
                //更新时间
                $res = Db::table('food_menu')->where(['id' => $id])->update(['end_time' => $time]);
                if (false === $res) {
                    throw new Exception('操作失败!');
                }
            }

            $menu_arr = '';
            //检查id
            $id_arr = array_unique(explode('-', $id_arr));
            if (sizeof($id_arr) > 0 && !empty($id_arr)) {
                //查询旧的菜单是否存在
                $is_have = Db::table('food_menu_list')->field('food_id')->where(['menu_id' => $id])->select();
                if (sizeof($is_have) > 0) {
                    $old = array_values(array_column($is_have, 'food_id'));
                    //求交集
                    if (sizeof($old) >= sizeof($id_arr)) {
                        $intersect = array_intersect($old, $id_arr);
                    } else {
                        $intersect = array_intersect($id_arr, $old);
                    }
                    //求减少的
                    if (sizeof($intersect) >= sizeof($old)) {
                        $reduce = array_diff($intersect, $old);
                    } else {
                        $reduce = array_diff($old, $intersect);
                    }
                    if (sizeof($reduce) > 0) { //删除减少的
                        $res = Db::table('food_menu_list')->where(['food_id' => ['in', $reduce]])->update(['is_del' => 1]);
                        if (false === $res) {
                            throw  new Exception('操作失败!');
                        }
                    }
                    //求新增的
                    if (sizeof($intersect) >= sizeof($id_arr)) {
                        $add = array_diff($intersect, $id_arr);
                    } else {
                        $add = array_diff($id_arr, $intersect);
                    }
                    if (sizeof($add) > 0) { //拼凑新增的数组
                        foreach ($add as $vs) {
                            $menu_arr[] = ['menu_id' => $id, 'food_id' => $vs];
                        }
                    }

                } else {
                    foreach ($id_arr as $vv) {
                        $menu_arr[] = ['menu_id' => $id, 'food_id' => $vv];
                    }
                }
            }
            //处理新增的
            $name_arr = explode('~', $name_arr);
            if (sizeof($name_arr) > 0 && !empty($name_arr)) {
                foreach ($name_arr as $v) {
                    if (empty($v)) {
                        continue;
                    }
                    //先查询是否存在
                    $is_have = Db::table('food')->where(['name' => $v, 'is_del' => 0])->find();
                    if (sizeof($is_have) > 0) {
                        $menu_arr[] = ['menu_id' => $id, 'food_id' => $is_have['id']];
                    } else {
                        //插入
                        $new_id = Db::table('food')->insertGetId(['name' => $v]);
                        $menu_arr[] = ['menu_id' => $id, 'food_id' => $new_id];
                    }
                }
            }
            if (sizeof($menu_arr) > 0 && !empty($menu_arr)) {
                //插入新的数据
                $res = Db::table('food_menu_list')->insertAll($menu_arr);
                if (!$res) {
                    throw new Exception('操作失败!');
                }
            }

            Db::commit();
            return return_success([], '操作成功!');
        } catch (\Exception $e) {
            Db::rollback();
            return return_error($e->getMessage());
        }
    }

    /**
     * @description 菜单列表
     */
    public function vote(Request $request)
    {
        $time = $request->param('end_time', date('Y-m-d', time()));
        $where = ['is_del' => 0];
        if (!empty($time)) {
            $where['add_time'] = $time;
        }
        $res = Db::table('food_menu')->where($where)->select();
        return $this->fetch('food/vote', ['data' => $res, 'time' => $time]);
    }

    /**
     * @description 投票统计详情
     */
    public function infos(Request $request)
    {
        //统计菜品投票
        $id = $request->param('id', 0);
        if (!$id) {
            $this->error('参数错误!');
        }
        $sql = "select a.food_name,ifnull(b.count,0) as count from (select distinct food_id,(select name from food where food.id=food_menu_list.food_id) as food_name from food_menu_list where menu_id={$id} and is_del=0) a left join
(select food_id,count(1) as count from vote where is_del=0 and menu_id={$id} group by food_id) b on a.food_id=b.food_id order by b.count+0 desc";
        $res = Db::query($sql);
        return $this->fetch('food/info', ['data' => $res]);
    }

    /**
     * @description 菜单库列表
     */
    public function fooddatabase(Request $request)
    {
        $name = $request->param('name', '');
        $where = ' where is_del=0';
        if (!empty($name)) {
            $where .= ' and name like "'.$name.'%"';
        }
        $sql = "select id,ifnull(b.count,0) as count,a.is_save,a.name from (select id,name,is_save from food " . $where . ") a left join (select food_id,count(1) as count from vote where is_del=0 group by food_id) b on a.id=b.food_id order by count desc";
        $res = Db::query($sql);
        return $this->fetch('food/food_database', ['data' => $res, 'name' => $name]);
    }
}