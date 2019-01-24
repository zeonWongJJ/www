<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>保修申请修改</h1>

	<form action="<?php echo $this->router->url('guarantee_change'); ?>" method='post' enctype="multipart/form-data">
		
		<input type="hidden" name="demand_id" value="<?php echo $a_view_data['demand_id']; ?>" >
		<input type="hidden" name="demand_state" value="<?php echo $a_view_data['demand_state']; ?>" >
		<input type="hidden" name="server_id" value="<?php echo $a_view_data['sever_uid']; ?>" >
		<input type="hidden" name="guarantee_video" value="<?php echo $a_view_data['guarantee_video'];?>">

		<input type="hidden" name="guarantee_number" value="<?php echo $a_view_data['guarantee_number'];?>">

		<input type="hidden" name="guarantee_id" value="<?php echo $a_view_data['guarantee_id']; ?>" >

		描述问题：<textarea name="guarantee_why" cols="30" rows="10"><?php echo $a_view_data['guarantee_why']; ?></textarea><br />
		视频：<input type="file" name="guarantee_video"><br />

		图片一：<input type="file" name="guarantee_img[]" multiple="multiple"><br />

		<img src="<?php echo $a_view_data['guarantee_img_two'];?>" style="width:120px;" />
		联系人：<input type="text" name="linkman" value="<?php echo $a_view_data['linkman']; ?>"><br />
		联系电话：<input type="text" name="link_tel" value="<?php echo $a_view_data['link_tel']; ?>"><br />
		<input type="submit" value="确认修改"><br />
	</form>

</body>
</html>