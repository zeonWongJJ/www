<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改退款申请</title>
</head>
<body>
	<form action="<?php echo $this->router->url('refund_update'); ?>" method='post' enctype="multipart/form-data">
	<input type="hidden" name="refund_id" value="<?php echo $a_view_data['data_refund']['refund_id']; ?>" >
	<input type="hidden" name="refund_video" value="<?php echo $a_view_data['data_refund']['refund_video']; ?>" >
	<input type="hidden" name="refund_img_one" value="<?php echo $a_view_data['data_refund']['refund_img_one']; ?>" >
	<input type="hidden" name="refund_img_two" value="<?php echo $a_view_data['data_refund']['refund_img_two']; ?>" >
	<input type="hidden" name="demand_id" value="<?php echo $a_view_data['data_refund']['demand_id']; ?>" >
	
	<p>标题：<?php echo $a_view_data['demand_detail']['title']; ?></p>
	服务状态：<input type="text" name="service_state">
	退款原因：<select name="refund_why">
		<option value="">请选择原因</option>
		<option value="未按约定时间上门" <?php if ($a_view_data['data_refund']['refund_why'] == '未按约定时间上门'){ echo 'selected'; } ?> >未按约定时间上门</option>
		<option value="服务者一直未到" <?php if ($a_view_data['data_refund']['refund_why'] == '服务者一直未到'){ echo 'selected'; } ?>>服务者一直未到</option>
		<option value="多拍/错拍/不需要" >多拍/错拍/不需要</option>
		<option value="联系不上服务者">联系不上服务者</option>
		<option value="其它">其它</option>
	</select><br />
	退款金额：<input type="text" name="refund_money" value="<?php echo $a_view_data['data_refund']['refund_money']; ?>"><br />
	退款说明：<textarea name="refund_detail"  cols="30" rows="10"><?php echo $a_view_data['data_refund']['refund_detail']; ?></textarea><br />
	视频凭证：<input type="file" name="refund_video"><br />
	<img src="<?php echo $a_view_data['data_refund']['refund_video']; ?>" style="width: 200px;" >
	图片凭证一：<input type="file" name="refund_img_one"><br />
	图片凭证二：<input type="file" name="refund_img_two"><br />
	<input type="submit" value="提交">
	</form>	
</body>
</html>