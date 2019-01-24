<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>我的订单-办公室订单-订单详情</title>
		<link href="./static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="./static/style_default/style/myOrder_office_details（waitOrder）.css" rel="stylesheet" type="text/css" />
		<script src="./static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="./static/style_default/script/myOrder_office_details（waitOrder）.js" type="text/javascript"></script>
	</head>
	<body>
	    <!-- 拉框开始 -->
	    <?php echo $this->display('head'); ?>
	    <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="javascript:window.history.back();"><img src="./static/style_default/images/kefu_03.png"/></a><i>订单详情</i></header>
			<div class="state clearfix">
				<?php if ($a_view_data['appointment_state'] == 0) { ?>
					<p class="p1">待付款</p>
					<p class="p2">逾期未支付订单将自动取消</p>
					<p class="p3">
					<a href="javascript:;" onclick="order_cancel(<?php echo $a_view_data['appointment_id'].','.$a_view_data['office_id']; ?>)">取消订单</a>
					<a class="overOffic" onclick="go_pay(<?php echo $a_view_data['appointment_id'] .','. $a_view_data['actual_pay']; ?>)">去付款</a>
					</p>
				<?php } else if ($a_view_data['appointment_state'] == 1) { ?>
					<p class="p1">待接单</p>
					<p class="p2">平均接单时间为<i>15-45分钟</i>&nbsp;请耐心等待</p>
					<p class="p3"><a href="javascript:;" onclick="order_cancel(<?php echo $a_view_data['appointment_id'].','.$a_view_data['office_id']; ?>)">取消订单</a></p>
				<?php } else if ($a_view_data['appointment_state'] == 2) { ?>
					<p class="p1">待入店</p>
					<p class="p2">您预约到店的时间为<i><?php echo $a_view_data['arrival_time']; ?></i>&nbsp;请及时前往</p>
					<p class="p3"><a href="javascript:;" onclick="order_cancel(<?php echo $a_view_data['appointment_id'].','.$a_view_data['office_id']; ?>)">取消订单</a></p>
				<?php } else if ($a_view_data['appointment_state'] == 3) { ?>
					<p class="p1">已入店</p>
					<p class="p2">订单开始了，期待您的满意</p>
					<p class="p3"><a class="overOffic" href="javascript:;" onclick="over_order(<?php echo $a_view_data['appointment_id']; ?>)" >结束办公</a></p>
				<?php } else if ($a_view_data['appointment_state'] == 4) { ?>
					<p class="p1">待评价</p>
					<p class="p2">服务周到吗，期待您的满意</p>
					<p class="p3"><a class="overOffic" href="appointment_comment-<?php echo $a_view_data['appointment_id']; ?>">评价</a></p>
				<?php } else if ($a_view_data['appointment_state'] == 5) { ?>
					<p class="p1">已评价</p>
					<p class="p2">感谢您的信任，期待再次光临</p>
					<p class="p3"><a class="overOffic" href="office_detail-<?php echo $a_view_data['office_id']; ?>">重新预约</a></p>
				<?php } else if ($a_view_data['appointment_state'] == 6 && $a_view_data['who_cancel']==1) { ?>
					<p class="p1">已取消</p>
					<p class="p2">您于<?php echo date('Y-m-d H:i:s',$a_view_data['cancel_time']); ?>取消了订单</p>
					<p class="p3"><a class="overOffic" href="office_detail-<?php echo $a_view_data['office_id']; ?>">重新预约</a></p>
				<?php } else if ($a_view_data['appointment_state'] == 6 && $a_view_data['who_cancel']==2) { ?>
					<p class="p1">已取消</p>
					<p class="p2">商家于<?php echo date('Y-m-d H:i:s', $a_view_data['cancel_time']); ?>取消了订单</p>
					<p class="p3"><a class="overOffic" href="office_detail-<?php echo $a_view_data['office_id']; ?>">重新预约</a></p>
				<?php } ?>
			</div>
			<div class="name">
				<ul>
					<li class="tit" onclick="store_detail(<?php echo $a_view_data['store_id']; ?>)">
						<img class="pic" src="./static/style_default/images/dingdan_03.png"/>
						<span class="span1"><?php echo $a_view_data['store_name']; ?></span>
						<img class="pic2" src="./static/style_default/images/shezhi_03.png"/>
					</li>
					<li class="roomLi clearfix" onclick="office_detail(<?php echo $a_view_data['office_id']; ?>)">
						<div class="rLeft">
							<p class="pName"><?php echo $a_view_data['room_name']; ?></p>
						    <p class="pDes"><?php echo $a_view_data['room_size']; ?>㎡ <?php echo $a_view_data['device']; ?> 可坐<?php echo $a_view_data['room_seat']; ?>人</p>
						</div>
						<p class="rRight"><?php echo $a_view_data['office_seatname']; ?></p>
					</li>
				</ul>
			</div>
			<div class="details">
				<ul>
					<li class="clearfix">
						<span class="spanL">订单号</span>
						<span class="spanR"><i class="i1" id="myordernumber"><?php echo $a_view_data['appointment_number']; ?></i><i class="i2">|</i><a class="copy" onclick="copyUrl2()">复制</a></span>
					</li>
					<li class="clearfix" style="display:none;">
						<span class="spanL">支付方式</span>
						<span class="spanR">微信支付</span>
					</li>
					<li class="clearfix">
						<span class="spanL">预约时间</span>
						<span class="spanR"><?php echo date('Y-m-d',$a_view_data['appointment_time']); ?>&nbsp;<?php echo $a_view_data['arrival_time']; ?></span>
					</li>
					<li class="clearfix">
						<span class="spanL">下单时间</span>
						<span class="spanR"><?php echo date('Y-m-d',$a_view_data['appointment_time']); ?>&nbsp;<?php echo date('H:i:s',$a_view_data['appointment_time']); ?></span>
					</li>
					<li class="clearfix">
						<span class="spanL">联系方式</span>
						<span class="spanR"><?php echo $a_view_data['linkman']; ?> <?php echo $a_view_data['link_phone']; ?></span>
					</li>
				</ul>

			</div>
		</div>

		<!--遮罩层开始-->
		<div class="shade"></div>
		<!--遮罩层结束-->
		<!--取消订单弹框开始-->
		<div class="qqBomb cancelBomb">
			<p class="p1">确定要取消此订单？</p>
			<p class="btnBox">
				<a href="javascript:;" class="cancel wait">再等会</a>
				<a href="javascript:;" class="remove">立即取消</a>
			</p>
		</div>
		<!--取消订单弹框结束-->
		<!--取消订单成功提示开始-->
		<div class="blackTips cancelTip">办公室订单取消成功</div>
		<!--取消订单成功提示结束-->
		<!--结束办公弹框开始-->
		<div class="qqBomb overBomb">
			<p class="p1">要结束此订单？</p>
			<p class="p2">结束后将需要离开办公室</p>
			<p class="btnBox">
				<a href="javascript:;" class="cancel wait">再等会</a>
				<a href="javascript:;" class="remove">立即结束</a>
			</p>
		</div>
		<!--结束办公弹框结束-->
		<!--取消订单成功提示开始-->
		<div class="blackTips overTip">办公室订单结束成功</div>
		<!--取消订单成功提示结束-->


		<!--支付弹框开始-->
		<form action="office_appoint3" method="post" id="zhifu">
		<div class="payment">
	        <dl>
	            <dt class="surplusTime">
	                <span>请在<em>30分00秒</em>内完成支付</span>
	                <img class="closeSurplus" src="static/style_default/images/y_03.png" alt=""/>
	            </dt>
	            <dd class="zhifubao payCur clickdd" value="1">
	                <img src="static/style_default/images/zhifubao_03.png" alt=""/>
	                <span>支付宝支付</span>
	                <i class="checkPay "><img src="static/style_default/images/dr_07.png" alt=""/></i>
	            </dd>
	            <dd class="weixin clickdd" value="2">
	                <img src="static/style_default/images/weChat_03.png" alt=""/>
	                <span>微信支付</span>
	                <i class="checkPay none"><img src="static/style_default/images/dr_07.png" alt=""/></i>
	            </dd>
	            <dd class="yinhangka clickdd" value="3">
	                <img src="static/style_default/images/y_07.png" alt=""/>
	                <span>银行卡支付</span>
	                <i class="checkPay none"><img src="static/style_default/images/dr_07.png" alt=""/></i>
	            </dd>
	            <dd class="surePay" id="zhi">
	                <a href="javascript:;">
	                    <span>继续支付<em>￥<i class="jiaqian"></i></em></span>
	                </a>
	            </dd>
	            <input type="hidden" name="come_source" value="<?php if ($a_view_data['appointment_type'] == 1) { echo 3; } else { echo 4; } ?>">
	            <input type="hidden" name="appointment_id" id="order_id">
	            <input name="pay_type" value="1" type="hidden" id="pay_type">
	        </dl>
	    </div>
	    </form>
		<!--支付弹框结束-->
		<script type="text/javascript">
			$('#zhi').click(function() {
				$('#zhifu').submit();
			})
		</script>

	</body>
</html>

<script>

// 取消订单
function order_cancel(appointment_id, office_id) {
	var thistime = "<?php echo date('Y-m-d H:i:s', time()); ?>";
	$('.shade').show();
	$('.cancelBomb').show();
	$('.cancelBomb .wait').unbind('click').click(function(){//再等会
		$('.shade').hide();
	    $('.cancelBomb').hide();
	})
	$('.cancelBomb .remove').unbind('click').click(function(){//立即取消
		// 发送ajax请求
		$.ajax({
			url: 'appointment_cancel',
			type: 'POST',
			dataType: 'json',
			data: {appointment_id: appointment_id},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					$(".state .p1").html('已取消');
					$(".state .p2").html('您于'+thistime+'取消了订单');
					$(".state .p3").html('<a class="overOffic" href="office_detail-'+office_id+'">重新预约</a>');
					$('.shade').hide();
				    $('.cancelBomb').hide();
				    $('.cancelTip').show();
				    setTimeout(function(){
				    	$('.cancelTip').hide();
				    },1100)
				}
			}
		})
	})
}

// 结束办公
function over_order(appointment_id) {
	$('.shade').show();
	$('.overBomb').show();
	$('.overBomb .wait').unbind('click').click(function(){//再等会
		$('.shade').hide();
	    $('.overBomb').hide();
	})
	$('.overBomb .remove').unbind('click').click(function(){//结束办公
		// 发送ajax请求
		$.ajax({
			url: 'appointment_over',
			type: 'POST',
			dataType: 'json',
			data: {appointment_id: appointment_id},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					$(".state .p1").html('待评价');
					$(".state .p2").html('服务周到吗，期待您的满意');
					$(".state .p3").html('<a class="overOffic" href="appointment_comment-'+appointment_id+'">评价</a>');
					$('.shade').hide();
				    $('.overBomb').hide();
				    $('.overTip').show();
				    setTimeout(function(){
				    	$('.overTip').hide();
				    },1100);
				}
			}
		})
	})
}

// 跳转门店详情
function store_detail(store_id) {
	window.location.href = "store_detail-"+store_id;
}

// 跳转办公室详情
function office_detail(office_id) {
	window.location.href = "office_detail-"+office_id;
}


function go_pay(appointment_id, actual_pay) {
	$('#order_id').val(appointment_id);
	$('.payment .surePay .jiaqian').text(actual_pay);//把价格放到弹窗
    $(".shade").show();
    $(".payment").slideDown(100);
    getTime();
}

$(".payment>dl>.clickdd").click(function(){
    $(this).addClass("payCur");
    var id = $(this).attr('value');
    $('#pay_type').val(id);
    $(".payment>dl>dd").not($(this)).removeClass("payCur");
    $(".payCur>i").show();
    $(".payment>dl>dd>i").not($(".payCur>i")).hide();
});

$(".closeSurplus").click(function(){
    $(".shade").hide();
    $(".payment").slideUp(100);
});

//30分钟倒计时
function getTime(){
    var x=30,t;
    var d = new Date("1111/1/1,0:" + x + ":0");
    t = setInterval(function() {
        var m = d.getMinutes();
        var s = d.getSeconds();
        m = m < 10 ? "0" + m : m;
        s = s < 10 ? "0" + s : s;
        $(".surplusTime>span>em").html(m + "分" + s+"秒");
        if (m == 0 && s == 0) {
            clearInterval(t);
            return;
        }
        d.setSeconds(s - 1);
    }, 1000);
}


function copyUrl2(){
    var Url2=document.getElementById("myordernumber").innerText;
    var oInput = document.createElement('input');
    oInput.value = Url2;
    document.body.appendChild(oInput);
    oInput.select(); // 选择对象
    document.execCommand("Copy"); // 执行浏览器复制命令
    oInput.className = 'oInput';
    oInput.style.display='none';
}


$(function(){
	var appointment_state = "<?php echo $a_view_data['appointment_state']; ?>";
	if (appointment_state == 0) {
    	var timer = window.setInterval("weixin_ispay()", 1000);
	}
})

function weixin_ispay(){
    var pay_type = $("input[name='pay_type']").val();
    if (pay_type == 2) {
        $.ajax({
            url: 'weixin_ispay_office',
            type: 'POST',
            dataType: 'json',
            data: {pay_type: pay_type},
            success: function(res) {
                console.log(res.code)
                if (res.code == 200) {
                    window.location.reload();
                }
            }
        })
    }
}


</script>