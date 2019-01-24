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
    <script src="static/style_default/script/attri_up.js"></script>
    <title>属性分类修改</title>
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
            <p>修改产品分类</p>
            <div class="cateList">
                <form action="<?php echo $this->router->url('attri_up')?>" method="post">
                    <ul>
                        <input type="hidden" name="id" value="<?php echo $a_view_data['pro']['attri_id']?>">
                        <input type="hidden" name="cons" value="<?php echo $a_view_data['pro']['grade']?>">
                        <li class="category">
                            <span>所属分类</span>
                            <select name="attri_id_1" id="cateA">
                                <?php if ($a_view_data['pro']['attri_id_1'] == 0) {?>
                            		<option value="0">顶级分类</option>
                            	<?php } else {?>
                                <option value="<?php foreach ($a_view_data['ali'] as $all) {if ($a_view_data['pro']['attri_cupid'] == $all['attri_id']) {
                                	echo $all['attri_id'].'-1';
                                }}?>"><?php foreach ($a_view_data['ali'] as $all) {if ($a_view_data['pro']['attri_cupid'] == $all['attri_id']) {
                                	echo $all['attri_name'];
                                }}?></option>
                                <?php }?>
                                <option value="0">顶级分类</option>
                                <?php foreach ($a_view_data['ali'] as $pro) {if ($pro['grade'] == 1) {if ($a_view_data['pro']['attri_cupid'] != $pro['attri_id']) {?>
                                <option value="<?php echo $pro['attri_id'] . '-' . $pro['grade']?>"><?php echo $pro['attri_name']?></option>
								<?php }}}?>
                            </select>

                           <!--  <?php if ($a_view_data['pro']['attri_id_1'] == 0) {?>
                                <select name="attri_id_2" class="cateB hide"></select>
                            <?php } else { if ($a_view_data['pro']['2'] < $a_view_data['pro']['3']) {?>
                                <select name="attri_id_2" class="cateB">
                                     <option value="<?php echo $a_view_data['pro']['3'] . '-2'?>"><?php foreach ($a_view_data['ali'] as $ali) {if ($a_view_data['pro']['3'] == $ali['attri_id']) { echo $ali['attri_name'];
                                     }}?></option>
                                     <option value="<?php echo $a_view_data['pro']['2'] . '-1'?>">请选择二级分类</option>
                                     <?php foreach ($a_view_data['ali'] as $all) {if ($a_view_data['pro']['2'] == $all['pro_pid']) {?>
                                    <option value="<?php echo $all['attri_id'].'-2';?>"><?php echo $all['attri_name'];?></option><?php }}?>
                                </select>
                            <?php } else if ($a_view_data['pro']['attri_id'] > $a_view_data['pro']['2']) {?>
                            <select name="attri_id_2" class="cateB">
                                     <option value="<?php echo $a_view_data['pro']['2'].'-1'?>">请选择二级分类</option>
                                     <?php foreach ($a_view_data['ali'] as $all) {if ($a_view_data['pro']['2'] == $all['pro_pid']) {if ($a_view_data['pro']['attri_id'] !=  $all['attri_id']) {?>
                                    <option value="<?php echo $all['attri_id'].'-2';?>"><?php echo $all['attri_name'];?></option><?php }}}?>
                            </select>
                            <?php }}?> -->

                            <em class="cateTip hide">
                                <img src="static/style_default/image/f_03.png" alt=""/>
                                <span></span>
                            </em>
                            <input type="hidden" name="proid" class="proid" value="<?php foreach ($a_view_data['ali'] as $all) {if ($a_view_data['pro']['attri_cupid'] == $all['attri_id']) {
                                    echo $all['attri_id'].'-1';
                                }}?>">
                        </li>
                        <li class="openClose">
                            <span>是否显示</span>
                            <em class="sure">
                            	<?php if ($a_view_data['pro']['show'] == 1) {?>
                            		<img  src="static/style_default/image/pro_36.png" alt=""/>
                            	<?php } else {?>
                                	<img  src="static/style_default/image/pro_38.png" alt=""/>
                                <?php }?>
                                <span>是</span>
                            </em>
                            <em  class="deny">
                               <?php if ($a_view_data['pro']['show'] == 2) {?>
                            		<img  src="static/style_default/image/pro_36.png" alt=""/>
                            	<?php } else {?>
                                	<img  src="static/style_default/image/pro_38.png" alt=""/>
                                <?php }?>
                                <span>否</span>
                            </em>
                            <em class="cateTip hide">
                                <img src="static/style_default/image/f_03.png" alt=""/>
                                <span></span>
                            </em>
                            <input type="hidden" name="show" value="<?php echo $a_view_data['pro']['show']?>" class="show">
                        </li>
                        <li class="addCateName">
                            <span>修改分类名称</span>
                            <input type="text" id="add_cateName" placeholder="请输入14个字符/汉字" name="name" value="<?php echo $a_view_data['pro']['attri_name']?>" />
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