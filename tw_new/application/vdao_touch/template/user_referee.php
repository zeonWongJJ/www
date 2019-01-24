<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>我推荐人列表</title>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>我推荐人列表</h1>
	搜索推荐人：<input type="text" name="keywords">&nbsp;<button onclick="referee_search()">搜索</button>
	<br><br>
	<div id="div_max">
		<?php foreach ($a_view_data as $key => $value): ?>
			<li><?php echo $value['user_id'] .'--'. $value['user_name']; ?></li>
		<?php endforeach ?>
	</div>
	<p id="no_more"></p>
	<button onclick="get_referee_more()">点击加载更多</button>
</body>
</html>

<script>

var page = 1;

function get_referee_more() {
	page++;
	//通过ajax将个数传递过去并获取更多数据回来
	$.ajax({
		url: '<?php echo $this->router->url('user_referee'); ?>',
		type: 'post',
		data: {'page':page},
		dataType: 'json',
		success: function(data){
			console.log(data);
			//将数据追加到页面
			if (data.code==400) {
				$('#no_more').html('没有更多数据了');
			} else {
	 			$.each(data, function (n, value) {
	               $("#div_max:last").append("<li style='color:red;'>"+value.user_id+'--'+value.user_name+"</li>");
	           });
			}
		}
	});
}

function referee_search() {
	var keywords = $("input[name='keywords']").val();
	if (keywords == '') {
		alert('关键词不能为空');
	} else {
		$.ajax({
			url: '<?php echo $this->router->url('referee_search'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {keywords: keywords},
			success: function(data) {
				console.log(data);
				if (data.code==400){
					alert(data.msg);
				} else {
					$("#div_max").children().remove();
					$.each(data, function (n, value) {
						$("#div_max:last").append("<li style='color:red;'>"+value.user_id+'--'+value.user_name+"</li>");
					});
				}
			}
		})
	}
}

</script>