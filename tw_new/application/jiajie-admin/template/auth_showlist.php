<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>权限管理</title>
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
	<button class="layui-btn layui-btn-sm authadd">
		<i class="layui-icon">&#xe654;</i>新增权限
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
      <th>权限名称</th>
      <th>权限路由</th>
      <th>上级权限</th>
      <th>权限节点</th>
      <th>添加时间</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
  	<?php foreach ($a_view_data['auth'] as $key => $value): ?>
    <tr id="tr_<?php echo $value['auth_id']; ?>">
      <td>
		<form class="layui-form">
			<input type="checkbox" name="auth_id[]" lay-skin="primary" lay-filter="role_choose" value="<?php echo $value['auth_id']; ?>">
		</form>
      </td>
      <td><?php echo $value['auth_id']; ?></td>
      <td>
      <?php echo str_repeat('&nbsp;', $value['auth_level']*4); ?>
      <?php if ($value['auth_pid'] == 0) {
      	echo '<b>' . $value['auth_name'] . '</b>';
      } else {
      	echo $value['auth_name'];
      } ?>
      </td>
      <td><?php echo $value['auth_url']; ?></td>
      <td><?php echo $value['auth_pid']; ?></td>
      <td><?php echo $value['auth_level']; ?></td>
      <td><?php echo date('Y-m-d', $value['auth_time']); ?></td>
      <td>
		<div class="layui-btn-group">
		  <button class="layui-btn layui-btn-primary layui-btn-sm updateauth" value="<?php echo $value['auth_id']; ?>">
		    <i class="layui-icon">&#xe642;</i>
		  </button>
		  <button class="layui-btn layui-btn-primary layui-btn-sm deletesingle" value="<?php echo $value['auth_id']; ?>">
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
	// 删除单条记录
	$('.deletesingle').on('click', function(){
	    var auth_id = $(this).attr('value');
		parent.layer.confirm('你确定要删除这条记录吗？', {icon:3, shade:0.3, skin:'layui-layer-molv', closeBtn:1,anim:6}, function(index){
		    $.ajax({
				url:'auth_delete',
				data: { auth_id: auth_id, delete_type: 1 },
				dataType:'json',
				type:'post',
				success:function(res){
					console.log(res);
					if (res.code == 200) {
						$("#tr_"+auth_id).remove();
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
	$('.authadd').on('click', function(event) {
		var gourl = 'auth_add';
		var tid = 'tid_auth_add';
		var tab_title = '新增权限';
		parent.son_parent_update(gourl, tid, tab_title);
	});
	// 修改
	$('.updateauth').on('click', function(event) {
		var auth_id = $(this).attr('value');
		var gourl = 'auth_update-'+auth_id;
		var tid = 'tid_auth_update_'+auth_id;
		var tab_title = '编辑权限';
		parent.son_parent_update(gourl, tid, tab_title);
	});
	// 监听是否选中
	form.on('checkbox(auth_choose)', function(data){
		console.log(data.elem.checked); //是否被选中，true或者false
		console.log(data.value); //复选框value值，也可以通过data.elem.value得到
	});
	// 全选
    form.on('checkbox(allChoose)', function (data) {
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="auth_state"])');
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
	var auth_ids = new Array();
	var i = 0;
	$("input[name='auth_id[]']").each(function(index, el) {
		if ($(this).is(':checked')) {
			auth_ids[i] = $(this).attr('value');
			i++;
		}
	});
	if (auth_ids.length > 0) {
		parent.layer.confirm('你确定要删除这'+auth_ids.length+'个权限吗？', {icon:3, shade:0.3, skin:'layui-layer-molv', closeBtn:1,anim:6}, function(index){
			// ajax请求
			$.ajax({
				url: 'auth_delete',
				type: 'POST',
				dataType: 'json',
				data: {auth_ids: auth_ids, delete_type: 2},
				success: function(res) {
					console.log(res);
					if (res.code == 200) {
						for (var i = 0; i < auth_ids.length; i++) {
							$('#tr_'+auth_ids[i]).remove();
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