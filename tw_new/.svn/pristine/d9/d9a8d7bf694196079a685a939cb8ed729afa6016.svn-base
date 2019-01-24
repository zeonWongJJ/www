$(function(){
	//鼠标聚焦第一个
	$('.intDiv .int:first-child').focus();
	//输入密码自动跳去下一个
	$('.intDiv .int').keyup(function(){
		var valLen = $(this).val().length;
		var tIndex = $(this).index();
		if(valLen == 1){
			$(this).next('.int').focus();
		}
		if(tIndex == 5){
			$(this).blur();
		}
	})
	
	//新加的JS
	//点击第一步的下一步
	$('body').on('click','.typeBox .one .submit',function(){
		$('.typeBox .two').show();
		$(".typeBox .two .intDiv").children('input:first-child').focus();
		$('.typeBox .one').hide();
	})
	//点击第二步的下一步
	$('body').on('click','.typeBox .two .submit',function(){
		$('.typeBox .three').show();
		$(".typeBox .three .intDiv").children('input:first-child').focus();
		$('.typeBox .two').hide();
	})
})
