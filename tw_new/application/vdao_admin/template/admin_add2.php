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
    <link rel="stylesheet" href="./static/style_default/style/addAdmin.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/addAdmin.js"></script>
    <title>添加管理员</title>
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

        <!-- 管理员列表 -->
        <div class="adminList">
            <p><a href="admin_showlist" style="color:#000;">权限管理</a> > 添加管理员</p>
        </div>
        <!-- 管理员列表 -->

        <!-- 编辑管理员账号 -->
        <div class="addAdmin">
            <p>
                <span>添加管理员账号</span>
            </p>
            <form action="<?php echo $this->router->url('admin_add'); ?>" method="post" >
                <ul>
                    <li class="addAccountName">
                        <span>账户名</span>
                        <input type="text" id="addAccount_name" name="admin_name" />
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="addAdminName">
                        <span>姓名</span>
                        <input type="text" id="addAdmin_name" name="admin_realname" />
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <input type="hidden" name="admin_sex" value='1'>
                    <li class="addAdminSex">
                        <span>性别</span>
                        <em class="man" value="1">
                            <img  src="./static/style_default/image/pro_38.png" /> 男
                        </em>
                        <em  class="wom" value="2">
                            <img src="./static/style_default/image/pro_38.png" /> 女
                        </em>
                        <img class="hide" style="vertical-align:middle; " src="./static/style_default/image/t_03.png" />
                    </li>
                    <li class="addAdminPhone">
                        <span>手机号码</span>
                        <input type="text" id="addAdmin_phone" name="admin_phone" />
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="addAdminMail">
                        <span>邮箱</span>
                        <input type="text" id="addAdmin_mail" name="admin_email" autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','readonly');" />
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="addAdminPwd">
                        <span>密码</span>
                        <input type="password" id="addAdmin_pwd" name="admin_password" autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','readonly');" />
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="addAdminRePwd">
                        <span>确认密码</span>
                        <input type="password" id="addAdmin_rePwd" name="admin_password2" autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','readonly');" />
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <input type="hidden" name="role_id" value=''>
                    <li class="addAdminRole">
                        <span>属于角色</span>
                        <div class="addRoleLevel">
                            <?php foreach ($a_view_data as $key => $value): ?>
                                <a value="<?php echo $value['role_id']; ?>"><span><?php echo $value['role_name'] ?></span><img class="hide" src="./static/style_default/image/ac_03.png" alt="" /></a>
                            <?php endforeach ?>
                        </div>
                    </li>
                </ul>
                <input type="submit" id="addAdminSub" value="确定"/>
            </form>
        </div>
        <!-- 编辑管理员账号 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>