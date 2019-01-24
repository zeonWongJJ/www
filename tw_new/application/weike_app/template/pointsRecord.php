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
    <link rel="stylesheet" href="css/pointsRecord.css"/>
    <title></title>
</head>
<body>
    <!--  积分记录 -->
    <div class="pointsRecord">
        <!--  头部 -->
        <header class="head">
            <em>&lt;</em>
            <span>积分记录</span>
        </header>
        <!-- 头部 -->
        <!-- 记录列表 -->
        <div class="record">
            <div class="recordList">
                <span>2017年04月</span>
                <ul>
                    <?php foreach ($a_view_data as $key => $value): ?>
                    <li>
                        <p>
                            <span><?php echo date('m/d', $value['variation_time']); ?></span>
                            <em <?php if($value['variation_type'] == '1') { echo "class='addP'"; } else { echo "class='miusP'"; }; ?>><?php echo $value['variation']; ?>积分</em>
                        </p>
                        <p>
                            <span><?php echo date('H:i', $value['variation_time']); ?></span>
                            <em><?php echo $value['change_hints']; ?></em>
                        </p>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <!-- 记录列表 -->
    </div>
    <!--  积分记录 -->
</body>
</html>