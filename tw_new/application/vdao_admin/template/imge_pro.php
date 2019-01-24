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
    <script src="./static/style_default/plugin/jquery-3.2.1.min.js"></script>
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
            background-image: url(/static/style_default/image/success.png);
            display: none;
        }
    </style>
</head>
<body>
    <h1>新图片上传测试</h1>
    <div id="choose_box" onclick="javascript:document.getElementById('mypic').click();">选择图片</div>
    <div id="maxbox">
        <input type="file" name="mypic" id="mypic" multiple="multiple" onchange="upload_preview()" accept="image/gif, image/jpeg" />
        <div id="picbox"></div>
    </div>
    <div id="upload_box" onclick="upload_now()">上传图片</div>
    <input type="hidden" name="imge" value="" class="imge">
    <input type="hidden" name="zhu_imge" value="" class="zhu_imge">
</body>
</html>

<script type="text/javascript">

var file_arr = new Array(); // 用于保存文件信息
var max_count = 10; // 允许上传最大文件数
var max_size = 1048576; // 单个文件允许上传的最大值 1024*1024=1M
var max_allsize = 10485760; // 允许上传的文件总大小 10M
var upload_url = 'imge'; // 上传的服务器地址
var input_name = 'file'; // 后台接收时的表单name值

// 图片验证并预览
function upload_preview() {
    var mypic_obj  = document.getElementById("mypic");
    var picbox_obj = document.getElementById("picbox");
    var fileList   = mypic_obj.files;
    // 验证文件数量是否超出最大值
    var have_count = 0; //已存在文件的总数
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
        have_size = have_size + mypic_obj.files[i]['size'];
        // 验证文件大小
        if (mypic_obj.files[i]['size'] > max_size) {
            alert(mypic_obj.files[i]['name'] + '超出允许上传的文件大小');
        } else if (have_size > max_allsize) {
            alert('超出允许上传的文件总大小');
            return false;
        } else {
            var append_content = '';
            append_content += '<div class="minbox" onMouseOver="show_shade('+arr_lenght+')" onMouseOut="hide_shade('+arr_lenght+')" id="minbox_'+arr_lenght+'">';
            append_content += '<img id="img_'+arr_lenght+'" src="">';
            append_content += '<div class="shade_box">';
            append_content += '<img src="static/style_default/image/shebei_07.png" class="ppyt'+arr_lenght+'" style="display: none;" onclick="mtye_file('+arr_lenght+')"/>';
            append_content += '<img src="./static/style_default/image/up_delete.png" onclick="delete_file('+arr_lenght+')" />';
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
}

// 删除选择的图片
function delete_file(imgid) {
    var img = $(".ppyt"+imgid).attr('value');
    //删除删除文件夹的文件
    $.ajax({
        type : 'post',
        url  : 'img_del',
        data : {img:img},
        dataType : 'json',
        success  : function(data) {
            console.log(data);
        }
    })
    var somearray = $('.imge').attr('value');
    var val = somearray.replace(img, "");
    var cal = val.replace(",,", ",");
    $('.imge').val(cal);
    $("#minbox_"+imgid).remove();
    // 替换数组对应的文件信息
    file_arr.splice(imgid, 1, 999);
    // console.log(file_arr);
}
//设置主图
function mtye_file(imgid) {
    var name = $('.ppyt'+imgid).attr('value');
    $('.zhu_imge').val(name);
}
$('.imge').val('');
// 上传图片
function upload_now() {
    name = '';
    for (var i=0; i<file_arr.length; i++) {
        if (file_arr[i] != 999 && file_arr[i] != 200) {
            var formData = new FormData();
            // 获取设置的表单名，未设置默认使用file
            if (input_name == '') {
                formData.append('file', file_arr[i]);
            } else {
                formData.append(input_name, file_arr[i]);
            }
            $.ajax({
                url: upload_url,
                type: 'POST',
                dataType: 'json',
                data: formData,
                async: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.code == 200) {
                        name += data.data+',';
                        name = name;
                        $('.imge').val(name);
                       // 上传成功之后替换数组文件信息
                        $("#success"+i).css('display','block');
                        $(".ppyt"+i).attr("value",data.data);
                        $(".ppyt"+i).css('display', 'block');
                    }
                }
            });
        }
    }
}

// 显示遮罩
function show_shade(imgid) {
    if (file_arr[imgid] != 200) {
        $("#minbox_"+imgid).children('.shade_box').css('display', 'block');
    }
}

// 隐藏遮罩
function hide_shade(imgid) {
    $("#minbox_"+imgid).children('.shade_box').css('display', 'none');
}
</script>
