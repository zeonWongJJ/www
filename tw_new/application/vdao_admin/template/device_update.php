<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改设备</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
</head>
<body>
	<h1>修改设备</h1>
	<form action="<?php echo $this->router->url('device_update'); ?>" method='post' enctype="multipart/form-data">
		<input type="hidden" name="device_id" value="<?php echo $a_view_data['detail']['device_id']; ?>">
		设备名称：<input type="text" name="device_name" value="<?php echo $a_view_data['detail']['device_name']; ?>"><br>
		设备型号：<input type="text" name="device_version" value="<?php echo $a_view_data['detail']['device_name']; ?>"><br>
		设备图片：<input type="file" name="device_otherpic[]" id="file" multiple="multiple" /><br>
		<div id="img_box">

		</div>
		设备描述：<textarea name="device_description" id="" cols="30" rows="10"><?php echo $a_view_data['detail']['device_description']; ?></textarea><br>
		<br>
		<input type="submit" value="修改设备">
	</form>

	<div id="result" name="result"></div>
</body>
</html>

<script>

</script>