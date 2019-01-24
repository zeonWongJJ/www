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
    <link rel="stylesheet" href="static/style_default/style/suppliesAddCate.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/suppliesAddCate.js"></script>
    <title>添加分类</title>
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
            <p>添加分类</p>
            <div class="cateList">
                <form action="<?php echo $this->router->url('cons_add')?>" method="post">
                    <ul>
                        <li class="category">
                            <span>所属分类</span>
                            <select name="cons_id_1" id="cateA">
                                <option value="0">顶级分类</option>
								<?php foreach ($a_view_data as $cons) { ?>
                                <option value="<?php echo  $cons['id'] . '-' . $cons['cons_id']?>"><?php echo $cons['cons_name']?></option>
                                <?php }?>
                            </select>
                            <select name="cons_id_2" class="cateB hide">
                            </select>
                            <em class="cateTip hide">
                                <img src="static/style_default/image/f_03.png" alt=""/>
                                <span></span>
                            </em>
                            <input type="hidden" name="cons_id" class="cons_id" value="0">
                        </li>
                        <li class="openClose">
                            <span>是否开放</span>
                            <em class="sure">
                                <img  src="static/style_default/image/pro_38.png" alt=""/>
                                <span>是</span>
                            </em>
                            <em  class="deny">
                                <img src="static/style_default/image/pro_38.png" alt=""/>
                                <span>否</span>
                            </em>
                            <em class="cateTip hide">
                                <img src="static/style_default/image/f_03.png" alt=""/>
                                <span></span>
                            </em>
                            <input type="hidden" name="show" class="show" value="1">
                        </li>
                        <li class="addCateName">
                            <span>添加分类名称</span>
                            <input type="text" id="add_cateName" placeholder="请输入14个字符/汉字" name="name" />
                            <em class="cateTip hide">
                                <img src="static/style_default/image/f_03.png" alt=""/>
                                <span></span>
                            </em>
                        </li>
                    </ul>
                    <input type="submit" id="cateSub" value="确定"/>
                </form>
            </div>
        </div>
        <!-- 添加分类 -->


        <!--  重要提示 -->
        <div class="tips1 hide">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png" alt=""/>
            <p>
                <span>▪ 确认删除这一部分分类吗？</span>
                <span>▪ 删除后不可恢复，所删除分类下的所有产品也将被删除</span>
            </p>
            <div class="tipsBtn">
                <em>确定</em>
                <a>再看看</a>
            </div>

        </div>
        <!--  重要提示 -->
    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>