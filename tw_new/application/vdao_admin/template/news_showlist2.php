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
    <link rel="stylesheet" href="./static/style_default/style/newsList.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/newList.js"></script>
    <title>新闻列表</title>
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

        <!-- 新闻列表 -->
        <div class="newsList">
            <p><a href="news_showlist" style="color:#000;">新闻管理</a> > 新闻列表

            <em>
                <a href="news_add"><img src="./static/style_default/image/pro_03.png" />发布新闻</a>
            </em>
            </p>
            <div class="news_content">
                <!-- 分类 -->
                <ul class="newCateBox">
                    <li class="news_cateA">
                        <a href="news_showlist-all"><span <?php if ($a_view_data['cate_one'] == 'all') { echo 'class="cateCur"'; } ?> >全部分类</span></a>
                        <?php foreach ($a_view_data['cate'] as $key => $value): ?>
                        <?php if ($value['cate_level'] == 0) {
                            if ($value['cate_id'] == $a_view_data['cate_one']) {
                                echo "<a href='news_showlist-".$value['cate_id']."'><span class='cateCur'>" . $value['cate_name'] . "</span></a>";
                            } else {
                                echo "<a href='news_showlist-".$value['cate_id']."'><span>" . $value['cate_name'] . "</span></a>";
                            }
                        } ?>
                        <?php endforeach ?>
                    </li>
                    <li class="news_cateB">
                        <em>二级分类：</em>
                        <a href="news_showlist-<?php echo $a_view_data['cate_one']; ?>"><span <?php if ($a_view_data['cate_two'] == 'all') { echo 'class="typeCur"'; } ?> >全部</span></a>
                        <?php foreach ($a_view_data['cate'] as $key => $value): ?>
                            <?php if ($value['cate_pid'] == $a_view_data['cate_one']) {
                                if ($value['cate_id'] == $a_view_data['cate_two']) {
                                    echo "<a href='news_showlist-".$value['cate_id']."'><span class='typeCur'>" . $value['cate_name'] . "</span></a>";
                                } else {
                                    echo "<a href='news_showlist-".$value['cate_id']."'><span>" . $value['cate_name'] . "</span></a>";
                                }
                            } ?>
                        <?php endforeach ?>
                    </li>
                    <li class="news_cateC">
                        <em>三级分类：</em>
                        <a href="news_showlist-<?php echo $a_view_data['cate_two']; ?>"><span <?php if ($a_view_data['cate_three'] == 'all') { echo 'class="typeCur"'; } ?> >全部</span></a>
                        <?php foreach ($a_view_data['cate'] as $key => $value): ?>
                            <?php if ($value['cate_pid'] == $a_view_data['cate_two']) {
                                if ($value['cate_id'] == $a_view_data['cate_three']) {
                                    echo "<a href='news_showlist-".$value['cate_id']."'><span class='typeCur'>" . $value['cate_name'] . "</span></a>";
                                } else {
                                    echo "<a href='news_showlist-".$value['cate_id']."'><span>" . $value['cate_name'] . "</span></a>";
                                }
                            } ?>
                        <?php endforeach ?>
                    </li>
                </ul>
                <!-- 分类 -->
                <!-- 选择新闻 -->
                <ul class="newsBox">
                    <?php foreach ($a_view_data['news'] as $key => $value): ?>
                    <li class="choiceNews" id="<?php echo "tr_".$value['news_id']; ?>">
                        <div class="leftNews">
                            <img src="./static/style_default/image/pro_07.png" value="<?php echo $value['news_id']; ?>" />
                            <span value="<?php echo $value['news_id']; ?>"><?php echo $value['news_title']; ?></span>
                        </div>
                        <div class="rightNews">
                            <em>
                                <img src="./static/style_default/image/clo_03.png" />
                                <span><?php echo date('Y-m-d H:i:s', $value['news_time']); ?></span>
                            </em>
                            <span>
                                <span class="switch" id="<?php echo "switch_".$value['news_id'];?>" onclick="news_switch(<?php echo $value['news_id']; ?>)" value="<?php echo $value['news_state']; ?>">
                                    <?php if ($value['news_state'] == 1) {
                                        echo '<img src="./static/style_default/image/ann_07.png" />&nbsp;&nbsp;';
                                    } else {
                                        echo '<img src="./static/style_default/image/ann_10.png" />&nbsp;&nbsp;';
                                    } ?>
                                </span>
                                <img src="./static/style_default/image/pro_26.png" onclick="news_delete_one(<?php echo $value['news_id']; ?>)" />
                                <img src="./static/style_default/image/pro_28.png" onclick="news_update(<?php echo $value['news_id']; ?>)" />
                            </span>
                        </div>
                    </li>
                    <?php endforeach ?>
                </ul>
                <!-- 选择新闻 -->
            </div>

        </div>
        <!-- 新闻列表 -->

        <!--  底部选项 -->
        <div class="bottomTool">
            <a class="bottomAllSelect">
                <img src="./static/style_default/image/pro_07.png" />
                <span>全选</span>
            </a>
            <a class="bottomDelect" onclick="news_delete_mony()">
                <img src="./static/style_default/image/pro_26.png" />
                <span>删除</span>
            </a>
            <a class="bottomHide" onclick="news_switch_mony()">
                <img src="./static/style_default/image/ann_10.png" />
                <span>隐藏</span>
            </a>

        </div>
        <!--  底部选项 -->

        <!-- 分页 -->
        <div class="page">
            <?php echo $this->pages->link_style_one($this->router->url('news_showlist-'.$a_view_data['cate_id'].'-', [], false, false)); ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->

        <!-- 显示信息层 -->
        <div class="showLay hide">
            <h3></h3>
            <div class="toolBox">
                <img src="./static/style_default/image/ann_07.png" class="pre_switch" onclick="pre_switch()" />
                <img src="./static/style_default/image/pro_26.png" class="pre_delete" onclick="delete_news_one()" />
                <img src="./static/style_default/image/pro_28.png" class="pre_update" onclick="news_update()" />
                <em>
                    <span class="pre_time1">2017-09-01</span>
                    <s class="pre_time2">19:00</s>
                </em>
            </div>
            <div class="layTextBox"></div>
        </div>
        <!-- 显示信息层 -->

        <!--  重要提示 -->
        <div class="tips hide">
            <em>重要提示</em>
            <img class="delete_cancel" src="./static/style_default/image/pro_19.png" />
            <p>
                <span>▪ 确认删除此新闻吗？</span>
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

// 启用停用开关
function news_switch(news_id) {
    var news_state = $('#switch_'+news_id).attr('value');
    $.ajax({
        url: '<?php echo $this->router->url('news_switch'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {news_id: news_id},
        success:function(data) {
            console.log(data);
            if (data.code==200) {
                if (news_state == 1) {
                    $('#switch_'+news_id).html('<img src="./static/style_default/image/ann_10.png" />&nbsp;&nbsp;');
                    $('#switch_'+news_id).attr('value', '0');
                } else {
                    $('#switch_'+news_id).html('<img src="./static/style_default/image/ann_07.png" />&nbsp;&nbsp;');
                    $('#switch_'+news_id).attr('value', '1');
                }
            }
        }
    })
}

// 批量启用停用
function news_switch_mony() {
    $('.newsSelect').each(function(index, el) {
        news_switch($(this).attr('value'));
    });
}

// 单个删除
function news_delete_one(news_id) {
    $('.tips').removeClass('hide');
    $('.delete_confirm').click(function(event) {
        $.ajax({
            url: '<?php echo $this->router->url('news_delete'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {news_id: news_id, type: 1},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    $("#tr_"+news_id).remove();
                }
            }
        })
        $('.tips').addClass('hide');
    });
    $('.delete_cancel').click(function(event) {
        $('.tips').addClass('hide');
    });
}

// 批量删除
function news_delete_mony() {
    $('.tips').removeClass('hide');
    $('.delete_confirm').click(function(event) {
        var news_ids = new Array();
        var i = 0;
        $(".newsSelect").each(function(index, el) {
            news_ids[i] = $(this).attr('value');
            i++;
        });
        if (news_ids.length > 0) {
            $.ajax({
                url: '<?php echo $this->router->url('news_delete'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {news_ids: news_ids, type: 2},
                success: function(data) {
                    console.log(data);
                    if (data.code==200) {
                        for (var j=0; j<news_ids.length; j++) {
                            $('#tr_'+news_ids[j]).remove();
                        }
                    }
                }
            })
        }
        $('.tips').addClass('hide');
    });
    $('.delete_cancel').click(function(event) {
        $('.tips').addClass('hide');
    });
}

// 预览动态
$(".leftNews>span").click(function(e){
    var news_id = $(this).attr('value');
    $.ajax({
        url: 'news_preview',
        type: 'POST',
        dataType: 'json',
        data: {news_id: news_id},
        success: function (res) {
            console.log(res);
            if (res.code == 200) {
                $('.showLay h3').html(res.data.news_title);
                $('.showLay .pre_delete').attr('onclick', 'news_delete_one('+res.data.news_id+')');
                $('.showLay .pre_update').attr('onclick', 'news_update('+res.data.news_id+')');
                if (res.data.news_state == 1) {
                    $(".pre_switch").attr('src','./static/style_default/image/ann_07.png');
                } else {
                    $(".pre_switch").attr('src','./static/style_default/image/ann_10.png');
                }
                $('.showLay .pre_switch').attr('onclick', 'pre_switch('+res.data.news_id+')');
                $('.showLay .pre_switch').attr('value', res.data.news_state);
                $('.pre_time1').html(res.data.news_time1);
                $('.pre_time2').html(res.data.news_time2);
                $('.layTextBox').html(res.data.news_content);
            }
        }
    })
    $(".showLay").removeClass("hide");
    e.stopPropagation();
});
$(".showLay").click(function(e){
    e.stopPropagation();
});
$(document.body).click(function(){
    $(".showLay").addClass("hide");
});

// 修改新闻
function news_update(news_id) {
    window.location.href = 'news_update-'+news_id;
}

// 开关
function pre_switch(news_id) {
    news_switch(news_id);
    if ($('.pre_switch').attr('value') == 1) {
        $('.pre_switch').attr('value', 0);
        $('.pre_switch').attr('src', './static/style_default/image/ann_10.png');
    } else {
        $('.pre_switch').attr('value', 1);
        $('.pre_switch').attr('src', './static/style_default/image/ann_07.png');
    }
}

</script>