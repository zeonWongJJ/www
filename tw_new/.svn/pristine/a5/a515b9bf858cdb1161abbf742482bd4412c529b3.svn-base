<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="../css/common.css"/>
    <link rel="stylesheet" href="../css/bankCardAuthen.css"/>
    <script src="../js/jquery-1.8.2.min.js"></script>
    <title></title>
    <script>
        $(function(){
            $(".bankCardAuthen>form").click(function(){
                console.log($(this).submit());
            });
        })

    </script>
</head>
<body>
    <!--  银行卡认证 -->
    <div class="bankCardAuthen">
        <!--  文字滚动栏 -->
        <div class="bankInfo">
            <marquee behavior="" direction="">系统已在24小时，给您账号打款0.01元~1元</marquee>
        </div>
        <!--  文字滚动栏 -->
        <!--  用户银行卡信息 -->
        <form action="<?php echo $this->router->url('bankcard_two'); ?>" method='post'>
            <ul class="userCard">
                <li>
                    <span>姓名</span>
                    <em><?php echo $a_view_data['account_name']; ?></em>
                </li>
                <li>
                    <span>开户银行</span>
                    <em><?php echo $a_view_data['bank_name']; ?></em>
                </li>
                <li>
                    <span>卡号</span>
                    <em><?php echo $a_view_data['card_number']; ?></em>
                </li>
                <li>
                    <span>开户支行</span>
                    <em><?php echo $a_view_data['bank_name']; ?></em>
                </li>
            </ul>
            <!-- 收到金额 -->
            <div class="SumMoney">
                <span>收到金额</span>
                <input type="text" name="amount" />元
            </div>
            <!-- 收到金额 -->
            <!--  提交审核 -->
            <div class="bankSub">
                <img src="../img/bankSub.png" alt=""/>
            </div>
            <!--  提交审核 -->
        </form>
        <!--  用户银行卡信息 -->

    </div>
    <!--  银行卡认证 -->
</body>
</html>