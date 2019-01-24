<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>管理员管理</title>
	<link rel="stylesheet" href="static/style_default/plugin/layui/css/layui.css">
	<script src="static/style_default/plugin/layui/layui.js"></script>
	<script src="static/style_default/script/jquery-3.2.1.min.js"></script>
	<script src="static/style_default/script/jquery.nicescroll.js"></script>
	<script src="static/style_default/script/iframe_nicescroll.js"></script>
	<style>
		.isshow {
			display: none;
		}
		.data_ip,.data_email,.data_register {
			display: none;
		}
		.data_pic img {
			width:50px;
			height:50px;
			border-radius:5px;
		}
		.user_shuai form {
			line-height: 30px;
		}
		.data_caozuo {
			text-align: center;
		}
	</style>
</head>
<body>

<blockquote class="layui-elem-quote layui-quote-nm">
	<button class="layui-btn layui-btn-sm" onclick="javascipt:window.location.reload();">
		<i class="layui-icon">&#x1002;</i>刷新页面
	</button>
	<button class="layui-btn layui-btn-sm monydelete" onclick="delete_mony()">
		<i class="layui-icon">&#xe640;</i>批量删除
	</button>
	<button class="layui-btn layui-btn-sm adminadd">
		<i class="layui-icon">&#xe654;</i>新增管理员
	</button>
</blockquote>

<fieldset class="layui-elem-field layui-field-title">
	<legend>数据筛选</legend>
	<div class="layui-field-box user_shuai">
		<form class="layui-form">
			<input type="checkbox" name="data_pic" title="头像" lay-skin="primary" lay-filter="data_choose" value="data_pic" checked>
			<input type="checkbox" name="data_name" title="用户名" lay-skin="primary" lay-filter="data_choose" value="data_name" checked>
			<input type="checkbox" name="data_realname" title="姓名" lay-skin="primary" lay-filter="data_choose" value="data_realname" checked>
			<input type="checkbox" name="data_sex" title="性别" lay-skin="primary" lay-filter="data_choose" value="data_sex" checked>
			<input type="checkbox" name="data_role" title="角色" lay-skin="primary" lay-filter="data_choose" value="data_role" checked>
			<input type="checkbox" name="data_phone" title="手机" lay-skin="primary" lay-filter="data_choose" value="data_phone" checked>
			<input type="checkbox" name="data_email" title="邮箱" lay-skin="primary" lay-filter="data_choose" value="data_email">
			<input type="checkbox" name="data_register" title="加入时间" lay-skin="primary" lay-filter="data_choose" value="data_register">
			<input type="checkbox" name="data_logintime" title="登录时间" lay-skin="primary" lay-filter="data_choose" value="data_logintime" checked>
			<input type="checkbox" name="data_ip" title="登录IP" lay-skin="primary" lay-filter="data_choose" value="data_ip">
			<input type="checkbox" name="data_state" title="状态" lay-skin="primary" lay-filter="data_choose" value="data_state" checked>
			<input type="checkbox" name="data_caozuo" title="操作" lay-skin="primary" lay-filter="data_choose" value="data_caozuo" checked>
		</form>
	</div>
</fieldset>

<table class="layui-table">
	<thead>
		<tr>
			<th>
				<form class="layui-form">
					<input type="checkbox" name="alluser" lay-skin="primary" lay-filter="allChoose" >
				</form>
			</th>
			<th>编号</th>
			<th class="data_pic">头像</th>
			<th class="data_name">用户名</th>
			<th class="data_realname">姓名</th>
			<th class="data_sex">性别</th>
			<th class="data_role">角色</th>
			<th class="data_phone">手机号</th>
			<th class="data_email">邮箱</th>
			<th class="data_register">加入时间</th>
			<th class="data_logintime">登录时间</th>
			<th class="data_ip">登录IP</th>
			<th class="data_state">状态</th>
			<th class="data_caozuo">操作</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($a_view_data['admin'] as $key => $value): ?>
		<tr id="tr_<?php echo $value['admin_id']; ?>">
			<td>
				<form class="layui-form">
					<input type="checkbox" name="admin_id[]" lay-skin="primary" lay-filter="admin_choose" value="<?php echo $value['admin_id']; ?>">
				</form>
			</td>
			<td><?php echo $value['admin_id']; ?></td>
			<td class="data_pic" style="text-align:center;">
			<?php if (!empty($value['admin_pic'])) {
				echo '<img src="/'.$value['admin_pic'].'">';
			} ?>
			</td>
			<td class="data_name"><?php echo $value['admin_name']; ?></td>
			<td class="data_realname"><?php echo $value['admin_realname']; ?></td>
			<td class="data_sex">
			<?php if ($value['admin_sex'] == 1) {
				echo '男';
			} else if ($value['admin_sex'] == 2) {
				echo '女';
			} else {
				echo '未知';
			}  ?>
			</td>
			<td class="data_role"><?php echo $value['role_name']; ?></td>
			<td class="data_phone"><?php echo $value['admin_phone']; ?></td>
			<td class="data_email"><?php echo $value['admin_email']; ?></td>
			<td class="data_register"><?php echo date('Y-m-d',$value['register_time']); ?></td>
			<td class="data_logintime"><?php echo date('Y-m-d',$value['login_time']); ?></td>
			<td class="data_ip"><?php echo $value['login_ip']; ?></td>
			<td class="data_state">
				<form class="layui-form">
					<input type="checkbox" name="admin_state" lay-skin="switch" lay-text="开启|关闭" lay-filter="admin_state" <?php if ($value['admin_state'] == 1) { echo 'checked'; } ?> value="<?php echo $value['admin_id']; ?>">
				</form>
			</td>
			<td class="data_caozuo">
				<div class="layui-btn-group">
				  <button class="layui-btn layui-btn-primary layui-btn-sm updateadmin" value="<?php echo $value['admin_id']; ?>">
				    <i class="layui-icon">&#xe642;</i>
				  </button>
				  <button class="layui-btn layui-btn-primary layui-btn-sm deletesingle" value="<?php echo $value['admin_id']; ?>">
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
	form.on('switch(admin_state)', function(data){
		var admin_id = data.value;
		if (data.elem.checked == true) {
			var admin_state = 1;
		} else {
			var admin_state = 2;
		}
		// 发送ajax请求改变状态
		$.ajax({
			url: 'admin_switch',
			type: 'POST',
			dataType: 'json',
			data: {admin_id: admin_id,admin_state: admin_state},
			success: function (res) {
				console.log(res);
				if (res.code == 400) {
					if (data.elem.checked == true) {
						data.elem.checked = false;
					} else {
						data.elem.checked = true;
					}
					form.render('checkbox');
					parent.layer.msg(res.msg, {shade: 0.3, time: 800});
				}
			}
		})
	});
	// 删除单条记录
	$('.deletesingle').on('click', function(){
	    var admin_id = $(this).attr('value');
		parent.layer.confirm('你确定要删除这条记录吗？', {icon:3, shade:0.3, skin:'layui-layer-molv', closeBtn:1,anim:6}, function(index){
		    $.ajax({
				url:'admin_delete',
				data: { admin_id: admin_id, delete_type: 1 },
				dataType:'json',
				type:'post',
				success:function(res){
					console.log(res);
					if (res.code == 200) {
						$("#tr_"+admin_id).remove();
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
	$('.adminadd').on('click', function(event) {
		var gourl = 'admin_add';
		var tid = 'tid_admin_add';
		var tab_title = '新增管理员';
		parent.son_parent_update(gourl, tid, tab_title);
	});
	// 修改
	$('.updateadmin').on('click', function(event) {
		var admin_id = $(this).attr('value');
		var gourl = 'admin_update-'+admin_id;
		var tid = 'tid_admin_update_'+admin_id;
		var tab_title = '编辑管理员';
		parent.son_parent_update(gourl, tid, tab_title);
	});
	// 监听是否选中
	form.on('checkbox(admin_choose)', function(data){
		console.log(data.elem.checked); //是否被选中，true或者false
		console.log(data.value); //复选框value值，也可以通过data.elem.value得到
	});
	// 全选
    form.on('checkbox(allChoose)', function (data) {
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="admin_state"])');
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
	var admin_ids = new Array();
	var i = 0;
	$("input[name='admin_id[]']").each(function(index, el) {
		if ($(this).is(':checked')) {
			admin_ids[i] = $(this).attr('value');
			i++;
		}
	});
	if (admin_ids.length > 0) {
		parent.layer.confirm('你确定要删除这'+admin_ids.length+'个管理员吗？', {icon:3, shade:0.3, skin:'layui-layer-molv', closeBtn:1,anim:6}, function(index){
			// ajax请求
			$.ajax({
				url: 'admin_delete',
				type: 'POST',
				dataType: 'json',
				data: {admin_ids: admin_ids, delete_type: 2},
				success: function(res) {
					console.log(res);
					if (res.code == 200) {
						for (var i = 0; i < admin_ids.length; i++) {
							$('#tr_'+admin_ids[i]).remove();
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