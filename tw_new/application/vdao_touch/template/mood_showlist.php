<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>动态列表</title>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>动态列表</h1>
	<?php foreach ($a_view_data as $key => $value): ?>
		<div><?php echo "<img src='".$value['user_pic']."' />" ?></div>
		<div><a href="<?php echo $this->router->url('mood_detail',['id'=>$value['mood_id']]); ?>"><?php echo $value['mood_content']; ?></a></div>
		<div>
			<a href="<?php echo $this->router->url('mood_relay',['id'=>$value['mood_id']]); ?>">转发</a> |
			<a href="<?php echo $this->router->url('mood_discuss',['id'=>$value['mood_id']]); ?>">评论</a> |
			<a href="#" onclick="mood_like(<?php echo $value['mood_id']; ?>)"><?php if($value['islike']==1){ echo '已点赞'; } else { echo '点赞'; } ?></a>
		</div>
	<?php endforeach ?>
</body>
</html>

<script>

function mood_like(mood_id) {
	$.ajax({
		url: '<?php echo $this->router->url('mood_like'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {mood_id: mood_id},
		success: function(data) {
			console.log(data);
		}
	})
}

</script>