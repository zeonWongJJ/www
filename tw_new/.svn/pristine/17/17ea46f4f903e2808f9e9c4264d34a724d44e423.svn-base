<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>权限管理-角色列表-编辑角色</title>
		<link rel="stylesheet" href="./static/style_default/style/common.css"/>
        <link rel="stylesheet" href="./static/style_default/style/header.css"/>
        <link rel="stylesheet" href="./static/style_default/style/authorization_roleList_edit.css"/>
        <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="./static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="./static/style_default/script/authorization_roleList_edit.js" type="text/javascript" charset="utf-8"></script>
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
        			<a href="group_showlist">角色列表</a>
        			<span>></span>
        			<a href="group_update-<?php echo $a_view_data['detail']['group_id']; ?>">编辑角色</a>
        		</div>
	        	<!--面包屑导航结束-->
	        	<!--编辑管理员开始-->
		        <div class="editBomb">
		        	<!--表单开始-->
		        	<div class="formBox">
		        		<form action="<?php echo $this->router->url('group_update'); ?>" method='post'>
		        			<input type="hidden" name="group_id" value="<?php echo $a_view_data['detail']['group_id']; ?>">
		        			<ul>
		        				<li>
		        					<span class="left">角色名称</span>
		        					<div class="right">
		        						<input type="text" class="input roleInt"name="group_name" value="<?php echo $a_view_data['detail']['group_name']; ?>" />
		        						<span class="green"><em></em><s class="wen">还可以输入<i>7</i>个汉字</s></span>
		        						<span class="red"><em></em><s class="wen">账户名不能为空</s></span>
		        					</div>
		        				</li>
		        				<input type="hidden" name="group_state" value="<?php echo $a_view_data['detail']['group_state']; ?>">
		        				<li class="sex">
		        					<span class="left">是否启用</span>
		        					<div class="right">
		        						<span class="boy">
		        							<input type="radio" class="sexItn" name="sex" id="sex" <?php if ($a_view_data['detail']['group_state'] == 1) { echo 'checked="checked"'; } ?> ve='1' />
		        							<label for="sex" class="pattern ding1 <?php if ($a_view_data['detail']['group_state'] == 1) { echo 'choose'; } ?>">是</label>
		        							<input type="radio" class="sexItn" name="sex" id="sex2" <?php if ($a_view_data['detail']['group_state'] == 0) { echo 'checked="checked"'; } ?> ve='0' />
		        							<label for="sex2" class="pattern ding2 <?php if ($a_view_data['detail']['group_state'] == 0) { echo 'choose'; } ?>">否</label
		        						</span>
		        						<span class="green"><em></em></span>
		        						<span class="red"><em></em><s class="wen">请选择操作权限</s></span>
		        					</div>
		        				</li>
		        				<li class="describe">
		        					<span class="left">角色描述</span>
		        					<div class="right">
		        						<textarea name="group_description" class="input txt"><?php echo $a_view_data['detail']['group_description']; ?></textarea>
		        						<span class="green"><em></em></span>
		        						<span class="red"><em></em><s class="wen">描述不能为空</s></span>
		        					</div>
		        				</li>
		        				<input type="hidden" name="group_auth" value="<?php echo $a_view_data['detail']['auth_ids']; ?>">
		        				<li class="choiceRole clearfix">
		        					<span class="left">分配权限</span>
		        					<div class="right">
		        						<!--用户管理选择开始-->
		        						<div class="roleWrap">
		        							<div class="roleBox">
			        							<div class="roleList clearfix">
			        								<!-- <p class="rLeft">用户管理</p> -->
			        								<div class="rRight" style="width:380px;">
		        										<?php foreach ($a_view_data['auth'] as $key => $value): ?>
			        									<a href="javascript:;" value="<?php echo $value['auth_id']; ?>" <?php if (in_array($value['auth_id'], $a_view_data['present'])) { echo 'class="gou"'; } ?>><i></i><?php echo $value['auth_name']; ?></a>
		        										<?php endforeach ?>
			        								</div>
			        							</div>
			        						</div>
		        						</div>
		        						<!--用户管理选择结束-->
		        						<span class="green"><em></em></span>
		        						<span class="red"><em></em><s class="wen">请至少选择一个权限</s></span>
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
		        <!--编辑管理员结束-->
	        </div>
	        <!--右边内容结束-->





	</body>
</html>
