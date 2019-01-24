<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加权限</title>
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
    <label class="layui-form-label">权限名称</label>
    <div class="layui-input-inline">
      <input type="text" name="auth_name" required lay-verify="required" placeholder="请输入权限名称" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">上级权限</label>
    <div class="layui-input-inline">
      <select name="auth_pid" lay-verify="required">
        <option value=""></option>
        <option value="0">顶级权限</option>
        <?php foreach ($a_view_data['auth'] as $key => $value): ?>
        <option value="<?php echo $value['auth_id']; ?>"><?php echo $value['auth_name']; ?></option>
        <?php endforeach ?>
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">权限路由</label>
    <div class="layui-input-inline">
      <input type="text" name="auth_url" placeholder="请输入路由" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">权限描述</label>
    <div class="layui-input-inline" style="width:300px;">
      <textarea name="auth_description" placeholder="请输入内容" class="layui-textarea"></textarea>
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

layui.use(['form','layer','element'], function(){
	var form = layui.form;
	var element = layui.element;
	//监听提交
	form.on('submit(formDemo)', function(data){
		console.log(data.field);
		// ajax提交表单
		$.ajax({
			url: 'auth_add',
			type: 'POST',
			dataType: 'json',
			data: data.field,
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					parent.layer.msg('添加成功', {shade: 0.4, time: 800});
					// 添加成功后关闭当前tab 切换到用户列表
					var gourl = 'auth_showlist';
					var tid = 'tid_auth_list';
					var tab_title = '权限管理';
					parent.son_parent_fun(gourl, tid, tab_title);
				} else {
					parent.layer.msg(res.msg, {shade: 0.4, time: 1000});
				}
			}
		})
		return false;
	});
})

</script>