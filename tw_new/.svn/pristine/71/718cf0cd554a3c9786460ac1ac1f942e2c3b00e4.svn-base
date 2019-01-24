<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>登录系统</title>
	<link rel="stylesheet" href="static/style_default/plugin/layui/css/layui.css">
	<script src="static/style_default/plugin/layui/layui.js"></script>
	<script src="static/style_default/script/jquery-3.2.1.min.js"></script>
	<script src="static/style_default/script/jquery.nicescroll.js"></script>
	<script src="static/style_default/script/iframe_nicescroll.js"></script>
	<style>
		*{
			margin:0;
			padding: 0;
		}
		html,body{
			height:100%;
			width:100%;
			margin:0;
			padding:0;
		}
		body {
			width:100%;
			height:100%;
			background:url(/upload/admin/bg2.jpg);
			background-repeat: no-repeat;
			background-size:100% 100%;
			position:absolute;
		}
		.login_box {
			width: 380px;
			height: 390px;
			position: fixed;
			background-color: #fff;
			border-radius: 5px;
			opacity:0.6;
		}
		.login_logo {
			height: 120px;
			text-align: center;
			line-height: 120px;
			margin-top: 15px;
		}
		.login_logo img {
			width: 65px;
			height: 65px;
			border-radius: 50%;
		}
		.form_box {
			width: 310px;
			height: 100px;
			margin: 0 auto;
		}
		.layui-input {
			margin-top: 10px;
			margin-bottom: 25px;
		}
	</style>
</head>
<body>

<div class="login_box">
	<div class="login_logo">
		<img src="/upload/admin/bg2.jpg" />
	</div>
	<div class="form_box">
		<form class="layui-form">
		    <input type="text" name="admin_name" required  lay-verify="required" placeholder="用户名" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','readonly');" class="layui-input">
		    <input type="password" name="admin_password" required  lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','readonly');" >
		    <div style="text-align:center">
		    	<button class="layui-btn layui-btn-primary layui-btn-fluid" lay-submit lay-filter="formDemo">立即登录</button>
		    </div>
		</form>
	</div>
</div>

</body>
</html>

<script>

$(function(){
	// 改变div位置[居中]
	cahnge_div();
})

window.onresize = function(){
	cahnge_div();
}

function cahnge_div() {
    var nagheight = $(window).height(); //浏览器时下窗口可视区域高度
    var nagwidth  = $(window).width();  //浏览器时下窗口可视区域宽
    var box_h   = $('.login_box').outerHeight();
    var box_w   = $('.login_box').outerWidth();
    $('.login_box').css('top', (nagheight-box_h)/2);
    $('.login_box').css('left', (nagwidth-box_w)/2);
}

layui.use(['form','layer','element',], function(){
	var form = layui.form;
	var element = layui.element;
	//监听提交
	form.on('submit(formDemo)', function(data){
		// 发送ajax请求
		$.ajax({
			url: 'admin_login',
			type: 'POST',
			dataType: 'json',
			data: data.field,
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					layer.msg('登录成功', {shade: 0.4, time: 1500});
					// 登录成功跳转到首页
					window.location.href = 'index';
				} else {
					layer.msg(res.msg, {shade: 0.4, time: 800});
				}
			}
		})
		return false;
	});
})


</script>