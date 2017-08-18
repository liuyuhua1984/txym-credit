<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017/7/30
 * Time: 11:33
 */

namespace app\home\controller;


use app\home\model\FrequentContacts;
use think\Controller;

use app\home\model\Loaner;
use app\home\model\Borrower;

class User extends Controller
{

    /**
     *借款人显示信息
     */
    public function borrowerInfo(){
         $did = $this->request->param('did');

         $borrower = Borrower::get($did);
         if (!empty($borrower)){
             $frelist = FrequentContacts::where('borrower_id',$did)->select();
             if (!empty($frelist)){
                 $borrower['frelist'] = $frelist;
             }
             $this->assign('borrower',$borrower);
             return $this->fetch('reg-j-info');
         }else{
            return $this->redirect('Index/index');
         }
    }

    /**
     *借款人显示信息
     */
    public function loanerInfo(){
        $did = $this->request->param('did');

        $loaner = Loaner::get($did);
        if (!empty($loaner)){
            $this->assign('loaner',$loaner);
            return $this->fetch('reg-c-info');
        }else{
           return  $this->redirect('Index/index');
        }
    }


}