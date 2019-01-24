<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>产品管理-房间管理-设置平面图</title>
		<link rel="stylesheet" href="./static/style_default/style/common.css"/>
        <link rel="stylesheet" href="./static/style_default/style/header.css"/>
        <link rel="stylesheet" href="./static/style_default/style/productManage_room_plan.css"/>
        <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="./static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="./static/style_default/script/productManage_room_plan.js" type="text/javascript" charset="utf-8"></script>
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
        			<a href="javascript:;">设置平面图</a>
        		</div>
	        	<!--面包屑导航结束-->
	        	<!--右下半部分开始-->
	        	<div class="rightDown">
	        		<div class="controlBox">
	        			<a href="javascript:;" class="addColumn">增加列</a>
	        			<a href="javascript:;" class="addRow">增加行</a>
	        			<a href="javascript:;" class="lessRow">减少行</a>
	        			<a href="javascript:;" class="lessColumn">减少列</a>
	        			<a href="javascript:;" class="save" onclick="save_set()">保存设置</a>
	        			<a href="javascript:;" class="preview">预览设置</a>
	        		</div>
	        		<!--表格开始-->
	        		<div class="table" id="mainbox">
	        			<?php $m=2; for($i=0; $i<$a_view_data['plan'][0]; $i++){ ?>
	        			<div class="row">
	        				<ul>
	        					<?php for($j=0; $j<$a_view_data['plan'][1]; $j++){ ?>
	        					<li type="<?php echo $a_view_data['plan'][$m]; ?>" seatname="<?php echo $a_view_data['seatname'][$m-2]; ?>">
	        						<p class="wen"><span>空</span></p>
	        						<p class="nameList">
	        							<a href="javascript:;" class="door" onclick="set_door()">门</a>
	        							<a href="javascript:;" class="window" onclick="set_window()">窗</a>
	        							<a href="javascript:;" class="gangway" onclick="set_gangway()">过</a>
	        							<a href="javascript:;" class="seat" onclick="set_seat()">座</a>
	        							<a href="javascript:;" class="empty" onclick="set_empty()">空</a>
	        						</p>
	        					</li>
	        					<?php $m++; }; ?>
	        				</ul>
	        			</div>
						<?php }; ?>
	        		</div>
	        		<!--表格结束-->
	        	</div>
	        	<!--右下半部分结束-->
	        </div>
	        <!--右边内容结束-->
	        <!--添加座位名称弹框开始-->
	         <div class="seatName">
	         	<div class="title">
	         		<p class="h3">设置座位名称</p>
	         		<a href="javascript:;" class="close"></a>
	         	</div>
	         	<div class="inputBox">
	         		<span class="biao">座位名称</span>
	         		<input type="text" class="int" placeholder="如座位1号" />
	         		<span class="red"><i></i>还没有输入座位名称</span>
	         	</div>
	         	<div class="sureBox">
	         		<a href="javascript:;">确定</a>
	         	</div>
	         </div>
	        <!--添加座位名称弹框结束-->
	        <!--预览弹框开始-->
	        <div class="previewBox">
	        	<a href="javascript:;" class="close"></a>
	        	<p class="h3">预览平面图</p>
	        	<div class="picBox">
	        		<span class="zuo"><i></i>座位</span>
	        		<span class="men"><i></i>门</span>
	        		<span class="chuang"><i></i>窗户</span>
	        	</div>
	        	<div class="tableBox">
					<?php $m=2; for($i=0; $i<$a_view_data['plan'][0]; $i++){ ?>
        			<div class="row">
        				<ul>
        					<?php for($j=0; $j<$a_view_data['plan'][1]; $j++){ ?>
        						<?php if ($a_view_data['plan'][$m] == 0) {
        							echo '<li></li>';
        						} else if ($a_view_data['plan'][$m] == 1) {
        							echo '<li class="doorPic"></li>';
        						} else if ($a_view_data['plan'][$m] == 2) {
        							echo '<li class="windowPic"></li>';
        						} else if ($a_view_data['plan'][$m] == 3) {
        							echo '<li class="gangwayPic">过道</li>';
        						} else if ($a_view_data['plan'][$m] == 4) {
        							echo '<li class="seatPic"></li>';
        						} ?>
        					<?php $m++; }; ?>
        				</ul>
        			</div>
        			<?php }; ?>
    			</div>
	        </div>
	        <!--预览弹框结束-->
	</body>
</html>

<script>

// 刷新页面效果
function update_page() {
	var i = 1;
	$("#mainbox .row li").each(function(index, el) {
		var type = $(this).attr('type');
		var seatname = $(this).attr('seatname');
		if (type == 0) {
			$(this).css('background-color','#ffffff');
		} else if (type == 1) {
			$(this).css('background-color','#ffd84b');
			$(this).children('.wen').children('span').html('门');
		} else if (type == 2) {
			$(this).css('background-color','#967240');
			$(this).children('.wen').children('span').html('窗');
		} else if (type == 3) {
			$(this).css('background-color','#4bffa8');
			$(this).children('.wen').children('span').html('过道');
		} else if (type == 4) {
			$(this).css('background-color','#88acff');
			$(this).children('.wen').children('span').html('座 ['+seatname + ']');
		}
		i++;
	});
}

// 刷新格子id
function update_li() {
	var i = 1;
	$('#mainbox .row li').each(function(index, el) {
		$(this).attr('liid',i);
		$(this).attr('id','li_'+i);
		$(this).children('.nameList').children('.door').attr('onclick','set_door('+i+')');
		$(this).children('.nameList').children('.window').attr('onclick','set_window('+i+')');
		$(this).children('.nameList').children('.gangway').attr('onclick','set_gangway('+i+')');
		$(this).children('.nameList').children('.seat').attr('onclick','set_seat('+i+')');
		$(this).children('.nameList').children('.empty').attr('onclick','set_empty('+i+')');
		i++;
	});
}

// 设置格子为门
function set_door(num) {
	$('#li_'+num).css('background-color', '#ffd84b');
	$('#li_'+num).attr('type', 1);
	$('#li_'+num).attr('seatname', 0);
	$('#li_'+num).children('.wen').children('span').html('门');
}

// 设置格子为窗
function set_window(num) {
	$('#li_'+num).css('background-color', '#967240');
	$('#li_'+num).attr('type', 2);
	$('#li_'+num).attr('seatname', 0);
	$('#li_'+num).children('.wen').children('span').html('窗');
}

// 设置格子为过道
function set_gangway(num) {
	$('#li_'+num).css('background-color', '#4bffa8');
	$('#li_'+num).attr('type', 3);
	$('#li_'+num).attr('seatname', 0);
	$('#li_'+num).children('.wen').children('span').html('过道');
}

// 设置格子为座位
function set_seat(num) {
	// 判断当前座位数是否超过总数
	var i = 0;
	$("#mainbox .row li").each(function(index, el) {
		if ($(this).attr('type') == 4) {
			i++;
		}
	});
	// 座位总数
	var seat_total = "<?php echo $a_view_data['room']['room_seat']; ?>";
	// 判断当前类型是否为座位，如果是则取出其旧的座位名
	if ($("#li_"+num).attr('type') == 4) {
		$('.seatName .inputBox .int').val($("#li_"+num).attr('seatname'));
		i = i - 1;
	}
	// 判断是否超出总座位数
	if (i >= seat_total) {
		alert('超过房间预设座位数，不能再添加座位了');
	} else {
		$(".seatName").show();
		$(".sureBox a").attr('onclick', 'set_seat_two('+num+')');
		//添加座位名称弹框的关闭按钮
		$('.seatName .close').click(function(){
			$('.seatName').hide();
		})
	}
}

// 设置座位名第二步[点击确认时执行]
function set_seat_two(num) {
	var seatname = $('.seatName .inputBox .int').val();
	seatname = seatname.replace(/(^\s*)|(\s*$)/g, "");
	if (seatname == '') {
		$('.seatName .inputBox .red').show();
	} else {
		$('.seatName .inputBox .red').hide();
		$('.seatName').hide();
		$('.seatName .inputBox .int').val('');
		$('#li_'+num).css('background-color', '#88acff');
		$('#li_'+num).attr('type', 4);
		$('#li_'+num).attr('seatname', seatname);
		$('#li_'+num).children('.wen').children('span').html('座['+seatname+']');
	}
}

// 设置格子为空
function set_empty(num) {
	$('#li_'+num).css('background-color', '#ffffff');
	$('#li_'+num).attr('type', 0);
	$('#li_'+num).attr('seatname', 0);
	$('#li_'+num).children('.wen').children('span').html('空');
}

// 保存平面图设置
function save_set() {
	var row_lehgth = $('.table .row').length;
	var col_length = $('.table .row:first-child').find('li').length;
	var seat_arr = new Array();
	var seatname = new Array();
	seat_arr[0] = row_lehgth;
	seat_arr[1] = col_length;
	var i = 2;
	$('#mainbox .row li').each(function(index, el) {
		seat_arr[i] = $(this).attr('type');
		seatname[i-2] = $(this).attr('seatname');
		i++;
	})
	//将数组拼接成字符串
	var seat_str = seat_arr.join('-');
	var seatname_str = seatname.join('-');
	var office_id = '<?php echo $a_view_data['office']['office_id']; ?>';
	// alert(office_id);
	// alert(seat_str);
	// alert(seatname_str);
	$.ajax({
		url: '<?php echo $this->router->url('save_plan'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {office_plan: seat_str, office_seatname: seatname_str, office_id: office_id},
		success: function(data){
			console.log(data);
			if (data.code==200) {
				alert('保存设置成功');
				window.location.reload();
			}
		}
	})
}


</script>