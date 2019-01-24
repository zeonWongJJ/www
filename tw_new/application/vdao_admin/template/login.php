<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>总后台登录</title>
</head>
<body>
    <h1>总后台登录</h1>
    <form action="<?php echo $this->router->url('login'); ?>" method="post">
        用户名：<input type="text" name="admin_name" value="test"><br>
        密码：<input type="password" name="admin_password" value="123456"><br>
        <input type="submit" value="登录">
    </form>
</body>
</html>