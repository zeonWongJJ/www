$(function(){

	//勾选男女
	$('body').on('click','.formBox .sexItn',function(){
		if($(this).attr("checked")){
			if($(this).next('.pattern').html()=='是'){
				$('.ding1').css('background-image','url(/static/style_default/images/pro_36.png)');
				$('.ding2').css('background-image','url(/static/style_default/images/pro_38.png)');
			}else if($(this).next('.pattern').html()=='否'){
				$('.ding1').css('background-image','url(/static/style_default/images/pro_38.png)');
				$('.ding2').css('background-image','url(/static/style_default/images/pro_36.png)');
			}
		}
	})

	//勾选角色权限
	$('body').on('click','.rRight a',function(){
		$(this).toggleClass('gou');
		group_auth_all();
	})

	function group_auth_all() {
	    var role_auth = new Array();
	    var i = 0;
	    // 组装权限ids
	    $('.rRight .gou').each(function(index, el) {
	        role_auth[i] = $(this).attr('value');
	        i++;
	    });
	    role_auth = role_auth.join('-')
	    $("input[name='group_auth']").val(role_auth);
	}

	 //表单验证
	//角色名称
	$('.roleInt').blur(function(){
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
		$("input[name='group_state']").val($(this).attr('ve'));
	})
	//角色描述
	$('.txt').click(function(){
		roleFun();
	})
	 $('.txt').blur(function(){
	 	val = $(this).val();
	 	if(val==''){
	 		$(this).siblings('.red').show();
	 		$(this).siblings('.green').hide();
	 	}else{
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red').hide();
	 	}
	 })

	 //点击确定按钮
	 $('.sureBox a').click(function(){
	 	//角色名称
	 	$('.roleInt').blur();
	 	//性别选择
	 	roleFun();
	 	//角色描述
	 	$('.txt').blur();
	 	//所属角色
	 	var tot = 0;
	 	$('.roleList .rRight').each(function(){
	 		var len = $(this).find('a.gou').length;
			if(len>0){
				tot+=1;
			}
	 	})
	 	var rLength = $('.roleList .rRight').length;
	 	if(tot < rLength){
	 		$('.choiceRole .right .red').show();
	 		$('.choiceRole .right .green').hide();
	 	}else if(tot == rLength){
	 		$('.choiceRole .right .green').show();
	 		$('.choiceRole .right .red').hide();
	 		$("form").submit();
	 	}
	 })
})

//角色判断
 function roleFun (){
 	sexLength = $('.sexItn:checked').length;
	if(sexLength == 0){
		$('.sex .red').show();
		$('.sex .green').hide();
	}
 }


