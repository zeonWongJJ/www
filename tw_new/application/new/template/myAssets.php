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
    <link rel="stylesheet" href="../css/myAssets.css"/>
    <script src="../js/jquery-1.8.2.min.js"></script>
    <script src="../js/flexible.js"></script>
    <title></title>
</head>
<body>
    <!-- 交易记录 -->
    <div class="transactionRecord">
        <!-- 账户总额 -->
        <div class="totalAccount">
            <h2>帐户总额（元）</h2>
            <span><?php echo $a_view_data['total']; ?></span>
        </div>
        <!-- 账户总额 -->
        <!-- 记录列表 -->
        <div class="record">
            <div class="recordList">
                <span>2017年04月</span>
                <ul>
                    <?php foreach ($a_view_data['detail'] as $key => $value): ?>
                     <li>
                        <p>
                            <span><?php echo date('m/d', $value['variation_time']); ?></span>
                            <em <?php if($value['variation_type'] == '1') { echo "class='addP'"; } else { echo "class='miusP'"; }; ?>><?php echo $value['variation']; ?></em>
                        </p>
                        <p>
                            <span><?php echo date('H:i', $value['variation_time']); ?></span>
                            <em><?php echo $value['change_hints']; ?></em>
                        </p>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
<!--             <div class="recordList">
                <span>2017年03月</span>
                <ul>
                    <li>
                        <p>
                            <span >04/19</span>
                            <em class="addP">+1积分</em>
                        </p>
                        <p>
                            <span>9:30</span>
                            <em>兑换2元礼包</em>
                        </p>
                    </li>

                </ul>
            </div> -->
        </div>
        <!-- 记录列表 -->
    </div>
    <!-- 交易记录 -->
</body>
</html>