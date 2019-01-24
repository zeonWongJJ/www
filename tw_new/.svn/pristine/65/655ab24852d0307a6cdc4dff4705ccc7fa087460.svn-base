<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>我的动态</title>
</head>
<body>
	<h1>我的动态</h1><h2><a href="<?php echo $this->router->url('user_moodmsg'); ?>">动态消息</a></h2>
	<p><img src="<?php echo $a_view_data['userinfo']['user_pic']; ?>"></p>
	<p><?php echo $a_view_data['userinfo']['user_name']; ?></p>
	<?php foreach ($a_view_data['mood'] as $key => $value): ?>
		<div style="border:1px solid red; margin-bottom:10px; padding:10px;">
			<?php echo $value['mood_id'] . '、' . $value['mood_content']; ?>
			<p <?php if ($value['like_count']==0) { echo " style='display:none;'"; } ?>><?php echo $value['like_this'] .' 等' . $value['like_count'] .'人觉得很赞'; ?></p>
			<?php foreach ($value['discuss_parent'] as $k => $v): ?>
				<p style="color:green;"><?php echo $v['discuss_id'].'--'.$v['discuss_content']; ?></p>
				<?php foreach ($value['discuss_son'] as $kk => $vv): ?>
					<?php if ($vv['discuss_pid'] == $v['discuss_id']) {
						echo "<p style='color:blue;'>".$vv['user_name'].' 回复了 '. $v['user_name'] . ' : ' .$vv['discuss_content']."</p>";
					}?>
				<?php endforeach ?>
			<?php endforeach ?>
		</div>
	<?php endforeach ?>
</body>
</html>