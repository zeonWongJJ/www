<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>提交订单</title>
		<link rel="stylesheet" type="text/css" href="./static/style_default/style/common.css"/>
		<script src="./static/style_default/plugin/jquery-3.1.1.min.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
		<style type="text/css">
			.body{position: relative;height: 100%;font-size: 0.14rem;}
			.box{background: #f7f7f7;position: absolute;top: 0;left: 0;right: 0;bottom: .55rem;height: calc(100% - .55rem);overflow: auto;}
			.kg{height: .1rem;width: 100%; background: #f7f7f7;}
			.head{height: 0.44rem;display: flex;justify-content: space-between ;padding: 0 .15rem;font-size: .18rem;background: #fff;}
			.head div{line-height: .44rem;color: #000000;}
			.head .left{flex: 0 0 .1rem;background: url(./static/style_default/images/back.png) no-repeat;background-size: .1rem .18rem; background-position: center;}
			.adress{padding: .15rem;background: #fff;}
			.adress .user{display: flex;justify-content: space-between;}
			.adress .adInfo{font-size: .16rem;display: flex;justify-content: space-between;align-items: center;}
			.adress .adInfo:after{content: '';display: inline-block;width: .07rem; height:.125rem;background: url(./static/style_default/images/more.png) no-repeat;background-size:100% 100%; background-position: center;margin-left: .125rem;}
			.contact{padding: 0 .15rem;background: #fff;}
			.contact .store{display: flex;justify-content: space-between;align-items: center;padding: .1rem 0;}
			.contact .store .left{display: flex;align-items: center;}
			.contact .store .left:before{content: '';display: inline-block;width: .25rem; height:.25rem;background: url(./static/style_default/images/store.png) no-repeat;background-size:100% 100%; background-position: center;margin-right: .125rem;}
			.contact .foods .food{display: flex;justify-content: space-between;padding: .1rem 0;border-top: 1px solid #f1f1f1;}
			.contact .foods .food .img{width: .75rem;height: .75rem;background: #A0A0A0; border-radius: .025rem;flex: 0 0 .75rem;margin-right: .1rem;}
			.contact .foods .food .other{display: flex;flex-direction: column;justify-content: space-between;flex: 1;}
			.contact .foods .food .other .info{font-size: .11rem;}
			.contact .foods .food .other .priceBox{font-size: .16rem;display: flex;justify-content: space-between;align-items: center;}
			.contact .foods .food .other .price{color: #fe563c;}
			.box>div:not(.head):not(.contact):not(.adress):not(.kg):not(.pay):not(.tips){font-size:.16rem;padding: .2rem .15rem;background: #fff;}
			.note{font-size: .16rem;display: flex;align-items: center;}
			.note input{font-size: .14rem; display: inline-block; flex-grow:1;padding: 0 .1rem;}
			.all{display: flex;flex-direction: row-reverse;}
			.all .allNum{margin-right: .2rem;}
			.all .allPrice .price{color: #FF6633;}
			.integral,.balance{display: flex;justify-content: space-between;}
			.sendTime{display: none;justify-content: space-between;}
			.sendTime .more:after{content: '';display: inline-block;width: .07rem; height:.125rem;margin-left: .115rem;background: url(./static/style_default/images/more_gray.png) no-repeat;background-size:100% 100%; background-position: center;}
			.tips{padding: .1rem .15rem;font-size: .14rem;}
			
			/*脚部*/
			.pay{display: flex;flex-direction: row-reverse; align-items: center;position: absolute;width: 100%;bottom: 0;background: #fff;}
			.pay .goPay{background: #FF6633; color: #ffffff;width: 1.5rem;height: .55rem;line-height: .55rem;text-align: center;margin-left: .1rem;font-size: .16rem;}
			.pay .orange{color: #FF6633;font-size: .12rem;}
			.pay .orange .money{font-size: .18rem;}
			.pay .total{text-align: right;}
			
			/*点击支付*/
			.bg_gray{background: rgba(0,0,0,.4);font-size: 0.14rem;position: absolute;top: 0;left: 0;right: 0;bottom: 0;z-index: 9999;display: none;flex-direction: column-reverse;align-items: center;}
			.bg_gray .selectPay>div{background: #fff;text-align: center;width: 3.45rem;border-radius: .05rem;}
			.bg_gray .price{height: .55rem; line-height: .55rem;margin-top: .15rem;font-size: .16rem;}
			.bg_gray .time,.bg_gray .type>div{height: .55rem;line-height: .55rem;}
			.bg_gray .time{display: flex;align-items: center;justify-content: space-between;padding:0 .15rem;}
			.bg_gray .cancel{height: .11rem; width: .11rem;background: url(./static/style_default/images/cancel.png) no-repeat;background-size:100% 100%; background-position: center;}
			.bg_gray .type{padding: 0 .15rem;}
			.bg_gray .type>div{display: flex;align-items: center;justify-content: space-between;}
			.bg_gray .type>.check:after{content: '';display: inline-block;width: .135rem;height: .095rem; background: url(./static/style_default/images/checked_pay.png)no-repeat;background-size:100% 100%; background-position: center;}
			.bg_gray .type>div>div{display: flex;align-items: center;}
			.logo_alipay:before{content: '';display: inline-block;width: .3rem;height: .3rem;margin-right: .1rem; background: url(./static/style_default/images/alipay.png)no-repeat;background-size:100% auto; background-position: center;}
			.logo_wechat:before{content: '';display: inline-block;width: .3rem;height: .3rem;margin-right: .1rem; background: url(./static/style_default/images/wechatpay.png)no-repeat;background-size:100% auto; background-position: center;}
			.logo_unionpay:before{content: '';display: inline-block;width: .3rem;height: .3rem;margin-right: .1rem; background: url(./static/style_default/images/unionpay.png)no-repeat;background-size:100% auto; background-position: center;}
			
			.c_gray{color: #666666;}
			.c_orange{color: #ff6633;}
			.border_b{border-bottom: 1px solid #f1f1f1;}
			.font_w{font-weight: 700;}
			.checkbox{width: .2rem;height: .2rem;border: 1px solid #cbcbcb;border-radius: .025rem;}
			.checkbox:checked{background: url(./static/style_default/images/checked.png) no-repeat;background-size: .12rem .08rem; background-position: center;}
		</style>
	</head>
	<body>
		<!--自取订单，外卖订单-->
		
		<div class="body">
			<div class="box">
				<div class="head">
					<a class="left" href="javascript:history.back(-1);"></a>
					<div>提交订单</div>
					<div></div>
				</div>
				<?php if($a_view_data['distribution_type'] != 2){?>
				<div class="adress ">
					    <?php if (empty($a_view_data['memb'])) { ?>
            				<a href="naddress-<?php echo $a_view_data['store_id']?>"><p>+添加配送地址</p></a>
          					  <?php } else {?>
						<a href="naddress-<?php echo $a_view_data['store_id']?>">

						<div class="user c_gray">
							<span>收货人：<?php echo $a_view_data['memb']['user_name']; ?></span> 
							<span><?php echo $a_view_data['memb']['mob_phone']; ?></span></div>
						<div class="adInfo">收货地址：<?php echo $a_view_data['memb']['address']; ?>（<?php echo $a_view_data['memb']['house']?>)</div></a>
						 <?php }?>
				</div>
				 <?php }?>
				<div class="kg"></div>
				<div class="contact border_b">
					 <?php if (!empty($a_view_data['goods']['store'])) { ?>
					  <?php for($i=0; $i<count($a_view_data['goods']['store']); $i++) { ?>
					<div class="store">
					<div class="left"><?php echo $a_view_data['goods']['store'][$i]['store_name']; ?>
						
					</div>
					<?php if($a_view_data['distribution_type'] != 2){?>
					<div class="right c_gray">配送费<?php echo $a_view_data['goods']['store'][$i]['freight']; ?>元</div>
					<?php }else{?>
					<div class="right c_gray">自取</div>
					<?php }?>
					</div>
					 
					<div class="foods">
						<?php foreach ($a_view_data['goods']['store'][$i]['cart'] as $key => $value) { ?>
						<div class="food">
						<div class="img"><img src="<?php echo $value['pro_img']; ?>"></div>
						<div class="other">
							<div class="name font_w"><?php echo $value['product_name']; ?></div>
							<div class="info c_gray"><?php echo $value['shux_name']; ?></div>
							<div class="priceBox"><span class="price">￥<?php echo $value['new_price']; ?></span><span class="foodNum">X <?php echo $value['prot_count']; ?></span></div>
						</div>
						</div>
						<?php } ?>
					</div>
					 <?php } }?>
				</div>
				
				<div class="contact border_b">
					 <?php if (!empty($a_view_data['goods']['nostore'])) { ?>
					 
					<div class="store">
					<div class="left">系统自动分配门店配送</div>
					
					<div class="right c_gray">配送费<?php echo $a_view_data['goods']['nostore']['freight']; ?>元</div>
					</div>
					
					<div class="foods">
						<?php foreach ($a_view_data['goods']['nostore']['cart'] as $key => $value) { ?>
						<div class="food">
						<div class="img"> <img src="<?php echo $value['pro_img']; ?>"></div>
						<div class="other">
							<div class="name font_w"><?php echo $value['product_name']; ?></div>
							<div class="info c_gray"><?php echo $value['shux_name']; ?></div>
							<div class="priceBox"><span class="price">￥<?php echo $value['new_price']; ?></span><span class="foodNum">X <?php echo $value['prot_count']; ?></span></div>
						</div>
						</div>
						<?php } ?>
					</div>
					 <?php  }?>
				</div>
				<div class="note border_b">
					<span>买家留言：</span>
					<input type="text" name="message" placeholder="如有特殊配送要求，请在此填写附信">
				</div>
				<div class="all">
					<span class="allPrice">小计：￥<span class="price"><?php echo $a_view_data['goods_amount_total']?></span></span>
					<span class="allNum">共<span class="num"><?php echo $a_view_data['goods_count_total']?></span>件商品</span>
				</div>
				<div class="kg"></div>
				<div class="integral border_b">
					<span>可用<span class="integralNum"><?php echo $a_view_data['user']['user_score']?></span>积分抵扣<span class="integralNum"><?php echo $a_view_data['user']['user_score']?></span>元</span>
					<input class="checkbox" type="checkbox" name="integral" value="<?php echo $a_view_data['user']['user_score']?>" >
					<input class="checkbox" type="hidden" name="useIntegral" value="0" >
				</div>
				<div class="balance">
					<span>可用<span class="balanceNum"><?php echo $a_view_data['user']['user_balance']?></span>余额抵扣<span class="balanceNum"><?php echo $a_view_data['user']['user_balance']?></span>元</span>
					<input class="checkbox" type="checkbox" value="<?php echo $a_view_data['user']['user_balance']?>" name="balance">
					<input class="checkbox" type="hidden" name="useBalance" value="0" >
				</div>
				<div class="kg"></div>
				<?php if($a_view_data['distribution_type'] != 2){?>
				<div class="sendTime" style="display: flex;">
					<div>送达时间</div>
					<div class="time more">尽快送达（<?php echo date("H:i",strtotime("+40 minute"));?>送达）</div>
				</div>
				 <?php }?>
				<?php if($a_view_data['appointment_id_str']){?>
				<div class="tips c_orange">*座位订金已抵扣<?php echo $a_view_data['appointment']['appointment_price'][0]['appointment_price'];?>元</div>
			<?php }?>
			</div>
 		<form action="coffee_newpay?oldurl=<?php echo $_GET['oldurl']?>" method="post" id="payform">
 			  <?php  if ($a_view_data['come_type'] == 2) { ?>
            <!-- 数量 -->
            <input type="hidden" name="prot_count" value="<?php echo $a_view_data['goods_count_total']; ?>">
            <!-- 门店名称 -->
            <input type="hidden" name="store_name" value="<?php echo $a_view_data['product']['store_name']; ?>">
            <!-- 门店id -->
            <input type="hidden" name="store_id" value="<?php echo $a_view_data['product']['store_id']; ?>">
            <!-- 运费 -->
            <input type="hidden" name="shipping_fee" value="<?php echo $a_view_data['product']['freight']; ?>">
            <!-- 产品id -->
            <input type="hidden" name="product_id" value="<?php echo $a_view_data['product']['product_id']; ?>">
            <!-- 属性 -->
            <input type="hidden" name="shux_name" value="<?php echo $a_view_data['shux']; ?>">
            <!-- 产品主图 -->
            <input type="hidden" name="imge" value="<?php echo $a_view_data['product']['pro_img']; ?>">
            <!-- 单价 -->
            <input type="hidden" name="money" value="<?php echo $a_view_data['product']['new_price']; ?>">
   			
            <!-- 产品名称 -->
            <input type="hidden" name="goods_name" value="<?php echo $a_view_data['product']['product_name']; ?>">
            <?php } ?>
        <!-- 购物车id -->
        <input type="hidden" name="cart_ids" value="<?php echo $a_view_data['cart_ids']; ?>">
        <!-- 实付款 -->
        <input type="hidden" name="actual_pay" value="<?php echo $a_view_data['order_price']; ?>" id="actual_pay">
        <!-- 商品总价 -->
        <input type="hidden" name="goods_amount" value="<?php echo $a_view_data['goods_amount_total']; ?>" id="goods_amount">
        <!-- 订单总价 -->
        <input type="hidden" name="order_price" value="<?php echo $a_view_data['order_price']; ?>">
        <!-- 运费 -->
        <?php if ( $a_view_data['distribution_type'] != 2) { ?>
        <input type="hidden" name="shipping_fee" value="<?php echo $a_view_data['shipping_fee']; ?>">
        <?php }else{ ?>
        	 <input type="hidden" name="shipping_fee" value="0">
        <?php }?>
        <!-- 余额抵扣 -->
        <input type="hidden" name="balance_deduction" value="0" id="balance_deduction">
        <!-- 积分抵扣 -->
        <input type="hidden" name="score_deduction" value="0" id="score_deduction">
        <!--配送类型-->
         <input type="hidden" name="distribution_type" value="<?php echo $a_view_data['distribution_type']; ?>">
        <!-- 送达时间 -->
        <input type="hidden" name="time_delay" value="<?php echo date("H:i",strtotime("+40 minute"));?>" id="time_delay">
        <!-- 支付方式 -->
        <input type="hidden" name="pay_type" value="1">
        <!-- 进入方式 -->
        <input type="hidden" name="come_type" value="<?php echo $a_view_data['come_type']?>">
        <!-- 抵扣的座位订单 -->
        <input type="hidden" name="appointment_ids" value ="<?php echo $a_view_data['appointment_id_str']?>">
        <input type="text" name="order_message" placeholder="如有特殊配送要求，请在此填写附信">
		</form>
			<div class="pay">
				<div class="goPay">去支付</div>
				<div class="total">
					<p><span class="font_w">总计：</span><span class="orange">￥<span class="money"><?php echo $a_view_data['order_price']; ?></span></span></p>
					<?php if($a_view_data['distribution_type'] != 2){?>
					<p>包含配送费<span class="sendPrice"><?php echo $a_view_data['shipping_fee'] ?></span>元</p>
					<?php }?>
					<input type="hidden" name="totalMoney" value="<?php echo $a_view_data['order_price']; ?>">
				</div>
			</div>
			
			<div class="bg_gray">
				<div class="selectPay">
					<div class="payType">
						<div class="time">
							<div></div>
							<div>请在
							<span class="time-item c_orange">
							<!--<span id="day_show">0天</span>
								<span id="hour_show">0时</span>-->
								<span id="minute_show">30分</span>
								<span id="second_show">0秒</span>
							</span>
							内完成支付</div>
							<div class="cancel"></div>
						</div>
						<div class="type">
							<div class="alipay check" payType="1"><div class="logo_alipay">支付宝支付</div></div>
							<div class="WeChat"  payType="2"><div class="logo_wechat">微信支付</div></div>
							<div class="Unionpay"  payType="3"><div class="logo_unionpay">银行卡支付</div></div>
						</div>
					</div>
					<div class="price c_orange INgoPay">继续支付 ¥<span class="fanletotal"><?php echo $a_view_data['order_price']; ?></span></div>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">

	
	var intDiff = parseInt(1799);//倒计时总秒数量
	payTime = false;//判断倒计时状态
	
	//点击支付
	$('.goPay').click(function(){
		$('.bg_gray').css('display','flex');
		if(!payTime){//判断倒计时状态,只执行一次
			timer(intDiff);
		}

	})
	$(".INgoPay").click(function(){
		var message = ($("input[name='message']").val());
		$("input[name='order_message']").val(message);
		var form  = $("#payform").serialize();
		$("#payform").submit();
		// console.log(form);
	})

	//使用积分计算
	$("input[name='integral']").change(function(){
		var total_money = Number($("input[name='totalMoney']").val());
		var  integrals = Number($("input[name='integral']").val());
	if($("input[name='integral']").prop("checked") == true){
		
		if(total_money > integrals){
			var totalMoney = total_money - integrals ;
			integrals = integrals;
		}else{
			var totalMoney = 0;
			var integrals  =  total_money;
			
			
		}
		$("input[name='score_deduction']").val(integrals.toFixed(2));
		$('.total .money').text(totalMoney.toFixed(2));
		$("input[name='totalMoney']").val(totalMoney.toFixed(2));
		$(".fanletotal").text(totalMoney.toFixed(2));
		$("input[name='actual_pay']").val(totalMoney.toFixed(2));

	}else{
		var total_money =Number($("input[name='totalMoney']").val());
		var totalMoney = total_money + Number($("input[name='score_deduction']").val());
		$("input[name='totalMoney']").val(totalMoney.toFixed(2));
		$('.total .money').text(totalMoney.toFixed(2));	
		$("input[name='score_deduction']").val(0);	
		$(".fanletotal").text(totalMoney.toFixed(2));
		$("input[name='actual_pay']").val(totalMoney.toFixed(2)); 
	}

	});
	//抵扣余额
	$("input[name='balance']").change(function(){
	if($("input[name='balance']").prop("checked") == true){
		var total_money =Number($("input[name='totalMoney']").val());
		var balance   =Number($("input[name='balance']").val());
		if(total_money > balance){
			var totalMoney = total_money - balance;
		}else {
			var totalMoney = 0;
			var balance  =  total_money;			
		}
		$("input[name='balance_deduction']").val(balance.toFixed(2));
		$('.total .money').text(totalMoney.toFixed(2));
		$("input[name='totalMoney']").val(totalMoney.toFixed(2));
		$(".fanletotal").text(totalMoney.toFixed(2));
		$("input[name='actual_pay']").val(totalMoney.toFixed(2));

	}else{
		var total_money =Number($("input[name='totalMoney']").val());
		var totalMoney = total_money + Number($("input[name='balance_deduction']").val());
		$("input[name='totalMoney']").val(totalMoney.toFixed(2));
		$('.total .money').text(totalMoney.toFixed(2));	
		$("input[name='balance_deduction']").val(0);	
		$(".fanletotal").text(totalMoney.toFixed(2));
		$("input[name='actual_pay']").val(totalMoney.toFixed(2));
	}
	});	

	//取消支付
	$('.bg_gray .cancel').click(function(){
		$('.bg_gray').css('display','none');
	})
	
	//选择支付方式
	$('.type>div').click(function(){
		var checked = $(this).is('.check');
		var type = $(this).attr("payType");
		if(!checked){
			$("input[name='pay_type']").val(type);
			$(this).addClass('check').siblings().removeClass('check')
		}
	})
	
function timer(intDiff){
    window.setInterval(function(){
    var day=0,
        hour=0,
        minute=0,
        second=0;//时间默认值        
    if(intDiff > 0){
        day = Math.floor(intDiff / (60 * 60 * 24));
        hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
        minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
        second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
    }
    if (minute <= 9) minute = '0' + minute;
    if (second <= 9) second = '0' + second;
    $('#minute_show').html('<s></s>'+minute+'分');
    $('#second_show').html('<s></s>'+second+'秒');
    intDiff--;
    }, 1000);
	payTime = !payTime
}
</script>