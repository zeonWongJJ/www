<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>添加设备</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
	<style>
		#result img {
			width: 100px;
			height: 100px;
		}
	</style>
</head>
<body>
	<h2>添加设备</h2>
	<form action="<?php echo $this->router->url('device_add'); ?>" method='post' enctype="multipart/form-data">
		设备名称：<input type="text" name="device_name"><br>
		设备型号：<input type="text" name="device_version"><br>
		设备图片：<input type="file" name="device_otherpic[]" id="file" multiple="multiple" /><br>
		<div id="img_box">

		</div>
		设备描述：<textarea name="device_description" id="" cols="30" rows="10"></textarea><br>
		<br>
		<input type="submit" value="添加设备">
	</form>
	<button onclick="readAsDataURL()">预览图片</button>
	<div id="result" name="result"></div>

</body>
</html>

<script>

$(function(){
	$("#file").change(function(event) {
		readAsDataURL();
	});
});

var result=document.getElementById("result");
var file=document.getElementById("file");
function readAsDataURL(){
    var file = document.getElementById("file").files;
    var result=document.getElementById("result");
    $('#result').html('');
    for(i = 0; i< file.length; i ++) {
        var reader    = new FileReader();
        reader.readAsDataURL(file[i]);
        reader.onload=function(e){
            //多图预览
            $('#result').append("<img src='"+this.result+"'>");
        }
    }
}

</script>