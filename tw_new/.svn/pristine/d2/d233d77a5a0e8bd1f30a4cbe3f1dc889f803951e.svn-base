<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="<?php echo $this->router->url('id_verification'); ?>" method="post" name="verification" enctype="multipart/form-data">
		真实姓名：<input type="text" name="realname" placeholder="身份证名称" autocomplete="off" required /><br />
		证件类型：<input type="text" name="id_type" value="身份证" required /><br />
		性别：<select name="realsex">
				<option value="">请选择性别</option>
				<option value="0">男</option>
				<option value="1">女</option>
			  </select><br />
		证件号码：<input type="text" name="id_number" autocomplete="off" required /><br />
		手持身份证照片：<input type="file" name="id_image"><br />
		身份证正面照片：<input type="file" name="id_imgtwo"><br />
		<button type="submit" value="立即提交">立即提交</button>
	</form>
</body>
</html>