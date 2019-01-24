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
    <link rel="stylesheet" href="static/style_default/style/addSlide.css"/>
<!--     <link rel="stylesheet" type="text/css" href="static/style_default/style/wangEditor-1.1.0.css">
    <link rel="stylesheet" type="text/css" href="static/style_default/fontawesome-4.2.0/css/font-awesome.min.css"> -->
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/editSlide.js"></script>
    <script src="static/style_default/plugin/upload_image.js"></script>
    <!-- <script type="text/javascript" src='static/style_default/plugin/wangEditor-1.1.0.js'></script> -->
    <title>修改广告</title>
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

        <div class="addSlide">
            <p>编辑轮播</p>
            <div class="newSlide">
                <div class="SlideTitle">
                    <span>编辑轮播</span>
                </div>
                <div class="slide_demand">
                    <form action="ad_update" method="post">
                    <input type="hidden" id="record_id" name="ad_id" value="<?php echo $a_view_data['ad_id']; ?>">
                        <ul>
                            <li class="slide_name">
                                <em><s>*</s>标题</em>
                                <input type="text" name="ad_title" id="slideName" value="<?php echo $a_view_data['ad_title']; ?>" placeholder="轮播标题"/>
                                <span class="hide">
                                    <img src="static/style_default/image/t_03.png" />
                                    <em></em>
                                </span>
                            </li>
                            <li class="slide_num">
                                <em><s>*</s>序号</em>
                                <input type="text" id="slideNum" name="ad_order" value="<?php echo $a_view_data['ad_order']; ?>" placeholder="序号" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') " />
                                <span class="hide">
                                    <img src="static/style_default/image/t_03.png" />
                                    <em></em>
                                </span>
                            </li>
                            <li class="slide_href">
                                <em><s>*</s>图片链接</em>
                                <input type="text" id="slideHref" name="ad_link" placeholder="图片链接(可不填)" value="<?php echo $a_view_data['ad_link']; ?>" />
                                <span class="hide">
                                    <img src="static/style_default/image/t_03.png" />
                                    <em></em>
                                </span>
                            </li>
                            <li class="product_picture">
                                <em><s>*</s>广告图片</em>
                                <div class="figureContent">
                                    <div id="maxbox">
                                        <input type="file" name="mypic" id="mypic" multiple="multiple" onchange="upload_preview()" />
                                        <div id="picbox"></div>
                                    </div>
                                    <div id="choose_box" onclick="javascript:document.getElementById('mypic').click();">选择图片</div>
                                    <div id="upload_box" onclick="upload_now()">上传图片</div>
                                    <input type="hidden" name="mainpic_path" value="<?php echo $a_view_data['ad_pic']; ?>">
                                    <input type="hidden" name="otherpic_path" value="<?php echo $a_view_data['ad_pic']; ?>">
                            <span>请上传一张轮播图片；支持jpg/png格式</span>
                                </div>
                            </li>

                        </ul>
                        <input type="submit" id="reSub" value="确定发布"/>
                    </form>
                </div>
            </div>
        </div>

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>



<script type="text/javascript">

$(function(){
    // 显示原有图片
    upload_update();
})

var file_arr      = new Array(); // 用于保存文件信息
var mainpic_imgid = 0; // 主图的图片id 默认第一张图片为主图
var max_count     = 1; // 允许上传最大文件数
var max_size      = 1048576; // 单个文件允许上传的最大值 1024*1024=1M
var max_allsize   = 10485760; // 允许上传的文件总大小 10M
var upload_url    = 'image_upload'; // 上传的服务器地址
var delete_url    = 'adtem_delete'; // 删除服务上图片的地址
var input_name    = 'file'; // 后台接收时的表单name值
var module_name   = 'ad'; // 服务器上存放图片的模块文件夹
var upload_accept = new Array('image/jpeg', 'image/png'); // 允许上传的格式

</script>