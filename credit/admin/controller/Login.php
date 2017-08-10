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

class Login extends Controller
{

    public function login()
    {
        Log::error("进入sdsdfaf板");
        $user_name = $this->request->param("user_name");
        $password = $this->request->param("password");
        $remember = $this->request->param("remember");
        $verify_code_text = $this->request->param("verify_code_text");
        $n_password = md5($password);

        $auser = Auser::where('user_name', '=', $user_name)->where('password', '=', $n_password)->find();

        if (empty($auser)) {
            return ['res' => -1];//角色不存在
        }


        if (strtolower($verify_code_text) != strtolower($_SESSION['osa_verify_code'])) {
            return ['res' => -2];//验证码不正确
        }
        else {

            if ($remember) {
                setAppCookie("osa_remember", $user_name, 30);
            }

        }

        Session::set("user_name", $user_name);

        return ['res' => 1];
    }
}

?>