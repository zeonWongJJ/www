<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改门店</title>
</head>
<body>
	<h1>修改门店- <?php echo $a_view_data['store_name']; ?></h1>
	<form action="<?php echo $this->router->url('store_update'); ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="store_id" value="<?php echo $a_view_data['store_id']; ?>">
		门店名称：<input type="text" name="store_name" value="<?php echo $a_view_data['store_name']; ?>"><br>
		门店地址：<input type="text" name="store_address" value="<?php echo $a_view_data['store_address']; ?>"><br>
		平均日产：<input type="text" name="store_output" value="<?php echo $a_view_data['store_output']; ?>"><br>
		门店介绍：
		<textarea name="store_introduction" cols="30" rows="10"><?php echo $a_view_data['store_introduction']; ?></textarea><br>
		营业执照：
		<img style="width:150px;height:150px;" src="<?php echo $a_view_data['store_licence']; ?>" /><br>
		联系人：<input type="text" name="store_linkman" value="<?php echo $a_view_data['store_linkman']; ?>"><br>
		联系方式：<input type="text" name="store_contact" value="<?php echo $a_view_data['store_contact']; ?>"><br>
		门店状态：
		<input type="radio" name="store_state" value="1" <?php if($a_view_data['store_state']==1){ echo 'checked'; } ?>>正常
		<input type="radio" name="store_state" value="2" <?php if($a_view_data['store_state']==2){ echo 'checked'; } ?>>停用
		<input type="radio" name="store_state" value="0" <?php if($a_view_data['store_state']==3){ echo 'checked'; } ?>>审核不通过
		<br />
		<input type="submit" value="修改门店">
	</form>
</body>
</html>