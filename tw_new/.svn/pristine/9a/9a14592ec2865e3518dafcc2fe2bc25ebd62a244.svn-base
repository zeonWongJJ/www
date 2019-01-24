<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>禁用用户</title>
</head>
<body>
	<h1>禁用用户：<span style="color:red;"><?php echo $a_view_data['user_name']; ?></span></h1>
	<form action="<?php echo $a_view_data['user_forbid']; ?>" method='post'>
		<input type="hidden" name="user_id" value="<?php echo $a_view_data['user_id']; ?>">
		开始时间：<input type="text" name="forbid_start" value="<?php echo date('Y-m-d H:i:s', time()) ?>">
		<br>
		结束时间：<input type="date" name="forbid_end">
		<br>
		禁用原因说明：<textarea name="forbid_detail" id="" cols="30" rows="10"></textarea><br>
		<input type="submit" value="禁用用户">
	</form>
</body>
</html>