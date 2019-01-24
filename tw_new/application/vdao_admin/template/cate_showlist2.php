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
    <link rel="stylesheet" href="./static/style_default/style/newsCate.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/cateTotal.js"></script>
    <title>新闻分类列表</title>
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

        <!-- 新闻分类 -->
        <div class="newsCateBox">
            <p class="navp"><a href="news_showlist">新闻管理</a> > <a href="cate_showlist">新闻分类</a><?php if ($a_view_data['type'] == 6) { echo ' > 分类搜索 ['.$a_view_data['keywords'].']'; } ?></p>
            <!-- 新闻分类列表 -->
            <div class="newsCateListContent">
                <form id="searchform" action="<?php echo $this->router->url('cate_search'); ?>" method="post" >
                    <a href="cate_add"><img src="./static/style_default/image/pro_03.png" />添加分类</a>
                    <div class="searchCate">
                        <?php if ($a_view_data['type'] == 1) {
                            echo '<input type="text" name="keywords" placeholder="分类名称"/>';
                        } else if ($a_view_data['type'] == 6) {
                            echo '<input type="text" name="keywords" value="'.$a_view_data['keywords'].'"/>';
                        } ?>
                        <i><img src="./static/style_default/image/s_03.png" onclick="cate_search()" /></i>
                    </div>
                </form>
                <!-- 分级列表 -->
                <div class="cateList">
                    <div class="cateHead">
                        <a class="c1">
                            <input type="checkbox"/>
                            <label><img src="./static/style_default/image/pro_07.png" /></label>
                            <span style="margin-left:25px;">新闻分类</span>
                        </a>
                        <a class="c2" style="text-align:center;">
                            <span>分类描述</span>
                        </a>
                        <a class="c3">
                            <span>新闻数量</span>
                        </a>
                        <a class="c4">
                            <span>启用/暂用</span>
                        </a>
                        <a class="c5">
                            <span>操作</span>
                        </a>
                    </div>
                    <div class="cateA">
                        <?php foreach ($a_view_data['cate'] as $key => $value): ?>
                        <div class="cateBodyA" id="<?php echo 'tr_'.$value['cate_id']; ?>">
                            <a class="c1">
                                <input type="checkbox"/>
                                <label><img src="./static/style_default/image/pro_07.png" value="<?php echo $value['cate_id']; ?>" /></label>
                                <span><?php echo str_repeat('└―', $value['cate_level']);if ($value['cate_level'] == 0) {  echo '<strong>'.$value['cate_name'].'</strong>'; } else { echo $value['cate_name']; }; ?></span>
                            </a>
                            <a class="c2">
                                <span><?php echo $value['cate_description']; ?></span>
                            </a>
                            <a class="c3">
                                <span><?php echo $value['cate_newscount']; ?></span>
                            </a>
                            <a class="c4" id="<?php echo "switch_".$value['cate_id'];?>" onclick="cate_switch(<?php echo $value['cate_id']; ?>)" value="<?php echo $value['is_show']; ?>">
                                <?php if ($value['is_show'] == 1) {
                                    echo '<img src="./static/style_default/image/pro_10.png" />';
                                } else {
                                    echo '<img src="./static/style_default/image/pro_33.png" />';
                                } ?>
                            </a>
                            <a class="c5">
                                <img src="./static/style_default/image/pro_26.png" onclick="cate_delete_one(<?php echo $value['cate_id']; ?>)" />
                                <img src="./static/style_default/image/pro_28.png" onclick="cate_update(<?php echo $value['cate_id']; ?>)" />
                            </a>
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <!-- 分级列表 -->
            <!-- 新闻分类列表 -->
        </div>
        <!-- 新闻分类 -->

        <!--  底部选项 -->
        <div class="bottomTool">
            <a class="bottomAllSelect">
                <input type="checkbox" id="bottomSelect"/>
                <label><img src="./static/style_default/image/pro_07.png" /></label>
                <span>全选</span>
            </a>
            <a class="bottomDelect" onclick="cate_delete_mony()">
                <img src="./static/style_default/image/pro_26.png" />
                <span>删除</span>
            </a>
            <a class="bottomProvisional" onclick="cate_switch_mony()">
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
                <span>▪ 确认删除这一部分分类吗？</span>
                <span>▪ 删除前请将该分类下所有新闻和子分类进行移动或者删除，否则将删除失败</span>
            </p>
            <div class="tipsBtn">
                <em class="delete_comfirm">确定</em>
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

// 启用暂用
function cate_switch(cate_id) {
    var is_show = $('#switch_'+cate_id).attr('value');
    $.ajax({
        url: '<?php echo $this->router->url('cate_switch'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {cate_id: cate_id},
        success:function(data) {
            console.log(data);
            if (data.code==200) {
                if (is_show == 1) {
                    $('#switch_'+cate_id).html('<img src="./static/style_default/image/pro_33.png" />');
                    $('#switch_'+cate_id).attr('value', '0');
                } else {
                    $('#switch_'+cate_id).html('<img src="./static/style_default/image/pro_10.png" />');
                    $('#switch_'+cate_id).attr('value', '1');
                }
            }
        }
    })
}

// 批量启用暂用
function cate_switch_mony() {
    $(".cateA .havechecked").each(function(index, el) {
        cate_switch($(this).attr('value'));
    });
}

// 单个删除
function cate_delete_one(cate_id) {
    $(".tips").removeClass('hide');
    $(".delete_comfirm").click(function(event) {
        $.ajax({
            url: 'cate_delete',
            type: 'POST',
            dataType: 'json',
            data: {cate_id: cate_id, type: 1},
            success: function(res) {
                console.log(res);
                if (res.code == 200) {
                    $("#tr_"+cate_id).remove();
                }
            }
        })
        $(".tips").addClass('hide');
    });
    $(".delete_cancel").click(function(event) {
        $(".tips").addClass('hide');
    });
}

// 批量删除
function cate_delete_mony() {
    $(".tips").removeClass('hide');
    $(".delete_comfirm").click(function(event) {
        // 获取所有选中的分类
        var cate_ids = new Array();
        var i = 0;
        $(".cateA .havechecked").each(function(index, el) {
            cate_ids[i] = $(this).attr('value');
            i++;
        });
        if (cate_ids.length > 0) {
            $.ajax({
                url: 'cate_delete',
                type: 'POST',
                dataType: 'json',
                data: {cate_ids: cate_ids, type: 2},
                success: function(res) {
                    console.log(res);
                    if (res.code == 200) {
                        for (var i=0; i<res.data.length; i++) {
                            $("#tr_"+res.data[i]).remove();
                        }
                    }
                }
            })
        }
        $(".tips").addClass('hide');
    });
    $(".delete_cancel").click(function(event) {
        $(".tips").addClass('hide');
    });
}

// 修改分类
function cate_update(cate_id) {
    window.location.href = 'cate_update-'+cate_id;
}

// 分类搜索
function cate_search() {
    var keywords = $("input[name='keywords']").val();
    if (keywords != '') {
        $("#searchform").submit();
    } else {
        window.location.href = "cate_showlist";
    }
}

</script>