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

use function convertDate;
use think\Controller;
use function time;

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
//        phone_rc:phone_rc,
//        password_rc:password_rc,
//        name_rc:name_rc,
//        address_rc:address_rc,
//        price_rc:price_rc,
//        time_rc:time_rc,
//        require_rc:require_rc,
//        sex:sex,

        $phone_rc = $this->request->param("phone_rc");//手机号
        $password_rc = $this->request->param("password_rc");//密码
        $name_rc = $this->request->param("name_rc");//名字
        $address_rcc = $this->request->param("address_rc");//地址
        $price_rc = $this->request->param("price_rc");//借出资金
        $time_rc = $this->request->param("time_rc");//借出时间
        $require_rc = $this->request->param("require_rc");//借出要求
        $sex = $this->request->param("sex");//性别 男=1,女=2

        $phone = Loaner::where("phone",'=',$phone_rc)->select();
        if (!empty($phone)){
            return ["res" => -1];
        }

        $_Loaner = new Loaner();

        $_Loaner->data(['name'=>$name_rc,'phone'=>$phone_rc,'password'=> $password_rc,'sex'=>$sex,'loan_money'=>$price_rc,
                        'loan_time_limit'=>$time_rc,'address'=>$address_rcc,'demand'=>$require_rc,'create_time'=> convertDate(time())]);
        $_Loaner->save();

        //具体看返回的Json 格式 xxx => xxxx
        return ["res" => 1];

    }

    /**
     *借入者注册
     */
    public  function borrowerRegister(){
        //
    }
}

?>