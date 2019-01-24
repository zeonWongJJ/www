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
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/public.css"/>
    <link rel="stylesheet" href="static/style_default/style/index.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="http://echarts.baidu.com/build/dist/echarts.js"></script>
    <script src="static/style_default/script/index.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/plugin/cycle.js"></script>
    <script src="static/style_default/plugin/raphael.js"></script>
    <title>爽爽挝啡管理</title>
</head>
<body style="background:#efefef;">
    <!--  后台管理 -->
    <div class="index">
       <?php echo $this->display('header'); ?>
        <!--  右侧内容 -->
        <article>
            <!--  标题 -->
            <?php echo $this->display('top'); ?>
            <!--  标题 -->
            <!--  信息列表 -->
            <div class="infoList">
                <a href="" class="newOrders">
                    <div class="listL">
                        <img src="./static/style_default/image/indexPic_10.png" alt=""/>
                    </div>
                    <div class="listR">
                        <span><?php echo $a_view_data['order']?></span><br/>
                        <dfn>总订单</dfn>
                    </div>
                </a>
                <a href="" class="newUser">
                    <div class="listL">
                        <img src="./static/style_default/image/indexPic_12.png" alt=""/>
                    </div>
                    <div class="listR">
                        <span><?php echo $a_view_data['user']?></span><br/>
                        <dfn>总用户</dfn>
                    </div>
                </a>
                <a href="" class="newStore">
                    <div class="listL">
                        <img src="./static/style_default/image/indexPic_14.png" alt=""/>
                    </div>
                    <div class="listR">
                        <span><?php echo $a_view_data['store']?></span><br/>
                        <dfn>总门店</dfn>
                    </div>
                </a>
                <a href="" class="newShopkeeper">
                    <div class="listL">
                        <img src="./static/style_default/image/indexPic_16.png" alt=""/>
                    </div>
                    <div class="listR">
                        <span><?php echo $a_view_data['shopman']?></span><br/>
                        <dfn>总店主</dfn>
                    </div>
                </a>
            </div>
            <!--  信息列表 -->
            <!-- 经营概况 -->
            <div class="operate">
                <h3>经营概况</h3>
                <div class="operateContent">
                    <div class="operateLeft">
                        <p class="volume">
                            日销售额
                            <span><?php echo $a_view_data['daily_order'] ? $a_view_data['daily_order'] : 0 ?></span>
                        </p>
                        <p class="dailyOrders">
                            日订单数
                            <span><?php echo $a_view_data['daily_sales'] ? $a_view_data['daily_sales'] : 0 ?></span>
                        </p>
                        <p class="totalVolume">
                            总销售额
                            <span><?php echo $a_view_data['sales'] ? $a_view_data['sales'] : 0 ?></span>
                        </p>
                        <p class="totalOrders">
                            总订单数
                            <span><?php echo $a_view_data['order'] ? $a_view_data['order'] : 0 ?></span>
                        </p>
                    </div>

                    <!-- 宣传图 -->
                    <div class="advertisement">
                        <img src="./static/style_default/image/tubg.png" alt=""/>
                    </div>
                    <!-- 宣传图 -->
                </div>
            </div>
            <!-- 经营概况 -->
            <!--  最新动态 -->
            <div class="newDynamic">
                <h3>最新公告</h3>
                <ul class="dynamicContent">
                    <?php foreach ($a_view_data['notice'] as $notice) {?>
                    <li class="htitle" value="<?php echo $notice['notice_id']; ?>" id="<?php echo "tr_".$notice['notice_id']; ?>">
                      <!-- <img src="./static/style_default/image/in_61.png" alt=""/> -->
                      <div class="dynamicInfo">
                          <span><?php echo $notice['notice_title']?></span>
                          <p><?php
                            $subject = strip_tags($notice['notice_content']);//去除html标签
                            $pattern = '/\s/';//去除空白
                            $content = preg_replace($pattern, '', $subject);
                            $seodata = mb_substr($content, 0, 100);//截取100个汉字
                            echo $seodata;
                          ?></p>
                      </div>
                    </li>
                    <?php } ?>
                </ul>
                <div class="viewMore">
                    <a href="notice_showlist">查看更多<img src="./static/style_default/image/indexPic_64.png" alt=""/></a>
                </div>
            </div>
            <!--  最新动态 -->

            <!-- 月新增百分比 -->
            <div class="percentage">
                <h3>月新增百分比</h3>
                <div class="monthBox">
                    <a class="monthOrder">
                        <div id="processingbar" class="processingbar"><font><?php if ($a_view_data['yue']['accott'] <= $a_view_data['yue']['acco']) {
                                echo 0;
                            } else {
                                echo sprintf("%.2f", ($a_view_data['yue']['accott'] - $a_view_data['yue']['acco']) / $a_view_data['yue']['accott']) * 100;
                            }?>%</font></div>
                        <div class="monthData">
                            <span>月订单增长</span>
                            <p><?php if ($a_view_data['yue']['accott'] < $a_view_data['yue']['acco']) {
                                echo 0;
                            } else {
                                echo $a_view_data['yue']['accott'] - $a_view_data['yue']['acco'];
                            }?></p>
                        </div>
                        <div class="beforeData">
                            <dl>
                                <dd>
                                    <span>上个月：</span>
                                    <em><?php echo $a_view_data['yue']['acco']?></em>
                                </dd>
                                <dd>
                                    <span>本月个月：</span>
                                    <em><?php echo $a_view_data['yue']['accott']?></em>
                                </dd>
                            </dl>
                        </div>
                    </a>
                    <a class="monthStore">
                        <div id="processingbar2" class="processingbar"><font><?php if ($a_view_data['yue']['user'] >= $a_view_data['yue']['user_ben']) {
                                echo 0;
                            } else {
                                echo sprintf("%.2f", ($a_view_data['yue']['user_ben'] - $a_view_data['yue']['user']) / $a_view_data['yue']['user_ben']) * 100;
                            }?>%</font></div>
                        <div class="monthData">
                            <span>月用户增长</span>
                            <p><?php if ($a_view_data['yue']['user'] > $a_view_data['yue']['user_ben']) {
                                echo 0;
                            } else {
                                echo $a_view_data['yue']['user_ben'] - $a_view_data['yue']['user'];
                            }?></p>
                        </div>
                        <div class="beforeData">
                            <dl>
                                <dd>
                                    <span>上个月：</span>
                                    <em><?php echo $a_view_data['yue']['user'] ?></em>
                                </dd>
                                <dd>
                                    <span>本月个月：</span>
                                    <em><?php echo $a_view_data['yue']['user_ben'] ?></em>
                                </dd>
                            </dl>
                        </div>
                    </a>
                    <a class="monthStorer">
                        <div id="processingbar3" class="processingbar"><font><?php if ($a_view_data['yue']['store'] >= $a_view_data['yue']['stor_ben']) {
                                echo 0;
                            } else {
                                echo sprintf("%.2f", ($a_view_data['yue']['stor_ben'] - $a_view_data['yue']['store']) / $a_view_data['yue']['stor_ben']) * 100;
                            }?>%</font></div>
                        <div class="monthData">
                            <span>月门店增长</span>
                            <p><?php if ($a_view_data['yue']['store'] > $a_view_data['yue']['stor_ben']) {
                                echo 0;
                            } else {
                                echo $a_view_data['yue']['stor_ben'] - $a_view_data['yue']['store'];
                            }?></p>
                        </div>
                        <div class="beforeData">
                            <dl>
                                <dd>
                                    <span>上个月：</span>
                                    <em><?php echo $a_view_data['yue']['store'] ?></em>
                                </dd>
                                <dd>
                                    <span>本月个月：</span>
                                    <em><?php echo $a_view_data['yue']['stor_ben'] ?></em>
                                </dd>
                            </dl>
                        </div>
                    </a>
                    <a class="monthUser">
                        <div id="processingbar4" class="processingbar"><font><?php if ($a_view_data['yue']['shop'] >= $a_view_data['yue']['shop_ben']) {
                                echo 0;
                            } else {
                                echo sprintf("%.2f", ($a_view_data['yue']['shop_ben'] - $a_view_data['yue']['shop']) / $a_view_data['yue']['shop_ben']) * 100;
                            }?>%</font></div>
                        <div class="monthData">
                            <span>月店主增长</span>
                            <p><?php if ($a_view_data['yue']['shop'] > $a_view_data['yue']['shop_ben']) {
                                echo 0;
                            } else {
                                echo $a_view_data['yue']['shop_ben'] - $a_view_data['yue']['shop'];
                            }?></p>
                        </div>
                        <div class="beforeData">
                            <dl>
                                <dd>
                                    <span>上个月：</span>
                                    <em><?php echo $a_view_data['yue']['shop'] ?></em>
                                </dd>
                                <dd>
                                    <span>本月个月：</span>
                                    <em><?php echo $a_view_data['yue']['shop_ben'] ?></em>
                                </dd>
                            </dl>
                        </div>
                    </a>
                </div>
            </div>
            <!-- 月新增百分比 -->
        </article>
        <!--  右侧内容 -->
        
        	<!-- 显示信息层 -->
            <div class="showLay" style="display:none;">
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
        	
        	<div class="lay"></div>
    </div>
    <!--  后台管理 -->
</body>
</html>
<script>
// 单个删除
function notice_delete_one(notice_id) {
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
                }
            }
        })
        $('.showLay').hide();
        $('.tips').hide();
        $('.lay').hide();
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


</script>