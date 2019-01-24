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
    <link rel="stylesheet" href="./static/style_default/style/addRole.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/updateRole.js"></script>
    <title>修改角色</title>
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

        <!-- 角色列表 -->
        <div class="adminList">
            <p><a href="role_showlist" style="color:#000;">权限管理</a> > 修改角色</p>
        </div>
        <!-- 角色列表 -->

        <!-- 添加角色 -->
        <div class="addRole">
            <p>
                <span>修改角色</span>
            </p>
            <form action="role_update" method="post">
                <input type="hidden" name="role_id" value="<?php echo $a_view_data['role']['role_id']; ?>">
                <ul>
                    <li class="addRoleName">
                        <span>角色名称</span>
                        <input type="text" name="role_name" id="addRole_name" value="<?php echo $a_view_data['role']['role_name']; ?>" />
                        <em>
                            <img src="./static/style_default/image/t_03.png" />
                            <span>还可以输入<s style="text-decoration:none;">5</s>字符/汉字</span>
                        </em>
                    </li>
                    <input type="hidden" name="role_state" value="<?php echo $a_view_data['role']['role_state']; ?>">
                    <li class="addManagersDisplay">
                        <span>是否启用</span>
                        <em class="sure" value='1'>
                            <?php if ($a_view_data['role']['role_state'] == 1) {
                                echo '<img  src="./static/style_default/image/pro_36.png" />';
                            } else {
                                echo '<img  src="./static/style_default/image/pro_38.png" />';
                            } ?>
                            <span>是</span>
                        </em>
                        <em  class="deny" value="0">
                            <?php if ($a_view_data['role']['role_state'] == 0) {
                                echo '<img  src="./static/style_default/image/pro_36.png" />';
                            } else {
                                echo '<img  src="./static/style_default/image/pro_38.png" />';
                            } ?>
                            <span>否</span>
                        </em>
                        <img class="hide" src="./static/style_default/image/t_03.png"/>
                    </li>
                    <li class="addRoleDescription">
                        <span>角色描述</span>
                        <textarea name="role_description" id="addRole_des" cols="30" rows="10"><?php echo $a_view_data['role']['role_description']; ?></textarea>
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <input type="hidden" name="role_auth" value='<?php echo $a_view_data['role']['auth_ids']; ?>'>
                    <li class="addRolePermissions">
                        <span>角色权限</span>
                        <div class="permissContent">
                            <ul>
                                <li class="addUseMan" style="line-height:25px;">
                                    <span>请选择需要分配给该角色的权限</span>
                                    <?php foreach ($a_view_data['auth'] as $key => $value): ?>
                                    <?php if($value['auth_level'] == 0) { echo '<br>'; } ?>
                                    <i><img <?php if (in_array($value['auth_id'], $a_view_data['present'])) { echo 'class="useChoice" src="./static/style_default/image/qx_03.png"'; } else { echo 'src="./static/style_default/image/qx_05.png"'; } ?> value="<?php echo $value['auth_id']; ?>" /><em> <?php echo $value['auth_name']; ?></em></i>
                                    <?php endforeach ?>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <input type="submit" id="addRole" value="确定"/>
            </form>
        </div>
        <!-- 添加角色 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>