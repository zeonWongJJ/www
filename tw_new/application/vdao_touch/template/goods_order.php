<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>餐饮订单</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/myOrder_coffee.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/myOrder_coffee.js" type="text/javascript"></script>
		<script src="static/style_default/script/iscroll.js" type="text/javascript"></script>
		<script src="static/style_default/script/navbarscroll.js" type="text/javascript"></script>
	</head>
	<body>
    <!-- 拉框开始 -->
    <?php //echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="user_center"><img src="static/style_default/images/dri_03.png"/></a><i>餐饮订单</i></header>
			<div class="wrapper wrapper01" id="retr">
				<div class="scroller">
					<ul class="clearfix">
						<li <?php if ($a_view_data['i_order'] == 0) {echo "class='oute'";}?>><a href="<?php echo $this->router->url('goods_order', ['i_order' => 0]); ?>">全部</a></li>
						<li <?php if ($a_view_data['i_order'] == 40) {echo "class='oute'";}?>><a href="<?php echo $this->router->url('goods_order', ['i_order' => 40]); ?>">待付款</a></li>
						<li <?php if ($a_view_data['i_order'] == 20) {echo "class='oute'";}?>><a href="<?php echo $this->router->url('goods_order', ['i_order' => 20]); ?>">待接单</a></li>
						<li <?php if ($a_view_data['i_order'] == 25) {echo "class='oute'";}?>><a href="<?php echo $this->router->url('goods_order', ['i_order' => 25]); ?>">待配送</a></li>
						<li <?php if ($a_view_data['i_order'] == 30) {echo "class='oute'";}?>><a href="<?php echo $this->router->url('goods_order', ['i_order' => 30]); ?>">配送中</a></li>
						<li <?php if ($a_view_data['i_order'] == 10) {echo "class='oute'";}?>><a href="<?php echo $this->router->url('goods_order', ['i_order' => 10]); ?>">待评价</a></li>
						<li <?php if ($a_view_data['i_order'] == 80) {echo "class='oute'";}?>><a href="<?php echo $this->router->url('goods_order', ['i_order' => 80]); ?>">已完成</a></li>
						<li <?php if ($a_view_data['i_order'] == 55) {echo "class='oute'";}?>><a href="<?php echo $this->router->url('goods_order', ['i_order' => 55]); ?>">已取消</a></li>
					</ul>
				</div>
			</div>
			<div class="content">
				<ul>
					<?php foreach ($a_view_data['product'] as $product) {?>
					<form action="shopping" method="post" id="form1">
					<li>
						<input type="hidden" name="repurchase" id="repurchase" target="_blank" >
						<div class="tit">
							<i class="pic"></i>
							<span class="span1"><?php echo $product['store_name']?></span>
							<?php if ($product['order_state'] < 2) {
								echo "<span class='span2 hasCancel'>已取消</span>";
							} else if ($product['order_state'] == 40) {
								echo "<span class='span2'>待付款</span>";
							} else if ($product['order_state'] == 20) {
								echo '<span class="span2">待接单</span>';
							} else if ($product['order_state'] == 25) {
								echo '<span class="span2">待配送</span>';
							} else if ($product['order_state'] == 30) {
								echo '<span class="span2">配送中</span>';
							} else if ($product['order_state'] == 10) {
								echo '<span class="span2">待评价</span>';
							} else if ($product['order_state'] == 80) {
								echo '<span class="span2 hasCancel">已完成</span>';
							}?>
						</div>
						<div class="describe">
							<a href="goods_list-<?php echo $product['order_id']?>" class="clearfix">
								<div class="left"><?php foreach ($a_view_data['goods'] as $goods) {if ($goods['order_id'] == $product['order_id']) {
										echo '<img src="'.get_config_item('goods_img').'/'.$goods['pro_img'].'"/>';
									}}?></div>
								<div class="right">
									<p class="rP1"><?php foreach ($a_view_data['goods'] as $goods) {if ($goods['order_id'] == $product['order_id']) {
										echo $goods['product_name'];
									}}?> 等<?php echo $product['order_count']?>件商品招牌爽爽挝啡 </p>
									<p class="rP2"><?php echo date('Y-m-d H:i', $product['time_create'])?></p>
									<p class="rP3">¥<i class="price"><?php echo $product['order_price']?></i></p>
								</div>
							</a>
						</div>
						<div class="control clearfix">
							<?php if ($product['order_state'] <= 2) {
								echo '<a href="javascript:;" class="appraise zailai" value='.$product['order_id'].'>再来一单</a>
									<input type="submit" name="argsubmit" value="" style="display: none;"/>';
							} else if ($product['order_state'] == 40) {
								echo '<a href="javascript:;" class="goPay" value='.$product['order_id'].'>去付款</a>
							<a href="javascript:;" class="cancel weifuk" value='.$product['order_id'].'>取消订单</a>';
							} else if ($product['order_state'] == 20) {
								if (time()-$product['order_time'] > 600) {

								} else {
									echo '<a href="javascript:;" class="cancel fukuan" value='.$product['order_id'].'>取消订单</a>';
								}
							} else if ($product['order_state'] == 25) {
								echo '<a href="tel:'.$product['store_contact'].'" class="contactBus">联系商家</a>';
							} else if ($product['order_state'] == 30) {
								echo '<a href="javascript:;" class="sureGet"  value='.$product['order_id'].'>确定收货</a>';
							} else if ($product['order_state'] == 10) {
								echo '<a href="'.$this->router->url('order_evaluate', [$product['order_id']]).'" class="appraise">评价</a>';
							} else if ($product['order_state'] == 80) {
								echo '';
							}?>
						</div>
					</li>
					</form>
					<?php }?>
				</ul>
			</div>
			<div class="noMore">
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
				<a href="javascript:;" class="cancel wait">再等会</a>
				<a href="javascript:;" class="remove">立即取消</a>
			</p>
		</div>
		<!--取消订单弹框结束-->
		<!--取消订单成功提示开始-->
		<div class="blackTips cancelTip">咖啡订单取消成功</div>
		<!--取消订单成功提示结束-->
		<!--确定收货弹框开始-->
		<div class="qqBomb sureBomb">
			<p class="p1">确认收到货了吗？</p>
			<p class="btnBox">
				<a href="javascript:;" class="cancel">取消</a>
				<a href="javascript:;" class="remove sure">确认</a>
			</p>
		</div>
		<!--确定收货弹框开始-->
		<!--支付弹框开始-->
		<form action="coffee_newpay" method="post" id="zhifu">
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
	            <input type="hidden" name="come_type" value="3">
	            <input type="hidden" name="order_id" value="" id="order_id">
	            <input name="pay_type" value="1" type="hidden" id="pay_type">
	        </dl>
	    </div>
	    </form>
		<!--支付弹框结束-->
		<script type="text/javascript">
			$(function(){

				//demo示例一到四 通过lass调取，一句可以搞定，用于页面中可能有多个导航的情况
				$('.wrapper').navbarscroll();

			});

			$('#zhi').click(function() {
				$('#zhifu').submit();
			})
			</script>
	</body>
</html>

<script>

$(function(){
    var timer = window.setInterval("weixin_ispay()", 1000);
})

function weixin_ispay(){
    var pay_type = $("input[name='pay_type']").val();
    console.log(pay_type);
    //if (pay_type == 2) {
        $.ajax({
            url: 'weixin_ispay_bill',
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
    //}
}

</script>