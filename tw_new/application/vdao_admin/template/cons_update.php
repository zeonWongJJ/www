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
    <script src="static/style_default/script/suppliesEditCate.js"></script>
    <title>修改耗材分类</title>
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
            <p>修改耗材分类</p>
            <div class="cateList">
                <form action="<?php echo $this->router->url('cons_update')?>" method="post">
                    <ul>
                        <input type="hidden" name="id" value="<?php echo $a_view_data['con']['id']?>">
                    	<input type="hidden" name="cons" value="<?php echo $a_view_data['con']['cons_id']?>">
                        <li class="category">
                            <span>所属分类</span>
                            <select name="cons_id_1" id="cateA">
                            	<?php if ($a_view_data['con']['cons_id'] == 1) {?>
                            		<option value="0">顶级分类</option>
                            	<?php } else {?>
                                <?php foreach ($a_view_data['all'] as $all) {if ($a_view_data['con']['cons_id_1'] == $all['id']) {?>
                                <option value="<?php echo $all['id'].'-1'?>"><?php echo $all['cons_name'];?>
                                <?php }}}?></option>
                                <option value="0">顶级分类</option>
								<?php foreach ($a_view_data['all'] as $cons) { if ($cons['cons_id'] == 1) {if ($cons['id'] != $a_view_data['con']['id']) {?>
                                <option value="<?php echo  $cons['id'] . '-' . $cons['cons_id']?>"><?php echo $cons['cons_name']?></option>
                                <?php }}}?>
                            </select>
                            <?php if ($a_view_data['con']['cons_id_1'] == 0) {?>
                               <select name="cons_id" class="cateB hide">
                                </select>
                            <?php } else if ($a_view_data['con']['cons_id_2'] > $a_view_data['con']['cons_id_1']) { ?>
                                <select name="cons_id_2" class="cateB">
                                     <option value="<?php echo $a_view_data['con']['cons_id_2'] . '-2'?>"><?php foreach ($a_view_data['all'] as $all) {if ($a_view_data['con']['cons_id_2'] == $all['id']) { echo $all['cons_name'];
                                     }}?></option>
                                     <option value="<?php echo $a_view_data['con']['cons_id_1'] . '-1'?>">请选择二级分类</option>
                                     <?php foreach ($a_view_data['all'] as $all) {if ($a_view_data['con']['cons_id_1'] == $all['cons_upid']) {?>
                                    <option value="<?php echo $all['id'].'-2';?>"><?php echo $all['cons_name'];?></option><?php }}?>
                                </select>
                            <?php } else { if ($a_view_data['con']['id'] > $a_view_data['con']['cons_id_2']) {?>
                                <select name="cons_id_2" class="cateB">
                                     <option value="<?php echo $a_view_data['con']['cons_id_2'].'-1'?>">请选择二级分类</option>
                                     <?php foreach ($a_view_data['all'] as $all) {if ($a_view_data['con']['cons_id_2'] == $all['cons_upid']) {if ($a_view_data['con']['id'] !=  $all['id']) {?>
                                    <option value="<?php echo $all['id'].'-2';?>"><?php echo $all['cons_name'];?></option><?php }}}?>
                                </select>
                            <?php }}?>
                            <em class="cateTip hide">
                                <img src="static/style_default/image/f_03.png" alt=""/>
                                <span></span>
                            </em>
                            <input type="hidden" name="cons_id" class="cons_id" value="<?php echo $a_view_data['con']['cons_upid'] .'-'. ($a_view_data['con']['cons_id'] - 1)?>">
                        </li>
                        <li class="openClose">
                            <span>是否开放</span>
                            <em class="sure">
                                <img  <?php if ($a_view_data['con']['cons_show'] == 1) {
                            		echo "src='static/style_default/image/pro_36.png'";
                            	} else {
                            		echo "src='static/style_default/image/pro_38.png'";
                            		}?> alt=""/>
                                <span>是</span>
                            </em>
                            <em  class="deny">
                                <img <?php if ($a_view_data['con']['cons_show'] == 2) {
                            		echo "src='static/style_default/image/pro_36.png'";
                            	} else {
                            		echo "src='static/style_default/image/pro_38.png'";
                            		}?> alt=""/>
                                <span>否</span>
                            </em>
                            <em class="cateTip hide">
                                <img src="static/style_default/image/f_03.png" alt=""/>
                                <span></span>
                            </em>
                            <input type="hidden" name="show" class="show" value="<?php echo $a_view_data['con']['cons_show']?>">
                        </li>
                        <li class="addCateName">
                            <span>添加分类名称</span>
                            <input type="text" id="add_cateName" placeholder="请输入14个字符/汉字" name="name" value="<?php echo $a_view_data['con']['cons_name']?>" />
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
    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>