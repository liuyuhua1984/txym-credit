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
use think\Cookie;

/**
 * @param $now
 *time()转换为Y-m-d h:i:s
 *
 * @return false|string
 */
function convertDate($now)
{
    return date("Y-m-d h:i:s", $now);
}

/**
 * 生成唯一订单号
 */
function build_order_no()
{
    $no = date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    //检测是否存在
    // $db = M('Order');
    // $info = $db->where(array('number'=>$no))->find();
    // (!empty($info)) && $no = $this->build_order_no();
    return $no;

}


function isPost()
{
    return $_SERVER ['REQUEST_METHOD'] === 'POST' ? TRUE : FALSE;
}

function isGet()
{
    return $_SERVER ['REQUEST_METHOD'] === 'GET' ? TRUE : FALSE;
}

function getIp()
{
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
        $ip = getenv("HTTP_CLIENT_IP");
    }
    elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    }
    elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
        $ip = getenv("REMOTE_ADDR");
    }
    elseif (isset ($_SERVER ['REMOTE_ADDR']) && $_SERVER ['REMOTE_ADDR'] && strcasecmp($_SERVER ['REMOTE_ADDR'], "unknown")) {
        $ip = $_SERVER ['REMOTE_ADDR'];
    }
    else {
        $ip = "unknown";
    }
    return ($ip);
}

function getDateTime($time = null)
{

    return (!is_numeric($time)) ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', $time);
}

function getTime()
{
    return strtotime(date('Y-m-d H:i:s'));
}


function setAppCookie($cookie = "key", $encrypted, $day = 7)
{
    Cookie::set($cookie, $encrypted, time() + 3600 * 24 * $day);

}

?>