<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"E:\AppServ\www\txym-credit\public/../credit/home\view\login\login-j.html";i:1501743415;}*/ ?>
<!DOCTYPE html>
<html class="ui-page-login">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <title>借款人登录</title>
    <link rel="stylesheet" href="_CSS_/layout.css"/>
    <link href="_CSS_/mui.css" rel="stylesheet"/>
</head>

<body>
<header class="mui-bar mui-bar-nav">
    <a href="javascript:history.go(-1)" class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">借款人登录</h1>
</header>
<div class="mui-content">
    <form id='login-form' class="mui-input-group">
        <div class="mui-input-row">
            <label>手机号</label>
            <input id='phone-j' type="number" class="mui-input-clear mui-input" placeholder="请输入手机号">
        </div>
        <div class="mui-input-row">
            <label>密码</label>
            <input id='password-j' type="password" class="mui-input-clear mui-input" placeholder="请输入密码">
        </div>
    </form>
    <div class="mui-content-padded">
        <button id='login-j' class="mui-btn mui-btn-block mui-btn-primary">登录</button>
        <div class="link-area"><a href="__ROOT__/home/Register/openBorrowRegister" id='reg-j'>注册账号</a></a>
        </div>
    </div>
    <div class="copy">
        <p>版权所属：民乐县天行电子商务有限公司</p>
        <p>技术支持：甘肃沙悟净电子商务有限公司</p>
    </div>
</div>
<script type="text/javascript" src="_JS_/jquery-1.12.4.js"></script>
<script type="text/javascript" src="_JS_/mui.js"></script>
<script>
    //mui初始化
    mui.init({
        swipeBack: true //启用右滑关闭功能
    });
    document.getElementById("login-j").addEventListener('tap', function () {
        var phone = $("#phone-j").val();
        var password1 = $("#password-j").val();
        if (phone == "") {
            mui.toast('手机号不能为空！');
        } else if (!phone.match(/^1(3|4|5|7|8)\d{9}$/)) {

            mui.toast("请输入正确的手机号码！");
        } else if (phone.length != 11) {
            mui.toast("手机号位数不对!");
        } else if (!checkPassword(password1)) {

            mui.toast("请输入正确的密码!");
        } else {
            //ajax发送

            $.ajax({
                url: "__ROOT__/home/Login/borrowerLogin",
                type: "POST",
                dataType: "json",
                data: {
                    'phone': phone,
                    'password1': password1,
                },


                success: function (data) {
                    if (data.res == "1") {
                        console.log("进入这进而::" + "__ROOT__");
                        window.location.href = "__ROOT__";
                    } else if (data.res == "-1") {
                        alert("手机号或者密码有错误")
                    } else if (data.res == "-2") {
                        alert("错误::" + data);
                    }

                },

                error: function (data) {

                    alert("这个错::" + data.responseText);
                }

            });
        }

    });

    function checkPassword(mm) {

        var reg = /^(\w){6,10}$/
        return reg.test(mm);
    }
</script>
</body>

</html>