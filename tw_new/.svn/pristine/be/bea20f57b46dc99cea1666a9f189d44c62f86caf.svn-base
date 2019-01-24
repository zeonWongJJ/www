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
    <link rel="stylesheet" href="./static/style_default/style/addCate.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/addCate.js"></script>
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

        <!-- 添加分类 -->
        <div class="addCate">
            <p class="navp">新闻管理 > <a href="cate_showlist">新闻分类</a> > 添加分类</p>
            <div class="cateList">
                <form action="<?php echo $this->router->url('cate_add'); ?>" method="post">
                    <ul>
                        <li class="category">
                            <span>所属分类</span>
                            <select name="pid_lev" id="cateA">
                                <option value="999">请选择上级</option>
                                <option value="999">顶级分类</option>
                                <?php foreach ($a_view_data as $key => $value): ?>
                                <option value="<?php echo $value['cate_id'] . '-' . $value['cate_level']; ?>">
                                <?php echo str_repeat('└―', $value['cate_level']) . $value['cate_name']; ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                            <em class="cateTip hide">
                                <img src="./static/style_default/image/f_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <input type="hidden" name="is_show" value="1">
                        <li class="openClose">
                            <span>是否开放</span>
                            <em class="sure" value="1">
                                <img src="./static/style_default/image/pro_38.png" />
                                <span>是</span>
                            </em>
                            <em class="deny" value="0">
                                <img src="./static/style_default/image/pro_38.png" />
                                <span>否</span>
                            </em>
                            <em class="cateTip hide">
                                <img src="./static/style_default/image/f_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="addCateName">
                            <span>分类名称</span>
                            <input type="text" name="cate_name" id="add_cateName" placeholder="请输入14个字符/汉字"/>
                            <em class="cateTip hide">
                                <img src="./static/style_default/image/f_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="cateDescribe">
                            <span>分类描述</span>
                            <textarea style="vertical-align:top" name="cate_description" id="cateText" cols="30" rows="10"></textarea>
                            <span style="position:absolute; bottom:3px; left:358px; font-size:12px;"><s id="cateNum">0</s>/200</span>
                            <em class="cateTip hide">
                                <img src="./static/style_default/image/f_03.png" />
                                <span></span>
                            </em>
                        </li>
                    </ul>
                    <input type="submit" id="cateSub" value="确定"/>
                </form>
            </div>
        </div>
        <!-- 添加分类 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>