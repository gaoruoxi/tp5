<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/18
 * Time: 11:37
 */

namespace app\index\controller;

use app\index\controller\Web;
use app\index\model\EmpModel;
use think\Config;
use think\Db;
use think\Request;

class Emp extends Web
{
    public function index(Request $request)
    {
        $phone = $request->param('phone', '');
        $name = $request->param('name', '');
        $res = EmpModel::index($phone, $name);
        return $this->fetch('emp/index', ['data' => $res,'phone'=>$phone,'name'=>$name]);
    }

    public function add()
    {
        //查询已上传的数据
        $res = EmpModel::news();
        return $this->fetch('emp/add', ['data' => $res]);
    }

    /**
     * @description   上传员工信息
     */
    public function uploadEmpData()
    {
        if (!is_dir($_SERVER['DOCUMENT_ROOT'] . '/upload/uploaddoc')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/uploaddoc', 0777, true);
        }
        $file = request()->file('empdata');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['size' => 104856975, 'ext' => 'xlsx,xls'])->move($_SERVER['DOCUMENT_ROOT'] . '/upload/uploaddoc');
        if (!$info) {
            // 上传失败获取错误信息
            echo $file->getError();
        }

        $filename = $_SERVER['DOCUMENT_ROOT'] . '/upload/uploaddoc/' . str_replace('\\', '/', $info->getSaveName());
        //赋予权限
        chmod($filename, 0777);
        $exts = $info->getExtension();
        unset($info);
        vendor('PHPExcel.PHPExcel');
        if ($exts == "xls") {
            $this->import_excel_xls($filename);
        } elseif ($exts == "xlsx") {
            $this->import_excel_xlsx($filename);
        }

    }

    private function import_excel_xls($filename)
    {
        if (!file_exists($filename)) {
            exit("文件内容不能为空!");
        } else {
            vendor("PHPExcel.Reader.Excel5");
            $phpexcelReader = new \PHPExcel_Reader_Excel5();
            $phpexcel = $phpexcelReader->load($filename);
            // 获取工作表(及当前活动的sheet)
            $currentSheet = $phpexcel->getSheet(0);
            // 获取总列数
            $allColumn = $currentSheet->getHighestColumn();
            // 获取总行数
            $allRow = $currentSheet->getHighestRow();
            //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
            for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
                //从哪列开始，A表示第一列
                for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                    //数据坐标
                    $address = $currentColumn . $currentRow;
                    //读取到的数据，保存到数组$arr中
                    $arr[$currentRow][$currentColumn] = $currentSheet->getCell($address)->getValue();
                }
            }
            $res = EmpModel::importEmployee($arr);
            is_file($filename) && unlink($filename);
            if ($res) {
                $this->success('上传成功');
            } else {
                $this->success('上传失败');
            }
        }
    }

    private function import_excel_xlsx($filename)
    {
        if (file_exists($filename)) {
            vendor("PHPExcel.Reader.Excel2007");
            $phpexcelReader = new \PHPExcel_Reader_Excel2007();
            $phpexcel = $phpexcelReader->load($filename);
            // 获取工作表(及当前活动的sheet)
            $currentSheet = $phpexcel->getSheet(0);
            // 获取总列数
            $allColumn = $currentSheet->getHighestColumn();
            // 获取总行数
            $allRow = $currentSheet->getHighestRow();
            //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
            for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
                //从哪列开始，A表示第一列
                for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                    //数据坐标
                    $address = $currentColumn . $currentRow;
                    //读取到的数据，保存到数组$arr中
                    $arr[$currentRow][$currentColumn] = $currentSheet->getCell($address)->getValue();
                }
            }
            $res = EmpModel::importEmployee($arr);
            is_file($filename) && @unlink($filename);
            if ($res) {
                $this->success('上传成功');
            } else {
                $this->success('上传失败');
            }
        } else {
            exit("文件不存在");
        }
    }

    //导出主方法
    public function exportExcel($expTitle, $expCellName, $expTableData)
    {
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = date('Y-m-d-H-i-s');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
        for ($i = 0; $i < $cellNum; $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '1', $expCellName[$i][1]);
        }
        for ($i = 0; $i < $dataNum; $i++) {
            for ($j = 0; $j < $cellNum; $j++) {
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 2), $expTableData[$i][$expCellName[$j][0]]);
            }
        }
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    /**
     *
     * 导出Excel
     */
    function expEmp()
    {//导出Excel
        $xlsName = "Emp";
        $xlsCell = array(
            array('name', '名字'),
            array('phone', '手机号'),
            array('password', '密码')
        );
        $xlsData = Db::table('emp_crs')->Field('name,phone,phone as password')->select();
        if (sizeof($xlsData) == 0) {
            $this->error('未查询到员工信息,请先导入员工信息');
        }
        $this->exportExcel($xlsName, $xlsCell, $xlsData);

    }

    /**
     *
     * 确认上传
     */
    public function save()
    {
        //判断之前数据库是否存在数据
        $is_have = Db::table('emp')->where(['is_del' => 0])->select();
        if (sizeof($is_have) > 0) {
            return return_error('已存在员工数据,无法批量上传');
        }
        //查询是否上传数据了
        $is_have = Db::table('emp_crs')->select();
        if (sizeof($is_have) == 0) {
            return return_error('未上传员工数据,无法保存');
        }
        Db::startTrans();
        try {
            //插入数据
            $res = Db::execute("insert into emp( name, gender, phone, password, type, is_del) select name,gender,phone,password,type,is_del from emp_crs;");
            if (!$res) {
                throw new \RuntimeException('操作失败');
            }
            //删除过渡表的数据
            Db::execute('truncate emp_crs');
            Db::commit();
            return return_success([], '操作成功,请关闭当前页面,然后刷新');
        } catch (\ Exception $e) {
            Db::rollback();
            return return_error('操作失败');
        }
    }

    /**
     *
     * 清除上传数据
     */
    public function clear()
    {
        Db::execute('truncate emp_crs');
        return return_success([], '操作成功');
    }

    /**
     *
     * 修改员工密码
     */
    public function editPass(Request $request)
    {
        $id = $request->param('id', 0);
        $pass = $request->param('pass', '');

        if (empty($id) || empty($pass)) {
            return return_error('参数错误,请完善信息');
        }
        //加密
        $salt = Config::get('salt');
        $pass = md5($salt . $pass);
        $res = EmpModel::editPass($id, $pass);
        if (false === $res) {
            return return_error('修改失败');
        }
        return return_success([], '操作成功');
    }

    /**
     *
     * 新增员工
     */
    public function addEmp(Request $request)
    {
        if ($this->request->isPost()) {
            $name = $request->param('name', '');
            $gender = $request->param('gender', 1);
            $phone = $request->param('phone', '');
            $password = $request->param('password', '');
            if (empty($name) || empty($phone) || empty($password)) {
                return return_error('参数错误,请完善信息');
            }
            //查询改手机号是否已经注册
            $is_have = Db::table('emp')->where(['phone' => $phone, 'is_del' => 0])->find();
            if (sizeof($is_have) > 0) {
                $this->error('该手机号已经注册!');
            }
            //加密
            $salt = Config::get('salt');
            $password = md5($salt . $password);
            $res = Db::table('emp')->insert(['name' => $name, 'gender' => $gender, 'phone' => $phone, 'password' => $password]);
            if (false === $res) {
                $this->error('新增失败');
            }
            $this->success('新增成功', url('/index/emp/index'));
        }
        return $this->fetch('emp/add_emp');
    }

    /**
     *
     * 删除员工
     */
    public function delEmp(Request $request)
    {
        $id = $request->param('id', 0);
        if (empty($id)) {
            $this->error('参数错误!');
        }
        $res = Db::table('emp')->where(['id' => $id])->update(['is_del' => 1]);
        if (false === $res) {
            $this->error('删除失败!');
        }
        $this->success('删除成功!');
    }
}