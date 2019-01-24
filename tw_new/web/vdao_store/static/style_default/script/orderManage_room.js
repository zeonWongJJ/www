$(function(){
	// 订单切换
	 $('.allOrder li a').click(function(){
	 	$(this).parent().addClass('current').siblings().removeClass('current');
	 })

	//显示弹框
	$('body').on('click','.tableBox .row .cancel',function(){
		$('.cancelBomb').show();
		var appointment_id = $(this).parents('span').attr('value');
		var thisDOM = $(this);
		$('.cancelBomb .sure').click(function(event) {
			var cancel_reason = $('.choose .cho').text();
			var cancel_description = $("input[name='cancel_description']").val();
			var cate = $("input[name='cate']").val();
			$.ajax({
				url: 'appointment_cancel',
				type: 'POST',
				dataType: 'json',
				data: {appointment_id: appointment_id, cancel_reason: cancel_reason, cancel_description: cancel_description, cate:cate},
				success: function(res) {
					console.log(res);
					if (res.code == 200) {
						$("#state_boxp"+appointment_id).children('b').text('已取消');
						$("#state_boxp"+appointment_id).children('b').css('text-decoration','line-through');
						$("#state_boxp"+appointment_id).attr('class','hasFin');
						thisDOM.parent('span').empty();
						// 更新上方各状态下的订单总数
						$(".waitList .number").html(res.data.state_one);
						$(".waitServe .number").html(res.data.state_two);
						$(".inService .number").html(res.data.state_three);
						$(".hasFinish .number").html(res.data.state_five);
					}
				}
			})
			$('.cancelBomb').hide();
			$('.choose .cho').text('');
			$("input[name='cancel_description']").val('');
		});
	})
	//关闭
	$('.cancelBomb .close,.cancelBomb .think').click(function(){
		$('.cancelBomb').hide();
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
	})
	//点击空白下拉消息
	$('body').on('click',function(e){
		var target = $(e.target);
		if(target.closest('.cancelBomb .reasonSel .choose').length == 0 && target.closest('.cancelBomb .reasonSel .select').length == 0){
			$('.cancelBomb .reasonSel .select').hide();
		}
	})

	//点击接单按钮
	$('body').on('click','.tableBox .row .getOrder',function(){
		var appointment_id = $(this).parents('span').attr('value');
		var cate           = $("input[name='cate']").val();
		var thisDOM = $(this);
		$.ajax({
			url: 'appointment_getorder',
			type: 'POST',
			dataType: 'json',
			data: {appointment_id: appointment_id, cate: cate},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					thisDOM.parent().siblings().find('.waitLis').find('b').text('待服务');
					thisDOM.parent().siblings().find('.waitLis').attr('class','waitSer');
					thisDOM.text('开始服务');
					thisDOM.attr('class','beginSer');
					// 更新上方各状态下的订单总数
					$(".waitList .number").html(res.data.state_one);
					$(".waitServe .number").html(res.data.state_two);
					$(".inService .number").html(res.data.state_three);
					$(".hasFinish .number").html(res.data.state_five);
				}
			}
		})
	})
	//点击开始服务按钮
	$('body').on('click','.tableBox .row .beginSer',function(){
		var appointment_id = $(this).parents('span').attr('value');
		var cate           = $("input[name='cate']").val();
		var thisDOM = $(this);
		$.ajax({
			url: 'appointment_beginser',
			type: 'POST',
			dataType: 'json',
			data: {appointment_id: appointment_id, cate: cate},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					thisDOM.parent().siblings().find('.waitSer').find('b').text('服务中');
					thisDOM.parent().siblings().find('.waitSer').attr('class','inSer');
					thisDOM.text('服务结束');
					thisDOM.attr('class','overSer');
					// 更新上方各状态下的订单总数
					$(".waitList .number").html(res.data.state_one);
					$(".waitServe .number").html(res.data.state_two);
					$(".inService .number").html(res.data.state_three);
					$(".hasFinish .number").html(res.data.state_five);
				}
			}
		})
	})
	//点击服务结束按钮
	$('body').on('click','.tableBox .row .overSer',function(){
		var appointment_id = $(this).parents('span').attr('value');
		var cate           = $("input[name='cate']").val();
		var thisDOM = $(this);
		$.ajax({
			url: 'appointment_overser',
			type: 'POST',
			dataType: 'json',
			data: {appointment_id: appointment_id, cate: cate},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					thisDOM.parent().siblings().find('.inSer').find('b').text('已完成');
					thisDOM.parent().siblings().find('.inSer').attr('class','hasFin');
					thisDOM.parent('span').empty();
					// 更新上方各状态下的订单总数
					$(".waitList .number").html(res.data.state_one);
					$(".waitServe .number").html(res.data.state_two);
					$(".inService .number").html(res.data.state_three);
					$(".hasFinish .number").html(res.data.state_five);
				}
			}
		})
	})

	//点击下拉改变颜色
	$('.twoSelect select').change(function(){
		//alert(0);
		var selVal = $(this).val();
		if(selVal == '全部房型' || selVal == '全部座位'){
			$(this).css('color','#999999');
		}else{
			$(this).css('color','#000000');
		}
	})

	// 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });

})




