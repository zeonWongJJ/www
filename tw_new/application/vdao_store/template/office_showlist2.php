<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>产品管理-房间管理</title>
		<link rel="stylesheet" href="./static/style_default/style/common.css"/>
        <link rel="stylesheet" href="./static/style_default/style/header.css"/>
        <link rel="stylesheet" href="./static/style_default/style/productManage_room.css"/>
        <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="./static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="./static/style_default/script/productManage_room.js" type="text/javascript" charset="utf-8"></script>
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
        			<a href="javascript:;">产品管理</a><span>></span><a href="javascript:;">会议管理</a>
        			<a href="javascript:;" class="searchnav"></a>
        		</div>
	        	<!--面包屑导航结束-->
	        	<!--表格模块开始-->
	        	<div class="tableModule">
	        		<div class="addSearch">
	        			<div class="addBox">
	        				<a href="<?php echo $this->router->url('room_showlist'); ?>"><i>+</i>添加房间</a>
	        			</div>
	        			<div class="searchBox">
	        				<input type="text" name="keywords" class="int" placeholder=" 房间名称" />
	        				<button class="btn" onclick="office_search()"></button>
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
	        					<span>暂停/启用</span>
	        					<span>价格/h</span>
	        					<span>操作</span>
	        				</li>
	        				<li class="roomTip" style="display: none;"><a href="javascript:;">没有房间，请添加房间</a></li>
	        				<?php foreach ($a_view_data as $key => $value): ?>
	        				<li class="row" id="<?php echo 'tr_' . $value['office_id']; ?>">
	        					<span class="check"><a class="gapCheck" value="<?php echo $value['office_id']; ?>" href="javascript:;"></a></span>
	        					<span><?php echo $value['room_name']; if ($value['type_cate'] == 1) { echo ' [会议室]'; } else { echo ' [餐厅]'; } ?></span>
	        					<span><?php echo $value['type_name']; ?></span>
	        					<span><?php echo $value['room_description']; ?></span>
	        					<span><?php echo substr($value['device'], 0, -3); ?></span>
	        					<span><?php echo $value['room_size']; ?>m<sup>2</sup></span>
	        					<span><?php echo $value['room_seat']; ?></span>
	        					<span id="<?php echo 'switch_'.$value['office_id']; ?>" onclick="office_switch(<?php echo $value['office_id']; ?>)" value="<?php echo $value['office_state']; ?>">
								<?php if($value['office_state'] == 1){
									echo '<img src="./static/style_default/images/pro_10.png" />';
								} else {
									echo '<img src="./static/style_default/images/pro_33.png" />';
								} ?>
	        					</span>
	        					<span id="price_<?php echo $value['office_id']; ?>"><?php echo $value['office_price']; ?></span>
	        					<span>
	        						<a href="javascript:;" class="delete" onclick="office_delete_one(<?php echo $value['office_id']; ?>)"></a>
	        						<a onclick="change_price(<?php echo $value['office_id']; ?>)" class="entry"></a>
	        						<?php if ($value['type_cate'] != 1) { ?>
	        						<a href="<?php echo $this->router->url('office_plan',['id'=>$value['office_id']]); ?>" class="edit"></a>
	        						<?php } ?>
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
        			<a href="javascript:;" class="deleBtn" onclick="office_delete_mony()"><i></i>删除</a>
        			<a onclick="office_switch_mony()" href="javascript:;" class="stopBtn"><i></i>暂用</a>
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
	        	<p class="p2">*<span>确定要删除这一部分房间吗？</span></p>
	        	<p class="p3">*<span>删除后不可以恢复</span></p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">再看看</a>
	        	</div>
	        </div>
	        <!--删除部分房间提示-是否删除 结束-->
	        <!--删除单个提示框开始-->
	        <div class="delePart deleSingle">
	        	<p>重要提示</p>
	        	<p class="p2">*<span>确定要删除这一部分房间吗？</span></p>
	        	<p class="p3">*<span>删除后不可以恢复</span></p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">取消</a>
	        	</div>
	        </div>
	        <!--删除单个提示框结束-->

	        <!-- 弹出输入框 -->
	        <div class="popEntry" style="display:none">
	        	<p>
	        		<span>价格</span>
	        		<img src="./static/style_default/images/pro_19.png" alt="" />
	        	</p>
<!-- 	        	<input type="text" id="entry" placeholder="请输入价格" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/> -->
	        	<input type="text" id="entry" placeholder="请输入价格" />
	        	<a class="popSure">确定</a>
	        </div>
	        <!-- 弹出输入框 -->
	</body>
</html>

<script>

	$(".popEntry").hide();
	//让指定的DIV始终显示在屏幕正中间
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/2;
        var left = ($(window).width() - divName.width())/2;
        var scrollTop = $(document).scrollTop();
        var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop,'left':left+scrollLeft });
    }

    setDivCenter($(".popEntry"));

  //   $(".entry").click(function(){
		// $(".popEntry").show();
  //   });

    $(".popEntry>p>img").click(function(){
    	$(".popEntry").hide();
    });
    // $("a.popSure").click(function(){
    // 	$(".popEntry").hide();
    // });


function change_price(office_id) {
	var thisprice = $('#price_'+office_id).html();
	$('#entry').val(thisprice);
	$(".popEntry").show();
    $("a.popSure").click(function(){
    	var new_price = $('#entry').val();
    	$.ajax({
    		url: 'office_updateprice',
    		type: 'POST',
    		dataType: 'json',
    		data: {office_id: office_id, new_price: new_price},
    		success: function (res) {
    			console.log(res);
    			if (res.code == 200) {
    				$('#price_'+office_id).html(new_price);
    			}
    		}
    	})
    	$(".popEntry").hide();
    });
}


// 启用停用办公室
function office_switch(office_id) {
	var office_state = $('#switch_'+office_id).attr('value');
	$.ajax({
		url: '<?php echo $this->router->url('office_switch'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {office_id: office_id},
		success : function(data) {
			console.log(data);
			if (data.code==200) {
				if (office_state == 0) {
					 $('#switch_'+office_id).html('<img src="./static/style_default/images/pro_10.png" />');
					 $('#switch_'+office_id).attr('value', '1');
				} else {
					 $('#switch_'+office_id).html('<img src="./static/style_default/images/pro_33.png" />');
					 $('#switch_'+office_id).attr('value', '0');
				}
			}
		}
	})
}

// 批量启用停用办公室
function office_switch_mony() {
	$('.row .greenCheck').each(function(index, el) {
		office_switch($(this).attr('value'));
	});
}

// 单个删除房间
function office_delete_one(office_id) {
 	$('.deleSingle').show();
 	$('.deleSingle .p2 span').text('确定要删除此房间吗');
 	$('.deleSingle .p3 span').text('删除后不可恢复，若该房间正在使用中则不允许删除');
 	// 确定按钮
 	$('.deleSingle .btnBox .sure').click(function(){
		$.ajax({
			url: '<?php echo $this->router->url('office_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {office_id: office_id, type: 1},
			success:function(data){
				console.log(data);
				if (data.code==200) {
					$('#tr_'+office_id).remove();
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

// 批量删除
function office_delete_mony() {
 	$('.deleSingle').show();
 	$('.deleSingle .p2 span').text('确定要删除此房间吗');
 	$('.deleSingle .p3 span').text('删除后不可恢复，若该房间正在使用中则不允许删除');
 	// 确定按钮
 	$('.deleSingle .btnBox .sure').click(function(){
		var office_ids = new Array();
		var i = 0;
		$('.row .greenCheck').each(function(index, el) {
			office_ids[i] = $(this).attr('value');
			i++;
		});
		if (office_ids.length > 0) {
			$.ajax({
				url: '<?php echo $this->router->url('office_delete'); ?>',
				type: 'POST',
				dataType: 'json',
				async: true,
				data: {office_ids: office_ids, type: 2},
				success: function(obj) {
					console.log(obj);
					if (obj.code==200) {
						for (var i=0; i<obj.data.length; i++) {
							$('#tr_'+obj.data[i]).remove();
						}
						alert(obj.data.length+'间办公室删除成功');
					} else {
						alert(obj.msg);
					}
				}
			})
		}
		$('.deleSingle').hide();
 	})
 	//取消按钮
 	$('.deleSingle .btnBox .think').click(function(){
 		$('.deleSingle').hide();
 	})
}

// 办公室搜索
function office_search() {
	var keywords = $("input[name='keywords']").val();
	if (keywords != '') {
		$.ajax({
			url: 'office_search',
			type: 'POST',
			dataType: 'json',
			data: {keywords: keywords},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					$(".searchnav").html('> 搜索办公室 [ '+keywords+' ]');
					$(".tableBox li").not(':eq(0)').remove();
					var append_content = '';
					$.each(res.data, function(index, el) {
						append_content += '<li class="row" id="tr_'+el.office_id+'">';
						append_content += '<span class="check"><a class="gapCheck" value="'+el.office_id+'" href="javascript:;"></a></span>';
						append_content += '<span>'+el.room_name+'</span>';
						append_content += '<span>'+el.type_name+'</span>';
						append_content += '<span>'+el.room_description+'</span>';
						append_content += '<span>'+el.device.substr(0, el.device.length-1)+'</span>';
						append_content += '<span>'+el.room_size+'m<sup>2</sup></span>';
						append_content += '<span>'+el.room_seat+'</span>';
						append_content += '<span id="switch_'+el.office_id+'" onclick="office_switch('+el.office_id+')" value="'+el.office_state+'">';
						if (el.office_state == 1) {
							append_content += '<img src="./static/style_default/images/pro_10.png" />';
						} else {
							append_content += '<img src="./static/style_default/images/pro_33.png" />';
						}
						append_content += '</span>';
						append_content += '<span><a href="javascript:;" class="delete" onclick="office_delete_one('+el.office_id+')"></a><a href="office_plan-'+el.office_id+'" class="edit"></a></span>';
						append_content += '</li>';
					});
					$('.tableBox').append(append_content);
				} else {
					alert('未搜索到任何内容');
				}
			}
		})
	} else {
		alert('关键词不能为空');
	}
}

</script>
