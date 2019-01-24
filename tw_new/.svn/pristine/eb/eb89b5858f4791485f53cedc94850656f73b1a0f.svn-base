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
    <link rel="stylesheet" href="./static/style_default/style/adminList.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/adminList.js"></script>
    <title>管理员列表</title>
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
            <p>权限管理>管理员列表</p>
            <!-- 选择管理员列表 -->
            <div class="chocie_adminList">
                <form action="">
                    <a href="admin_add"><img src="./static/style_default/image/pro_03.png" />添加管理员</a>
                    <div class="searchAdmin">
                        <input type="text" placeholder="管理员账号/姓名" name="keywords" />
                        <i><img src="./static/style_default/image/s_03.png" onclick="admin_search()" alt=""/></i>
                    </div>
                </form>
                <ul class="cateList">
                    <li class="cateHead">
                        <em class="v1">
                            <img src="./static/style_default/image/pro_07.png" alt=""/>
                            <p>
                                <span>全选</span>
                                <span>账号</span>
                            </p>
                        </em>
                        <em class="v2" >姓名</em>
                        <em class="v3">性别</em>
                        <em class="v4">管理员角色</em>
                        <em class="v5">手机号码</em>
                        <em class="v6">邮箱</em>
                        <em class="v7">添加时间</em>
                        <em class="v8">启用/暂用</em>
                        <em class="v9">操作</em>
                    </li>
                    <?php foreach ($a_view_data['admin'] as $key => $value): ?>
                    <li class="cateBody" id="<?php echo 'tr_' . $value['admin_id']; ?>">
                        <!--品种-->
                        <div class="varieties">
                            <em class="v1">
                                <img src="./static/style_default/image/pro_07.png" value="<?php echo $value['admin_id'] . '-' . $value['role_id']; ?>" />
                                <p >
                                    <span><?php echo $value['admin_name']; ?></span>
                                </p>
                            </em>
                            <em class="v2"><?php echo $value['admin_realname']; ?></em>
                            <em class="v3"><?php echo $value['admin_sex']; ?></em>
                            <em class="v4"><?php echo $value['role_name']; ?></em>
                            <em class="v5"><?php echo $value['admin_phone']; ?></em>
                            <em class="v6"><?php echo $value['admin_email']; ?></em>
                            <em class="v7"><?php echo $value['register_time']; ?></em>
                            <em class="v8" id="<?php echo 'switch_'.$value['admin_id']; ?>" onclick="admin_switch(<?php echo $value['admin_id']; ?>)" value="<?php echo $value['admin_state']; ?>">
                            <?php if ($value['admin_state'] == 1) {
                                echo '<img src="./static/style_default/image/pro_10.png" alt=""/>';
                            } else {
                                echo '<img src="./static/style_default/image/pro_33.png" alt=""/>';
                            } ?>
                            </em>
                            <em class="v9">
                                <img src="./static/style_default/image/pro_26.png" onclick="del_admin_one(<?php echo $value['admin_id'] . ',' . $value['role_id']; ?>)" alt=""/>
                                <img src="./static/style_default/image/pro_28.png" onclick="admin_update(<?php echo $value['admin_id']; ?>)" alt=""/>
                            </em>
                        </div>
                        <!--品种-->
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <!-- 选择管理员列表 -->
        </div>
        <!-- 管理员列表 -->

        <!--  底部选项 -->
        <div class="bottomTool">
            <a class="bottomAllSelect">
                <img src="./static/style_default/image/pro_07.png" alt=""/>
                <span>全选</span>
            </a>
            <a class="bottomDelect" onclick="del_admin_mony()">
                <img src="./static/style_default/image/pro_26.png" alt=""/>
                <span>删除</span>
            </a>
            <a class="bottomProvisional" onclick="switch_admin_mony()">
                <img src="./static/style_default/image/pro_52.png" alt=""/>
                <span>暂用</span>
            </a>

        </div>
        <!--  底部选项 -->

        <!-- 编辑管理员账号 -->
        <div class="editAdmin" style="display:none;">
            <p>
                <span>添加管理员</span>
                <img onclick="close_editAdmin()" src="./static/style_default/image/pro_19.png" class="closeRole" alt=""/>
            </p>
            <form action="<?php echo $this->router->url('admin_add'); ?>" method="post">
                <ul>
                    <li class="accountName">
                        <span>账户名</span>
                        <input type="text" id="account_name" name="admin_name" />
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" alt=""/>
                            <span></span>
                        </em>
                    </li>
                    <li class="adminName">
                        <span>姓名</span>
                        <input type="text" id="admin_name" name="admin_realname" />
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" alt=""/>
                            <span></span>
                        </em>
                    </li>
                    <input type="hidden" name="admin_sex" value=''>
                    <li class="adminSex">
                        <span>性别</span>
                        <em class="man">
                            <img src="./static/style_default/image/pro_38.png" alt=""/> 男
                        </em>
                        <em class="wom">
                            <img src="./static/style_default/image/pro_38.png" alt=""/> 女
                        </em>
                        <img class="hide" style="vertical-align:middle; " src="./static/style_default/image/t_03.png" alt=""/>
                    </li>
                    <li class="adminPhone">
                        <span>手机号码</span>
                        <input type="text" id="admin_phone" name="admin_phone" />
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" alt=""/>
                            <span></span>
                        </em>
                    </li>
                    <li class="adminMail">
                        <span>邮箱</span>
                        <input type="text" id="admin_mail" name="admin_email" />
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" alt=""/>
                            <span></span>
                        </em>
                    </li>
                    <li class="adminPwd">
                        <span>密码</span>
                        <input type="password" id="admin_pwd" name="admin_password" />
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" alt=""/>
                            <span></span>
                        </em>
                    </li>
                    <li class="adminRePwd">
                        <span>确认密码</span>
                        <input type="password" id="admin_rePwd" name="admin_password2" />
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" alt=""/>
                            <span></span>
                        </em>
                    </li>
                    <li class="adminRole">
                        <span>属于角色</span>
                        <input type="hidden" name="role_id" value=''>
                        <div class="roleLevel">
                            <?php foreach ($a_view_data['role'] as $key => $value): ?>
                                <a value="<?php echo $value['role_id']; ?>"><span><?php echo $value['role_name'] ?></span><img class="hide" src="./static/style_default/image/ac_03.png" alt="" /></a>
                            <?php endforeach ?>
                        </div>
                    </li>
                </ul>
                <input type="submit" id="adminSub" value="确定"/>
            </form>
        </div>
        <!-- 编辑管理员账号 -->

        <!-- 重要提示 -->
        <div class="pop_tips" style="display:none;">
            <p>重要提示</p>
            <span class="delete_cancel"><img src="./static/style_default/image/pro_19.png" class="closeTips" alt=""/></span>
            <div class="tipsText">
                <p><s>*</s>确认要删除这部分管理员吗</p>
                <p><s>*</s>删除后不可恢复，下次使用需要重新添加</p>
            </div>
            <div class="btnBox">
                <span id="delete_confirm">确认</span>
                <em class="delete_cancel">再看看</em>
            </div>
        </div>
        <!-- 重要提示 -->
    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>


<script>

function del_admin_one(admin_id, role_id) {
    $('.pop_tips').css('display','block');
    // 确定删除
    $('#delete_confirm').click(function(event) {
        $.ajax({
            url: '<?php echo $this->router->url('admin_delete'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {admin_id: admin_id, role_id: role_id, type: 1},
            success: function(data) {
                console.log(data);
                $('#tr_'+admin_id).remove();
            }
        })
        $('.pop_tips').css('display','none');
    });
}

// 取消删除
$('.delete_cancel').click(function(event) {
    $('.pop_tips').css('display','none');
});

function del_admin_mony() {
    $('.pop_tips').css('display','block');
    // 确定删除
    $('#delete_confirm').click(function(event) {
        var value_ids = new Array();
        var admin_ids = new Array();
        var role_ids = new Array();
        var i = 0;
        $(".varietiesChoice").each(function(index, value) {
            value_ids[i]    = $(this).attr('value');
            var value_array = value_ids[i].split('-');
            admin_ids[i]    = value_array[0];
            role_ids[i]     = value_array[1];
            i++;
        });
        if (admin_ids.length > 0) {
            $.ajax({
                url: '<?php echo $this->router->url('admin_delete'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {admin_id: admin_ids, role_id: role_ids, type: 2},
                success: function(data) {
                    console.log(data);
                    for (var j=0; j<admin_ids.length; j++) {
                        $('#tr_'+admin_ids[j]).remove();
                    }
                }
            })
        }
        $('.pop_tips').css('display','none');
    });
}

function admin_switch(admin_id) {
    var admin_state = $('#switch_'+admin_id).attr('value');
    $.ajax({
        url: '<?php echo $this->router->url('admin_switch'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {admin_id: admin_id},
        success: function(data){
            console.log(data);
            if (data.code==200) {
                if (admin_state == 0) {
                    $('#switch_'+admin_id).attr('value', '1');
                    $('#switch_'+admin_id).html('<img src="./static/style_default/image/pro_10.png" alt=""/>');
                } else {
                    $('#switch_'+admin_id).attr('value', '0');
                    $('#switch_'+admin_id).html('<img src="./static/style_default/image/pro_33.png" alt=""/>');
                }
            }
        }
    })
}

function add_admin() {
    var editAdmin_state = $('.editAdmin').css('display');
    if (editAdmin_state == 'none') {
        $('.editAdmin').css('display', 'block');
    } else {
        $('.editAdmin').css('display', 'none');
    }
}

function close_editAdmin() {
    $('.editAdmin').css('display', 'none');
}

function admin_search() {
    var keywords = $("input[name='keywords']").val();
    if (keywords != '') {
        $.ajax({
            url: '<?php echo $this->router->url('admin_search'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {keywords: keywords},
            success: function(res){
                console.log(res);
                if (res.code == 200) {
                    $(".cateList li").not(':eq(0)').remove();
                    var append_content = '';
                    $.each(res.data, function(index, el) {
                        append_content += '<li class="cateBody" id="tr_'+el.admin_id+'">';
                        append_content += '<div class="varieties">';
                        append_content += '<em class="v1"><img src="./static/style_default/image/pro_07.png" value="'+el.admin_id+'-'+el.role_id+'" /><p><span>'+el.admin_name+'</span></p></em>';
                        append_content += '<em class="v2">'+el.admin_realname+'</em>';
                        append_content += '<em class="v3">'+el.admin_sex+'</em>';
                        append_content += '<em class="v4">'+el.role_name+'</em>';
                        append_content += '<em class="v5">'+el.admin_phone+'</em>';
                        append_content += '<em class="v6">'+el.admin_email+'</em>';
                        append_content += '<em class="v7">'+el.register_time+'</em>';
                        append_content += '<em class="v8" id="switch_'+el.admin_id+'" onclick="admin_switch('+el.admin_id+')" value="'+el.admin_state+'">';
                        if (el.admin_state == 1) {
                            append_content += '<img src="./static/style_default/image/pro_10.png" />';
                        } else {
                            append_content += '<img src="./static/style_default/image/pro_33.png"/>';
                        }
                        append_content += '</em>';
                        append_content += '<em class="v9"><img src="./static/style_default/image/pro_26.png" onclick="del_admin_one('+el.admin_id+','+el.role_id+')"/><img src="./static/style_default/image/pro_28.png" onclick="admin_update('+el.admin_id+')"/></em>';
                        append_content += '</div>';
                        append_content += '</li>';
                    });
                    $('.cateList').append(append_content);
                }
            }
        })
    }
}

function switch_admin_mony() {
    var value_ids = new Array();
    var admin_ids = new Array();
    var i = 0;
    $(".varietiesChoice").each(function(index, value) {
        value_ids[i]    = $(this).attr('value');
        var value_array = value_ids[i].split('-');
        admin_ids[i]    = value_array[0];
        admin_switch(value_array[0]);
        i++;
    });
}

function admin_update(admin_id) {
    window.location.href = "admin_update-"+admin_id;
}

</script>