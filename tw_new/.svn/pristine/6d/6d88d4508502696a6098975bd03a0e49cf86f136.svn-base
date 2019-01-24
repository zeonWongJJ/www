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
    <link rel="stylesheet" href="./static/style_default/style/managers.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/managers.js"></script>
    <title>角色列表</title>
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
            <p> 权限管理 > 角色管理</p>
            <!-- 选择管理员列表 -->
            <div class="chocie_adminList">
                <form action="">
                    <a href="role_add"><img src="./static/style_default/image/pro_03.png" />添加角色</a>
                    <div class="searchAdmin">
                        <input type="text" name="keywords" placeholder="角色名称/备注"/>
                        <i><img src="./static/style_default/image/s_03.png" onclick="role_search()" /></i>
                    </div>
                </form>
                <ul class="cateList">
                    <li class="cateHead">
                        <em class="v1">
                            <img src="./static/style_default/image/pro_07.png" alt=""/>
                            <p>
                                <span>全选</span>
                                <span style="margin-left:24px">角色名称</span>
                            </p>
                        </em>
                        <em class="v2" style="text-align:center;">角色备注</em>
                        <em class="v3">添加时间</em>
                        <em class="v4">启用/暂用</em>
                        <em class="v5">操作</em>
                    </li>
                    <?php foreach ($a_view_data['role'] as $key => $value): ?>
                    <li class="cateBody" id="<?php echo 'tr_' .$value['role_id']; ?>">
                        <!--品种-->
                        <div class="varieties">
                            <em class="v1">
                                <img src="./static/style_default/image/pro_07.png" value="<?php echo $value['role_id']; ?>" />
                                <p >
                                    <span><?php echo $value['role_name']; ?></span>
                                </p>
                            </em>
                            <em class="v2"><?php echo $value['role_description']; ?></em>
                            <em class="v3"><?php echo date('Y-m-d', $value['add_time']); ?></em>
                            <em class="v4" id="<?php echo 'switch_'.$value['role_id']; ?>" onclick="role_switch(<?php echo $value['role_id']; ?>)" value="<?php echo $value['role_state']; ?>">
                            <?php if ($value['role_state'] == 0) {
                                echo '<img src="./static/style_default/image/pro_33.png" />';
                            } else {
                                echo '<img src="./static/style_default/image/pro_10.png" />';
                            } ?>
                            </em>
                            <em class="v5">
                                <img src="./static/style_default/image/pro_26.png" onclick="del_role_one(<?php echo $value['role_id']; ?>)" />
                                <img src="./static/style_default/image/pro_28.png" onclick="role_update(<?php echo $value['role_id']; ?>)" />
                            </em>
                        </div>
                        <!--品种-->
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <!-- 选择管理员列表 -->
        </div>
        <!-- 角色列表 -->

        <!--  底部选项 -->
        <div class="bottomTool">
            <a class="bottomAllSelect">
                <img src="./static/style_default/image/pro_07.png" alt=""/>
                <span>全选</span>
            </a>
            <a class="bottomDelect" onclick="del_role_mony()">
                <img src="./static/style_default/image/pro_26.png" alt=""/>
                <span>删除</span>
            </a>
            <a class="bottomProvisional" onclick="switch_role_mony()">
                <img src="./static/style_default/image/pro_52.png" alt=""/>
                <span>暂用</span>
            </a>

        </div>
        <!--  底部选项 -->

        <!-- 编辑角色 -->
        <div class="editRole" style="display:none;">
            <p>
                <span>添加角色</span>
                <img src="./static/style_default/image/pro_19.png" onclick="close_editRole()" />
            </p>
            <form action="<?php echo $this->router->url('role_add'); ?>" method="post">
                <ul>
                    <li class="roleName">
                        <span>角色名称</span>
                        <input type="text" id="role_name" name="role_name" />
                        <em>
                            <img src="./static/style_default/image/t_03.png" alt=""/>
                            <span>还可以输入<s style=" text-decoration:none;">5</s>字符/汉字</span>
                        </em>
                    </li>
                    <input type="hidden" name="role_state" value="1">
                    <li class="managersDisplay">
                        <span>是否启用</span>
                        <em class="sure" value="1">
                            <img  src="./static/style_default/image/pro_38.png" alt=""/> 是
                        </em>
                        <em  class="deny" value="0">
                            <img src="./static/style_default/image/pro_38.png" alt=""/> 否
                        </em>
                        <img class="hide" src="./static/style_default/image/t_03.png"/>
                    </li>
                    <li class="roleDescription">
                        <span>角色描述</span>
                        <textarea id="role_des" cols="30" rows="10" name="role_description"></textarea>
                        <em>
                            <img src="./static/style_default/image/t_03.png" alt=""/>
                            <span></span>
                        </em>
                    </li>
                    <input type="hidden" name="role_auth" value=''>
                    <li class="rolePermissions">
                        <span>角色权限</span>
                        <div class="permissContent">
                            <ul>
                                <li class="useMan" style="line-height:25px;">
                                    <span>请选择需要分配给该角色的权限</span>
                                    <?php foreach ($a_view_data['auth'] as $key => $value): ?>
                                    <?php if($value['auth_level'] == 0) { echo '<br>'; } ?>
                                    <i><img src="./static/style_default/image/qx_05.png" value="<?php echo $value['auth_id']; ?>" /><em> <?php echo $value['auth_name']; ?></em></i>
                                    <?php endforeach ?>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <input type="submit" id="manSub" value="确定"/>
            </form>
        </div>
        <!-- 编辑角色 -->

        <!-- 重要提示 -->
        <div class="pop_tips" style="display:none;">
            <p>重要提示</p>
            <span class="delete_cancel"><img src="./static/style_default/image/pro_19.png" class="closeTips" alt=""/></span>
            <div class="tipsText">
                <p><s>*</s>确认要删除这部分角色吗</p>
                <p><s>*</s>如果该角色下有管理员则需要清空该角色下的所有管理员方可删除</p>
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

function del_role_one(role_id) {
    $('.pop_tips').css('display','block');
    // 确定删除
    $('#delete_confirm').click(function(event) {
        $.ajax({
            url: '<?php echo $this->router->url('role_delete'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {role_id: role_id, type: 1},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    $('#tr_'+role_id).remove();
                }
            }
        })
        $('.pop_tips').css('display','none');
    });
}

// 取消删除
$('.delete_cancel').click(function(event) {
    $('.pop_tips').css('display','none');
});

function del_role_mony() {
    $('.pop_tips').css('display','block');
    // 确定删除
    $('#delete_confirm').click(function(event) {
        var role_ids = new Array();
        var i = 0;
        $(".varietiesChoice").each(function(index, value) {
            role_ids[i] = $(this).attr('value');
            i++;
        });
        if (role_ids.length > 0) {
            $.ajax({
                url: '<?php echo $this->router->url('role_delete'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {role_id: role_ids, type: 2},
                success: function(data) {
                    console.log(data);
                    if (data.code==200) {
                        for (var j=0; j<role_ids.length; j++) {
                            $('#tr_'+role_ids[j]).remove();
                        }
                    }
                }
            })
        }
        $('.pop_tips').css('display','none');
    });
}

// 启用停用
function role_switch(role_id) {
    var role_state = $('#switch_'+role_id).attr('value');
    $.ajax({
        url: '<?php echo $this->router->url('role_switch'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {role_id: role_id},
        success: function(data){
            console.log(data);
            if (data.code==200) {
                if (role_state == 0) {
                    $('#switch_'+role_id).attr('value', '1');
                    $('#switch_'+role_id).html('<img src="./static/style_default/image/pro_10.png" />');
                } else {
                    $('#switch_'+role_id).attr('value', '0');
                    $('#switch_'+role_id).html('<img src="./static/style_default/image/pro_33.png" />');
                }
            }
        }
    })
}

// 批量启用停用
function switch_role_mony() {
    var i = 0;
    $(".varietiesChoice").each(function(index, value) {
        role_switch($(this).attr('value'));
        i++;
    });
}

// 搜索角色
function role_search() {
    var keywords = $("input[name='keywords']").val();
    if (keywords != '') {
        $.ajax({
            url: '<?php echo $this->router->url('role_search'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {keywords: keywords},
            success: function(res) {
                console.log(res);
                if (res.code == 200) {
                    $(".cateList li").not(':eq(0)').remove();
                    var append_content = '';
                    $.each(res.data, function(index, el) {
                        append_content += '<li class="cateBody" id="tr_'+el.role_id+'">';
                        append_content += '<div class="varieties">';
                        append_content += '<em class="v1"><img src="./static/style_default/image/pro_07.png" value="'+el.role_id+'" /><p><span>'+el.role_name+'</span></p></em>';
                        append_content += '<em class="v2">'+el.role_description+'</em>';
                        append_content += '<em class="v3">'+el.add_time+'</em>';
                        append_content += '<em class="v4" id="switch_'+el.role_id+'" onclick="role_switch('+el.role_id+')" value="'+el.role_state+'">';
                        if (el.role_state == 1) {
                            append_content += '<img src="./static/style_default/image/pro_10.png" />';
                        } else {
                            append_content += '<img src="./static/style_default/image/pro_33.png"/>';
                        }
                        append_content += '</em>';
                        append_content += '<em class="v5"><img src="./static/style_default/image/pro_26.png" onclick="del_role_one('+el.role_id+')"/><img src="./static/style_default/image/pro_28.png" onclick="role_update('+el.role_id+')"/></em>';
                        append_content += '</div>';
                        append_content += '</li>';
                    });
                    $('.cateList').append(append_content);
                }
            }
        })
    }
}

// 添加角色
function role_add() {
    var editRole_state = $('.editRole').css('display');
    if (editRole_state == 'none') {
        $('.editRole').css('display', 'block');
    } else {
        $('.editRole').css('display', 'none');
    }
}

// 关闭编辑窗口
function close_editRole() {
    $('.editRole').css('display', 'none');
}

// 修改角色
function role_update(role_id) {
    window.location.href = 'role_update-'+role_id;
}

</script>