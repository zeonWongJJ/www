<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>评价办公室订单</title>
	<script src='./script/jquery-1.8.2.min.js'></script>
	<style>
		#goods li {
			float: left;
			width: 20px;
			height: 20px;
			margin-right: 15px;
			border: 1px solid red;
			list-style: none;
		}
		#service li {
			float: left;
			width: 20px;
			height: 20px;
			margin-right: 15px;
			border: 1px solid green;
			list-style: none;
		}
	</style>
</head>
<body>
	<h1>评价办公室订单</h1>
	<form action="<?php echo $this->router->url('appointment_comment'); ?>" method='post' enctype="multipart/form-data">
		<input type="hidden" name="appointment_id" value="<?php echo $a_view_data['appointment_id']; ?>">
		<input type="hidden" name="order_number" value="<?php echo $a_view_data['appointment_number']; ?>">
		商品评分：
		<div id="goods">
			<li name='1'></li>
			<li name='2'></li>
			<li name='3'></li>
			<li name='4'></li>
			<li name='5'></li>
		</div>
		<br>
		<input type="hidden" name="goods_score" value="0"><br>
		服务态度：
		<div id="service">
			<li name='1'></li>
			<li name='2'></li>
			<li name='3'></li>
			<li name='4'></li>
			<li name='5'></li>
		</div>
		<input type="hidden" name="service_score"><br>
		评价内容：<br><textarea name="comment_content" cols="30" rows="10"></textarea><br>
		评价图片：<input type="file" name="comment_pic[]" multiple="multiple"><br>
		是否匿名评论：<input type="radio" name="is_anonymous" value="0" checked>否
		<input type="radio" name="is_anonymous" value="1">是<br>
		<input type="submit" value="立即评价">
	</form>
</body>
</html>
<script>
$("#goods li").click(function(event) {
	var score = $(this).attr('name');
	$('#goods li').each(function(index, el) {
		if($(this).attr('name')<=score){
			$(this).css('background-color','red');
		} else {
			$(this).css('background-color','white');
		}
	});
	$("input[name='goods_score']").val(score);
});

$("#service li").click(function(event) {
	var score = $(this).attr('name');
	$('#service li').each(function(index, el) {
		if($(this).attr('name')<=score){
			$(this).css('background-color','green');
		} else {
			$(this).css('background-color','white');
		}
	});
	$("input[name='service_score']").val(score);
});
</script>