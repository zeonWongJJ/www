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
    <script src="./static/style_default/script/editUserupdate.js"></script>
    <title>修改用户</title>
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
            <p>修改用户资料</p>
            <form action="<?php echo $this->router->url('user_update'); ?>" method='post'>
                <input type="hidden" name="user_id" value="<?php echo $a_view_data['user_id']; ?>">
                <input type="hidden" name="original_name" value="<?php echo $a_view_data['user_name']; ?>">
                <input type="hidden" name="original_phone" value="<?php echo $a_view_data['user_phone']; ?>">
                <input type="hidden" name="original_score" value="<?php echo $a_view_data['user_score']; ?>">
                <input type="hidden" name="original_balance" value="<?php echo $a_view_data['user_balance']; ?>">
                <ul>
                    <li class="userName">
                        <span>账户名</span>
                        <input type="text" id="user_name" name="user_name" value="<?php echo $a_view_data['user_name']; ?>" />
                        <em class="hide">
                            <img src="/static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <input type="hidden" name="user_sex" value="<?php echo $a_view_data['user_sex']; ?>">
                    <li class="userSex">
                        <span>性别</span>
                        <em class="man" value="1">
                            <?php if ($a_view_data['user_sex'] == 1) {
                                echo '<img src="/static/style_default/image/pro_36.png" />';
                            } else {
                                echo '<img src="/static/style_default/image/pro_38.png" />';
                            } ?>
                            男
                        </em>&nbsp;&nbsp;
                        <em class="wom" value="2">
                            <?php if ($a_view_data['user_sex'] == 2) {
                                echo '<img src="/static/style_default/image/pro_36.png" />';
                            } else {
                                echo '<img src="/static/style_default/image/pro_38.png" />';
                            } ?>
                            女
                        </em>
                        <img class="hide" style="vertical-align:middle;" src="/static/style_default/image/t_03.png" />
                    </li>
                    <li class="userPhone">
                        <span>手机号码</span>
                        <input type="text" id="user_phone" name="user_phone" value="<?php echo $a_view_data['user_phone']; ?>" />
                        <em class="hide">
                            <img src="/static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="userMail">
                        <span>邮箱</span>
                        <input type="text" id="user_mail" name="user_email" value="<?php echo $a_view_data['user_email']; ?>" />
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
                        <input type="password" id="user_pwd2" name="user_password" placeholder="不填将使用原密码" />
                        <em class="hide">
                            <img src="/static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="userRePwd">
                        <span>确认密码</span>
                        <input type="password" id="user_rePwd2" name="user_password2" placeholder="不填将使用原密码" />
                        <em class="hide">
                            <img src="/static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="userPoint">
                        <span>积分</span>
                        <input type="text" id="user_point" name="user_score" value="<?php echo $a_view_data['user_score']; ?>" />
                        <em class="hide">
                            <img src="/static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="userBalance">
                        <span>余额</span>
                        <input type="text" id="user_balance" name="user_balance" value="<?php echo $a_view_data['user_balance']; ?>" />
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