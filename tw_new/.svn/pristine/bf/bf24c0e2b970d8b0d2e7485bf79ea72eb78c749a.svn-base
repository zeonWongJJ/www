<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>注册成功</title>
		<link rel="stylesheet" type="text/css" href="style/Login.css" />
		<script src="js/jquery-1.8.2.min.js"></script>
		<script src="js/shipei.js"></script>
		<script src="js/Login.js"></script>
	</head>
	<body>
		<!--2.注册成功-->
		<section class="page" id="succeed">
			<div class="onekey">
				<div class="onekey_01">
					<a href="login"><span>已有账号</span></a>
				</div>
				<form class="onekey_02">
					<div class="success">
						<p>
							<em>注册成功</em>
							<span></span>
						</p>
						<div class="number">
							<p>账号&nbsp;:<span class='user_name name'><?php echo $_SESSION['member_na']?></span></p>
							<p>密码&nbsp;:<span class='randpwd pwd'><?php echo $_SESSION['pw']?></span></p>
						</div>
						<div class="success_btn">
							<span onclick="to_moblixia()">发送到我手机</span>
							<img src="image/success.jpg" alt="" />
						</div>
					</div>
				</form>
				<input type="submit" class="Login" value="一键登录" onclick="login_username()"/>
			</div>
		</section>
	</body>
</html>
<script>
	//点击发送账号密码触发
    function to_moblixia() {
        location.href = 'protocolhead://WHCMobileVC_?123';        
    }
    //点击发送账号密码登录
    function login_username() {
        var name = $('.name').text();
        var randpwd = $('.pwd').text();
        $.ajax({
            type : "POST",
            url : '<?php echo $this->router->url('login_auth');?>',
            data : {username:name,passwd:randpwd},
            dataType : 'json',
            success : function(data) {
              if (data == 23) {
                alert('请填写用户名和密码！');
              } else if (data == 24) {
                alert('登录失败！');
              } else if (data == 25) {
                window.location.href ='<?php echo $this->router->url('index');?>';
              } else if (data == 26) {
                alert('用户密码错误,请尝试重新登录');
              };                  
            }
        })
    }
</script>