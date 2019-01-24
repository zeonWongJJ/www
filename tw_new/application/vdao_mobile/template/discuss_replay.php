<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>回复评论</title>
</head>
<body>
	<h1>评论<?php echo $a_view_data['user_name'].'的动态'. $a_view_data['mood_content']; ?></h1>
	<form action="<?php echo $this->router->url('discuss_replay'); ?>" method='post'>
		<input type="hidden" name="mood_id" value="<?php echo $a_view_data['mood_id']; ?>">
		<input type="hidden" name="discuss_pid" value="<?php echo $a_view_data['discuss_pid']; ?>">
		<textarea name="discuss_content" id="" cols="30" rows="10"></textarea>
		<br>
		<input type="submit" value="发表评论">
	</form>
</body>
</html>