<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>申请保修</title>
</head>
<body>
	<p>标题：<?php echo $a_view_data['title']; ?></p>
	<form action="<?php echo $this->router->url('for_guarantee'); ?>" method='post' enctype="multipart/form-data">
		<input type="hidden" name="demand_id" value="<?php echo $a_view_data['demand_id']; ?>" >
		<input type="hidden" name="server_id" value="<?php echo $a_view_data['selected_member_id']; ?>" >
		<input type="hidden" name="demand_state" value="<?php echo $a_view_data['state']; ?>" >
		描述问题：<textarea name="guarantee_why" cols="30" rows="10"></textarea><br />
		视频：<input type="file" name="guarantee_video"><br />
		图片一：<input type="file" name="guarantee_img[]" multiple="multiple"><br />
		联系人：<input type="text" name="linkman"><br />
		联系电话：<input type="text" name="link_tel"><br />
		<input type="submit" value="申请保修"><br />
	</form>
</body>
</html>