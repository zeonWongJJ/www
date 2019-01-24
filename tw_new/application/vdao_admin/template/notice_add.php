<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML,ASP,PHP,SQL">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=6" ><!-- 使用IE6 -->
    <meta http-equiv="X-UA-Compatible" content="IE=7" ><!-- 使用IE7 -->
    <meta http-equiv="X-UA-Compatible" content="IE=8" ><!-- 使用IE8 -->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="./static/style_default/style/common.css"/>
    <link rel="stylesheet" href="./static/style_default/style/public.css"/>
    <link rel="stylesheet" href="./static/style_default/style/releaseAnnouncement.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script type="text/javascript" charset="utf-8" src="plugin/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="plugin/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="plugin/ueditor/lang/zh-cn/zh-cn.js"></script>
    <title>发布公告</title>
</head>
<body style="background:#efefef;">
<!--  后台管理 -->
<div class="productClassification">
    <?php echo $this->display('header'); ?>
    <!--  右侧内容 -->
    <article>
        <!--  标题 -->
        <?php echo $this->display('top'); ?>
        <!--  标题 -->

        <!-- 发布公告 -->
        <div class="announcement">
            <p><a href="notice_showlist" style="color:#000;">公告管理</a> > 发布公告</p>
            <div class="ggTitle">
                <span>发布公告</span>
            </div>

        </div>
        <div class="announcementList">
            <form id="addform" action="<?php echo $this->router->url('notice_add'); ?>" method="post">
                <ul>
                    <li class="announcementTitle">
                        <span>公告标题</span>
                        <input type="text" name="notice_title" id="announTitle_name" style="width:50%;" />
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="editBox" style="overflow:hidden;">
                        <span style="float:left;">图文说明</span>
                        <script id="editor" style="width:90%; height:300px; float:left;" name="notice_content" type="text/plain"></script>
                    </li>
                </ul>
            </form>
            <span id="announceSub">确定发布</span>
        </div>
        <!-- 发布公告 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>

<script>
    var ue = UE.getEditor('editor');
    $('#announceSub').click(function(event) {
        $('#addform').submit();
    });
</script>