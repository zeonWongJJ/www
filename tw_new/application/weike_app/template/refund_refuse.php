<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>拒绝退款</title>
</head>
<body>
	<h1>拒绝退款</h1>
	<form action="<?php echo $this->router->url('server_refund_refuse'); ?>" method='post'  enctype="multipart/form-data">
	<input type="hidden" name="demand_id" value="<?php echo $a_view_data['demand_id']; ?>">
	<input type="hidden" name="demand_state" value="<?php echo $a_view_data['state']; ?>">
		拒绝原因：
		<select name="refuse_why">
			<option value="事实与原因不符">事实与原因不符</option>
			<option value="我就是不想，咋滴">我就是不想，咋滴</option>
		</select>
		<br />
		拒绝说明：
		<textarea name="refuse_detail" id="" cols="30" rows="10">

		</textarea>
		<br />
		视频凭证：<input type="file" name="refuse_video"><br />
		图片凭证：<input type="file" name="refuse_img[]" multiple="multiple"><br />
		<input type="submit" value="拒绝退款">
	</form>
</body>
</html>