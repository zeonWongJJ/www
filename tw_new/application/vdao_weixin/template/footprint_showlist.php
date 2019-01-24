<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="./static/style_default/style/common.css"/>
    <link rel="stylesheet" href="./static/style_default/style/footprint.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/plugin/flexible.js"></script>
    <script src="./static/style_default/script/footprint.js"></script>
    <title>我的足迹</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 我的足迹 -->
    <div class="footprint">
        <p class="pjoTitle">
            <!--<img style="margin-top:0.4rem;" src="./static/style_default/images/kefu_03.png" onclick="javascript:window.location.href='user_center';" />-->
            <a class="back" onclick="javascript:window.location.href='user_center';"><img src="static/style_default/images/yongping_03.png" /></a>
            <span>我的足迹</span>
            <a style="top:0.3rem;" class="edit">编辑</a>
        </p>
        <!-- 列表 -->
        <div class="footprintList">
            <dl>
            <?php for ($i=0; $i < count($a_view_data['time']); $i++) { ?>
            <dt>
                <a>
                    <img src="./static/style_default/images/check_06.png" />
                    <span><?php echo date('m月d日', $a_view_data['time'][$i]); ?></span>
                </a>
            </dt>
            <?php foreach ($a_view_data['footprint'] as $key => $value): ?>
            <?php if (date('Ymd', $value['footprint_time']) == date('Ymd', $a_view_data['time'][$i])) { ?>
            <?php if ($value['footprint_type'] == 2) { ?>
            <dd>
                <img src="./static/style_default/images/check_06.png" value="<?php echo $value['footprint_id']; ?>" />
                <a class="listContent" href="office_detail-<?php echo $value['object_id']; ?>">
                    <?php if (empty($value['room_mainpic'])) {
                        echo '<img src="./static/style_default/images/tou_03.png" />';
                    } else {
                        echo '<img src="'.$value['room_mainpic'].'">';
                    } ?>
                    <em>
                        <dfn>
                            <em><?php echo $value['room_name']; ?></em>
                            <span></span>
                        </dfn>
                        <span><?php echo $value['room_size'].'m<sup>2</sup> '. $value['room_device'] . ' 可坐'.$value['room_seat'].'人'; ?></span>
                        <p style="display:none;">
                            <span>月售3辆</span>
                            <span>好评率100%</span>
                        </p>
                    </em>
                </a>
            </dd>
            <?php } else { ?>
           <dd>
                <img src="./static/style_default/images/check_06.png" value="<?php echo $value['footprint_id']; ?>" />
                <a class="listContent" href="<?php echo $value['gourl']; ?>">
                    <?php if (empty($value['pro_img'])) {
                        echo '<img src="./static/style_default/images/tou_03.png" />';
                    } else {
                        echo '<img src="'.$value['pro_img'].'">';
                    } ?>
                    <em>
                        <dfn>
                            <em><?php echo $value['product_name']; ?></em>
                            <span></span>
                        </dfn>
                        <span><?php echo $value['pro_details']; ?></span>
                        <p style="display:none;">
                            <span>月售3辆</span>
                            <span>好评率100%</span>
                        </p>
                    </em>
                </a>
            </dd>
            <?php } ?>
            <?php } ?>
            <?php endforeach ?>
            <?php } ?>
            </dl>
        </div>
        <!-- 列表 -->

        <!-- 底部 -->
        <div class="bottom">
            <a class="cancel">取消</a>
            <a class="delete">删除</a>
        </div>
        <!-- 底部 -->
        <input type="hidden" name="isedit" value="1">
        <!-- 提示层 -->
        <div class="tips">

        </div>
        <!-- 弹出层 -->
    </div>
    <!-- 我的足迹 -->
</body>
</html>

<script>

var page = 1;
var stop = true;
var recode = 200;
// 当滚动条滚到底时加载更多
$(window).scroll(function(){
    totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
    if($(document).height() <= totalheight){
        if (stop == true) {
            footprint_getmore();
        }
        if (recode == 400) {
            stop = false;
        }
    }
});

function footprint_getmore() {
    var isedit = $("input[name='isedit']").val();
    page++;
    $.ajax({
        url: 'footprint_getmore',
        type: 'POST',
        dataType: 'json',
        data: {page: page},
        success: function(res) {
            console.log(res);
            recode = res.code;
            if (res.code == 200) {
                var append_content = '';
                for(var i = 0; i < res.data.time.length; i++){
                    append_content += '<dt>';
                    append_content += '<a>';
                    append_content += '<img style="display:none;" src="./static/style_default/images/check_06.png" />';
                    append_content += '<span>'+res.data.time[i]+'</span>';
                    append_content += '</a>';
                    append_content += '</dt>';
                    $.each(res.data.footprint, function(index, el) {
                        if (el.footprint_time == res.data.time[i]) {
                            if (el.footprint_type == 2) {
                                // 房间
                                append_content += '<dd class="new_dd">';
                                if (isedit == 1) {
                                    append_content += '<img style="display:none;" src="./static/style_default/images/check_06.png" value="'+el.footprint_id+'" class="newcheck" onclick="check_this('+el.footprint_id+')" id="newimg_'+el.footprint_id+'" />';
                                } else {
                                    append_content += '<img style="display:inline-block;" src="./static/style_default/images/check_06.png" value="'+el.footprint_id+'" class="newcheck" onclick="check_this('+el.footprint_id+')" id="newimg_'+el.footprint_id+'" />';
                                }
                                append_content += '<a class="listContent" href="office_detail-'+el.object_id+'">';
                                if (el.room_mainpic == '') {
                                    append_content += '<img src="./static/style_default/images/tou_03.png" />';
                                } else {
                                    append_content += '<img src="'+el.room_mainpic+'">';
                                }
                                append_content += '<em>';
                                append_content += '<dfn>';
                                append_content += '<em>'+el.room_name+'</em>';
                                append_content += '<span></span>';
                                append_content += '</dfn>';
                                append_content += '<span>'+el.room_size+'m<sup>2</sup> '+el.room_device+' 可坐'+el.room_seat+'人</span>';
                                append_content += '<p style="display:none;">';
                                append_content += '<span>月售3辆</span>';
                                append_content += '<span>好评率100%</span>';
                                append_content += '</p>';
                                append_content += '</em>';
                                append_content += '</a>';
                                append_content += '</dd>';
                            } else {
                                // 产品
                                append_content += '<dd class="new_dd">';
                                if (isedit == 1) {
                                    append_content += '<img style="display:none;" src="./static/style_default/images/check_06.png" value="'+el.footprint_id+'" class="newcheck" onclick="check_this('+el.footprint_id+')" id="newimg_'+el.footprint_id+'" />';
                                } else {
                                    append_content += '<img style="display:inline-block;" src="./static/style_default/images/check_06.png" value="'+el.footprint_id+'" class="newcheck" onclick="check_this('+el.footprint_id+')" id="newimg_'+el.footprint_id+'" />';
                                }
                                append_content += '<a class="listContent" href="'+el.gourl+'">';
                                if (el.pro_img == '') {
                                    append_content += '<img src="./static/style_default/images/tou_03.png" />';
                                } else {
                                    append_content += '<img src="'+el.pro_img+'">';
                                }
                                append_content += '<em>';
                                append_content += '<dfn>';
                                append_content += '<em>'+el.product_name+'</em>';
                                append_content += '<span></span>';
                                append_content += '</dfn>';
                                append_content += '<span>'+el.pro_details+'</span>';
                                append_content += '<p style="display:none;">';
                                append_content += '<span>月售3辆</span>';
                                append_content += '<span>好评率100%</span>';
                                append_content += '</p>';
                                append_content += '</em>';
                                append_content += '</a>';
                                append_content += '</dd>';
                            }
                        }
                    });
                }
                $('.footprintList dl').append(append_content);
                $(".new_dd .listContent>em").css("width","7.16rem");
                $(".footprintList>dl>.new_dd>a>em>dfn>span").css("margin-left","2.5rem");
            }
        }
    })
}

function new_check() {
    $(".newcheck").each(function(index, el) {
        if ( $(this).css('display') == 'none') {
            $(this).css('display', 'inline-block');
        } else {
            $(this).removeClass('checkChild');
            $(this).attr('src', '/static/style_default/images/check_06.png');
            $(this).css('display', 'none');
        }
    });
}

function check_this(footprint_id) {
    if ($('#newimg_'+footprint_id).hasClass('checkChild')) {
        $('#newimg_'+footprint_id).removeClass('checkChild');
        $('#newimg_'+footprint_id).attr('src', '/static/style_default/images/check_06.png');
    } else {
        $('#newimg_'+footprint_id).addClass('checkChild');
        $('#newimg_'+footprint_id).attr('src', '/static/style_default/images/check_03.png');
    }
}

</script>