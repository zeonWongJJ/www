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
    <link rel="stylesheet" href="./static/style_default/style/releaseNews.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script type="text/javascript" charset="utf-8" src="plugin/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="plugin/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="plugin/ueditor/lang/zh-cn/zh-cn.js"></script>
    <title>发布新闻</title>
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
        <div class="releaseNews">
            <p><a href="news_showlist" style="color:#000;">新闻管理</a> >发布新闻</p>
            <div class="releaseNewsTitle">
                <span>发布新闻</span>
            </div>

        </div>
        <div class="NewsList">
            <form id="addform" action="<?php echo $this->router->url('news_add'); ?>" method="post">
                <ul>
                    <li class="category">
                        <span>所属分类</span>
                        <select name="cate_id" id="cateA">
                            <option>请选择分类</option>
                            <?php foreach ($a_view_data as $key => $value): ?>
                                <option value="<?php echo $value['cate_id']; ?>"><?php echo str_repeat('└―', $value['cate_level']) . $value['cate_name']; ?></option>
                            <?php endforeach ?>
                        </select>
                        <em class="cateTip hide">
                            <img src="./static/style_default/image/f_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="NewsTitle">
                        <span>新闻标题</span>
                        <input type="text" size="80" id="NewsTitle_name" name="news_title" />
                        <em class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <span></span>
                        </em>
                    </li>
                    <li class="editBox" style="overflow:hidden;">
                        <span style="float:left;">图文说明</span>
                        <script id="editor" style="width:90%; height:300px; float:left;" name="news_content" type="text/plain"></script>
                    </li>
                </ul>
            </form>
            <span id="NewsSub">确定发布</span>
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
    $("#NewsSub").click(function(event) {
        $("#addform").submit();
    });
</script>