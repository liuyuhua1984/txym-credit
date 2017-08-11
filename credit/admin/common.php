<?php

use think\Cookie;

function checkNoNeedLogin($action_url, $no_need_login_array){
    $last_slash_pos = strrpos($action_url,'/');
    $action_dir = substr($action_url,0,$last_slash_pos+1);

    if(in_array($action_url,$no_need_login_array) || in_array($action_dir,$no_need_login_array)){
        return true;
    }else{
        return false;
    }

    function getCookieRemember(){
        $encrypted = Cookie::get('osa_remember');
       // $base64=urldecode($encrypted);
        return $encrypted;
    }
}
?>