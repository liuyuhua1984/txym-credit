<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017/8/20
 * Time: 21:35
 */

namespace app\admin\controller;

use app\home\model\FrequentContacts;
use function array_key_exists;
use function error_log;
use think\Controller;

use app\home\model\Loaner;
use app\home\model\Borrower;
use think\Log;
use think\Session;
use function var_dump;

class Usermodify extends BaseController
{
    /**
     * 出借人信息
     * @return mixed|void
     */
    public function pLoanerInfo()
    {
        $did = $this->request->param('lId');

        $loaner = Loaner::get($did);
        Log::error("dddd::" . $loaner['phone']);
        if (!empty($loaner)) {
            $this->assign('loaner', $loaner);
            return $this->fetch('LoanerModify');
        } else {
            return $this->redirect('Index/index');
        }
    }

    public function modifyLoaner(){
        $phone_rc = $this->request->param("phone");//手机号
        $password_rc = $this->request->param("password");//密码
        $name_rc = $this->request->param("name");//名字
        $address_rcc = $this->request->param("address");//地址
        $price_rc = $this->request->param("money");//借出资金
        $time_rc = $this->request->param("days");//借出时间
        $require_rc = $this->request->param("require");//借出要求

        $pId= $this->request->param('pId');

        $phone_rc =  preg_replace('/\s/','',$phone_rc);
        $password_rc =  preg_replace('/\s/','',$password_rc);
        $name_rc =  preg_replace('/\s/','',$name_rc);
        $address_rcc =  preg_replace('/\s/','',$address_rcc);
        $price_rc =  preg_replace('/\s/','',$price_rc);
        $time_rc =  preg_replace('/\s/','',$time_rc);
        $require_rc =  preg_replace('/\s/','',$require_rc);

       $loaner = Loaner::where('id','=',$pId)->find();

       if (empty($loaner)){
           return $this->error('不存在此数据');
       }

        if (!isPhoneNum($phone_rc)){
            return $this->error('请输入正确的电话号码');

        }

        if (!is_numeric($time_rc) || !is_numeric($price_rc)){
           // return ['res' => -3];
            return $this->error("借出资金与借出时间必须是数字");
        }

        $sex = $this->request->param("sex");//性别 男=1,女=2

        $phone = Loaner::where("phone", '=', $phone_rc)->find();
        if (!empty($phone) &&$phone['phone'] != $loaner['phone'] ) {
            return $this->error("电话已存在");
           // return ["res" => -1];
        }


        $_Loaner =  Loaner::where('id','=',$pId)->update(['name' => $name_rc, 'phone' => $phone_rc, 'password' => $password_rc, 'sex' => $sex, 'loan_money' => $price_rc,
                                               'loan_time_limit' => $time_rc, 'address' => $address_rcc, 'demand' => $require_rc]);
        Session::set("name", $name_rc);
        Session::delete("bBorrower");
        Session::set('loaner',$_Loaner);

        return $this->redirect('Aloaner/index');
    }

    /**
     *借款人显示信息
     */
    public function pBorrowerInfo()
    {
        $did = $this->request->param('lId');

        $borrower = Borrower::get($did);
        if (!empty($borrower)) {
            $frelist = FrequentContacts::where('borrower_id', $did)->select();
            if (!empty($frelist)) {
                $borrower['frelist'] = $frelist;
            }
            $this->assign('borrower', $borrower);
            return $this->fetch('BorrowerModify');
        } else {
            return $this->redirect('Index/index');

        }

    }

    /**
     *修改借款人
     */
    public function modifyBorrower(){
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


        $sex = $this->request->param("sex");//性别 男=1,女=2
        $house= $this->request->param("house");//有=1,无=2
        $car = $this->request->param("car");//有=1,无=2

        $did = $this->request->param('pId');

        $cId1 = $this->request->param('cId1');
        $cId2 = $this->request->param('cId2');


        if (!isPhoneNum($phone_rj) || !isPhoneNum($phone_1) || !isPhoneNum($phone_2)){
            return ['res' => -2];
        }

        if (!isEmail($email_rj)){
            return ['res' => -3];
        }

        if ($phone_rj == $phone_2 || $phone_rj == $phone_2 || $phone_1 == $phone_2){
            return ['res' => -4];
        }

        if ($name_rj == $name_1 || $name_rj == $name_2 || $name_1 == $name_2){
            return ['res' => -5];
        }


        // Log::error("进来ssssssssssssssssssssssssssssssssssssssss了");
        $id_card = ['up_img_WU_FILE_0', 'up_img_WU_FILE_1'];
        // 获取表单上传文件
        $borrowerVal = ['name' => $name_rj, 'phone' => $phone_rj, 'password' => $password_rj, 'sex' => $sex, 'email' => $email_rj,

                        'house_licence' => $house, 'address' => $address_rj, 'driver_licence' => $car];
        $i = 1;
        $files = $this->request->file();

        foreach($id_card as $val){

            if (empty($files)){
                break;
            }

            if (!array_key_exists($val,$files)){
                continue;
            }

            $file =  $files[$val];
            if (empty($file)){
                // return json_encode(["res" => -2]);
               continue;
            }

          //  error_log("文件::".$val);


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
              //  Log::error(ROOT_PATH."文件::".$val);
                //return json_encode(["res" => -2]);
                return ["res" => -2];
            }
        }

        $phone = Borrower::where("phone", '=', $phone_rj)->find();
        $borrower = Borrower::where("id", '=', $did)->find();
        if (!empty($phone) && $phone['phone'] != $borrower['phone'] ) {
            Log::error('phone'.$phone['phone']);
            Log::error($did.':bphone'.$borrower['phone']);
            return ["res" => -1];
        }





        $borrower = Borrower::where('id','=',$did)->update($borrowerVal);

        $fContact1 =  FrequentContacts::where('id',"=",$cId1)->find();
        $fContact2 =  FrequentContacts::where('id',"=",$cId2)->find();
        if (!empty($fContact1)){
            FrequentContacts::where('id','=',$cId1)->update(['borrower_id'=> $did,'name'=>$name_1,'phone'=>$phone_1,'relation'=>$contact_1]);
        }

        if (!empty($fContact2)){
            FrequentContacts::where('id','=',$cId2)->update(['borrower_id'=> $did,'name'=>$name_2,'phone'=>$phone_2,'relation'=>$contact_2]);
        }

        // Log::error(ROOT_PATH."文件222222222222::");
        //具体看返回的Json 格式 xxx => xxxx
        Session::set("name", $name_rj);
        Session::set("bBorrower", $borrower);
        Session::delete('loaner');

        return ["res" => 1];
    }

}

?>