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
					<a class="" href="order_list.html">线下订单</a>
					<a id ="order_online" class="" href="order_online---50.html">线上订单</a>
					<a id = "order_new" class="" href="order_new.html">附近订单</a>
					<a id ="book_order_list" class="navCur "  href="book_order_list.html">订座订单</a>
					<a id ="appointment_order" class=" "  href="appointment_order.html">会议订单</a>
				</div>
				<!-- 订单导航 -->

				<div class="orderBox">
					<!--  线上订单 -->
					<div class="online orderContent">
						<!-- 查询 -->
						<div class="orderForm">
							<form action="book_order_list" method="post">
								<input type="text" id="order_B" placeholder="请输入订单编号" name="number" />
								<input type="submit" id="subB" value="查询"/>
							</form>
						</div>
						<!-- 查询 -->
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
											} else if ($a_view_data['code'] == 1) {
												echo "支付宝";
											} else if ($a_view_data['code'] == 2) {
												echo "微信";
											} else if ($a_view_data['code'] == 3) {
												echo "银联";
											}?></span>
										<img src="static/default/images/heisan_06.png" alt=""/>
										<div class="modeContainer">
											<a href="<?php echo $this->router->url('book_order_list', [$a_view_data['number'], 'code' => 0, $a_view_data['state']]);?>">全部方式</a>
											<a href="<?php echo $this->router->url('book_order_list', [$a_view_data['number'], 'code' => '2', $a_view_data['state']]);?>">微信支付</a>
											<a href="<?php echo $this->router->url('book_order_list', [$a_view_data['number'], 'code' => '1', $a_view_data['state']]);?>">支付宝</a>
											<a href="<?php echo $this->router->url('book_order_list', [$a_view_data['number'], 'code' => '3', $a_view_data['state']]);?>">银联支付</a>
											
										</div>
									</li>
									<li><span>订单进度</span></li>
									<li>
										<span>
									<?php  if ($a_view_data['state'] == 1) {
				        						echo "待接单";
				        					} else if($a_view_data['state'] == 0) {
				        						echo "订单状态";
				        					} else if ($a_view_data['state'] == 3) {
				        					echo "进行中";} else if ($a_view_data['state'] == 4) {
				        					echo "待评价";} else if ($a_view_data['state'] == 5) {
				        					echo "已完成";} else if ($a_view_data['state'] == 6) {
				        					echo "已取消";}?></span>
										<img src="static/default/images/heisan_06.png" alt=""/>
										<div class="dealContainer">
											<!-- <a href="<?php echo $this->router->url('book_order_list', [$a_view_data['number'], $a_view_data['code'], 'state' => 0]);?>">交易状态</a> -->
											<a href="<?php echo $this->router->url('book_order_list', [$a_view_data['number'], $a_view_data['code'], 'state' => 0]);?>">全部状态</a>
											<a href="<?php echo $this->router->url('book_order_list', [$a_view_data['number'], $a_view_data['code'], 'state' => 1]);?>">待接单</a>
											<a href="<?php echo $this->router->url('book_order_list', [$a_view_data['number'], $a_view_data['code'], 'state' => 3]);?>">进行中</a>
											<a href="<?php echo $this->router->url('book_order_list', [$a_view_data['number'], $a_view_data['code'], 'state' => 4]);?>">待评价</a>
											<a href="<?php echo $this->router->url('book_order_list', [$a_view_data['number'], $a_view_data['code'], 'state' => 5]);?>">已完成</a>
											<a href="<?php echo $this->router->url('book_order_list', [$a_view_data['number'], $a_view_data['code'], 'state' => 6]);?>">已取消</a>

										</div>
									</li>
									<li><span>操作</span></li>
								</ul>
								</dt>
								<?php foreach ($a_view_data['oret']['order'] as $a_order) {?>
								<dd>
									<div class="orderNum">
										
										<em>
											<span>订单编号: </span>
											<span><?php echo $a_order['appointment_number'];?></span>
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
												<p><span><?php echo $a_order['linkman'];?></span></p>
												<p><span>预约号码:<?php echo $a_order['link_phone'];?></span></p>
												<p><span>预约时间段:<?php echo $a_order['arrival_time'];?></span></p>
												<p><span>座位 - <?php echo $a_order['office_seatname'];?> </span></p>
											</div>
										</li>
										<li>
											<p>¥<?php echo $a_order['actual_pay'];?></p>
											<em>
												
											</em>
										</li>
										<li>
											<span><?php if ($a_order['pay_type'] == 2) {
												echo "微信付款";
											} else if ($a_order['pay_type'] == 1) {
												echo "支付宝";
											} else if ($a_order['pay_type'] == 3) {
												echo "银联支付";
											} ?></span>
										</li>
										<?php if ($a_order['appointment_state'] == 1) {?>
										<li id="xian_<?php echo $a_order['appointment_id'];?>">
											<div class="bigBar2">
												<div class="smallBar"></div>
												<div class="state"><s>已付款</s><i class="sijiao"></i></div>
											</div>									
											<div class="character">
												<i class="pai">拍下</i>
												<i class="wan">完成</i>
											</div>
										</li>
										<li id="stye_<?php echo $a_order['appointment_id'];?>">
											<p class="payShow">
												<i></i>
												<span>已付款</span>
											</p>
											
										</li>
										<li id="order_<?php echo $a_order['appointment_id'];?>">
											
											<span class="giveOrder" onclick="jiedan('<?php echo $a_order['appointment_id'];?>')">接单</span>
										
											<span class="cancelOrder" value="<?php echo $a_order['appointment_id'];?>">取消</span>
										</li>
										<?php } else if ($a_order['appointment_state'] == 3 || $a_order['appointment_state'] ==2 ) {?>
										<li class="xian_<?php echo $a_order['appointment_id'];?>">
											<div class="bigBar3">
												<div class="smallBar"></div>
												<div class="state"><s>进行中</s><i class="sijiao"></i></div>
											</div>
											<div class="character">
												<i class="pai">拍下</i>
												<i class="wan">完成</i>
											</div>
										</li>
										<li class="stye_<?php echo $a_order['appointment_id'];?>">
											<p class="sendShow">
												<i></i>
												<span>进行中</span>
											</p>
										
										</li>
										<li id="order_<?php echo $a_order['appointment_id'];?>">
											
											<span class="giveOrder" onclick="finishOrder(<?php echo $a_order['appointment_id'];?>)">结束订单</span>
										
										
										</li>									
										
										<?php } else if ($a_order['appointment_state'] == 6 ) {?>
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
											
										</li>
										<li>
											
										</li>
										<?php } else if ($a_order['appointment_state'] == 5 || $a_order['appointment_state'] == 4) {?>
										<li>
											<div class="bigBar5">
												<div class="smallBar"></div>
												<div class="state"><s>已完成</s><i class="sijiao"></i></div>
											</div>
											<div class="character">
												<i class="pai">拍下</i>
												<i class="wan">完成</i>
											</div>
										</li>
										<li>
											<p class="comShow">
												<i></i>
												<span>已完成</span>
											</p>
											<!---<a class="orderDetail" onclick="show_detail('<?php echo $a_order['order_id'];?>')">订单详情</a>-->
										</li>
										<li></li>
										<?php }?>
									</ul>
								</dd>
								<?php }?>
							</dl>
						</div>
						<!-- 列表 -->
					</div>
					<!--  线上订单 -->
				</div>

				<!--分页开始-->
	        	<div class="page">
	        		<?php echo $this->pages->link_style_one($this->router->url('book_order_list-'.$a_view_data['number'].'-'.$a_view_data['code'].'-'.$a_view_data['state'].'-', [], false, false));?>
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
							<span>座位已被占用</span>
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

$('.closeBox').on('click', function(event) {
	
	$('.messageBox').hide();
});

// 接单
function jiedan(oid) {
	$.ajax({
		url: "<?php echo $this->router->url('book_receive');?>",
		type: "post",
		data: "appointment_id=" + oid + "&appointment_type =2",
		dataType: "json",
		success: function(res) {
			
			if (res.code == 200) {
				window.location.reload();
				$('#xian_'+oid).html('<div class="bigBar3">'
												+'<div class="smallBar"></div>'
												+'<div class="state"><s>进行中</s><i class="sijiao"></i></div>'
											+'</div>'
											+'<div class="character">'
												+'<i class="pai">拍下</i>'
												+'<i class="wan">完成</i>'
											+'</div>');
				$('#xian_'+oid).addClass('xian_'+oid);
				$('#stye_'+oid).html('<p class="sendShow">'
												+'<i></i>'
												+'<span>进行中</span>'
											+'</p>'
											);
				$('#stye_'+oid).addClass('stye_'+oid);
				
				$('#order_'+oid).addClass('order_'+oid);
			} else {
				alert(res.msg);
			}
		},
		error:function(msg){
			alert('程序错误!');
		}
	});
}

//结束订单
function finishOrder(oid) {
	$.ajax({
		url: "<?php echo $this->router->url('finish_book_order');?>",
		type: "post",
		data: "appointment_id=" + oid,
		dataType: "json",
		success: function(res) {
			
			if (res.code == 200) {
				location.reload();
				
			} else {
				alert(res.msg);
			}
		},
		error:function(msg){
			alert('程序错误!');
		}
	});
}
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
			alert('');
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
        url: "<?php echo $this->router->url('book_cancel')?>",
        type: "post",
        data: "appointment_id=" + id1 + "&reason=" + name+"&appointment_type=2",
        dataType: "json",
        success: function(res) {
        	
            if (res.code == 200) {
                $('#xian_'+id1).addClass('bigBar6');
            	$('#xian_'+id1).html('<div class="smallBar"></div>'
									+'<div class="state" style="display: none;"><s>已取消</s><i class="sijiao"></i></div>');
            	$('#stye_'+id1).html('<p class="cancelShow">'
									+'<i></i>'
									+'<span>已取消</span>'
								+'</p>'
								);
            	$('#order_'+id1).html('');
                location.reload();
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