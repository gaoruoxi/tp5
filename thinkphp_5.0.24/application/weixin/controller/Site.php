<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/21
 * Time: 9:02
 */

namespace app\weixin\controller;

use app\weixin\controller\WeiXinPublic;
use think\Controller;
use think\Db;
use think\Request;

class Site extends WeiXinPublic
{
    //主页查询
    public function index(Request $request)
    {
        $id = $request->param('id', 0);
        $arr = getWeek();
        //查询当前周的线路
        $this_week = Db::table('site_line')->where(['is_del' => 0, 'apply_time' => ['between', $arr]])->select();
        if (sizeof($this_week) > 0 && !empty($this_week)) {
            //查询该线路的站点
            $site_line_id = array_unique(array_values(array_column($this_week, 'id')));
            if (sizeof($site_line_id) > 0 & !empty($site_line_id)) {
                //查询当前的所有站点
                $site_id = Db::table('site_line_list')->field("site_line_list.*,site.name")->where(['site_line_list.is_del' => 0, 'site_line_id' => ['in', $site_line_id]])->join('site', 'site.id=site_line_list.site_id', 'left')->select();
                if (sizeof($site_id) > 0 && !empty($site_id)) {
                    //查询当前用户选择的站点情况
                    $select_id = Db::table('site_vote')->where(['is_del' => 0, 'site_line_id' => ['in', $site_line_id]])->select();
                    if (!empty($select_id) && sizeof($select_id) > 0) {
                        foreach ($select_id as $sv) {
                            $new_sel[$sv['site_line_id']] = $sv['site_id'];
                        }
                    }
                    //处理数组
                    foreach ($site_id as $kkk => &$vv) {
                        $site_id[$kkk]['is_select'] = 0;
                        unset( $site_id[$kkk]['is_del']);
                        unset( $site_id[$kkk]['id']);
                        $new_arr[$vv['site_line_id']][] = $site_id[$kkk];
                    }
                    foreach ($this_week as $kk => &$vvs) {
                        unset($this_week[$kk]['is_del']);
                        unset($this_week[$kk]['add_time']);
                        $this_week[$kk]['emp_select']='';
                        $vvs['site_id'] = isset($new_arr[$vvs['id']]) ? $new_arr[$vvs['id']] : '';
                        $select_ids = isset($new_sel[$vvs['id']]) ? $new_sel[$vvs['id']] : '';
                        //处理选择状态
                        foreach ($vvs['site_id'] as &$v_s_v) {
                            if (!empty($select_ids) && $select_ids == $v_s_v['site_id']) {
                                $v_s_v['is_select'] = 1;
                                $this_week[$kk]['emp_select']=['id'=>$select_ids,'name'=>$v_s_v['name']];
                            }
                        }
                        //转换结束的时间戳
                        $vvs['end_timestamp'] = strtotime($vvs['end_time']);
                        $vvs['is_out'] = 0;
                        if ($vvs['end_timestamp'] <= time()) {
                            $vvs['is_out'] = 1;
                        }
                    }
                    return return_success($this_week, '查询成功!');
                }
            }
        }
        return return_error('未查询到数据!');
    }
}