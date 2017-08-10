<?php

namespace app\admin\controller;

use app\admin\model\AmenuUrl;
use app\admin\model\Auser;
use function implode;
use think\Controller;
use think\Log;
use think\Session;

class Index extends Controller
{
    public function index()
    {

        Log::error("进入index");

           $passport =  Session::get("user_mame");
           if (empty($passport)){
               $this->assign ( 'page_title','登入' );

               Log::error("进入login板");

               return $this->fetch("login/login");
           }

          $aUser =  Auser::where('user_name','=',$passport)->find();
        $shorts = implode(',',$aUser['shortcuts']);
        if (!empty($shorts)){
            $menus =  AMenuUrl::where('menu_id','in',$shorts)->select();
            $this->assign('menus', $menus);
            return $this->fetch();
        }else{
            $this->assign ( 'page_title','登入' );
            return $this->fetch("login/login");
        }


    }
}
