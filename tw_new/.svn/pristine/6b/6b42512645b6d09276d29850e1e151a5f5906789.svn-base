<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>选择座位</title>
	<script src='./script/jquery-1.8.2.min.js'></script>
	<style>
		table{
			border-collapse: collapse;
		}
		td {
			width: 120px;
			height: 120px;
			text-align: center;
			vertical-align:bottom;
			padding-bottom: 5px;
			border: 1px solid green;
		}
		a {
			text-decoration: none;
			color: rgb(120, 196, 236);
		}
	</style>
</head>
<body>
	<h1>设置座位 <a href="#" onclick="add_tr()">增加行</a> | <a href="#" onclick="add_td()">增加列</a> | <a href="#" onclick="reduce_tr()">减少行</a> | <a href="#" onclick="reduce_td()">减少列</a></h1>
	<table id="tab">
		<?php for($i=1; $i<3; $i++) { ?>
		<tr>
			<?php for($j=1; $j<3; $j++) { ?>
				<td>
					<p></p>
					<a href="#" class="door" onclick="set_door()">门</a>&nbsp;
					<a href="#" class="window" onclick="set_window()">窗</a>&nbsp;
					<a href="#" class="aisle" onclick="set_aisle()">过</a>&nbsp;
					<a href="#" class="seat" onclick="set_seat()">座</a>&nbsp;
					<a href="#" class="name" onclick="set_name()">名</a>
				</td>
			<?php }; ?>
		</tr>
		<?php }; ?>
	</table>
	<br>
	<a href="#" onclick="save_set()">保存设置</a>
</body>
</html>

<script>

function set_door(num) {
	$('#td_'+num).css('background-color','orange');
	$('#td_'+num).attr('name',1);
}

function set_window(num) {
	$('#td_'+num).css('background-color','blue');
	$('#td_'+num).attr('name',2);
}

function set_aisle(num) {
	$('#td_'+num).css('background-color','green');
	$('#td_'+num).attr('name',3);
}

function set_seat(num) {
	$('#td_'+num).css('background-color','pink');
	$('#td_'+num).attr('name',4);
}

function set_name(num) {
	 var name = prompt("请输入座位名称","");
	 if (name != '') {
	 	$('#td_'+num).attr('seatname',name);
	 	$('#td_'+num).children('p').html($('#td_'+num).attr('seatname'));
	 } else {
	 	$('#td_'+num).attr('seatname',0);
	 }
}

function add_tr() {
	var length = $("#tab").find("tr").eq(0).children('td').length;
	var content = '<tr>'
	for (var i=0; i<length; i++) {
		content += '<td><p></p><a href="#" class="door">门</a>&nbsp;<a href="#" class="window">窗</a>&nbsp;<a href="#" class="aisle">过</a>&nbsp;<a href="#" class="seat">座</a>&nbsp;<a href="#" class="name">名</a></td>'
	}
	content += '</tr>';
	$('#tab').append(content);
	refresh_id();
}

function add_td() {
	$('#tab tr').each(function(index, el) {
		$(this).append('<td><p></p><a href="#" class="door">门</a>&nbsp;<a href="#" class="window">窗</a>&nbsp;<a href="#" class="aisle">过</a>&nbsp;<a href="#" class="seat">座</a>&nbsp;<a href="#" class="name">名</a></td>')
	});
	refresh_id();
}

function reduce_tr() {
	var tr_lehgth = $('#tab tr').length;
	if (tr_lehgth > 2) {
		$("#tab tr:last").remove();
		refresh_id();
	} else {
		alert('不能再减少啦！');
	}
}

function reduce_td() {
	var td_length = $("#tab tr td").length;
	if (td_length > 4) {
		$('#tab tr').each(function(index, el) {
			$(this).children("td:last-child").remove();
		});
		refresh_id();
	} else {
		alert('不能再减少啦！');
	}
}

$(function(){
	refresh_id();
});

//刷新id
function refresh_id() {
	var i = 1;
	$('#tab td').each(function(index, el) {
		$(this).attr('id','td_'+i);
		if(typeof($(this).attr("name"))=="undefined"){
			$(this).attr('name',0);
		}
		if(typeof($(this).attr("seatname"))=="undefined"){
			$(this).attr('seatname',0);
		}
		if ($(this).attr('seatname')!=0) {
			$(this).children('p').html($(this).attr('seatname'));
		}
		$(this).children('.door').attr('onclick','set_door('+i+')');
		$(this).children('.window').attr('onclick','set_window('+i+')');
		$(this).children('.aisle').attr('onclick','set_aisle('+i+')');
		$(this).children('.seat').attr('onclick','set_seat('+i+')');
		$(this).children('.name').attr('onclick','set_name('+i+')');
		i++;
	});
}

//保存数据
function save_set() {
	var row_lehgth = $('#tab tr').length;
	var col_length = $("#tab").find("tr").eq(0).children('td').length;
	var seat_arr = new Array();
	var seatname = new Array();
	seat_arr[0] = row_lehgth;
	seat_arr[1] = col_length;
	var i = 2;
	$('#tab td').each(function(index, el) {
		seat_arr[i] = $(this).attr('name');
		seatname[i-2] = $(this).attr('seatname');
		i++;
	})
	//将数组拼接成字符串
	var seat_str = seat_arr.join('-');
	var seatname_str = seatname.join('-');
	alert(seat_str);
	alert(seatname_str);
}

</script>