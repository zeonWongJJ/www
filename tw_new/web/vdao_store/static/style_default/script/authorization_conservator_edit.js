$(function(){
	// 勾选男女
	$('body').on('click','.formBox .sexItn',function(){
		if($(this).attr("checked")){
			if($(this).next('.pattern').html()=='男'){
				$('.ding1').css('background-image','url(/static/style_default/images/pro_36.png)');
				$('.ding2').css('background-image','url(/static/style_default/images/pro_38.png)');
			}else if($(this).next('.pattern').html()=='女'){
				$('.ding1').css('background-image','url(/static/style_default/images/pro_38.png)');
				$('.ding2').css('background-image','url(/static/style_default/images/pro_36.png)');
			}
		}
	})

	//勾选角色权限
	$('body').on('click','.role a',function(){
		$(this).addClass('gou').siblings().removeClass('gou');
		$("input[name='group_id']").val($(this).attr('value'));
	})

	 //表单验证
	 // 账户名
	 $('.accountInt').blur(function(){
	 	val = $(this).val();
	 	if(val==''){
	 		$(this).siblings('.red').show();
	 		$(this).siblings('.green').hide();
	 		$(this).data({'s':0});
	 	}else{
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red').hide();
	 		htmlText = 20 - parseInt(val.length);
	 		$(this).siblings('.green').find('i').html(htmlText);
	 		$(this).data({'s':1});
	 	}
	 })
	// 姓名
	$('.nameInt').blur(function(){
	 	val = $(this).val();
	 	if(val==''){
	 		$(this).siblings('.red').show();
	 		$(this).siblings('.green').hide();
	 		$(this).data({'s':0});
	 	}else{
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red').hide();
	 		htmlText = 20 - parseInt(val.length);
	 		$(this).siblings('.green').find('i').html(htmlText);
	 		$(this).data({'s':1});
	 	}
	 })
	//性别选择
	$('.sexItn').click(function(){
		$(this).parent().parent('.right').find ('.green').show();
		$(this).parent().parent('.right').find ('.red').hide();
		$("input[name='manager_sex']").val($(this).attr('ve'));
	})

	// 手机号码
	$('.phoneInt').click(function(){
		sexLength = $('.sexItn:checked').length;
		if(sexLength == 0){
			$('.sex .red').show();
			$('.sex .green').hide();
			$('.sexItn').data({'s':0})
		}
	})
	$('.phoneInt').blur(function(){
	 	val = $(this).val();
	 	if(val==''){
	 		$(this).siblings('.red1').show();
	 		$(this).siblings('.red2').hide();
	 		$(this).siblings('.green').hide();
	 		$(this).data({'s':0});
	 	}else if(!(/^1[34578]\d{9}$/.test(val))){
	 		$(this).siblings('.green').hide();
	 		$(this).siblings('.red1').hide();
	 		$(this).siblings('.red2').show();
	 		$(this).data({'s':0});
	 	}else{
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red1').hide();
	 		$(this).siblings('.red2').hide();
	 		$(this).data({'s':1});
	 	}
	 })
	//  邮箱
	$('.email').blur(function(){
	 	val = $(this).val();
	 	if(val==''){
	 		$(this).siblings('.red1').show();
	 		$(this).siblings('.red2').hide();
	 		$(this).siblings('.green').hide();
	 		$(this).data({'s':0});
	 	}else if(!(/^\w+@\w+\.\w+$/.test(val))){
	 		$(this).siblings('.green').hide();
	 		$(this).siblings('.red1').hide();
	 		$(this).siblings('.red2').show();
	 		$(this).data({'s':0});
	 	}else{
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red1').hide();
	 		$(this).siblings('.red2').hide();
	 		$(this).data({'s':1});
	 	}
	 })
	//密码
	$('.passInt').blur(function(){
	 	val = $(this).val();
	 	if(val==''){
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red').hide();
	 		$(this).data({'s':1});
	 		// $(this).siblings('.red').show();
	 		// $(this).siblings('.green').hide();
	 		// $(this).data({'s':0});
	 	}else{
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red').hide();
	 		$(this).data({'s':1});
	 	}
	 })
	//确认密码
	$('.againInt').blur(function(){
	 	val = $(this).val();
	 	passVal = $('.passInt').val();
	 	if(val==''){
	 		// $(this).siblings('.red1').show();
	 		// $(this).siblings('.red2').hide();
	 		// $(this).siblings('.green').hide();
	 		// $(this).data({'s':0});
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red1').hide();
	 		$(this).siblings('.red2').hide();
	 		$(this).data({'s':1});
	 	}else if(val!=passVal){
	 		$(this).siblings('.red1').hide();
	 		$(this).siblings('.red2').show();
	 		$(this).siblings('.green').hide();
	 		$(this).data({'s':0});
	 	}else{
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red1').hide();
	 		$(this).siblings('.red2').hide();
	 		$(this).data({'s':1});
	 	}
	 })
	//所属角色
	$('.roleRight .role a').click(function(){
		$('.roleRight .green').show();
		$('.roleRight .red').hide();
		$(this).data({'s':1});
		//$(this).siblings().data({'s':0});
	})
	//点击确定按钮
	$('.sureBox a').click(function(){
		var tot = 0;
		// 账号聚焦
		$('.accountInt').blur();
		//姓名聚焦
		$('.nameInt').blur();
		//性别
		sexLength = $('.sexItn:checked').length;
		if(sexLength == 0){
			$('.sex .red').show();
			$('.sex .green').hide();
		}else{
			tot+=1;
		}
		//手机号码
		$('.phoneInt').blur();
		//邮箱
		$('.email').blur();
		//密码
		 $('.passInt').blur();
		//确认密码
		$('.againInt').blur();
		//所属角色
		roleLength = $('.roleRight .role a.gou').length;
		if(roleLength == 0){
			$('.roleRight .red').show();
		}else{
			tot+=1;
		}
		//计算data
		$('.total').each(function(){
			tot+=$(this).data('s');
		})
		if(tot==8){
			// alert('提交表单');
			$("form").submit();
		}
	})
})


