<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>角色管理</title>
	<link rel="stylesheet" href="static/style_default/plugin/layui/css/layui.css">
	<script src="static/style_default/plugin/layui/layui.js"></script>
	<script src="static/style_default/script/jquery-3.2.1.min.js"></script>
	<script src="static/style_default/script/jquery.nicescroll.js"></script>
	<script src="static/style_default/script/iframe_nicescroll.js"></script>
</head>
<body>

<blockquote class="layui-elem-quote layui-quote-nm">
	<button class="layui-btn layui-btn-sm" onclick="javascipt:window.location.reload();">
		<i class="layui-icon">&#x1002;</i>刷新页面
	</button>
	<button class="layui-btn layui-btn-sm monydelete" onclick="delete_mony()">
		<i class="layui-icon">&#xe640;</i>批量删除
	</button>
	<button class="layui-btn layui-btn-sm roleadd">
		<i class="layui-icon">&#xe654;</i>新增角色
	</button>
</blockquote>

<table class="layui-table">
	<thead>
		<tr>
			<th>
				<form class="layui-form">
					<input type="checkbox" name="alluser" lay-skin="primary" lay-filter="allChoose" >
				</form>
			</th>
			<th>编号</th>
			<th>角色名称</th>
			<th>角色描述</th>
			<th>添加时间</th>
			<th>角色开关</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($a_view_data['role'] as $key => $value): ?>
		<tr id="tr_<?php echo $value['role_id']; ?>">
			<td>
				<form class="layui-form">
					<input type="checkbox" name="role_id[]" lay-skin="primary" lay-filter="role_choose" value="<?php echo $value['role_id']; ?>">
				</form>
			</td>
			<td><?php echo $value['role_id']; ?></td>
			<td><?php echo $value['role_name']; ?></td>
			<td><?php echo $value['role_description']; ?></td>
			<td><?php echo date('Y-m-d', $value['role_time']) ?></td>
			<td>
				<form class="layui-form">
					<input type="checkbox" name="role_state" lay-skin="switch" lay-text="开启|关闭" lay-filter="role_state" <?php if ($value['role_state'] == 1) { echo 'checked'; } ?> value="<?php echo $value['role_id']; ?>">
				</form>
			</td>
			<td>
				<div class="layui-btn-group">
				  <button class="layui-btn layui-btn-primary layui-btn-sm updaterole" value="<?php echo $value['role_id']; ?>">
				    <i class="layui-icon">&#xe642;</i>
				  </button>
				  <button class="layui-btn layui-btn-primary layui-btn-sm deletesingle" value="<?php echo $value['role_id']; ?>">
				    <i class="layui-icon">&#xe640;</i>
				  </button>
				</div>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>

</body>
</html>

<script>

layui.use(['form','layer'], function(){
	var form = layui.form;
	var layer = layui.layer;
	// 开关
	form.on('switch(role_state)', function(data){
		var role_id = data.value;
		if (data.elem.checked == true) {
			var role_state = 1;
		} else {
			var role_state = 2;
		}
		// 发送ajax请求改变状态
		$.ajax({
			url: 'role_switch',
			type: 'POST',
			dataType: 'json',
			data: {role_id: role_id,role_state: role_state},
			success: function (res) {
				console.log(res);
			}
		})
	});
	// 删除单条记录
	$('.deletesingle').on('click', function(){
	    var role_id = $(this).attr('value');
		parent.layer.confirm('你确定要删除这条记录吗？', {icon:3, shade:0.3, skin:'layui-layer-molv', closeBtn:1,anim:6}, function(index){
		    $.ajax({
				url:'role_delete',
				data: { role_id: role_id, delete_type: 1 },
				dataType:'json',
				type:'post',
				success:function(res){
					console.log(res);
					if (res.code == 200) {
						$("#tr_"+role_id).remove();
						parent.layer.msg('删除成功', {shade: 0.3, time: 800});
					} else {
						parent.layer.msg(res.msg, {shade: 0.3, time: 800});
					}
				}
		    });
			layer.close(index);
		});
	});
	// 添加
	$('.roleadd').on('click', function(event) {
		var gourl = 'role_add';
		var tid = 'tid_role_add';
		var tab_title = '新增角色';
		parent.son_parent_update(gourl, tid, tab_title);
	});
	// 修改
	$('.updaterole').on('click', function(event) {
		var role_id = $(this).attr('value');
		var gourl = 'role_update-'+role_id;
		var tid = 'tid_role_update_'+role_id;
		var tab_title = '编辑角色';
		parent.son_parent_update(gourl, tid, tab_title);
	});
	// 监听是否选中
	form.on('checkbox(role_choose)', function(data){
		console.log(data.elem.checked); //是否被选中，true或者false
		console.log(data.value); //复选框value值，也可以通过data.elem.value得到
	});
	// 全选
    form.on('checkbox(allChoose)', function (data) {
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="role_state"])');
        child.each(function (index, item) {
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
    });
    // 数据筛选
	form.on('checkbox(data_choose)', function(data){
		console.log(data.elem.checked); //是否被选中，true或者false
		console.log(data.value); //复选框value值，也可以通过data.elem.value得到
		if (data.elem.checked) {
			$('.'+data.value).show();
		} else {
			$('.'+data.value).hide();
		}
	});
})

// 批量删除
function delete_mony() {
	var role_ids = new Array();
	var i = 0;
	$("input[name='role_id[]']").each(function(index, el) {
		if ($(this).is(':checked')) {
			role_ids[i] = $(this).attr('value');
			i++;
		}
	});
	if (role_ids.length > 0) {
		parent.layer.confirm('你确定要删除这'+role_ids.length+'个角色吗？', {icon:3, shade:0.3, skin:'layui-layer-molv', closeBtn:1,anim:6}, function(index){
			// ajax请求
			$.ajax({
				url: 'role_delete',
				type: 'POST',
				dataType: 'json',
				data: {role_ids: role_ids, delete_type: 2},
				success: function(res) {
					console.log(res);
					if (res.code == 200) {
						for (var i = 0; i < role_ids.length; i++) {
							$('#tr_'+role_ids[i]).remove();
						}
						parent.layer.msg('删除成功', {shade: 0.3, time: 800});
					} else {
						parent.layer.msg(res.msg, {shade: 0.3, time: 800});
					}
				}
			})
			layer.close(index);
		});
	} else {
		parent.layer.msg('请先选择需要删除的选项', {shade: 0.3, time: 800});
	}
}


</script>