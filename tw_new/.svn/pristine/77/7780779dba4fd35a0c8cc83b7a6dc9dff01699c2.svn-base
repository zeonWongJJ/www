<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>设置列表</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
	<style>
		table{
			border-collapse: collapse;
		}
		th,td{
			padding: 8px;
			border: 1px solid green;
		}
	</style>
</head>
<body>
	<h1>设置列表</h1>
	<table>
		<tr>
			<th>id</th>
			<th>参数名</th>
			<th>参数</th>
			<th>描述</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr id="<?php echo 'tr_'.$value['set_id']; ?>">
			<td><?php echo $value['set_id']; ?></td>
			<td><?php echo $value['set_name']; ?></td>
			<td><input id="<?php echo 'input_'.$value['set_id']; ?>" type="text" name="set_parameter" value="<?php echo $value['set_parameter']; ?>" oldvalue="<?php echo $value['set_parameter']; ?>" setid="<?php echo $value['set_id']; ?>" onblur="add_diabled(<?php echo $value['set_id']; ?>)" disabled>
			</td>
			<td><?php echo $value['set_description']; ?></td>
			<td>
				<a href="#" onclick="set_update(<?php echo $value['set_id']; ?>)">修改</a> |
				<a href="#" onclick="set_save(<?php echo $value['set_id']; ?>)">保存</a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<?php echo $this->pages->link_style_one($this->router->url('set_showlist-', [], false, false)); ?>
	<br>
	<button onclick="set_save_mony()">保存设置</button><br>
</body>
</html>

<script>

function set_update(set_id) {
	$('input').attr('disabled','true');
	$('#input_'+set_id).removeAttr("disabled");
}

function add_diabled(set_id) {
	$('#input_'+set_id).attr('disabled','true');
}

function set_save(set_id) {
	var set_parameter = $('#input_'+set_id).val();
	var oldvalue = $('#input_'+set_id).attr('oldvalue');
	if (set_parameter != oldvalue) {
		$.ajax({
			url: '<?php echo $this->router->url('set_update'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {set_parameter: set_parameter, set_id: set_id, type: 1},
			success: function(data) {
				console.log(data);
			}
		})
	}
}

function set_save_mony() {
	var set_ids = new Array();
	var set_parameters = new Array();
	var i = 0;
	$("input[name='set_parameter']").each(function(index, el) {
		if ($(this).attr('oldvalue') != $(this).val() && $(this).val() != '') {
			set_ids[i] = $(this).attr('setid');
			set_parameters[i] = $(this).val();
			i++;
		}
	});
	if (set_ids.length != 0) {
		$.ajax({
			url: '<?php echo $this->router->url('set_update'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {set_ids: set_ids, set_parameters: set_parameters, type: 2},
			success: function(data) {
				console.log(data);
				if(data.code==200) {
					alert('保存设置成功');
				}
			}
		})
	} else {
		alert('没有需要保存的数据');
	}
}

</script>