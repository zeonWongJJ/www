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
    <link rel="stylesheet" href="static/style_default/style/productList3.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/plugin/upload_image.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/productList3Edit.js"></script>
    <script type="text/javascript" charset="utf-8" src="plugin/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="plugin/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="plugin/ueditor/lang/zh-cn/zh-cn.js"></script>
    <title>产品修改</title>
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
        <div class="productList">
            <p>产品管理>产品列表>修改产品</p>
            <!-- 发布产品 -->
            <div class="newProduct">
                <div class="productTitle">
                    <span>修改产品</span>
                </div>
                <!-- 产品需求 -->
                <div class="product_demand">
                    <form action="<?php echo $this->router->url('product_update'); ?>" method='post'>
                        <ul>
                            <input name="id" type="hidden" value="<?php echo $a_view_data['product']['product_id']; ?>" id="id">
                            <li class="product_name">
                                <em><s>*</s>产品名称</em>
                                <input type="text" id="productName" placeholder="输入14字符/汉字" name="pname" value="<?php echo $a_view_data['product']['product_name']; ?>"/>
                                <span>
                                    <img src="images/t_03.png" alt=""/>
                                    <em>还可以输入14字符/汉字</em>
                                </span>
                            </li>
                            <li class="product_sort">
                                <em><s>*</s>产品排序</em>
                                <input type="text" id="productSort" onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" placeholder="请输入数字" name="order" value="<?php echo $a_view_data['product']['order']; ?>"/>
                                <span class="hide">
                                    <img src="images/t_03.png" alt=""/>
                                    <em></em>
                                </span>
                            </li>
                            <li class="productCate">
                                <em><s>*</s>产品分类</em>
                                <select name="proid_id_1" id="product_cate_A">
                                    <option value="<?php echo $a_view_data['product']['proid_id_1']?>"><?php foreach ($a_view_data['pro'] as $proid_id_1) { if ($proid_id_1['pro_id'] == $a_view_data['product']['proid_id_1']) {
                                        echo $proid_id_1['pro_name'];
                                    }} ?></option>
                                    <?php foreach ($a_view_data['pro'] as $proid_id_1) { if ($proid_id_1['proid'] == 1) {?>
                                    <option value="<?php echo $proid_id_1['pro_id']?>"><?php echo $proid_id_1['pro_name']; ?></option>
                                    <?php } }?>
                                </select>
                                <select name="proid_id_2" class="product_cate_B">
                                    <option value="<?php echo $a_view_data['product']['proid_id_2']?>"><?php foreach ($a_view_data['pro'] as $proid_id_2) { if ($proid_id_2['pro_id'] == $a_view_data['product']['proid_id_2']) {
                                        echo $proid_id_2['pro_name'];
                                    }} ?></option>
                                    <?php foreach ($a_view_data['pro'] as $proid_id_2) { if ($proid_id_2['pro_pid'] == $a_view_data['product']['proid_id_1']) {?>
                                    <option value="<?php echo $proid_id_2['pro_id']?>"><?php echo $proid_id_2['pro_name']; ?></option>
                                    <?php }}?>
                                </select>
                                <select name="proid_id_3" class="product_cate_C">
                                    <option value="<?php echo $a_view_data['product']['proid_id_3']?>"><?php foreach ($a_view_data['pro'] as $proid_id_3) { if ($proid_id_3['pro_id'] == $a_view_data['product']['proid_id_3']) {
                                        echo $proid_id_3['pro_name'];
                                    }} ?></option>
                                    <?php foreach ($a_view_data['pro'] as $proid_id_3) { if ($proid_id_3['pro_pid'] == $a_view_data['product']['proid_id_2']) {?>
                                    <option value="<?php echo $proid_id_3['pro_id']?>"><?php echo $proid_id_3['pro_name']; ?></option>
                                    <?php }}?>
                                </select>
                                <span class="hide">
                                    <img src="images/t_03.png" alt=""/>
                                    <em></em>
                                </span>
                            </li>
                            <li class="supply">
                                <em><s>*</s>产品供应区间</em>
                                <div class="supplyBox">
                                    <?php foreach ($a_view_data['time'] as $time) { if(in_array($time['time_id'], explode(",", $a_view_data['product']['supply_time']))) {?>
                                        <a value="<?php echo $time['time_id']?>" class='check'>
                                            <span><?php echo $time['time_nema']?></span>
                                            <img src="static/style_default/image/ac_03.png">
                                            <input type="hidden" name="time[]" value="<?php echo $time['time_id']?>">
                                        </a>
                                        <?php } else {?>
                                        <a value="<?php echo $time['time_id']?>">
                                            <span><?php echo $time['time_nema']?></span>
                                            <input type="hidden" name="" value="<?php echo $time['time_id']?>">
                                        </a>
                                     <?php } }?>
                                </div>
                            </li>
                            <li class="material_price">
                                <em><s>*</s>耗材及价格</em>
                                <ul class="cup_size">
                                    <?php foreach ($a_view_data['cup'] as $cup) {?>
                                    <li>
                                        <div class="cup_type">
                                            <p><?php echo $cup['cup_name']?></p>
                                            <ul>
                                                <li class="cup_price">
                                                    <span>价格</span>
                                                    <input type="text" name="price_<?php echo $cup['cup_id']?>" value="<?php foreach ($a_view_data['price'] as $price) {
                                                    if ($cup['cup_id'] == $price['cup_id']) {
                                                        echo $price['price'];
                                                    }}?>"/>
                                                    元
                                                </li>
                                                <?php foreach ($a_view_data['cons'] as $cons) {?>
                                                <li class="cup_coffee">
                                                    <span><?php echo $cons['consu_name']?></span>
                                                    <input type="text" name="cons_<?php echo $cup['cup_id'].'_'.$cons['consumption_id']; ?>" value="<?php foreach ($a_view_data['term'] as $term) {
                                                        if ($cup['cup_id'] == $term['cup_id']) {
                                                            if ($cons['consumption_id'] == $term['consumption_id']) {
                                                                if ($term['amount'] == 0) {
                                                                    echo "";
                                                                } else {
                                                                    echo $term['amount'];
                                                                }
                                                            }}}?>"/>
                                                    <?php echo $cons['units']?>
                                                </li>
                                                <?php }?>
                                            </ul>
                                        </div>
                                    </li>
                                    <?php }?>
                                </ul>
                                <span class="hide">
                                    <img src="images/t_03.png" alt=""/>
                                    <em></em>
                                </span>
                            </li>
                            <?php foreach ($a_view_data['attr'] as $attr) {
                                if ($attr['grade'] == 1) {?>
                            <li class="temperature">
                                <em><?php echo $attr['attri_name']?></em>
                                <div class="temperatureBox">
                                    <?php foreach ($a_view_data['attr'] as $key => $value) {
                                        if ($attr['attri_id'] == $value['attri_cupid']) {?>
                                     <a value="<?php echo $attr['attri_id']?>" <?php if(!empty($a_view_data['wendu']) && in_array($value['attri_id'], $a_view_data['wendu'])) { echo 'class="check"';}?>>
                                        <span><?php echo $value['attri_name']?></span>
                                        <?php if(!empty($a_view_data['wendu']) && in_array($value['attri_id'], $a_view_data['wendu'])) {?>
                                            <input name="wen[<?php echo $attr['attri_id']?>][]" value="<?php echo $value['attri_id']?>" id="wendu" type="hidden">
                                            <img src="static/style_default/image/ac_03.png">
                                        <?php } else {?> 
                                        <input type="hidden" name="" value="<?php echo $value['attri_id']?>" id="wendu">
                                        <?php }?>
                                    </a>
                                    <?php }}?>
                                </div>
                            </li>
                            <?php }}?>
                            <li class="productKey">
                                <em><s>*</s>产品关键词</em>
                                <input style="width:300px" type="text" id="product_key" placeholder="输入文字，按空格或回车生成产品关键词"/>
                                <span class="hide">
                                     <img src="images/t_03.png" alt=""/>
                                     <em></em>
                                </span>
                                <div class="containerCate">
                                    <?php if(empty($a_view_data['product']['antistop'])) {

                                        } else{ foreach (explode(",", $a_view_data['product']['antistop']) as $antistop) {?>
                                         <span class="tag"><?php echo $antistop?>,<img src="static/style_default/image/pro_19.png"></span>
                                    <?php }}?>
                                </div>
                                <input type="hidden" class="name" name="antistop" value="<?php echo $a_view_data['product']['antistop']?>">
                            </li>
                            <li class="productKey">
                                 <em>产品主图</em>
                                   <div class="figureContent">
                                       <div id="maxbox">
                                           <input type="file" name="mypic" id="mypic" multiple="multiple" onchange="upload_preview()" />
                                           <div id="picbox"></div>
                                       </div>
                                       <div id="choose_box" onclick="javascript:document.getElementById('mypic').click();">选择图片</div>
                                       <div id="upload_box" onclick="upload_now()">上传图片</div>
                                       <input type="hidden" name="mainpic_path" value="<?php echo $a_view_data['product']['pro_img']?>">
                                       <input type="hidden" name="otherpic_path"
                                        value="<?php echo $a_view_data['product']['pro_image']?>">
                               <span>请至少上传一张产品图片；支持jpg/png格式，单张（长&lt;xxx，宽&lt;xxx，大小<1M），
   最多支持5张图片，将按上传顺序展示图片，支持批量上传。</span>
                                   </div>
                            </li>
                            <li class="product_text">
                                <em style="float:left;">产品描述</em>
                                <script id="editor" style="width:80%; height:300px; float:left;margin: auto 13px;" name="details" type="text/plain"><?php echo $a_view_data['product']['pro_details']?></script>
                            </li>
                        </ul>
                        <input type="submit" id="reSub" value="确定发布"/>
                    </form>
                </div>
                <!-- 产品需求 -->
            </div>
            <!-- 发布产品 -->
        </div>
        <!-- 产品列表 --></article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>
<script type="text/javascript">
    // 用于保存文件信息
    var file_arr      = new Array(); 
    // 主图的图片id 默认第一张图片为主图
    var mainpic_imgid = 0; 
    // 允许上传最大文件数
    var max_count     = 10; 
    // 单个文件允许上传的最大值 1024*1024=1M
    var max_size      = 1048576; 
    // 允许上传的文件总大小 10M
    var max_allsize   = 10485760; 
    // 上传的服务器地址
    var upload_url    = 'image_upload'; 
    // 删除服务上图片的地址
    var delete_url    = 'img_del'; 
    // 后台接收时的表单name值
    var input_name    = 'file'; 
    // 服务器上存放图片的模块文件夹
    var module_name   = 'goods'; 
    // 允许上传的格式
    var upload_accept = new Array('image/jpeg', 'image/png','image/gif'); 


    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');
        $("#NewsSub").click(function(event) {
        $("#addform").submit();
    });
</script>