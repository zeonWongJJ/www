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
    <link rel="stylesheet" href="static/style_default/style/forwardDynamic.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/releaseDynamic.js"></script>
    <title>转发动态</title>
    <script>
        $(function(){
            $(".release").click(function(){
                $('#moodform').submit();
                // $(".tips").stop().show(100).delay(3000).hide(100);
                // $(".tips").html("发布成功！");
            });
        })
    </script>
</head>
<body>
<!-- 拉框开始 -->
<?php echo $this->display('head'); ?>
<!-- 拉框结束 -->
<!--  转发动态  -->
<div class="forwardDynamic">
    <form id="moodform" action="mood_relay" method="post">
        <p class="pjoTitle">
            <a style="top:0.5rem;" href="javascript:window.history.back();" class="backUp"><img src="static/style_default/images/yongping_03.png" /></a>
            <span>转发动态</span>
            <a style="top:0.3rem;" class="release">发布</a>
        </p>
        <div class="forwardBox">
            <input type="hidden" name="relay_mood" value="<?php echo $a_view_data['mood_id']; ?>">
            <textarea name="mood_content" cols="30" rows="10" placeholder="说说转发的心得"></textarea>
            <div class="beForwarded">
                <?php if (empty($a_view_data['user_pic'])) {
                    echo '<img src="static/style_default/images/tou_03.png" />';
                } else {
                    echo '<img src="'.$a_view_data['user_pic'].'" />';
                } ?>
                <em>
                    <span>@ <?php echo $a_view_data['user_name']; ?></span>
                    <p><?php echo $a_view_data['mood_content']; ?></p>
                </em>
            </div>
        </div>
    </form>
</div>
<!-- 转发动态  -->
<!-- 提示层 -->
<div class="tips"></div>

</body>
</html>