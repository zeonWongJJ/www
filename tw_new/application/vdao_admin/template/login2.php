<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML,ASP,PHP,SQL">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=6" ><!-- 使用IE6 -->
    <meta http-equiv="X-UA-Compatible" content="IE=7" ><!-- 使用IE7 -->
    <meta http-equiv="X-UA-Compatible" content="IE=8" ><!-- 使用IE8 -->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="./static/style_default/style/common.css"/>
    <link rel="stylesheet" href="./static/style_default/style/login.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/login.js"></script>
    <title>登录</title>
</head>
<body>
    <div class="login">
        <p>V稻管理中心</p>
        <div class="loginBox">
            <form action="<?php echo $this->router->url('login'); ?>" method="post">
                <dl>
                    <dd class="adminNum">
                        <p>账号：</p>
                        <input type="text" id="admin_num" name="admin_name" />
                    </dd>
                    <dd class="adminPassword">
                        <p>密码：</p>
                        <input type="password" id="admin_pwd" name="admin_password" />
                    </dd>
                </dl>
                <input type="submit" value="登录" id="sub"/>
            </form>
        </div>
    </div>
    <!-- 底部文字 -->
    <div class="bottomText">
        <span>Copyright © 20177度共享</span>
        <span>粤ICP备10094607号-7</span>
    </div>
    <!-- 底部文字 -->
    <!-- 登录提示 -->
    <div class="loginTips">
        <p></p>
    </div>
    <!-- 登录提示 -->
</body>
</html>