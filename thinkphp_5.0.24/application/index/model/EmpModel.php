<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/18
 * Time: 11:39
 */

namespace app\index\model;

use think\Config;
use think\Model;
use think\Db;

class EmpModel extends Model
{
    public static function index($phone,$name)
    {
        $where['is_del']=0;
        if(!empty($phone)){
            $where['phone']=$phone;
        }
        if(!empty($name)){
            $where['name']=['like',$name.'%'];
        }
        $res = Db::table('emp')->field("*,(case when gender=1 then '男' when gender=2 then '女' else '其他'end) as gender")->where($where)->paginate(10);
        return $res;
    }
    public static function news()
    {
        $res = Db::table('emp_crs')->field("*,(case when gender=1 then '男' when gender=2 then '女' else '其他'end) as gender")->where(array('is_del' => 0))->paginate(10);
        return $res;
    }

    public static function importEmployee($param)
    {
        unset($param[1]);
        sort($param);
        $salt = Config::get('salt');
        foreach ($param as $k => $v) {
            //创建插入数据
            $data[$k]['name'] = trim($v['A']);
            switch (trim($v['B'])) {
                case '男':
                    $sex = 1;
                    break;
                case '女':
                    $sex = 2;
                    break;
                default:
                    $sex = 9;
                    break;
            }
            $data[$k]['gender'] = $sex;
            $data[$k]['phone'] = trim($v['C']);
            $data[$k]['password'] = md5($salt . '123456');
        }
        if (sizeof($data) > 0) {
            //删除旧数据
            Db::execute("truncate emp_crs");
            Db::table('emp_crs')->insertAll($data);
        }
        $res = Db::table('emp_crs')->select();
        return $res;
    }
    /**
     *
     * 修改员工密码
     */
    public static function editPass($id,$pass)
    {
        return Db::table('emp')->where(['id'=>$id])->update(['password'=>$pass]);
    }
}