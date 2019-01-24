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
    <link rel="stylesheet" href="static/style_default/style/addStorage.css"/>
    <script src="static/style_default/plugin/upload_image.js"></script>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/editStorage.js"></script>
    <title>修改入库</title>
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
        <div class="suppliesList">
            <p>耗材管理>耗材管理记录>修改入库</p>
            <!-- 添加产品 -->
            <div class="newSupplies">
                <div class="suppliesTitle">
                    <span>修改入库</span>
                </div>
                <div class="newSuppliesContent">
                    <form action="entry_uptate" method='post' enctype="multipart/form-data">
                        <ul>
                        	<input type="hidden" value="<?php echo $a_view_data['record']['record_id']?>" name="id" id="record_id">
                            <li class="suppliesCate">
                                <em><s>*</s>耗材分类</em>
                                  <select name="cons_id_1" class="cons_id_1" id="supplies_cate_A">
                                    <option value="<?php echo $a_view_data['record']['cons_id_1']?>"><?php foreach ($a_view_data['con'] as $cons_id_1) {if ($cons_id_1['id'] == $a_view_data['record']['cons_id_1']) {
                                    	echo $cons_id_1['cons_name'];
                                    }}?></option>
                                    <?php foreach ($a_view_data['con'] as $cons_id_1) {if ($cons_id_1['cons_id'] == 1) {if ($cons_id_1['id'] != $a_view_data['record']['cons_id_1']) {?>
									<option value="<?php echo $cons_id_1['id']?>"><?php echo $cons_id_1['cons_name']; ?></option>
									<?php }}}?>
                                </select>
                                <select name="cons_id_2" class="supplies_cate_B cons_id_2">
                                	 <option value="<?php echo $a_view_data['record']['cons_id_2']?>"><?php foreach ($a_view_data['con'] as $cons_id_2) {if ($cons_id_2['id'] == $a_view_data['record']['cons_id_2']) {
                                    	echo $cons_id_2['cons_name'];
                                    }}?></option>
                                    <?php foreach ($a_view_data['con'] as $cons_id_2) {if ($cons_id_2['cons_upid'] == $a_view_data['record']['cons_id_1']) {if ($cons_id_2['id'] != $a_view_data['record']['cons_id_2']) {?>
									<option value="<?php echo $cons_id_2['id']?>"><?php echo $cons_id_2['cons_name']; ?></option>
									<?php }}}?>
                                </select>
                                <select name="cons_id_3" class="supplies_cate_B cons_id_3">
									<option value="<?php echo $a_view_data['record']['cons_id_3']?>"><?php foreach ($a_view_data['con'] as $cons_id_3) {if ($cons_id_3['id'] == $a_view_data['record']['cons_id_3']) {
                                    	echo $cons_id_3['cons_name'];
                                    }}?></option>
                                     <?php foreach ($a_view_data['con'] as $cons_id_3) {if ($cons_id_3['cons_upid'] == $a_view_data['record']['cons_id_2']) {if ($cons_id_3['id'] != $a_view_data['record']['cons_id_3']) {?>
                                    <option value="<?php echo $cons_id_3['id']?>"><?php echo $cons_id_3['cons_name']; ?></option>
                                    <?php }}}?>
                                </select>
                            </li>
                            <li>
	                            <em><s>*</s>耗材名称</em>
	                            <input type="hidden" name="name" value="<?php echo $a_view_data['record']['consu_name']?>" class="cons_name">
	                            <select name="cons_id" class="cons_id" id="supplies_cate_A" style="padding: 5px 62px 10px 93px;">
	                            	<option value="<?php echo $a_view_data['record']['consumption_id']?>"><?php echo $a_view_data['record']['consu_name']?></option>
                                    <?php foreach ($a_view_data['paost'] as $paost) {if($paost['consu_id_3'] == $a_view_data['record']['cons_id_3']) {?>
                                    <option value="<?php echo $paost['consumption_id']?>"><?php echo $paost['consu_name']?></option>
                                    <?php }}?>
	                            </select>
                            </li>
                            <li class="suppliesPrice">
                                <em><s>*</s>数量</em>
                                <input type="text" value="<?php echo $a_view_data['record']['amount']?>" name="amount"  onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/>
                                <span>
                                    <img src="" alt=""/>
                                </span>
                            </li>
                            <li class="suppliesPrice">
                                <em><s>*</s>总价</em>
                                <input onkeyup="value=value.replace(/[^\d.]/g,'')" type="text" value="<?php echo $a_view_data['record']['price']?>" name="price" />
                                <span>
                                    <img src="" alt=""/>
                                </span>
                            </li>
                           <li class="mainFigure">
                                <em><s>*</s>入库凭证</em>
                                    <div class="figureContent">
                                        <div id="maxbox">
                                            <input type="file" name="mypic" id="mypic" multiple="multiple" onchange="upload_preview()" />
                                            <div id="picbox"></div>
                                        </div>
                                        <div id="choose_box" onclick="javascript:document.getElementById('mypic').click();">选择图片</div>
                                        <div id="upload_box" onclick="upload_now()">上传图片</div>
                                        <!-- <input type="hidden" name="mainpic_path"> -->
                                        <input type="hidden" name="otherpic_path" value="<?php echo $a_view_data['record']['img'];?>">
                                        <span>请至少上传一张产品图片；支持jpg/png格式，单张（长&lt;xxx，宽&lt;xxx，大小<1M），
    最多支持10张图片，将按上传顺序展示图片，支持批量上传。</span>
                                    </div>
                            </li>
                            <li class="suppliesDescribe">
                                <em><s>*</s>操作描述</em>
                                <textarea name="reason" id="describe" cols="30" rows="10"><?php echo $a_view_data['record']['reason']?></textarea>
                                <!-- <span>
                                    <em>还可以输入200字符/汉字</em>
                                </span> -->
                            </li>
                        </ul>
                        <input type="submit" value="确定修改" id="suppliesSub"/>
                    </form>

                </div>
            </div>
            <!-- 添加产品 -->
        </div>
        <!-- 产品列表 -->



    </article>
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
var delete_url    = 'entry_img_del'; 
// 后台接收时的表单name值
var input_name    = 'file'; 
// 服务器上存放图片的模块文件夹
var module_name   = 'proof'; 
// 允许上传的格式
var upload_accept = new Array('image/jpeg', 'image/png','image/gif'); 

</script>