
$(function(){
	//点击右边导航
	$('.rdR ul li').click(function(){
		$(this).addClass('rCurrent').siblings().removeClass('rCurrent');
	})
	//选择类型
	$('body').on('click','.chooseBox .component li',function(){
		submit_product_id = $(this).attr('product_id');
		submit_price_id = $(this).attr('price_id');
		$("#product_price").html($(this).attr('price'));
		$(this).addClass('xCurrent').siblings().removeClass('xCurrent');
	})
	//选择口味
	$('body').on('click','.chooseBox .taste li',function(){
		$(this).addClass('xCurrent').siblings().removeClass('xCurrent');
	})
	//选择属性
	$('body').on('click','.chooseBox .temperature li',function(){
		var $this=$(this);
		submit_attr += "|" + $(this).attr('attr_id');
		$this.addClass('xCurrent').siblings().removeClass('xCurrent');
	});
	
	function eleEach(){
		$(".temperature>div").each(function(i){
			$(this).addClass("type_"+i);
		})
	}
	
	// 选择数量
	$('body').on('click','.chooseBox .number select',function(){
		submit_num = $(this).val();
		$(this).addClass('xCurrent').siblings().removeClass('xCurrent');
	})
	// 数量操作，增加和减少
	$('body').on('click','.oRight a',function(){
		cart_add_subtract($(this).attr('product_index'), $(this).attr('class'));
	})

	//显示点菜弹框
	$('body').on('click','.rDown .lList .produc',function(){
		submit_attr = '';
		$('.chooseBox label').html('');
		$('.chooseBox label').prepend(a_product[$(this).attr('product_id')]['detail']);
		$('.imgBox img').attr("src", a_product[$(this).attr('product_id')]['img']);
		submit_product_id = $(this).attr('product_id');
		submit_price_id = $(this).attr('price_id');
		eleEach();
		$('.detailBomb').show();
		$("#product_price").html($('.detailBomb  .clearfix .xCurrent').attr('price'));
	})
	//关闭
	$('body').on('click','.detailBomb .dClose',function(){
		$('.detailBomb').hide();
	})
})

