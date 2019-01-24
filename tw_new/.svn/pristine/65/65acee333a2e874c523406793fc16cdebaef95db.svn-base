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
    <link rel="stylesheet" href="./static/style_default/style/common.css"/>
    <link rel="stylesheet" href="./static/style_default/style/public.css"/>
    <link rel="stylesheet" href="./static/style_default/style/addDevice.css"/>
    <link rel="stylesheet" href="./static/style_default/style/webuploader.min.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/addDevice.js"></script>
    <script src="./static/style_default/plugin/webuploader.js"></script>
    <script src="./static/style_default/plugin/uploadImgPreview.min.js"></script>
    <title>添加设备</title>
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

        <!-- 添加设备 -->
        <div class="addDevice">
            <p><a href="room_showlist" style="color:#000;">房间管理</a> > <a href="device_showlist" style="color:#000;">设备列表</a> > 添加设备</p>
            <div class="addDeviceTitle">
                <span>添加设备</span>
            </div>
        </div>
        <div class="deviceList">
            <form action="device_add" method="post">
                <ul>
                    <li class="deviceName">
                        <em><s>*</s>设备名称</em>
                        <input type="text" id="device_name" name="device_name" placeholder="输入14字符/汉字"/>
                        <span class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <em></em>
                        </span>
                    </li>
                    <li class="deviceNum">
                        <em><s>*</s>设备型号</em>
                        <input type="text" id="device_num" name="device_version" placeholder="输入14字符/汉字"/>
                         <span class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <em></em>
                        </span>
                    </li>
                    <input type="hidden" name="device_state" value="1">
                    <li class="deviceDisplay">
                        <em><s>*</s>是否启用</em>
                        <em class="sure" style="width:50px; text-align:left;" value='1' >
                            <img  src="./static/style_default/image/pro_38.png" />
                            <span>是</span>
                        </em>
                        <em  class="deny" style="width:50px; text-align:left;" value='0'>
                            <img src="./static/style_default/image/pro_38.png" />
                            <span>否</span>
                        </em>
                         <span class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <em></em>
                        </span>
                    </li>
                    <li class="mainFigure">
                        <em>设备图片</em>
                        <div id="uploader" style="width:1000px; display:inline-block; vertical-align:top;"></div>
                        <div class="choose-file-btn" style="font-size:14px;" id="choose_file">选择图片</div>
                        <button type="button" id="upload_now">上传图片</button>
                        <button type="button" id="retry_upload">重新上传</button>
                        <!-- 图片路径 -->
                        <input type="hidden" name="path_img" value="">
                    </li>
                    <li class="deviceDescribe">
                        <em>设备描述</em>
                        <textarea name="device_description" id="describe" cols="30" rows="10"></textarea>
                    </li>
                </ul>
                <input type="submit" value="确定发布" id="deviceSub"/>
            </form>

        </div>
        <!-- 添加设备 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>

<script>
$(function(){
    var path_img;
    var uploader = uploadImage({
        wrap: "#uploader", //包裹整个上传控件的元素，必须。可以传递dom元素、选择器、jQuery对象
        /*预览图片的宽度，可以不传，如果宽高都不传则为包裹预览图的元素宽度，高度自动计算*/
        //width: "160px",
        height: 120,      //预览图片的高度
        url: "deviceimg_upload", // 服务器地址
        fileVal: "file",  // [默认值：'file'] 设置文件上传域的name。
        btns: {//必须
            uploadBtn: $("#upload_now"), //开始上传按钮，必须。可以传递dom元素、选择器、jQuery对象
            retryBtn: "#retry_upload",  //用户自定义"重新上传"按钮
            chooseBtn: '#choose_file',  //"选折图片"按钮，必须。可以传递dom元素、选择器、jQuery对象
            chooseBtnText: "选择图片"   //选择文件按钮显示的文字
        },
        pictureOnly: true,          // 是否只能上传图片
        resize: false,
        // 是否可以重复上传，即上传一张图片后还可以再次上传。默认是不可以的，false为不可以，true为可以
        duplicate: true,
        maxFileNum: 10,             // 允许上传的最大文件数
        maxFileTotalSize: 10485760, // 限制文件总大小
        maxFileSize: 2097152,       // 限制单个文件大小
        swf: "./static/style_default/image/Uploader.swf" // 进度条图片地址
    });

    // 上传成功后将将图片路径保存到隐藏域中
    uploader.on( 'uploadSuccess', function( file, response ) {
        console.log(response);
        if (response.code == 200) {
            path_img = $("input[name='path_img']").val();
            if (path_img == '') {
                $("input[name='path_img']").val(response.data);
            } else {
                $("input[name='path_img']").val(path_img+','+response.data);
            }
        }
    });
});
</script>