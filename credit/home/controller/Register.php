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
use function error_log;
use function is_numeric;
use function isEmail;
use function isPhoneNum;
use function json_encode;
use think\Session;
use function convertDate;
use think\Controller;
use think\Log;
use app\home\model\Black;
use function time;
use app\home\model\FrequentContacts;

class Register extends Controller
{

    private $contact = ["父母","亲戚","朋友","同事"];

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


        $phone_rc =  preg_replace('/\s/','',$phone_rc);
        $password_rc =  preg_replace('/\s/','',$password_rc);
        $name_rc =  preg_replace('/\s/','',$name_rc);
        $address_rcc =  preg_replace('/\s/','',$address_rcc);
        $price_rc =  preg_replace('/\s/','',$price_rc);
        $time_rc =  preg_replace('/\s/','',$time_rc);
        $require_rc =  preg_replace('/\s/','',$require_rc);

        if (!isPhoneNum($phone_rc)){
            return ['res' => -2];
        }

        if (!is_numeric($time_rc) || !is_numeric($price_rc)){
            return ['res' => -3];
        }

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
        Session::set('loaner',$_Loaner);
        //具体看返回的Json 格式 xxx => xxxx
        return ["res" => 1];

    }
//<option value="1" selected="selected">父母</option>
//<option value="2">亲戚</option>
//<option value="3">朋友</option>
//<option value="4">同事</option>



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

        $phone_1 = $this->request->param("phone_1");//联系人1手机号
        $name_1 = $this->request->param("name_1");//联系人1名称
        $contact_1 = $this->request->param("contact_1");//联系人1关系

        $phone_2 = $this->request->param("phone_2");//联系人1手机号
        $name_2 = $this->request->param("name_2");//联系人1名称
        $contact_2 = $this->request->param("contact_2");//联系人1关系

        error_log("::contact_1".$contact_1);

        $phone_rj =  preg_replace('/\s/','',$phone_rj);

        $password_rj =  preg_replace('/\s/','',$password_rj);
        $name_rj =  preg_replace('/\s/','',$name_rj);
        $address_rj =  preg_replace('/\s/','',$address_rj);
        $email_rj =  preg_replace('/\s/','',$email_rj);
        $phone_1 =  preg_replace('/\s/','',$phone_1);
        $name_1 =  preg_replace('/\s/','',$name_1);
        $contact_1 =  preg_replace('/\s/','',$contact_1);
        $phone_2 =  preg_replace('/\s/','',$phone_2);
        $name_2 =  preg_replace('/\s/','',$name_2);
        $contact_2 =  preg_replace('/\s/','',$contact_2);

        if ($contact_1 < 0 || $contact_1 > count($this->contact)){
            $contact_1 = 0;
        }


        $contact_1 = $this->contact[$contact_1];

        if ($contact_2 < 0 || $contact_2 > count($this->contact)){
            $contact_2 = 0;
        }

        $contact_2 = $this->contact[$contact_2];

        $sex = $this->request->param("sex");//性别 男=1,女=2
        $house= $this->request->param("house");//有=1,无=2
        $car = $this->request->param("car");//有=1,无=2

//
//        if (data.res == '1') {
//            console.log("进入这进而::" + "__ROOT__");
//            window.location.href = "__ROOT__";
//        } else if (data.res == '-1') {
//            alert("手机号已注册,请更换");
//        }else if (data.res == "-2"){
//            alert("手机号码参数不正确::");
//        }else if (data.res == "-3"){
//            alert("email格式不正确");
//        }else if (data.res == "-4"){
//            alert("电话号码不能一样");
//        }else if (data.res == "-5"){
//            alert("名称不能一样");
//        }else if (data.res == "-7"){
//            alert("上传文件有问题");
//        }else if (data.res == "-8"){
//            alert("不能注册");
//        }
//        else{
//            alert("错误:"+data);
//        }

        if (!isPhoneNum($phone_rj) || !isPhoneNum($phone_1) || !isPhoneNum($phone_2)){
           // return ['res' => -2];
           return $this->error("手机号码参数不正确");
        }

        if (!isEmail($email_rj)){
           // return ['res' => -3];
            return $this->error("email格式不正确");
        }

        if ($phone_rj == $phone_2 || $phone_rj == $phone_2 || $phone_1 == $phone_2){
           // return ['res' => -4];
            return $this->error("电话号码不能一样");
        }

        if ($name_rj == $name_1 || $name_rj == $name_2 || $name_1 == $name_2){
          //  return ['res' => -5];
            return $this->error("名称不能一样");
        }

        $blackList = Black::where('phone','=',$phone_rj)->find();
        if ($blackList){
           // return ["res" => -8];
            return $this->error("不能注册");
        }
       // Log::error("进来ssssssssssssssssssssssssssssssssssssssss了");
        $id_card = ['up_img_WU_FILE_0', 'up_img_WU_FILE_1'];
        // 获取表单上传文件
        $borrowerVal = ['name' => $name_rj, 'phone' => $phone_rj, 'password' => $password_rj, 'sex' => $sex, 'email' => $email_rj,

                        'house_licence' => $house, 'address' => $address_rj, 'driver_licence' => $car, 'create_time' => convertDate(time())];
        $i = 1;
        $files = $this->request->file();
        foreach($id_card as $val){

            if (empty($files)){
                Log::error("上传文件有问题11111111111111111");
               return $this->error("上传文件有问题");

               // return ["res" => -7];
            }

            if (!array_key_exists($val,$files)){
                Log::error("上传文件有问题22222222222");
                return $this->error("上传文件有问题");
               // return ["res" => -7];
            }

            $file =  $files[$val];
            if (empty($file)){
               // return json_encode(["res" => -2]);
             //  return ["res" => -7];
                Log::error("上传文件有问题33333333");
                return $this->error("上传文件有问题");
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
               // return ["res" => -2];
                return $this->error("手机号码参数不正确");
            }
        }

        $phone = Borrower::where("phone", '=', $phone_rj)->find();
        if (!empty($phone)) {
           // return json_encode(["res" => -1]);
           // return ["res" => -1];
            return $this->error("手机号已注册,请更换");
        }


        $borrower = new Borrower();

        $borrower->data($borrowerVal);
        $borrower->save();

       $fContact1 = new FrequentContacts();
       $fContact1->data(['borrower_id'=> $borrower->id,'name'=>$name_1,'phone'=>$phone_1,'relation'=>$contact_1,'create_time'=>convertDate(time())]);
       $fContact1->save();


        //Log::error($name_2."文件::11111111:".$borrower->id."::".$phone_2."::".$contact_2);
        $fContact2 = new FrequentContacts();
        $fContact2->data(['borrower_id'=> $borrower->id,'name'=>$name_2,'phone'=>$phone_2,'relation'=>$contact_2,'create_time'=>convertDate(time())]);
        $fContact2->save();
       // Log::error(ROOT_PATH."文件222222222222::");
        //具体看返回的Json 格式 xxx => xxxx
        Session::set("name", $name_rj);
        Session::set("bBorrower", $borrower);
        Session::delete('loaner');

       return $this->redirect("Index/index");
        //return ["res" => 1];
    }
}

?>