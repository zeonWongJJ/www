<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="css/common.css"/>
    <link rel="stylesheet" href="css/personal.css"/>
    <title></title>
</head>
<body>
    <!-- 个人资料 -->
    <div class="personal">
        <!-- 资料信息 -->
        <ul class="perList">
            <li class="touxiang">
                <span>头像</span>
                <em class="choicePer"><img src="img/dayuhao.png" alt=""/></em>
                <i class="perPic"><img src="img/ttt.jpg" alt=""/></i>
            </li>
            <li class="user">
                <span>用户名</span>
                <em><?php echo $a_view_data['username']; ?></em>
            </li>
            <li class="phone">
                <span>手机号</span>
                <em><?php echo substr_replace($a_view_data['mobile'], '****', 3, 4); ?></em>
            </li>
            <li class="sex">
                <span>性别</span>
                <em><img src="img/dayuhao.png" alt=""/></em>
                <b><?php if($a_view_data['sex']==0){ echo "未知"; } elseif($a_view_data['sex']==1){ echo "男"; } else { echo "女";} ?></b>
            </li>
        </ul>
        <!-- 资料信息 -->
    </div>
    <!-- 个人资料 -->
</body>
</html>