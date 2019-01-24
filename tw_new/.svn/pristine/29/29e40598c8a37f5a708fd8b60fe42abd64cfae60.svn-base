$(function(){

	// 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });

    //选择最近时间效果
    $('.dealBox .close a').click(function(){
    	$(this).addClass('current').siblings().removeClass('current');
    })

    //选择变动事项效果
    $('.changeBox .shi a').click(function(){
    	$(this).addClass('current').siblings().removeClass('current');
    })

    // 勾选支付宝，银行卡
	$('body').on('click','.formBox .sexItn',function(){
		if($(this).attr("checked")){
			if($(this).next('.pattern').html()=='支付宝'){
				$('.ding1').css('background-image','url(/static/style_default/images/pro_36.png)');
				$('.ding2').css('background-image','url(/static/style_default/images/pro_38.png)');
			}else if($(this).next('.pattern').html()=='银行卡'){
				$('.ding1').css('background-image','url(/static/style_default/images/pro_38.png)');
				$('.ding2').css('background-image','url(/static/style_default/images/pro_36.png)');
			}
		}
	})

	//提现弹框显示
	$('.repeatOrder .takeCash a').click(function(){
		$('.editBomb').show();
	})
	//关闭
	$('.editBomb .close').click(function(){
		$('.editBomb').hide();
		$('.cashLi .input').val('');
		$('.integralLi .input').val('')
		$('.wayLi .sexItn:checked').siblings('.pattern').css('background-image','url(/static/style_default/images/pro_38.png)');
		//$('.wayLi .sexItn:checked').removeAttr('checked');
		$(".wayLi .sexItn").prop("checked",false);
		$('.passLi .input').val('');
	})

	//点击确定按钮
	$('.editBomb .sureBox a').click(function(){
		var tot = 0;
		//提现
		if($('.cashLi .input').val() == '' && $('.integralLi .input').val() == ''){
			$('.integralLi .red').show();
			$('.cashLi').data('s',0);
		}else{
			$('.integralLi .red').hide();
			$('.cashLi').data('s',1);
		}
		//提现方式
		if($('.wayLi .sexItn:checked').length == 0){
			$('.wayLi .red').show();
			$('.wayLi').data('s',0);
		}else{
			$('.wayLi .red').hide();
			$('.wayLi').data('s',1);
		}
		//提取密码
		if($('.passLi .input').val() == ''){
			$('.passLi .red').show();
			$('.passLi').data('s',0);
		}else{
			$('.passLi .red').hide();
			$('.passLi').data('s',1);
		}
		$('.tot').each(function(){
			tot += $(this).data('s');
		})

		//条件满足时显示银行卡弹框,支付宝弹框，成功弹框
		// var checkedId = $('.wayLi').find('.sexItn:checked').attr('id');
		// if(tot == 3 && checkedId == 'sex2'){
		// 	$('.bankBomb').show();
		// }else if(tot == 3 && checkedId == 'sex'){
		// 	$('.alipayBomb').show();
		// }
		if (tot == 3) {
			$("#withdrawform").submit();
		}
	})
	// 关闭银行卡弹框
	$('.bankBomb .close').click(function(){
		$('.bankBomb').hide();
	})
	// 关闭银行卡弹框
	$('.alipayBomb .close').click(function(){
		$('.alipayBomb').hide();
	})

	//当有填写/选择时去掉提现弹框提示
	$('.cashLi .input,.integralLi .input').keydown(function(){
		$('.integralLi .red').hide();
	})
	$('.wayLi .sexItn').click(function(){
		$('.wayLi .red').hide();
	})
	$('.passLi .input').keydown(function(){
		$('.passLi .red').hide();
	})

	//现金，积分盈余环形比例图
	var allMoney = Number($('.repeatOrder .money').text());//总余额
	var cashMon = Number($('.repeatOrder .xianjin').text());//现金余额
	if(allMoney == 0){
		$('#processingbar font').text(''+0+'%');
	 	$('#processingbar2 font').text(''+0+'%');
	}else{
		var caPercent = Math.round(cashMon/allMoney*100);//现金比
		var inPercent = 100-caPercent;//积分比
		$('#processingbar font').text(''+caPercent+'%');
		$('#processingbar2 font').text(''+inPercent+'%');
	}
	
})




