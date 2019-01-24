<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>设置平面图</title>
	<style>
		table{
			border-collapse: collapse;
		}
		td {
			width: 150px;
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
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>设置平面图</h1>
	<h3>设置座位 <a href="#" onclick="add_tr()">增加行</a> | <a href="#" onclick="add_td()">增加列</a> | <a href="#" onclick="reduce_tr()">减少行</a> | <a href="#" onclick="reduce_td()">减少列</a> | <a href="#" onclick="save_set()">保存设置</a></h3>
	<table id="tab">
		<?php $m=2; for($i=0; $i<$a_view_data['plan'][0]; $i++){ ?>
			<tr>
				<?php for($j=0; $j<$a_view_data['plan'][1]; $j++){ ?>
					<td name="<?php echo $a_view_data['plan'][$m]; ?>" seatname="<?php echo $a_view_data['seatname'][$m-2]; ?>">
						<p class='sname'></p>
						<a href="#" class="door" onclick="set_door()">门</a>&nbsp;
						<a href="#" class="window" onclick="set_window()">窗</a>&nbsp;
						<a href="#" class="aisle" onclick="set_aisle()">过</a>&nbsp;
						<a href="#" class="seat" onclick="set_seat()">座</a>&nbsp;
						<a href="#" class="name" onclick="set_name()">名</a>
						<a href="#" class="kong" onclick="set_kong()">空</a>
					</td>
				<?php $m++; }; ?>
			</tr>
		<?php }; ?>
	</table>
	<button onclick="save_set()">保存设置</button>
</body>
</html>

<script>

$(function(){
	reflush_display();
	refresh_tdid();
})

function add_tr() {
	var length = $("#tab").find("tr").eq(0).children('td').length;
	var content = '<tr>'
	for (var i=0; i<length; i++) {
		content += '<td name="0" seatname="0"><p class="sname"></p><a href="#" class="door" onclick="set_door()">门</a>&nbsp;<a href="#" class="window" onclick="set_window()">窗</a>&nbsp;<a href="#" class="aisle" onclick="set_aisle()">过</a>&nbsp;<a href="#" class="seat" onclick="set_seat()">座</a>&nbsp;<a href="#" class="name" onclick="set_name()">名</a><a href="#" class="kong" onclick="set_kong()">空</a></td>'
	}
	content += '</tr>';
	$('#tab').append(content);
	refresh_tdid();
	reflush_display();
}


function add_td() {
	$('#tab tr').each(function(index, el) {
		$(this).append('<td name="0" seatname="0"><p class="sname"></p><a href="#" class="door" onclick="set_door()">门</a>&nbsp;<a href="#" class="window" onclick="set_window()">窗</a>&nbsp;<a href="#" class="aisle" onclick="set_aisle()">过</a>&nbsp;<a href="#" class="seat" onclick="set_seat()">座</a>&nbsp;<a href="#" class="name" onclick="set_name()">名</a><a href="#" class="kong" onclick="set_kong()">空</a></td>')
	});
	refresh_tdid();
	reflush_display();
}

function reduce_tr() {
	var tr_lehgth = $('#tab tr').length;
	if (tr_lehgth > 2) {
		$("#tab tr:last").remove();
		refresh_tdid();
		reflush_display();
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
		refresh_tdid();
		reflush_display();
	} else {
		alert('不能再减少啦！');
	}
}

function set_kong(num) {
	$('#td_'+num).css('background-color','white');
	$('#td_'+num).attr('name',0);
	$('#td_'+num).attr('seatname',0);
	$('#td_'+num).children('.sname').html('');
}

function set_door(num) {
	$('#td_'+num).css('background-color','orange');
	$('#td_'+num).attr('name',1);
	$('#td_'+num).attr('seatname',0);
	$('#td_'+num).children('.sname').html('');
}

function set_window(num) {
	$('#td_'+num).css('background-color','blue');
	$('#td_'+num).attr('name',2);
	$('#td_'+num).attr('seatname',0);
	$('#td_'+num).children('.sname').html('');
}

function set_aisle(num) {
	$('#td_'+num).css('background-color','green');
	$('#td_'+num).attr('name',3);
	$('#td_'+num).attr('seatname',0);
	$('#td_'+num).children('.sname').html('');
}

function set_seat(num) {
	$('#td_'+num).css('background-color','pink');
	$('#td_'+num).attr('name',4);
}

function set_name(num) {
	 var name = prompt("请输入座位名称","");
	 if (name != '') {
	 	$('#td_'+num).attr('seatname',name);
	 	$('#td_'+num).children('.sname').html(name);
	 } else {
	 	$('#td_'+num).attr('seatname',0);
	 }
}

function reflush_display() {
	var i = 1;
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
			$(this).children('.sname').html('门');
			$(this).css('color','#000000');
		} else if (name==2) {
			$(this).css('background-color','blue');
			$(this).children('.sname').html('窗');
			$(this).css('color','#000000');
		} else if (name==3) {
			$(this).css('background-color','green');
			$(this).children('.sname').html('过道');
			$(this).css('color','#000000');
		} else if (name==4) {
			$(this).css('background-color','pink');
			$(this).children('.sname').html('座位 ['+seatname + ']');
			$(this).css('color','#000000');
		}
		i++;
	});
}

function refresh_tdid() {
	var i = 1;
	$('table td').each(function(index, el) {
		$(this).attr('tdid',i);
		$(this).attr('id','td_'+i);
		$(this).children('.door').attr('onclick','set_door('+i+')');
		$(this).children('.window').attr('onclick','set_window('+i+')');
		$(this).children('.aisle').attr('onclick','set_aisle('+i+')');
		$(this).children('.seat').attr('onclick','set_seat('+i+')');
		$(this).children('.name').attr('onclick','set_name('+i+')');
		$(this).children('.kong').attr('onclick','set_kong('+i+')');
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
	var office_id = '<?php echo $a_view_data['office_id']; ?>';
	// alert(office_id);
	// alert(seat_str);
	// alert(seatname_str);
	$.ajax({
		url: '<?php echo $this->router->url('save_plan'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {office_plan: seat_str, office_seatname: seatname_str, office_id: office_id},
		success: function(data){
			console.log(data);
			if (data.code==200) {
				alert('保存设置成功');
				window.location.href = '<?php echo $this->router->url('office_showlist'); ?>';
			}
		}
	})
}

</script>