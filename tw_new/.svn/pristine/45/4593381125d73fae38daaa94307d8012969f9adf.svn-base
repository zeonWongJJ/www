$(function(){

	// 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });

	// 点击全部状态显示下拉
	$('body').on('click','.tableBox .thead .staTitle',function(){
		$(this).parent().toggleClass('down');
		$(this).siblings('.stateSelect').toggle();
		$(this).siblings('.zhe').toggle();
	})

	//点击空白下拉消失
	$('body').on('click',function(e){
    	var target = $(e.target);
    	if(target.closest('.tableBox .thead .staTitle').length == 0 && target.closest('.tableBox .state .stateSelect').length == 0 && target.closest('.tableBox .state .zhe').length == 0 ){
    		$('.tableBox .state').removeClass('down');
			$('.tableBox .state .stateSelect').hide();
			$('.tableBox .state .zhe').hide();
    	}
    })

	//选择下拉
	$('body').on('click','.tableBox .state .stateSelect a',function(){
		var aText = $(this).text();
		$(this).parent().parent().siblings('.staTitle').find('s').text(aText);
		$(this).closest('.stateSelect').hide();
		$(this).closest('.state').removeClass('down');
		$(this).parent().parent('.stateSelect').siblings('.zhe').hide();
	})

	//显示审核评价弹框
	// $('body').on('click','.tableBox .row .handle .shen',function(){
	// 	$('.examineBomb').show();
	// })
	//关闭
	$('.examineBomb .close').click(function(){
		$('.examineBomb').hide();
	})

	//显示删除评价弹框
	// $('body').on('click','.tableBox .row .handle .shan',function(){
	// 	$('.deleteBomb').show();
	// })
	//关闭
	$('.deleteBomb .close').click(function(){
		$('.deleteBomb').hide();
	})

	//显示标签弹框
	$('.bread .tagManage a').click(function(){
		$('.tagBomb').show();
	})
	//关闭
	$('.tagBomb .h2 .close').click(function(){
		$('.tagBomb').hide();
	})
	$('.tagBomb .sureBox').click(function(){
		$('.tagBomb').hide();
	})
	//咖啡，房间标签切换
	$('.tagBomb .navL a').click(function(){
		$(this).addClass('aCur').siblings().removeClass('aCur');
		var tIndex = $(this).index();
		if(tIndex == 0){
			$('.tagBomb .coffeeCom1').show();
			$('.tagBomb .roomCom').hide();
			$("input[name='comtag_type']").val('2');// 添加标签时的类型 1代表房间标签 2代表咖啡标签
		}else if(tIndex == 1){
			$('.tagBomb .coffeeCom1').hide();
			$('.tagBomb .roomCom').show();
			$("input[name='comtag_type']").val('1');// 添加标签时的类型 1代表房间标签 2代表咖啡标签
		}
	})

	//添加标签
	$('.tagBomb .addR .addA').click(function(){
		if($('.coffeeCom:visible .good1').find('ul').children().is('.intLi') == false){
			$('.coffeeCom:visible .good1 ul').append('<li class="intLi"><input class="int" comtag_cate="1" type="text"/><a class="right" href="javascript:;">&#10004</a><a class="wrong" href="javascript:;">&#10006</a></li>');
		    $('.coffeeCom:visible .good1 ul').find('.intLi').find('input').focus();
		}
		if($('.coffeeCom:visible .soso').find('ul').children().is('.intLi') == false){
			$('.coffeeCom:visible .soso ul').append('<li class="intLi"><input class="int" comtag_cate="2" type="text"/><a class="right" href="javascript:;">&#10004</a><a class="wrong" href="javascript:;">&#10006</a></li>');
		}
		if($('.coffeeCom:visible .bad').find('ul').children().is('.intLi') == false){
			$('.coffeeCom:visible .bad ul').append('<li class="intLi"><input class="int" comtag_cate="3" type="text"/><a class="right" href="javascript:;">&#10004</a><a class="wrong" href="javascript:;">&#10006</a></li>');
		}
	})
	//删除按钮
	$('body').on('click','.good .intLi .wrong',function(){
		$(this).parent().remove();
	})
	//确定按钮
	$('body').on('click','.good .intLi .right',function(){
		var intVal = $(this).siblings('.int').val();
		var comtag_cate = $(this).siblings('.int').attr('comtag_cate');
		var comtag_type = $("input[name='comtag_type']").val();
		var click_this = $(this);
		if(intVal !== ''){
			$.ajax({
				url: 'comtag_add',
				type: 'POST',
				dataType: 'json',
				data: {comtag_name: intVal, comtag_type: comtag_type, comtag_cate: comtag_cate},
				success: function(res) {
					console.log(res);
					if (res.code == 200) {
						click_this.parent().parent('ul').append('<li id="comtag_'+res.data+'">'+intVal+'<a href="javascript:;" class="shanchu" onclick="comtag_delete('+res.data+')"></a></li>');
						click_this.closest('.good').siblings().find('.intLi').remove();
						click_this.parent().remove();
					}
				}
			})
		}else{
			alert('你还没输入标签内容');
		}
	})
	//键盘回车或空格
	$(window).keydown(function(e){
		if(e.keyCode == 13 || e.keyCode == 32){
			$(".coffeeCom:visible .good .intLi").each(function(index, el) {
				var this_dom = $(this);
				var comtag_name = $(this).children('.int').val();
				var comtag_cate = $(this).children('.int').attr('comtag_cate');
				var comtag_type = $("input[name='comtag_type']").val();
				if (comtag_name != '') {
					$.ajax({
						url: 'comtag_add',
						type: 'POST',
						dataType: 'json',
						data: {comtag_name: comtag_name, comtag_type: comtag_type, comtag_cate: comtag_cate},
						success: function(res) {
							console.log(res);
							if (res.code == 200) {
								this_dom.parents('ul').append('<li id="comtag_'+res.data+'">'+comtag_name+'<a href="javascript:;" class="shanchu" onclick="comtag_delete('+res.data+')"></a></li>');
								this_dom.remove();
							}
						}
					})
				}
			});
			// var intLen = $('.coffeeCom:visible .good .intLi').length;
			// for(var i = 0; i < intLen; i ++){
			// 	if($('.coffeeCom:visible .good .intLi:eq('+i+')').find('.int').val() !== ''){
			// 		var intVal = $('.coffeeCom:visible .good .intLi:eq('+i+')').find('.int').val();
			// 		var comtag_cate = $('.coffeeCom:visible .good .intLi:eq('+i+')').find('.int').attr('comtag_cate');
			// 		var comtag_type = $("input[name='comtag_type']").val();
			// 		var click_this = $('.coffeeCom:visible .good .intLi:eq('+i+')');
			// 		$.ajax({
			// 			url: 'comtag_add',
			// 			type: 'POST',
			// 			dataType: 'json',
			// 			data: {comtag_name: intVal, comtag_type: comtag_type, comtag_cate: comtag_cate},
			// 			success: function(res) {
			// 				console.log(res);
			// 				if (res.code == 200) {
			// 					$('.coffeeCom:visible .good .intLi:eq('+i+')').parent('ul').append('<li id="comtag_'+res.data+'">'+intVal+'<a href="javascript:;" class="shanchu" onclick="comtag_delete('+res.data+')"></a></li>');
			// 					$('.coffeeCom:visible .good .intLi:eq('+i+')').closest('.good').siblings().find('.intLi').remove();
			// 					$('.coffeeCom:visible .good .intLi:eq('+i+')').remove();
			// 				}
			// 			}
			// 		})
			// 	}else{
			// 		alert('你还没输入标签内容');
			// 	}
			// }
		}
	})
	//删除标签
	// $('body').on('click','.good .shanchu',function(){
	// 	$('.deleTag1').show();
	// })
	// $('.deleTag1 .think').click(function(){
	// 	$('.deleTag1').hide();
	// })

})


// 删除标签
function comtag_delete(comtag_id) {
	$('.deleTag1').show();
	$('.deleTag1 .think').click(function(event) {
		$('.deleTag1').hide();
	});
	$('.deleTag1 .sure').click(function(event) {
		$.ajax({
			url: 'comtag_delete',
			type: 'POST',
			dataType: 'json',
			data: {comtag_id: comtag_id},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					$("#comtag_"+comtag_id).remove();
				}
			}
		})
		$('.deleTag1').hide();
	});
}

