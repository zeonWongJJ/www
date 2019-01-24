<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>权限管理-管理员列表</title>
		<link rel="stylesheet" href="./static/style_default/style/common.css"/>
        <link rel="stylesheet" href="./static/style_default/style/header.css"/>
        <link rel="stylesheet" href="./static/style_default/style/authorization_conservator.css"/>
        <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="./static/style_default/script/authorization_conservator.js" type="text/javascript" charset="utf-8"></script>
        <script src="./static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
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
        			<a href="javascript:;">管理员列表</a>
        		</div>
	        	<!--面包屑导航结束-->
	        	<!--表格模块开始-->
	        	<div class="tableModule">
	        		<div class="addSearch">
	        			<div class="addBox">
	        				<a href="javascript:;"><i>+</i>添加管理员</a>
	        			</div>
	        			<div class="searchBox">
	        				<input type="text" name="keywords" class="int" placeholder="管理员账号/姓名" />
	        				<button class="btn" onclick="manager_search()"></button>
	        			</div>
	        		</div>
	        		<!--表格列表开始-->
	        		<div class="tableBox">
	        			<ul>
	        				<li class="thead">
	        					<span class="check"><a class="gapCheck" href="javascript:;"></a></span>
	        					<span>账号</span>
	        					<span>姓名</span>
	        					<span>性别</span>
	        					<span>管理员角色</span>
	        					<span>手机号码</span>
	        					<span>邮箱</span>
	        					<span>添加时间</span>
	        					<span>暂停/启用</span>
	        					<span>操作</span>
	        				</li>
	        				<?php foreach ($a_view_data['manager'] as $key => $value): ?>
	        				<li class="row" id="<?php echo 'tr_'.$value['manager_id']; ?>">
	        					<span class="check"><a class="gapCheck" value="<?php echo $value['manager_id']; ?>" href="javascript:;"></a></span>
	        					<span><?php echo $value['manager_name']; ?></span>
	        					<span><?php echo $value['manager_realname']; ?></span>
	        					<span><?php if($value['manager_sex'] == 1){ echo '男'; } else { echo '女'; } ?></span>
	        					<span><?php echo $value['group_name']; ?></span>
	        					<span><?php echo $value['manager_phone']; ?></span>
	        					<span><?php echo $value['manager_email']; ?></span>
	        					<span><?php echo date('Y-m-d', $value['register_time']); ?></span>
	        					<span id="<?php echo 'switch_'.$value['manager_id']; ?>" onclick="manager_switch(<?php echo $value['manager_id']; ?>)" value="<?php echo $value['manager_state']; ?>">
								<?php if($value['manager_state'] == 1){
									echo '<img src="./static/style_default/images/pro_10.png" />';
								} else {
									echo '<img src="./static/style_default/images/pro_33.png" />';
								} ?>
	        					</span>
	        					<span>
	        						<a href="javascript:;" class="delete" onclick="manager_delete_one(<?php echo $value['manager_id']; ?>)"></a>
	        						<a href="manager_update-<?php echo $value['manager_id']; ?>" class="edit"></a>
	        					</span>
	        				</li>
	        				<?php endforeach ?>
	        			</ul>

	        		</div>
	        		<!--表格列表结束-->
	        	</div>
	        	<!--表格模块结束-->
	        	<!--全选开始-->
        		<div class="controlBox">
        			<a href="javascript:;" class="gapCheck"><i></i>全选</a>
        			<a href="javascript:;" class="deleBtn" onclick="manager_delete_mony()"><i></i>删除</a>
        			<a href="javascript:;" class="stopBtn" onclick="manager_switch_mony()"><i></i>暂用</a>
        		</div>
        		<!--全选结束-->
	        </div>
	        <!--右边内容结束-->
	        <!--遮罩开始-->
	        <div class="shade"></div>
	        <!--遮罩结束-->
	        <!--删除部分房间提示-是否删除开始-->
	        <div class="delePart batchDel">
	        	<a href="javascript:;" class="close"></a>
	        	<p>重要提示</p>
	        	<p>*确定要删除这一部分管理员吗？</p>
	        	<p>*删除后不可以恢复</p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">再看看</a>
	        	</div>
	        </div>
	        <!--删除部分房间提示-是否删除 结束-->
	        <!--删除单个提示框开始-->
	        <div class="delePart deleSingle">
	        	<p>重要提示</p>
	        	<p>*确定要删除这个管理员吗？</p>
	        	<p>*删除后不可以恢复</p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">取消</a>
	        	</div>
	        </div>
	        <!--删除单个提示框结束-->
	        <!--编辑管理员弹框开始-->
	        <div class="editBomb">
	        	<div class="h2">
	        		<span class="title">添加管理员账号</span>
	        		<a href="javascript:;" class="close"></a>
	        	</div>
	        	<!--表单开始-->
	        	<div class="formBox">
	        		<form id="add_form" action="<?php echo $this->router->url('manager_add'); ?>" method="post">
	        			<ul>
	        				<li>
	        					<span class="left">账户名</span>
	        					<div class="right">
	        						<input type="text" class="input accountInt total" name="manager_name" />
	        						<span class="green"><em></em><s class="wen">还可以输入<i>7</i>个汉字</s></span>
	        						<span class="red"><em></em><s class="wen">账户名不能为空</s></span>
	        					</div>
	        				</li>
	        				<li>
	        					<span class="left">姓名</span>
	        					<div class="right">
	        						<input type="text" class="input nameInt total" name="manager_realname" />
	        						<span class="green"><em></em><s class="wen">还可以输入<i>7</i>个汉字</s></span>
	        						<span class="red"><em></em><s class="wen">姓名不能为空</s></span>
	        					</div>
	        				</li>
	        				<input type="hidden" name="manager_sex" value="" />
	        				<li class="sex">
	        					<span class="left">性别</span>
	        					<div class="right">
	        						<span class="boy">
	        							<input type="radio" class="sexItn" name="sex" id="sex" value="1" />
	        							<label for="sex" class="pattern ding1">男</label>
	        							<input type="radio" class="sexItn" name="sex" id="sex2" value="2" />
	        							<label for="sex2" class="pattern ding2">女</label>
	        						</span>
	        						<span class="green"><em></em></span>
	        						<span class="red"><em></em><s class="wen">请选择性别</s></span>
	        					</div>
	        				</li>
	        				<li>
	        					<span class="left">手机号码</span>
	        					<div class="right">
	        						<input type="text" class="input phoneInt total" name="manager_phone" />
	        						<span class="green"><em></em></span>
	        						<span class="red red1"><em></em><s class="wen">手机号码不能为空</s></span>
	        						<span class="red red2"><em></em><s class="wen">手机号码输入有误</s></span>
	        					</div>
	        				</li>
	        				<li class="email">
	        					<span class="left">邮箱</span>
	        					<div class="right">
	        						<input type="text" class="input email total" name="manager_email" />
	        						<span class="green"><em></em></span>
	        						<span class="red red1"><em></em><s class="wen">邮箱不能为空</s></span>
	        						<span class="red red2"><em></em><s class="wen">邮箱格式有误</s></span>
	        					</div>
	        				</li>
	        				<li>
	        					<span class="left">密码</span>
	        					<div class="right">
	        						<input type="password" class="input password passInt total" name="manager_password" />
	        						<span class="green"><em></em></span>
	        						<span class="red"><em></em><s class="wen">密码不能为空</s></span>
	        					</div>
	        				</li>
	        				<li>
	        					<span class="left">确认密码</span>
	        					<div class="right">
	        						<input type="password" class="input password againInt total" name="manager_password2" />
	        						<span class="green"><em></em></span>
	        						<span class="red red1"><em></em><s class="wen"> 请再次输入密码</s></span>
	        						<span class="red red2"><em></em><s class="wen">两次密码不一样</s></span>
	        					</div>
	        				</li>
	        				<input type="hidden" name="group_id" value='' />
	        				<li>
	        					<span class="left">所属角色</span>
	        					<div class="right roleRight">
	        						<div class="role">
	        							<?php foreach ($a_view_data['group'] as $key => $value): ?>
	        								<a value="<?php echo $value['group_id']; ?>" href="javascript:;"><b></b><?php echo $value['group_name']; ?></a>
	        							<?php endforeach ?>
	        						</div>
	        						<span class="green"><em></em></span>
	        						<span class="red"><em></em><s class="wen"> 请选择管理员角色</s></span>
	        					</div>
	        				</li>
	        			</ul>
	        			<div class="sureBox">
	        				<a href="javascript:;">确定</a>
	        			</div>
	        		</form>
	        	</div>
	        	<!--表单结束-->
	        </div>
	        <!--编辑管理员弹框结束-->
	</body>
</html>


<script>

function manager_delete_one(manager_id) {
 	var _this = $(this);
 	$('.deleSingle').show();
 	// 确定按钮
 	$('.deleSingle .btnBox .sure').click(function(){
		$.ajax({
			url: '<?php echo $this->router->url('manager_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {manager_id: manager_id, type: 1},
			success: function(data){
				console.log(data);
				if (data.code==200) {
					$('#tr_'+manager_id).remove();
					$('.deleSingle').hide();
				}
			}
		})
 	})
 	//取消按钮
 	$('.deleSingle .btnBox .think').click(function(){
 		$('.deleSingle').hide();
 	})
}

// 批量删除
function manager_delete_mony() {
 	var _this = $(this);
 	$('.deleSingle').show();
 	// 确定按钮
 	$('.deleSingle .btnBox .sure').click(function(){
		var manager_ids = new Array();
		var i = 0;
		$(".row .greenCheck").each(function(index, el) {
			manager_ids[i] = $(this).attr('value');
			i++
		});
		$.ajax({
			url: '<?php echo $this->router->url('manager_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {manager_ids: manager_ids, type: 2},
			success: function(res) {
				console.log(res);
				if (res.code==200) {
					for (var i = 0; i<manager_ids.length; i++) {
						$('#tr_'+manager_ids[i]).remove();
					}
					$('.deleSingle').hide();
				}
			}
		})
 	})
 	//取消按钮
 	$('.deleSingle .btnBox .think').click(function(){
 		$('.deleSingle').hide();
 	})
}

// 启用暂用
function manager_switch(manager_id) {
	var manager_state = $('#switch_'+manager_id).attr('value');
	$.ajax({
		url: '<?php echo $this->router->url('manager_switch'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {manager_id: manager_id},
		success : function(data) {
			console.log(data);
			if (data.code==200) {
				if (manager_state == 0) {
					 $('#switch_'+manager_id).html('<img src="./static/style_default/images/pro_10.png" />');
					 $('#switch_'+manager_id).attr('value', '1');
				} else {
					 $('#switch_'+manager_id).html('<img src="./static/style_default/images/pro_33.png" />');
					 $('#switch_'+manager_id).attr('value', '0');
				}
			}
		}
	})
}

// 批量暂用
function manager_switch_mony() {
	$('.row .greenCheck').each(function(index, el) {
		manager_switch($(this).attr('value'));
	});
}

// 搜索管理员
function manager_search() {
	var keywords = $("input[name='keywords']").val();
	if (keywords != '') {
		$.ajax({
			url: '<?php echo $this->router->url('manager_search'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {keywords: keywords},
			success: function(res){
				console.log(res);
				if (res.code == 200) {
					$(".tableBox li").not(':eq(0)').remove();
					var append_content = '';
					$.each(res.data, function(index, el) {
						append_content += '<li class="row" id="tr_'+el.manager_id+'">';
						append_content += '<span class="check"><a class="gapCheck" value="'+el.manager_id+'" href="javascript:;"></a></span>';
						append_content += '<span>'+el.manager_name+'</span>';
						append_content += '<span>'+el.manager_realname+'</span>';
						append_content += '<span>'+el.manager_sex+'</span>';
						append_content += '<span>'+el.group_name+'</span>';
						append_content += '<span>'+el.manager_phone+'</span>';
						append_content += '<span>'+el.manager_email+'</span>';
						append_content += '<span>'+el.register_time+'</span>';
						append_content += '<span id="switch_'+el.manager_id+'" onclick="manager_switch('+el.manager_id+')" value="'+el.manager_state+'">';
						if (el.manager_state == 1) {
							append_content += '<img src="./static/style_default/images/pro_10.png" />';
						} else {
							append_content += '<img src="./static/style_default/images/pro_33.png" />';
						}
						append_content += '</span>';
						append_content += '<span><a href="javascript:;" class="delete" onclick="manager_delete_one('+el.manager_id+')"></a><a href="manager_update-'+el.manager_id+'" class="edit"></a></span>';
						append_content += '</li>';
					});
					$('.tableBox').append(append_content);
				}
			}
		})
	}
}

</script>
