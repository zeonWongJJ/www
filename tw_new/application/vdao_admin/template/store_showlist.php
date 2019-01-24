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
    <link rel="stylesheet" href="./static/style_default/style/storeManagers.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/storeManagers.js"></script>
    <title>门店列表</title>
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

        <!-- 门店管理 -->
        <div class="storeManagers">
            <p><a style="color:#000;" href="store_showlist">门店管理</a> > <?php if ($a_view_data['type'] == 8) { echo '门店列表'; } else { echo '门店搜索'; } ?></p>
            <!-- 门店列表 -->
            <div class="chocie_storeList">
                <form id="searchform" action="<?php echo $this->router->url('store_search'); ?>" method="post">
                    <a class="addStorePage" href="<?php echo $this->router->url('store_add'); ?>"><img src="./static/style_default/image/pro_03.png" />添加门店</a>
                    <div class="searchStore">
                        <?php if ($a_view_data['type'] == 9) {
                            echo '<input type="text" name="keywords" placeholder="门店名称" value="'.$a_view_data['keywords'].'" required />';
                        } else {
                            echo '<input type="text" name="keywords" placeholder="门店名称" required />';
                        } ?>
                        <i onclick="store_search()"><img src="./static/style_default/image/s_03.png" /></i>
                    </div>
                </form>
                <ul class="cateList">
                    <li class="cateHead">
                        <em class="v1" style="text-align:left;">
                            <img src="./static/style_default/image/pro_07.png" />
                            <p>
                                <span>全选</span>
                                <span style="margin-left:24px">门店名称</span>
                            </p>
                        </em>
                        <em class="v2" style="text-align:center;">门店地址</em>
                        <em class="v3">联系人</em>
                        <em class="v4">联系方式</em>
                        <em class="v5">进店人数</em>
                        <em class="v6">当前在店人数</em>
                        <em class="v7">当前离店人数</em>
                        <em class="v8">营业执照</em>
                        <em class="v9">启用/暂用</em>
                        <em class="v10">操作</em>
                    </li>
                    <?php foreach ($a_view_data['store'] as $key => $value): ?>
                    <li class="cateBody" id="<?php echo 'tr_' . $value['store_id']; ?>">
                        <div class="varieties">
                            <em class="v1" style="text-align:left;">
                                <img src="./static/style_default/image/pro_07.png" value="<?php echo $value['store_id']; ?>" />&nbsp;&nbsp;
                                <p>
                                    <span><?php echo $value['store_name']; ?></span>
                                </p>
                            </em>
                            <em class="v2"><?php echo $value['store_address']; ?></em>
                            <em class="v3"><?php echo $value['store_linkman']; ?></em>
                            <em class="v4"><?php echo $value['store_contact']. '<br>' . $value['store_tel']; ?></em>
                            <em class="v5"><?php echo $value['in_all']; ?></em>
                            <em class="v6"><?php echo $value['in_cur']; ?></em>
                            <em class="v7"><?php echo $value['out_cur']; ?></em>
                            <em class="v8 license" value="<?php echo $value['store_licence']; ?>">查看</em>
                            <em class="v9" id="<?php echo 'switch_'.$value['store_id']; ?>" onclick="store_switch(<?php echo $value['store_id']; ?>)" value="<?php echo $value['store_state']; ?>">
                            <?php if ($value['store_state'] == 1) {
                                echo '<img src="./static/style_default/image/pro_10.png" />';
                            } else {
                                echo '<img src="./static/style_default/image/pro_33.png" />';
                            } ?>
                            </em>
                            <em class="v10">
                                <img src="./static/style_default/image/pro_26.png" onclick="store_delete_one(<?php echo $value['store_id']; ?>)" />
                                <img src="./static/style_default/image/pro_28.png" onclick="store_update(<?php echo $value['store_id']; ?>)" />
                            </em>
                        </div>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <!-- 门店列表 -->
        </div>
        <!-- 门店管理 -->

        <!-- 分页 -->
        <div class="page">
            <?php if ($a_view_data['type'] == 9) {
                 echo $this->pages->link_style_one($this->router->url('store_search-'.$a_view_data['keywords'].'-', [], false, false));
            } else {
                echo $this->pages->link_style_one($this->router->url('store_showlist-', [], false, false));
            } ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->

        <!-- 营业执照 -->
        <div class="businessLicense hide">
            <h4>营业执照</h4>
            <img src="" />
            <span class="closeLic">关闭窗口</span>
        </div>
        <!-- 营业执照 -->

        <!--  底部选项 -->
        <div class="bottomTool">
            <a class="bottomAllSelect">
                <img src="./static/style_default/image/pro_07.png" />
                <span>全选</span>
            </a>
            <a class="bottomDelect" onclick="store_delete_mony()">
                <img src="./static/style_default/image/pro_26.png" />
                <span>删除</span>
            </a>
            <a class="bottomProvisional" onclick="store_switch_mony()">
                <img src="./static/style_default/image/pro_52.png" />
                <span>暂用</span>
            </a>

        </div>
        <!--  底部选项 -->

        <!-- 重要提示 -->
        <div class="pop_tips hide">
            <p>重要提示</p>
            <img src="./static/style_default/image/pro_19.png" class="closeTips delete_cancel" />
            <div class="tipsText">
                <p><s>*</s>你确定要删除这家门店吗？</p>
                <p><s>*</s>删除后不可恢复，且与该门店有关的数据将会丢失</p>
            </div>
            <div class="btnBox">
                <span class="delete_confirm">确认</span>
                <em class="delete_cancel">再看看</em>
            </div>
        </div>
        <!-- 重要提示 -->

        <!-- 添加门店 -->
        <div class="addBox hide">
            <iframe src="store_add" frameborder="0"></iframe>
            <img src="./static/style_default/image/pro_19.png" class="closeAddStore" />
        </div>
        <!-- 添加门店 -->
    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>


<script>

// 单个停用启用
function store_switch(store_id) {
    var store_state = $('#switch_'+store_id).attr('value');
    $.ajax({
        url: '<?php echo $this->router->url('store_switch'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {store_id: store_id},
        success: function(data){
            console.log(data);
            if (data.code==200) {
                if (store_state == 1) {
                    $('#switch_'+store_id).attr('value', '2');
                    $('#switch_'+store_id).html('<img src="./static/style_default/image/pro_33.png" alt=""/>');
                } else {
                    $('#switch_'+store_id).attr('value', '1');
                    $('#switch_'+store_id).html('<img src="./static/style_default/image/pro_10.png" alt=""/>');
                }
            }
        }
    })
}

// 批量停用启用
function store_switch_mony() {
    $(".varietiesChoice").each(function(index, value) {
        store_switch($(this).attr('value'));
    });
}

// 单条删除
function store_delete_one(store_id) {
    $('.pop_tips').show();
    $('.delete_confirm').click(function(event) {
        $.ajax({
            url: '<?php echo $this->router->url('store_delete'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {store_id: store_id, type: 1},
            success: function(res) {
                console.log(res);
                $('#tr_'+store_id).remove();
            }
        })
        $('.pop_tips').hide();
    });
}

// 关闭提示窗口
$('.delete_cancel').click(function(event) {
    $('.pop_tips').hide();
});

// 批量删除
function store_delete_mony() {
    $('.pop_tips').show();
    $('.delete_confirm').click(function(event) {
        var store_ids = new Array();
        var i = 0;
        $(".varietiesChoice").each(function(index, el) {
            store_ids[i] = $(this).attr('value');
            i++
        });
        if (store_ids.length > 0) {
            $.ajax({
                url: '<?php echo $this->router->url('store_delete'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {store_ids: store_ids, type: 2},
                success: function(data) {
                    console.log(data);
                    if (data.code==200) {
                        for (var j=0; j<store_ids.length; j++) {
                            $('#tr_'+store_ids[j]).remove();
                        }
                    }
                }
            })
        }
        $('.pop_tips').hide();
    });
}

// 搜索门店
function store_search111() {
    var keywords = $("input[name='keywords']").val();
    if (keywords != '') {
        $.ajax({
            url: '<?php echo $this->router->url('store_search'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {keywords: keywords},
            success: function(res) {
                console.log(res);
                    $(".cateList li").not(':eq(0)').remove();
                    var append_content = '';
                    $.each(res.data, function(index, el) {
                        append_content += '<li class="cateBody" id="tr_'+el.store_id+'">';
                        append_content += '<div class="varieties">';
                        append_content += '<em class="v1" style="text-align:left;"><img src="./static/style_default/image/pro_07.png" value="'+el.store_id+'" />&nbsp;&nbsp;<p><span>'+el.store_name+'</span></p></em>';
                        append_content += '<em class="v2">'+el.store_address+'</em>';
                        append_content += '<em class="v3">'+el.store_linkman+'</em>';
                        append_content += '<em class="v4">'+el.store_contact+'<br>'+el.store_tel+'</em>';
                        append_content += '<em class="v5">'+el.store_visitorall+'</em>';
                        append_content += '<em class="v6">'+el.store_visitorcur+'</em>';
                        append_content += '<em class="v7">'+el.store_visitorlea+'</em>';
                        append_content += '<em class="v8 license" value="'+el.store_licence+'">查看</em>';
                        append_content += '<em class="v9" id="switch_'+el.store_id+'" onclick="store_switch('+el.store_id+')" value="'+el.store_state+'">'
                        if (el.store_state == 1) {
                            append_content += '<img src="./static/style_default/image/pro_10.png" />';
                        } else {
                            append_content += '<img src="./static/style_default/image/pro_33.png"/>';
                        }
                        append_content += '</em>';
                        append_content += '<em class="v10"><img src="./static/style_default/image/pro_26.png" onclick="store_delete_one('+el.store_id+')" /><img src="./static/style_default/image/pro_28.png" /></em>';
                        append_content += '</div>';
                        append_content += '</li>';
                    });
                    $('.cateList').append(append_content);
            }
        });
    }
}

// 提交搜索门店
function store_search() {
    var keywords = $("input[name='keywords']").val();
    if (keywords != '') {
        $('#searchform').submit();
    }
}

function store_update(store_id) {
    window.location.href = "store_update-"+store_id;
}

</script>