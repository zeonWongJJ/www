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
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <title>修改设备</title>
    <style>
        #picbox {
            width: 960px;
            overflow: hidden;
            border: 1px solid pink;
        }
        .minbox {
            width: 200px;
            height: 200px;
            float: left;
            margin:10px;
            padding: 10px;
            cursor: pointer;
            position: relative;
            background-image: url(./static/style_default/image/bg.png);
        }
        .minbox img {
            width: 200px;
            height: 200px;
            border: 0px;
        }
        #mypic {
            width: 0px;
            height: 0px;
            color: white;
            background-color: rgb(95, 184, 120);
        }
        #choose_box {
            width: 100px;
            height: 40px;
            color: white;
            border-radius: 5px;
            text-align: center;
            line-height: 40px;
            font-size: 16px;
            cursor: pointer;
            background-color: rgb(0, 183, 238);
        }
        #upload_box {
            width: 100px;
            height: 40px;
            margin-top: 20px;
            color: white;
            border-radius: 5px;
            text-align: center;
            line-height: 40px;
            font-size: 16px;
            cursor: pointer;
            background-color: rgb(0, 150, 136);
        }
        .shade_box {
            display: none;
            width: 100%;
            height: 30px;
            position: absolute;
            left: 0;
            top: 0;
            z-index: 100;
            background-color: rgb(127, 127, 127);
        }
        .shade_box img {
            max-width: 15px;
            max-height: 15px;
            float: right;
            margin-top: 6px;
            margin-right: 10px;
        }
        .success_box {
            width: 40px;
            height: 40px;
            position: absolute;
            right: 0px;
            top: 0px;
            background-image: url(/static/style_default/image/up_success.png);
            display: none;
        }
        .mainpic {
            color: white;
            line-height: 30px;
            font-size: 14px;
            margin-left: 10px;
            display: none;
            float: left;
        }
    </style>
</head>
<body>
    <h1>新图片上传测试</h1>
    <div id="choose_box" onclick="javascript:document.getElementById('mypic').click();">选择图片</div>
    <div id="maxbox">
        <input type="file" name="mypic" id="mypic" multiple="multiple" onchange="upload_preview()" />
        <div id="picbox"></div>
    </div>
    <div id="upload_box" onclick="upload_now()">上传图片</div>
    <input type="hidden" name="mainpic_path">
    <input type="hidden" name="otherpic_path">
</body>
</html>

<script type="text/javascript">

var file_arr      = new Array(); // 用于保存文件信息
var mainpic_imgid = 0; // 主图的图片id 默认第一张图片为主图
var max_count     = 10; // 允许上传最大文件数
var max_size      = 1048576; // 单个文件允许上传的最大值 1024*1024=1M
var max_allsize   = 10485760; // 允许上传的文件总大小 10M
var upload_url    = 'deviceimg_upload'; // 上传的服务器地址
var delete_url    = 'devicetem_delete'; // 删除服务上图片的地址
var input_name    = 'file'; // 后台接收时的表单name值
var upload_accept = new Array('image/jpeg', 'image/png','image/gif'); // 允许上传的格式

// 图片验证并预览
function upload_preview() {
    var mypic_obj  = document.getElementById("mypic");
    var picbox_obj = document.getElementById("picbox");
    var fileList   = mypic_obj.files;
    // 验证文件数量是否超出最大值
    var have_count = 0; // 已存在文件的总数
    var have_size = 0; // 已存在文件的总大小
    for (var i=0; i<file_arr.length; i++) {
        if (file_arr[i] != 999) {
            have_count++;
            have_size = have_size + file_arr[i]['size'];
        }
    }
    if (have_count > max_count || (have_count + fileList.length) > max_count) {
        alert('超出允许上传的最大文件数\n最多允许上传'+max_count+'个图片或文件');
        return false;
    }
    for (var i=0; i<fileList.length; i++) {
        var arr_lenght = file_arr.length;
        var is_have_add = 0; // 之前是否已经添加过 0代表否 1代表是
        var is_allow_type = 0; // 是否是允许的格式 0代表否 1代表是
        // 验证之前是否添加过
        for (var j=0; j<arr_lenght; j++) {
            if (mypic_obj.files[i]['name'] == file_arr[j]['name']) {
                alert(mypic_obj.files[i]['name'] + '已经添加过啦！');
                is_have_add = 1;
            }
        }
        for (var m=0; m<upload_accept.length; m++) {
            if (mypic_obj.files[i]['type'] == upload_accept[m]) {
                is_allow_type = 1;
            }
        }
        have_size = have_size + mypic_obj.files[i]['size'];
        if (is_have_add == 1) {
            have_size = have_size - mypic_obj.files[i]['size'];
        } else if (is_allow_type == 0) {
            alert(mypic_obj.files[i]['name'] + '格式不合法，允许上传的格式为:'+upload_accept.join(','));
        } else if (mypic_obj.files[i]['size'] <= 0) {
            alert(mypic_obj.files[i]['name'] + '不合法');
        } else if (mypic_obj.files[i]['size'] > max_size) {
            alert(mypic_obj.files[i]['name'] + '超出允许上传的文件大小');
        } else if (have_size > max_allsize) {
            alert('超出允许上传的文件总大小');
            return false;
        } else {
            var append_content = '';
            append_content += '<div class="minbox" onMouseOver="show_shade('+arr_lenght+')" onMouseOut="hide_shade('+arr_lenght+')" id="minbox_'+arr_lenght+'">';
            append_content += '<img id="img_'+arr_lenght+'" src="">';
            append_content += '<div class="shade_box">';
            append_content += '<span class="mainpic" id="mainpic_'+arr_lenght+'">主图</span>';
            append_content += '<img src="./static/style_default/image/up_delete.png" id="delete_'+arr_lenght+'" onclick="delete_file('+arr_lenght+')" /><img style="margin-top:7px;" src="./static/style_default/image/up_main.png" id="mainimg_'+arr_lenght+'" onclick="main_file('+arr_lenght+')" />';
            append_content += '</div>';
            append_content += '<div class="success_box" id="success'+arr_lenght+'">';
            append_content += '</div>';
            append_content += '</div>';
            $("#picbox").append(append_content);
            var imgObjPreview = document.getElementById("img_"+arr_lenght);
            if (mypic_obj.files && mypic_obj.files[i]) {
                imgObjPreview.src = window.URL.createObjectURL(mypic_obj.files[i]);
            }
            file_arr.push(mypic_obj.files[i]);
        }
    }
    // 默认将第一张图片设为主图
    main_file(0);
}

// 删除选择的图片
function delete_file(imgid) {
    // 判断是否为主图
    if (imgid == mainpic_imgid) {
        $("input[name='mainpic_path']").val('');
        $(".mainpic").css('display','none');
    }
    $("#minbox_"+imgid).remove();
    // 替换数组对应的文件信息
    file_arr.splice(imgid, 1, 999);
    console.log(file_arr);
}

// 将当前图片设为主图
function main_file(imgid) {
    $(".mainpic").css('display','none');
    $("#mainpic_"+imgid).css('display', 'block');
    mainpic_imgid = imgid;
}

// 将已上传的图片设置为主图
function set_mainpic(imgid, image_path) {
    $(".mainpic").css('display','none');
    $("#mainpic_"+imgid).css('display', 'block');
    mainpic_imgid = imgid;
    $("input[name='mainpic_path']").val(image_path);
}

// 已经上传的图片的删除操作
function unlink_file(imgid, image_path) {
    // 判断是否为主图
    if (imgid == mainpic_imgid) {
        $("input[name='mainpic_path']").val('');
        $(".mainpic").css('display','none');
    }
    var new_patharr = new Array();
    $.ajax({
        url: delete_url,
        type: 'POST',
        dataType: 'json',
        data: {image_path: image_path},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                // 删除成功后删除预览信息
                $("#minbox_"+imgid).remove();
                // 替换数组对应的文件信息
                file_arr.splice(imgid, 1, 999);
                // 同时删除隐藏域中的路径删除
                var otherpic_path = $("input[name='otherpic_path']").val();
                var path_arr = otherpic_path.split(",");
                var j = 0;
                for (var i=0; i<path_arr.length; i++) {
                    if (path_arr[i] != image_path) {
                        new_patharr[j] = path_arr[i];
                        j++;
                    }
                }
                path_str = new_patharr.join(',');
                $("input[name='otherpic_path']").val(path_str);
                console.log(file_arr);
            }
        }
    });
}

// 上传图片
function upload_now() {
    for (var i=0; i<file_arr.length; i++) {
        if (file_arr[i] != 999 && file_arr[i] != 200) {
            var formData = new FormData();
            // 获取设置的表单名，未设置默认使用file
            if (input_name == '') {
                formData.append('file', file_arr[i]);
            } else {
                formData.append(input_name, file_arr[i]);
            }
            // 调用上传的函数
            upload_one(formData, i);
        }
    }
}

// ajax请求
function upload_one(formData, i) {
    $.ajax({
        url: upload_url,
        type: 'POST',
        dataType: 'json',
        data: formData,
        async: true,
        processData: false,
        contentType: false,
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                // 上传成功之后替换数组文件信息
                file_arr.splice(i, 1, 200);
                console.log(file_arr);
                $("#delete_"+i).attr('onclick', 'unlink_file('+i+',"'+res.data+'")');
                $("#mainimg_"+i).attr('onclick', 'set_mainpic('+i+',"'+res.data+'")');
                $("#success"+i).css('display','block');
                // 判断是否为主图
                if (i == mainpic_imgid) {
                    $("input[name='mainpic_path']").val(res.data);
                    $(".mainpic").css('display','none');
                    $("#mainpic_"+i).css('display', 'block');
                }
                // 将图片路径保存到隐藏域
                var otherpic_path = $("input[name='otherpic_path']").val();
                if (otherpic_path == '') {
                    $("input[name='otherpic_path']").val(res.data);
                } else {
                    $("input[name='otherpic_path']").val(otherpic_path + ',' + res.data);
                }
            } else {
                $("#success"+i).css('background-image','url(/static/style_default/image/up_error.png)');
                $("#success"+i).css('display','block');
            }
        }
    });
}

// 显示遮罩
function show_shade(imgid) {
    $("#minbox_"+imgid).children('.shade_box').css('display', 'block');
}

// 隐藏遮罩
function hide_shade(imgid) {
    $("#minbox_"+imgid).children('.shade_box').css('display', 'none');
}


</script>
