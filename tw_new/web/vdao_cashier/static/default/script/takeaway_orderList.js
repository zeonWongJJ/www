$(function(){
	// 订单切换
	$('.allOrder li a').click(function(){
	 	$(this).parent().addClass('current').siblings().removeClass('current');
	})
	
	//显示交易状态下拉
	$('.tabThead .dealState .biaoti').click(function(){
		$(this).parent('.dealState').toggleClass('clickState');
		$(this).siblings('.selectBox').toggle();
	})
	
	//点击空白下拉消失
	$('body').on('click',function(e){
		var target = $(e.target);
		if(target.closest('.tabThead .dealState .biaoti').length == 0 && target.closest('.tabThead .dealState .selectBox').length == 0){
			$('.tabThead .dealState').removeClass('clickState');
			$('.tabThead .dealState .selectBox').hide();
		}
	})
	
	//选择下拉
	$('.tabThead .dealState .selectBox a').click(function(){
		var aText = $(this).text();
		$(this).parent().siblings('.biaoti').find('.jiao').text(aText);
		$(this).closest('.dealState').removeClass('clickState');
		$(this).closest('.selectBox').hide();
	})
	
	//鼠标经过显示消息提醒
	$('.tableBox .messageTip .imgT').hover(function(){
		$(this).siblings('.messCha').toggle();
	})
	
	//鼠标经过状态显示
	$('.tableBox .row span:nth-child(3)').hover(function(){
		$(this).find('.state').toggle();
	})
	
	//显示订单详情弹框
	$('body').on('click','.tableBox .row .detail a',function(){
		$('.detailBomb').show();
	})
	//关闭订单详情弹框
	$('body').on('click','.detailBomb .closeBox a',function(){
		$('.detailBomb').hide();
	})
	
	//点击显示取消订单原因下拉
	$('.cancelBomb .reasonSel .choose').click(function(){
		$('.cancelBomb .select').toggle();		
	})
	//点击下拉
	$('.cancelBomb .select li').click(function(){
		$(this).closest('.select').hide();
		var sText = $(this).find('.rea').text();
		$(this).closest('.select').siblings('.choose').find('.cho').text(sText);
		if(sText == '其他'){
			$(this).closest('.reasonBox').siblings('.remark').show();
		}else{
			$(this).closest('.reasonBox').siblings('.remark').hide();
			$(this).closest('.reasonBox').siblings('.remark').find('.txt').val('');
		}
	})
	//点击空白下拉消息
	$('body').on('click',function(e){
		var target = $(e.target);
		if(target.closest('.cancelBomb .reasonSel .choose').length == 0 && target.closest('.cancelBomb .reasonSel .select').length == 0){
			$('.cancelBomb .reasonSel .select').hide();
		}
	})
})



