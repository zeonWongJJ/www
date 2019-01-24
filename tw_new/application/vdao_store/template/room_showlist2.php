<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>产品管理-房间管理-添加房间</title>
		<link rel="stylesheet" href="./static/style_default/style/common.css"/>
        <link rel="stylesheet" href="./static/style_default/style/header.css"/>
        <link rel="stylesheet" href="./static/style_default/style/productManage_room_addRoom.css"/>
        <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="./static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="./static/style_default/script/productManage_room_addRoom.js" type="text/javascript" charset="utf-8"></script>
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
        			<a href="javascript:;">产品管理</a>
        			<span>></span>
        			<a href="office_showlist">房间管理</a>
        			<span>></span>
        			<a href="room_showlist">添加房间</a>
        		</div>
	        	<!--面包屑导航结束-->
	        	<!--表格模块开始-->
	        	<div class="tableModule">
	        		<div class="addSearch">
	        			<!--<div class="addBox">
	        				<a href="javascript"><i>+</i>添加房间</a>
	        			</div>-->
	        			<div class="searchBox">
	        				<input type="text" name="keywords" class="int" placeholder=" 房间名称" />
	        				<button class="btn" onclick="room_search()"></button>
	        			</div>
	        		</div>
	        		<!--表格列表开始-->
	        		<div class="tableBox">
	        			<ul>
	        				<li class="thead">
	        					<span class="check"><a class="gapCheck" href="javascript:;"></a></span>
	        					<span>房间名称</span>
	        					<span>所属分类</span>
	        					<span>房间描述</span>
	        					<span>配备设备</span>
	        					<span>房间大小</span>
	        					<span>座位</span>
	        					<span>操作</span>
	        				</li>
	        				<?php foreach ($a_view_data as $key => $value): ?>
	        				<li class="row" id="<?php echo 'tr_' . $value['room_id']; ?>">
	        					<span class="check"><a class="gapCheck" value="<?php echo $value['room_id']; ?>" href="javascript:;"></a></span>
	        					<span><?php echo $value['room_name']; if ($value['type_cate'] == 1) { echo ' [会议室]'; } else { echo ' [餐厅]'; } ?></span>
	        					<span><?php echo $value['type_name']; ?></span>
	        					<span><?php echo $value['room_description']; ?></span>
	        					<span><?php echo substr($value['device'], 0, -3); ?></span>
	        					<span><?php echo $value['room_size']; ?>m<sup>2</sup></span>
	        					<span><?php echo $value['room_seat']; ?></span>
	        					<span>
	        						<a href="javascript:;" class="addRoom" onclick="office_add_one(<?php echo $value['room_id']; ?>)"></a>
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
        			<a href="javascript:;" class="chooseBtn gapCheck"><i></i>全选</a>
        			<a href="javascript:;" onclick="office_add_mony()" class="addBtn"><i></i>批量添加</a>
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
	        	<p class="p2">*<span>确定要添加这一部分房间到您门店吗？</span></p>
	        	<!--<p class="p3">*<span>删除后不可以恢复</span></p>-->
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">再看看</a>
	        	</div>
	        </div>
	        <!--删除部分房间提示-是否删除 结束-->
	        <!--删除单个提示框开始-->
	        <div class="delePart deleSingle">
	        	<p>重要提示</p>
	        	<p class="p2">*<span>确定要添加此房间到您门店吗？</span></p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">取消</a>
	        	</div>
	        </div>
	        <!--删除单个提示框结束-->
	</body>
</html>

<script>

// 单个添加房间
function office_add_one(room_id) {
	$(".deleSingle").show();
	$(".deleSingle .sure").unbind('click').click(function(event) {
		$.ajax({
			url: 'office_add',
			type: 'POST',
			dataType: 'json',
			data: {room_id: room_id, type: 1},
			success:function(data) {
				console.log(data);
				if (data.code==200) {
					alert('添加成功，您还可以继续添加');
				}
			}
		})
		$(".deleSingle").hide();
	});
	$(".deleSingle .think").click(function(event) {
		$(".deleSingle").hide();
	});
}

// 批量添加房间
function office_add_mony() {
	$(".batchDel").show();
	$(".batchDel .sure").click(function(event) {
		var room_ids = new Array();
		var i = 0;
		$(".row .greenCheck").each(function(index, el) {
			room_ids[i] = $(this).attr('value');
			i++;
		});
		if (room_ids.length > 0) {
			$.ajax({
				url: 'office_add',
				type: 'POST',
				dataType: 'json',
				data: {room_ids: room_ids, type: 2},
				success:function(data) {
					console.log(data);
					if (data.code==200) {
						alert(room_ids.length+'间房间添加成功，您还可以继续添加');
					}
				}
			})
		}
		$(".batchDel").hide();
	});
	$(".think,.close").click(function(event) {
		$(".batchDel").hide();
	});
}

// 搜索房间
function room_search() {
	var keywords = $("input[name='keywords']").val();
	if (keywords != '') {
		$.ajax({
			url: 'room_search',
			type: 'POST',
			dataType: 'json',
			data: {keywords: keywords},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					$(".tableBox li").not(':eq(0)').remove();
					var append_content = '';
					$.each(res.data, function(index, el) {
						append_content += '<li class="row" id="tr_'+el.room_id+'">';
						append_content += '<span class="check"><a class="gapCheck" value="'+el.room_id+'" href="javascript:;"></a></span>';
						append_content += '<span>'+el.room_name+'</span>';
						append_content += '<span>'+el.type_name+'</span>';
						append_content += '<span>'+el.room_description+'</span>';
						append_content += '<span>'+el.device.substr(0, el.device.length-1)+'</span>';
						append_content += '<span>'+el.room_size+'m<sup>2</sup></span>';
						append_content += '<span>'+el.room_seat+'</span>';
						append_content += '<span><a href="javascript:;" class="addRoom" onclick="office_add_one('+el.room_id+')"></a></span>';
						append_content += '</li>';
					});
					$('.tableBox').append(append_content);
				} else {
					alert('没有搜索到数据');
				}
			}
		})
	} else {
		alert('关键词不能为空');
	}
}

</script>
