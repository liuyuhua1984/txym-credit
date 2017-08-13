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
use think\Config;
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


//获取action_url，用于权限验证
 function getActionUrl(){
    $action_script=$_SERVER['SCRIPT_NAME'];
    $arscript=dirname($action_script);
     $action_url = $action_script;
    $admin_url = str_replace($arscript,"",$action_script);

     \think\Log::error("位置::".$admin_url);
   //  $admin_url_no_http = str_replace("http://","",$admin_url);

    //$http_pos = strpos($admin_url,'http://');

//    if($http_pos !== false){
//
//        $admin_url_no_http = substr($admin_url,$http_pos);
//    }else{
//        $admin_url_no_http=$admin_url;
//    }
//
//
//    $slash=strpos($admin_url_no_http,'/');
//
//    if($slash){
//        $sub_dir = substr($admin_url_no_http,$slash);
//        $action_url = substr($action_script,strlen($sub_dir));
//    }else{
//        $action_url =$action_script;
 //   }
     $admin_url =  str_replace('//','/',$admin_url);
     return  str_replace('.php','',$admin_url);
}


/**
 * @param $url
 * 跳转到后台url
 */
function jumpAdminUrl($url){
    Header ( "Location: ".Config::get('_M_ADMIN_')."/$url" );
}

/**
 * @param $url
 * 跳转前台URL
 */
function jumpHomeUrl($url){
    Header ( "Location: ".Config::get('_M_HOME_')."/$url" );
}

?>