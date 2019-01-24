$(function(){
	//点击待付款的取消订单
	$('body').on('click','.stateBox .waitPay .delOrd',function(){
		var id = $(this).attr('value');
		$('.shade').show();
		$('.cancelBomb').show();	
		$('.cancelBomb .wait').click(function(){//再等会
			$('.shade').hide();
		    $('.cancelBomb').hide();
		})
		$('.cancelBomb .remove').click(function(){//立即取消			
		    $.ajax({
				url: 'order_confirm',
				type: 'post',
				data: {weifuk:id},
				dataType: 'json',
				success: function(data){
					$('.shade').hide();
		   			$('.cancelBomb').hide();
					if (data.code == 8) {
						alert('系统已取消！');
						parent.location.reload();
					} else if (data.code == 50) {
						alert('取消订单成功！');
						parent.location.reload();
					} else {
						alert('取消订单失败！');
						parent.location.reload();
					};
				}
			});
		})
	})
	
	//点击待接单的取消订单
	$('body').on('click','.stateBox .waitOrder .delOrd',function(){
		var id = $(this).attr('value');
		$('.shade').show();
		$('.cancelBomb').show();	
		$('.cancelBomb .wait').click(function(){//再等会
			$('.shade').hide();
		    $('.cancelBomb').hide();
		})
		$('.cancelBomb .remove').click(function(){//立即取消			
		   $.ajax({
				url: 'order_confirm',
				type: 'post',
				data: {fukuan:id},
				dataType: 'json',
				success: function(data){
					$('.shade').hide();
	    			$('.cancelBomb').hide();
					// console.log(data);
					if (data.code == 8) {
						alert('订单有误！');
						parent.location.reload();
					}else if (data.code == 5) {
						alert('订单已过10分钟，不能取消订单！');
						parent.location.reload();
					}else if (data.code == 33) {
						alert('取消订单成功！');
						parent.location.reload();
					} else {
						alert(data.usname);
						parent.location.reload();
					};
				}
			});
		})
	})
	
	//点击确定收货
	$('body').on('click','.stateBox .inCarry .conSeller',function(){
		var id = $(this).attr('value');
		$('.shade').show();
		$('.sureBomb').show();	
		$('.sureBomb .cancel').click(function(){//再等会
			$('.shade').hide();
		    $('.sureBomb').hide();
		})
		$('.sureBomb .sure').click(function(){//立即取消			
		   $.ajax({
				url: 'order_confirm',
				type: 'post',
				data: {ensure:id},
				dataType: 'json',
				success: function(data){
					$('.shade').hide();
		    		$('.sureBomb').hide();
					// console.log(data);
					if (data.code == 20) {
						alert('确认订单成功！');
						parent.location.reload();
					} else {
						alert(data.usname);
						parent.location.reload();
					};
				}
			})
		})
	})
	//提交表单
	$('.zailai').click(function(){
		$('#form1').submit();
	});
	
	//支付时间
	function payTime(time,id){
//		var day_elem = $(id).find('.day');
		var hour_elem = $(id).find('.hour');
		var minute_elem = $(id).find('.minute');
		var second_elem = $(id).find('.second');
		var end_time = new Date(time).getTime(),//月份是实际月份-1
		sys_second = (end_time-new Date().getTime())/1000;
		var timer = setInterval(function(){
			if (sys_second > 1) {
				sys_second --;
				var day = Math.floor((sys_second / 3600) / 24);
				var hour = Math.floor((sys_second / 3600) % 24);
				var minute = Math.floor((sys_second / 60) % 60);
				var second = Math.floor(sys_second % 60);
//				day_elem && $(day_elem).text(day);//计算天
				$(hour_elem).text(hour<10?"0"+hour:hour);//计算小时
				$(minute_elem).text(minute<10?"0"+minute:minute);//计算分钟
				$(second_elem).text(second<10?"0"+second:second);//计算秒杀
			} else { 
				clearInterval(timer);
			}
		}, 1000);
	}
	payTime("2017/12/23 12:00:00",".payTime");

	
})
