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
    <link rel="stylesheet" href="css/vipIndex.css"/>
    <!--<link rel="stylesheet" href="css/head.css"/>-->
    <!--<link rel="stylesheet" href="css/footer.css"/>-->
    <script src="js/jquery-1.8.2.min.js"></script>
    <title></title>
</head>
<body>
<!-- 头部 -->
<header class="header">

    <!--  头像 -->
    <div class="setBox">
        <a href="<?php echo $this->router->url('user_set'); ?>">设置</a>
        <a href=""><i class="iconfont">&#xe68d;</i></a>
    </div>
    <!--  头像 -->

    <!-- 用户信息 -->
    <div class="userDetails">
        <i>
            <img src="img/timg.jpg" alt=""/>
        </i>
        <div class="userInfo">
            <p><?php echo $a_view_data['mybaseinfo']['username']; ?></p>
            <a href=""><?php echo $a_view_data['mybaseinfo']['demander_appellation']; ?> &gt;</a>
        </div>

    </div>
    <!-- 用户信息 -->

</header>
<!-- 头部 -->

<!-- 账户信息 -->
<nav class="account">

    <div class="accountBox">
        <!-- 余额 -->
        <div class="balance">
            <span>账户总额(元)</span>
            <p><?php echo $a_view_data['mybaseinfo']['balance']; ?></p>
        </div>
        <!-- 余额 -->
        <!--  充值 -->
        <div class="rech">
            <a>充值</a>
            <a>提现</a>
        </div>
        <!-- 充值-->
    </div>

    <!--  导航 -->
    <div class="nav">
        <a href="<?php echo $this->router->url('get_demand_footprint'); ?>">
            <p>足迹</p>
            <p><?php echo $a_view_data['myfootprint']; ?></p>
        </a>
        <a href="<?php echo $this->router->url('get_server_collect'); ?>">
            <p>收藏</p>
            <p><?php echo $a_view_data['mycollect']; ?></p>
        </a>
        <a href="<?php echo $this->router->url('get_demand_footprint'); ?>">
            <p>排班表</p>
            <p><?php echo $a_view_data['mypaiban']; ?></p>
        </a>
    </div>
    <!-- 导航 -->
</nav>
<!-- 账户 -->

<!-- 用户状态列表 -->
<div class="stateList">
    <ul>
        <li>
            <a href="<?php echo $this->router->url('demand_detail',['id'=>1]); ?>">
                <p>竞标中</p>
                <p><?php echo $a_view_data['inbid_total']; ?></p>
            </a>
        </li>
        <li>
            <a href="">
                <p>待付款</p>
                <p><?php echo $a_view_data['waitpay_total']; ?></p>
            </a>
        </li>
        <li>
            <a href="">
                <p>待确认</p>
                <p><?php echo $a_view_data['waitconfirm_total']; ?></p>
            </a>
        </li>
        <li>
            <a href="">
                <p>待服务</p>
                <p><?php echo $a_view_data['waitservice_total']; ?></p>
            </a>
        </li>
        <li>
            <a href="">
                <p>服务中</p>
                <p><?php echo $a_view_data['inservice_total']; ?></p>
            </a>
        </li>
        <li>
            <a href="">
                <p>待评价</p>
                <p><?php echo $a_view_data['waitcomment_total']; ?></p>
            </a>
        </li>
        <li>
            <a href="">
                <p>已完成</p>
                <p><?php echo $a_view_data['complete_total']; ?></p>
            </a>
        </li>
    </ul>
</div>
<!-- 用户状态列表 -->

<!-- 用户功能目录列表 -->
<div class="cataList">
    <ul>
        <li>
            <a href="">
                <em>
                    <i class="iconfont">&#xe835;</i>
                    <span>交易记录</span>
                </em>
                <span>
                    点击查看详细 &gt;
                </span>
            </a>
        </li>
        <li>
            <a href="<?php echo $this->router->url('user_myscore'); ?>">
                <em>
                    <i class="iconfont">&#xe835;</i>
                    <span>积分记录</span>
                </em>
                <span>
                    <e style="color:red;"><?php echo $a_view_data['mybaseinfo']['integral']; ?>分</e>可用 &gt;
                </span>
            </a>
        </li>
        <li>
            <a href="">
                <em>
                    <i class="iconfont">&#xe835;</i>
                    <span>我的评价</span>
                </em>
                <span>
                    去查看 &gt;
                </span>
            </a>
        </li>
        <li>
            <a href="">
                <em>
                    <i class="iconfont">&#xe835;</i>
                    <span>现金券</span>
                </em>
                <span>
                    <e style="color:red;"><?php echo $a_view_data['mybaseinfo']['cash_coupon']; ?></e>张可用 &gt;
                </span>
            </a>
        </li>
        <li>
            <a href="">
                <em>
                    <i class="iconfont">&#xe835;</i>
                    <span>联系客服</span>
                </em>
                <span>
                   去联系客服 &gt;
                </span>
            </a>
        </li>
        <li>
            <a href="">
                <em>
                    <i class="iconfont">&#xe835;</i>
                    <span>关于找服务</span>
                </em>
                <span>
                   点击查看详情  &gt;
                </span>
            </a>
        </li>
    </ul>
</div>
<!-- 用户功能目录列表 -->

<!-- 底部 -->
<footer class="foot" id="foot">
    <ul>
        <li>
            <a href="" class="ify">
                <i class="iconfont">&#xe835;</i>
                <p>首页</p>
            </a>
        </li>
        <li>
            <a href="" class="ify">
                <i class="iconfont">&#xe6d4;</i>
                <p>找活干</p>
            </a>
        </li>
        <li class="release">
            <a href="" class="ify">
                <i></i>
                <span>ddd</span>
                <p>发布</p>
            </a>
        </li>
        <li>
            <a href="" class="ify">
                <i class="iconfont">&#xe63a;</i>
                <p>找服务</p>
            </a>
        </li>
        <li>
            <a href="" class="ify">
                <i class="iconfont">&#xe61e;</i>
                <p>个人中心</p>
            </a>
        </li>

    </ul>
</footer>
<!-- 底部 -->

</body>
</html>