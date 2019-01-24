<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/userCenter.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <title>用户中心</title>
    <script>
        $(function(){
            $(".nav>ul>li>a>i>img:last-child").hide();
            $(".nav>ul>li>a>i").click(function(){
                $(this).addClass("cur");
                $(".cur>img:first-child").hide();
                $(".cur>img:last-child").show();
                $(".nav>ul>li>a>i").not($(this)).removeClass("cur");
                $(".nav>ul>li>a>i>:first-child").not( $(".cur>img:first-child")).show();
                $(".nav>ul>li>a>i>:last-child").not( $(".cur>img:last-child")).hide();
            });
        });
    </script>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 用户中心 -->
    <div class="userCenter">
        <!-- 用户信息 -->
        <div class="userContent">
            <div class="userTool">
                <!--<a href=""><img src="static/style_default/images/in_03.png" /></a>-->
                <a href=""><img src="static/style_default/images/in_05.png" /></a>
            </div>
            <div class="userPic">
                <?php if (empty($_SESSION['user_id'])) {?>
                    <img src="static/style_default/images/noneLogin.png" />
                    <span>
                         <a href="login">登录</a>/<a href="login">注册</a>
                    </span>
                <?php } else {?>
                    <?php if (empty($a_view_data['user_pic'])) {
                        echo '<img src="static/style_default/images/noneLogin.png" />';
                    } else {
                        echo '<img src="'.$a_view_data['user_pic'].'" />';
                    } ?>
                <span><?php echo $a_view_data['user_name']?></span>
                <?php }?>
            </div>
            <div class="userNav">
                <a href="">
                    <img src="static/style_default/images/in_13.png" />
                    <p>我的余额</p>
                    <?php if (empty($_SESSION['user_id'])) {?>
                        <span>¥ 0.00</span>
                    <?php } else {?>
                        <span>¥ <?php echo $a_view_data['user_balance']?></span>
                    <?php }?>
                </a>
                <a href="">
                    <img src="static/style_default/images/in_15.png" />
                    <p>我的积分</p>
                     <?php if (empty($_SESSION['user_id'])) {?>
                        <span>0</span>
                    <?php } else {  if ($a_view_data['user_scoreuseruseruser'] == 0) {
                        echo "<span>0</span>";
                    } else { echo "<span>".$a_view_data['user_scoreuseruseruser']."</span>";}}?>
                </a>
                <a href="">
                    <img src="static/style_default/images/in_10.png" />
                    <p>我的动态</p>
                </a>
            </div>
            <div class="userOrders">
                <a href="<?php echo $this->router->url('goods_order')?>">
                    <span>咖啡订单</span>
                </a>
                <a href="">
                    <span>办公室订单</span>
                </a>
            </div>
        </div>
        <!-- 用户信息 -->

        <!-- 导航 -->
        <div class="nav">
            <ul>
                <li>
                    <a class="assets" href="">
                        <i>
                            <img src="static/style_default/images/in_30.png" />
                            <img src="static/style_default/images/sd7.png" />
                        </i>
                        <span>总资产</span>
                    </a>
                </li>
                <li>
                    <a class="assets" href="<?php echo $this->router->url('collect')?>">
                        <i>
                            <img src="static/style_default/images/in_24.png" />
                            <img src="static/style_default/images/sd3.png" />
                        </i>
                        <span>我的收藏</span>
                    </a>
                </li>
                <li>
                    <a class="assets">
                        <i>
                            <img src="static/style_default/images/sd4.png" />
                            <img src="static/style_default/images/in_21.png" />
                        </i>
                        <span>我的足迹</span>
                    </a>
                </li>
                <li>
                    <a class="assets">
                        <i>
                            <img src="static/style_default/images/in_27.png" />
                            <img src="static/style_default/images/sd2.png" />
                        </i>
                        <span>我的评价</span>
                    </a>
                </li>
                <li>
                    <a class="assets">
                        <i>
                            <img src="static/style_default/images/in_43.png" />
                            <img src="static/style_default/images/sd6.png" />
                        </i>
                        <span>邀请好友</span>
                    </a>
                </li>
                <li>
                    <a class="assets" href="login3">
                        <i>
                            <img src="static/style_default/images/in_37.png" />
                            <img src="static/style_default/images/sd5.png" />
                        </i>
                        <span>我是店主</span>
                    </a>
                </li>
                <li>
                    <a class="assets">
                        <i>
                            <img src="static/style_default/images/in_40.png" />
                            <img src="static/style_default/images/sd1.png" />
                        </i>
                        <span>客服中心</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- 导航 -->
    </div>
    <!-- 用户中心 -->
</body>
</html>