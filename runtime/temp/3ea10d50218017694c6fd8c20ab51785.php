<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"E:\AppServ\www\txym-credit\public/../credit/admin\view\login\login.html";i:1502361054;}*/ ?>


  <body class="simple_body">
    
    <div class="navbar">
        <div class="navbar-inner">
                <ul class="nav pull-right">
                    
                </ul>
                <a class="brand" href="__ROOT__/admin/Index/index"><span class="first"></span> <span class="second">天品></span></a>
        </div>
    </div>
<div>
<div class="container-fluid">	    
    <div class="row-fluid">	
	
    <div class="dialog">

        <div class="block">
            <p class="block-heading">登入</p>
            <div class="block-body">
                <form name="loginForm" method="post" action="" onsubmit="return false;">
                    <label>账号</label>
                    <input type="text" class="span12" id ="user_name" name="user_name" value="" required="true" autofocus="true">
                    <label>密码</label>
                    <input type="password" class="span12"  id = "password" name="password" value = "" required="true" >
                    
                     <label>验证码</label>
					<input type="text" id="verify_code_text" name="verify_code" class="span4" placeholder="输入验证码" autocomplete="off" required="required">
					<a href="#"><img title="验证码" id="verify_code" src="__ROOT__/verify_code_cn.php" style="vertical-align:top"></a>
					<div class="clearfix"><input type="checkbox" name="remember"  value="remember-me"> 记住我
					<span class="label label-info">一个月内不用再次登入</span>
                        <button type="button" class="btn btn-primary pull-right" name="loginSubmit" onclick="login();" >登录</button>
                    </div>
					
                </form>
            </div>
        </div>
        <p class="pull-right" style=""><a href="http://osadmin.org" target="blank"></a></p>
    </div>

<script type="text/javascript">

$("#verify_code").click(function(){
	var d = new Date()
	var hour = d.getHours(); 
	var minute = d.getMinutes();
	var sec = d.getSeconds();
    $(this).attr("src","__ROOT__/verify_code_cn.php?"+hour+minute+sec);
});

function login() {

    var user_name = $("#user_name").val();
    var password =  $("#password").val();
    var verify_code_text = $("#verify_code_text").val();
    var remember =$("input[type=checkbox]:checked").val();
    if (verify_code_text == null || verify_code_text == ""){
        return alert("请输入验证码");
    }


    $.ajax({
        url : "__ROOT__/admin/Login/login",
        type:"POST",
        dataType: "json",
        data: {
            'user_name': user_name,
            'password': password,
            'verify_code_text':verify_code_text,
            'remember' :remember,
        },


        success: function (data) {
            if (data.res=="1"){
                // console.log("进入这进而::"+"__ROOT__");
                window.location.href="__ROOT__/admin/Index/index";
                alert("完成申请!")
            }else if (data.res == "-1"){
                alert("角色不存在!")
            }else if (data.res == "-2"){
                alert("验证码不正确")
            }

        },

        error: function (data) {

            alert("这个错::"+data.responseText);
        }

    });
}

</script>

<{include file = "footer.html"}>


