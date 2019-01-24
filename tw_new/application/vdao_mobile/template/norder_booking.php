<?php //var_dump($a_view_data);exit; ?>
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
			.contact{padding: 0 .15rem;background: #fff;}
			.contact>div{padding: .1rem 0;font-size: .16rem;color: #888888;}
			.contact .food{display: flex;justify-content: space-between;}
			.contact .food .img{width: .75rem;height: .75rem;background: #A0A0A0; border-radius: .025rem;flex: 0 0 .75rem;margin-right: .1rem;}
			.contact .food .other{display: flex;flex-direction: column;justify-content: space-between;flex: 1; color: #333333;}
			.contact .food .other .info{font-size: .11rem;}
			.contact .food .other .priceBox{font-size: .16rem;display: flex;justify-content: space-between;align-items: center;}
			.contact .food .other .price{color: #fe563c;}
			.contact .userName, .contact .userTel,.contact .note,.contact .bookingNum{font-size: .16rem;display: flex;align-items: center;}
			.contact .userName input, .contact .userTel input,.contact .note input{font-size: .14rem; display: inline-block; flex-grow:1;}
			.contact .bookingNum .num{color: #000000;}
			.contact .bookingNum .num>span+span:before{content: '、';}
			.contact .comeTime{display: flex;justify-content: space-between;}
			.contact .comeTime .more:after{content: '';display: inline-block;width: .07rem; height:.125rem;margin-left: .115rem;background: url(./static/style_default/images/more_gray.png) no-repeat;background-size:100% 100%; background-position: center;}
			.contact .come{display: flex;justify-content: space-between;align-items: center;flex: 1;}
			.contact .all{display: flex;flex-direction: row-reverse;}
			.contact .all .allNum{margin-right: .2rem;}
			.contact .all .allPrice .price{color: #FF6633;}
			.tips{padding: .1rem .15rem;font-size: .14rem;}
			
			/*脚部*/
			.pay{display: flex;flex-direction: row-reverse; align-items: center;position: absolute;width: 100%;bottom: 0;background: #fff;}
			.pay .goPay{background: #FF6633; color: #ffffff;width: 1.5rem;height: .55rem;line-height: .55rem;text-align: center;margin-left: .1rem;font-size: .16rem;}
			.pay .orange{color: #FF6633;font-size: .12rem;}
			.pay .orange .money{font-size: .18rem;}
			.pay .total{text-align: right;}
			
			
			.bg_gray{background: rgba(0,0,0,.4);font-size: 0.14rem;position: absolute;top: 0;left: 0;right: 0;bottom: 0;z-index: 9999;display: none;flex-direction: column-reverse;align-items: center;}
			.bg_gray>div{display: none;}
			/*选择时间*/
			.bg_gray .selectTime{background: #fff;width: 100%;}
			.bg_gray .selectTime .sel_header{display: flex;justify-content: space-between;padding: .15rem;}
			.bg_gray .selectTime .sel_header .selectType{font-size: .16rem;}
			.bg_gray .selectTime .sel_content{display: flex;}
			.bg_gray .selectTime .sel_content .left{background: #F1F1F1;}
			.bg_gray .selectTime .sel_content .left>div{padding: .15rem;text-align: center;}
			.bg_gray .selectTime .sel_content .left .check{color: #ff6633;background: #fff;}
			.bg_gray .selectTime .sel_content .right{height: 2rem;padding: .1rem;flex: 1;overflow-y: auto;}
			.bg_gray .selectTime .sel_content .right>div{padding: .2rem;background: #F8f8f8;margin-bottom: .1rem;border-radius: .05rem;}
			.bg_gray .selectTime .sel_content .right .check{color: #ff6633;background: #ffece6;}
			
			/*点击支付*/
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
			
			.w_100{width: 1rem;}
			.c_gray{color: #666666;}
			.c_orange{color: #ff6633;}
			.border_b{border-bottom: 1px solid #f1f1f1;}
			.
		</style>
	</head>
	<body>
		<!--办公室订单-->
		<div class="body">
			<div class="box">
				<div class="head">
					<div class="left" onclick="window.history.go(-1)"></div>
					<div>提交订单</div>
					<div></div>
				</div>
				<div class="kg"></div>
				<div class="contact">
					<div class="food border_b">
						<div class="img"></div>
						<div class="other">
							<div class="name font_w"><?php echo $a_view_data['store']['store_name']; ?></div>
							<div class="info c_gray">就餐订座-座位</div>
							<div class="priceBox"><span class="price">¥<?php echo $a_view_data['office']['office_price']; ?>/个</span><span class="Num">X<?php echo $a_view_data['seat_count'] ?></span></div>
						</div>
					</div>
					<div class="bookingNum border_b">
						<div class="w_100">座位详情：</div>
						<div class="num">
                            <?php foreach ($a_view_data['office_seatname'] as $seatname) : ?>
							<span><?php echo $seatname; ?></span>
                            <?php endforeach; ?>
						</div>
					</div>
					<div class="comeTime border_b">
						<div class="w_100">入座时间：</div>
						<div class="come more" onclick="selectTime()">去选择</div>
					</div>
					<div class="userName border_b">
						<span class="w_100">联系人：</span>
						<input type="text" placeholder="请填写联系人姓名">
					</div>
					<div class="userTel border_b">
						<span class="w_100">联系电话：</span>
						<input type="text" placeholder="请填写联系电话">
					</div>
					<div class="note border_b">
						<span class="w_100">买家留言：</span>
						<input type="text" placeholder="如有特殊配送要求，请在此填写附信">
					</div>
					<div class="all">
						<span class="allPrice">小计：￥<span class="price">30</span></span>
						<span class="allNum">共<span class="num">1</span>件商品</span>
					</div>
				</div>
				<div class="tips c_orange">*您的座位订金，将在您订餐时自动抵扣</div>
			</div>
		
			<div class="pay">
				<div class="goPay">去支付</div>
				<div class="total">
					<p><span class="font_w">总计：</span><span class="orange">￥<span class="money">30</span></span></p>
				</div>
			</div>
			
			<!--这里是半透明背景-->
			<div class="bg_gray">
				<!--选择时间-->
				<div class="selectTime">
					<div class="sel_header">
						<div class="c_gray" onclick="cancel()">返回</div>
						<div class="selectType">进店时间</div>
						<div class="c_orange sureTime">确定</div>
					</div>
					<div class="sel_content">
						<div class="left">
						</div>
						<div class="right">
						</div>
					</div>
				</div>
				<div class="selectPay">
					<div class="payType">
						<div class="time">
							<div></div>
							<div>请在
							<span class="time-item c_orange">
								<span id="minute_show">30分</span>
								<span id="second_show">0秒</span>
							</span>
							内完成支付</div>
							<div class="cancel"  onclick="cancel()"></div>
						</div>
						<div class="type">
							<div class="alipay check"><div class="logo_alipay">支付宝支付</div></div>
							<div class="WeChat"><div class="logo_wechat">微信支付</div></div>
							<div class="Unionpay"><div class="logo_unionpay">银行卡支付</div></div>
						</div>
					</div>
					<div class="price c_orange">继续支付 ¥134.00</div>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		var intDiff = parseInt(1799);//倒计时总秒数量
		payTime = false;//判断倒计时状态
		
		//点击支付
		$('.goPay').click(function(){
			$('.bg_gray').css('display','flex').find('.selectPay').show();
			if(!payTime){//判断倒计时状态,只执行一次
				timer(intDiff);
			}
		})
		
		//取消支付
		function cancel(){
			$('.bg_gray').hide().children().hide();
		}
		
		//选择支付方式
		$('.type>div').click(function(){
			var checked = $(this).is('.check');
			if(!checked){
				$(this).addClass('check').siblings().removeClass('check')
			}
		})
		
		// 选择时间
		function selectTime(){
			//添加选择日期
			var date = new Date();
			var arr1 = [];
			arr1.push(date.getDay(),date.getDay()+1);
			var left = '';
			$.each(arr1,function(idx,obj){
				if(idx == 0){
					left += '<div class="check" data-value="'+obj+'">今天('+get_Day(obj)+')</div>'
				}else if(idx == 1){
					left += '<div data-value="'+obj+'">明天('+get_Day(obj)+')</div>'
				}else{
					left += '<div data-value="'+obj+'">'+get_Day(obj)+'</div>'
				}
			})
			$('.selectTime').find('.left').html(left);
			
			//添加选择时间段
			var arr2 =[];
			var date1 = new Date(date);
			for(var i=0;i<4;i++){
				date1 = get_hour(date1);
				arr2.push(date1);
			}
			
			var right = '';
			$.each(arr2,function(idx,obj){
				var hour = obj.getHours();
				var minute = obj.getMinutes();
				if(idx == 0){
					right += '<div class="check" data-value="'+obj+'">'+add0(hour)+':'+add0(minute)+'</div>'
				}else{
					right += '<div data-value="'+obj+'">'+add0(hour)+':'+add0(minute)+'</div>'
				}
			})
			$('.selectTime').find('.right').html(right);
				
			$('.bg_gray').css('display','flex').find('.selectTime').show();
		}
		
		//选择日期
		$('body').on('click','.selectTime .left>div',function(){
			var check = $(this).is('.check');
			if(!check){
				$(this).addClass('check').siblings().removeClass('check');
			}
		})
		
		//选择时间段
		$('body').on('click','.selectTime .right>div',function(){
			var check = $(this).is('.check');
			if(!check){
				$(this).addClass('check').siblings().removeClass('check');
			}
		})
		
		$('.sureTime').click(function(){
			var value = $('.selectTime .right>div.check').data('value');
			var date = new Date(value);
			var html = '<span style="color:black">'+add0(date.getHours())+':'+add0(date.getMinutes())+'</span>'
			$('.comeTime .come').html(html);
			cancel()
		})
		
		
		//获取周天
		function get_Day(day){
			switch (day){
				case 0:
					return '周日'
					break;
				case 1:
					return '周一'
					break;
				case 2:
					return '周二'
					break;
				case 3:
					return '周三'
					break;
				case 4:
					return '周四'
					break;
				case 5:
					return '周五'
					break;
				case 6:
					return '周六'
					break;
			}
		}
		
		//增加时间段
		function get_hour(time){
			var time2 = new Date(time);
			var hour = time2.getHours();
			if(time2.getMinutes()>=30){
				time2.setHours(hour+1,0,0,0)
			}else{
				time2.setHours(hour,30,0,0)
			}
			return time2
		}
		
		
		//支付倒计时
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
		function add0(time){
			if(time <= 9){
				return '0'+time
			}else{
				return time
			}
		}
	</script>
</html>