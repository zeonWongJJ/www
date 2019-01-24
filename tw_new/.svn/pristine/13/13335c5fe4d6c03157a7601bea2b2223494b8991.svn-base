<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>转发动态</title>
</head>
<body>
	<h1>转发动态</h1>
	<form action="<?php echo $this->router->url('mood_relay'); ?>" method='post'>
		<input type="hidden" name="relay_mood" value="<?php echo $a_view_data['mood_id']; ?>">
		<textarea name="mood_content" cols="30" rows="10"></textarea>
		<br>
		<input type="submit" value="转发">
	</form>
	<?php echo $a_view_data['mood_content']; ?>
</body>
</html>