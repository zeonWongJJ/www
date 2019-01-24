
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
    <link rel="stylesheet" href="./static/style_default/style/messages.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <title>消息管理</title>
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

        <!-- 产品列表 -->
        <div class="messagesBox">
            <p>消息管理</p>
            <!--消息模块开始-->
            <div class="newsBox clearfix">
                    <?php foreach ($a_view_data['get'] as $value) {?>
                    <div class="sigleNews">
                        <p class="date"><i></i><?php echo $value['day']; ?></p>
                        <ul>
                            <?php foreach ($a_view_data['messg'] as $messg) {if ($value['day'] == date('Ymd',$messg['mess_time'])) {?>
                            <li>
                              <span class="news"><i class="red"><?php echo $messg['ues_name']; ?></i><?php echo $messg['content']; ?></span>
                              <i class="time"><?php echo date('H:i', $messg['mess_time']); ?></i>
                            </li>
                            <?php }}?>
                        </ul>
                    </div>
                    <?php }?>
            </div>
            <!--消息模块结束-->
        </div>
             <!-- 分页 -->
                    <div class="page" style="margin-bottom:30px;">
                        <?php echo $this->pages->link_style_one($this->router->url('messages_showlist-', [], false, false)); ?>
                        <span style="background:none">共计<em> <?php echo $a_view_data['getr']; ?> </em>条数据</span>
                    </div>
             <!-- 分页 -->
        </div>

        <!-- 产品列表 -->
    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>