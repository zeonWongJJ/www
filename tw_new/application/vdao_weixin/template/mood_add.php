<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>发布帖子</title>
</head>
<body>
	<h1>发布帖子</h1>
	<form action="<?php echo $this->router->url('mood_add'); ?>" method='post' enctype="multipart/form-data">
		内容：<textarea name="mood_content" cols="30" rows="10"></textarea><br>
		图片或者视频：<input type="file" name="mood_pic[]" multiple="multiple"><br>
		谁可以看见：
		<select name="mood_view">
			<option value="1">全部人可见</option>
			<option value="2">推荐人可见</option>
			<option value="3">仅自己可见</option>
		</select>
		<br>
		<input type="submit" value="提交">
	</form>
</body>
</html>