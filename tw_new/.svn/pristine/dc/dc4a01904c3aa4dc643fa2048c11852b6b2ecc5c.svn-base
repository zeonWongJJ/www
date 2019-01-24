<!DOCTYPE HTML>
<html>
<script type="text/javascript" src="script/jquery-1.8.3.js"></script>

<link rel="stylesheet" type="text/css" href="webuploader.css">

<!--引入JS-->
<script type="text/javascript" src="webuploader.min.js"></script>

<style type="text/css">
body {
	font: 13px Arial, Helvetica, Sans-serif;
}
#previewImgs{
	width:350px;
	height:200px;
	list-style:none;
}
#previewImgs li{
	max-width:350px;
	height:auto;
	float:left;
	margin:3px;
}

</style>
</head>

<div id="uploader" class="wu-example">
    <!--用来存放文件信息-->
    <div id="thelist" class="uploader-list"></div>
    <div class="btns">
        <div id="picker">选择文件</div>
    </div>
</div>
<script>
var uploader = WebUploader.create({

    // 选完文件后，是否自动上传。
    auto: true,
    formData: {     //上传图片时附带的参数
                uid: 123
            },
    // swf文件路径
    swf:'http://user.7du.com/Uploader.swf',
    fileNumLimit: 2, 

    // 文件接收服务端。
    server: '/img_upload',

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#picker',

    // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
    }
});
uploader.on('error', function(handler) {

if(handler=="Q_EXCEED_NUM_LIMIT"){
alert("超出最大张数");
}
if(handler=="F_DUPLICATE"){
alert("文件重复");
}
});


    uploader.on( 'fileQueued', function( file ) {
 

        // 创建缩略图
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr( 'src', src );
        }, thumbnailWidth, thumbnailHeight );
    });
</script>
</html>