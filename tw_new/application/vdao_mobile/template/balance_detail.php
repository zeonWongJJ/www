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
    <link rel="stylesheet" href="static/style_default/style/rechange.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/plugin/flexible.js"></script>
    <title>明细详情</title>
</head>
<body>
<!-- 拉框开始 -->
<?php echo $this->display('head'); ?>
<!-- 拉框结束 -->
<!-- 明细详情 -->
<div class="rechange">
    <p class="pjoTitle">
        <img style="margin-top:0.35rem" src="static/style_default/images/kefu_03.png" onclick="javascript:window.history.back();" />
        <span>明细详情</span>
    </p>
    <!-- 金额 -->
    <div class="amount">
        <span><?php if ($a_view_data['detail']['ub_type'] == 1) { echo '进账'; } else { echo '出账'; } ?>金额</span>
        <p>¥<?php echo $a_view_data['detail']['ub_money']; ?></p>
        <em>交易成功</em>
    </div>
    <!-- 金额 -->
    <!-- 金额信息 -->
    <div class="amountInfo">
        <ul>
            <li>
                <em>项目</em>
                <span><?php echo $a_view_data['detail']['ub_item']; ?></span>
            </li>
            <li>
                <em>说明</em>
                <span><?php echo $a_view_data['detail']['ub_description']; ?></span>
            </li>
            <li>
                <em>创建时间</em>
                <span>
                    <span><?php echo date('Y-m-d', $a_view_data['detail']['ub_time']); ?></span>
                    <em style="font-style:normal;"><?php echo date('H:i:s', $a_view_data['detail']['ub_time']); ?></em>
                </span>
            </li>
            <li>
                <em>订单号</em>
                <span>
                  <?php echo $a_view_data['detail']['ub_number']; ?>
                </span>
            </li>
        </ul>
    </div>
    <!-- 金额信息 -->
</div>
<!-- 明细详情  -->
</body>
</html>