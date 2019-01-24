<!-- 证照验证 -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>证照验证</title>
</head>
<body>
	<form action="<?php echo $this->router->url('certificate_verification'); ?>" method='post' enctype="multipart/form-data">
		证照类别：<input type="text" name="cer_cate"><br>
		证照编号：<input type="text" name="cer_number"><br>
		有效日期：<input type="date" name="cer_effective"><br>
		证照等级：
		<select name="cer_rank" id="">
			<option value="1">一级</option>
			<option value="2">二级</option>
			<option value="3">三级</option>
		</select>
		<br>
		证照照片：<input type="file" name="cer_pic[]"><br>
		<input type="submit" value="提交认证">
	</form>
</body>
</html>