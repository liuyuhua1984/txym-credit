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
 * @param $now
 *time()转换为Y-m-d h:i:s
 * @return false|string
 */
 function convertDate($now){
    return date("Y-m-d h:i:s", $now);
}

/**
 * 生成唯一订单号
 */
 function build_order_no()
{
    $no = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    //检测是否存在
   // $db = M('Order');
   // $info = $db->where(array('number'=>$no))->find();
   // (!empty($info)) && $no = $this->build_order_no();
    return $no;

}
?>