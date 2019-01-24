<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加角色</title>
	<link rel="stylesheet" href="static/style_default/plugin/layui/css/layui.css">
	<script src="static/style_default/plugin/layui/layui.js"></script>
	<script src="static/style_default/script/jquery-3.2.1.min.js"></script>
	<script src="static/style_default/script/jquery.nicescroll.js"></script>
	<script src="static/style_default/script/iframe_nicescroll.js"></script>
</head>
<body>

<div style="margin-top:15px;">
<form class="layui-form">
  <div class="layui-form-item">
    <label class="layui-form-label">角色名称</label>
    <div class="layui-input-inline">
      <input type="text" name="role_name" required lay-verify="required" placeholder="角色名称" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">角色名称</div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">角色状态</label>
    <div class="layui-input-inline">
      <select name="role_state" lay-verify="required">
        <option value=""></option>
        <option value="1">开启</option>
        <option value="2">关闭</option>
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">角色权限</label>
    <div class="layui-input-block">
		<table class="layui-table">
		  <tbody>
	    	<?php foreach ($a_view_data['auth'] as $key => $value): ?>
		    <?php if ($value['auth_pid'] == 0) { ?>
		    <tr id="tr_<?php echo $value['auth_id']; ?>">
		      <td>
		      	<input type="checkbox" name="role_auth[]" title="<?php echo $value['auth_name']; ?>" lay-skin="primary" value="<?php echo $value['auth_id']; ?>" lay-filter="p_auth_choose">
		      </td>
		      <td class="td_two">
			  <?php foreach ($a_view_data['auth'] as $k => $v): ?>
		      <?php if ($v['auth_pid'] == $value['auth_id']) { ?>
		      	<input type="checkbox" name="role_auth[]" title="<?php echo $v['auth_name']; ?>" lay-skin="primary" value="<?php echo $v['auth_id']; ?>">
		      <?php } ?>
			  <?php endforeach ?>
		      </td>
		    </tr>
		    <?php } ?>
	    	<?php endforeach ?>
		  </tbody>
		</table>
    </div>
  </div>
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">角色描述</label>
    <div class="layui-input-block">
      <textarea name="role_description" placeholder="请输入内容" class="layui-textarea"></textarea>
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置表单</button>
    </div>
  </div>
</form>
</div>

</body>
</html>

<script>

layui.use(['form','layer','element','upload'], function(){
	var form = layui.form;
	var upload = layui.upload;
	var element = layui.element;

	//监听提交
	form.on('submit(formDemo)', function(data){
		console.log(data.field);
		// ajax提交表单
		$.ajax({
			url: 'role_add',
			type: 'POST',
			dataType: 'json',
			data: data.field,
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					parent.layer.msg('添加成功', {shade: 0.4, time: 800});
					// 添加成功后关闭当前tab 切换到用户列表
					var gourl = 'role_showlist';
					var tid = 'tid_role_list';
					var tab_title = '角色管理';
					parent.son_parent_fun(gourl, tid, tab_title);
				} else {
					parent.layer.msg(res.msg, {shade: 0.4, time: 1000});
				}
			}
		})
		return false;
	});

	// 监听是否选中
	form.on('checkbox(p_auth_choose)', function(data){
		console.log(data.elem.checked); //是否被选中，true或者false
		console.log(data.value); //复选框value值，也可以通过data.elem.value得到
        var child = $(data.elem).parents('#tr_'+data.value).find('.td_two input[type="checkbox"]');
        child.each(function (index, item) {
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
	});

})

</script>