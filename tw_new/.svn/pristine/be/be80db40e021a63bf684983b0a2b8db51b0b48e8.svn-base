// 修改时的操作
function upload_update() {
    var record_id = $("#record_id").val();
    var mainimg_str = $("input[name='mainpic_path']").val();
    var yuanimg_str = $("input[name='otherpic_path']").val();
    // 拆分成数组
    var yuanimg_arr = yuanimg_str.split(',');
    if (yuanimg_str != '') {
        for (var i=0; i<yuanimg_arr.length; i++) {
            var append_yuan = '';
            append_yuan += '<div class="minbox" onMouseOver="show_shade('+i+')" onMouseOut="hide_shade('+i+')" id="minbox_'+i+'">';
            append_yuan += '<img id="img_'+i+'" src="'+yuanimg_arr[i]+'">';
            append_yuan += '<div class="shade_box">';
            append_yuan += '<span class="mainpic" id="mainpic_'+i+'">主图</span>';
            append_yuan += '<img src="/static/style_default/images/up_delete.png" id="delete_'+i+'" onclick="unlink_file('+i+','+"'"+yuanimg_arr[i]+"'"+','+2+','+record_id+')" /><img style="margin-top:7px;" src="/static/style_default/images/up_main.png" id="mainimg_'+i+'" onclick="set_mainpic('+i+','+"'"+yuanimg_arr[i]+"'"+')" />';
            append_yuan += '</div>';
            append_yuan += '<div class="success_box" style="display:block;" id="success'+i+'">';
            append_yuan += '</div>';
            append_yuan += '</div>';
            $("#picbox").append(append_yuan);
            // 判断是否为主图 是则显示主图标识
            if (yuanimg_arr[i] == mainimg_str) {
                $("#mainpic_"+i).css('display','block');
            }
            file_arr.push(200);
        }
    }
}

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
            append_content += '<img src="/static/style_default/images/up_delete.png" id="delete_'+arr_lenght+'" onclick="delete_file('+arr_lenght+')" /><img style="margin-top:7px;" src="/static/style_default/images/up_main.png" id="mainimg_'+arr_lenght+'" onclick="main_file('+arr_lenght+')" />';
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
function unlink_file(imgid, image_path, dtype, record_id) {
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
        data: {image_path: image_path, dtype: dtype, record_id: record_id},
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
            formData.append('module_name', module_name);
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
                $("#delete_"+i).attr('onclick', "unlink_file("+i+",'"+res.data+"'"+","+1+",-999)");
                $("#mainimg_"+i).attr('onclick', "set_mainpic("+i+",'"+res.data+"')");
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
                $("#success"+i).css('background-image','url(/static/style_default/images/up_error.png)');
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