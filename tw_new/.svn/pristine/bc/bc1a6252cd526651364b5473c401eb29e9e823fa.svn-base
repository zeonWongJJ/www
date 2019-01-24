<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>服务者申辩</title>
</head>
<body>
	<h1>服务者申辩</h1>
	<h3><?php echo $a_view_data['title']; ?> 已保修<?php echo $a_view_data['guarantee_count']; ?>次</h3>
	<form action="<?php echo $this->router->url('server_guarantee_averment'); ?>" method='post' enctype="multipart/form-data">
		<input type="hidden" name="demand_id" value="<?php echo $a_view_data['demand_id']; ?>">
		<input type="hidden" name="demand_state" value="<?php echo $a_view_data['state']; ?>">

		请填写申辩内容：<textarea name="averment_detail" id="" cols="30" rows="10"></textarea><br />
		视频凭证：<input type="file" name="averment_video"><br />
		图片凭证：<input type="file" name="averment_img[]" multiple="multiple"><br />
		<input type="submit" value="提交">
	</form>
</body>
</html>