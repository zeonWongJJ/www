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
    <link rel="stylesheet" href="static/style_default/style/suppliesManagement.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/selectTotal.js"></script>
    <script src="static/style_default/script/suppliesManaagement.js"></script>
    <title>耗材分类</title>
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

        <!-- 耗材分类 -->
        <div class="suppliesCate">
            <p>耗材管理>耗材分类</p>
            <!-- 耗材分类列表 -->
            <div class="suppliesCateList">
                 <form action="<?php echo $this->router->url('cons')?>" method='post' id="formId">
                    <a href="<?php echo $this->router->url('cons_add')?>"><img src="static/style_default/image/pro_03.png" alt=""/>添加分类</a>
                    <div class="searchSupplies">
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
                            <span style="margin-left:25px; margin-right:40px;">全选</span>
                            <span>耗材分类</span>
                        </a>
                        <a class="c2" style="text-align:center;">
                            <span>启用/暂用</span>
                        </a>
                        <a class="c3">
                            <span>操作</span>
                        </a>
                    </div>
                    <?php if (empty($a_view_data['a_name'])) {foreach ($a_view_data['cons'] as $cons) {
                        if ($cons['cons_id'] == 1) {?>
                        <div class="cateA" id="<?php echo 'co_'.$cons['id']; ?>">
                            <a class="c1">
                                <input type="checkbox"/>
                                <label for="" value="<?php echo $cons['id']?>"><img src="static/style_default/image/pro_07.png" alt=""/></label>
                                <img src="static/style_default/image/bv.png" alt=""/>
                                <span><?php echo $cons['cons_name']?></span>
                            </a>
                            <a class="c2 upta" value="<?php echo $cons['id']?>" id="<?php echo 'up_'.$cons['id']; ?>">
                                <?php if ($cons['cons_show'] == 1) {?>
                                    <img src="static/style_default/image/pro_10.png" alt=""/>
                                <?php } else {?>
                                <img src="static/style_default/image/pro_33.png" alt=""/>
                                <?php }?>
                            </a>
                            <a class="c3">
                                <img src="static/style_default/image/pro_26.png" alt="" class="dele1" value="<?php echo $cons['id']?>"/>
                                <a href="cons_update-<?php echo $cons['id']?>"><img src="static/style_default/image/pro_28.png" alt=""/></a>
                            </a>
                            <?php foreach ($a_view_data['cons'] as $const) {
                                 if ($cons['id'] == $const['cons_upid']) {?>
                            <div class="cateB hide"  id="<?php echo 'co_'.$const['id']; ?>">
                                <a class="c1">
                                    <input type="checkbox"/>
                                    <label for="" value="<?php echo $const['id']?>"><img src="static/style_default/image/pro_07.png" alt=""/></label>
                                    <img src="static/style_default/image/bv.png" alt=""/>
                                    <span><?php echo $const['cons_name']?></span>
                                </a>
                                <a class="c2 upta" value="<?php echo $const['id']?>" id="<?php echo 'up_'.$const['id']; ?>">
                                    <?php if ($const['cons_show'] == 1) {?>
                                        <img src="static/style_default/image/pro_10.png" alt=""/>
                                    <?php } else {?>
                                        <img src="static/style_default/image/pro_33.png" alt=""/>
                                    <?php }?>
                                </a>
                                <a class="c3">
                                    <img src="static/style_default/image/pro_26.png" alt="" class="dele1" value="<?php echo $const['id']?>"/>
                                    <a href="cons_update-<?php echo $const['id']?>"><img src="static/style_default/image/pro_28.png" alt=""/></a>
                                </a>
                                <?php foreach ($a_view_data['cons'] as $conso) {
                                    if ($const['id'] == $conso['cons_upid']) {?>
                                <div class="cateC"  id="<?php echo 'co_'.$conso['id']; ?>">
                                    <a class="c1">
                                        <input type="checkbox"/>
                                        <label for="" value="<?php echo $conso['id']?>"><img src="static/style_default/image/pro_07.png" alt=""/></label>
                                        <span><?php echo $conso['cons_name']?></span>
                                    </a>
                                    <a class="c2 upta" value="<?php echo $conso['id']?>" id="<?php echo 'up_'.$conso['id']; ?>">
                                        <?php if ($conso['cons_show'] == 1) {?>
                                            <img src="static/style_default/image/pro_10.png" alt=""/>
                                        <?php } else {?>
                                            <img src="static/style_default/image/pro_33.png" alt=""/>
                                        <?php }?>
                                    </a>
                                    <a class="c3">
                                        <img src="static/style_default/image/pro_26.png" alt="" class="dele1" value="<?php echo $conso['id']?>" />
                                        <a href="cons_update-<?php echo $conso['id']?>"><img src="static/style_default/image/pro_28.png" alt=""/></a>
                                    </a>
                                </div>
                                <?php }}?>
                            </div>
                            <?php }}?>
                        </div>
                    <?php }}} else {?>
                        <?php foreach ($a_view_data['cons'] as $cons) {?>
                        <div class="cateA" id="<?php echo 'co_'.$cons['id']; ?>">
                            <a class="c1">
                                <input type="checkbox"/>
                                <label for="" value="<?php echo $cons['id']?>"><img src="static/style_default/image/pro_07.png" alt=""/></label>
                                <img src="static/style_default/image/bv.png" alt=""/>
                                <span><?php echo $cons['cons_name']?></span>
                            </a>
                            <a class="c2 upta" value="<?php echo $cons['id']?>" id="<?php echo 'up_'.$cons['id']; ?>">
                                <?php if ($cons['cons_show'] == 1) {?>
                                    <img src="static/style_default/image/pro_10.png" alt=""/>
                                <?php } else {?>
                                <img src="static/style_default/image/pro_33.png" alt=""/>
                                <?php }?>
                            </a>
                            <a class="c3">
                                <img src="static/style_default/image/pro_26.png" alt="" class="dele1" value="<?php echo $cons['id']?>"/>
                                <a href="cons_update-<?php echo $cons['id']?>"><img src="static/style_default/image/pro_28.png" alt=""/></a>
                            </a>
                    <?php }}?>
                </div>
            </div>
            <!-- 耗材分类列表 -->
            <!--  底部选项 -->
            <div class="bottomTool">
                <a class="bottomAllSelect">
                    <input type="checkbox" id="bottomSelect"/>
                    <label for="bottomSelect"><img src="static/style_default/image/pro_07.png" alt=""/></label>
                    <span>全选</span>
                </a>
                <a class="bottomDelect">
                    <img src="static/style_default/image/pro_26.png" alt=""/>
                    <span>删除</span>
                </a>
                <a class="bottomProvisional">
                    <img src="static/style_default/image/pro_52.png" alt=""/>
                    <span>暂用</span>
                </a>

            </div>
            <!--  底部选项 -->
        </div>
        <!-- 耗材分类 -->


        <!--  重要提示 -->
        <div class="tips hide">
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