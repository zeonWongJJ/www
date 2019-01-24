$(function(){
	//输入文字减少
	$('.traffic .txt').keydown(function(){
		var len = $(this).val().length;
		var num = 200 - len;
		$(this).siblings('.num').children('span:eq('+0+')').text(num);
		$(this).siblings('.num').children('span:eq('+0+')').css('color','red');
	})
	//输入产品获取到全部的相识的
	$('.product_name').bind('input propertychange', function() {
		$(".selectBox").show();
		$(".numDiv").hide();
		$(".content").removeClass('hide');
		$(".content").html("");
		var name = $(this).attr('value');
		if (name == "") {
			$(".content").addClass('hide');
		} else {
			$.ajax({
				type : 'post',
				data : {name:name},
				url  : 'consumable_add',
				dataType: "json",
				success : function(data) {
					var hte = "";
					$.each(data, function (n, value) {
		               hte += "<b value="+value.product_id+">"+value.product_name+"</b>";
		          	});
					$(".content").html(hte);			
				}
			})
		}
	})
	//选中产品名出现产品的杯型
	$('.content').click(function() {
		$("b").click(function() {
			var name = $(this).text();
			var id   = $(this).attr('value');
			$(".product_name").val(name);
			$("#product_id").val(id);
			$(".content").addClass('hide');
			// $(".tit").find('span').text('请选择杯型');
			//清空seletct的数据 
			$(".cup").empty(); 
			$.ajax({
				type : 'post',
				data : {cup_name:name},
				url  : 'consumable_add',
				dataType: "json",
				success : function(data) {
			  	  	//向select中append、option标签
	                var optionString = "";
	                //返回的json数据
	                var beanList = data;            
	                //判断
	                if(beanList){                   
	                    //遍历，动态赋值
	                    $.each(beanList, function(i, tex){ 
	                        //动态添加数据 
	                        optionString += "<a href='javascript:;' value="+tex.cup_id+">"+tex.cup_name+"</a>";
	                    }) 
	                    $(".cup").append(optionString);
	                     // 为当前name为asd的select添加数据。
	                } 	
				}
			})
		});
	})	
	//获取产品分类二级
	$('.id_1 a').click(function() {
		var id = $(this).attr('value');		
		$('.yin').text('请选择产品分类');
		$('.yin1').text('请选择产品分类');
		$('.yin2').text('请选择产品');
		$.ajax({
			type : 'post',
			url  : 'proid_id_2',
			data : {id:id},
			dataType : 'json',
			success  : function(data) {
				if (data != '') {
					var html = '';
					$.each(data, function(i, name) {
						html += '<a href="javascript:;" value="'+name.pro_id+'">'+name.pro_name+'</a>';
					})
					$(".id_2").html(html);
					$(".twoLev").removeClass('hide');
					$(".threeLev").addClass('hide');
				};
			}
		})
		$.ajax({
			type : 'post',
			url  : 'proid_goode',
			data : {id:id,shuwe:1},
			dataType : 'json',
			success  : function(data) {
				var html = '';
				$.each(data, function(i, name) {
					html += '<a href="javascript:;" value="'+name.product_id+'">'+name.product_name+'</a>';
				})
				$(".proid").html(html);
			}
		})
	})
	//获取产品分类三级
	$('.id_2').on('click','a',function() {
		var id = $(this).attr('value');
		$('.yin1').text('请选择产品分类');
		$('.yin2').text('请选择产品');
		$.ajax({
			type : 'post',
			url  : 'proid_id_3',
			data : {id:id},
			dataType : 'json',
			success  : function(data) {
				if (data != '') {
					var html = '';
					$.each(data, function(i, name) {
						html += '<a href="javascript:;" value="'+name.pro_id+'">'+name.pro_name+'</a>';
					})
					$(".id_3").html(html);
					$(".threeLev").removeClass('hide');
				};
			}
		})
		$.ajax({
			type : 'post',
			url  : 'proid_goode',
			data : {id:id,shuwe:2},
			dataType : 'json',
			success  : function(data) {
				var html = '';
				$.each(data, function(i, name) {
					html += '<a href="javascript:;" value="'+name.product_id+'">'+name.product_name+'</a>';
				})
				$(".proid").html(html);
			}
		})
	})
	//获取选中的3级产品
	$('.id_3').on('click','a',function() {
		var id = $(this).attr('value');
		$('.yin2').text('请选择产品');
		$.ajax({
			type : 'post',
			url  : 'proid_goode',
			data : {id:id,shuwe:3},
			dataType : 'json',
			success  : function(data) {
				var html = '';
				$.each(data, function(i, name) {
					html += '<a href="javascript:;" value="'+name.product_id+'">'+name.product_name+'</a>';
				})
				$(".proid").html(html);
			}
		})
	})
	//选择杯型
	$('.proid').on('click','a',function() {
		var name = $(this).text();
		var id   = $(this).attr('value');
		$('#product_id').val(id);
		//清空seletct的数据 
		$(".cup").empty(); 
		$.ajax({
			type : 'post',
			data : {cup_name:name},
			url  : 'consumable_add',
			dataType: "json",
			success : function(data) {
		  	  	//向select中append、option标签
                var optionString = "";
                //返回的json数据
                var beanList = data;            
                //判断
                if(beanList){                   
                    //遍历，动态赋值
                    $.each(beanList, function(i, tex){ 
                        //动态添加数据 
                        optionString += "<a href='javascript:;' value="+tex.cup_id+">"+tex.cup_name+"</a>";
                    }) 
                    $(".cup").append(optionString);
                    // 为当前name为asd的select添加数据。
                } 	
			}
		})
	})
	//获取耗材2级
	$('.haoc1 a').click(function(){
		var id = $(this).attr('value');
		$('#haoc2').text('请选择耗材分类');
		$('#haoc3').text('请选择耗材分类');
		$('#haoc4').text('请选择耗材名称');
		$.ajax({
			type : 'post',
			url  : 'haoc_id_2',
			data : {id:id},
			dataType : 'json',
			success  : function(data) {
				if (data != '') {
					var html = '';
					$.each(data, function(i, name) {
						html += '<a href="javascript:;" value="'+name.id+'">'+name.cons_name+'</a>';
					})
					$(".haoc2").html(html);
					$(".twoLev").removeClass('hide');
					$(".threeLev").addClass('hide');
				};
			}
		})
		$.ajax({
			type : 'post',
			url  : 'haoc_name',
			data : {id:id,con:1},
			dataType : 'json',
			success  : function(data) {
				var html = '';
				$.each(data, function(i, name) {
					html += '<a href="javascript:;" value="'+name.consumption_id+'">'+name.consu_name+'</a>';
				})
				$(".haoc4").html(html);
			}
		})
	})
	//获取耗材3级
	$('.haoc2').on('click','a',function() {
		var id = $(this).attr('value');
		$('#haoc3').text('请选择耗材分类');
		$('#haoc4').text('请选择耗材名称');
		$.ajax({
			type : 'post',
			url  : 'haoc_id_3',
			data : {id:id},
			dataType : 'json',
			success  : function(data) {
				if (data != '') {
					var html = '';
					$.each(data, function(i, name) {
						html += '<a href="javascript:;" value="'+name.id+'">'+name.cons_name+'</a>';
					})
					$(".haoc3").html(html);
					$(".threeLev").removeClass('hide');
				};
			}
		})
		$.ajax({
			type : 'post',
			url  : 'haoc_name',
			data : {id:id,con:2},
			dataType : 'json',
			success  : function(data) {
				var html = '';
				$.each(data, function(i, name) {
					html += '<a href="javascript:;" value="'+name.consumption_id+'">'+name.consu_name+'</a>';
				})
				$(".haoc4").html(html);
			}
		})
	})
	//获取耗材名
	$('.haoc3').on('click','a',function() {
		var id = $(this).attr('value');
		$('#haoc4').text('请选择耗材名称');
		$.ajax({
			type : 'post',
			url  : 'haoc_name',
			data : {id:id,con:3},
			dataType : 'json',
			success  : function(data) {
				var html = '';
				$.each(data, function(i, name) {
					html += '<a href="javascript:;" value="'+name.consumption_id+'">'+name.consu_name+'</a>';
				})
				$(".haoc4").html(html);
			}
		})
	})
	// 数量
	$('.haoc4').on('click','a',function() {
		var id = $(this).attr('value');
		$('.conte').val(id);
		$('.sInt').text('');
	})
	//所有下拉
	$('body').on('click','.chooseL .selectBox .tit',function(){		
		$(this).siblings('.select').slideToggle();
		$(this).toggleClass('down');		
	})
	//所有下拉选择
	$('body').on('click','.chooseL .selectBox .select a',function(){		
		var aText = $(this).text();
		$(this).parent().siblings('.tit').find('span').text(aText);
		$(this).parent('.select').slideUp();
		$(this).parent().siblings('.tit').removeClass('down');
		$('.chooseL .selectBox .beixing').hide();		
	})
	//点击空白下拉消失
	$('body').on('click',function(e){
    	var target = $(e.target);
    	if(target.closest('.chooseL .selectBox .tit').length == 0 && target.closest('.chooseL .selectBox .select').length == 0 && target.closest('.intRea .selPic').length == 0 ){
    		$('.chooseL .selectBox .select').slideUp();
    		$('.chooseL .selectBox .tit').removeClass('down');
    	}
    })
	
	//产品选择杯型后数量框出现
	$('body').on('click','.productBox1 .cupSelect .select a',function(){
		$(this).closest('.nameDiv').siblings('.numDiv').show();
		var cup_id = $(this).attr("value");
		var pro    = $(".product_name").val();
		$('#cup').val(cup_id);
		$.ajax({
			type : 'post',
			url  : 'consumable_add',
			data : {cup_id:cup_id,pro_name:pro},
			dataType : 'json',
			success  : function(data) {
				var con =   '<div class="sigleNum proNum">'
								+'<span class="sNum">数量</span>'
								+'<div class="intL">'
									+'<input type="text" class="sInt oute" />&nbsp;&nbsp;份'
								+'</div>'
								+'<span class="sTips">标准份数为<s>10</s>份，减少了<i>5</i>份</span>'
								+'<span class="sTips2">请填写份数，不需要时写<i>0</i></span>'
								+'<span class="sTips3">标准份数为<s>10</s>份，增加了<i>5</i>份</span>'
							+'</div>';
				$.each(data, function(n, name) {
					con +=  '<div class="sigleNum marNum">'
								+'<span class="sNum" value="'+name.consumption_id+'"><s>'+name.consu_name+'</s></span>'
								+'<div class="intL">'
									+'<input type="text" class="sInt" />&nbsp;&nbsp;份'
								+'</div>'
								+'<span class="sTips">标准份数为<s>10</s>份，减少了<i>5</i>份</span>'
								+'<span class="sTips2">请填写份数，不需要时写<i>0</i></span>'
								+'<span class="sTips3">标准份数为<s>10</s>份，增加了<i>5</i>份</span>'
							+'</div>';
				});
				$('#consumption').html(con);
			}
		})
	})

	//耗材选择最后一个下拉后数量框出现
	$('body').on('click','.materialBox .moreBox .selectBox:last-child .select a',function(){
		$(this).closest('.nameDiv').siblings('.numDiv').show();
	})
	
	//点击按产品添加显示添加框
	$('body').on('click','.chooseLi .product',function(){
		$('.chooseLi .materialBox').hide();
		$('.chooseLi .productBox1').show();
	})
	
	//点击按耗材显示添加框
	$('body').on('click','.chooseLi .material',function(){
		$('.chooseLi .materialBox').show();
		$('.chooseLi .productBox1').hide();
	})

	//填写数量其它分数变成一样
	$('.oute').live('input propertychange', function() {
		var out = $(this).val();
		$('.sInt').val(out);
	})

	//填写数量失去焦点
	$('body').on('blur','.materialBox .sInt',function(){// 耗材的
		var val = $(this).val();
		if(val == ''){
			$(this).parent().siblings('.sTips2').show();
			$(this).data({'s':0});
		}else{
			$(this).parent().siblings('.sTips2').hide();
			$(this).data({'s':1});
		}
	})
	$('body').on('blur','.productBox1 .proNum .sInt',function(){//产品的
		var val = $(this).val();
		if(val == ''){
			$(this).parent().siblings('.sTips2').show();
			$(this).data({'s':0});
		}else{
			$(this).parent().siblings('.sTips2').hide();
			$(this).data({'s':1});
		}
		$('.productBox1 .marNum .sInt').blur();
	})
	$('body').on('blur','.productBox1 .marNum .sInt',function(){//产品的
		var val = $(this).val();
		if(val == ''){
			val = $(this).val();
		}else if(val == 0){
			val == 0;
		}else{
			val = parseInt($(this).val());
		}
		var proNum = parseInt($('.productBox1 .proNum .sInt').val());
		if(val == ''){
			$(this).parent().siblings('.sTips').hide();
			$(this).parent().siblings('.sTips3').hide();
			$(this).parent().siblings('.sTips2').show();	
			$(this).data({'s':0});
		}else if(val < proNum){
			$(this).parent().siblings('.sTips').show();
			var iText = proNum - val;
			$(this).parent().siblings('.sTips').find('i').text(iText);
			$(this).parent().siblings('.sTips').find('s').text(proNum);
			$(this).parent().siblings('.sTips2').hide();
			$(this).parent().siblings('.sTips3').hide();
			$(this).data({'s':1});
		}else if(val == proNum){			
			$(this).parent().siblings('.sTips').hide();
			$(this).parent().siblings('.sTips2').hide();
			$(this).parent().siblings('.sTips3').hide();
			$(this).data({'s':1});
		}else if(val > proNum){
			$(this).parent().siblings('.sTips3').show();
			var iText = val - proNum;
			$(this).parent().siblings('.sTips3').find('i').text(iText);
			$(this).parent().siblings('.sTips3').find('s').text(proNum);
			$(this).parent().siblings('.sTips2').hide();
			$(this).parent().siblings('.sTips').hide();
			$(this).data({'s':1});
		}
	})
	
	//按产品添加的保存按钮
	$('.productBox1 .controlBox .save').click(function(){
		var tot = 0;
		$('.productBox1 .proNum .sInt').blur();
		$('.productBox1 .marNum .sInt').blur();
		var beiText = $('.chooseL .cupSelect .tit span').text();
		if(beiText == '请选择杯型'){
			$('.chooseL .selectBox .beixing').show();
		}else{
			$('.chooseL .selectBox .beixing').hide();
			tot += 1;
		}
		$('.productBox1 .sInt').each(function(){
			tot+=$(this).data('s');	
		})
		var sintLen = $('.productBox1').find('.sInt').length;
		var intLen = sintLen + 1;
		if(tot == intLen && $('.productBox1 .inputL .int').val() != ''){
			//产品添加到右边去
			var proVal = $('.productBox1 .inputL .int').val();//产品名称
			var provid = $('#product_id').val();
			var beixing =$('.productBox1 .cupSelect .tit span').text();//杯型
			var cup_id = $('#cup').val();
			var proNum = $('.productBox1 .proNum .sInt').val();//产品数量
			var marLen = $('.productBox1 .marNum').length;
			var str = '<div class="singleAdd"><ul><li class="first"><span class="addName"><s>'+proVal+'</s>（<i>'+beixing+'</i>）</span><span class="addNum"><s>'+proNum+'</s>份</span><span class="addCon"><a href="javascript:;" class="delete"></a><a href="javascript:;" class="edit"></a></span><input type="hidden" name="cons[1]['+provid+']['+cup_id+'][i]" value="'+proNum+'" id="cons1"></li>'
			for(var i = 0; i < marLen; i ++){
				var marName = $('.productBox1 .marNum:eq('+i+')').find('.sNum').text();//耗材名称
				var marid = $('.productBox1 .marNum:eq('+i+')').find('.sNum').attr('value');//耗材id
				var marNum = $('.productBox1 .marNum:eq('+i+')').find('.sInt').val();//耗材数量
				str += '<li class="second"><span class="addName" value="'+marid+'"><s>'+marName+'</s></span><span class="addNum"><s>'+marNum+'</s>份</span><input type="hidden" name="cons[1]['+provid+']['+cup_id+']['+marid+']" value="'+proNum+'" id="cons"></li>'
					
			}				
	 		str += '</ul></div>'			
	 		$('.productAdd1').append(str);			
	 		//添加后val值清空；
	 		$('.productBox1 .inputL .int').val('');
	 		$('.productBox1 .cupSelect .tit span').text('请选择杯型');	
	 		$('.productBox1 .cupSelect').hide();
	 		$('.productBox1 .proNum .sInt').val('');
	 		$('.productBox1 .moreBox .selectBox .tit span').text('');
	 		for(var i = 0; i < marLen; i ++){				
				var marNum = $('.productBox1 .marNum:eq('+i+')').find('.sInt').val('');//耗材数量				
			}
	 		$('.productBox1 .numDiv').find('.sTips').hide();
	 		$('.productBox1 .numDiv').find('.sTips3').hide();
	 		$('.productBox1 .numDiv').hide();
		}
	})
	//按耗材添加的保存按钮
	$('.materialBox .controlBox .save1').click(function(){
		var tot = 0;
		$('.materialBox .sInt').blur();		
		if($('.materialBox .intL .sInt').val() != '' && $('.materialBox .inputL .int').val() != ''){
			//耗材添加到右边去
			var proVal = $('.materialBox .inputL .int').val();//耗材名称			
			var proid  = $('.materialBox .inputL .conte').val();//耗材id			
			var proNum = $('.materialBox .intL .sInt').val();//产品数量			
			if($('.materialAdd').children().is('.matTitle') == false){
				$('.materialAdd').append(
					'<p class="matTitle">单独添加耗材</p>'
		 			+'<div class="singleAdd">'
		 				+'<ul>'
		 					+'<li>'
		 						+'<span class="addName">'+proVal+'</span>'
		 						+'<span class="addNum"><s>'+proNum+'</s>份</span>'
		 						+'<input type="hidden" name="cons[2]['+proid+']" value="'+proNum+'" id="out">'
		 						+'<span class="addCon">'
		 							+'<a href="javascript:;" class="delete"></a>'
					                +'<a href="javascript:;" class="edit"></a>'
		 						+'</span>'
		 					+'</li>'	 							 					
		 				+'</ul>'
		 			+'</div>'
				)
				//添加后清空值
				$('.materialBox .inputL .int').val('');
				$('.materialBox .intL .sInt').val('');
				$('.materialBox .numDiv').find('.sTips').hide();
				$('.materialBox .moreBox .selectBox .tit span').text('');
				$('.materialBox .numDiv').hide();
			}else{
				$('.materialAdd').find('.singleAdd').find('ul').append(
					'<li>'
 						+'<span class="addName">'+proVal+'</span>'
 						+'<span class="addNum"><s>'+proNum+'</s>份</span>'
 						+'<input type="hidden" name="cons[2]['+proid+']" value="'+proNum+'" id="out">'
 						+'<span class="addCon">'
 							+'<a href="javascript:;" class="delete"></a>'
			                +'<a href="javascript:;" class="edit"></a>'
 						+'</span>'
 					+'</li>'
				)
				//添加后清空值
				$('.materialBox .inputL .int').val('');
				$('.materialBox .intL .sInt').val('');
				$('.materialBox .numDiv').find('.sTips').hide();
				$('.materialBox .moreBox .selectBox .tit span').text('');
				$('.materialBox .numDiv').hide();
			}	 		
		}
	})
	
	//产品添加的取消按钮
	$('.productBox1 .controlBox .cancel').click(function(){
		//alert(0);
		var marLen = $('.productBox1 .marNum').length;
		$('.productBox1 .inputL .int').val('');//产品名
 		$('.productBox1 .cupSelect .tit span').text('请选择杯型');//杯型	
 		$('.chooseL .selectBox .beixing').hide();//杯型提示语
 		$('.productBox1 .cupSelect').hide();
 		$('.productBox1 .proNum .sInt').val('');//耗材名
 		$('.productBox1 .moreBox .selectBox .tit span').text('');//多级下拉
 		for(var i = 0; i < marLen; i ++){				
			var marNum = $('.productBox1 .marNum:eq('+i+')').find('.sInt').val('');//耗材数量				
		}
 		$('.productBox1 .numDiv').find('.sTips').hide();
 		$('.productBox1 .numDiv').find('.sTips3').hide();
 		$('.productBox1 .numDiv').hide();
 		$('.productBox1 .numDiv .sTips,.productBox1 .numDiv .sTips2,.productBox1 .numDiv .sTips3').hide();//提示语
 		$('.chooseLi .productBox1').hide();//产品框消失
	})
	
	//点击耗材的取消按钮
	$('.materialBox .controlBox .cancel1').click(function(){
		$('.materialBox .inputL .int').val('');
		$('.materialBox .intL .sInt').val('');
		$('.materialBox .numDiv').find('.sTips').hide();
		$('.materialBox .moreBox .selectBox .tit span').text('');
		$('.materialBox .numDiv').hide();
		$('.materialBox .numDiv .sTips,.materialBox .numDiv .sTips2').hide();
		$('.chooseLi .materialBox').hide();//耗材框消失
	})
	
	//删除产品添加的耗材申请
	$('body').on('click','.productAdd1 li .delete',function(){
		var _this = $(this);
		$('.deleBomb').show();
		//弹框确定确定按钮
		$('.deleBomb .sure').click(function(){
			_this.closest('.singleAdd').remove();
			$('.deleBomb').hide();
		})
		//弹框的取消按钮
		$('.deleBomb .think').click(function(){			
			$('.deleBomb').hide();
		})
	})
	
	//删除 耗材添加的耗材申请
	$('body').on('click','.materialAdd li .delete',function(){
		var _this = $(this);
		$('.deleBomb').show();
		//弹框确定确定按钮
		$('.deleBomb .sure').unbind('click').click(function(){
			var tIndex = _this.closest('li').index();
			//alert(tIndex);
			if(tIndex == 0){				
				_this.closest('.singleAdd').siblings('.matTitle').remove();
				_this.closest('.singleAdd').remove();
				$('.deleBomb').hide();
			}else{
				_this.closest('li').remove();
				$('.deleBomb').hide();
			}
			
		})
		//弹框的取消按钮
		$('.deleBomb .think').unbind('click').click(function(){			
			$('.deleBomb').hide();
		})
	})
	
	//点击产品的编辑按钮
	$('body').on('click','.productAdd1 li .edit',function(){
		$('.productBox1 .controlBox .save').hide();//添加到右边的保存按钮隐藏
		$('.productBox1 .controlBox .saveEdit').show();//编辑的保存按钮显示
		var _this = $(this);
		$('.productBox1 .numDiv').show();
		$('.productBox1 .numDiv .marNum').remove()//清空左边的值
		var liLen = $(this).parent().parent().siblings('.second').length;
		var proName = $(this).parent().siblings('.addName').find('s').text();//产品名称
		var beixing = $(this).parent().siblings('.addName').find('i').text();//杯型 
		var proNum = $(this).parent().siblings('.addNum').find('S').text();//产品数量
		var nameArr = [];//获取耗材名称		
		var numArr = [];//获取耗材数量3
		// var numid = [];//获取耗材id
		for(var i = 0; i < liLen; i ++){
			var iName = $(this).parent().parent().siblings('.second:eq('+i+')').find('.addName').find('s').text();
			nameArr.push(iName);
		}
		for(var j = 0; j < liLen; j ++){
			var jNum = $(this).parent().parent().siblings('.second:eq('+j+')').find('.addNum').find('s').text();
			numArr.push(jNum);
		}
		// for(var j = 0; j < liLen; j ++){
		// 	var jNumid = $(this).parent().parent().siblings('.second:eq('+j+')').find('.addName').attr('value');//耗材id
		// 	// console.log(jNumid);
		// 	numid.push(jNumid);
		// }
		$('.chooseLi .productBox1').show()//产品框显示
		$('.productBox1 .cupSelect').show()//杯型显示
		$('.chooseLi .materialBox').hide()//耗材框隐藏
		$('.productBox1 .numDiv').show();
		$('.productBox1 .numDiv').empty();
		$('.productBox1 .numDiv').append(
			'<div class="sigleNum proNum">'
				+'<span class="sNum"><s>数量</s></span>'
				+'<div class="intL">'
					+'<input type="text" class="sInt oute" />&nbsp;&nbsp;份'
				+'</div>'
				+'<span class="sTips">标准份数为<s>10</s>份，减少了<i>5</i>份</span>'
				+'<span class="sTips2">请填写份数，不需要时写<i>0</i></span>'
				+'<span class="sTips3">标准份数为<s>10</s>份，增加了<i>5</i>份</span>'
			+'</div>'
		);

		//添加左边的值
		$('.productBox1 .inputL .int').val(proName);
		$('.productBox1 .cupSelect .tit span').text(beixing);
		$('.productBox1 .proNum .sInt').val(proNum);
		var str = '';
		for(var f = 0; f < nameArr.length; f ++){
			var fName = nameArr[f];
			str += '<div class="sigleNum marNum"><span class="sNum"><s>'+fName+'</s></span><div class="intL"><input type="text" class="sInt" />&nbsp;&nbsp;份</div><span class="sTips">标准份数为<s>10</s>份，减少了<i>5</i>份</span><span class="sTips2">请填写份数，不需要时写<i>0</i></span><span class="sTips3">标准份数为<s>10</s>份，增加了<i>5</i>份</span></div>'
		}
		$('.productBox1 .numDiv .proNum').after(str);
		for(var i = 0; i < nameArr.length; i ++){				
			var marNum = numArr[i];
			$('.productBox1 .marNum:eq('+i+')').find('.sInt').val(marNum);//耗材数量
		}
		// for(var i = 0; i < nameArr.length; i ++){				
		// 	var marid = numid[i];
		// 	// console.log(marid);
		// 	$('.productBox1 .marNum:eq('+i+') .sNum').attr('value', marid);//耗材id
		// }
		$('.productBox1 .controlBox .saveEdit').unbind('click').click(function(){
			//再重新获取数据
			var proName = $('.productBox1 .inputL .int').val();//产品名称
			var proid   = $('.productBox1 .inputL #product_id').val();//产品di
			var beixing = $('.productBox1 .cupSelect .tit span').text();//杯型
			var cupid   = $('.productBox1 .cupSelect #cup').val();//杯型
			var proNum = $('.productBox1 .proNum .sInt').val();//产品数量
			// console.log(proid);
			// console.log(cupid);
			// var haoid = [];
			var haoNum = [];
			for(var i = 0; i < nameArr.length; i ++){
				var numText = $('.productBox1 .marNum:eq('+i+') .sInt').val();
				haoNum.push(numText);
			}
			// for(var i = 0; i < nameArr.length; i ++){
			// 	var numid = $('.productBox1 .marNum:eq('+i+') .sNum').attr('value');//耗材id//耗材id
			// 	// console.log(numid);
			// 	haoid.push(numid);
			// }
			//判断条件
			var sintLen = $('.productBox1').find('.sInt').length;
			var tot = 0;
			$('.productBox1 .proNum .sInt').blur();
			$('.productBox1 .marNum .sInt').blur();
			$('.productBox1 .sInt').each(function(){
				tot+=$(this).data('s');	
			})
			if(tot == sintLen && $('.productBox1 .int').val() != ''){
				//放到右边
				_this.parent().siblings('.addName').find('s').text(proName);//产品名称
				_this.parent().siblings('.addName').find('i').text(beixing);//杯型 
				_this.parent().siblings('.addNum').find('S').text(proNum);//产品数量
				// _this.parent().siblings('#cons1').prop("name","cons[1]["+proid+"]["+cupid+"][i]");//产品id
				_this.parent().siblings('#cons1').val(proNum);//产品数量
				for(var j = 0; j < liLen; j ++){//耗材数量
					var jText = haoNum[j];
					_this.parent().parent().siblings('.second:eq('+j+')').find('.addNum').find('s').text(jText);
					_this.parent().parent().siblings('.second:eq('+j+')').find('#cons').val(jText);
					// _this.parent().parent().siblings('.second:eq('+j+')').find('#cons').prop("name","cons[1]["+proid+"]["+cupid+"]["+numid+"]");
				}
				//保存后清空值
				$('.productBox1 .inputL .int').val('');//产品名称
				$('.productBox1 .cupSelect .tit span').text('请选择杯型');//杯型值
				$('.productBox1 .proNum .sInt').val('');//产品数量
				$('.productBox1 .cupSelect').hide();//隐藏杯型
				$('.productBox1 .moreBox .selectBox .tit span').text('');//多选框
				for(var i = 0; i < nameArr.length; i ++){				
					$('.productBox1 .marNum:eq('+i+')').find('.sInt').val('');//耗材数量				
				}
				$('.productBox1 .numDiv').hide();//数量填写框隐藏
				$('.productBox1 .controlBox .save').show();
				$('.productBox1 .controlBox .saveEdit').hide();
			}
			
		})	
		//点击取消按钮
		$('.productBox1 .controlBox .cancel').click(function(){
			$('.productBox1 .controlBox .save').show();
		    $('.productBox1 .controlBox .saveEdit').hide();
		})
	})
	
	//点击耗材的编辑按钮
	$('body').on('click','.materialAdd li .edit',function(){		
		$('.materialBox .controlBox .save1').hide();
		$('.materialBox .controlBox .saveEdit1').show();
		var _this = $(this);
		$('.chooseLi .productBox1').hide()//产品框隐藏
		$('.chooseLi .materialBox').show()//耗材框显示
		$('.materialBox .numDiv').show();//数量框
		var matName = $.trim($(this).parent().siblings('.addName').text());//耗材名称
		var matid   = $(this).parent().siblings('#out').val()//耗材id
		var matNum = $(this).parent().siblings('.addNum').find('S').text();//耗材数量
		$('.materialBox .controlBox .save').unbind('click');
		//值放到左边
		$('.materialBox .nameDiv .int').val(matName);
		// $('.materialBox .nameDiv .conte').val(matid);
		$('.materialBox .numDiv .sInt').val(matNum);
		$('.materialBox .controlBox .saveEdit1').unbind('click').click(function(){
			$('.materialBox .sInt').blur();	
			//重新获取数据
			var matName = $('.materialBox .nameDiv .int').val();
			var proid  = $('.materialBox .inputL .conte').val();//耗材id
			var matNum = $('.materialBox .numDiv .sInt').val();
			//放到右边 
			if(matName != '' && matNum != ''){
				_this.parent().siblings('.addName').text(matName);
				_this.parent().siblings('.addNum').find('S').text(matNum);
				_this.parent().siblings('#out').val(matNum);
				//保存后清空值
				$('.materialBox .nameDiv .int').val('');
				$('.materialBox .numDiv .sInt').val('');
				$('.materialBox .numDiv').hide();
				$('.materialBox .moreBox .selectBox .tit span').text('');//多选框
				$('.materialBox .controlBox .save1').show();
		        $('.materialBox .controlBox .saveEdit1').hide();
			}
			
		})
		//点击取消按钮
		$('.materialBox .controlBox .cancel1').click(function(){
			$('.materialBox .controlBox .save1').show();
		    $('.materialBox .controlBox .saveEdit1').hide();
		})
	})
	
	
	//点击    产品的下拉图片显示四级筛选框
	$('.productBox1 .intRea .selPic').click(function(){
		$(this).parent('.intRea').hide();
	 	$(this).parent().siblings('.chooseL').find('.moreBox').show();
	 	$('.productBox1 .chooseL .moreBox .oneLev .select').show();//四级下拉中的一级下拉显示
	 	$('.productBox1 .cupSelect').hide()// 杯型隐藏
	})
	 	 
	//当选择   产品最后一个下拉时又显示回输入框
	$('body').on('click','.productBox1 .moreBox .selectBox:last-child .select a',function(){
		var curText = $(this).text();// 最后一个下拉选择的值
		$('.productBox1 .intRea .int').val(curText);
		$('.productBox1 .moreBox').hide();//四级隐藏
		$('.productBox1 .intRea').show();//输入框显示
		$('.productBox1 .cupSelect').show()// 杯型显示
	})
	
	//点击    耗材的下拉图片显示四级筛选框
	$('.materialBox .intRea .selPic').click(function(){
		$(this).parent('.intRea').hide();
	 	$(this).parent().siblings('.chooseL').find('.moreBox').show();
	 	$('.materialBox .chooseL .moreBox .oneLev .select').show();//四级下拉中的一级下拉显示
	 	$('.materialBox .cupSelect').hide()// 杯型隐藏
	})
	 	 
	//当选择   耗材最后一个下拉时又显示回输入
	$('body').on('click','.materialBox .moreBox .selectBox:last-child .select a',function(){
		var curText = $(this).text();// 最后一个下拉选择的值
		$('.materialBox .intRea .int').val(curText);
		$('.materialBox .moreBox').hide();//四级隐藏
		$('.materialBox .intRea').show();//输入框显示
		$('.materialBox .cupSelect').show()// 杯型显示
	})
	
	//确定申请按钮	
	$('.basicBox .saveBox #cateSub').click(function(){
		var total = 0;
		var proLen = $('.productAdd1').find('li').length;//产品添加的长度
		var matLen = $('.materialAdd').find('li').length;//耗材添加的长度
		var mobileLen = $('.phone .mobile').val().length;//手机
		var callLen = $('.phone .call').val().length;//固定电话
		var mobile = $('.phone .mobile').val();
		var call = $('.phone .call').val();
		//alert(mobileLen);
		if(proLen == 0 && matLen == 0){
			$('.chooseLi .tipsBox .red').show();
			$('.chooseLi').data({'b':0});
		}else{
			$('.chooseLi .tipsBox .red').hide();
			$('.chooseLi').data({'b':1});
		}
		if(mobileLen == 11 || callLen == 8 || callLen == 12 || callLen == 11){			
			$('.phone .tipsBox .red').hide();
			$('.phone').data({'b':1});
		}else if(mobile !== '' || call !== ''){
			$('.phone .tipsBox .red').show();
			$('.phone .tipsBox .red').html('<i></i>联系电话格式不对');
			$('.phone').data({'b':0});
		}else{
			$('.phone .tipsBox .red').show();
			$('.phone .tipsBox .red').html('<i></i>请至少输入一个联系电话');
			$('.phone').data({'b':0});
		}
		$('.basicBox .bLeft .total').each(function(){
			total += $(this).data('b');
		});
		if(total == 0 || total == 1){
			return false;
		}
		if(total == 2){
			$('#cateSub').submit();
			$('.phone .mobile').val('');
			$('.phone .call').val('');
		}
	})
})

