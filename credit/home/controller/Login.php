<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017/7/30
 * Time: 11:38
 */

namespace app\home\controller;

use think\Controller;
use app\home\model\Loaner;
use app\home\model\Borrower;
use think\Session;

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

    }

    /**
     *借入者登录
     */
    public  function borrowerLogin(){
        //
    }
}