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
    <link rel="stylesheet" href="static/style_default/style/joinApply.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/common.js"></script>
    <script src="static/style_default/script/joinApplication.js"></script>
    <title>加盟列表</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 加盟申请 -->
    <div class="joinApply">
        <p class="pjoTitle">
            <a href="javascript:history.back(-1);" class="back"><img src="static/style_default/images/yongping_03.png" alt=""/></a>
            <span>加盟申请</span>
            <a href="join_apply" class="creat">创建新申请</a>
        </p>
        <!-- 列表 -->
        <div class="joinContainer">
            <ul>
                <?php foreach ($a_view_data['join'] as $key => $value): ?>
                <li class="joinList">
                    <a href="join_update-<?php echo $value['join_id']; ?>">
                        <div class="joinStore">
                            <span><?php echo $value['join_storename']; ?></span>
                            <em class="joinState <?php if ($value['join_state'] == 1) {
                                echo 'joining';
                            } else if ($value['join_state'] == 2 || $value['join_state'] == 4) {
                                echo 'joining';
                            } else if ($value['join_state'] == 3) {
                                echo 'adopt';
                            } else if ($value['join_state'] == 5) {
                                echo 'reject';
                            } ?>">
                            <?php if ($value['join_state'] == 1) {
                                echo '草稿';
                            } else if ($value['join_state'] == 2 || $value['join_state'] == 4) {
                                echo '申请中';
                            } else if ($value['join_state'] == 3) {
                                echo '已通过';
                            } else if ($value['join_state'] == 5) {
                                echo '已驳回';
                            } ?>
                            </em>
                        </div>
                        <div class="joiner">
                            <span><?php echo $value['join_linkman']; ?></span>
                        </div>
                        <div class="joinContact">
                            <span><?php echo $value['join_phone']; ?></span>
                            <em><?php echo date('Y.m.d', $value['join_time']); ?></em>
                        </div>
                        <?php if ($value['join_state'] == 3 || $value['join_state'] == 5) { ?>
                        <div class="successText">
                            <span>
                            <?php if ($value['join_state'] == 3) {
                                echo '我们会安排专人与您取得联系，请耐心等待';
                            } else {
                                echo '理由：'.$value['join_refusereason'];
                            } ?>
                            </span>
                        </div>
                        <?php } ?>
                    </a>
                </li>
                <?php endforeach ?>
            </ul>
        </div>
        <!-- 列表 -->
    </div>
    <!-- 加盟申请 -->

</body>
</html>
