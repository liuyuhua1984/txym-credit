<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/11
 * Time: 17:50
 * TODO:
 */

namespace app\admin\controller;


use app\admin\model\Amodule;
use app\admin\model\AquickNote;
use function checkNoNeedLogin;
use function convertDate;
use function getIp;
use think\Controller;
use app\admin\model\AmenuUrl;
use app\admin\model\Auser;
use app\admin\model\AuserGroup;

use function error_log;

use think\Log;
use think\Session;
use think\Cookie;
use think\Config;
use function var_dump;

class BaseController extends Controller
{
    const SESSION_NAME = "osa_user_info";

    //显示可见菜单
    const SHOW_MENU = 1;

    public function _initialize()
    {
        //   $no_need_login_page = array("/Login/login", 'Login/openLogin', "/Login/logout",);
     //   var_dump($_SERVER);
        // 如果不需要登录就可以访问的话
       $action_url = getActionUrl();

      // Log::error("action::!!!!" . $action_url);

        // 否则需要验证登录信息,如果cookie有user_id
        if (empty(Session::get(self::SESSION_NAME))) {
          //  Log::error("检测为w空!!!!");
            $user_id = getCookieRemember();
            if ($user_id > 0) {
                $status = $this->loginDoSomething($user_id);
                if (empty($status)) {
                    return ;
                }
            }
        }


        $checkNull = $this->checkLogin();

        if ($checkNull) {
            //Log::error("检测为w假!!!!".$checkNull);
            return ;
        }



        //  Log::error("检测为w假!!!!");
        // $checkAcces = $this->checkActionAccess();
        //   if ($checkAcces){
        //      return $this->error('您当前没有权限访问该功能，如需访问请联系管理员开通权限', 'index/index');
        //   }

        $current_user_info = $this->getSessionInfo();
        // 如果非 AJAX 请求
       // if (stripos($_SERVER['SCRIPT_NAME'], "/ajax") === false) {
        if (!$this->request->isAjax()){
            // 显示菜单、导航条、模板
            $sidebar = $this->getTree();

            // 是否显示 quick note
            if ($current_user_info['show_quicknote']) {
                $this->showQuickNote();
            }

            $menu = $this->getMenuByUrl(getActionUrl());

            if (empty($menu)){
                $menu = $this->getMenuById(1);
                if (!empty($menu)) {
                    $module = $this->getModuleById($menu['module_id']);
                    $menu['module_id'] = $module['module_id'];
                    $menu['module_name'] = $module['module_name'];
                    $menu['module_url'] = $module['module_url'];
                    if ($menu['father_menu'] > 0) {
                        $father_menu = $this->getMenuById($menu['father_menu']);
                        $menu['father_menu_url'] = $father_menu['menu_url'];
                        $menu['father_menu_name'] = $father_menu['menu_name'];
                    }

                }
            }
            $this->assign('page_title', $menu['menu_name']);
            $this->assign('content_header', $menu);
            $this->assign('sidebar', $sidebar);
            $this->assign('current_module_id', $menu['module_id']);
            $this->assign('user_info', $this->getSessionInfo());
        }


        $this->assign('osa_templates', Config::get('OSA_TEMPLATES'));

        $sidebarStatus = Cookie::get('sidebarStatus') == null ? "yes" : Cookie::ge('sidebarStatus');
        $this->assign('sidebarStatus', $sidebarStatus);
    }

    /**
     * @param $user_id
     *存玩家
     *
     * @return mixed|void
     */
    protected function loginDoSomething($user_id)
    {

        $user_info = Auser::where("user_id", '=', $user_id)->find();

        if (empty($user_info)) {
          //  Log::info('把user存入dddddd容器');
            return 0;
        }
        $user_info['login_time'] = convertDate(time());//登录时间

        if ($user_info['status'] != 1) {//状不为1就去登录 界面

            return 0;
        }

        //读取该用户所属用户组将该组的权限保存在$_SESSION中
        $user_group = AuserGroup::where('group_id', '=', $user_info['user_group'])->find();
        if (empty($user_group)) {
            return 0;
        }

        $user_info['group_id'] = $user_group['group_id'];
        $user_info['user_role'] = $user_group['group_role'];
        $user_info['shortcuts_arr'] = explode(',', $user_info['shortcuts']);
        $menu = $this->getMenuByUrl('/panel/setting.php');
        if (!empty($menu)) {
            if (strpos($user_group['group_role'], $menu['menu_id'])) {
                $user_info['setting'] = 1;
            }
        }

        $login_time = time();
        $login_ip = getIp();
        $update_data = array('login_ip' => $login_ip, 'login_time' => $login_time);
        Auser::where('user_id', '=', $user_info['user_id'])->update($update_data);


        $user_info['login_ip'] = $login_ip;
        $user_info['login_time'] = getDateTime($login_time);
        Session::set(self::SESSION_NAME, $user_info);

    }


    /**
     * @param $url
     *获得菜单栏
     *
     * @return array|false|\PDOStatement|string|\think\Model
     */
    protected function getMenuByUrl($url)
    {

      //  Log::error("url::".$url);
        $menu = AmenuUrl::where('menu_url', "=", $url)->find();
        if (!empty($menu)) {

            $module = $this->getModuleById($menu['module_id']);
            $menu['module_id'] = $module['module_id'];
            $menu['module_name'] = $module['module_name'];
            $menu['module_url'] = $module['module_url'];
            if ($menu['father_menu'] > 0) {
                $father_menu = $this->getMenuById($menu['father_menu']);
                $menu['father_menu_url'] = $father_menu['menu_url'];
                $menu['father_menu_name'] = $father_menu['menu_name'];
            }
            return $menu;
        }
        return array();
    }

    public function getSessionInfo()
    {
        return Session::get(self::SESSION_NAME);
    }

//    public function checkActionAccess()
//    {
//        $action_url = getActionUrl();
//
//        Log::error('權限:' . $action_url);
//
//        $user_info = $this->getSessionInfo();
//
//        $role_menu_url = $this->getMenuByRole($user_info['user_role']);
//        // var_dump($role_menu_url);
//        $search_result = in_array($action_url, $role_menu_url);
//        if (!$search_result) {
//            // Common::exitWithMessage ('您当前没有权限访问该功能，如需访问请联系管理员开通权限','index.php' );
//            return true;
//        }
//    }

    public function getMenuByRole($user_role, $online = 1)
    {
        $url_array = array();
        $SQL = "me.menu_id in($user_role) AND me.online=$online AND me.module_id=mo.module_id AND mo.online=1";
        $list = AmenuUrl::alias('me')->join('__AMODULE__ mo', $SQL)->select();

        //  $sql = "select * from " . self::getTableName() . " me," . Module::getTableName() . " mo where me.menu_id in ($user_role) and me.online = $online and me.module_id = mo.module_id and mo.online = 1";

        //  $list = $db->query($sql)->fetchAll();

        if ($list) {
            foreach ($list as $menu_info) {
                $url_array[] = $menu_info['menu_url'];
            }
            return $url_array;
        }
        return array();
    }

    /**
     * @param $menu_id
     *获得菜单栏
     *
     * @return array|bool|false|\PDOStatement|string|\think\Model
     */
    protected function getMenuById($menu_id)
    {
        if (!$menu_id || !is_numeric($menu_id))
            return false;

        $module = AmenuUrl::where('menu_id', "=", $menu_id)->find();
        if (empty($module)) {
            return array();
        }
        return $module;
    }


    protected function checkLogin()
    {
        $user_info = Session::get(self::SESSION_NAME);
        if (empty($user_info)) {
            return true;
        }
        return false;
    }


    protected function getTree()
    {

        $user_info = $this->getSessionInfo();
        //功能菜单
        $data = array();
        $data = $this->getAllModules(1);

        $user_info = $this->getSessionInfo();
        //用户的权限
        $access = $this->getMenuByRole($user_info ['user_role']);

        foreach ($data as $k => $module) {
            $list = $this->getlistByModuleId($module ['module_id'], 'sidebar');

            if (!$list) {
                unset ($data [$k]);
                continue;
            }
            //去除无权限访问的
            foreach ($list as $key => $value) {
                if (!in_array($value ['menu_url'], $access)) {
                    unset ($list [$key]);
                }
            }
            $data [$k] ['menu_list'] = $list;
        }
        return $data;
    }

    protected function getMenuShortCuts()
    {

        $user_info = $this->getSessionInfo();
        //功能菜单
        $data = array();
        $data = $this->getAllModule();
        $user_info = $this->getSessionInfo();
        //用户的权限
        $access = $this->getMenuByRole($user_info ['user_role']);

        foreach ($data as $k => $module) {
            $list = $this->getlistByModuleId($module['module_id'], 'shortcut');
            if (!$list) {
                unset ($data [$k]);
                continue;
            }
            //去除无权限访问的
            foreach ($list as $key => $value) {
                if (!in_array($value ['menu_url'], $access)) {
                    unset ($list [$key]);
                }
            }
            $data [$k] ['menu_list'] = $list;
        }
        return $data;
    }

    protected function getModuleById($module_id)
    {
        if (!$module_id || !is_numeric($module_id)) {
            return false;
        }
        $module = Amodule::where('module_id', '=', $module_id)->find();
        if ($module) {
            return $module;
        }
        return array();
    }

    //列表
    protected function getAllModules($is_online = null)
    {

        if (!empty($is_online)) {
            $list = Amodule::where('online', '=', $is_online)->order(array('module_sort' => 'asc', 'module_id' => 'asc'))->select();
        }
        else {
            $list = Amodule::order(array('module_sort' => 'asc', 'module_id' => 'asc'))->select();
        }

        if ($list) {
            return $list;
        }
        return array();
    }


    protected function getListByModuleId($module_id, $type = "all")
    {
        if (!$module_id || !is_numeric($module_id)) {
            return array();
        }

        switch ($type) {
            case "sidebar":
                $sub_condition["is_show"] = 1;
                $sub_condition["online"] = 1;
                break;
            case "role":
                $sub_condition["online"] = 1;
                break;
            case "navibar":
                $sub_condition["is_show"] = 1;
                $sub_condition["online"] = 1;
                break;
            // default:
        }

        $sub_condition["module_id"] = $module_id;
        $list = AmenuUrl::where($sub_condition)->select();

        if ($list)
            return $list;
        return array();
    }


    protected function getRandomNote()
    {
        $min = AquickNote::min('note_id');
        $max = AquickNote::max('note_id');

        if ($max && $min) {
            $note_id = rand($min, $max);
            $condition['note_id[>=]'] = $note_id;
            $list = AquickNote::where('note_id', '=', $note_id)->find();

            if ($list) {
                return $list;
            }
        }
        return array();
    }

    protected function showQuickNote()
    {
        $note = $this->getRandomNote();
        $note_content = $note['note_content'];
        $note_html = "<div class=\"alert alert-info\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>$note_content</div>";
        $this->assign("osadmin_quick_note", $note_html);
    }


}

?>