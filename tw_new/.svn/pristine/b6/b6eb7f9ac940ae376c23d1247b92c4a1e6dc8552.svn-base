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
    <link rel="stylesheet" href="css/integrationss.css"/>
    <title></title>
</head>
<body>
    <!--  积分页面  -->
    <div class="integration">
        <!-- 头部 -->
        <header class="head">
            <em>&lt;</em>
            <span>密码找回</span>
        </header>
        <!-- 头部 -->
        <!--  我的积分 -->
        <article class="userPoints">
            <h4>我的积分</h4>
            <p>
                <span><?php echo $a_view_data['present']; ?></span>
                <i class="iconfont"></i>
                <em></em>
            </p>
            <div class="pointsInfo">
                <p>历史积分：<em><?php echo $a_view_data['history']; ?></em></p>
                <p>打败了<em><?php echo $a_view_data['beat']; ?>%</em>的找服务用户</p>
            </div>
            <!-- 积分分类 -->
            <div class="pointsCate">
                <div class="reward">
                    <a href="<?php echo $this->router->url('user_score_detail'); ?>">
                        <i><img src="img/ss9_03.png" alt=""/></i>
                        <div class="cbox">
                            <h3>积分明细</h3>
                            <span>查看积分明细</span>
                        </div>
                    </a>
                </div>
                <div class="record">
                    <a href="">
                        <i><img src="img/ss9_03.png" alt=""/></i>
                        <div class="cbox">
                            <h3>兑换记录</h3>
                            <span>查看积分兑换记录</span>
                        </div>
                    </a>
                </div>
            </div>
            <!-- 积分分类 -->
        </article>
        <!-- 我的积分 -->

        <!-- 积分兑换 -->
        <div class="exchange">
            <p class="exTit">
                <span>积分兑换</span>
            </p>
            <!--  兑换商品 -->
            <div class="wares">
                <ul>
                    <?php foreach ($a_view_data['gold'] as $key => $value): ?>
                    <li>
                        <a href="">
                            <i><img src="<?php echo $value['image']; ?>" alt=""/></i>
                            <h4><?php echo $value['cash_name']; ?></h4>
                            <p>
                                <span>积分</span><em><?php echo $value['integral']; ?></em>
                            </p>
                        </a>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <!-- 积分兑换 -->
    </div>
    <!--  积分页面  -->

    <!--  底线 -->
    <div class="bottom">
         <p /></p> &nbsp;
            <span>这是底线</span>
        &nbsp;<p/></p>
    </div>
</body>
</html>