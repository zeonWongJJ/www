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
    <link rel="stylesheet" href="static/style_default/style/refund.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <title>查看退款</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <div class="logistics">
        <p class="pjoTitle">
            <a href="goods_list-<?php echo $this->router->get(1)?>"><img src="static/style_default/images/kefu_03.png" alt=""/></a>
            <span>查看退款</span>
        </p>

        <div class="balance">
            <p class="p1">
                <span>退款金额</span>
                <em><?php echo $a_view_data['order']['actual_pay']?>元</em>
            </p>
            <p class="p2">
                <span>退回账户</span>
                <em><?php if ( $a_view_data['order']['payment_code'] == 'offline') {
                    echo "微信";
                    } else if ( $a_view_data['order']['payment_code'] == 'alipay') {
                    echo "支付宝";
                    } else if ( $a_view_data['order']['payment_code'] == 'unionpay') {
                    echo "银联";
                    }?></em>
            </p>
        </div>
        <!-- 物流订单 -->
        <div class="logInfo">
            <p>退款进度</p>
            <div class="expressContainer">
                <ul>
                    <?php if (empty($a_view_data['tuik'])) {?>
                    <li class="expressList">
                        <a class="exTime">
                        </a>
                        <a class="line">
                            <i></i>
                            <hr/>
                        </a>
                        <a class="exInfo">
                            <span>退款成功</span>
                        </a>
                    </li>
                    <?php } else {?>
                    <li class="expressList exCur">
                        <a class="exTime">
                            <p><?php if ( $a_view_data['order']['payment_code'] == 'offline') {
                                echo $a_view_data['tuik']['refund_success_time_0'];
                                } else if ( $a_view_data['order']['payment_code'] == 'alipay') {
                                echo $a_view_data['tuik']['send_pay_date'];
                                } else if ( $a_view_data['order']['payment_code'] == 'unionpay') {
                                // echo $a_view_data['tuik'][''];
                                }?>
                            </p>    
                        </a>
                        <a class="line">
                            <i></i>
                            <hr/>
                        </a>
                        <a class="exInfo">
                            <span>退款成功</span>
                        </a>
                    </li>
                    <?php }?>
                    <?php foreach ($a_view_data['reim'] as $reim) {?>
                    <li class="expressList exCur">
                        <a class="exTime">
                            <p><?php echo date('Y-m-d H:i', $reim['time'])?></p>
                        </a>
                        <a class="line">
                            <i></i>
                            <hr/>
                        </a>
                        <a class="exInfo">
                            <span><?php echo $reim['reimburse']?></span>
                        </a>
                    </li>
                    <?php }?>
                    
                </ul>
            </div>
        </div>
        <!-- 物流订单 -->
    </div>


</body>
</html>