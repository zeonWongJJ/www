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
    <link rel="stylesheet" href="static/style_default/style/releaseDynamic.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/releaseDynamic.js"></script>
    <title>发布动态</title>
</head>
<body>
<!-- 拉框开始 -->
<?php echo $this->display('head'); ?>
<!-- 拉框结束 -->
<!--  发布动态  -->
<div class="releaseDynamic">
    <form id="moodform" action="mood_add" method="post" enctype="multipart/form-data">
        <p class="pjoTitle">
            <a href="user_mood" style="top:0.5rem;" class="backUp" style="top:top:0.5rem;">
            <img src="static/style_default/images/yongping_03.png" />
            </a>
            <span>发布动态</span>
            <a href="javascript:$('#moodform').submit();" style="top:0.3rem;" class="release">发布</a>
        </p>
        <div class="dynamicBox">
            <textarea name="mood_content" cols="30" rows="10" placeholder="说说新鲜事"></textarea>
            <div class="photoDynamic">
                <div class="container">
                    <!--    照片添加    -->
                    <div class="z_photo">
                        <div class="z_file">
                            <input type="file" style="color:transparent; opacity:0;" name="file[]"  multiple="multiple" id="file" accept="images/*" onchange="imgChange('z_photo','z_file');" />
                        </div>
                    </div>

                    <!--遮罩层-->
                    <div class="z_mask">
                        <!--弹出框-->
                        <div class="z_alert">
                            <p>确定要删除这张图片吗？</p>
                            <p>
                                <span class="z_cancel">取消</span>
                                <span class="z_sure">确定</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- 发布动态  -->
<!-- 提示层 -->
<div class="tips"></div>

</body>
</html>

<script>


</script>