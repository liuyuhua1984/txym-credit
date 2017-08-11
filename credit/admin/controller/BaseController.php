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
use function checkNoNeedLogin;
use function convertDate;
use function getActionUrl;
use function getIp;
use think\Controller;
use app\admin\model\AmenuUrl;
use app\admin\model\Auser;
use app\admin\model\AuserGroup;

use function error_log;

use think\Log;
use think\Session;

class BaseController extends Controller
{
    const SESSION_NAME = "osa_user_info";

    public function _initialize()
    {
        $no_need_login_page = array("/Login/login", "/panel/logout",);

        // 如果不需要登录就可以访问的话
        $action_url = getActionUrl();

        if (checkNoNeedLogin($action_url, $no_need_login_page)) {
            // for login.php, logout.php, etc . . .
            // ;
        }
        else {
            // 否则需要验证登录信息
            if (empty(Session::get(SESSION_NAME))) {
                $user_id = getCookieRemember();
                if ($user_id > 0) {
                    loginDoSomething($user_id);
                }
            }

            checkLogin();

            User::checkActionAccess();
            $current_user_info = UserSession::getSessionInfo();
            // 如果非 AJAX 请求
            if (stripos($_SERVER['SCRIPT_NAME'], "/ajax") === false) {
                // 显示菜单、导航条、模板
                $sidebar = SideBar::getTree();

                // 是否显示 quick note
                if ($current_user_info['show_quicknote']) {
                    OSAdmin::showQuickNote();
                }

                $menu = MenuUrl::getMenuByUrl(Common::getActionUrl());
                Template::assign('page_title', $menu['menu_name']);
                Template::assign('content_header', $menu);
                Template::assign('sidebar', $sidebar);
                Template::assign('current_module_id', $menu['module_id']);
                Template::assign('user_info', UserSession::getSessionInfo());
            }
        }

        Template::assign('osa_templates', $OSA_TEMPLATES);

        $sidebarStatus = $_COOKIE['sidebarStatus'] == null ? "yes" : $_COOKIE['sidebarStatus'];
        Template::assign('sidebarStatus', $sidebarStatus);
    }

    /**
     * @param $user_id
     *存玩家
     *
     * @return mixed|void
     */
    private function loginDoSomething($user_id)
    {

        $user_info = Auser::where("user_id", '=', $user_id)->find();

        if (empty($user_info)) {
            return;
        }
        $user_info['login_time'] = convertDate(time());//登录时间

        if ($user_info['status'] != 1) {//状不为1就去登录 界面

            return $this->fetch('login/login');
        }

        //读取该用户所属用户组将该组的权限保存在$_SESSION中
        $user_group = AuserGroup::where('group_id', '=', $user_info['user_group'])->find();
        if (empty($user_group)) {
            return;
        }
        $user_info['group_id'] = $user_group['group_id'];
        $user_info['user_role'] = $user_group['group_role'];
        $user_info['shortcuts_arr'] = explode(',', $user_info['shortcuts']);
        $menu = getMenuByUrl('/admin/setting.php');
        if (strpos($user_group['group_role'], $menu['menu_id'])) {
            $user_info['setting'] = 1;
        }

        $login_time = time();
        $login_ip = getIp();
        $update_data = array('login_ip' => $login_ip, 'login_time' => $login_time);
        Auser::where('user_id', '=', $user_info['user_id'])->update($update_data);


        $user_info['login_ip'] = $login_ip;
        $user_info['login_time'] = getDateTime($login_time);
        Session::set(SESSION_NAME, $user_info);
    }


    /**
     * @param $url
     *获得菜单栏
     *
     * @return array|false|\PDOStatement|string|\think\Model
     */
    protected function getMenuByUrl($url)
    {

        $menu = AmenuUrl::where('menu_url', "=", $url)->find();
        if (!empty($menu)) {

            $module = getModuleById($menu['module_id']);
            $menu['module_id'] = $module['module_id'];
            $menu['module_name'] = $module['module_name'];
            $menu['module_url'] = $module['module_url'];
            if ($menu['father_menu'] > 0) {
                $father_menu = getMenuById($menu['father_menu']);
                $menu['father_menu_url'] = $father_menu['menu_url'];
                $menu['father_menu_name'] = $father_menu['menu_name'];
            }
            return $menu;
        }
        return array();
    }


    public static function getMenuByRole($user_role, $online = 1)
    {
        $url_array = array();
        $db = self::__instance();

        $sql = "select * from " . self::getTableName() . " me," . Module::getTableName() . " mo where me.menu_id in ($user_role) and me.online = $online and me.module_id = mo.module_id and mo.online = 1";

        $list = $db->query($sql)->fetchAll();

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

        $module = Amodule::where('menu_id', "=", $menu_id)->find();
        if (empty($module)) {
            return array();
        }
        return $module;
    }


    protected function checkLogin(){
        $user_info = Session::get(SESSION_NAME);
        if (empty($user_info)){
            return $this->fetch('login/login');
        }
    }
}


?>