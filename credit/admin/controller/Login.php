<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/10
 * Time: 15:46
 * TODO:
 */

namespace app\admin\controller;


use app\admin\model\Auser;
use function md5;
use think\Controller;
use think\Session;
use think\Log;
class Login extends BaseController
{


    public function openLogin(){
        $this->assign('page_title', '登入');
        return $this->fetch('login');
    }

    public function login()
    {

        Log::error(session_id().":进入sdsdfaf板::".Session::get('osa_verify_code'));
        $user_name = $this->request->param("user_name");
        $password = $this->request->param("password");
        $remember = $this->request->param("remember");
        $verify_code_text = $this->request->param("verify_code_text");
        $n_password = md5($password);

        $auser = Auser::where('user_name', '=', $user_name)->where('password', '=', $n_password)->find();

        if (empty($auser)) {
            return ['res' => -1];//角色不存在
        }


        if (strtolower($verify_code_text) != strtolower(Session::get('osa_verify_code'))) {
            return ['res' => -2];//验证码不正确
        }
        else {

            if($auser['status']==1){
                $this->loginDoSomething($auser['user_id']);
            }
            if ($remember) {
                setAppCookie("osa_remember", $auser['user_id'], 30);
            }

        }

        //Session::set("user", $auser);

        return ['res' => 1];
    }


    public function logOut(){

        setAppCookie("osa_remember","",time()-3600);
        Session::delete("user");
        Session::delete("osa_timezone");

    }
}

?>