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

use function count;
use function json_encode;
use think\Session;
use function convertDate;
use think\Controller;
use think\Log;
use function time;
use app\home\model\FrequentContacts;

class Register extends Controller
{


    public function openLoanerRegister()
    {
        return $this->fetch("reg-c");
    }

    public function openBorrowRegister()
    {
        return $this->fetch("reg-j");
    }

    /**
     *借出者注册
     */
    public function loanerRegister()
    {
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

        $phone = Loaner::where("phone", '=', $phone_rc)->find();
        if (!empty($phone)) {
            return ["res" => -1];
        }

        $_Loaner = new Loaner();

        $_Loaner->data(['name' => $name_rc, 'phone' => $phone_rc, 'password' => $password_rc, 'sex' => $sex, 'loan_money' => $price_rc,
                        'loan_time_limit' => $time_rc, 'address' => $address_rcc, 'demand' => $require_rc, 'create_time' => convertDate(time())]);
        $_Loaner->save();

        Session::set("name", $name_rc);
        Session::delete("bBorrower");
        //具体看返回的Json 格式 xxx => xxxx
        return ["res" => 1];

    }

    /**
     * 　 x-requested-with  XMLHttpRequest
     *借入者注册
     */
    public function borrowerRegister()
    {
      //  $res = Array();
        //enctype="multipart/form-data" method="post" onsubmit="return false;"
//        phone_rj:phone_rj,
//        password_rj: password_rj,
//                    name_rj: name_rj,
//                    address_rj: address_rj,
//                    email_rj: email_rj,
//                    phone_1: phone_1,
//                    name_1: name_1,
//                    contact_1: contact_1,
//                    phone_2: phone_2,
//                    name_2: name_2,
//                    contact_2: contact_2,
//                    sex: sex,
//                    house: house,
//                    car: car,

        $phone_rj = $this->request->param("phone_rj");//手机号
        $password_rj = $this->request->param("password_rj");//密码
        $name_rj = $this->request->param("name_rj");//名字
        $address_rj= $this->request->param("address_rj");//地址
        $email_rj = $this->request->param("email_rj");//email

        $phone_1 = $this->request->param("phone_1");//借出时间
        $name_1 = $this->request->param("name_1");//借出要求
        $contact_1 = $this->request->param("contact_1");//借出要求

        $phone_2 = $this->request->param("phone_2");//借出时间
        $name_2 = $this->request->param("name_2");//借出要求
        $contact_2 = $this->request->param("contact_2");//借出要求


        $sex = $this->request->param("sex");//性别 男=1,女=2
        $house= $this->request->param("house");//有=1,无=2
        $car = $this->request->param("car");//有=1,无=2

        $id_card = ['up_img_WU_FILE_0', 'up_img_WU_FILE_1'];
        // 获取表单上传文件
        $borrowerVal = ['name' => $name_rj, 'phone' => $phone_rj, 'password' => $password_rj, 'sex' => $sex, 'email' => $email_rj,

                        'house_licence' => $house, 'address' => $address_rj, 'driver_licence' => $car, 'create_time' => convertDate(time())];
        $i = 1;
        $files = $this->request->file();
        foreach($id_card as $val){

            $file =  $files[$val];
            if (empty($file)){
               // return json_encode(["res" => -2]);
               return ["res" => -2];
            }

           // Log::error("文件::".$val);

            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>1024000,'ext'=>'gif,jpeg,jpg,bmp,png'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg

               // Log::error("扩展文件::".$info->getExtension());
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                Log::error("文件路径::".$info->getSaveName());
                $borrowerVal['id_card_'.$i++] = $info->getSaveName();

                // 输出 42a79759f284b767dfcb2a0197904287.jpg
              //  echo $info->getFilename();
               // Log::error("文件名称::".$info->getFilename());


            }else{
                // 上传失败获取错误信息
                Log::error(ROOT_PATH."文件::".$val);
                //return json_encode(["res" => -2]);
                return ["res" => -2];
            }
        }

        $phone = Borrower::where("phone", '=', $phone_rj)->find();
        if (!empty($phone)) {
           // return json_encode(["res" => -1]);
            return ["res" => -1];
        }


        $borrower = new Borrower();

        $borrower->data($borrowerVal);
        $borrower->save();

       $fContact1 = new FrequentContacts();
       $fContact1->data(['borrower_id'=> $borrower->id,'name'=>$name_1,'phone'=>$phone_1,'relation'=>$contact_1,'create_time'=>convertDate(time())]);
       $fContact1->save();


        Log::error($name_2."文件::11111111:".$borrower->id."::".$phone_2."::".$contact_2);
        $fContact2 = new FrequentContacts();
        $fContact2->data(['borrower_id'=> $borrower->id,'name'=>$name_2,'phone'=>$phone_2,'relation'=>$contact_2,'create_time'=>convertDate(time())]);
        $fContact2->save();
        Log::error(ROOT_PATH."文件222222222222::");
        //具体看返回的Json 格式 xxx => xxxx
        Session::set("name", $name_rj);
        Session::set("bBorrower", 1);

       // return json_encode(["res" => 1]);
        return ["res" => 1];
    }
}

?>