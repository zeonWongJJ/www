<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>修改客服介入申请</h1>

	<form action="<?php echo $this->router->url('custom_change'); ?>" method='post' enctype="multipart/form-data">

	<input type="hidden" name="custom_video" value="<?php echo $a_view_data['custom_video']; ?>">
	<input type="hidden" name="custom_img" value="<?php echo $a_view_data['custom_img']; ?>">

	<input type="hidden" name="custom_id" value="<?php echo $a_view_data['custom_id']; ?>">

	

		申请原因：
		<select name="custom_why">
			<option value="产品质量问题">产品质量问题</option>
			<option value="服务者造假问题">服务者造假问题</option>
		</select><br />
		联系电话：<input type="text" name="proposer_tel"><br />
		维权说明：<textarea name="custom_detail" cols="30" rows="10"></textarea><br />
		视频：<input type="file" name="custom_video"><br />
		图片：<input type="file" name="custom_img[]" multiple="multiple">
		<input type="submit" value="确认提交"><br />
	</form>

</body>
</html>