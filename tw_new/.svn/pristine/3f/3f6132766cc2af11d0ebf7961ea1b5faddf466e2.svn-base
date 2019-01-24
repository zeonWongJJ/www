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
    <link rel="stylesheet" href="static/style_default/style/productClassification.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/productClassification.js"></script>
    <script src="static/style_default/script/attri.js"></script>
    <title>属性分类</title>
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

        <!-- 产品分类 -->
        <div class="classification">
            <p>产品管理>属性分类</p>
            <!-- 产品分类列表 -->
            <div class="classificationList">
                <form action="<?php echo $this->router->url('attri')?>" method='post' id="formId">
                    <a href="<?php echo $this->router->url('attri_add')?>"><img src="static/style_default/image/pro_03.png" alt=""/>添加分类</a>
                    <div class="searchClassifi">
                        <input type="text" placeholder="分类名称" onfocus="javascript:if(this.value=='分类名称')this.value='';" name="name"/>
                        <i onclick="document.getElementById('formId').submit();"><img src="static/style_default/image/s_03.png" alt=""/></i>
                    </div>
                </form>
                <!-- 分级列表 -->
                <div class="cateList">
                    <div class="cateHead">
                        <a class="c1">
                            <input type="checkbox"/>
                            <label for=""><img src="static/style_default/image/pro_07.png" alt=""/></label>
                            <span style="margin-left:25px;">全选</span>
                            <span style="margin-left:50px;">属性分类</span>
                        </a>
                        <a class="c4">
                            <span>启用/暂用</span>
                        </a>
                        <a class="c5">
                            <span>操作</span>
                        </a>
                    </div>
                    <?php if (empty($a_view_data['a_name'])) { foreach ($a_view_data['pro'] as $pro) {
                        if ($pro['grade'] == 1) {?>
                        <div class="cateA" id="<?php echo 'co_'.$pro['attri_id']; ?>">
                            <a class="c1">
                                <input type="checkbox"/>
                                <label for="" value="<?php echo $pro['attri_id']?>"><img src="static/style_default/image/pro_07.png" alt=""/></label>
                                <img src="static/style_default/image/bv.png" alt=""/>
                                <span><?php echo $pro['attri_name']?></span>
                            </a>
                            <a class="c4 upta1" value="<?php echo $pro['attri_id']?>" id="<?php echo 'up_'.$pro['attri_id']; ?>">
                                <?php if ($pro['show'] == 1) {?>
                                    <img src="static/style_default/image/pro_10.png" alt=""/>
                                <?php } else {?>
                                <img src="static/style_default/image/pro_33.png" alt=""/>
                                <?php }?>
                            </a>
                            <a class="c5">
                                <img src="static/style_default/image/pro_26.png" alt="" class="dele2" value="<?php echo $pro['attri_id']?>"/>
                                <a href="attri_up-<?php echo $pro['attri_id']?>"><img src="static/style_default/image/pro_28.png" alt=""/></a>
                            </a>
                            <?php foreach ($a_view_data['pro'] as $prot) {
                                 if ($pro['attri_id'] == $prot['attri_cupid']) {?>
                            <div class="cateB hide"  id="<?php echo 'co_'.$prot['attri_id']; ?>">
                                <a class="c1">
                                    <input type="checkbox"/>
                                    <label for="" value="<?php echo $prot['attri_id']?>"><img src="static/style_default/image/pro_07.png" alt=""/></label>
                                    <img src="static/style_default/image/bv.png" alt=""/>
                                    <span><?php echo $prot['attri_name']?></span>
                                </a>
                                <a class="c4 upta1" value="<?php echo $prot['attri_id']?>" id="<?php echo 'up_'.$prot['attri_id']; ?>">
                                    <?php if ($prot['show'] == 1) {?>
                                        <img src="static/style_default/image/pro_10.png" alt=""/>
                                    <?php } else {?>
                                        <img src="static/style_default/image/pro_33.png" alt=""/>
                                    <?php }?>
                                </a>
                                <a class="c5">
                                    <img src="static/style_default/image/pro_26.png" alt="" class="dele2" value="<?php echo $prot['attri_id']?>"/>
                                    <a href="attri_up-<?php echo $prot['attri_id']?>"><img src="static/style_default/image/pro_28.png" alt=""/></a>
                                </a>
                               	<?php foreach ($a_view_data['pro'] as $proo) {
                                    if ($prot['attri_id'] == $proo['attri_cupid']) {?>
                                <div class="cateC"  id="<?php echo 'co_'.$proo['attri_id']; ?>">
                                    <a class="c1">
                                        <input type="checkbox"/>
                                        <label for="" value="<?php echo $proo['attri_id']?>"><img src="static/style_default/image/pro_07.png" alt=""/></label>
                                        <span><?php echo $proo['attri_name']?></span>
                                    </a>
                                    <a class="c4 upta1" value="<?php echo $proo['attri_id']?>" id="<?php echo 'up_'.$proo['attri_id']; ?>">
                                        <?php if ($proo['show'] == 1) {?>
                                            <img src="static/style_default/image/pro_10.png" alt=""/>
                                        <?php } else {?>
                                            <img src="static/style_default/image/pro_33.png" alt=""/>
                                        <?php }?>
                                    </a>
                                    <a class="c5">
                                        <img src="static/style_default/image/pro_26.png" alt="" class="dele2" value="<?php echo $proo['attri_id']?>" />
                                        <a href="attri_up-<?php echo $proo['attri_id']?>"><img src="static/style_default/image/pro_28.png" alt=""/></a>
                                    </a>
                                </div>
                                <?php }}?>
                            </div>
                            <?php }}?>
                    </div>
                    <?php }}} else {foreach ($a_view_data['pro'] as $pro) {?>
                        <div class="cateA" id="<?php echo 'co_'.$pro['attri_id']; ?>">
                            <a class="c1">
                                <input type="checkbox"/>
                                <label for="" value="<?php echo $pro['attri_id']?>"><img src="static/style_default/image/pro_07.png" alt=""/></label>
                                <img src="static/style_default/image/bv.png" alt=""/>
                                <span><?php echo $pro['attri_name']?></span>
                            </a>
                            <a class="c4 upta1" value="<?php echo $pro['attri_id']?>" id="<?php echo 'up_'.$pro['attri_id']; ?>">
                                <?php if ($pro['show'] == 1) {?>
                                    <img src="static/style_default/image/pro_10.png" alt=""/>
                                <?php } else {?>
                                <img src="static/style_default/image/pro_33.png" alt=""/>
                                <?php }?>
                            </a>
                            <a class="c5">
                                <img src="static/style_default/image/pro_26.png" alt="" class="dele2" value="<?php echo $pro['attri_id']?>"/>
                                <a href="attri_up-<?php echo $pro['attri_id']?>"><img src="static/style_default/image/pro_28.png" alt=""/></a>
                            </a>
                        </div>
                    <?php }}?>
                </div>
                <!-- 分级列表 -->
            </div>
            <!-- 产品分类列表 -->
        </div>
        <!-- 产品分类 -->

        <!--  底部选项 -->
        <div class="bottomTool">
            <a class="bottomAllSelect">
                <input type="checkbox" id="bottomSelect"/>
                <label for="bottomSelect"><img src="static/style_default/image/pro_07.png" alt=""/></label>
                <span>全选</span>
            </a>
            <a class="bottomDelect1">
                <img src="static/style_default/image/pro_26.png" alt=""/>
                <span>删除</span>
            </a>
            <a class="bottomProvisional1">
                <img src="static/style_default/image/pro_52.png" alt=""/>
                <span>暂用</span>
            </a>

        </div>
        <!--  底部选项 -->

        <!--  重要提示 -->
        <div class="tips1 hide">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png" alt="" class="quchu" />
            <p>
                <span>▪ 确认删除这一部分分类吗？</span>
                <span>▪ 删除后不可恢复，所删除分类下的所有产品也将被删除</span>
            </p>
            <div class="tipsBtn">
                <em class="quedi">确定</em>
                <a class="quchu">再看看</a>
            </div>

        </div>
        <!--  重要提示 -->
    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>

