<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>我的订单-咖啡订单-订单详情（已取消）</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/myOrder_coffee_details（waitPay）.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/myOrder_coffee_details（waitPay）.js" type="text/javascript"></script>
	</head>
	<body>
	    <!-- 拉框开始 -->
	    <?php echo $this->display('head'); ?>
	    <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="<?php echo $this->router->url('goods_order')?>"><img src="static/style_default/images/kefu_03.png"/></a><i>订单详情</i></header>
			<div class="stateBox">
				<?php if ($a_view_data['list'][0]['order_state'] == 0) {?>
					<!--已取消2开始-->
					<form action="shopping" method="post" id="form1">
					<div class="state clearfix hadCancel2">
					<input type="hidden" name="repurchase" id="repurchase" target="_blank" value="<?php echo $a_view_data['list'][0]['order_id']?>" >
						<p class="p1">
							<a href="order_tracking-<?php echo $this->router->get(1)?>">
								<span>已取消</span>
								<img style="width:0.21rem;" src="static/style_default/images/shezhi_03.png" alt=""/>
							</a>
						</p>
						<p class="p2">商家于<?php echo date('m-d H:i', $a_view_data['list'][0]['time_finnshed'])?>取消了订单</p>
						<p class="p3">
							<a href="refund-<?php echo $this->router->get(1)?>" class="refund">查看退款</a>
							<a href="javascript:;" class="conSeller zailai">再来一单</a>					
						</p>
						<input type="submit" name="argsubmit" value="" style="display: none;"/>
					</div>
					</form>
					<!--已取消2结束-->
				<?php } else if ($a_view_data['list'][0]['order_state'] == 1) {?>
					<!--已取消1开始-->
					<div class="state clearfix hadCancel1">
					<form action="shopping" method="post" id="form1">
						<input type="hidden" name="repurchase" id="repurchase" target="_blank" value="<?php echo $a_view_data['list'][0]['order_id']?>" >
						<p class="p1">
							<a href="order_tracking-<?php echo $this->router->get(1)?>">
								<span>已取消</span>
								<img style="width:0.21rem;" src="static/style_default/images/shezhi_03.png" alt=""/>
							</a>
						</p>
						<p class="p2">你于<?php echo date('m-d H:i', $a_view_data['list'][0]['time_finnshed'])?>取消了订单</p>
						<p class="p3">
							<a href="refund-<?php echo $this->router->get(1)?>" class="refund">查看退款</a>
							<a href="javascript:;" class="conSeller zailai">再来一单</a>					
						</p>
						<input type="submit" name="argsubmit" value="" style="display: none;"/>
					</form>
					</div>
					<!--已取消1结束-->
				<?php } else if ($a_view_data['list'][0]['order_state'] == 40) {?>
					<!--待付款开始-->
					<div class="state clearfix waitPay">
						<p class="p1">
							<a href="order_tracking-<?php echo $this->router->get(1)?>">
								<span>待付款</span>
								<img style="width:0.21rem;" src="static/style_default/images/shezhi_03.png" alt=""/>
							</a>							
						</p>
						<p class="p2">逾期未支付，订单将自动关闭</p>
						<p class="p3">
							<a href="javascript:;" class="delOrd" value="<?php echo $a_view_data['list'][0]['order_id']?>">取消订单</a>
							<a href="javascript:;" class="payTime">支付还剩(<span class="hour">00</span>:<span class="minute">00</span>:<span class="second">00</span>)</a>
						</p>
					</div>
					<!--待付款结束-->
				<?php } else if ($a_view_data['list'][0]['order_state'] == 20) {?>
					<!--待接单开始-->
					<div class="state clearfix waitOrder">
						<p class="p1">
							<a href="order_tracking-<?php echo $this->router->get(1)?>">
								<span>待接单</span>
								<img style="width:0.21rem;" src="static/style_default/images/shezhi_03.png" alt=""/>
							</a>						
						</p>
						<p class="p2">平均接单时间为<i>3分钟</i>&nbsp;请耐心等待</p>
						<p class="p3">
							<?php if (time()-$a_view_data['list'][0]['order_time'] > 600) {
									
								} else {?>
							<a href="javascript:;" class="delOrd" value="<?php echo $a_view_data['list'][0]['order_id']?>">取消订单</a>		
							<?php }?>
						</p>
					</div>
					<!--待接单结束-->
				<?php } else if ($a_view_data['list'][0]['order_state'] == 25) {?>
					<!--待配送开始-->
					<div class="state clearfix waitCarry">
						<p class="p1">待配送</p>
						<p class="p2">订单即将开始配送，请耐心等待</p>
						<p class="p3">
							<a href="tel:<?php echo $a_view_data['list'][0]['store_contact']?>" class="conSeller">联系商家</a><!--在href="tel:13800138000"里输入相应商家号码-->				
						</p>
					</div>
					待配送结束
				<?php } else if ($a_view_data['list'][0]['order_state'] == 30) {?>
					<!--配送中开始-->
					<div class="state clearfix inCarry">
						<p class="p1">
							<a href="order_tracking-<?php echo $this->router->get(1)?>">
								<span>配送中</span>
								<img style="width:0.21rem;" src="static/style_default/images/shezhi_03.png" alt=""/>
							</a>
						</p>
						<p class="p2">美食配送中，请注意接听配送员来电</p>
						<p class="p3">
							<a href="javascript:;" class="conSeller" value="<?php echo $a_view_data['list'][0]['order_id']?>">确定收货</a>					
						</p>
					</div>
					<!--配送中结束-->
				<?php } else if ($a_view_data['list'][0]['order_state'] == 10) {?>
					<!--待评价开始-->
					<div class="state clearfix waitAppraise">
						<p class="p1">
							<a href="order_tracking-<?php echo $this->router->get(1)?>">
								<span>待评价</span>
								<img style="width:0.21rem;" src="static/style_default/images/shezhi_03.png" alt=""/>
							</a>
						</p>
						<p class="p2">服务周到吗？期待你的满意</p>
						<p class="p3">
							<a href="<?php echo $this->router->url('order_evaluate', [$a_view_data['list'][0]['order_id']]);?>" class="conSeller">评价</a>					
						</p>
					</div>
					<!--待评价结束-->
				<?php } else if ($a_view_data['list'][0]['order_state'] == 80) {?>
					<!--已完成开始-->
					<div class="state clearfix hadFinish">
					<form action="shopping" method="post" id="form1">
						<input type="hidden" name="repurchase" id="repurchase" target="_blank" value="<?php echo $a_view_data['list'][0]['order_id']?>" >			
						<p class="p1">
							<a href="order_tracking-<?php echo $this->router->get(1)?>">
								<span>已完成</span>
								<img style="width:0.21rem;" src="static/style_default/images/shezhi_03.png" alt=""/>
							</a>
						</p>
						<p class="p2">感谢你的信任，期待再次光临</p>
						<p class="p3">
							<a href="javascript:;" class="conSeller zailai">再来一单</a>					
						</p>
						<input type="submit" name="argsubmit" value="" style="display: none;"/>
					</form>
					</div>
					<!--已完成结束-->
				<?php }?>			
			</div>
			<div class="name">
				<ul>
					<!--标题开始-->
					<li class="tit">
						<img class="pic" src="static/style_default/images/dingdan_03.png"/>
						<span class="span1"><?php if (empty($a_view_data['list'][0]['store_name'])) {
							
						} else { ?>
						<a href="store_detail-<?php echo $a_view_data['list'][0]['store_id']?>">
							<?php echo $a_view_data['list'][0]['store_name']?>			
						</a>
						<?php }?>
						</span>
						<img class="pic2" src="static/style_default/images/shezhi_03.png"/>
					</li>
					<!--标题结束-->
					<!--咖啡类型开始-->
					<?php foreach ($a_view_data['list'] as $list) {?>
					<li class="roomLi">
						<div class="roomWrap clearfix">
							<div class="rLeft">
								<p class="pName"><?php echo $list['product_name']?></p>
							    <p class="pDes"><?php echo $list['spec']?></p>
							</div>						
							<p class="rLeft2">x<?php echo $list['goods_num']?></p>
							<p class="rRight">¥<?php echo $list['money']?></p>
						</div>						
					</li>
					<?php }?>
					<!--咖啡类型结束-->
					<!--配送费开始-->
					<li class="carryMoney">
						<div class="roomWrap clearfix">
							<div class="rLeft">
								<p class="pName">配送费</p>							 
							</div>													
							<p class="rRight">¥<?php echo $a_view_data['list'][0]['shipping_fee']?></p>
						</div>						
					</li>
					<!--配送费结束-->
					<!--积分抵用开始-->
					<li class="carryMoney">
						<div class="roomWrap clearfix">
							<div class="rLeft">
								<p class="pName"><i class="jifen">积</i>积分抵用（1积分=1元）</p>							 
							</div>													
							<p class="rRight"><?php if ($a_view_data['list'][0]['use_jife'] == 0) {
								echo 0;
							} else{ echo $a_view_data['list'][0]['use_jife'];}?></p>
						</div>						
					</li>
					<!--积分抵用结束-->
				</ul>
				<!--实付开始-->
				<div class="allPay">实付 <i>¥<?php echo $a_view_data['list'][0]['actual_pay']?></i></div>
				<!--实付结束-->
			</div>
			<div class="details">
				<ul>
					<li class="clearfix">
						<span class="spanL">订单号</span>
						<span class="spanR"><i class="i1" id="myordernumber"><?php echo $a_view_data['list'][0]['order_number']?></i><i class="i2">|</i><a class="copy" id="" href="javascript:;" onclick="copyUrl2();">复制</a></span>
					</li>
					<li class="clearfix">
						<span class="spanL">支付方式</span>
						<span class="spanR"><?php if($a_view_data['list'][0]['payment_code'] == 'offline') {
							 	echo '微信付款';
							} else if ($a_view_data['list'][0]['payment_code'] == 'online') {
								echo '余额支付';
							} else if ($a_view_data['list'][0]['payment_code'] == 'alipay') {
								echo '支付宝支付';
							} else if ($a_view_data['list'][0]['payment_code'] == 'unionpay') {
								echo '银行卡支付';
							}?></span>
					</li>
					<li class="clearfix">
						<span class="spanL">预约时间</span>
						<span class="spanR"><?php echo $a_view_data['list'][0]['time_delay']?></span>
					</li>
					<li class="clearfix">
						<span class="spanL">下单时间</span>
						<span class="spanR"><?php echo date('Y-m-d H:i', $a_view_data['list'][0]['time_create'])?></span>
					</li>
					<li class="clearfix">
						<span class="spanL">联系方式</span>
						<span class="spanR"><?php echo $a_view_data['list'][0]['addres']?><br><?php echo $a_view_data['list'][0]['reciver_name']?> <?php echo $a_view_data['list'][0]['mob_phone']?></span>
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
		<!--确定收货弹框开始-->
		<div class="qqBomb sureBomb">
			<p class="p1">确认收到货了吗？</p>			
			<p class="btnBox">
				<a href="javascript:;" class="cancel">取消</a>
				<a href="javascript:;" class="remove sure">确认</a>
			</p>
		</div>
		<!--确定收货弹框开始-->
	</body>
</html>
<script>
function copyUrl2(){
	var Url2=document.getElementById("myordernumber").innerText;
	var oInput = document.createElement('input');
	oInput.value = Url2;
	document.body.appendChild(oInput);
	oInput.select(); // 选择对象
	document.execCommand("Copy"); // 执行浏览器复制命令
	oInput.className = 'oInput';
	oInput.style.display='none';
	alert('复制成功');
}

</script>