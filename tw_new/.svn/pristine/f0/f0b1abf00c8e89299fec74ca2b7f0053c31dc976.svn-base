<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
</head>
<body>
	<div id="div_max">
	<?php foreach ($a_view_data as $key => $value): ?>
		<li style="list-style:none;"><?php echo $value['variation_id']; ?>
		<?php echo $value['change_hints'].'<br />'; ?></li>
	<?php endforeach ?>
	</div>
	<div id="no_more"></div>
	<button onclick="loadmore()">加载更多</button>
</body>
</html>

<script src="js/jquery-1.8.2.min.js"></script>
<script>

var page = 1;

function loadmore() {
	page++;
	//通过ajax将个数传递过去并获取更多数据回来
	$.ajax({
		url: '<?php echo $this->router->url('get_more'); ?>',
		type: 'post',
		data: {'page':page},
		dataType: 'json',
		success: function(data){
			console.log(data);
			//将数据追加到页面
			if (data.state==0) {
				$('#no_more').html('没有更多数据了');
			} else {
	 			$.each(data, function (n, value) {
	               $("#div_max:last").append("<li style='color:red;'>"+value.variation_id+value.change_hints+"</li>");
	           });
			}
		}
	});
}
</script>