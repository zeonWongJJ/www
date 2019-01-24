<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>权限管理-角色列表</title>
		<link rel="stylesheet" href="./static/style_default/style/common.css"/>
        <link rel="stylesheet" href="./static/style_default/style/header.css"/>
        <link rel="stylesheet" href="./static/style_default/style/authorization_roleList.css"/>
        <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="./static/style_default/script/authorization_roleList.js" type="text/javascript" charset="utf-8"></script>
        <script src="./static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<!-- 头部 开始-->
		<?php echo $this->display('top'); ?>
        <!-- 头部结束 -->
        <div class="bottom clearfix">
        	<!-- 导航 开始-->
			<?php echo $this->display('left'); ?>
	        <!-- 导航 结束-->
	        <!--右边内容开始-->
	        <div class="rightSide">
	        	<!--面包屑导航开始-->
        		<div class="breadNav">
        			<a href="javascript:;">权限管理</a>
        			<span>></span>
        			<a href="javascript:;">角色列表</a>
        		</div>
	        	<!--面包屑导航结束-->
	        	<!--表格模块开始-->
	        	<div class="tableModule">
	        		<div class="addSearch">
	        			<div class="addBox">
	        				<a href="javascript:;"><i>+</i>添加角色</a>
	        			</div>
	        			<div class="searchBox">
	        				<input type="text" name="keywords" class="int" placeholder="角色名称" />
	        				<button class="btn" onclick="group_search()"></button>
	        			</div>
	        		</div>
	        		<!--表格列表开始-->
	        		<div class="tableBox">
	        			<ul>
	        				<li class="thead">
	        					<span class="check"><a class="gapCheck" href="javascript:;"></a></span>
	        					<span>角色名称</span>
	        					<span>角色备注</span>
	        					<span>添加时间</span>
	        					<span>暂停/启用</span>
	        					<span>操作</span>
	        				</li>
	        				<?php foreach ($a_view_data['group'] as $key => $value): ?>
	        				<li class="row" id="<?php echo 'tr_'.$value['group_id']; ?>">
	        					<span class="check a"><a class="gapCheck" value="<?php echo $value['group_id']; ?>" href="javascript:;"></a></span>
	        					<span><?php echo $value['group_name']; ?></span>
	        					<span><?php echo $value['group_description']; ?></span>
	        					<span><?php echo date('Y-m-d', $value['add_time']); ?></span>
	        					<span id="<?php echo 'switch_'.$value['group_id']; ?>" onclick="group_switch(<?php echo $value['group_id']; ?>)" value="<?php echo $value['group_state']; ?>">
								<?php if($value['group_state'] == 1){
									echo '<img src="./static/style_default/images/pro_10.png" />';
								} else {
									echo '<img src="./static/style_default/images/pro_33.png" />';
								} ?>
	        					</span>
	        					<span>
	        						<a href="javascript:;" class="delete" onclick="group_delete_one(<?php echo $value['group_id']; ?>)"></a>
	        						<a href="group_update-<?php echo $value['group_id']; ?>" class="edit"></a>
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
        			<a href="javascript:;" class="deleBtn" onclick="group_delete_mony()"><i></i>删除</a>
        			<a href="javascript:;" class="stopBtn" onclick="group_switch_mony()"><i></i>暂用</a>
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
	        	<p class="p2">*<span>确认要暂用此部分角色员吗？</span></p>
	        	<p class="p3">*<span>暂用后，此部分角色下的管理员账号将被停用</span></p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">再看看</a>
	        	</div>
	        </div>
	        <!--删除部分房间提示-是否删除 结束-->
	        <!--删除单个提示框开始-->
	        <div class="delePart deleSingle">
	        	<p>重要提示</p>
	        	<p class="p2">*<span>确定要删除次管理员吗？</span></p>
	        	<p class="p3">*<span>删除后不可以恢复</span></p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">取消</a>
	        	</div>
	        </div>
	        <!--删除单个提示框结束-->
	        <!--编辑管理员弹框开始-->
	        <div class="editBomb">
	        	<div class="h2">
	        		<span class="title">编辑角色</span>
	        		<a href="javascript:;" class="close"></a>
	        	</div>
	        	<!--表单开始-->
	        	<div class="formBox">
	        		<form id="groupadd_form" action="<?php echo $this->router->url('group_add'); ?>" method="post">
	        			<ul>
	        				<li>
	        					<span class="left">角色名称</span>
	        					<div class="right">
	        						<input type="text" class="input roleInt" name="group_name" />
	        						<span class="green"><em></em><s class="wen">还可以输入<i>7</i>个汉字</s></span>
	        						<span class="red"><em></em><s class="wen">账户名不能为空</s></span>
	        					</div>
	        				</li>
	        				<input type="hidden" name="group_state" value=''>
	        				<li class="sex">
	        					<span class="left">是否启用</span>
	        					<div class="right">
	        						<span class="boy">
	        							<input type="radio" class="sexItn" name="sex" id="sex" value="1" />
	        							<label for="sex" class="pattern ding1">是</label>
	        							<input type="radio" class="sexItn" name="sex" id="sex2" value="0" />
	        							<label for="sex2" class="pattern ding2">否</label
	        						</span>
	        						<span class="green"><em></em></span>
	        						<span class="red"><em></em><s class="wen">请选择是否启用</s></span>
	        					</div>
	        				</li>
	        				<li class="describe">
	        					<span class="left">角色描述</span>
	        					<div class="right">
	        						<textarea class="input txt" name="group_description"></textarea>
	        						<span class="green"><em></em></span>
	        						<span class="red"><em></em><s class="wen">描述不能为空</s></span>
	        					</div>
	        				</li>
	        				<input type="hidden" name="group_auth" value=''>
	        				<li class="choiceRole clearfix">
	        					<span class="left">操作权限</span>
	        					<div class="right">
	        						<!--用户管理选择开始-->
	        						<div class="roleWrap">
	        							<div class="roleBox">
		        							<div class="roleList clearfix">
		        								<!-- <p class="rLeft">用户管理</p> -->
		        								<div class="rRight">
	        										<?php foreach ($a_view_data['auth'] as $key => $value): ?>
		        									<a href="javascript:;" value="<?php echo $value['auth_id']; ?>"><i></i><?php echo $value['auth_name']; ?></a>
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

// 启用暂用
function group_switch(group_id) {
	var group_state = $('#switch_'+group_id).attr('value');
	$.ajax({
		url: '<?php echo $this->router->url('group_switch'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {group_id: group_id},
		success : function(data) {
			console.log(data);
			if (data.code==200) {
				if (group_state == 0) {
					 $('#switch_'+group_id).html('<img src="./static/style_default/images/pro_10.png" />');
					 $('#switch_'+group_id).attr('value', '1');
				} else {
					 $('#switch_'+group_id).html('<img src="./static/style_default/images/pro_33.png" />');
					 $('#switch_'+group_id).attr('value', '0');
				}
			}
		}
	})
}

// 批量暂用
function group_switch_mony() {
	$('.row .greenCheck').each(function(index, el) {
		group_switch($(this).attr('value'));
	});
}

// 单个删除
function group_delete_one(group_id) {
	 //单个删除
	 $('body').on('click','.tableBox .row .delete',function(){
	 	var _this = $(this);
	 	$('.deleSingle').show();
	 	$('.deleSingle .p2 span').text('确定要删除此角色吗');
	 	$('.deleSingle .p3 span').text('若该角色下有管理员，需清空该角色下所有管理员方可删除');
	 	// 确定按钮
	 	$('.deleSingle .btnBox .sure').click(function(){
			$.ajax({
				url: '<?php echo $this->router->url('group_delete'); ?>',
				type: 'POST',
				dataType: 'json',
				data: {group_id: group_id, type: 1},
				success: function(data){
					console.log(data);
					if (data.code==200) {
						$('#tr_'+group_id).remove();
						$('.deleSingle').hide();
					}
				}
			})
	 	})
	 	//取消按钮
	 	$('.deleSingle .btnBox .think').click(function(){
	 		$('.deleSingle').hide();
	 	})
	 })
}

// 批量删除
function group_delete_mony() {
 	var _this = $(this);
 	$('.deleSingle').show();
 	$('.deleSingle .p2 span').text('确定要删除此角色吗');
 	$('.deleSingle .p3 span').text('若该角色下有管理员，需清空该角色下所有管理员方可删除');
 	// 确定按钮
 	$('.deleSingle .btnBox .sure').click(function(){
		var group_ids = new Array();
		var i = 0;
		$(".row .greenCheck").each(function(index, el) {
			group_ids[i] = $(this).attr('value');
			i++
		});
		$.ajax({
			url: '<?php echo $this->router->url('group_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {group_ids: group_ids, type: 2},
			success: function(res) {
				console.log(res);
				if (res.code==200) {
					for (var i = 0; i<(res.data).length; i++) {
						$('#tr_'+res.data[i]).remove();
					}
				}
			}
		})
		$('.deleSingle').hide();
 	})
 	//取消按钮
 	$('.deleSingle .btnBox .think').click(function(){
 		$('.deleSingle').hide();
 	})
}

// 搜索角色
function group_search() {
	var keywords = $("input[name='keywords']").val();
	if (keywords != '') {
		$.ajax({
			url: '<?php echo $this->router->url('group_search'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {keywords: keywords},
			success: function(res){
				console.log(res);
				if (res.code == 200) {
					$(".tableBox li").not(':eq(0)').remove();
					var append_content = '';
					$.each(res.data, function(index, el) {
						append_content += '<li class="row" id="tr_'+el.group_id+'">';
						append_content += '<span class="check a"><a class="gapCheck" value="'+el.group_id+'" href="javascript:;"></a></span>';
						append_content += '<span>'+el.group_name+'</span>';
						append_content += '<span>'+el.group_description+'</span>';
						append_content += '<span>'+el.add_time+'</span>';
						append_content += '<span id="switch_'+el.group_id+'" onclick="group_switch('+el.group_id+')" value="'+el.group_state+'">';
						if (el.group_state == 1) {
							append_content += '<img src="./static/style_default/images/pro_10.png" />';
						} else {
							append_content += '<img src="./static/style_default/images/pro_33.png" />';
						}
						append_content += '</span>';
						append_content += '<span><a href="javascript:;" class="delete" onclick="group_delete_one('+el.group_id+')"></a><a href="group_update-'+el.group_id+'" class="edit"></a></span>';
					});
					$('.tableBox').append(append_content);
				}
			}
		})
	}
}

</script>
