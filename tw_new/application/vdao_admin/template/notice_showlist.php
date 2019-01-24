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
    <link rel="stylesheet" href="./static/style_default/style/announcements.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <title>公告列表</title>
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

        <!-- 公告管理 -->
        <div class="announcements">
            <form>
                公告管理
                <a href="<?php echo $this->router->url('notice_add'); ?>">
                <img src="/static/style_default/image/pro_03.png" />发布公告</a>
            </form>
            <!-- 公告列表 -->
            <div class="noticeContent">
                <?php foreach ($a_view_data['group'] as $key => $value): ?>
                <dl class="noticeList" >
                    <dt>
                        <img src="/static/style_default/image/ann_03.png" />
                        <span><?php echo $value['day']; ?></span>
                    </dt>
                    <?php foreach ($a_view_data['notice'] as $k => $v): ?>
                    <?php if($value['day'] == date('Ymd',$v['notice_time'])) { ?>
                    <dd id="<?php echo 'tr_'. $v['notice_id']; ?>" >
                        <h3><?php echo $v['notice_title'] ?></h3>
                        <p class="htitle" value="<?php echo $v['notice_id']; ?>"><?php
                            $subject = strip_tags($v['notice_content']);//去除html标签
                            $pattern = '/\s/';//去除空白
                            $content = preg_replace($pattern, '', $subject);
                            $seodata = mb_substr($content, 0, 100);//截取100个汉字
                            echo $seodata;
                        ?></p>
                        <div class="noticeTool">
                            <?php if ($v['notice_state'] == 1) {
                                echo '<img src="/static/style_default/image/ann_07.png" id="switch_'.$v['notice_id'].'" value="'.$v['notice_state'].'" onclick="notice_switch('.$v['notice_id'].')" />';
                            } else {
                                echo '<img src="/static/style_default/image/ann_10.png" id="switch_'.$v['notice_id'].'" value="'.$v['notice_state'].'" onclick="notice_switch('.$v['notice_id'].')" />';
                            } ?>
                            <img src="/static/style_default/image/pro_26.png" onclick="notice_delete_one(<?php echo $v['notice_id']; ?>)" />
                            <img src="/static/style_default/image/pro_28.png" onclick="notice_update(<?php echo $v['notice_id']; ?>)" />
                            <em>
                                <span><?php echo date('Y-m-d',$v['notice_time']); ?></span>
                                <s><?php echo date('H:i:s',$v['notice_time']); ?></s>
                            </em>
                        </div>
                    </dd>
                    <?php } ?>
                    <?php endforeach ?>
                </dl>
                <?php endforeach ?>
            </div>
            <!-- 公告列表 -->

            <!-- 显示信息层 -->
            <div class="showLay hide">
                <h3></h3>
                <div class="toolBox">
                    <img src="/static/style_default/image/ann_07.png" class="pre_switch" />
                    <img src="/static/style_default/image/pro_26.png" class="pre_delete" />
                    <img src="/static/style_default/image/pro_28.png" class="pre_update" />
                    <em>
                        <span class="time_one">2017-09-01</span>
                        <s class="time_two">19:00</s>
                    </em>
                </div>
                <div class="layTextBox"></div>
            </div>
            <!-- 显示信息层 -->
        </div>
        <!-- 公告管理 -->

        <!--  重要提示 -->
        <div class="tips hide">
            <em>重要提示</em>
            <img src="/static/style_default/image/pro_19.png" class="delete_cancel" />
            <p>
                <span class="span_one">▪ 确认删除此公告吗？</span>
                <span class="span_two">▪ 删除后不可恢复！</span>
            </p>
            <div class="tipsBtn">
                <em class="delete_confirm">确定</em>
                <a class="delete_cancel">再看看</a>
            </div>
        </div>
        <!--  重要提示 -->

        <!-- 分页 -->
        <div class="page" style="margin-bottom:30px;">
            <?php echo $this->pages->link_style_one($this->router->url('notice_showlist-', [], false, false)); ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>

<script>

$(function (){
    // 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });
    // 重置弹出窗口的屏幕显示位置
    var nagheight = $(window).height(); //浏览器时下窗口可视区域高度
    var nagwidth  = $(window).width(); //浏览器时下窗口可视区域宽
    var tiph   = $('.tips').outerHeight();
    var tipw   = $('.tips').outerWidth();
    $('.tips').css('top', (nagheight-tiph)/2);
    $('.tips').css('left', (nagwidth-tipw)/2);

    var showLayh   = $('.showLay').outerHeight();
    var showLayw   = $('.showLay').outerWidth();
    $('.showLay').css('top', (nagheight-showLayh)/2);
    $('.showLay').css('left', (nagwidth-showLayw)/2);

});

// 单个删除
function notice_delete_one(notice_id) {
    $('.tips .span_one').html("▪ 确认要删除此公告吗？");
    $('.tips .span_two').html("▪ 删除后不可恢复！");
    $('.tips').show();
    $('.delete_confirm').click(function(event) {
        $.ajax({
            url: '<?php echo $this->router->url('notice_delete'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {notice_id: notice_id, type: 1},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    $("#tr_"+notice_id).remove();
                    $('.noticeList').each(function(index, el) {
                        var dd_lenght = $(this).children('dd').length;
                        if (dd_lenght == 0) {
                            $(this).remove();
                        }
                    });
                }
            }
        })
        $('.tips').hide();
    });
    $('.delete_cancel').click(function(event) {
        $('.tips').hide();
    });
}

// 修改公告
function notice_update(notice_id) {
    window.location.href="/notice_update-"+notice_id;
}

// 显示隐藏公告
function notice_switch(notice_id) {
    var notice_state = $("#switch_"+notice_id).attr('value');
    var msg;
    var msg2;
    if (notice_state == 1) {
        msg = '隐藏';
        msg2 = '看不见此公告';
    } else {
        msg = '显示';
        msg2 = '可查看此公告';
    }
    $('.tips .span_one').html("▪ 确认要"+msg+"此公告吗？");
    $('.tips .span_two').html("▪ "+msg+"后用户将"+msg2);
    $('.tips').show();
    $('.delete_confirm').click(function(event) {
        $.ajax({
            url: '<?php echo $this->router->url('notice_switch'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {notice_id: notice_id},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    if (notice_state == 1) {
                        $("#switch_"+notice_id).attr({
                            src: '/static/style_default/image/ann_10.png',
                            value: '0'
                        });
                    } else {
                        $("#switch_"+notice_id).attr({
                            src: '/static/style_default/image/ann_07.png',
                            value: '1'
                        });
                    }
                }
            }
        })
        $('.tips').hide();
    });
    $('.delete_cancel').click(function(event) {
        $('.tips').hide();
    });
}


$(".htitle").click(function(e) {
    var notice_id = $(this).attr('value');
    $.ajax({
        url: '<?php echo $this->router->url('notice_preview'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {notice_id: notice_id},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                $('.showLay h3').html(res.data.notice_title);
                $('.time_one').html(res.data.notice_time1);
                $('.time_two').html(res.data.notice_time2);
                if (res.data.notice_state == 0) {
                    $('.pre_switch').attr({
                        src: '/static/style_default/image/ann_10.png',
                        value: '0',
                        onclick: 'pre_switch('+res.data.notice_id+')'
                    });
                } else {
                    $('.pre_switch').attr({
                        src: '/static/style_default/image/ann_07.png',
                        value: '1',
                        onclick: 'pre_switch('+res.data.notice_id+')'
                    });
                }
                $('.showLay .pre_delete').attr('onclick', 'notice_delete_one('+res.data.notice_id+')');
                $('.showLay .pre_update').attr('onclick', 'notice_update('+res.data.notice_id+')');
                $('.showLay .layTextBox').html(res.data.notice_content);
                $('.showLay').show();
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

function pre_switch (notice_id) {
    notice_switch(notice_id);
    if ($('.pre_switch').attr('value') == 1) {
        $('.pre_switch').attr('value', 0);
        $('.pre_switch').attr('src', './static/style_default/image/ann_10.png');
    } else {
        $('.pre_switch').attr('value', 1);
        $('.pre_switch').attr('src', './static/style_default/image/ann_07.png');
    }
}

</script>