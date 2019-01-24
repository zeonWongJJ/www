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
    <link rel="stylesheet" href="./static/style_default/style/roomCate.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/roomCate.js"></script>
    <title>房间分类</title>
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

        <!-- 房型分类 -->
        <div class="roomCate">
            <p><a href="room_showlist" style="color:#000;">房间管理</a> > <a href="type_showlist" style="color:#000;">房间分类</a><?php if ($a_view_data['type'] == 6) { echo ' > 搜索类型 ['.$a_view_data['keywords'].']'; } ?></p>
            <!-- 房型分类列表 -->
            <div class="roomCateList">
                <form id="searchform" action="type_search" method="post">
                    <a href="type_add"><img src="./static/style_default/image/pro_03.png" />添加分类</a>
                    <div class="searchRoom">
                        <input name="keywords" type="text" placeholder="分类名称" <?php if ($a_view_data['type'] == 6) { echo 'value="'.$a_view_data['keywords'].'"'; } ?> />
                        <i><img src="./static/style_default/image/s_03.png" onclick="type_search()" /></i>
                    </div>
                </form>
                <ul class="cateList">
                    <li class="cateHead">
                        <em class="v1">
                            <img src="./static/style_default/image/pro_07.png" />
                            <p>
                                <span>房型分类</span>
                            </p>
                        </em>
                        <em class="v2" style="text-align:center;">房间描述</em>
                        <em class="v3">是否开放</em>
                        <em class="v4">操作</em>
                    </li>
                    <?php foreach ($a_view_data['roomtype'] as $key => $value): ?>
                    <li class="cateBody" id="<?php echo 'tr_' . $value['type_id']; ?>">
                        <!--品种-->
                        <div class="varieties">
                            <em class="v1">
                                <img src="./static/style_default/image/pro_07.png" value="<?php echo $value['type_id']; ?>" />
                                <p >
                                    <!--<img src="./static/style_default/image/pro_48.png" />-->
                                    <span><?php if ($value['type_cate'] == 1) { echo '[会议] '; } else { echo '[餐厅] '; } ?><?php echo str_repeat('└―', $value['type_level']);if ($value['type_level'] == 0) {  echo '<strong>'.$value['type_name'].'</strong>'; } else { echo $value['type_name']; }; ?></span>
                                </p>
                            </em>
                            <em class="v2"><?php echo $value['type_description']; ?></em>
                            <em class="v3" id="<?php echo "switch_".$value['type_id'];?>" onclick="type_switch(<?php echo $value['type_id']; ?>)" value="<?php echo $value['type_state']; ?>">
                            <?php if ($value['type_state'] == 1) {
                                echo '<img src="./static/style_default/image/pro_10.png" />';
                            } else {
                                echo '<img src="./static/style_default/image/pro_33.png" />';
                            } ?>
                            </em>
                            <em class="v4">
                                <img src="./static/style_default/image/pro_26.png" onclick="type_delete_one(<?php echo $value['type_id']; ?>)" />
                                <img src="./static/style_default/image/pro_28.png" onclick="type_update(<?php echo $value['type_id']; ?>)" />
                            </em>
                        </div>
                        <!--品种-->
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <!-- 房型分类列表 -->
        </div>
        <!-- 房型分类 -->

        <!--  底部选项 -->
        <div class="bottomTool">
            <a class="bottomAllSelect">
                <img src="./static/style_default/image/pro_07.png" />
                <span>全选</span>
            </a>
            <a class="bottomDelect" onclick="type_delete_mony()">
                <img src="./static/style_default/image/pro_26.png" />
                <span>删除</span>
            </a>
            <a class="bottomProvisional" onclick="type_switch_mony()">
                <img src="./static/style_default/image/pro_52.png" />
                <span>暂用</span>
            </a>
        </div>
        <!--  底部选项 -->

        <!--  重要提示 -->
        <div class="tips hide">
            <em>重要提示</em>
            <img src="./static/style_default/image/pro_19.png" class="delete_cancel" />
            <p>
                <span>▪ 确认删除此部分分类吗？</span>
                <span>▪ 删除后不可恢复！</span>
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

// 显示隐藏
function type_switch(type_id) {
    var type_state = $("#switch_"+type_id).attr('value');
    $.ajax({
        url: 'type_switch',
        type: 'POST',
        dataType: 'json',
        data: {type_id: type_id},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                if (type_state == 1) {
                    $("#switch_"+type_id).html('<img src="./static/style_default/image/pro_33.png" />');
                    $("#switch_"+type_id).attr('value','0');
                } else {
                    $("#switch_"+type_id).html('<img src="./static/style_default/image/pro_10.png" />');
                    $("#switch_"+type_id).attr('value', '1');
                }
            }
        }
    })
}

// 批量显示隐藏
function type_switch_mony() {
    $(".cateBody .body_selectA").each(function(index, value) {
        type_switch($(this).attr('value'));
    });
}

// 单个删除
function type_delete_one(type_id) {
    $(".tips").removeClass('hide');
    $(".delete_confirm").click(function(event) {
        $.ajax({
            url: 'type_delete',
            type: 'POST',
            dataType: 'json',
            data: {type_id: type_id, type: 1},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    $('#tr_'+type_id).remove();
                }
            }
        });
         $(".tips").addClass('hide');
    });
    $(".delete_cancel").click(function(event) {
        $(".tips").addClass('hide');
    });
}

// 批量删除
function type_delete_mony() {
    $(".tips").removeClass('hide');
    $(".delete_confirm").click(function(event) {
        var type_ids = new Array();
        var i = 0;
        $(".cateBody .body_selectA").each(function(index, value) {
            type_ids[i] = $(this).attr('value');
            i++;
        });
        if (type_ids.length > 0) {
            $.ajax({
                url: 'type_delete',
                type: 'post',
                dataType: 'json',
                data: {type: 2, type_ids:type_ids},
                success: function(data) {
                    console.log(data);
                    for (var j = 0; j<type_ids.length; j++) {
                        $('#tr_'+type_ids[j]).remove();
                    }
                }
            });
        }
        $(".tips").addClass('hide');
    });
    $(".delete_cancel").click(function(event) {
        $(".tips").addClass('hide');
    });
}

function type_search() {
    var keywords = $("input[name='keywords']").val();
    if (keywords != '') {
        $("#searchform").submit();
    }
}

function type_update(type_id) {
    window.location.href = 'type_update-'+type_id;
}

</script>