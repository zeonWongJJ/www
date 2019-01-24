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
    <link rel="stylesheet" href="./static/style_default/style/userManagement.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/userManagement.js"></script>
    <title>用户列表</title>
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

        <!-- 用户管理 -->
        <div class="userManagement">
            <h1>用户管理(<span><?php echo $a_view_data['count']; ?></span>)</h1>
            <!-- 管理列表 -->
            <div class="managementList">
                <ul>
                    <li class="managesmentHead">
                        <em class="v1" style="text-align:left;">
                            <a href="<?php echo $this->router->url('user_add'); ?>" class="addUserBtn">
                                <img src="./static/style_default/image/pro_03.png" alt=""/>
                                <span>添加用户</span>
                            </a>
                        </em>
                        <em class="v2">性别</em>
                        <em class="v3">手机号码</em>
                        <em class="v4">邮箱</em>
                        <em class="v5">绑定平台</em>
                        <em class="v6">积分</em>
                        <em class="v7">余额</em>
                        <em class="v8">启用/暂用</em>
                        <em class="v9">操作</em>
                    </li>
                    <?php foreach ($a_view_data['user'] as $key => $value): ?>
                    <li class="managesmentBody" id="<?php echo 'tr_' . $value['user_id']; ?>">
                        <em class="v1" style="text-align:left;">
                            <img src="./static/style_default/image/pro_07.png" value="<?php echo $value['user_id']; ?>" />
                            <div class="userInfo">
                                <?php if (empty($value['user_pic'])) {
                                    echo '<img src="./static/style_default/image/tt_03.png" />';
                                } else if(strpos($value['user_pic'], 'http') === false) {
                                    echo '<img src="'.get_config_item('vdao_mobile').$value['user_pic'].'" />';
                                } else {
                                    echo '<img src="'.$value['user_pic'].'" />';
                                } ?>
                                <p>
                                    <em><?php echo $value['user_name']; ?></em>
                                    <span><?php echo date('Y-m-d', $value['user_regtime']); ?></span>
                                </p>
                            </div>
                        </em>
                        <em class="v2">
                        <?php
                            if ($value['user_sex'] == 0) {
                                echo '未知';
                            } else if ($value['user_sex'] == 1) {
                                echo '男';
                            } else if ($value['user_sex'] == 2) {
                                echo '女';
                            }
                        ?>
                        </em>
                        <em class="v3"><?php echo $value['user_phone']; ?></em>
                        <em class="v4"><?php echo $value['user_email']; ?></em>
                        <em class="v5">
                            <?php if (empty($value['weixin_openid'])) {
                                echo '<img src="./static/style_default/image/com_09.png" />';
                            } else {
                                echo '<img src="./static/style_default/image/com_03.png" />';
                            } ?>
                            <?php if (empty($value['qq_openid'])) {
                                echo '<img src="./static/style_default/image/com_10.png" />';
                            } else {
                                echo '<img src="./static/style_default/image/com_05.png" />';
                            } ?>
                        </em>
                        <em class="v6"><?php echo $value['user_score']; ?></em>
                        <em class="v7"><?php echo $value['user_balance']; ?></em>
                        <em class="v8" id="<?php echo "switch_".$value['user_id'];?>" onclick="user_switch(<?php echo $value['user_id']; ?>)" value="<?php echo $value['user_state']; ?>">
                        <?php if ($value['user_state'] == 1) {
                            echo '<img src="./static/style_default/image/pro_10.png" />';
                        } else {
                            echo '<img src="./static/style_default/image/pro_33.png" />';
                        } ?>
                        </em>
                        <em class="v9">
                            <img src="./static/style_default/image/pro_26.png" onclick="user_delete_one(<?php echo $value['user_id']; ?>)"/>
                            <a href="<?php echo $this->router->url('user_update',['id'=>$value['user_id']]); ?>"><img src="./static/style_default/image/pro_28.png" /></a>
                        </em>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <!-- 管理列表 -->
        </div>
        <!-- 用户管理 -->

        <!--  底部选项 -->
        <div class="bottomTool">
            <a class="bottomAllSelect">
                <img src="./static/style_default/image/pro_07.png" alt=""/>
                <span>全选</span>
            </a>
            <a class="bottomDelect" onclick="user_delete_mony()">
                <img src="./static/style_default/image/pro_26.png" alt=""/>
                <span>删除</span>
            </a>
            <a class="bottomProvisional" onclick="user_switch_mony()">
                <img src="./static/style_default/image/pro_52.png" alt=""/>
                <span>暂用</span>
            </a>
        </div>
        <!--  底部选项 -->
        <!-- 分页 -->
        <div class="page">
            <?php echo $this->pages->link_style_one($this->router->url('user_showlist-', [], false, false)); ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->
        <!--  重要提示 -->
        <div class="tips hide">
            <em>重要提示</em>
            <img class="delete_cancel" src="./static/style_default/image/pro_19.png" />
            <p>
                <span>▪ 确认删除这些用户吗？</span>
                <span>▪ 删除后不可恢复</span>
            </p>
            <div class="tipsBtn">
                <em class="delete_confirm">确定</em>
                <a class="delete_cancel">再看看</a>
            </div>
        </div>
        <!--  重要提示 -->
    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>


<script>

// 启用停用开关
function user_switch(user_id) {
    var user_state = $('#switch_'+user_id).attr('value');
    $.ajax({
        url: '<?php echo $this->router->url('user_switch'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {user_id: user_id},
        success:function(data) {
            console.log(data);
            if (data.code==200) {
                if (user_state == 1) {
                    $('#switch_'+user_id).html('<img src="./static/style_default/image/pro_33.png" />');
                    $('#switch_'+user_id).attr('value', '2');
                } else {
                    $('#switch_'+user_id).html('<img src="./static/style_default/image/pro_10.png" />');
                    $('#switch_'+user_id).attr('value', '1');
                }
            }
        }
    })
}

// 批量暂用
function user_switch_mony() {
    $('.userSelect').each(function(index, el) {
        user_switch($(this).attr('value'));
    });
}

// 单个删除
function user_delete_one(user_id) {
    $('.tips').show();
    $('.delete_confirm').click(function(event) {
        $.ajax({
            url: '<?php echo $this->router->url('user_delete'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {user_id: user_id, type: 1},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    $("#tr_"+user_id).remove();
                    $('.tips').hide();
                }
            }
        })
    });
    // 取消删除
    $('.delete_cancel').click(function(event) {
        $('.tips').hide();
    });
}

// 批量删除
function user_delete_mony() {
    $('.tips').show();
    $('.delete_confirm').click(function(event) {
        var user_ids = new Array();
        var i = 0;
        $(".userSelect").each(function(index, el) {
            user_ids[i] = $(this).attr('value');
            i++
        });
        if (user_ids.length > 0) {
            $.ajax({
                url: '<?php echo $this->router->url('user_delete'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {user_ids: user_ids, type: 2},
                success: function(data) {
                    console.log(data);
                    if (data.code==200) {
                        for (var j=0; j<user_ids.length; j++) {
                            $('#tr_'+user_ids[j]).remove();
                        }
                    }
                }
            })
        }
        $('.tips').hide();
    });
    // 取消删除
    $('.delete_cancel').click(function(event) {
        $('.tips').hide();
    });
}

</script>