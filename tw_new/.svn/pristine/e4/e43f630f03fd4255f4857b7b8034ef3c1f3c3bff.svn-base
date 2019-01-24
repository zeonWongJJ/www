$(function(){
	//暂停/启用功能切换
	$('body').on('click','.characterBox .open,.characterBox .stopOpen',function(){
		var product_id = $(this).attr('proid');
		$.ajax({
			url: 'package_switch',
			type: 'POST',
			dataType: 'json',
			data: {product_id: product_id},
			success: function(res) {
				console.log(res);
			}
		})
		if($(this).hasClass('open')){
			$(this).removeClass('open').addClass('stopOpen');
			$(this).children('span').text('暂用');
			$(this).children('img').attr('src','/static/style_default/images/pro_33.png');
		}else if($(this).hasClass('stopOpen')){
			$(this).removeClass('stopOpen').addClass('open');
			$(this).children('span').text('启用');
			$(this).children('img').attr('src','/static/style_default/images/pro_10.png');
		}
	})
	//点击一级菜单变色
    $('.oneLevel li').click(function(){
    	$(this).addClass('oneCuttom').siblings().removeClass('oneCuttom');
    })
    //点击二级菜单变色
    $('.twoLevel li').click(function(){
    	$(this).addClass('twoCuttom').siblings().removeClass('twoCuttom');
    })
    //点击显示上下架产品
    $('.characterBox .updown img').click(function(){
    	_this = $(this);
    	_this.closest('.sigleModule').siblings('.sigleModule').find('.stop').hide();
    	_this.closest('.sigleModule').siblings('.sigleModule').find('.updown').children('img').prop('src','/static/style_default/images/tips_05.png');
    	_this.closest('.sigleModule').siblings('.sigleModule').find('.updown').removeClass('none');
    	$(this).parent().siblings('.stop').toggle();


    	if(!$(this).parent('.updown').hasClass('none')){
    		$(this).prop('src','/static/style_default/images/tips_03.png');
    		$(this).parent('.updown').addClass('none');
    	}else{
    		$(this).prop('src','/static/style_default/images/tips_05.png');
    		$(this).parent('.updown').removeClass('none');
    	}

    	//点击空白上下架产品框消失
	    $('body').on('click',function(e){
	    	var target = $(e.target);
	    	if(target.closest('.characterBox .stop a').length == 0 && target.closest('.characterBox .up a').length == 0 && target.closest('.characterBox .updown img').length == 0){
	    		//$('.characterBox .stop').hide();
	    		_this.parent().siblings('.stop').hide();
                _this.prop('src','/static/style_default/images/tips_05.png');
		    	_this.parent('.updown').removeClass('none');

	    	}
	    })
    })

    //点击下架产品
    $('body').on('click','.characterBox .stop a',function(){
    	var _this = $(this);
    	var product_id = $(this).attr('value');
    	if($(this).parent().hasClass('up')){
    		//alert(0);
    		$('.deleSingle .p2 span').text('确定要上架产品吗？');
    		$('.deleSingle .p3 span').text('上架后，可重新下架此产品');
    		$('.deleSingle .p4').show();
    		$('.deleSingle').show();
    		//点击弹框的确定按钮
		    $('body').on('click','.deleSingle .sure',function(){
		    	$('.deleSingle').hide();
		    	_this.parent().removeClass('up');
		    	_this.parent().parent().parent().parent().removeClass('upModule');
		    	_this.find('span').text('下架产品');
				_this.parent().siblings('.updown').find('img').prop('src','/static/style_default/images/tips_05.png');
		        _this.parent().siblings('.updown').removeClass('none');
			    // 发送ajax请求
			    var pro_stock = $("input[name='pro_stock']").val();
			    $.ajax({
			    	url: 'package_add',
			    	type: 'POST',
			    	dataType: 'json',
			    	data: {product_id: product_id, pro_stock: pro_stock},
			    	success: function(res){
			    		console.log(res);
			    		if (res.code == 200) {
			    			// 显示库存和开关
			    			$('#tr_'+product_id).find('.stock').removeClass('isshow');
			    			$('#tr_'+product_id).find('.stock>span').html(pro_stock);
			    			$('#tr_'+product_id).find('.proswitch').removeClass('isshow');
							$('#tr_'+product_id).find('.proswitch').removeClass('stopOpen').addClass('open');
							$('#tr_'+product_id).find('.proswitch').children('span').text('启用');
							$('#tr_'+product_id).find('.proswitch').children('img').attr('src','/static/style_default/images/pro_10.png');
			    		}
			    	}
			    })
		    })
    	}else{
    		$('.deleSingle .p2 span').text('确定要下架产品吗？');
    		$('.deleSingle .p3 span').text('下架后，可重新上架此产品');
    		$('.deleSingle .p4').hide();
    		$('.deleSingle').show();
    		//点击弹框的确定按钮
		    $('body').on('click','.deleSingle .sure',function(){
		    	$('.deleSingle').hide();
		    	_this.parent().addClass('up');
		    	_this.parent().parent().parent().parent().addClass('upModule');
		    	_this.find('span').text('上架产品');
				_this.parent().siblings('.updown').find('img').prop('src','/static/style_default/images/tips_05.png');
		        _this.parent().siblings('.updown').removeClass('none');
		    	// 发送ajax请求
			    $.ajax({
			    	url: 'package_delete',
			    	type: 'POST',
			    	dataType: 'json',
			    	data: {product_id: product_id},
			    	success: function(res){
			    		console.log(res);
			    		if (res.code == 200) {
			    			// 显示库存和开关
			    			$('#tr_'+product_id).find('.stock').addClass('isshow');
			    			$('#tr_'+product_id).find('.proswitch').addClass('isshow');
			    		}
			    	}
			    })
		    })
    	}

    	//点击弹框的取消按钮
	    $('body').on('click','.deleSingle .think',function(){
	    	$('.deleSingle').hide();
	    })

    })

	//库存量
	$(".stock>img").click(function(){
		var $this=$(this);
		// var num=$this.parent().parent().parent().find(".characterBox>.stock>span").html();
		// Number(num);
		// if( $(this).hasClass("stockPrev") ){
		// 	num--;
		// 	if( num<=0 ){
		// 		$this.parent().parent().parent().find(".characterBox>.stock>span").html("0");
		// 	}else{
		// 		$this.parent().parent().parent().find(".characterBox>.stock>span").html(num);
		// 	}
		// }else if( $(this).hasClass("stockNext") ){
		// 	num++;
		// 	$this.parent().parent().parent().find(".characterBox>.stock>span").html(num);
		// }
		var product_id = $(this).parent('.stock').attr('value');
		var stock_num = $('#stock_'+product_id).html();
		console.log(product_id);
		if( $(this).hasClass("stockPrev") && stock_num > 0){
			stock_num = parseInt(stock_num) - 1;
		} else if ( $(this).hasClass("stockNext") ){
			stock_num = parseInt(stock_num) + 1;
		} else {
			stock_num = 0;
		}
		console.log(stock_num);
		// 发送ajax请求
		$.ajax({
			url: 'update_stock',
			type: 'POST',
			dataType: 'json',
			data: {product_id: product_id, stock_num: stock_num},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					$('#stock_'+product_id).html(stock_num);
				}
			}
		})
	});

})
