<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>预约办公室</title>
	<style>
		table{
			border-collapse: collapse;
		}
		td {
			width: 60px;
			height: 60px;
			text-align: center;
			vertical-align:bottom;
			padding-bottom: 5px;
			border: 1px solid green;
		}
		a {
			text-decoration: none;
			color: rgb(120, 196, 236);
		}
		td:hover{
			cursor: pointer;
		}
	</style>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>预约办公室</h1>
	<p><?php echo $a_view_data['room']['room_name']; ?></p>
	<p><?php echo $a_view_data['room']['room_size'].'m<sup>2</sup> ' . $a_view_data['room']['device'] . ' 可坐'.$a_view_data['room']['room_seat'].'人'; ?></p>
	<p id="occupy" style="display:none"><?php echo $a_view_data['occupy']; ?></p>
	<p id="seatname" style="display:none"><?php echo $a_view_data['seatname']; ?></p>
	<form action="<?php echo $this->router->url('order_office'); ?>" method="post">
		<input type="hidden" name="office_id" value="<?php echo $a_view_data['office']['office_id']; ?>">
		<input type="hidden" name="store_id" value="<?php echo $a_view_data['office']['store_id']; ?>">
		<input type="hidden" name="room_id" value="<?php echo $a_view_data['room']['room_id']; ?>">
		<input type="hidden" name="room_name" value="<?php echo $a_view_data['room']['room_name']; ?>">
		<input type="hidden" name="office_seat" value="">
<!-- 		联系人：<input type="text" name="linkman"><br>
		手机号码：<input type="text" name="link_phone"><br> -->
		<a href="#" onclick="select_seat()">点击选择座位</a>
		<input type="text" name="office_seatname"><br>
		到达时间：
		<select name="arrival_time">
			<option value="10:30-11:00">10:30-11:00</option>
			<option value="12:30-13:00">12:30-13:00</option>
			<option value="13:30-14:00">13:30-14:00</option>
			<option value="15:30-16:00">15:30-16:00</option>
		</select>
		<br>
		<input type="submit" value="确定">
	</form>
	<div id="choose_seat" style="border:1px solid red; display:none;">
		<table>
			<?php $m=2; for($i=0; $i<$a_view_data['plan'][0]; $i++){ ?>
				<tr>
					<?php for($j=0; $j<$a_view_data['plan'][1]; $j++){ ?>
						<td name="<?php echo $a_view_data['plan'][$m]; ?>" seatname="<?php echo $a_view_data['seatname'][$m-2]; ?>"></td>
					<?php $m++; }; ?>
				</tr>
			<?php }; ?>
		</table>
	</div>
</body>
</html>

<script>
function select_seat() {
	var tabdisplay = $('#choose_seat').css('display');
	if (tabdisplay=='none') {
		$('#choose_seat').css('display','block');
	} else {
		$('#choose_seat').css('display','none');
	}
}

$(function(){
	reflush_display();
});


$('table td').click(function(event) {
	if ($(this).attr('name')==4) {
		reflush_display();
		var thisvalue = $(this).attr('value')
		var thisseatname = $(this).attr('seatname')
		$("input[name='office_seat']").val(thisvalue);
		if (thisseatname==0) {
			$("input[name='office_seatname']").val(thisvalue);
		} else {
			$("input[name='office_seatname']").val(thisseatname);
		}
		$(this).css('background-color','#7FFFD4');
		$(this).css('color','red');
	} else {
		alert('请选择正确的位置！');
	}
});

function reflush_display() {
	var i = 1;
	var occupy = $('#occupy').html();
	occupy = occupy.split(",");
	var pos;
	$('table td').each(function(index, el) {
		if (i<10) {
			i = '0'+i;
		}
		var name = $(this).attr('name');
		var seatname = $(this).attr('seatname');
		if (seatname==0) {
			seatname = i;
		}
		if (name==0) {
			$(this).css('background-color','white');
			$(this).css('color','#000000');
		} else if (name==1) {
			$(this).css('background-color','orange');
			$(this).html('门');
			$(this).css('color','#000000');
		} else if (name==2) {
			$(this).css('background-color','blue');
			$(this).html('窗');
			$(this).css('color','#000000');
		} else if (name==3) {
			$(this).css('background-color','green');
			$(this).html('过道');
			$(this).css('color','#000000');
		} else if (name==4) {
			$(this).css('background-color','pink');
			$(this).html('座位'+seatname);
			$(this).css('color','#000000');
		}
		$(this).attr('value',i);
		for (var j=0; j<occupy.length; j++) {
			if (i==occupy[j]) {
				$(this).attr('name','10');
				$(this).css('background-color','#A52A2A');
				$(this).html(seatname+'<br>已占用')
			}
		}
		i++;
	});
}

</script>