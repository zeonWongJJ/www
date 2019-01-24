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
    <link rel="stylesheet" href="static/style_default/style/package.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/editPackage.js"></script>
    <script src="./static/style_default/plugin/upload_image.js"></script>
    <title>修改套餐</title>
    <style>
        .fontred {
            color: red;
        }
    </style>
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


        <div class="package">
            <p>产品管理>套餐管理>编辑套餐</p>

            <div class="newPackage">
                <div class="packageTitle">
                    <span>编辑套餐</span>
                </div>

                <div class="package_demand">
                    <form action="package_update" method="post">
                        <ul>
                            <li class="package_name">
                                <em><s>*</s>套餐名称</em>
                                <input type="text" name="product_name" value="<?php echo $a_view_data['product']['product_name']; ?>" id="packageName" placeholder="输入14字符/汉字"/>
                                <span>
                                    <img src="" />
                                    <em></em>
                                </span>
                            </li>
                            <li class="package_sort">
                                <em><s>*</s>套餐排序</em>
                                <input type="text" id="packageSort" name="order" value="<?php echo $a_view_data['product']['order']; ?>" onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" placeholder="请输入数字"/>
                                <span class="hide">
                                    <img src="static/style_default/image/t_03.png" />
                                    <em></em>
                                </span>
                            </li>
                            <li class="productTime">
                                <em><s>*</s>产品供应区间</em>
                                <div class="productBox">
                                    <?php if (!empty($a_view_data['product']['supply_time'])) {
                                        $time_arr = explode(',', $a_view_data['product']['supply_time']);
                                    } else {
                                        $time_arr = array();
                                    } ?>
                                    <?php foreach ($a_view_data['time'] as $key => $value): ?>
                                    <?php if (in_array($value['time_id'],  $time_arr)) { ?>
                                    <a class="check" value="<?php echo $value['time_id']; ?>">
                                        <span><?php echo $value['time_nema']; ?></span>
                                        <img src="/static/style_default/image/ac_03.png">
                                    </a>
                                    <?php } else { ?>
                                    <a value="<?php echo $value['time_id']; ?>">
                                        <span><?php echo $value['time_nema']; ?></span>
                                    </a>
                                    <?php } ?>
                                    <?php endforeach ?>
                                </div>
                            </li>
                            <li class="package_price">
                                <em><s>*</s>价格</em>
                                <input type="text" id="packagePrice" name="price" value="<?php echo $a_view_data['price']['price']; ?>" onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" placeholder="请输入数字"/>
                                <span class="hide">
                                    <img src="static/style_default/image/t_03.png" />
                                    <em></em>
                                </span>
                            </li>
                            <li class="package_mix">
                                <em><s>*</s>套餐组合</em>
                                <div class="optionContainer">
                                    <?php for ($i=0; $i < count($a_view_data['pro']); $i++) { ?>
                                    <div class="optionlist" id="myoption_<?php echo $i+1; ?>" value="<?php echo $i+1; ?>">
                                        <p>选项<?php echo $i+1; ?></p>
                                        <img src="static/style_default/image/pro_19.png" />
                                        <div class="groupContent">
                                            <div class="groupCate">
                                                <a>
                                                    <span>请选择产品分类</span>
                                                    <img src="static/style_default/image/xia.png" />
                                                </a>
                                                <ul value="<?php echo $i+1; ?>">
                                            <?php foreach ($a_view_data['top'] as $key => $value): ?>
                                            <li <?php if ($value['pro_id'] == $a_view_data['pro'][$i]) { echo 'class="fontred"'; } ?> value="<?php echo $value['pro_id']; ?>"><a><?php echo $value['pro_name']; ?></a></li>
                                            <?php endforeach ?>
                                                </ul>
                                            </div>
                                            <div class="groupName">
                                                <a>
                                                    <span>请选择产品名称</span>
                                                    <img src="static/style_default/image/xia.png" />
                                                </a>
                                                <ul>

                    <?php foreach ($a_view_data['topproduct'] as $key => $value) { ?>
                    <?php if ($value['proid_id_1'] == $a_view_data['pro'][$i]) { ?>
                        <li value="<?php echo $value['product_id']; ?>" <?php if (in_array($value['product_id'], $a_view_data['pid'][$i])) { echo 'class="nameCur"'; } ?> >
                            <a>
                                <span><?php echo $value['product_name']; ?></span>
                                <?php if (in_array($value['product_id'], $a_view_data['pid'][$i])) {
                                    echo '<img src="static/style_default/image/qx_03.png" />';
                                } else {
                                    echo '<img src="static/style_default/image/qx_05.png" />';
                                } ?>
                            </a>
                        </li>
                    <?php } ?>
                    <?php } ?>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="addOption"><img src="static/style_default/image/adddd.png" /></div>
                                <span class="hide" style="display:inline-block; margin-left:110px; margin-top:10px;">
                                    <img src="" />
                                    <em></em>
                                </span>
                            </li>
                            <li class="packageKey">
                                <em><s>*</s>套餐关键词</em>
                                <input style="width:300px" type="text" id="package_key" placeholder="输入文字，按空格或回车生成产品关键词"/>
                                <div class="containerCate">
                        <?php if (!empty($a_view_data['product']['antistop'])) { ?>
                        <?php $keywords = explode(',', $a_view_data['product']['antistop']); ?>
                        <?php for ($i=0; $i < count($keywords); $i++) { ?>
                        <span class="tag"><?php echo $keywords[$i]; ?><img src="/static/style_default/image/pro_19.png">
                        </span>
                        <?php } ?>
                        <?php } ?>
                                </div>
                                 <span class="hide">
                                    <img src="" />
                                    <em></em>
                                </span>
                            </li>
                            <li class="package_picture">
                                <em><s>*</s>产品主图</em>
                                <div class="figureContent">
                                    <div id="maxbox">
                                        <input type="file" name="mypic" id="mypic" multiple="multiple" onchange="upload_preview()" />
                                        <div id="picbox"></div>
                                    </div>
                                    <div id="choose_box" onclick="javascript:document.getElementById('mypic').click();">选择图片</div>
                                    <div id="upload_box" onclick="upload_now()">上传图片</div>
                                    <input type="hidden" name="mainpic_path" value="<?php echo $a_view_data['product']['pro_img']; ?>">
                                    <input type="hidden" name="otherpic_path" value="<?php echo $a_view_data['product']['pro_image']; ?>">
                            <span>请至少上传一张产品图片；支持jpg/png格式，单张（长&lt;xxx，宽&lt;xxx，大小<1M），
最多支持10张图片，将按上传顺序展示图片，支持批量上传。</span>
                                </div>
                            </li>
                            <li class="package_text">
                                <em>套餐描述</em>
                                <textarea style="width:600px" name="pro_details" id="product_des" cols="30" rows="10"><?php echo $a_view_data['product']['pro_details']; ?></textarea>
                                <p style="display:none;">
                                    <span>200</span><em>/200</em>
                                </p>
                            </li>
                        </ul>
                        <input type="hidden" name="group_product" value="<?php echo $a_view_data['product']['group_product']; ?>">
                        <input type="hidden" name="antistop" value="<?php echo $a_view_data['product']['antistop']; ?>">
                        <input type="hidden" name="product_id" id="record_id" value="<?php echo $a_view_data['product']['product_id']; ?>">
                        <input type="hidden" name="supply_time" value="<?php echo $a_view_data['product']['supply_time']; ?>">
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

var file_arr      = new Array(); // 用于保存文件信息
var mainpic_imgid = 0; // 主图的图片id 默认第一张图片为主图
var max_count     = 10; // 允许上传最大文件数
var max_size      = 1048576; // 单个文件允许上传的最大值 1024*1024=1M
var max_allsize   = 10485760; // 允许上传的文件总大小 10M
var upload_url    = 'image_upload'; // 上传的服务器地址
var delete_url    = 'packagetem_delete'; // 删除服务上图片的地址
var input_name    = 'file'; // 后台接收时的表单name值
var module_name   = 'goods'; // 服务器上存放图片的模块文件夹
var upload_accept = new Array('image/jpeg', 'image/png','image/gif'); // 允许上传的格式

// 点击分类时获取产品
$('.groupCate ul li').live('click', function() {
    $this = $(this);
    var thisoptionid = $(this).parent('ul').attr('value');
    var pro_id = $(this).attr('value');
    if (pro_id != '') {
        // ajax请求获取相应的产品
        $.ajax({
            url: 'package_product',
            type: 'POST',
            dataType: 'json',
            data: {pro_id: pro_id},
            success: function(res) {
                if (res.code == 200) {
                    $('#myoption_'+thisoptionid).find('.groupCate>ul>li').removeClass('fontred');
                    $this.addClass('fontred');
                    var append_content = '';
                    $.each(res.data, function(index, el) {
                        append_content += '<li value="'+el.product_id+'">';
                        append_content += '<span>'+el.product_name+'</span>';
                        append_content += '<a>';
                        append_content += '<img src="static/style_default/image/qx_05.png" />';
                        append_content += '</a>';
                        append_content += '</li>';
                    });
                    $('#myoption_'+thisoptionid).find('.groupName>ul').html(append_content);
                }
            }
        })
    }
});

$('.groupName ul li').live('click', function() {
    if( $(this).hasClass("nameCur") ){
        $(this).removeClass("nameCur");
        $(this).find("a>img").attr("src","/static/style_default/image/qx_05.png");
    }else{
        $(this).addClass("nameCur");
        $(this).find("a>img").attr("src","/static/style_default/image/qx_03.png");
    }
    data_packaging();
});


function data_packaging() {
    var i = 0;
    var pro_arr = new Array();
    $('.optionlist').each(function(index, el) {
        var id = i+1;
        var j = 0;
        pro_arr[i] = new Array();
        $('#myoption_'+id+' .groupContent .groupName ul .nameCur').each(function(index2, el2) {
            pro_arr[i][j] = $(this).attr('value');
            j++;
        });
        i++;
    });

    // 循环数组
    var n = 0;
    var new_arr = new Array();
    for (var m=0; m<pro_arr.length; m++) {
        if (pro_arr[m].length > 0) {
            new_arr[n] = pro_arr[m].join('-');
            n++;
        }
    }

    if (new_arr.length > 0) {
        $("input[name='group_product']").val(new_arr.join(','));
    } else {
        $("input[name='group_product']").val('');
    }
    console.log($("input[name='group_product']").val());
}


$(document).on("click",".addOption",function(){
    $(".optionContainer").append($("#myoption_1").clone());
    var i = 1;
    $('.optionlist').each(function(index, el) {
        $(this).attr('id','myoption_'+i);
        $(this).attr('value',i);
        $(this).children('p').html('选项'+i);
        $(this).find('.groupCate>ul').attr('value',i);
        i++;
    });
    $('.optionContainer').children('.optionlist:last').find('.groupContent .groupName ul').html('');
    $('.optionContainer').children('.optionlist:last').find('.groupContent .groupCate ul li').removeClass('fontred');
});

//删除选项
$(document).on("click",".optionlist>img",function(){
    $(this).parent().remove();
    var i = 1;
    $('.optionlist').each(function(index, el) {
        $(this).attr('id','myoption_'+i);
        $(this).attr('value',i);
        $(this).children('p').html('选项'+i);
        $(this).find('.groupCate>ul').attr('value',i);
        i++;
    });
    data_packaging();
});

</script>