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