$(function(){
	//点击切换导航
	$('.nav li a').click(function(){
		$(this).parent('li').addClass('current').siblings().removeClass('current');		
	})
	 // 未付款取消
    $('body').on('click','.content .control .weifuk',function(){
    	var id = $(this).attr('value');
    	$('.shade').show();
		$('.cancelBomb').show();
		$('.cancelBomb .wait').unbind('click').click(function(){//再等会
			$('.shade').hide();
		    $('.cancelBomb').hide();
		})
		$('.cancelBomb .remove').unbind('click').click(function(){//立即取消
	    	$.ajax({
				url: 'order_confirm',
				type: 'post',
				data: {weifuk:id},
				dataType: 'json',
				success: function(data){
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

    //付款取消
    $('body').on('click','.content .control .fukuan',function(){
    	var id = $(this).attr('value');
    	$('.shade').show();
		$('.cancelBomb').show();
		$('.cancelBomb .wait').unbind('click').click(function(){//再等会
			$('.shade').hide();
		    $('.cancelBomb').hide();
		})
		$('.cancelBomb .remove').unbind('click').click(function(){//立即取消
	    	$.ajax({
				url: 'order_confirm',
				type: 'post',
				data: {fukuan:id},
				dataType: 'json',
				success: function(data){
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
	
	//支付弹框
	$(".content .goPay").click(function(){
		var price = $(this).parent().siblings('.describe').find('.price').text();//获取当前的价格
		var order_id = $(this).attr('value');
		$('#order_id').val(order_id);
		$('.payment .surePay .jiaqian').text(price);//把价格放到弹窗
        $(".shade").show();
        $(".payment").slideDown(100);
        getTime();
    });
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
	//提交表单
	$('.zailai').click(function(){
		var id = $(this).attr('value');
		$('#repurchase').val(id);
		$('#form1').submit();
	})
	//确定收货
	$('body').on('click','.content .control .sureGet',function(){
		var id = $(this).attr('value');
		$('.sureBomb').show();
		$('.sureBomb .cancel').unbind('click').click(function(){
		    $('.sureBomb').hide();
		})
		$('.sureBomb .sure').unbind('click').click(function(){
	    	$.ajax({
				url: 'order_confirm',
				type: 'post',
				data: {ensure:id},
				dataType: 'json',
				success: function(data){
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
	//关闭
	$('body').on('click','.sureBomb .cancel',function(){
		$('.shade').hide();
		$('.sureBomb').hide();
	})
})
 
