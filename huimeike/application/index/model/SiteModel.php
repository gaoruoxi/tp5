<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/19
 * Time: 17:05
 */

namespace app\index\model;

use think\Db;
use think\Exception;
use think\Model;

class SiteModel extends Model
{
    public static function queryList()
    {
        return Db::table('site')->where(['is_del' => 0])->select();
    }

    public static function del($id)
    {
        return Db::table('site')->where(['id' => $id])->update(['is_del' => 1]);
    }

    public static function queryLineList()
    {
        return Db::table('site_line')->where(['is_del' => 0])->order('id desc')->select();
    }

    public static function queryLineInfo($id)
    {
        //查询当前路线的站点列表
        $current = Db::table('site_line_list')->where(['is_del' => 0, 'site_line_id' => $id])->select();           //查询所有的站点
        $all = self::queryList();
        if (sizeof($current) == 0 || empty($current)) {
            //添加是否选择的标志位
            foreach ($all as &$vv) {
                $vv['is_check'] = 0;
            }
            return $all;
        }
        $current = array_values(array_column($current, 'site_id'));
        foreach ($all as &$v) {
            if (in_array($v['id'], $current)) {
                $v['is_check'] = 1;
            } else {
                $v['is_check'] = 0;
            }
        }
        return $all;
    }

    //删除路线
    public static function delSiteLine($id)
    {
        return Db::table('site_line')->where(['id' => $id])->update(['is_del' => 1]);
    }

    //修改路线
    public static function editSiteLine($id, $arr)
    {
        //开启事务
        Db::startTrans();
        try {
            //处理id串
            if (!empty($arr) && sizeof($arr) > 0) {
                $arr = array_unique(explode('-', $arr));
                //查询旧的站点
                $old = Db::table('site_line_list')->where(['site_line_id' => $id, 'is_del' => 0])->select();
                if (!empty($old) && sizeof($old) > 0) {
                    $old = array_unique(array_values(array_column($old, 'site_id')));
                    //求交集
                    if (sizeof($old) > sizeof($arr)) {
                        $inc = array_intersect($old, $arr);
                    } else {
                        $inc = array_intersect($arr, $old);
                    }
                    //求减少的
                    if (sizeof($old) > sizeof($inc)) {
                        $reduce = array_diff($old, $inc);
                    } else {
                        $reduce = array_diff($inc, $old);
                    }
                    //删除缺少的
                    if (!empty($reduce) && sizeof($reduce) > 0) {
                        $res = Db::table('site_line_list')->where(['site_line_id' => $id, 'site_id' => ['in', $reduce]])->update(['is_del' => 1]);
                        if (false === $res) {
                            throw new Exception('操作失败!');
                        }
                    }
                    //求新增的
                    if (sizeof($arr) > sizeof($inc)) {
                        $add = array_diff($arr, $inc);
                    } else {
                        $add = array_diff($inc, $arr);
                    }
                    if (!empty($add) && sizeof($add) > 0) {
                        //查询是否存在已经删除的
                        $is_delete = Db::table('site_line_list')->where(['site_line_id' => $id, 'site_id' => ['in', $add]])->select();
                        if (!empty($is_delete) && sizeof($is_delete) > 0) {
                            $is_delete = array_unique(array_values(array_column($is_delete, 'site_id')));
                            //更新已经删除的删除状态
                            $res = Db::table('site_line_list')->where(['site_line_id' => $id, 'site_id' => ['in', $is_delete]])->update(['is_del' => 0]);
                            if (false === $res) {
                                throw new Exception('操作失败!');
                            }
                            //删除id
                            foreach ($add as $kk => $arr_vs) {
                                if (in_array($arr_vs, $add)) {
                                    unset($add[$kk]);
                                }
                            }
                        }
                        if (sizeof($add) > 0) {
                            foreach ($add as $vvs) {
                                $add_arr[] = ['site_id' => $vvs, 'site_line_id' => $id];
                            }
                        }
                        if (isset($add_arr) && sizeof($add_arr) > 0) {
                            $res = Db::table('site_line_list')->insertAll($add_arr);
                            if (!$res) {
                                throw  new  Exception('操作失败!');
                            }
                        }
                    }
                    Db::commit();
                    return true;
                } else {
                    //查询是否存在已经删除的
                    $is_delete = Db::table('site_line_list')->where(['site_line_id' => $id, 'site_id' => ['in', $arr]])->select();
                    if (!empty($is_delete) && sizeof($is_delete) > 0) {
                        $is_delete = array_unique(array_values(array_column($is_delete, 'site_id')));
                        //更新已经删除的删除状态
                        $res = Db::table('site_line_list')->where(['site_line_id' => $id, 'site_id' => ['in', $is_delete]])->update(['is_del' => 0]);
                        if (false === $res) {
                            throw new Exception('操作失败!');
                        }
                        //删除id
                        foreach ($arr as $ks => &$arr_v) {
                            if (in_array($arr_v, $arr)) {
                                unset($arr[$ks]);
                            }
                        }
                    }
                    if (sizeof($arr) > 0) {
                        //插入新的数据
                        foreach ($arr as $v) {
                            $inset_arr[] = ['site_id' => $v, 'site_line_id' => $id];
                        }
                    }

                    if (isset($inset_arr) && sizeof($inset_arr) > 0) {
                        $res = Db::table('site_line_list')->insertAll($inset_arr);
                        if (!$res) {
                            throw new Exception('操作失败!');
                        }
                    }
                    Db::commit();
                    return true;
                }
            } else {
                //删除站点
                $res = Db::table('site_line_list')->where(['site_line_id' => $id])->update(['is_del' => 1]);

                if (false === $res) {
                    throw new Exception('操作失败!');
                }
                Db::commit();
                return $res;
            }
        } catch (\Exception $e) {
            Db::rollback();
            return false;
        }
    }

    //查询路线站点统计详情
    public static function querySiteLineCountInfo($id)
    {
        $sql = "select a.site_name,ifnull(b.count,0) as count from (select distinct site_id,(select name from site where site.id=site_line_list.site_id) as site_name from site_line_list where site_line_id={$id} and is_del=0) a left join (select site_id,sum(num) as count from site_vote where is_del=0 and site_line_id={$id} group by site_id) b on a.site_id=b.site_id order by count desc;";
        $data = Db::query($sql);
        return $data;
    }
}