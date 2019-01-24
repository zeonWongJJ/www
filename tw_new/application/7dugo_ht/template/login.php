<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
        <meta name="Keywords" content="" />
        <meta name="Description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="Cache-Control" content="max-age=7200" />
        <title>管理员中心</title>
    <link rel="stylesheet" href="style/style.css">
    </head>
<body>

<h1>管理员中心</h1>
<div class="login-form">
    <form action="login_auth" method="post">
        <div class="head-info">
            <label class="lbl-1"> </label>
            <label class="lbl-2"> </label>
            <label class="lbl-3"> </label>
        </div>
            <div class="clear"> </div>
        <div class="avtar">
            <img src="image/avtar.png" />
        </div>
            
                <input type="text" name="username" class="userName" placeholder="请输入用户名"  value=""  autocomplete="off" required  />
                <input type="password"  name="passwd" class="userPassw" placeholder="请输入密码" value="" required />
            
        <div class="signin">
            <input type="submit" value="登录" >
        </div>
    </form>
</div>
</body>
</html>