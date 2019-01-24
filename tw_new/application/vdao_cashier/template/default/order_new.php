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
					<a id = "order_new" class="navCur " href="order_new.html">附近订单</a>
					<a id ="book_order_list" class="" href="book_order_list.html">订座订单</a>
				</div>
				<!-- 订单导航 -->

				<div class="orderBox">
					<!--  附近订单 -->
					<span class="nearTitle">
						<ul>
							<li style="text-align:left;"><span>所有订单</span></li>
							<li><span>实付款</span></li>
							<li>
								<span><?php switch ($this->router->get(1)) {
											case '0':
												echo '支付方式';break;
											case '1':
												echo '线下支付'; break;
											case '2':
												echo '在线支付'; break;
											case '3':
												echo '支付宝支付'; break;
											case '4':
												echo '微信支付'; break;
											case '5':
												echo '银联支付'; break;
										};?></span>
								<img src="static/default/images/heisan_06.png" alt=""/>
								<div class="modeContainer">
									<a href="<?php echo $this->router->url('order_new',['code' => 0]);?>">全部方式</a>
									<a href="<?php echo $this->router->url('order_new',['code' => 4]);?>">微信支付</a>
									<a href="<?php echo $this->router->url('order_new',['code' => 3]);?>">支付宝支付</a>
									<a href="<?php echo $this->router->url('order_new',['code' => 5]);?>">银联支付</a>
									<a href="<?php echo $this->router->url('order_new',['code' => 2]);?>">在线支付</a>
								</div>
							</li>
							<li><span>预约时间</span></li>
							<li><span>距离</span></li>
							<li><span>订单详情</span></li>
							<li><span>操作</span></li>
						</ul>
					</span>
					<div class="nearby orderContent">
						<!-- 列表 -->
						<div class="orderContainer">
							<dl>	
								
							</dl>
						</div>
						<!-- 列表 -->
					</div>
					<!--  附近订单 -->
				</div>
				<input type="hidden" id="order" value="">
				<!--分页开始-->
	        	<div class="page">
		            
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
						<span>其他</span>
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
	</body>
</html>
<script>
 // var interval = window.setInterval(function(){$.ajax(weixuan)},1000);
//抢单
function qinadan(oid) {
	// window.clearInterval(interval );//停止
	$.ajax({
		url: "<?php echo $this->router->url('order_rob');?>",
		type: "post",
		data: "order_id="+oid,
		dataType: "json",
		success: function(result) {
			if (result.result == 'success') {
				$('.ster_'+oid).html('已抢单');
				$('.ster_'+oid).addClass('notOrder');
			} else {
				window.location.reload();			}
		},
		error:function(msg){
			alert('');
		}
	});
	// window.setInterval(function(){$.ajax(weixuan)},1000);
}
// 订单详情
function show_detail(oid) {
	window.clearInterval(interval );
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
//关键在这里，Ajax定时访问服务端，不断获取数据 ，这里是1秒请求一次。
var stre = '<?php echo $this->router->get(1)?>';
var page = '<?php echo $this->router->get(2)?>';
var weixuan = {
	type : 'post',
    url  : 'order_new_lise',
    data : {page:page,stre:stre},
    dataType:'json',
    success:function(res) {
	var id = $('#order').attr('value');
  
			html = '';
	        $.each(res.data.order, function(index, item){
	        	html += res.data[index].html;
				$('.orderContainer dl').html(html);					
	        })
	        $('.page').html(res.data.pages+'<span style="background:none">共计<em>'+res.data.i_total+'</em>条数据</span>');
			$('#order').val(res.id);
	
    }

}
window.setInterval(function(){$.ajax(weixuan)},2000);

</script>