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
    <link rel="stylesheet" href="./static/style_default/style/deviceList.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/deviceList.js"></script>
    <title>设备列表</title>
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

        <!-- 设备列表 -->
        <div class="deviceList">
            <p>房间管理 > <a href="device_showlist" style="color:#000;">设备列表</a><?php if ($a_view_data['type'] == 6) { echo ' > 搜索设备 ['.$a_view_data['keywords'].']'; } ?></p>
            <!-- 选择设备列表 -->
            <div class="chocie_deviceList">
                <form id="searchform" action="device_search" method="post">
                    <a href="device_add"><img src="/static/style_default/image/pro_03.png" />添加设备</a>
                    <div class="searchDevice">
                        <input name="keywords" type="text" placeholder="设备名称/型号" <?php if ($a_view_data['type'] == 6) { echo 'value="'.$a_view_data['keywords'].'"'; } ?> />
                        <i><img src="/static/style_default/image/s_03.png" onclick="device_search()" /></i>
                    </div>
                </form>
                <ul class="cateList">
                    <li class="cateHead">
                        <em class="v1">
                            <img src="/static/style_default/image/pro_07.png" />
                            <p>
                                <span>全选</span>
                                <span style="margin-left:24px">设备名称</span>
                            </p>
                        </em>
                        <em class="v2" style="text-align:center;">设备型号</em>
                        <em class="v3">设备描述</em>
                        <em class="v4">是否开放</em>
                        <em class="v5">操作</em>
                    </li>
                    <?php foreach ($a_view_data['device'] as $key => $value): ?>
                    <li class="cateBody" id="<?php echo 'tr_' . $value['device_id']; ?>">
                        <!--品种-->
                        <div class="varieties">
                            <em class="v1">
                                <img src="/static/style_default/image/pro_07.png" value="<?php echo $value['device_id']; ?>" />
                                <p >
                                    <img src="<?php echo $value['device_mainpic']; ?>" />
                                    <span><?php echo $value['device_name']; ?></span>
                                </p>
                            </em>
                            <em class="v2"><?php echo $value['device_version']; ?></em>
                            <em class="v3"><?php echo $value['device_description']; ?></em>
                            <em class="v4" id="<?php echo "switch_".$value['device_id'];?>" onclick="device_switch(<?php echo $value['device_id']; ?>)" value="<?php echo $value['device_state']; ?>">
                            <?php if ($value['device_state'] == 1) {
                                echo '<img src="./static/style_default/image/pro_10.png" />';
                            } else {
                                echo '<img src="./static/style_default/image/pro_33.png" />';
                            } ?>
                            </em>
                            <em class="v5">
                                <img src="/static/style_default/image/pro_26.png" onclick="device_delete_one(<?php echo $value['device_id']; ?>)" />
                                <img src="/static/style_default/image/pro_28.png" onclick="device_update(<?php echo $value['device_id']; ?>)" />
                            </em>
                        </div>
                        <!--品种-->
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <!-- 选择设备列表 -->
        </div>
        <!-- 设备列表 -->

        <!--  底部选项 -->
        <div class="bottomTool">
            <a class="bottomAllSelect">
                <img src="/static/style_default/image/pro_07.png" />
                <span>全选</span>
            </a>
            <a class="bottomDelect" onclick="device_delete_mony()">
                <img src="/static/style_default/image/pro_26.png" />
                <span>删除</span>
            </a>
            <a class="bottomProvisional" onclick="device_switch_mony()">
                <img src="/static/style_default/image/pro_52.png" />
                <span>暂用</span>
            </a>
        </div>
        <!--  底部选项 -->

        <!-- 分页 -->
        <div class="page">
            <?php if ($a_view_data['type'] == 6) {
                echo $this->pages->link_style_one($this->router->url('device_search-'.$a_view_data['keywords'].'-', [], false, false));
            } else {
                echo $this->pages->link_style_one($this->router->url('device_showlist-', [], false, false));
            } ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->

        <!-- 重要提示 -->
        <div class="pop_tips hide">
            <p>重要提示</p>
            <img src="/static/style_default/image/pro_19.png" class="closeTips delete_cancel" />
            <div class="tipsText">
                <p><s>*</s>确认要删除这部分设备吗</p>
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
function device_switch(device_id) {
    var device_state = $("#switch_"+device_id).attr('value');
    $.ajax({
        url: 'device_switch',
        type: 'POST',
        dataType: 'json',
        data: {device_id: device_id},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                if (device_state == 1) {
                    $("#switch_"+device_id).html('<img src="./static/style_default/image/pro_33.png" />');
                    $("#switch_"+device_id).attr('value','2');
                } else {
                    $("#switch_"+device_id).html('<img src="./static/style_default/image/pro_10.png" />');
                    $("#switch_"+device_id).attr('value', '1');
                }
            }
        }
    })
}

// 批量显示隐藏
function device_switch_mony() {
    $(".cateBody .varietiesChoice").each(function(index, value) {
        device_switch($(this).attr('value'));
    });
}

// 单个删除
function device_delete_one(device_id) {
    $(".pop_tips").removeClass('hide');
    $(".delete_confirm").click(function(event) {
        $.ajax({
            url: '<?php echo $this->router->url('device_delete'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {device_id: device_id, type: 1},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    $('#tr_'+device_id).remove();
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
function device_delete_mony() {
    $(".pop_tips").removeClass('hide');
    $(".delete_confirm").click(function(event) {
        var device_ids = new Array();
        var i = 0;
        $(".cateBody .varietiesChoice").each(function(index, value) {
            device_ids[i] = $(this).attr('value');
            i++;
        });
        if (device_ids.length > 0) {
            $.ajax({
                url: '<?php echo $this->router->url('device_delete'); ?>',
                type: 'post',
                dataType: 'json',
                data: {type: 2, device_ids:device_ids},
                success: function(data) {
                    console.log(data);
                    for (var j = 0; j<device_ids.length; j++) {
                        $('#tr_'+device_ids[j]).remove();
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

// 搜索设备
function device_search() {
    var keywords = $("input[name='keywords']").val();
    if (keywords != '') {
        $("#searchform").submit();
    }
}

function device_update(device_id) {
    window.location.href = "device_update-"+device_id;
}

</script>