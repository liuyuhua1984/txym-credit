<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"E:\AppServ\www\txym-credit\public/../credit/home\view\index\index.html";i:1501837642;}*/ ?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>首页</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<link rel="stylesheet" href="_CSS_/layout.css" />
	<link href="_CSS_/mui.css" rel="stylesheet" />
	<script src="_JS_/mui.js"></script>
	<script type="text/javascript" src="_JS_/jquery-1.12.4.js" ></script>
</head>

<body>
	<!--header-->
	<header id="header" class="mui-bar mui-bar-nav">
		<h1 class="mui-title">公司名称</h1>
		<?php if(\think\Session::get('name') != null): ?>

		<a href="__ROOT__/home/Login/exitCredit" class="mui-btn-link mui-pull-right">退出</a>
		<a href="#" class="mui-btn-link mui-pull-right "><?php echo \think\Session::get('name'); ?>&nbsp;/&nbsp; </a>
		<?php else: ?>
			<a id="menu1"  href="#topPopover1" class="mui-btn-link mui-pull-right">登录</a>
			<a id="menu2"  href="#topPopover2" class="mui-btn-link mui-pull-right">注册&nbsp;/&nbsp;</a>
		<?php endif; ?>



		<!--登陆成功后显示个人中心，去掉hide类就可以了-->

	</header>

	<div class="mui-content">
		<!--贷款推荐-->
	    <div class="mui-card">

			<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($k % 2 );++$k;?>
			<div class="mui-card-header">贷款推荐 <?php echo $k; ?></div>
			<div class="mui-card-content">
				<div class="mui-card-content-inner">
					<div class="mui-input-row">
						<label>可出借资金：</label>
						<input id="price_rc"  style="padding-right: 40px;"  type="text" class="mui-input" placeholder="" maxlength="10" value="<?php echo $item['loan_money']; ?>" readonly="true">
						<span class="right-tet">元</span>
					</div>
					<div class="mui-input-row">
						<label>可出借期限：</label>
						<input id="time_rc" style="padding-right: 40px;"  type="text" class="mui-input" placeholder="" maxlength="10" value="<?php echo $item['loan_time_limit']; ?>" readonly="true">
						<span class="right-tet">日</span>
					</div>
					<p class="magin5">要求：</p>
					<p>
						<?php echo $item['demand']; ?>
					</p>
				</div>

			</div>
			<div class="mui-card-footer">
				<a class="mui-card-link"></a>
				<?php if(\think\Session::get('bBorrower') != null): ?>
					<a id='promptBtn' type="button" class="mui-card-link mui-btn mui-btn-blue mui-btn-outlined  mui-btn-block-mini" onclick=reqeustBorrow(this,"<?php echo $item['id']; ?>");>申请借贷</a>
				<?php endif; ?>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>

		</div>


		<input type="hidden" name="tIndex" value=<?php echo $tIndex; ?>>
	</div>

	<!--右上角弹出菜单-->
	<div id="topPopover1" class="mui-popover">
		<div class="mui-popover-arrow"></div>
			<ul class="mui-table-view">
				<li class="mui-table-view-cell"><a href="__ROOT__/home/Login/openLoanerLogin">出借人登录</a></li>
				<li class="mui-table-view-cell"><a href="__ROOT__/home/Login/openBorrowLogin">借款人登录</a></li>
			</ul>
        </div>
	</div>
	<div id="topPopover2" class="mui-popover">
		<div class="mui-popover-arrow"></div>
			<ul class="mui-table-view">
				<li class="mui-table-view-cell"><a href="__ROOT__/home/Register/openLoanerRegister">出借人注册</a></li>
				<li class="mui-table-view-cell"><a href="__ROOT__/home/Register/openBorrowRegister">借款人注册</a></li>
			</ul>
        </div>
	</div>
<script type="text/javascript" charset="utf-8">
	mui.init({
		swipeBack: true
	});
	//已登录弹出借贷信息

	function reqeustBorrow(e,lid){
       // e.detail.gesture.preventDefault();  //修复iOS 8.x平台存在的bug，使用plus.nativeUI.prompt会造成输入法闪一下又没了
        var btnArray = ['取消', '确定'];
        mui.prompt('请输入您借贷的信息', '', '', btnArray, function(e) {

            if (e.index == 1) {

				var money = $('#input1').val();
				var days = $('#input2').val();

				if (!money.match('^[1-9]\d*$')){
                    mui.toast("请输入金钱");
                    return;
				}

				if (!days.match('^[1-9]\d*$')){
                    mui.toast("请输入天数");
                    return;
				}
                var loaner_id = lid;
			    var borrower_id = "<?php echo \think\Session::get('bBorrower')['id']; ?>";
                //ajax发送

                $.ajax({
                    url : "__ROOT__/home/Borrow/borrowRequest",
                    type:"POST",
                    dataType: "json",
                    data: {
                        'money': money,
                        'days': days,
						'loaner_id':loaner_id,
						'borrower_id' :borrower_id,
                    },


                    success: function (data) {
                        if (data.res=="1"){
                           // console.log("进入这进而::"+"__ROOT__");
                           // window.location.href="__ROOT__";
                            alert("完成申请!")
                        }else if (data.res == "-1"){
                            alert("不存在借贷者")
                        }else if (data.res == "-2"){
                            alert("不存在借出者")
                        }

                    },

                    error: function (data) {

                        alert("这个错::"+data.responseText);
                    }

                });

            } else {
//				info.innerText = '你点了取消按钮';
            }
        })
	}

//	document.getElementById("promptBtn").addEventListener('tap', function(e) {
//		e.detail.gesture.preventDefault(); //修复iOS 8.x平台存在的bug，使用plus.nativeUI.prompt会造成输入法闪一下又没了
//		var btnArray = ['取消', '确定'];
//		mui.prompt('请输入您借贷的信息', '', '', btnArray, function(e) {
//			if (e.index == 1) {

//				info.innerText = '输出内容：' + $('#input1').val()+$('#input2').val();
//			} else {
//				info.innerText = '你点了取消按钮';
//			}
//		})
//	});
	//登录注册弹出菜单
	mui.init({
			swipeBack: true //启用右滑关闭功能
		});
		mui('.mui-scroll-wrapper').scroll();
		mui('body').on('shown', '.mui-popover', function(e) {
			//console.log('shown', e.detail.id);//detail为当前popover元素
		});
		mui('body').on('hidden', '.mui-popover', function(e) {
			//console.log('hidden', e.detail.id);//detail为当前popover元素
		});

</script>    
</body>
</html>