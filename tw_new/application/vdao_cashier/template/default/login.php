<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>登陆</title>
		<link href="static/default/style/common.css" rel="stylesheet" type="text/css"/>
		<link href="static/default/style/login.css" rel="stylesheet" type="text/css"/>
		<script src="static/default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="main">
			<form action="" method="post">
				<p class="title">收银员登陆</p>
				<div class="name">
					<span>账号</span>
					<input type="text" placeholder="请输入账号" name="manager_name" />
				</div>
				<div class="name password">
					<span>密码</span>
					<input type="password" placeholder="请输入密码" name="manager_password"/>
				</div>	
				<div class="submit">
					<input type="submit" value="登陆" />
				</div>
			</form>
			
		</div>

<?php
// 调用安卓
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) {
?>
	
<script type="text/javascript" charset="utf-8" src="http://cordova.js"></script>
<script type="text/javascript" charset="utf-8" src="http://qiducashregisterlink.js"></script>
<script>
	$(document).ready(function() {
   var u = navigator.userAgent;
	var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端		
		
		if(isAndroid) {
			var txt={"url":"<?php echo $this->router->url('waits');?>"};
			loadViceScreenPageByUrl(txt);
		}
	});

</script>
<?php } ?>
</body>
</html>
