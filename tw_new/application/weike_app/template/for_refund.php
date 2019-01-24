<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="<?php echo $this->router->url('for_refund'); ?>" method='post' enctype="multipart/form-data">
	<input type="hidden" name="demand_id" value="<?php echo $a_view_data['demand_id']; ?>" >
	<input type="hidden" name="server_id" value="<?php echo $a_view_data['selected_member_id']; ?>" >

	<input type="hidden" name="demand_state" value="<?php echo $a_view_data['state']; ?>">
	<p>标题：<?php echo $a_view_data['title']; ?></p>
	服务状态：<input type="text" name='service_state'>
	退款原因：<select name="refund_why">
		<option value="">请选择原因</option>
		<option value="未按约定时间上门">未按约定时间上门</option>
		<option value="服务者一直未到">服务者一直未到</option>
		<option value="多拍/错拍/不需要">多拍/错拍/不需要</option>
		<option value="联系不上服务者">联系不上服务者</option>
		<option value="其它">其它</option>
	</select><br />
	退款金额：<input type="text" name="refund_money"><br />
	退款说明：<textarea name="refund_detail"  cols="30" rows="10"></textarea><br />
	视频凭证：<input type="file" name="refund_video"><br />
	图片凭证一：<input type="file" name="refund_img[]" multiple="multiple"><br />
	<input type="submit" value="提交">
	</form>
</body>
</html>