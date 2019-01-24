<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>订单管理-咖啡订单</title>
		<link rel="stylesheet" href="static/style_default/style/common.css"/>
        <link rel="stylesheet" href="static/style_default/style/header.css"/>
        <link rel="stylesheet" href="static/style_default/style/seatOrder.css"/>
        <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="static/style_default/script/seatOrder.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<!-- 头部 开始-->
        <?php echo $this->display('top'); ?>
        <!-- 头部结束 -->
        <div class="bottom clearfix">
        	<!-- 导航 开始-->
	        <?php echo $this->display('left'); ?>
	        <!-- 导航结束-->
	        <!--右边内容开始-->
	        <div class="rightSide">
	        	<!--小导航开始-->
	        	<div class="smallNav">
	        		<i></i>
	        		<a href="javascript:;">订单管理/</a><a class="cur" href="javascript:;">座位订单</a>
	        	</div>
	        	<!--小导航结束-->
	        	<!--所有订单开始-->
	        	<div class="allOrder">
	        		<ul>
	        			<li class="allList <?php if ($a_view_data['state'] == 9) { echo 'current'; } ?>"><a href="appointment_order-2-9">所有订单</a></li>
	        			<li class="waitList <?php if ($a_view_data['state'] == 1) { echo 'current'; } ?>"><a href="appointment_order-2-1"><i class="dot"></i>待接单<i class="number"><?php echo $a_view_data['state_one']; ?></i></a></li>
	        			
	        			<li class="inCarry <?php if ($a_view_data['state'] == 3) { echo 'current'; } ?>"><a href="appointment_order-2-3"><i class="dot"></i>进行中<i class="number"><?php echo $a_view_data['state_three']; ?></i></a></li>
	        			<li class="hasFinish <?php if ($a_view_data['state'] == 5) { echo 'current'; } ?>"><a href="appointment_order-2-5"><i class="dot"></i>已完成<i class="number"><?php echo $a_view_data['state_five']; ?></i></a></li>
	        			<li class="hasCancel <?php if ($a_view_data['state'] == 6) { echo 'current'; } ?>"><a href="appointment_order-2-6">已取消</a></li>
	        		</ul>
	        	</div>
	        	<!--所有订单结束-->
				<!-- 查找单号 -->
				<div class="searchOrder">
					<form action="appointment_search" method="post">
						<input type="hidden" name="cate" value="<?php echo $a_view_data['cate']; ?>">
						<input type="hidden" name="search_office" value="all">
						<ul>
							<li class="orderNum">
								<input type="text" name="keywords" placeholder="订单编号/联系人/手机号" id="orderNum" <?php if ($a_view_data['type'] == 6 && $a_view_data['keywords'] != 9) { echo 'value="'.$a_view_data['keywords'].'"'; } ?> />
							</li>
							<li class="seatNum">
								<span>座位号</span>
								<input type="text" name="search_seat" placeholder="请输入座位号" id="seatNum" <?php if ($a_view_data['type'] == 6 && $a_view_data['search_seat'] != 'all') { echo 'value="'.$a_view_data['search_seat'].'"'; } ?> />
							</li>
							<li class="orderSub">
								<input type="submit" id="orderSub" value="查询"/>
							</li>
						</ul>
					</form>
				</div>
				<!-- 查找单号 -->
	        	<!--标题开始-->
	        	<div class="tabThead">
	        		<ul>
	        			<li>用户名</li>
						<li>入座时间</li>
	        			<li>金额</li>
	        			<li>联系方式</li>
	        			<li class="dealState">
	        				<a class="biaoti"><span class="jiao">订单状态</span><i class="downPic"></i></a>
	        				<div class="selectBox">
	        					<a href="appointment_order-2-1">待接单</a>
	        					<a href="appointment_order-2-3">进行中</a>
	        					<a href="appointment_order-2-4">已完成</a>
	        					<a href="appointment_order-2-5">已取消</a>
	        					<i class="bai"></i>
	        				</div>
	        			</li>
	        			<li>操作</li>
	        		</ul>
	        	</div>
	        	<!--标题结束-->
	        	<!--表格模块开始-->
	        	<div class="tableBox">
	        		<ul>
	        			<?php foreach ($a_view_data['order'] as $key => $value): ?>
	        			<li>
	        				<div class="title">
	        					<p class="time"><?php echo date('Y-m-d H:i:s', $value['appointment_time']); ?></p>
	        					<p class="orderNumber">订单编号:  <?php echo $value['appointment_number']; ?></p>
	        				</div>
	        				<div class="row">
	        					<span>
	        						<div class="userBox clearfix">
	        							<div class="imgL">
		                                <?php if (empty($value['user_pic'])) {
		                                    echo '<img src="static/style_default/images/yong_03.png" />';
		                                } else if(strpos($value['user_pic'], 'http') === false) {
		                                    echo '<img src="'.get_config_item('vdao_mobile').$value['user_pic'].'" />';
		                                } else {
		                                    echo '<img src="'.$value['user_pic'].'" />';
		                                } ?>
	        							</div>
	        							<div class="messageR">
											<p class="name"><?php echo $value['user_name']; ?></p>
											<p class="orderNum"><?php echo $value['office_seatname']; ?></p>
	        							</div>
	        						</div>
	        					</span>
	        					<span>
									<p class="userYear"><?php echo date('Y-m-d H:i', $value['begin_time']); ?></p>
									<p class="userTime"><?php echo date('Y-m-d H:i', $value['end_time']); ?></p>
	        					</span>
	        					<span>
	        						<p class="price">￥<?php echo $value['appointment_price']; ?></p>
	        					</span>
	        					<span style="text-align:center;">
	        						<p class="userName"><?php echo $value['linkman']; ?></p>
									<p class="userPhone"><?php echo $value['link_phone']; ?></p>
	        					</span>
	        					<span id="state_<?php echo $value['appointment_id']; ?>">
	        						<?php if ($value['appointment_state'] == 1) { ?>
	        							<p class="waitLis"><i></i><b>待接单</b></p>
	        						
	        						<?php } else if ($value['appointment_state'] == 3 || $value['appointment_state'] == 2) { ?>
	        							<p class="inCar"><i></i><b>进行中</b></p>
	        						<?php } else if ($value['appointment_state'] == 4 || $value['appointment_state'] == 5) { ?>
	        							<p class="hasFin"><i></i><b>已完成</b></p>
	        						<?php } else if ($value['appointment_state'] == 6) { ?>
	        							<p class="hasCan"><i></i><b>已取消</b></p>
	        						<?php } ?>
	        					</span>
	        					<span id="curl_<?php echo $value['appointment_id']; ?>">
	        						<?php if ($value['appointment_state'] == 1) { ?>
		        						<a href="javascript:;" class="getOrder" onclick="appointment_getorder(<?php echo $value['appointment_id']; ?>)">接单</a>
		        						<a href="javascript:;" class="cancel" onclick="appointment_cancel(<?php echo $value['appointment_id']; ?>)">取消</a>
	        					
	        						<?php } else if ($value['appointment_state'] == 3 || $value['appointment_state'] == 2) { ?>
		        						<a href="javascript:;" class="hadFinish" onclick="appointment_overser(<?php echo $value['appointment_id']; ?>)">已完成</a>
		        						
	        						<?php } ?>
	        					</span>
	        				</div>
	        			</li>
	        			<?php endforeach ?>
	        		</ul>
	        	</div>
	        	<!--表格模块结束-->
	        </div>
	        <!--分页开始-->
        	<div class="page">
        		<?php if ($a_view_data['type'] == 6) {
        			echo $this->pages->link_style_one($this->router->url('appointment_search-'.$a_view_data['cate'].'-'.$a_view_data['search_office'].'-'.$a_view_data['search_seat'].'-'.$a_view_data['keywords'].'-', [], false, false));
        		} else {
        			echo $this->pages->link_style_one($this->router->url('appointment_order-'.$a_view_data['cate'].'-'.$a_view_data['state'].'-', [], false, false));
        		} ?>
	            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        	</div>
        	<!--分页结束-->
	        <!--右边内容结束-->
	        <!--订单详情弹框开始-->
	        <div class="detailBomb">
	        	<div class="messageBox">
	        		<div class="numberBox">
	        			<p class="dingdan"><i></i>订单编号</p>
	        			<div class="cont">
	        				<p>201706013134</p>
	        			</div>
	        			<span class="shang"></span>
	        			<span class="xia"></span>
	        		</div>
	        		<div class="numberBox timeBox">
	        			<p class="dingdan"><i></i>下单时间/预约时间</p>
	        			<div class="cont">
	        				<p>2017-06-01 13:34/2017-06-01 13:34</p>
	        			</div>
	        			<span class="shang"></span>
	        			<span class="xia"></span>
	        		</div>
	        		<div class="numberBox takeBox">
	        			<p class="dingdan"><i></i>收货信息</p>
	        			<div class="cont">
	        				<p>联系人：李小姐</p>
	        				<p>联系电话：13556545556</p>
	        				<p>联系地址：长华创意谷D区16栋06号三楼</p>
	        			</div>
	        			<span class="shang"></span>
	        			<span class="xia"></span>
	        		</div>
	        		<div class="numberBox proBox">
	        			<p class="dingdan"><i></i>下单产品</p>
	        			<div class="cont">
	        				<ul>
	        					<li>
	        						<i class="wen1">招牌爽爽挝(大杯)</i>
	        						<i class="wen2">x1</i>
	        						<i class="wen3">¥16</i>
	        					</li>
	        					<li>
	        						<i class="wen1">招牌爽爽挝(大杯)</i>
	        						<i class="wen2">x1</i>
	        						<i class="wen3">¥16</i>
	        					</li>
	        					<li>
	        						<i class="wen1">招牌爽爽挝(大杯)</i>
	        						<i class="wen2">x1</i>
	        						<i class="wen3">¥16</i>
	        					</li>
	        					<li>
	        						<i class="wen1">招牌爽爽挝(大杯)</i>
	        						<i class="wen2">x1</i>
	        						<i class="wen3">¥16</i>
	        					</li>
	        					<li>
	        						<i class="wen1">招牌爽爽挝(大杯)</i>
	        						<i class="wen2">x1</i>
	        						<i class="wen3">¥16</i>
	        					</li>

	        				</ul>
	        				<p class="redPaper">
	        					<i class="red">红包优惠</i>
	        					<i class="money">-¥2</i>
	        				</p>
	        				<p class="redPaper carryM">
	        					<i class="red">配送费</i>
	        					<i class="money">¥25</i>
	        				</p>
	        			</div>
	        		</div>
	        	</div>
	        	<div class="payBox">
    				<span class="payType">微信支付</span>
    				<span class="allMon">¥110</span>
    			</div>
    			<div class="closeBox">
    				<a href="javascript:;">关闭窗口</a>
    			</div>
	        </div>
	        <!--订单详情弹框结束-->
	        <!--取消订单提示弹框开始-->
	        <div class="delePart cancelBomb">
	        	<a href="javascript:;" class="close"></a>
	        	<p>重要提示</p>
	        	<p>*确定要取消订单吗？</p>
	        	<div class="reasonBox">
	        		<p class="ding">*订单取消原因：</p>
	        		<div class="reasonSel">
	        			<a href="javascript:;" class="choose"><span class="cho"></span><i class="down"></i></a>
	        			<div class="select">
	        				<ul>
	        					<li><label><input type="radio" name="check" class="rad"/><span class="rea">跟用户协商</span></label></li>
	        					<li><label><input type="radio" name="check" class="rad"/><span class="rea">房间故障</span></label></li>
	        					<li><label><input type="radio" name="check" class="rad"/><span class="rea">用户拍错了</span></label></li>
	        					<li><label><input type="radio" name="check" class="rad"/><span class="rea">信息填写错误</span></label></li>
	        					<li><label><input type="radio" name="check" class="rad"/><span class="rea">其他</span></label></li>
	        				</ul>
	        			</div>
	        		</div>
	        	</div>
	        	<p class="remark"><span>*备注：</span><input type="text" class="txt"/></p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">再看看</a>
	        	</div>
	        </div>
	        <!--取消订单提示弹框结束-->

	</body>
</html>

<script>

// 取消订单
function appointment_cancel(appointment_id) {
	$('.cancelBomb').show();
	var cancel_reason = $('.choose .cho').text();
	$('.cancelBomb .sure').click(function(event) {
		$.ajax({
			url: 'appointment_cancel',
			type: 'POST',
			dataType: 'json',
			data: {appointment_id: appointment_id, cancel_reason: cancel_reason, cate: 2},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					alert(res.msg);
					$("#state_"+appointment_id).html('<p class="hasCan"><i></i><b>已取消</b></p>');
					$("#curl_"+appointment_id).html('');
					// 更新上方各状态下的订单总数
					$(".waitList .number").html(res.data.state_one);
					$(".waitCarry .number").html(res.data.state_two);
					$(".inCarry .number").html(res.data.state_three);
					$(".hasFinish .number").html(res.data.state_five);
				}else if (res.code == 400) {
					alert(res.msg);
				}
			}
		})
		$('.cancelBomb').hide();
	});
}

$('.cancelBomb .think,.close').click(function(event) {
	$('.cancelBomb').hide();
});


// 接单
function appointment_getorder(appointment_id) {
	$.ajax({
		url: 'appointment_getorder',
		type: 'POST',
		dataType: 'json',
		data: {appointment_id: appointment_id, cate: 2},
		success: function(res) {
			alert(res.msg);
			if (res.code == 200) {
				
				$("#state_"+appointment_id).html('<p class="waitCar"><i></i><b>进行中</b></p>');
				$("#curl_"+appointment_id).html('<a href="javascript:;" class="carry" onclick="appointment_overser('+appointment_id+')">已完成</a><a href="javascript:;" class="cancel" onclick="appointment_cancel('+appointment_id+')">取消</a>');
				// 更新上方各状态下的订单总数
				$(".waitList .number").html(res.data.state_one);
				$(".waitCarry .number").html(res.data.state_two);
				$(".inCarry .number").html(res.data.state_three);
				$(".hasFinish .number").html(res.data.state_five);
			}
		}
	})
}

// 开始服务
function appointment_beginser(appointment_id) {
	$.ajax({
		url: 'appointment_beginser',
		type: 'POST',
		dataType: 'json',
		data: {appointment_id: appointment_id, cate: 2},
		success: function(res) {
			console.log(res);
			if (res.code == 200) {
				$("#state_"+appointment_id).html('<p class="inCar"><i></i><b>服务中</b></p>');
				$("#curl_"+appointment_id).html('<a href="javascript:;" class="hadFinish" onclick="appointment_overser('+appointment_id+')">服务结束</a>');
				// 更新上方各状态下的订单总数
				$(".waitList .number").html(res.data.state_one);
				$(".waitCarry .number").html(res.data.state_two);
				$(".inCarry .number").html(res.data.state_three);
				$(".hasFinish .number").html(res.data.state_five);
			}
		}
	})
}

// 服务结束
function appointment_overser(appointment_id) {
	$.ajax({
		url: 'appointment_overser',
		type: 'POST',
		dataType: 'json',
		data: {appointment_id: appointment_id, cate: 2},
		success: function(res) {
			console.log(res);
			if (res.code == 200) {
				$("#state_"+appointment_id).html('<p class="hasFin"><i></i><b>已完成</b></p>');
				$("#curl_"+appointment_id).html('');
				// 更新上方各状态下的订单总数
				$(".waitList .number").html(res.data.state_one);
				$(".waitCarry .number").html(res.data.state_two);
				$(".inCarry .number").html(res.data.state_three);
				$(".hasFinish .number").html(res.data.state_five);
			}
		}
	})
}

</script>



