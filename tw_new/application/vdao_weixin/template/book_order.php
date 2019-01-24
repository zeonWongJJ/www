<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>点餐座位</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/seatOrder.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/seatOrder.js" type="text/javascript"></script>
		<script src="static/style_default/script/iscroll.js" type="text/javascript"></script>
		<script src="static/style_default/script/navbarscroll.js" type="text/javascript"></script>
	</head>
	<body>
        <!-- 拉框开始 -->
        <?php //echo $this->display('head'); ?>
        <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="user_center"><img src="static/style_default/images/dri_03.png"/></a><i>座位订单</i></header>
			<div class="wrapper wrapper01" id="retr">
				<div class="scroller">
					<ul class="clearfix">
						<li <?php if ($a_view_data['state'] == 9) { echo 'class="current"'; } ?>><a href="book_order-9">全部</a></li>
						<li <?php if ($a_view_data['state'] == 0) { echo 'class="current"'; } ?>><a href="book_order-0">待付款</a></li>
						<li <?php if ($a_view_data['state'] == 1) { echo 'class="current"'; } ?>><a href="book_order-1">待接单</a></li>
						<li <?php if ($a_view_data['state'] == 2) { echo 'class="current"'; } ?>><a href="book_order-2">待入店</a></li>
						<li <?php if ($a_view_data['state'] == 3) { echo 'class="current"'; } ?>><a href="book_order-3">已入店</a></li>
						<li <?php if ($a_view_data['state'] == 4) { echo 'class="current"'; } ?>><a href="book_order-4">待评价</a></li>
						<li <?php if ($a_view_data['state'] == 5) { echo 'class="current"'; } ?>><a href="book_order-5">已完成</a></li>
						<li <?php if ($a_view_data['state'] == 6) { echo 'class="current"'; } ?>><a href="book_order-6">已取消</a></li>
					</ul>
				</div>
			</div>
			<script type="text/javascript">
				$(function(){

					//demo示例一到四 通过lass调取，一句可以搞定，用于页面中可能有多个导航的情况
					$('.wrapper').navbarscroll();

					//demo示例五 通过id调取
					$('#demo05').navbarscroll({
						defaultSelect:6,
						endClickScroll:function(obj){
							console.log(obj.text())
						}
					});

					//demo示例六 通过id调取
					$('#demo06').navbarscroll({
						defaultSelect:3,
						scrollerWidth:6,
						fingerClick:1,
						endClickScroll:function(obj){
							console.log(obj.text())
						}
					});
				});
			</script>
			<div class="content">
				<ul>
					<?php foreach ($a_view_data['order'] as $key => $value): ?>
					<li>
						<div class="tit">
							<i class="pic"></i>
							<span class="span1"><?php echo $value['store_name']; ?></span>
							<span class="span2" id="state_<?php echo $value['appointment_id']; ?>">
							<?php if ($value['appointment_state'] == 0) {
								echo '待付款';
							} else if ($value['appointment_state'] == 1) {
								echo '待接单';
							} else if ($value['appointment_state'] == 2) {
								echo '待入店';
							} else if ($value['appointment_state'] == 3) {
								echo '已入店';
							} else if ($value['appointment_state'] == 4) {
								echo '待评价';
							} else if ($value['appointment_state'] == 5) {
								echo "已完成";
							} else if ($value['appointment_state'] == 6) {
								echo "已取消";
							} ?>
							</span>
						</div>
						<div class="describe" onclick="book_detail(<?php echo $value['appointment_id']; ?>)">
							<a href="javascript:;" class="clearfix">
								<div class="left">
								<?php if (!empty($value['store_touxiang'])) {
									echo '<img src="'.get_config_item('store_touxiang').$value['store_touxiang'].'"/>';
								} else {
									echo '<img src="./static/style_default/images/dingdan_07.png"/>';
								} ?>
								</div>
								<div class="right">
									<p>预约时间：<?php echo date('Y-m-d', $value['appointment_date']); ?>&nbsp;&nbsp;<?php echo $value['arrival_time']; ?></p>
									<p>预约信息：<?php echo $value['linkman']; ?>(<?php echo $value['link_phone']; ?>)</p>
									<p style="width:7rem; overflow:hidden; text-overflow:ellipsis; white-space: nowrap;">预约座位：<?php echo $value['room_name']; ?> - <?php echo $value['office_seatname']; ?></p>
									<p>金额：￥<?php echo $value['appointment_price']; ?></p>
								</div>
							</a>
						</div>
						<div class="control clearfix" id="ctrl_<?php echo $value['appointment_id']; ?>">
							<?php if ($value['appointment_state'] == 0) {
								echo '<a onclick="book_cancel('.$value['appointment_id'].')">取消订单</a>';
								echo '<a class="bookAgain" onclick="go_pay('.$value['appointment_id'].','.$value['actual_pay'].')">去付款</a>';
							} else if ($value['appointment_state'] == 1) {
								echo '<a onclick="book_cancel('.$value['appointment_id'].')">取消订单</a>';
							} else if ($value['appointment_state'] == 2) {
								echo '<a href="javascript:;" class="overStore" onclick="book_instore('.$value['appointment_id'].','.$value['store_id'].')">我已入店</a>';
							} else if ($value['appointment_state'] == 3) {
								echo '<a href="list_store-'.$value['store_id'].'" class="oredering">点餐</a>';
							} else if ($value['appointment_state'] == 4) {
								echo '<a class="appraise" href="appointment_comment-'.$value['appointment_id'].'">评价</a>';
							} else if ($value['appointment_state'] == 5) {
								echo '<a href="javascript:;" class="bookAgain" onclick="book_again('.$value['office_id'].')">再次预约</a>';
							} else if ($value['appointment_state'] == 6) {
								echo '<a href="javascript:;" class="bookAgain" onclick="book_again('.$value['office_id'].')">再次预约</a>';
							} ?>
						</div>
					</li>
					<?php endforeach ?>
				</ul>
			</div>
			<div class="noMore" style="display:none;">
				没有更多了
			</div>
		</div>
		<!--遮罩层开始-->
		<div class="shade"></div>
		<!--遮罩层结束-->
		<!--取消订单弹框开始-->
		<div class="qqBomb cancelBomb">
			<p class="p1">确定要取消此订单？</p>
			<p class="btnBox">
				<a href="javascript:;" class="cancel wait">再想想</a>
				<a href="javascript:;" class="remove">立即取消</a>
			</p>
		</div>
		<!--取消订单弹框结束-->
		<!--取消订单成功提示开始-->
		<div class="blackTips cancelTip">办公室订单取消成功</div>
		<!--取消订单成功提示结束-->
		<!--结束办公弹框开始-->
		<div class="qqBomb overBomb">
			<p class="p1">您已入店吗？</p>
			<p class="p2">入店后可开始点餐</p>
			<p class="btnBox">
				<a href="javascript:;" class="remove">确定</a>
				<a href="javascript:;" class="cancel wait">取消</a>
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
	            <input type="hidden" name="come_source" value="4">
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

// 已入店
function book_instore(appointment_id,store_id) {
	$('.shade').show();
	$('.overBomb').show();
	$('.overBomb .cancel').click(function(event) {
		$('.shade').hide();
		$('.overBomb').hide();
	});
	$('.overBomb .remove').click(function(event) {
		$.ajax({
			url: 'book_instore',
			type: 'POST',
			dataType: 'json',
			data: {appointment_id: appointment_id},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					$("#ctrl_"+appointment_id).html('<a href="list_store-'+store_id+'" class="oredering">点餐</a>');
					$("#state_"+appointment_id).html('待点餐');
				}
			}
		})
		$('.shade').hide();
		$('.overBomb').hide();
	});
}

// 取消订单
function book_cancel(appointment_id) {
	$('.shade').show();
	$('.cancelBomb').show();
	$('.cancelBomb .cancel').click(function(event) {
		$('.shade').hide();
		$('.cancelBomb').hide();
	});
	$('.cancelBomb .remove').click(function(event) {
		$.ajax({
			url: 'book_cancel',
			type: 'POST',
			dataType: 'json',
			data: {appointment_id: appointment_id},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					$("#ctrl_"+appointment_id).html('<a href="javascript:;" class="bookAgain">再次预约</a>');
					$("#state_"+appointment_id).html('已取消');
				}
			}
		})
		$('.shade').hide();
		$('.cancelBomb').hide();
	});
}

// 订座详情
function book_detail(appointment_id) {
	window.location.href = "appoint_detail-"+appointment_id;
}

function book_again(office_id) {
	<?php $_SESSION['appointment_type'] = 2;  ?>
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

$(function(){
    var timer = window.setInterval("weixin_ispay()", 1000);
    $(".main").height( $(document).height() );
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
                if (res.code == 200) {
                    window.location.reload();
                }
            }
        })
    }
}

</script>
