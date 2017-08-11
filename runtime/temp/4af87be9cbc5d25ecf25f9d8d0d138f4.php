<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:71:"E:\AppServ\www\txym-credit\public/../credit/admin\view\index\index.html";i:1502441678;s:70:"E:\AppServ\www\txym-credit\public/../credit/admin\view\sys\header.html";i:1502437869;s:71:"E:\AppServ\www\txym-credit\public/../credit/admin\view\sys\navibar.html";i:1502436891;s:71:"E:\AppServ\www\txym-credit\public/../credit/admin\view\sys\sidebar.html";i:1502443607;s:70:"E:\AppServ\www\txym-credit\public/../credit/admin\view\sys\footer.html";i:1502423038;}*/ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <!--<title><?php echo $page_title; ?> - Powered by 天品!</title>-->
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

      <link rel="stylesheet" href="_A_CSS_/bootstrap.css">

      <link rel="stylesheet" href="_A_THEME_default/theme.css">
      <link rel="stylesheet" href="_A_FONT_/css/font-awesome.css">
      <link rel="stylesheet" href="_A_CSS_/other.css">
      <link rel="stylesheet" href="_A_CSS_/jquery-ui.css" />

      <script src="_A_JS_/jquery-1.12.4.js"></script>

      <script src="_A_JS_/jquery.cookie.js" ></script>
      <script src="_A_JS_/bootbox.js"></script>
      <script src="_A_JS_/bootstrap-modal.js"></script>
      <script src="_A_JS_/other.js"></script>
      <script src="_A_JS_/jquery-ui.js"></script>
    <!-- Demo page code -->

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>

  </head>


<?php if($sidebarStatus  == 'yes'): ?>
    <body id="body" class="body">
    <?php else: ?>
    <body id="body" class="body-fullscreen">
<?php endif; ?>
<!--<![endif]-->
<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav pull-right">

            <?php if($sidebarStatus == 'yes'): ?>
                <li class="doSidebarClz"><a href="#" class="hidden-phone visible-tablet visible-desktop" role="button">
                    关闭侧栏<i class="icon-step-backward"></i>
                </a></li>
                <?php else: ?>
                <li class="doSidebarClz"><a href="#" class="hidden-phone visible-tablet visible-desktop" role="button">
                    打开侧栏<i class="icon-step-forward"></i>
                </a></li>
            <?php endif; ?>
            <!--
            <{if $user_info.setting}>
            <li id="fat-menu" class="dropdown">
                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-cog"></i>设置<i class="icon-caret-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo $smarty['const']['ADMIN_URL']; ?>/panel/setting.php">系统设置</a></li>
                </ul>
            </li>
            <{/if}>

            <li id="fat-menu" class="dropdown">
                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">

                    选择模板
                    <i class="icon-caret-down"></i>
                </a>

                <ul class="dropdown-menu">
                    <{foreach from=$osa_templates key=key item=name}>
                    <li><a href="<?php echo $smarty['const']['ADMIN_URL']; ?>/panel/set.php?t=<?php echo $key; ?>"><?php echo $name; ?></a></li>
                    <{/foreach}>
                </ul>
            </li>

                -->

            <li id="fat-menu" class="dropdown">
                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-user"></i> <?php echo \think\Session::get('user')['user_name']; ?>

                    <i class="icon-caret-down"></i>
                </a>

                <ul class="dropdown-menu">
                    <!-- <li><a tabindex="-1" href="<?php echo $smarty['const']['ADMIN_URL']; ?>/panel/profile.php">我的账号</a></li>-->
                    <li><a tabindex="-1" href="_ADMIN_/Login/logout">登出</a></li>
                </ul>
            </li>

        </ul>
        <a class="brand" href="_ADMIN_/Index/index"><span class="first"></span> <span class="second"><?php echo $smarty['const']['COMPANY_NAME']; ?></span></a>
    </div>
</div>
<?php if($sidebarStatus == 'yes'): ?>
    <div id="sidebar-nav" class="sidebar-nav">
        <?php else: ?>
        <div id="sidebar-nav" class="sidebar-nav-hide">
<?php endif; if(is_array($sidebar) || $sidebar instanceof \think\Collection || $sidebar instanceof \think\Paginator): $i = 0; $__LIST__ = $sidebar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$module): $mod = ($i % 2 );++$i;if(count($module['menu_list']) > 0): ?>

        <a href="#sidebar_menu_<?php echo $module['module_id']; ?>" class="nav-header collapsed" data-toggle="collapse">
            <i class="<?php echo $module['module_icon']; ?>"></i>
            <?php echo $module['module_name']; ?>
            <i class="icon-chevron-up"></i>
        </a>
        <?php if($module['module_id'] ==  $current_module_id): ?>
            <ul id="sidebar_menu_<?php echo $module['module_id']; ?>" class="nav nav-list collapse in">
                <?php else: ?>
                <ul id="sidebar_menu_<?php echo $module['module_id']; ?>" class="nav nav-list collapse">
        <?php endif; if(is_array($module['menu_list']) || $module['menu_list'] instanceof \think\Collection || $module['menu_list'] instanceof \think\Paginator): if( count($module['menu_list'])==0 ) : echo "" ;else: foreach($module['menu_list'] as $key=>$menu_list): if(\\//'): ?>
                <li><a target=_blank href="<?php echo $menu_list['menu_url']; ?>"><?php echo $menu_list['menu_name']; ?></a></li>
                <?php else: ?>
                <li><a href="_ADMIN_<?php echo $menu_list['menu_url']; ?>"><?php echo $menu_list['menu_name']; ?></a></li>
            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    <?php endif; endforeach; endif; else: echo "" ;endif; ?>

<a target="_blank" href="http://osadmin.org" class="nav-header"><i class="icon-question-sign"></i>帮助</a>
</div>
<!--- 以上为左侧菜单栏 sidebar --->
<?php if($sidebarStatus == 'yes'): ?>
    <div id="content" class="content">
        <?php else: ?>
        <div id="content" class="content-fullscreen">
<?php endif; ?>
<div class="header">
    <div class="stats">
        <p class="stat"><!--span class="number"></span--></p>
    </div>

    <h1 class="page-title"><?php echo $content_header['menu_name']; ?></h1>
</div>
<!--
<ul class="breadcrumb">
    <li><a href="_ADMIN_<?php echo $content_header['module_url']; ?>"> <?php echo $content_header['module_name']; ?> </a> <span class="divider">/</span></li>

    <?php if($content_header['father_menu'] != null): ?>
    <li><a href="_ADMIN_<?php echo $content_header['father_menu_url']; ?>"> <?php echo $content_header['father_menu_name']; ?> </a> <span class="divider">/</span></li>
    <?php endif; ?>

    <li class="active"><?php echo $content_header['menu_name']; ?></li>
    <?php if($content_header['shortcut_allowed'] != null): if($user_info['shortcuts_arr']): ?>

    <a title="移除快捷菜单" href="#">
        <li class="active"><i class="icon-minus" method="del" url="_ADMIN_/ajax/shortcut.php?menu_id=<?php echo $content_header['menu_id']; ?>"></i></li>
    </a>
    <?php else: ?>
    <a title="加入快捷菜单" href="#">
        <li class="active"><i class="icon-plus" method="add" url="_ADMIN_/ajax/shortcut.php?menu_id=<?php echo $content_header['menu_id']; ?>"></i></li>
    </a>
    <?php endif; endif; ?>

</ul>
-->
<div class="container-fluid">
    <div class="row-fluid">
        <div class="bb-alert alert alert-info" style="display: none;">
            <span>操作成功</span>
        </div>

<p> 进来了index</p>


<!--- START 以上内容不需更改，保证该TPL页内的标签匹配即可--->


	<div class="block">
        <a href="#page-menu" class="block-heading" data-toggle="collapse">快捷菜单</a>
        <div id="page-menu" class="block-body collapse in">
		<h3>
		<?php if(condition= "count($menus)): ?> 0"  >
			<?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?>
			<span>
				<a href="_ADMIN_/<?php echo $menu[menu_url]; ?>">
					<?php echo $menu[menu_name]; ?>
				</a>
			</span>&nbsp;
			<?php endforeach; endif; else: echo "" ;endif; endif; ?>
		</h3>
		</div> 
    </div>
	
	<div class="block">
        <a href="#page-stats" class="block-heading" data-toggle="collapse">当前用户信息</a>
        <div id="page-stats" class="block-body collapse in">
			
               <table class="table table-striped">  
						     
							 <tr>
						        <td>用户名</td>
						        <td>真实姓名</td>
						        <td>手机号</td>
						        <td>Email</td>
						        <td>登录时间</td>
						        <td>登录IP</td>
					          </tr>
						      <tr>
						        <td><?php echo $user_info['user_name']; ?></td>
						        <td><?php echo $user_info['real_name']; ?></td>
						        <td><?php echo $user_info['mobile']; ?></td>
						        <td><?php echo $user_info['email']; ?></td>
						        <td><?php echo $user_info['login_time']; ?></td>
						        <td><?php echo $user_info['login_ip']; ?></td>
					          </tr>
					        
					      </table>
		</div>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>注意！</strong>请保管好您的个人信息，一点发生密码泄露请紧急联系管理员。</div>
        </div>
    </div>

<!--- END 以下内容不需更改，请保证该TPL页内的标签匹配即可--->
					<footer>
                        <hr>
                        <p class="pull-right">A <a href="http://osadmin.org/" target="_blank">Basic Backstage Management System for China Only.</a> by <a href="http://weibo.com/osadmin" target="_blank">SomewhereYu</a>. 安卓应用【<a href="http://app.herobig.com" target="_blank">短信卫士</a>】</p>
                        <p>&copy; 2013 <a href="http://osadmin.org" target="_blank">天品</a></p>
                    </footer>
				</div>
			</div>
		</div>
    <script src="_A_JS_/bootstrap.js"></script>

<!-- 捷径的提示 -->

		<script type="text/javascript">	
			alertDismiss("alert-success", 3);
			alertDismiss("alert-info", 10);

			listenShortCut("icon-plus");
			listenShortCut("icon-minus");

			doSidebar();
		</script>
	</body>
</html>
