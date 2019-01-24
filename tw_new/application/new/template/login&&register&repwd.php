<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="css/common.css"/>
    <link rel="stylesheet" href="css/login.css"/>
    <link rel="stylesheet" href="css/register.css"/>
    <link rel="stylesheet" href="css/searchPwd.css"/>
    <link rel="stylesheet" href="css/register&&login&&searchPwd.css"/>
    <script src="js/jquery-1.8.2.min.js"></script>
    <script src="js/registerBack.js"></script>
    <script src="js/loginBack.js"></script>
    <script src="js/searchPwdBack.js"></script>
    <script src="js/register&&login&&searchPwd.js"></script>
    <title></title>
</head>
<body>
<div class="lrp">
    <!-- 登录页面 -->
    <div  class="loginBox">
        <!--  背景图片 -->
        <i class="loginBg">
            <img src="img/loginBg.png" alt=""/>
        </i>
        <!--  背景图片 -->
        <div class="login">
            <form action="<?php echo $this->router->url('login'); ?>" method="post">
                <div class="user">
                    <i><img src="img/user.png" alt=""/></i>
                    <input type="text" name="tel_or_username" id="user" placeholder="手机号/用户名"/>
                </div>
                <div class="pwd">
                    <i><img src="img/pwd.png" alt=""/></i>
                    <input id="pwd" type="password" name="password" placeholder="请输入密码"/>
                </div>
                <!--<button type="submit" class="sub">登录</button>-->
                <p class="forget">
                    <a>忘记密码 ?</a>
                </p>
                <i class="loginSub">
                    <img src="img/btn_03.png" alt=""/>
                </i>
            </form>
        </div>

        <!-- 注册 -->
        <div class="clickRegister">
            <span>新用户？</span><a>点击注册</a>
        </div>
        <!--  注册 -->

        <!--  右上角关闭 -->
        <div class="close">
            <a href="#"><i><img src="img/close.png" alt=""/></i></a>
        </div>
        <!--  右上角关闭 -->

        <!-- 验证提示 -->
        <div class="loginRegTips hide">
            <p></p>
        </div>
        <!-- 验证提示 -->
    </div>

    <!-- 注册 -->
    <div id="register" class="register ">
        <!-- 注册背景 -->
        <div class="userPicture">
            <img src="img/reBg.png" alt=""/>
        </div>
        <!-- 注册背景 -->
        <form id="registerForm" action="<?php echo $this->router->url('register'); ?>">
            <div class="userPhone" >
                <i><img src="img/up.png" alt=""/></i>
                <input  type="text" id="check_userPhone" name="mobile" placeholder="手机号"/>
            </div>
            <div class="userName" >
                <i><img src="img/user.png" alt=""/></i>
                <input  type="text" id="check_username" name="username" placeholder="用户名,注册后不能修改"/>
            </div>
            <div class="userCode">
                <div class="codeBox">
                    <i><img src="img/mes.png" alt=""/></i>
                    <input type="text" id="check_userCode" name="code" placeholder="验证码"/>
                    <div class="codeContent">
                        <a class="getCode" >
                            <i>
                                <span class="">获取验证码</span>
                                <s class="hide" style="text-decoration:none;">60s</s>
                                <em class="hide">重新获取</em>
                                <img src="img/border.png" alt=""/>
                            </i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="userPwd1">
                <i><img src="img/pwd.png" alt=""/></i>
                <input id="check_pwd1" type="password" name="password1" placeholder="请输入密码"/>
            </div>
            <div class="userPwd2">
                <i><img src="img/pwd.png" alt=""/></i>
                <input id="check_pwd2" type="password" name="password2" placeholder="请再次输入密码"/>
            </div>
            <!--<button type="submit" class="sub">注册</button>-->
            <i class="registerSub">
                <img  src="img/register.png" alt=""/>
            </i>

        </form>

        <!-- 注册 -->
        <div class="registerBox">
            <span>已有账户？</span><a>点击登录</a>
        </div>
        <!--  注册 -->

        <!--  右上角关闭 -->
        <div class="close">
            <a href="vipIndex.html"><i><img src="img/close.png" alt=""/></i></a>
        </div>
        <!--  右上角关闭 -->

        <!-- 验证提示 -->
        <div class="registerRegTips hide">

            <p></p>
        </div>
        <!-- 验证提示 -->
    </div>
    <!-- 注册 -->

    <!-- 找回密码 -->
    <div class="findPwd">
        <!--  密码找回 -->
        <div class="searchPwd">
            <header class="head">
                <a><i><img src="img/xiaoyuhao.png" alt=""/></i></a>
                <span>找回密码</span>
            </header>
        </div>
        <!--  密码找回 -->

        <!-- 验证 -->
        <div class="validate">
            <form action="<?php echo $this->router->url('find_password'); ?>" method="post">
                <ul>
                    <li class="searchUserPhone">
                        <span>手机号</span>
                        <input type="text" id="searchPhone" name="mobile" placeholder="请输入手机号"/>
                    </li>
                    <li class="searchUserCode">
                        <span>验证码</span>
                        <input id="searchCode" type="text" name="code" placeholder="请输入验证码"/>
                        <i><img src="img/border.png" alt=""/></i>
                        <a class="getCode" >获取验证码</a>
                        <b class="codeTime hide">2s</b>
                        <em class="hide">重新获取</em>
                    </li>
                    <li class="searchUserpwd">
                        <span>登录密码</span>
                        <input id="searchPwd" type="password" name="password" placeholder="请输入登录密码"/>
                        <i><img src="img/closeEye.png" alt=""/></i>
                    </li>
                    <!--<li class="searchRePwd">
                        <span>重复输入</span>
                        <input id="searchRePwd" type="password" placeholder="请再次输入"/>
                        <i><img src="img/closeEye.png" alt=""/></i>
                    </li>-->
                </ul>
                <div class="searchSub">
                    <!--<button type="submit" >确定</button>-->
                    <img src="img/sure_03.png" alt=""/>
                </div>
            </form>
        </div>
        <!-- 验证 -->

        <!-- 验证提示 -->
        <div class="searchRegTips hide">
            <p></p>
        </div>
        <!-- 验证提示 -->
    </div>
    <!-- 找回密码 -->
</div>



</body>
</html>