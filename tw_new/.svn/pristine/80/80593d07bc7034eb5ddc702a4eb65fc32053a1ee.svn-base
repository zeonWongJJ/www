<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>申请客服介入</title>
</head>
<body>
	<form action="<?php echo $this->router->url('refund_custom_service'); ?>" method='post' enctype="multipart/form-data">

	<input type="hidden" name="demand_id" value="<?php echo $a_view_data['demand_id']; ?>">
	<input type="hidden" name="refund_id" value="<?php echo $a_view_data['refund_id']; ?>">

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