<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>共享办公室详情</title>
</head>
<body>
	<h1>共享办公室详情</h1>
	<h3><?php echo $a_view_data['detail']['room_name']; ?></h3>
	<p>大小：<?php echo $a_view_data['detail']['room_size']; ?> m<sup>2</sup></p>
	<p>座位：<?php echo $a_view_data['detail']['room_seat']; ?></p>
	<p>设备：<?php echo $a_view_data['detail']['device']; ?></p>
	<p>描述：<?php echo $a_view_data['detail']['room_description']; ?></p>

	<h2>房间评价</h2>（<?php echo '评论总数：' . $a_view_data['comment_total']; ?>）：
	<?php foreach ($a_view_data['comment'] as $key => $value): ?>
		<p><?php echo $value['comment_id'] . '--' . $value['comment_content']. '----评论人：'.$value['user_name'].'---评论时间：'.date('Y-m-d', $value['comment_time']). "———头像：<img src='".$value['user_pic']."'>"; ?></p>
	<?php endforeach ?>

	<a href="<?php echo $this->router->url('login'); ?>">查看全部评论</a>

	<h2>用过的人还推荐了</h2>
	<?php foreach ($a_view_data['office'] as $key => $value): ?>
		<li><?php echo $value['room_name'].'--'.$value['room_size'].'m<sup>2</sup> '.$value['device'].'可坐'.$value['room_seat'].'人'; ?></li>
	<?php endforeach ?>
</body>
</html>