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
    <link rel="stylesheet" href="static/style_default/style/myShare.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/myShare.js"></script>
    <title>我要分享</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 我要分享 -->
    <div class="myShare">
        <p class="pjoTitle">
            <a href="<?php echo $this->router->url('user_center')?>"><img src="static/style_default/images/gouxiang_18.png" alt=""/></a>
            <span>我要分享</span>
        </p>
        <!-- 导航 -->
        <div class="nav">
            <a href="<?php echo $this->router->url('audit')?>">
                <img style="width:0.74rem;" src="static/style_default/images/Medal.png" alt=""/>
                <span>资质认证</span>
            </a>
            <a <?php if ($a_view_data['qual']['audit'] != 2) {echo 'class="audit"';} else {echo 'href="classification"';}?>>
                <img style="width:0.8rem;" src="static/style_default/images/Cloud_upload.png" alt=""/>
                <span>分享产品</span>
            </a>
            <a <?php if ($a_view_data['qual']['audit'] != 2) {echo 'class="audit"';} else {echo 'href="share_goods_list?myshare='.$this->router->get_url().'"';}?>>
                <img style="width:0.56rem;" src="static/style_default/images/Ribbon.png" alt=""/>
                <span>产品列表</span>
            </a>
            <a <?php if ($a_view_data['qual']['audit'] != 2) {echo 'class="audit"';} else {echo 'href="share_order"';}?>>
                <img style="width:0.56rem;" src="static/style_default/images/Notepad.png" alt=""/>
                <span>订单列表</span>
            </a>
        </div>
        <!-- 导航 -->
        <!-- 数据 -->
        <div class="shareData">
            <p>
                <img src="static/style_default/images/la.png" alt=""/>
                <span>经营数据</span>
            </p>
            <div class="while">
                <a onclick="change_day(1)" class="whileCur today">今天</a>
                <a onclick="change_day(2)" class="yestoday">昨天</a>
                <a onclick="change_day(7)" class="week">近7天</a>
            </div>
            <dl>
                <dt>
                    <span>收入(元)</span>
                    <p id="income"><?php echo $a_view_data['today_income']; ?></p>
                </dt>
                <dd>
                    <span>笔单价(元)</span>
                    <p id="per"><?php echo $a_view_data['today_per']; ?></p>
                </dd>
                <dd>
                    <span>笔数</span>
                    <p id="count"><?php echo $a_view_data['today_count']; ?></p>
                </dd>
                <dd>
                    <span>新增评价</span>
                    <p id="comment"><?php echo $a_view_data['today_comment']; ?></p>
                </dd>
            </dl>
        </div>
        <!-- 数据 -->
    </div>
    <!-- 我的分享 -->

    <!-- 遮罩层 -->
    <div class="lay"></div>
    <!-- 遮罩层 -->

    <!-- 提示 -->
    <div class="tips">
        <p>提示</p>
        <span>通过资质认证后，才能使用此功能</span>
        <div class="tipsBtn">
            <a href="<?php echo $this->router->url('audit')?>">去认证</a>
            <a class="cancel">取消</a>
        </div>
    </div>
    <!-- 提示 -->
</body>
</html>

<script>

function change_day(day) {
    var today_income     = "<?php echo $a_view_data['today_income']; ?>";
    var today_count      = "<?php echo $a_view_data['today_count']; ?>";
    var today_per        = "<?php echo $a_view_data['today_per']; ?>";
    var today_comment    = "<?php echo $a_view_data['today_comment']; ?>";
    var yestoday_income  = "<?php echo $a_view_data['yestoday_income']; ?>";
    var yestoday_count   = "<?php echo $a_view_data['yestoday_count']; ?>";
    var yestoday_per     = "<?php echo $a_view_data['yestoday_per']; ?>";
    var yestoday_comment = "<?php echo $a_view_data['yestoday_comment']; ?>";
    var seven_income     = "<?php echo $a_view_data['seven_income']; ?>";
    var seven_count      = "<?php echo $a_view_data['seven_count']; ?>";
    var seven_per        = "<?php echo $a_view_data['seven_per']; ?>";
    var seven_comment    = "<?php echo $a_view_data['seven_comment']; ?>";
    if (day==1) {
        $(".while a").removeClass('whileCur');
        $(".today").addClass('whileCur');
        $("#income").html(today_income);
        $("#count").html(today_count);
        $("#per").html(today_per);
        $("#comment").html(today_comment);
    } else if (day==2) {
        $(".while a").removeClass('whileCur');
        $(".yestoday").addClass('whileCur');
        $("#income").html(yestoday_income);
        $("#count").html(yestoday_count);
        $("#per").html(yestoday_per);
        $("#comment").html(yestoday_comment);
    } else if (day==7) {
        $(".while a").removeClass('whileCur');
        $(".week").addClass('whileCur');
        $("#income").html(seven_income);
        $("#count").html(seven_count);
        $("#per").html(seven_per);
        $("#comment").html(seven_comment);
    }
}

</script>