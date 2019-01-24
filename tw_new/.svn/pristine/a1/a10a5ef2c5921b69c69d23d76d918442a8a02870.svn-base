<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>发送失败</title>
		<link rel="stylesheet" type="text/css" href="style/Login.css" />
		<script src="js/jquery-1.8.2.min.js"></script>
		<script src="js/shipei.js"></script>
		<script src="js/Login.js"></script>
	</head>
	<body>
		<!--9.更换手机号-->
		<section class="page" id="fail">
			<div class="onekey">
				<div class="onekey_01">
					<a href="register"><span>已有账号</span></a>
				</div>
				<form class="onekey_02">
					<div class="fail">
						<p>
							<em>发送失败</em>
							<span></span>
						</p>
						<div class="fail_word">
							<div class="account">
								<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;账号：<span class='user_name name'><?php echo $_SESSION['member_na']?></span></p>
								<p>密码：<span class='randpwd pwd'><?php echo $_SESSION['pw']?></span></p>
							</div>
							<p>手机号已注册，可尝试使用密码登录或直接使用一键注册的账号登录</p>
						</div>
						<div class="fail_btn">
							<span onclick="to_moblixia()">更换手机号</span>
							<img src="image/success.jpg" alt="" />
						</div>
					</div>
				</form>
				<input type="submit" class="Login_06" value="一键登录" onclick="login_username()"/>
			</div>
		</section>
	</body>
</html>
<script>
	//再次点击发送账号密码触发
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
              if (data.code == 23) {
                alert('请填写用户名和密码！');
              } else if (data.code == 24) {
                alert('登录失败！');
              } else if (data.code == 25) {
                window.location.href ='<?php echo $this->router->url('index');?>';
              } else if (data.code == 26) {
                alert('用户密码错误,请尝试重新登录');
              };                  
            }
        })
    }
</script>