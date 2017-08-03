<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017/7/30
 * Time: 11:38
 */

namespace app\home\controller;

use function count;
use think\Controller;
use app\home\model\Loaner;
use app\home\model\Borrower;
use think\Session;
use think\Log;
class Login extends Controller
{

    public function  userCenter(){
        return $this->fetch('user');
    }

    public function openLoanerLogin(){
        return $this->fetch('login-c');
    }

    public function openBorrowLogin(){
        return $this->fetch('login-j');
    }

    public function exitCredit(){
        Session::delete('name');
        //重定向到News模块的Category操作
        $this->redirect('index/index');
       // return $this->fetch('index/index');
    }

    /**
     *借出者登录
     */
    public function loanerLogin(){
        //判断是否已存在
        $phone =  $this->request->param("phone");
        $password =  $this->request->param("password1");
        $loaner =  Loaner::where('phone','=',$phone)->where('password','=',$password)->find();
        if (empty($loaner)){
            return ['res' => -1];
        }

        Log::error(count($loaner)."::". gettype($loaner));


        //具体看返回的Json 格式 xxx => xxxx
        Session::set("name", $loaner['name']);

        Session::delete("bBorrower");

        return ['res' => 1];
    }

    /**
     *借入者登录
     */
    public  function borrowerLogin(){
        //

        //var phone = $("#phone-j").val();
       // var password1 = $("#password-j").val();
        $phone =  $this->request->param("phone");
        $password =  $this->request->param("password1");
        $borrower =  Borrower::where('phone','=',$phone)->where('password','=',$password)->find();
      if (empty($borrower)){
          return ['res' => -1];
      }

        //具体看返回的Json 格式 xxx => xxxx
        Session::set("name", $borrower['name']);
        Session::set("bBorrower", $borrower);

        return ['res' => 1];
    }
}