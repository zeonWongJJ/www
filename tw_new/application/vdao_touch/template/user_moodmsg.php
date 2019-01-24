<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>动态消息</title>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>

<h1>动态消息</h1>
<button onclick="moodmsg_clear()">清空消息</button>
<br><br>
<div id="max_div">
	<?php foreach ($a_view_data as $key => $value): ?>
		<li>
			<img src="<?php echo $value['send_upic']; ?>">
			<p><?php echo $value['send_uname']; ?></p>
			<p><?php echo $value['msg_content']; ?></p>
			<p><?php echo date('m-d H:i:s', $value['msg_time']); ?></p>
			<?php if (!empty($value['mood_pic'])){ echo "<img src='".$value['mood_pic']."'>"; } ?>
		</li>
	<?php endforeach ?>
</div>

<button>点击查看更多</button>
</body>
</html>

<script>

function moodmsg_clear() {
	if (confirm('你确定要清空这些消息吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('moodmsg_clear'); ?>',
			type: 'POST',
			dataType: 'json',
			success:function(data){
				console.log(data);
				if (data.code==200) {
					$("#max_div").children().remove();
				}
			}
		})
	}
}

</script>