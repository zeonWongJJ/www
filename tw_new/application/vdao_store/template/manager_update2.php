<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>权限管理-管理员列表-编辑管理员</title>
		<link rel="stylesheet" href="./static/style_default/style/common.css"/>
        <link rel="stylesheet" href="./static/style_default/style/header.css"/>
        <link rel="stylesheet" href="./static/style_default/style/authorization_conservator_edit.css"/>
        <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="./static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="./static/style_default/script/authorization_conservator_edit.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<!-- 头部 开始-->
        <?php echo $this->display('top'); ?>
        <!-- 头部结束 -->
        <div class="bottom clearfix">
        	<!-- 导航 开始-->
	        <?php echo $this->display('left'); ?>
	        <!-- 导航结束-->
	        <!--右边内容开始-->
	        <div class="rightSide">
	        	<!--面包屑导航开始-->
        		<div class="breadNav">
        			<a href="javascript:;">权限管理</a>
        			<span>></span>
        			<a href="manager_showlist">管理员列表</a>
        			<span>></span>
        			<a href="manager_update-<?php echo $a_view_data['detail']['manager_id']; ?>">编辑管理员</a>
        		</div>
	        	<!--面包屑导航结束-->
	        	<!--编辑管理员弹框开始-->
		        <div class="editBomb">
		        	<!--表单开始-->
		        	<div class="formBox">
		        		<form action="manager_update" method="post">
		        			<input type="hidden" name="manager_id" value="<?php echo $a_view_data['detail']['manager_id']; ?>">
		        			<input type="hidden" name="original_name" value="<?php echo $a_view_data['detail']['manager_name']; ?>">
							<input type="hidden" name="original_group" value="<?php echo $a_view_data['detail']['group_id']; ?>">
		        			<ul>
		        				<li>
		        					<span class="left">账户名</span>
		        					<div class="right">
		        						<input type="text" name="manager_name" class="input accountInt total" value="<?php echo $a_view_data['detail']['manager_name']; ?>" />
		        						<span class="green"><em></em><s class="wen">还可以输入<i>7</i>个汉字</s></span>
		        						<span class="red"><em></em><s class="wen">账户名不能为空</s></span>
		        					</div>
		        				</li>
		        				<li>
		        					<span class="left">姓名</span>
		        					<div class="right">
		        						<input type="text" name="manager_realname" class="input nameInt total" value="<?php echo $a_view_data['detail']['manager_realname']; ?>" />
		        						<span class="green"><em></em><s class="wen">还可以输入<i>7</i>个汉字</s></span>
		        						<span class="red"><em></em><s class="wen">姓名不能为空</s></span>
		        					</div>
		        				</li>
		        				<input type="hidden" name="manager_sex" value="<?php echo $a_view_data['detail']['manager_sex']; ?>">
		        				<li class="sex">
		        					<span class="left">性别</span>
		        					<div class="right">
		        						<span class="boy">
		        							<input type="radio" class="sexItn" name="sex" id="sex" <?php if ($a_view_data['detail']['manager_sex'] == 1) { echo 'checked="checked"'; } ?> ve='1' />
		        							<label for="sex" class="pattern ding1 <?php if ($a_view_data['detail']['manager_sex'] == 1) { echo 'choose'; } ?>">男</label>
		        							<input type="radio" class="sexItn" name="sex" id="sex2" <?php if ($a_view_data['detail']['manager_sex'] == 2) { echo 'checked="checked"'; } ?> ve='2' />
		        							<label for="sex2" class="pattern ding2 <?php if ($a_view_data['detail']['manager_sex'] == 2) { echo 'choose'; } ?>">女</label
		        						</span>
		        						<span class="green"><em></em></span>
		        						<span class="red"><em></em><s class="wen">请选择性别</s></span>
		        					</div>
		        				</li>
		        				<li>
		        					<span class="left">手机号码</span>
		        					<div class="right">
		        						<input type="text" name="manager_phone" class="input phoneInt total" value="<?php echo $a_view_data['detail']['manager_phone']; ?>" />
		        						<span class="green"><em></em></span>
		        						<span class="red red1"><em></em><s class="wen">手机号码不能为空</s></span>
		        						<span class="red red2"><em></em><s class="wen">手机号码输入有误</s></span>
		        					</div>
		        				</li>
		        				<li class="email">
		        					<span class="left">邮箱</span>
		        					<div class="right">
		        						<input type="text" name="manager_email" class="input email total" value="<?php echo $a_view_data['detail']['manager_email']; ?>"/>
		        						<span class="green"><em></em></span>
		        						<span class="red red1"><em></em><s class="wen">邮箱不能为空</s></span>
		        						<span class="red red2"><em></em><s class="wen">邮箱格式有误</s></span>
		        					</div>
		        				</li>
		        				<li>
		        					<span class="left">密码</span>
		        					<div class="right">
		        						<input type="text" name="manager_password" class="input password passInt total" placeholder="不填将使用原来的密码" />
		        						<span class="green"><em></em></span>
		        						<span class="red"><em></em><s class="wen">密码不能为空</s></span>
		        					</div>
		        				</li>
		        				<li>
		        					<span class="left">确认密码</span>
		        					<div class="right">
		        						<input type="text" name="manager_password2" class="input password againInt total" placeholder="不填将使用原来的密码" />
		        						<span class="green"><em></em></span>
		        						<span class="red red1"><em></em><s class="wen"> 请再次输入密码</s></span>
		        						<span class="red red2"><em></em><s class="wen">两次密码不一样</s></span>
		        					</div>
		        				</li>
		        				<input type="hidden" name="group_id" value="<?php echo $a_view_data['detail']['group_id']; ?>">
		        				<li class="roleLi clearfix">
		        					<span class="left">所属角色</span>
		        					<div class="right roleRight">
		        						<div class="role">
		        							<?php foreach ($a_view_data['group'] as $key => $value): ?>
		        							<a href="javascript:;" <?php if ($a_view_data['detail']['group_id'] == $value['group_id']) { echo 'class="gou"'; } ?> value="<?php echo $value['group_id']; ?>"><b></b><?php echo $value['group_name']; ?></a>
		        							<?php endforeach ?>
		        						</div>
		        						<span class="green"><em></em></span>
		        						<span class="red"><em></em><s class="wen"> 请选择管理员角色</s></span>
		        					</div>
		        				</li>
		        			</ul>
		        			<div class="sureBox">
		        				<a href="javascript:;">保存</a>
		        			</div>
		        		</form>
		        	</div>
		        	<!--表单结束-->
		        </div>
		        <!--编辑管理员弹框结束-->
	        </div>
	        <!--右边内容结束-->
	</body>
</html>
