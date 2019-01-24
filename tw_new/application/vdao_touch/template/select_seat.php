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
			width: 95px;
			height: 90px;
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
	<h1>选择座位</h1>
	<table>
		<?php $m=2; for($i=0; $i<$a_view_data[0]; $i++){ ?>
			<tr>
				<?php for($j=0; $j<$a_view_data[1]; $j++){ ?>
					<td name="<?php echo $a_view_data[$m]; ?>"></td>
				<?php $m++; }; ?>
			</tr>
		<?php }; ?>
	</table>
</body>
</html>

<script>
$(function(){
	var i = 1;
	$('table td').each(function(index, el) {
		if (i<10) {
			i = '0'+i;
		}
		var name = $(this).attr('name');
		if (name==0) {
			$(this).css('background-color','white');
		} else if (name==1) {
			$(this).css('background-color','orange');
			$(this).html('门');
		} else if (name==2) {
			$(this).css('background-color','blue');
			$(this).html('窗');
		} else if (name==3) {
			$(this).css('background-color','green');
			$(this).html('过道');
		} else if (name==4) {
			$(this).css('background-color','pink');
			$(this).html('座位'+i);
		}
		i++;
	});
});
</script>

