<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>动态详情</title>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>动态详情</h1>
	内容：<?php echo $a_view_data['detail']['mood_content']; ?><br>
	点赞：<?php echo $a_view_data['detail']['mood_good']; ?><br>
	评论：<?php echo $a_view_data['detail']['mood_discuss']; ?><br>
	<?php foreach ($a_view_data['discuss_parent'] as $key => $value): ?>
		<div><?php echo $value['discuss_content']; ?>
		<a href="<?php echo $this->router->url('discuss_replay',['mood_id'=>$value['mood_id'],'discuss_id'=>$value['discuss_id']]); ?>">回复</a>
		<a href="#" onclick="discuss_like(<?php echo $value['discuss_id']; ?>)">点赞 [<?php echo $value['discuss_like']; ?>]</a>
		</div>
		<?php foreach ($a_view_data['discuss_son'] as $k => $v): ?>
			<?php
				if ($value['discuss_id']==$v['discuss_pid']) {
					echo "<div style='color:red;'>".$v['discuss_content']."</div>";
				}
			?>
		<?php endforeach ?>
	<?php endforeach ?>
</body>
</html>

<script>
function discuss_like(discuss_id) {
	$.ajax({
		url: '<?php echo $this->router->url('discuss_like'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {discuss_id: discuss_id},
		success: function(data) {
			console.log(data);
		}
	})
}
</script>