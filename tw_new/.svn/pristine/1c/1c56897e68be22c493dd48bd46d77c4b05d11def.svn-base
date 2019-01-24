<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>门店设置</title>
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
            width: 600px;
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
        #tip {
            background-color: #fff;
            padding:0 10px;
            border: 1px solid silver;
            box-shadow: 3px 4px 3px 0px silver;
            font-size: 12px;
            border-radius: 3px;
            line-height: 36px;
            margin-top: 20px;
        }
    </style>
    <script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>门店设置</h1>
	<form action="<?php echo $this->router->url('store_set'); ?>" method='post' enctype="multipart/form-data">
		门店名称：<input type="text" name="store_name" value="<?php echo $a_view_data['store_name']; ?>"><br>
		门店介绍：<textarea name="store_introduction" cols="30" rows="10"><?php echo $a_view_data['store_introduction']; ?></textarea><br>
		门店定位：<input type="text" name="store_position" value="<?php echo $a_view_data['store_position']; ?>">
		&nbsp;&nbsp;<a style="color:green;text-decoration:none;" href="#" onclick="spread()">点击重新定位</a><br>
		门店地址：<input type="text" name="store_address" value="<?php echo $a_view_data['store_address']; ?>"><br>
		交通线路：<input type="text" name="store_traffic" value="<?php echo $a_view_data['store_traffic']; ?>"><br>
        联系方式：<input type="text" name="store_contact" value="<?php echo $a_view_data['store_contact']; ?>"><br>
		耗材预警值：<input type="text" name="store_warning" value="<?php echo $a_view_data['store_warning']; ?>"><br>
		一键抢单距离(km)：<input type="text" name="order_distance" value="<?php echo $a_view_data['order_distance']; ?>">
		<br>
<!--         门店照片：<input type="file" id="file" multiple="multiple" /><br> -->
		<input type="submit" value="保存设置">
	</form>
    <div style="border:3px solid pink; padding:10px; margin:10px;">
        <form action="<?php echo $this->router->url('store_withdraw'); ?>" method="post">
            真实姓名：<input type="text" name="store_remittee" value="<?php echo $a_view_data['store_remittee']; ?>"><br>
            银行卡号：<input type="text" name="store_bankcard" value="<?php echo $a_view_data['store_bankcard']; ?>"><br>
            支付宝账号：<input type="text" name="store_alipay" value="<?php echo $a_view_data['store_alipay']; ?>"><br>
            提现密码：<input type="password" name="store_password" placeholder="留空表示不修改"><br>
            <input type="submit" value="确定">
        </form>
    </div>
	<div id="maxdiv" style="display:none;">
        <div style="padding:10px; margin-bottom:10px; border:1px solid pink;">
            <p style="color:gray;">鼠标左键单击获取的地理座标：
                经度：<span id="click_lng" style="color:red;"><?php if($a_view_data['position_x']==9999){ echo '未设置'; }else{ echo $a_view_data['position_x']; }; ?></span>&nbsp;&nbsp;
                纬度：<span id="click_lat" style="color:red;"><?php if($a_view_data['position_y']==9999){ echo '未设置'; }else{ echo $a_view_data['position_y']; }; ?></span>&nbsp;&nbsp;
                <?php if($a_view_data[0]==9999){ echo '<span id="tipspan" style="color:red;">请点击下方地图进行设置</span>'; }; ?>
            </p>
        </div>
        <div style="overflow:hidden;">
            <div id="container"></div>
            <div id="search_right">
                <span style="background-color:pink; color:white; padding:5px;">搜索</span>
                <input type="text" id="tipinput"/>
                <div id="tip">
                    省：
                    <select id='province' name="province" style="width:100px" onchange='get_city(this.value)'>
                        <option value="999">--请选择--</option>
                    </select>
                    市：
                    <select id='city' name="city" style="width:100px" onchange='get_district(this.value)'>
                        <option value="999">--请选择--</option>
                    </select>
                    区：
                    <select id='district' name="district" style="width:100px" onchange='get_street(this.value)'>
                        <option value="999">--请选择--</option>
                    </select>
                    街道：
                    <select id='street' name="street" style="width:100px" onchange='set_center(this.value)'>
                        <option value="999">--请选择--</option>
                    </select>
                </div>
                <div id="area_number" style="margin-top:30px;">
                    省编号：<input style="width:60px;" type="text" name="province_number" >
                    市编号：<input style="width:60px;" type="text" name="city_number" >
                    区编号：<input style="width:60px;" type="text" name="district_number" >
                    <br><br>
                    地图点击的位置：
                    <span id="amc_clik" style="color:green;"></span>
                    <br><br>
                    点击的城市编码：
                    <span id="amc_number" style="color:red;"></span>
                </div>
            </div>
        </div>
    </div>
    <div id="result" name="result"></div>
</body>
</html>

<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=fc088640a32f5ccf91f1702022f88ac0&plugin=AMap.DistrictSearch""></script>
<script type="text/javascript">

function spread() {
	if($('#maxdiv').css('display')=='none'){
		$('#maxdiv').css('display','block');
	} else {
		$('#maxdiv').css('display', 'none');
	};
}

// 门店之前的位置信息
var longitude = <?php echo $a_view_data['position_x']; ?>;
var latitude = <?php echo $a_view_data['position_y']; ?>;
// 判断是否设置了门店位置 如果设置了则显示 没有则默认显示当前城市
if (longitude == 9999 && latitude == 9999) {
    // 若center及level属性缺省，地图默认显示用户当前城市范围
    var map = new AMap.Map('container', {
        resizeEnable: true,
        zoom: 10,
    });
} else {
    // 创建地图
    var map = new AMap.Map('container',{
        resizeEnable: true,
        zoom: 17,
        center: [<?php echo $a_view_data['position_x'] . ',' . $a_view_data['position_y']; ?>]
    });
    // 给默认位置标记
    var marker = new AMap.Marker({
        position: [<?php echo $a_view_data['position_x'] . ',' . $a_view_data['position_y']; ?>],//marker所在的位置
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
    $("input[name='store_position']").val(longitude+','+latitude);

    console.log(e);

    AMap.service('AMap.Geocoder',function(){//回调函数
        //实例化Geocoder
        geocoder = new AMap.Geocoder({});
        //TODO: 使用geocoder 对象完成相关功能
        //逆地理编码
        var lnglatXY=[longitude, latitude];//地图上所标点的坐标
        geocoder.getAddress(lnglatXY, function(status, result) {
            if (status === 'complete' && result.info === 'OK') {
               //获得了有效的地址信息:
               //即，result.regeocode.formattedAddress
               console.log(result.regeocode);
               $('#amc_clik').html(result.regeocode.formattedAddress);
               get_city_number(result.regeocode.addressComponent.province,result.regeocode.addressComponent.city);
            }else{
               //获取地址失败
               alert('获取失败');
            }
        });
    })


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

AMap.service('AMap.DistrictSearch',function(){//回调函数
    //实例化DistrictSearch
    districtSearch = new AMap.DistrictSearch();
    //TODO: 使用districtSearch对象调用行政区查询的功能
})
var districtSearch = new AMap.DistrictSearch({
    level : 'country',
    subdistrict : 1
});



districtSearch.search('中国',function(status, result){
    var subDistricts = result.districtList[0].districtList;
    for(var i=0; i<subDistricts.length; i+=1){
            var name = subDistricts[i].name;
            var adcode = subDistricts[i].adcode;
            $("#province").append('<option adcode='+adcode+' value="'+name+'">'+name+'</option>');
    }
})


function get_city(province) {
    if (province != 999) {
        map.setCity(province);
        $("#province option").each(function(index, el) {
            if ($(this).val() == province) {
               $("input[name='province_number']").val($(this).attr('adcode'));
            }
        });
        $('#city option').not(':eq(0)').remove();
        districtSearch.search(province, function(status, result){
            var subDistricts = result.districtList[0].districtList;
            for(var i=0; i<subDistricts.length; i+=1){
                    var name = subDistricts[i].name;
                    var adcode = subDistricts[i].adcode;
                    $("#city").append('<option adcode='+adcode+' value="'+name+'">'+name+'</option>');
            }
        })
    } else {
        $('#city option').not(':eq(0)').remove();
        $('#district option').not(':eq(0)').remove();
        $('#street option').not(':eq(0)').remove();
        $("input[name='province_number']").val('');
        $("input[name='city_number']").val('');
        $("input[name='district_number']").val('');
    }
}


function get_district(city) {
    if (city != 999) {
        map.setCity(city);
        $("#city option").each(function(index, el) {
            if ($(this).val() == city) {
               $("input[name='city_number']").val($(this).attr('adcode'));
            }
        });
        $('#district option').not(':eq(0)').remove();
        districtSearch.search(city, function(status, result){
            var subDistricts = result.districtList[0].districtList;
            for(var i=0; i<subDistricts.length; i+=1){
                    var name = subDistricts[i].name;
                    var adcode = subDistricts[i].adcode;
                    $("#district").append('<option adcode='+adcode+' value="'+name+'">'+name+'</option>');
            }
        })
    } else {
        $('#district option').not(':eq(0)').remove();
        $('#street option').not(':eq(0)').remove();
        $("input[name='city_number']").val('');
        $("input[name='district_number']").val('');
    }
}


function get_street(district) {
    if (district != 999) {
        map.setCity(district);
        $("#district option").each(function(index, el) {
            if ($(this).val() == district) {
               $("input[name='district_number']").val($(this).attr('adcode'));
            }
        });
        $('#street option').not(':eq(0)').remove();
        districtSearch.search(district, function(status, result){
            var subDistricts = result.districtList[0].districtList;
            for(var i=0; i<subDistricts.length; i+=1){
                    var name = subDistricts[i].name;
                    var adcode = subDistricts[i].adcode;
                    $("#street").append('<option adcode='+adcode+' value="'+name+'">'+name+'</option>');
            }
        })
    } else {
        $('#street option').not(':eq(0)').remove();
        $("input[name='district_number']").val('');
    }
}

function set_center(street) {
    if (street != 999) {
        map.setCity(street);
    }
}


function get_city_number(province, city) {
    districtSearch.search(province, function(status, result){
        var subDistricts = result.districtList[0].districtList;
        for(var i=0; i<subDistricts.length; i+=1){
                var name = subDistricts[i].name;
                var adcode = subDistricts[i].adcode;
                if (name == city) {
                    $("#amc_number").html(name+'：'+adcode);
                }
        }
    })
}









</script>