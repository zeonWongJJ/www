<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改房间</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
	<style>
		#result img {
			width:120px;
		}
	</style>
</head>
<body>
	<h1>修改房间</h1>
	<form action="<?php echo $this->router->url('room_update'); ?>" method='post' enctype="multipart/form-data">
		<input type="hidden" id="record_id" name="room_id" value="<?php echo $a_view_data['detail']['room_id']; ?>">
		房间名称：<input type="text" name="room_name" value="<?php echo $a_view_data['detail']['room_name']; ?>"><br>
		房间分类：
		<select name="type_id">
			<?php foreach ($a_view_data['type'] as $key => $value): ?>
				<option value="<?php echo $value['type_id']; ?>" <?php if ($a_view_data['detail']['type_id']==$value['type_id']) { echo "selected"; } ?>><?php echo str_repeat('--',$value['type_level']) . $value['type_name']; ?></option>
			<?php endforeach ?>
		</select>
		<br>
		房间关键词：<input type="text" name="room_keywords" value="<?php echo $a_view_data['detail']['room_keywords']; ?>"><br>
		房间大小：<input type="text" name="room_size" value="<?php echo $a_view_data['detail']['room_size']; ?>"><br>
		配备座位：<input type="text" name="room_seat" value="<?php echo $a_view_data['detail']['room_seat']; ?>"><br>
		配备设备：
		<?php foreach ($a_view_data['device'] as $key => $value): ?>
			<input type="checkbox" name="device_id[]" value="<?php echo $value['device_id']; ?>" <?php if(strpos( $a_view_data['detail']['device_ids'], $value['device_id'])!==false){ echo "checked"; } ?>> <?php echo $value['device_name']; ?>
		<?php endforeach ?>
		<br>
		房间图片：<input type="file" id="file" name="room_otherpic[]" multiple="multiple"><br>
		房间描述：<textarea name="room_description" id="" cols="30" rows="10"><?php echo $a_view_data['detail']['room_description']; ?></textarea><br>
		<br>
		<?php
			$imgs = explode('&', $a_view_data['detail']['room_otherpic']);
			for ($i=0; $i<count($imgs); $i++) {
				echo "<span id='img_".$i."' onclick='del(".$i.','.$a_view_data['detail']['room_id'].")'><img style='width:100px;' src='".$imgs[$i]."'></span>";
			}
		?>
		<div id="result" name="result"></div>
		<br>
		主图：<img style="width:150px;" src="<?php echo $a_view_data['detail']['room_mainpic']; ?>">
		<input type="hidden" name="original_pic" value="<?php echo $a_view_data['detail']['room_otherpic']; ?>">
		<input type="hidden" name="room_mainpic" value="<?php echo $a_view_data['detail']['room_mainpic']; ?>">
		<input type="submit" value="修改房间">
	</form>
</body>
</html>

<script>

function del(num, room_id) {
	if (confirm('你确定要删除这张图片吗？')) {
		var del_src = $('#img_'+num+' img').attr('src');
		$.ajax({
			url: '<?php echo $this->router->url('room_update'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {path: del_src},
			success: function(data) {
				console.log(data);
				if (data.code==200) {
					var original_pic = $("input:hidden[name='original_pic']").val();
					original_pic = original_pic.split('&');
					for (var i=0; i<original_pic.length; i++) {
						if (original_pic[i]==del_src) {
							original_pic.splice(i,1);
							original_pic = original_pic.join('&');
							$("input:hidden[name='original_pic']").val(original_pic);
						}
					}
					$('#img_'+num).remove();
				}
			}
		})
	}
}

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
            $('#result').append("<span id='pic_"+i+"' onclick='del_this("+i+")'><img src='"+this.result+"'></span>");
        }
    }
}

function del_this(i) {
	$("#pic_"+i).remove();
}

</script>


