<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>添加房间</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
	<style>
		#result img {
			width: 100px;
			height: 100px;
		}
	</style>
</head>
<body>
	<h2>添加房间</h2>
	<form action="<?php echo $this->router->url('room_add'); ?>" method='post' enctype="multipart/form-data">
		房间名称：<input type="text" name="room_name"><br>
		房间分类：
		<select name="type_id">
			<?php foreach ($a_view_data['type'] as $key => $value): ?>
				<option value="<?php echo $value['type_id']; ?>"><?php echo str_repeat('--',$value['type_level']) . $value['type_name']; ?></option>
			<?php endforeach ?>
		</select>
		<br>
		房间关键词：<input type="text" name="room_keywords"><br>
		房间大小：<input type="text" name="room_size"><br>
		配备座位：<input type="text" name="room_seat"><br>
		配备设备：
		<?php foreach ($a_view_data['device'] as $key => $value): ?>
			<input type="checkbox" name="device_id[]" value="<?php echo $value['device_id']; ?>"> <?php echo $value['device_name']; ?>
		<?php endforeach ?>
		<br>
		房间图片：<input type="file" id="file" name="room_otherpic[]" multiple="multiple"><br>
		房间描述：<textarea name="room_description" id="" cols="30" rows="10"></textarea><br>
		<input type="submit" value="添加房间">
	</form>
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