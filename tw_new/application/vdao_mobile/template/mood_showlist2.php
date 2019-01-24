<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/dynamic.css"/>
    <link rel="stylesheet" href="static/style_default/style/swiper.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/plugin/swiper.js"></script>
    <script src="static/style_default/script/dynamic.js"></script>
    <title>动态</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 动态列表-->
    <div class="dynamic">
        <p class="pjoTitle">
            <span><?php if ($a_view_data['keywords'] == 'all') { echo '全部'; } else { echo $a_view_data['keywords']; } ?></span>
            <a class="menu"><img src="static/style_default/images/dt_03.png" /></a>
        </p>
        <!-- 标签 -->
        <div class="labelBox">
            <p>查询指定标签</p>
            <ul>
                <li><a <?php if ($a_view_data['thistag'] == 'all') { echo 'style="color:rgb(255, 102, 51);"'; } ?> href="mood_showlist">全部</a></li>
                <?php foreach ($a_view_data['tag'] as $key => $value): ?>
                    <li><a href="mood_showlist-<?php echo $value['tag_id']; ?>" <?php if ($a_view_data['thistag'] == $value['tag_id']) { echo 'style="color:rgb(255, 102, 51);"'; } ?>><?php echo $value['tag_name']; ?></a></li>
                <?php endforeach ?>
            </ul>
        </div>
        <!-- 标签 -->
        <!-- 列表内容 -->
        <div class="listContent">
            <ul>
                <?php foreach ($a_view_data['mood'] as $key => $value): ?>
                <li>
                    <ol>
                        <li class="userInfo">
                            <?php if (empty($value['user_pic'])) {
                                echo '<img src="static/style_default/images/tou_03.png" />';
                            } else {
                                echo '<img src="'.$value['user_pic'].'">';
                            } ?>
                            <em>
                                <p><?php echo $value['user_name']; ?></p>
                                <span><?php if ($value['mood_time'] > (time()-3600)) {
                                    echo ceil((time()-$value['mood_time'])/60).'分钟前';
                                } else if ($value['mood_time'] > (time()-86400)) {
                                    echo ceil((time()-$value['mood_time'])/3600).'小时前';
                                } else {
                                    echo date('Y-m-d', $value['mood_time']);
                                } ?></span>
                            </em>
                            <!--<a class="talk">聊天</a>-->
                        </li>
                        <li class="userText" onclick="mood_detail(<?php echo $value['mood_id']; ?>)">
                            <p><?php echo $value['mood_content']; ?></p>
                        </li>
                        <?php if (!empty($value['mood_pic'])) { ?>
                        <li class="userPic">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php $mood_pics = explode('&', $value['mood_pic']); ?>
                                    <?php for ($i=0; $i<count($mood_pics); $i++) { ?>
                                    <div class="swiper-slide"><img src="<?php echo $mood_pics[$i]; ?>" /></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                        <!--加的转发开始-->
                        <?php if ($value['mood_type'] == 2) { ?>
                        <li class="transmit">
                            <div class="tPic">
                                <a href="javascript:;">
                                <?php if (empty($value['replay_upic'])) {
                                    echo '<img src="static/style_default/images/tou_03.png"/>';
                                } else {
                                    echo '<img src="'.$value['replay_upic'].'"/>';
                                } ?>
                                </a>
                            </div>
                            <div class="tDescribe">
                                <p class="tMing"><a href="mood_detail-<?php echo $value['replay_mid']; ?>">@<?php echo $value['relay_uname']; ?></a></p>
                                <p class="tMiao"><a href="mood_detail-<?php echo $value['replay_mid']; ?>"><?php echo $value['replay_mcon']; ?></a></p>
                            </div>
                        </li>
                        <?php } ?>
                        <!--加的转发结束-->
                        <li class="userNav">
                            <div class="navBox">
                                <a href="javascript:;" onclick="mood_like(<?php echo $value['mood_id']; ?>)">
                                    <img src="static/style_default/images/dt_07.png" />
                                    <span id="moodlike_<?php echo $value['mood_id']; ?>"><?php echo $value['mood_good']; ?></span>
                                </a>
                                <a href="mood_detail-<?php echo $value['mood_id']; ?>">
                                    <img src="static/style_default/images/dt_10.png" />
                                    <span><?php echo $value['mood_discuss']; ?></span>
                                </a>
                                <a href="mood_relay-<?php echo $value['mood_id']; ?>">
                                    <img src="static/style_default/images/dt_13.png" />
                                    <span><?php echo $value['mood_relay']; ?></span>
                                </a>
                            </div>
                        </li>
                    </ol>
                </li>
                <?php endforeach ?>
            </ul>
        </div>
        <!-- 列表内容 -->
    </div>
    <!-- 动态列表 -->
    <div class="lay"></div>
    <!-- 底部导航 -->
    <?php echo $this->display('bottom'); ?>
    <!-- 底部导航 -->
</body>
</html>

<script>

// 动态点赞
function mood_like(mood_id) {
    $.ajax({
        url: 'mood_like',
        type: 'POST',
        dataType: 'json',
        data: {mood_id: mood_id},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                $('#moodlike_'+mood_id).html(res.data);
            }
        }
    })
}

// 动态详情
function mood_detail(mood_id) {
    window.location.href = 'mood_detail-'+mood_id;
}

// 获取更多动态
var page = 1;
var stop = true;
var recode = 200;
var tag_id = "<?php echo $a_view_data['thistag']; ?>";
// 当滚动条滚到底时加载更多
$(window).scroll(function(){
    totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
    if($(document).height() <= totalheight){
        if (stop == true) {
            mood_more();
        }
        if (recode == 400) {
            stop = false;
        }
    }
});

function mood_more() {
    page++;
    $.ajax({
        url: 'mood_more',
        type: 'POST',
        dataType: 'json',
        data: {page: page, tag_id: tag_id},
        success: function (res) {
            console.log(res);
            recode = res.code;
            if (res.code == 200) {
                var append_content = '';
                $.each(res.data, function(index, el) {
                    append_content += '<li>';
                    append_content += '<ol>';
                    append_content += '<li class="userInfo">';
                    append_content += el.user_pic;
                    append_content += '<em>';
                    append_content += '<p>'+el.user_name+'</p>';
                    append_content += '<span>'+el.mood_time+'</span>';
                    append_content += '</em>';
                    append_content += '<a class="talk">聊天</a>';
                    append_content += '</li>';
                    append_content += '<li class="userText" onclick="mood_detail('+el.mood_id+')">';
                    append_content += '<p>'+el.mood_content+'</p>';
                    append_content += '</li>';
                    if (el.mood_pic != '') {
                        append_content += '<li class="userPic">';
                        append_content += '<div class="swiper-container">';
                        append_content += '<div class="swiper-wrapper">';
                        var mood_pics = el.mood_pic.split('&');
                        for(var i = 0; i < mood_pics.length; i++){
                            append_content += '<div class="swiper-slide swiper-slide-active" style="width:100px; margin-right:5px;"><img src="'+mood_pics[i]+'" /></div>';
                        }
                        append_content += '</div>';
                        append_content += '</div>';
                        append_content += '</li>';
                    }
                    if (el.mood_type == 2) {
                        append_content += '<li class="transmit">';
                        append_content += '<div class="tPic">';
                        append_content += '<a href="javascript:;">';
                        if (el.replay_upic == '') {
                            append_content += '<img src="static/style_default/images/tou_03.png"/>';
                        } else {
                            append_content += '<img src="'+el.replay_upic+'"/>';
                        }
                        append_content += '</a>';
                        append_content += '</div>';
                        append_content += '<div class="tDescribe">';
                        append_content += '<p class="tMing"><a href="mood_detail-'+el.replay_mid+'">@'+el.relay_uname+'</a></p>';
                        append_content += '<p class="tMiao"><a href="mood_detail-'+el.replay_mid+'">'+el.replay_mcon+'</a></p>';
                        append_content += '</div>';
                        append_content += '</li>';
                    }
                    append_content += '<li class="userNav">';
                    append_content += '<div class="navBox">';
                    append_content += '<a href="javascript:;" onclick="mood_like('+el.mood_id+')">';
                    append_content += '<img src="static/style_default/images/dt_07.png" />';
                    append_content += '<span id="moodlike_'+el.mood_id+'">'+el.mood_good+'</span>';
                    append_content += '</a>';
                    append_content += '<a href="">';
                    append_content += '<img src="static/style_default/images/dt_10.png" />';
                    append_content += '<span>'+el.mood_discuss+'</span>';
                    append_content += '</a>';
                    append_content += '<a href="">';
                    append_content += '<img src="static/style_default/images/dt_13.png" />';
                    append_content += '<span>'+el.mood_relay+'</span>';
                    append_content += '</a>';
                    append_content += '</div>';
                    append_content += '</li>';
                    append_content += '</ol>';
                    append_content += '</li>';
                });
                $('.listContent ul').append(append_content);
            }
        }
    })
}

</script>