<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * @description 定义ajax 返回前端的成功数据格式
 * @msg 提示语
 * @result false/true 成功或失败
 * @data 返回的数据
 *
 */
function return_success($data = '', $msg = '操作成功', $code = 0, $result = true)
{
    return json(['msg' => $msg, 'data' => $data, 'result' => $result, 'code' => $code]);
}

/**
 * @description 定义ajax 返回前端的失败数据格式
 * @msg 提示语 code 参数只针对微信端
 * @result false/true 成功或失败
 * @data 返回的数据
 *
 */
function return_error($msg = '操作失败', $code = 0, $data = '', $result = false)
{
    return json(['msg' => $msg, 'data' => $data, 'result' => $result, 'code' => $code]);
}

/**
 * @description 根据value 转换性别名称
 * @data 返回的数据
 *
 */
function getGenderAttr($value)
{
    $get_data = ['0' => '男', '1' => '女', '9' => '其他'];
    if ($value != '') {
        return isset($get_data[$value]) ? $get_data[$value] : '';
    }
    return $value;
}

/**
 * @description token 生成
 * @data 返回的token
 *
 */
function setAppLoginToken($phone = '')
{
    $str = md5(uniqid(md5(microtime(true)), true));
    $str = sha1($str . $phone);
    return $str;
}

/**
 * @description 根据日期/或时间算出当前周的开始和结束日期
 * @data array
 *
 */
function getWeek($time = '', $weekStart = 1)
{
    if (empty($time)) {
        $time = date('Y-m-d H:i:s', time());
    }
    $w = date("w", strtotime($time)); //取得一周的第几天,星期天开始0-6
    $dn = $w ? $w - $weekStart : 6; //要减去的天数
    $st = date("Y-m-d", strtotime("$time  - " . $dn . "  days "));
    $en = date("Y-m-d", strtotime("$st  +6  days "));
    return array($st, $en); //返回开始和结束日期
}

/**
 * @description 根据日期/或时间算出当前是周几
 * @data str
 *
 */
function getWeekToday($time = '')
{
    if (empty($time)) {
        $time = date('Y-m-d H:i:s', time());
    }
    $w = date("w", strtotime($time)); //取得一周的第几天,星期天开始0-6
    $str = '';
    switch ($w) {
        case 0:
            $str = '周日';
            break;
        case 1:
            $str = '周一';
            break;
        case 2:
            $str = '周二';
            break;
        case 3:
            $str = '周三';
            break;
        case 4:
            $str = '周四';
            break;
        case 5:
            $str = '周五';
            break;
        case 6:
            $str = '周六';
            break;
    }
    return $str;
}
