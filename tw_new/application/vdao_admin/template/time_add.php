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
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/public.css"/>
    <link rel="stylesheet" href="static/style_default/style/addTime.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/addTime.js"></script>
    <title></title>
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

        <!-- 添加时间段 -->
        <div class="addTime">
            <p>添加时间段</p>
            <div class="editBox">
                <form action="time_add" method="post">
                    <ul>
                        <li class="stageName">
                            <em>阶段名称</em>
                            <input type="text" id="stage_name" name="name" />
                            <span class="hide">
                                <img src="" alt=""/>
                                <em></em>
                            </span>
                        </li>
                        <li class="stageTime">
                            <em>阶段时间</em>
                            <input type="text" id="stage_timeA" name="start" />
                            <dfn>-</dfn>
                            <input type="text" id="stage_timeB" name="end_tiem" />
                            <span class="hide">
                                <img src="" alt=""/>
                                 <em></em>
                            </span>
                        </li>
                    </ul>
                    <input type="submit" value="确定" id="timeSub"/>
                </form>
            </div>
        </div>
        <!-- 添加时间段 -->


    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>