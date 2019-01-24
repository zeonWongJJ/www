<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加管理员</title>
  <link rel="stylesheet" href="static/style_default/plugin/layui/css/layui.css">
  <script src="static/style_default/plugin/layui/layui.js"></script>
  <script src="static/style_default/script/jquery-3.2.1.min.js"></script>
  <script src="static/style_default/script/jquery.nicescroll.js"></script>
  <script src="static/style_default/script/iframe_nicescroll.js"></script>
	<style>
	#userpic {
	  width: 50px;
	  height: 50px;
	  border-radius: 50%;
	  margin-right: 20px;
	}
	</style>
</head>
<body>

<div style="margin-top:15px;">
<form class="layui-form">
  <div class="layui-form-item">
    <label class="layui-form-label">用户头像</label>
    <div class="layui-input-inline">
    	<?php if (!empty($a_view_data['admin']['admin_pic'])) { ?>
    	<img id="userpic" src="/<?php echo $a_view_data['admin']['admin_pic']; ?>" />
    	<?php } else { ?>
      	<img id="userpic" src="/upload/admin/default_userpic.png" />
    	<?php } ?>
    	<button type="button" class="layui-btn layui-btn-sm" id="choosepic">选择图片</button>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">用&nbsp;&nbsp;户&nbsp;&nbsp;名</label>
    <div class="layui-input-inline">
      <input type="text" name="admin_name" required lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input" value="<?php echo $a_view_data['admin']['admin_name']; ?>">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">用户密码</label>
    <div class="layui-input-inline">
      <input type="password" name="admin_password" placeholder="空白表示不修改" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">真实姓名</label>
    <div class="layui-input-inline">
      <input type="text" name="admin_realname" required lay-verify="required" placeholder="真实姓名" autocomplete="off" class="layui-input" value="<?php echo $a_view_data['admin']['admin_realname']; ?>">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">用户性别</label>
    <div class="layui-input-inline">
      <select name="admin_sex" lay-verify="required">
        <option value=""></option>
        <option value="1" <?php if ($a_view_data['admin']['admin_sex'] == 1) { echo 'selected'; } ?>>男</option>
        <option value="2" <?php if ($a_view_data['admin']['admin_sex'] == 2) { echo 'selected'; } ?>>女</option>
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">手机号码</label>
    <div class="layui-input-inline">
      <input type="text" name="admin_phone" placeholder="请输入手机号码" autocomplete="off" class="layui-input" value="<?php echo $a_view_data['admin']['admin_phone']; ?>" >
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">用户邮箱</label>
    <div class="layui-input-inline">
      <input type="text" name="admin_email" placeholder="请输入邮箱" autocomplete="off" class="layui-input"   value="<?php echo $a_view_data['admin']['admin_email']; ?>" >
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">所属角色</label>
    <div class="layui-input-inline">
      <select name="role_id" lay-verify="required">
        <option value=""></option>
        <?php foreach ($a_view_data['role'] as $key => $value): ?>
        <option value="<?php echo $value['role_id']; ?>" <?php if ($a_view_data['admin']['role_id'] == $value['role_id']) { echo 'selected'; } ?>><?php echo $value['role_name']; ?></option>
        <?php endforeach ?>
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">用户状态</label>
    <div class="layui-input-inline">
      <select name="admin_state" lay-verify="required">
        <option value=""></option>
        <option value="1" <?php if ($a_view_data['admin']['admin_state'] == 1) { echo 'selected'; } ?>>启用</option>
        <option value="2" <?php if ($a_view_data['admin']['admin_state'] == 2) { echo 'selected'; } ?>>禁用</option>
      </select>
    </div>
  </div>
  <input type="hidden" name="admin_pic" value="<?php echo $a_view_data['admin']['admin_pic']; ?>">
  <input type="hidden" name="admin_id" value="<?php echo $a_view_data['admin']['admin_id']; ?>">
  <div class="layui-form-item" style="padding-left:40px;">
      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置表单</button>
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
		// ajax提交表单
		$.ajax({
			url: 'admin_update',
			type: 'POST',
			dataType: 'json',
			data: data.field,
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					parent.layer.msg('保存成功', {shade: 0.4, time: 800});
					// 添加成功后关闭当前tab 切换到用户列表
					var gourl = 'admin_showlist';
					var tid = 'tid_admin_list';
					var tab_title = '管理员管理';
					parent.son_parent_fun(gourl, tid, tab_title);
				} else {
					parent.layer.msg(res.msg, {shade: 0.4, time: 1000});
				}
			}
		})
		return false;
	});
	// 普通图片上传 [上传头像]
	var uploadInst = upload.render({
		elem: '#choosepic'
		,url: 'admin_pic'
		,field: 'userfile'
		,before: function(obj){
		  //预读本地文件示例，不支持ie8
		  obj.preview(function(index, file, result){
		    $('#userpic').attr('src', result); //图片链接（base64）
		  });
		}
		,done: function(res){
		  if(res.code == 200){
		  	// 上传成功
		  	$("input[name='admin_pic']").val(res.data);
		    return parent.layer.msg('上传成功', {shade: 0.4, time: 600});
		  } else {
		  	// 上传失败
        	$('#userpic').attr('src', 'upload/admin/default_userpic.png');
		  	return parent.layer.msg('上传失败', {shade: 0.4, time: 600});
		  }
		}
		,error: function(){

		}
	});
})

</script>