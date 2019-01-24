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
    <link rel="stylesheet" href="static/style_default/style/orderShareList.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/orderShareList.js"></script>
    <title>订单列表</title>
</head>
<body>
<!-- 拉框开始 -->
<?php echo $this->display('head'); ?>
<!-- 拉框结束 -->
<!-- 订单列表 -->
<div class="orderShareList">
    <p class="pjoTitle">
        <a href="javascript:window.history.back();"><img src="static/style_default/images/lefB.png" /></a>
        <span>我的订单</span>
    </p>
    <!-- 导航 -->
    <div class="nav">
        <a <?php if ($a_view_data['type'] == 'all') { echo 'class="navCur"'; } ?> href="share_order-all"><span>全部</span></a>
        <a <?php if ($a_view_data['type'] == 40) { echo 'class="navCur"'; } ?> href="share_order-40"><span>待付款</span></a>
        <a <?php if ($a_view_data['type'] == 20) { echo 'class="navCur"'; } ?> href="share_order-20"><span>待接单</span></a>
        <a <?php if ($a_view_data['type'] == 25) { echo 'class="navCur"'; } ?> href="share_order-25"><span>待发货</span></a>
        <a <?php if ($a_view_data['type'] == 30) { echo 'class="navCur"'; } ?> href="share_order-30"><span>已发货</span></a>
    </div>
    <!-- 导航 -->

    <!-- 订单 -->
    <div class="orderContainer">
        <ul>
            <?php foreach ($a_view_data['order'] as $key => $value): ?>
                <li class="orederList" id="orli_<?php echo $value['order_id']; ?>">
                    <div class="myState">
                        <?php if (empty($value['user_pic'])) {
                            echo '<img src="static/style_default/images/tou_03.png" />';
                        } else {
                            echo '<img src="'.$value['user_pic'].'">';
                        } ?>
                        <span><?php echo $value['user_name']; ?></span>
                        <em id="stateem_<?php echo $value['order_id']; ?>">
                            <?php if ($value['order_state'] == 40) {
                                echo '待付款';
                            } else if ($value['order_state'] == 20) {
                                echo '待接单';
                            } else if ($value['order_state'] == 25) {
                                echo '待发货';
                            } else if ($value['order_state'] == 30) {
                                echo '已发货';
                            } else if ($value['order_state'] == 0) {
                                echo '已取消';
                            } else {
                                echo '已完成';
                            } ?>
                        </em>
                    </div>
                    <div class="myProduct" onclick="share_orderdetail(<?php echo $value['order_id']; ?>)">
                        <a>
                            <?php if (empty($value['pro_img'])) {
                                echo '<img src="static/style_default/images/bffg.png" />';
                            } else {
                                echo '<img src="'.$value['pro_img'].'">';
                            } ?>
                            <em class="productInfo">
                                <span>
                                    <?php echo $value['product_name'] ?>
                                    <?php if ($value['order_count'] > 1) { ?>
                                        等<em><?php echo $value['order_count']; ?></em>件商品
                                    <?php } ?>
                                </span>
                                <p><?php echo date('Y-m-d H:i', $value['time_create']); ?></p>
                                <em>¥<dfn><?php echo $value['goods_amount']; ?></dfn></em>
                            </em>
                        </a>
                    </div>
                    <div class="orderChoice">
                        <?php if ($value['order_state'] == 40) { ?>
                            <a class="cancelOrder" onclick="order_cancel(<?php echo $value['order_id']; ?>)">取消订单</a>
                        <?php } elseif ($value['order_state'] == 20) { ?>
                            <a class="cancelOrder" onclick="order_cancel(<?php echo $value['order_id']; ?>)">取消订单</a>
                            <a class="meet" onclick="share_orderacct(<?php echo $value['order_id']; ?>)">接单</a>
                        <?php } elseif ($value['order_state'] == 25) { ?>
                            <a class="cancelOrder" onclick="order_cancel(<?php echo $value['order_id']; ?>)">取消订单</a>
                            <a class="mail" href="share_delivery-<?php echo $value['order_id']; ?>">我已寄出</a>
                        <?php } else {  ?>
                            <a class="logistics" href="share_logistics-<?php echo $value['order_id']; ?>">查看物流</a>
                        <?php }  ?>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
    <!-- 订单 -->

    <p class="nothing" style="height:0.77rem; line-height:0.77rem; text-align:center; font-size:0.37rem; color:#666666; ">没有更多了</p>
</div>
<!-- 订单列表 -->

<!-- 遮罩层 -->
<div class="lay"></div>
<!-- 遮罩层 -->

<!-- 提示 -->
<div class="tips">
    <p>提示</p>
    <span>你确定要取消此订单吗？</span>
    <div class="tipsBtn">
        <a class="sure">确定</a>
        <a class="cancel">取消</a>
    </div>
</div>

<div class="tipsTNT">订单取消成功！</div>
<!-- 提示 -->

</body>
</html>

<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>

<script>

var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
// 取消订单
function order_cancel(order_id) {
    if (isAndroid || isiOS) {
        var callbackSuccess=function(json){
            // 发送ajax请求
            $.ajax({
                url: 'share_ordercancel',
                type: 'POST',
                dataType: 'json',
                data: {reason: json, order_id: order_id},
                success: function(res) {
                    console.log(res);
                    if (res.code == 200) {
                        $("#orli_"+order_id).children('.orderChoice').html('<a class="logistics" href="share_logistics-'+order_id+'">查看物流</a>');
                        $("#stateem_"+order_id).html('已取消');
                        setDivCenter($(".tipsTNT"));
                        $(".tipsTNT").stop().show(100).delay(3000).hide(100);
                        $(".tipsTNT").html("订单取消成功！");
                    }
                }
            })
        }
        //title 标题,list 原因动态列表
        var obj={"title":"请选择取消订单原因","list":["跟用户协商","用户拍错","信息填写错误","其它原因"]}
    }
    if (isAndroid) {
        showWheelViewReasonList(callbackSuccess,obj);
    } else if (isiOS) {
        obj = JSON.stringify(obj);
        window.webkit.messageHandlers.vdao.postMessage({
            body: obj,
            callback: callbackSuccess+'',
            command:'showWheelViewReasonList'
        });
    }
}

// 确定接单
function share_orderacct(order_id) {
    $(".lay").show();
    $(".tips span").html('你确定要接此订单吗？');
    $(".tips").show();
    $(".sure").click(function(event) {
        // 发送ajax请求
        $.ajax({
            url: 'share_orderacct',
            type: 'POST',
            dataType: 'json',
            data: {order_id: order_id},
            success: function(res) {
                console.log(res);
                if (res.code == 200) {
                    if (res.code == 200) {
                        $("#orli_"+order_id).children('.orderChoice').html('<a class="cancelOrder" onclick="order_cancel('+order_id+')">取消订单</a><a class="mail" href="share_delivery-'+order_id+'">我已寄出</a>');
                        $("#stateem_"+order_id).html('待发货');
                        setDivCenter($(".tipsTNT"));
                        $(".tipsTNT").stop().show(100).delay(3000).hide(100);
                        $(".tipsTNT").html("接单成功！");
                    }
                }
                $(".lay").hide();
                $(".tips").hide();
            }
        })
    });
}

function setDivCenter(divName){
    var top = ($(window).height() - divName.height())/2;
    var left = ($(window).width() - divName.width())/2;
    var scrollTop = $(document).scrollTop();
    //var scrollLeft = $(document).scrollLeft();
    divName.css( { 'top' : top + scrollTop});
}


// 获取更多订单
var page = 1;
var type = "<?php echo $a_view_data['type']; ?>";
var stop = true;
var recode = 200;
// 当滚动条滚到底时加载更多
$(window).scroll(function(){
    totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
    if($(document).height() <= totalheight){
        if (stop == true) {
            share_ordermore();
        }
        if (recode == 400) {
            stop = false;
        }
    }
});

function share_ordermore() {
    page++;
    $.ajax({
        url: 'share_ordermore',
        type: 'POST',
        dataType: 'json',
        data: {page: page, type: type},
        success: function(res) {
            console.log(res);
            recode = res.code;
            if (res.code == 200) {
                var append_content = '';
                $.each(res.data, function(index, el) {
                    append_content += '<li class="orederList" id="orli_'+el.order_id+'">';
                    append_content += '<div class="myState">';
                    if (el.user_pic == '') {
                        append_content += '<img src="static/style_default/images/tou_03.png" />';
                    } else {
                        append_content += '<img src="'+el.user_pic+'">';
                    }
                    append_content += '<span>'+el.user_name+'</span>';
                    append_content += '<em id="stateem_'+el.order_id+'">';
                    if (el.order_state == 40) {
                        append_content += '待付款';
                    } else if (el.order_state == 20) {
                        append_content += '待接单';
                    } else if (el.order_state == 25) {
                        append_content += '待发货';
                    } else if (el.order_state == 30) {
                        append_content += '已发货';
                    } else if (el.order_state == 0) {
                        append_content += '已取消';
                    } else {
                        append_content += '已完成';
                    }
                    append_content += '</em>';
                    append_content += '</div>';
                    append_content += '<div class="myProduct">';
                    append_content += '<a href="share_orderdetail-'+el.order_id+'">';
                    if (el.pro_img == '') {
                        append_content += '<img src="static/style_default/images/bffg.png" />';
                    } else {
                        append_content += '<img src="'+el.pro_img+'">';
                    }
                    append_content += '<em class="productInfo">';
                    append_content += '<span>'+el.product_name;
                    if (el.order_count > 1) {
                        append_content += '等<em>'+el.order_count+'</em>件商品';
                    }
                    append_content += '</span>';
                    append_content += '<p>'+el.time_create+'</p>';
                    append_content += '<em>¥<dfn>'+el.goods_amount+'</dfn></em>';
                    append_content += '</em>';
                    append_content += '</a>';
                    append_content += '</div>';
                    append_content += '<div class="orderChoice">';
                    if (el.order_state == 40) {
                        append_content += '<a class="cancelOrder" onclick="order_cancel('+el.order_id+')">取消订单</a>';
                    } else if (el.order_state == 20) {
                        append_content += '<a class="cancelOrder" onclick="order_cancel('+el.order_id+')">取消订单</a>';
                        append_content += '<a class="meet" onclick="share_orderacct('+el.order_id+')">接单</a>';
                    } else if (el.order_state == 25) {
                        append_content += '<a class="cancelOrder" onclick="order_cancel('+el.order_id+')">取消订单</a>';
                        append_content += '<a class="mail" href="share_delivery-'+el.order_id+'">我已寄出</a>';
                    } else {
                        append_content += '<a class="logistics" href="share_logistics-'+el.order_id+'">查看物流</a>';
                    }
                    append_content += '</div>';
                    append_content += '</li>';
                });
                $(".orderContainer ul").append(append_content);
            }
        }
    })
}

// 订单详情
function share_orderdetail(order_id) {
    window.location.href = "share_orderdetail-"+order_id;
}

</script>