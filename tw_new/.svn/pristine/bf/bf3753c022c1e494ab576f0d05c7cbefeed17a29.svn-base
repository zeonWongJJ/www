$(function(){
	// 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });	
    
    //显示提现弹框
    $('.bottomBox .takeCash').click(function(){
    	$('.cashBomb').show();
		$('.cashBomb .sure').click(function(){
			if($('.cashBomb .singleRad1 .radInt').attr('checked')){
				//显示未设置提现银行卡弹框
				$('.bankBomb').show();
				//关闭未设置提现银行卡弹框
			    $('.bankBomb .think,.bankBomb .close').click(function(){
			    	$('.bankBomb').hide();
			    })
			}else if($('.cashBomb .singleRad2 .radInt').attr('checked')){
				//显示未设置提现支付宝弹框
				$('.alipayBomb').show();
				//关闭未设置提现支付宝弹框
			    $('.alipayBomb .think,.alipayBomb .close').click(function(){
			    	$('.alipayBomb').hide();
			    })
			}
		})
    })   
    //关闭提现弹框
    $('.cashBomb .think,.cashBomb .close').click(function(){
    	$('.cashBomb').hide();
    })
       
    //勾选提现方式
    $('body').on('click','.cashBomb .radioBox .singleRad .radInt',function(){		    	
		if($(this).attr("checked")){			
			if($(this).next('.chooseLab').find('s').html()=='银行卡'){
				$('.cashBomb .yinhang').addClass('choosed');
				$('.cashBomb .zhifu').removeClass('choosed');
			}else if($(this).next('.chooseLab').find('s').html()=='支付宝'){
				$('.cashBomb .yinhang').removeClass('choosed');
				$('.cashBomb .zhifu').addClass('choosed');
			}
		}
	})
})

	

