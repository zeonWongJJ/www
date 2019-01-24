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
    <link rel="stylesheet" href="./static/style_default/style/roomList.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/roomList.js"></script>
    <title>房间列表</title>
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

        <!-- 房间管理 -->
        <div class="roomManagers">
            <p>房间管理 > <a href="room_showlist" style="color:#000;">房间列表</a><?php if ($a_view_data['type'] == 6) { echo ' > 搜索房间 ['.$a_view_data['keywords'].']'; } ?></p>
            <!-- 房间列表 -->
            <div class="room_List">
                <form id="searchform" action="room_search" method="post">
                    <a class="addStorePage" href="room_add"><img src="./static/style_default/image/pro_03.png" />发布房间</a>
                    <div class="searchRoom">
                        <input name="keywords" type="text" placeholder="房间名称" <?php if ($a_view_data['type'] == 6) { echo 'value="'.$a_view_data['keywords'].'"'; } ?> />
                        <i><img src="./static/style_default/image/s_03.png" onclick="room_search()" /></i>
                    </div>
                </form>
                <ul class="cateList">
                    <li class="cateHead">
                        <em class="v1" style="text-align:left;">
                            <img src="./static/style_default/image/pro_07.png" />
                            <p>
                                <span>房间名称</span>
                            </p>
                        </em>
                        <em class="v2" style="text-align:center;">所属分类</em>
                        <em class="v3">房间描述</em>
                        <em class="v4">配备设备</em>
                        <em class="v5">房间大小</em>
                        <em class="v6">座位</em>
                        <em class="v7">是否开放</em>
                        <em class="v8">操作</em>
                    </li>
                    <?php foreach ($a_view_data['room'] as $key => $value): ?>
                    <li class="cateBody" id="<?php echo 'tr_' . $value['room_id']; ?>">
                        <div class="varieties">
                            <em class="v1" style="text-align:left;">
                                <img src="./static/style_default/image/pro_07.png" value="<?php echo $value['room_id']; ?>" />
                                <p >
                                    <span><?php echo $value['room_name']; ?></span>
                                </p>
                            </em>
                            <em class="v2">
                            <?php if ($value['type_cate'] == 1) { echo '[会议] '; } else { echo '[餐厅] '; } ?>
                            <?php echo $value['type_name']; ?>
                            </em>
                            <em class="v3"><?php echo $value['room_description']; ?></em>
                            <em class="v4"><?php echo substr($value['device'], 0, -3); ?></em>
                            <em class="v5"><?php echo $value['room_size']; ?>m<sup>2</sup></em>
                            <em class="v6"><?php echo $value['room_seat']; ?></em>
                            <em class="v7" id="<?php echo "switch_".$value['room_id'];?>" onclick="room_switch(<?php echo $value['room_id']; ?>)" value="<?php echo $value['room_state']; ?>">
                            <?php if ($value['room_state'] == 1) {
                                echo '<img src="./static/style_default/image/pro_10.png" />';
                            } else {
                                echo '<img src="./static/style_default/image/pro_33.png" />';
                            } ?>
                            </em>
                            <em class="v8 license">
                                <img src="./static/style_default/image/pro_26.png" onclick="room_delete_one(<?php echo $value['room_id']; ?>)" />
                                <img src="./static/style_default/image/pro_28.png" onclick="room_update(<?php echo $value['room_id']; ?>)" />
                            </em>
                        </div>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <!-- 房间列表 -->
        </div>
        <!-- 房间管理 -->

        <!-- 分页 -->
        <div class="page">
            <?php if ($a_view_data['type'] == 6) {
                echo $this->pages->link_style_one($this->router->url('room_search-'.$a_view_data['keywords'].'-', [], false, false));
            } else {
                echo $this->pages->link_style_one($this->router->url('room_showlist-', [], false, false));
            } ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->

        <!--  底部选项 -->
        <div class="bottomTool">
            <a class="bottomAllSelect">
                <img src="./static/style_default/image/pro_07.png" />
                <span>全选</span>
            </a>
            <a class="bottomDelect" onclick="room_delete_mony()">
                <img src="./static/style_default/image/pro_26.png" />
                <span>删除</span>
            </a>
            <a class="bottomProvisional" onclick="room_switch_mony()">
                <img src="./static/style_default/image/pro_52.png" />
                <span>暂用</span>
            </a>
        </div>
        <!--  底部选项 -->

        <!-- 重要提示 -->
        <div class="pop_tips hide">
            <p>重要提示</p>
            <img src="/static/style_default/image/pro_19.png" class="closeTips delete_cancel" />
            <div class="tipsText">
                <p><s>*</s>确认要删除这部分房间吗</p>
                <p><s>*</s>删除后不可恢复，拥有此部分设备的房间将删除该设备</p>
            </div>
            <div class="btnBox">
                <span class="delete_confirm">确认</span>
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

// 显示隐藏
function room_switch(room_id) {
    var room_state = $("#switch_"+room_id).attr('value');
    $.ajax({
        url: 'room_switch',
        type: 'POST',
        dataType: 'json',
        data: {room_id: room_id},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                if (room_state == 1) {
                    $("#switch_"+room_id).html('<img src="./static/style_default/image/pro_33.png" />');
                    $("#switch_"+room_id).attr('value','0');
                } else {
                    $("#switch_"+room_id).html('<img src="./static/style_default/image/pro_10.png" />');
                    $("#switch_"+room_id).attr('value', '1');
                }
            }
        }
    })
}

// 批量显示隐藏
function room_switch_mony() {
    $(".cateBody .varietiesChoice").each(function(index, value) {
        room_switch($(this).attr('value'));
    });
}

// 单个删除
function room_delete_one(room_id) {
    $(".pop_tips").removeClass('hide');
    $(".delete_confirm").click(function(event) {
        $.ajax({
            url: 'room_delete',
            type: 'POST',
            dataType: 'json',
            data: {room_id: room_id, type: 1},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    $('#tr_'+room_id).remove();
                }
            }
        });
         $(".pop_tips").addClass('hide');
    });
    $(".delete_cancel").click(function(event) {
        $(".pop_tips").addClass('hide');
    });
}

// 批量删除
function room_delete_mony() {
    $(".pop_tips").removeClass('hide');
    $(".delete_confirm").click(function(event) {
        var room_ids = new Array();
        var i = 0;
        $(".cateBody .varietiesChoice").each(function(index, value) {
            room_ids[i] = $(this).attr('value');
            i++;
        });
        if (room_ids.length > 0) {
            $.ajax({
                url: 'room_delete',
                type: 'post',
                dataType: 'json',
                data: {type: 2, room_ids:room_ids},
                success: function(data) {
                    console.log(data);
                    for (var j = 0; j<room_ids.length; j++) {
                        $('#tr_'+room_ids[j]).remove();
                    }
                }
            });
        }
        $(".pop_tips").addClass('hide');
    });
    $(".delete_cancel").click(function(event) {
        $(".pop_tips").addClass('hide');
    });
}

// 搜索房间
function room_search() {
    var keywords = $("input[name='keywords']").val();
    if (keywords != '') {
        $("#searchform").submit();
    }
}

// 修改房间
function room_update(room_id) {
    window.location.href = "room_update-"+room_id;
}

</script>