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
    <link rel="stylesheet" href="./static/style_default/style/public.css"/>
    <link rel="stylesheet" href="./static/style_default/style/editUser.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/editUser.js"></script>
    <title>添加用户</title>
</head>
<body style="background:#efefef;">
<!--  后台管理 -->
<div class="productClassification">
    <?php echo $this->display('header'); ?>
    <!--  右侧内容 -->
    <article>
        <!--  标题 -->
        <?php echo $this->display('top'); ?>
        <!--  标题 -->

        <!-- 编辑用户资料-->
        <div class="editUser">
            <p>添加用户</p>
            <form action="<?php echo $this->router->url('user_add'); ?>" method='post'>
            <!-- 防止表单自动填充 -->
            <!-- <input type="text" name="user_email" style="display:none;" /> -->
            <!-- <input type="text" name="user_password" style="display:none;" /> -->
            <!-- 防止表单自动填充 -->
                <ul>
                    <li class="userName">
                        <span>账户名</span>
                        <input type="text" id="user_name" name="user_name" />
                        <em class="hide">
                            <img src="/static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <input type="hidden" name="user_sex" value="">
                    <li class="userSex">
                        <span>性别</span>
                        <em class="man" value="1">
                            <img src="/static/style_default/image/pro_38.png" /> 男
                        </em>&nbsp;&nbsp;
                        <em  class="wom" value="2">
                            <img src="/static/style_default/image/pro_38.png" /> 女
                        </em>
                        <img class="hide" style="vertical-align:middle; " src="/static/style_default/image/t_03.png" />
                    </li>
                    <li class="userPhone">
                        <span>手机号码</span>
                        <input type="text" id="user_phone" name="user_phone readonly onfocus="this.removeAttribute('readonly');"" />
                        <em class="hide">
                            <img src="/static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="userMail">
                        <span>邮箱</span>
                        <input type="text" id="user_mail" name="user_email" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" />
                        <em class="hide">
                            <img src="/static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
<!--                     <li class="userWeChat">
                        <span>微信</span>
                        <input type="password" id="user_weChat" name="user_" />
                        <em class="hide">
                            <img src="/static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="userQQ">
                            <span>QQ</span>
                            <input type="password" id="user_QQ"/>
                        <em class="hide">
                            <img src="/static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li> -->
                    <li class="userPwd">
                        <span>密码</span>
                        <input type="password" id="user_pwd" name="user_password" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','readonly');" />
                        <em class="hide">
                            <img src="/static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="userRePwd">
                        <span>确认密码</span>
                        <input type="password" id="user_rePwd" name="user_password2" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','readonly');" />
                        <em class="hide">
                            <img src="/static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="userPoint">
                        <span>积分</span>
                        <input type="text" id="user_point" name="user_score" />
                        <em class="hide">
                            <img src="/static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="userBalance">
                        <span>余额</span>
                        <input type="text" id="user_balance" name="user_balance" />
                        <em class="hide">
                            <img src="/static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                </ul>
                <input type="submit" id="userSub" value="确定"/>
            </form>
        </div>
        <!-- 编辑用户资料 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>