<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/31
 * Time: 17:43
 * TODO:
 */

namespace app\home\controller;
use app\home\model\Loaner;
use app\home\model\Borrower;

use think\Controller;
class Register extends Controller
{


    public function openLoanerRegister(){
        return $this->fetch("reg-c");
    }

    public function  openBorrowRegister(){
        return $this->fetch("reg-j");
    }

    /**
     *借出者注册
     */
    public function loanerRegister(){
        //判断是否已存在

    }

    /**
     *借入者注册
     */
    public  function borrowerRegister(){
        //
    }
}

?>