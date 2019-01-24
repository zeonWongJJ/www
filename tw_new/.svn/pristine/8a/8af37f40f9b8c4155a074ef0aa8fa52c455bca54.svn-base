<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改资料</title>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>修改资料</h1>
<!-- 	头像：<input type="file" id="user_pic" name="user_pic" onchange="update_pic()"> -->
	<p>头像：<img src="<?php echo $a_view_data['user_pic']; ?>"></p>
	性别：
	<select name="user_sex" onchange="update_sex(this.value)">
		<option value="1" <?php if($a_view_data['user_sex']==1){ echo 'selected'; } ?> >男</option>
		<option value="2" <?php if($a_view_data['user_sex']==2){ echo 'selected'; } ?> >女</option>
		<option value="0" <?php if($a_view_data['user_sex']==0){ echo 'selected'; } ?> disabled>未知</option>
	</select>
	<br>
	<p>手机绑定：<a href="<?php echo $this->router->url('user_phone'); ?>"><?php echo $a_view_data['user_phone']; ?></a></p>
	<p><a href="#" onclick="update_password()">登录密码</a></p>
	<div style="display:none;padding:10px;border:1px solid red;" id="password_div">
		<a href="#" onclick="update_password_old()">通过旧密码方式</a> | <a href="#" onclick="update_password_phone()">通过手机验证方式</a>
	</div>
	<p><a href="<?php echo $this->router->url('user_payment'); ?>">支付密码</a></p>
</body>
</html>

<script>
function update_password() {
	var disp = $('#password_div').css('display');
	if (disp == 'none') {
		$('#password_div').css('display', 'block');
	} else {
		$('#password_div').css('display', 'none');
	}
}

function update_password_old() {
	window.location.href = "<?php echo $this->router->url('user_password',['type'=>1]); ?>";
}

function update_password_phone() {
	window.location.href = "<?php echo $this->router->url('user_password',['type'=>2]); ?>";
}

function update_sex(user_sex) {
	$.ajax({
		url: '<?php echo $this->router->url('user_update'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {type: 1, user_sex: user_sex},
		success:function(data){
			console.log(data);
		}
	})
}

</script>