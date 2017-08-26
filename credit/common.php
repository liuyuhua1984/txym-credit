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

/**
 * @param $date
 *0点开始
 *
 * @return string
 */
function beginDate($date)
{
    return $date . " 00:00:00";
}

/**
 * @param $date
 * 23:59结束
 *
 * @return string
 */
function endDate($date)
{
    return $date . " 23:59:59";
}


function setAppCookie($cookie = "key", $encrypted, $day = 7)
{
    Cookie::set($cookie, $encrypted, time() + 3600 * 24 * $day);

}


//获取action_url，用于权限验证
function getActionUrl()
{
    $action_script = $_SERVER['SCRIPT_NAME'];
    $php_self = $_SERVER['PHP_SELF'];
    //  $arscript=dirname($action_script);
    // $action_url = $action_script;

    $admin_url = str_replace($action_script, "", $php_self);

   // \think\Log::error("位置::" . $admin_url);

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
    $action_url = str_replace('//', '/', $admin_url);
    return str_replace('.php', '', $action_url);
}


/**
 * @param $url
 * 跳转到后台url
 */
function jumpAdminUrl($url)
{
    Header("Location: " . Config::get('_M_ADMIN_') . "/$url");
}

/**
 * @param $url
 * 跳转前台URL
 */
function jumpHomeUrl($url)
{
    Header("Location: " . Config::get('_M_HOME_') . "/$url");
}


/**
 * @param $mobile
 *是否是手机电话号码
 *
 * @return bool
 */
function isPhoneNum($mobile)
{
    if (is_numeric($mobile) && preg_match("/^1[34578]\d{9}$/", $mobile)) {
        //这里有无限想象
        return true;
    }
    return false;
}


/**
 * @param $email
 *判断是否是email
 *
 * @return bool
 */
function isEmail($email)
{
    $reg = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
    if (preg_match($reg, $email)) {
        return true;
    }
    return false;
}

/**
 * @param $cardId
 *
 * @return bool
 */
function isCardId($cardId)
{
    $regIdCard = "/^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/";

    // $isIDCard1="/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$/";
//身份证正则表达式(18位)
//$isIDCard2="/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{4}$/";
    if (preg_match($regIdCard, $cardId)) {
        if (strlen($cardId) == 18) {
            $idCardWi = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2); //将前17位加权因子保存在数组里
            $idCardY = array(1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2); //这是除以11后，可能产生的11位余数、验证码，也保存成数组
            $idCardWiSum = 0; //用来保存前17位各自乖以加权因子后的总和
            for ($i = 0; $i < 17; $i++) {
                $idCardWiSum += substr($cardId, $i, $i + 1) * $idCardWi[$i];
                // $idCard.substring(i,i+1)*idCardWi[i];
            }


            $idCardMod = $idCardWiSum % 11;//计算出校验码所在数组的位置

            $idCardLast = substr($cardId, 17);//得到最后一位身份证号码

            //如果等于2，则说明校验码是10，身份证号码最后一位应该是X
            if ($idCardMod == 2) {
                if ($idCardLast == "X" || $idCardLast == "x") {
                    return true;
                }
                else {
                    return false;
                }
            }
            else {
                //用计算出的验证码与最后一位身份证号码匹配，如果一致，说明通过，否则是无效的身份证号码
                if ($idCardLast == $idCardY[$idCardMod]) {
                    return true;
                }
                else {
                    return false;
                }
            }
        }
    }
    return false;
}

/**
 * @param $array
 *对象转数组
 * @return array
 */
function object_array($array) {
    if(is_object($array)) {
        $array = (array)$array;
    } if(is_array($array)) {
        foreach($array as $key=>$value) {
            $array[$key] = object_array($value);
        }
    }
    return $array;
}

/**
 *每月还款额=[贷款本金×月利率×（1+月利率）^还款月数]÷[（1+月利率）^还款月数－1]
 */
function month_cal($months,$money,$month_interest_rate){
    return pow(($money*$month_interest_rate *(1+$month_interest_rate)),$months)/(pow((1+$month_interest_rate),$months)-1);
}
?>