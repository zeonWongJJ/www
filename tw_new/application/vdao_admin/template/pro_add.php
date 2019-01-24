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
    <link rel="stylesheet" href="static/style_default/style/productAddCate.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/productAddCate.js"></script>
    <title>产品分类添加</title>
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
            <p>添加产品分类</p>
            <div class="cateList">
                <form action="<?php echo $this->router->url('pro_add')?>" method="post">
                    <ul>
                        <li class="category">
                            <span>所属分类</span>
                            <select name="pro_id_1" id="cateA">
                                <option value="0">顶级分类</option>
                                <?php foreach ($a_view_data as $pro) {?>
                                <option value="<?php echo $pro['pro_id'] . '-' . $pro['proid']?>"><?php echo $pro['pro_name']?></option>
								<?php }?>
                            </select>
                            <select name="pro_id_2" class="cateB hide">
                                
                            </select>
                            <em class="cateTip hide">
                                <img src="static/style_default/image/f_03.png" alt=""/>
                                <span></span>
                            </em>
                            <input type="hidden" name="proid" class="proid" value="0">
                        </li>
                        <li class="openClose">
                            <span>是否显示</span>
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
                            <input type="hidden" name="show" value="1" class="show">
                        </li>
                        <li class="addCateName">
                            <span>添加分类名称</span>
                            <input type="text" id="add_cateName" placeholder="请输入14个字符/汉字" name="name" />
                            <em class="cateTip hide">
                                <img src="static/style_default/image/f_03.png" alt=""/>
                                <span></span>
                            </em>
                        </li>
                        <!-- <li class="cateDescribe">
                            <span>分类描述</span>
                            <textarea style="vertical-align:top" name="" id="cateText" cols="30" rows="10"></textarea>
                            <span style="position:absolute; bottom:3px; left:358px; font-size:12px;"><s id="cateNum">200</s>/200</span>
                            <em class="cateTip hide">
                                <img src="static/style_default/image/f_03.png" alt=""/>
                                <span></span>
                            </em>
                        </li> -->
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