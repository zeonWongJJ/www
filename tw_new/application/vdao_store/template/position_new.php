<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>新定位测试</title>
	<style>
		a {
			text-decoration: none;
			color: pink;
		}
		#container {
			width: 500px;
			height: 380px;
			float: left;
			border: 1px solid pink;
	    }
	    #search_right {
			width: 350px;
			height: 360px;
			padding: 10px;
	    	float: left;
	    	margin-left: 30px;
	    	font-size: 16px;
	    	color: pink;
	    	border:1px solid pink;
	    }
	    #search_right input {
			width: 250px;
			height: 25px;
	    }
	</style>
	<script src='./script/jquery-1.8.2.min.js'></script>
	<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=fc088640a32f5ccf91f1702022f88ac0"></script>
</head>
<body>
	<h1 style="color:#000;">新定位测试 | <a href="#" onclick="save_position()">点这里保存设置</a></h1>
	<div style="padding:10px; margin-bottom:10px; border:1px solid pink;">
		<p style="color:gray;">鼠标左键单击获取的地理座标：
			经度：<span id="click_lng" style="color:red;"><?php if($a_view_data[0]==9999){ echo '未设置'; }else{ echo $a_view_data[0]; }; ?></span>&nbsp;&nbsp;
			纬度：<span id="click_lat" style="color:red;"><?php if($a_view_data[1]==9999){ echo '未设置'; }else{ echo $a_view_data[1]; }; ?></span>&nbsp;&nbsp;
			<?php if($a_view_data[0]==9999){ echo '<span id="tipspan" style="color:red;">请点击下方地图进行设置</span>'; }; ?>
		</p>
	</div>
	<div style="overflow:hidden;">
		<div id="container"></div>
		<div id="search_right">
			<span style="background-color:pink; color:white; padding:5px;">搜索</span>
			<input type="text" id="tipinput"/>
		</div>
	</div>
</body>
</html>

<script>

$(function(){
	// 门店之前的位置信息
    var longitude = <?php echo $a_view_data[0]; ?>;
    var latitude = <?php echo $a_view_data[1]; ?>;
    // 判断是否设置了门店位置 如果设置了则显示 没有则默认显示当前城市
    if (longitude == 9999 && latitude == 9999) {
    	// 若center及level属性缺省，地图默认显示用户当前城市范围
	    var map = new AMap.Map('container', {
	        resizeEnable: true
	    });
    } else {
	    // 创建地图
		var map = new AMap.Map('container',{
			resizeEnable: true,
		    zoom: 17,
		    center: [<?php echo $a_view_data[0] . ',' . $a_view_data[1]; ?>]
		});
		// 给默认位置标记
		var marker = new AMap.Marker({
		    position: [<?php echo $a_view_data[0] . ',' . $a_view_data[1]; ?>],//marker所在的位置
		    map:map//创建时直接赋予map属性
		});
    }
	// 加载插件
	AMap.plugin(['AMap.ToolBar','AMap.AdvancedInfoWindow', 'AMap.OverView', 'AMap.Autocomplete', 'AMap.PlaceSearch'],function(){
	    //创建并添加工具条控件
	    var toolBar = new AMap.ToolBar();
	    map.addControl(toolBar);
	})
	// 点击事件
	var _onClick = function(e){
		// 如果之前设置了位置信息则移除标记 没有则移除提示
		if (longitude == 9999 && latitude == 9999) {
			// 清除提示信息
			$("#tipspan").html('');
		} else {
			// 清除原来的标记
			map.remove(marker);
		}
		// 给点击的府标加上标记
	    marker = new AMap.Marker({
	        position : e.lnglat,
	        map : map
	    })
	    // 点击的座标
	    longitude = e.lnglat.getLng();
	    latitude = e.lnglat.getLat();
	    $("#click_lng").html(longitude);
	    $("#click_lat").html(latitude);
	}
	// 绑定事件，返回监听对象
	var clickListener = AMap.event.addListener(map, "click", _onClick);
    // 输入提示
    var autoOptions = {
        input: "tipinput"
    };
    var auto = new AMap.Autocomplete(autoOptions);
    var placeSearch = new AMap.PlaceSearch({
        map: map
    });  //构造地点查询类
    AMap.event.addListener(auto, "select", select);//注册监听，当选中某条记录时会触发
    function select(e) {
        placeSearch.setCity(e.poi.adcode);
        placeSearch.search(e.poi.name);  //关键字查询查询
    }
})

// 保存地理位置设置
function save_position() {
	// 获取位置信息
	var mylng = $("#click_lng").html();
	var mylat = $("#click_lat").html();
	// 判断是否是位置信息
	if (mylng == '未设置' || mylat == '未设置') {
		alert('请在地图上点击需要保存的位置');
	} else {
		$.ajax({
			url: '<?php echo $this->router->url('position_new'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {mylng: mylng, mylat: mylat},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					alert('保存成功');
					window.location.reload();
				} else {
					alert('保存失败');
				}
			}
		})
	}
}

</script>