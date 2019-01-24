<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>外卖-订单列表</title>
		<link rel="stylesheet" href="static/default/style/common.css"/>
		<link rel="stylesheet" href="static/default/style/orderList.css"/>
		<script src="static/default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/default/script/common.js" type="text/javascript"></script>
		<script src="static/default/script/orderList.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="main">
			<!--左边导航开始-->
			<?php $this->view->display('menu_system');?>
			<!--左边导航结束-->	
			<!--中间模块开始-->
			<div class="middle">
				<!-- 订单导航 -->
				<div class="orderNav">
					<a class="navCur" href="order_list.html">线下订单</a>
					<a class="" href="order_online---50.html">线上订单</a>
					<a class="" href="order_new.html">附近订单</a>
					<a class="" href="book_order_list.html">订座订单</a>
				</div>
				<!-- 订单导航 -->

				<div class="orderBox">
					<!--  线下订单 -->
					<div class="offline orderContent">
						<!-- 查询 -->
						<div class="orderForm">
							<form action="order_list" method="post">
								<input type="text" id="order_B" placeholder="请输入订单编号" name="number" />
								<input type="submit" id="subB" value="查询"/>
							</form>
						</div>
						<!-- 查询 -->
	<!-- 线上支付金额 -->
						<div class="moneyBox" style="color:#b91717;">
							<p>积分抵扣</p>
							<span><?php echo $a_view_data['use_jife']?></span>
						</div>
						<!-- 线上支付金额 -->						
						<!-- 线上支付金额 -->
						<div class="moneyBox" style="color:#b91717;">
							<p>线上收款</p>
							<span><?php echo $a_view_data['online_money']?></span>
						</div>
						<!-- 线上支付金额 -->						
						<!-- 钱箱金额 -->
						<div class="moneyBox">
							<p>现金收款</p>
							<span><?php echo $a_view_data['money']?></span>
						</div>
						<!-- 钱箱金额 -->
											
						<!-- 列表 -->
						<div class="orderContainer">
							<dl>
								<dt class="orderTitle">
								<ul>
									<li style="text-align:left;"><span>所有订单</span></li>
									<li><span>实付款</span></li>
									<li>
										<span><?php if ($a_view_data['code'] == 0) {
												echo "支付方式";
											} else if ($a_view_data['code'] == 'offline') {
												echo "微信付款";
											} else if ($a_view_data['code'] == 'alipay') {
												echo "支付宝";
											} else if ($a_view_data['code'] == 'cashier') {
												echo "现金支付";
											}?></span>
										<img src="static/default/images/heisan_06.png" alt=""/>
										<div class="modeContainer">
											<a href="<?php echo $this->router->url('order_list', [$a_view_data['number'], 'code' => 0, $a_view_data['state']]);?>">全部方式</a>
											<a href="<?php echo $this->router->url('order_list', [$a_view_data['number'], 'code' => 'offline', $a_view_data['state']]);?>">微信支付</a>
											<a href="<?php echo $this->router->url('order_list', [$a_view_data['number'], 'code' => 'alipay', $a_view_data['state']]);?>">支付宝支付</a>
											<a href="<?php echo $this->router->url('order_list', [$a_view_data['number'], 'code' => 'cashier', $a_view_data['state']]);?>">现金支付</a>
										</div>
									</li>
									<li><span>订单进度</span></li>
									<li>
										<span><?php if ($a_view_data['state'] == 0) { echo "交易状态";} else if ($a_view_data['state'] == 20) {echo "已付款";} else if ($a_view_data['state'] == 10) {echo "已完成";} else if ($a_view_data['state'] == 55) {echo "已取消";}?></span>
										<img src="static/default/images/heisan_06.png" alt=""/>
										<div class="dealContainer">
											<a href="<?php echo $this->router->url('order_list', [$a_view_data['number'], $a_view_data['code'], 'state' => 0]);?>">交易状态</a>
											<a href="<?php echo $this->router->url('order_list', [$a_view_data['number'], $a_view_data['code'], 'state' => 20]);?>">已付款</a>
											<a href="<?php echo $this->router->url('order_list', [$a_view_data['number'], $a_view_data['code'], 'state' => 10]);?>">已完成</a>
											<a href="<?php echo $this->router->url('order_list', [$a_view_data['number'], $a_view_data['code'], 'state' => 55]);?>">已取消</a>
										</div>
									</li>
									<li><span>操作</span></li>
								</ul>
								</dt>
								<?php foreach ($a_view_data['oret']['order'] as $a_order) {?>
								<dd>
									<div class="orderNum">
										<span><?php echo date('Y-m-d H:i', $a_order['order_time']);?></span>
										<em>
											<span>订单编号: </span>
											<span><?php echo $a_order['order_number'];?></span>
										</em>
									</div>
									<ul>
										<li>
											<?php if (empty($a_order['user_pic'])) {
			                                    echo '<img src="static/default/images/yong_03.png" />';
			                                } else if(strpos($a_order['user_pic'], 'http') === false) {
			                                    echo '<img src="'.$a_order['user_pic'].'" />';
			                                } else {
			                                    echo '<img src="'.$a_order['user_pic'].'" />';
			                                } ?>
											<div class="userInfo">
												<span><?php if (empty($a_order['reciver_name'])) {
													echo "咖菲猫";
												} else{ echo $a_order['reciver_name'];}?></span>
												<p><?php echo $a_order['product_info'];?><span>共<?php echo $a_order['order_count'];?>件产品</span></p>
											</div>
										</li>
										<li>
											<p>¥<?php echo $a_order['order_price'];?></p>
										</li>
										<li>
											<span><?php if ($a_order['payment_code'] == 'offline') {
												echo "微信付款";
											} else if ($a_order['payment_code'] == 'alipay') {
												echo "支付宝";
											} else if ($a_order['payment_code'] == 'cashier') {
												echo "在线支付";
											}?></span>
										</li>
										<?php if ($a_order['order_state'] == 10) {?>
										<li>
											<div class="bigBar5 li_<?php echo $a_order['order_id'];?>">
												<div class="smallBar"></div>
												<div class="state"><s>已完成</s><i class="sijiao"></i></div>
											</div>
											<div class="character">
												<i class="pai">拍下</i>
												<i class="wan">完成</i>
											</div>
										</li>
										<li class="lt_<?php echo $a_order['order_id'];?>">
											<p class="comShow">
												<i></i>
												<span>已完成</span>
											</p>
											<a class="orderDetail" onclick="show_detail('<?php echo $a_order['order_id'];?>')">订单详情</a>
										</li>
										<li id="li_<?php echo $a_order['order_id'];?>">
											<a onclick="dayi(<?php echo $a_order['order_id'];?>)">重新打单</a>
										</li>
										<?php } else if($a_order['order_state'] == 0) {?>
										<li>
											<div class="bigBar6">
												<div class="smallBar"></div>
												<div class="state"><s>已取消</s><i class="sijiao"></i></div>
											</div>
											<div class="character">
												<i class="pai">拍下</i>
												<i class="wan">完成</i>
											</div>
										</li>
										<li>
											<p class="cancelShow">
												<i></i>
												<span>已取消</span>
											</p>
											<a class="orderDetail" onclick="show_detail('<?php echo $a_order['order_id'];?>')">订单详情</a>
										</li>
										<li>

										</li>
										<?php }?>
									</ul>
								</dd>
								<?php }?>
							</dl>
						</div>
						<!-- 列表 -->
					</div>
					<!--  线下订单 -->
				</div>

				<!--分页开始-->
	        	<div class="page">
	        		<?php echo $this->pages->link_style_one($this->router->url('order_list-'.$a_view_data['number'].'-'.$a_view_data['code'].'-'.$a_view_data['state'].'-', [], false, false));?>
		            <span style="background:none">共计<em> <?php echo $a_view_data['oret']['total']?> </em>条数据</span>
	        	</div>
	        	<!--分页结束-->
			</div>
			<!--中间模块结束-->
		</div>	
		<!--订单详情弹框开始-->
        <div class="detailBomb">
        </div>
        <!--订单详情弹框结束-->
        <!--  重要提示 -->
		<div class="tips">
			<input type="text" class="i1">
			<em>重要提示</em>
			<img src="images/close_03.png" alt=""/>
			<div style="position:relative ">
				<span>▪ 确定要取消订单？</span>
				<span class="resContainer">
					<em>▪ 订单取消原因:</em>
					<a>
						<span class="name">其他</span>
						<img src="images/heisan_06.png" alt=""/>
					</a>
					<div class="reasonBox">
						<a class="resCur">
							<img src="images/Radio.png" alt=""/>
							<span>跟用户协商</span>
						</a>
						<a>
							<img src="images/radio_shape.png" alt=""/>
							<span>商品缺货</span>
						</a>
						<a>
							<img src="images/radio_shape.png" alt=""/>
							<span>拍错了</span>
						</a>
						<a>
							<img src="images/radio_shape.png" alt=""/>
							<span>信息填写有误</span>
						</a>
						<a>
							<img src="images/radio_shape.png" alt=""/>
							<span>其他</span>
						</a>
					</div>
				</span>
			</div>
			<div class="tipsBtn">
				<em>确定</em>
				<a>再看看</a>
			</div>
		</div>
		<!--  重要提示 -->

		<!-- 遮罩层 -->
		<div class="lay"></div>
		<!-- 遮罩层 -->
		
	<!--	<input type="text" id="ss"  value="hjg"/>-->
	</body>
</html>
<script>
// 订单详情
function show_detail(oid) {
	$.ajax({
		url: "<?php echo $this->router->url('order_detail');?>",
		type: "post",
		data: "order_id=" + oid,
		dataType: "text",
		success: function(result) {
			$(".detailBomb").html(result);
		},
		error:function(msg){
			//alert('');
		}
	});
};
// 重新打印
function dayi(oid) {
	$.ajax({
		url: "<?php echo $this->router->url('order_reprint');?>",
		type: "post",
		data: "order_id=" + oid,
		dataType: "json",
		success: function(result) {
			if (result.result == 'success') {
				// 小票打印
				if (is_func('printTextBySmallPaperMoneyMachine')) {
					printTextBySmallPaperMoneyMachine(result);
				}
				// 不干胶打印
				if (is_func('printTextBySmallPaperMoneyMachine')) {
					printContextByThermosensitiveDryGlueMachine(result);
				}
			}
		},
		error:function(msg){
			alert('系统错误!');
		}
	});
}
// 验证函数存在后调用
function is_func(func) {
	try	{ 
		if(typeof(eval(func))=="function") {
			return true;
		}
	} catch(e) {
		return false; 
	}
}
//取消订单
var id1;
$(".cancelOrder").click(function(){
    $(".tips").show();
    $(".lay").show();  
    id1 = $(this).attr("value"); 
});
//确定
$(".tipsBtn>em").click(function(){
    $(".tips").hide();
    $(".lay").hide();
    $(".resContainer>a").removeClass("resShow");
    $(".reasonBox").hide();
    var name = $(".name").text();     
    $.ajax({
        url: "<?php echo $this->router->url('order_cancel')?>",
        type: "post",
        data: "order_id=" + id1 + "&reason=" + name + "&ster=" + 2,
        dataType: "json",
        success: function(result) {        	
        	console.log(result);
            if (result.result == 'success') {
                if (result.qianxia == 'qianxia') {
                	//打开钱箱
                   openCashBoxMachine();
                };
                $('.li_'+id1).addClass('bigBar6');
            	$('.li_'+id1).html('<div class="smallBar"></div>'
									+'<div class="state" style="display: none;"><s>已取消</s><i class="sijiao"></i></div>');
            	$('.lt_'+id1).html('<p class="cancelShow">'
									+'<i></i>'
									+'<span>已取消</span>'
								+'</p>'
								+'<a class="orderDetail" onclick="show_detail('+id1+')">订单详情</a>');
            	$('#li_'+id1).html('');
                location.reload();
            } else {
                alert('取消订单失败!');
            }
        },
        error:function(msg){
            alert(msg);
        }
    });
});
</script>
<?php
// 调用安卓
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) {
?>
<script>
function show_vice_screen() {
	var txt={"url":"<?php echo $this->router->url('cart_list');?>"};
	loadViceScreenPageByUrl(txt);
}
</script>
<?php
}
?>