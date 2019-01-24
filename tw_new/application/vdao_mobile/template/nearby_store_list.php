<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
		<meta content="black" name="apple-mobile-web-app-status-bar-style">
		<meta content="telephone=no" name="format-detection">
		<meta content="yes" name="apple-touch-fullscreen">
		<title>附近门店</title>
		<link rel="stylesheet" type="text/css" href="./static/style_default/style/common.css" />
		<script src="./static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
		<script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.6&key=6dbcdd666a88d6ba145ff5b3cd66ec71"></script>
	</head>

	<body>
		<style type="text/css">
			.box {
				background: #fff;
				height: 100%;
				font-size: 0.14rem;
			}
			
			.kg {
				height: .1rem;
				width: 100%;
				background: #f7f7f7;
			}
			
			.head {
				height: 0.44rem;
				display: flex;
				justify-content: space-between;
			}
			
			.head div {
				line-height: .44rem;
			}
			
			.head div:nth-child(1),
			.head div:nth-child(3) {
				flex: 0 0 0.3rem;
				text-align: center;
			}
			
			.head div:nth-child(1) {
				font-size: .18rem;
			}
			
			.navBox {
				position: relative;
				z-index: 2;
				background: white;
			}
			
			.nav {
				font-size: 0;
				border-bottom: 0.01rem solid #ddd;
			}
			
			.nav>span {
				width: 1.25rem;
				padding: 0.15rem 0;
				display: inline-block;
				font-size: 0.16rem;
				text-align: center;
				cursor: pointer;
			}
			
			.navCur {
				font-weight: bold;
			}
			
			.sortBox {
				width: 100%;
				background: white;
				display: none;
				position: absolute;
				border-top: 0.01rem solid #ddd;
			}
			
			.sortBox>li {
				padding: 0.2rem 0.15rem;
				font-size: 0.16rem;
				cursor: pointer;
			}
			
			.sortBox>li.sortCur {
				color: #ff6633;
			}
			
			.storeBox {}
			
			.storeBox>ul {}
			
			.storeBox>ul>li {
				margin: 0.14rem;
			}
			/* 门店 */
			
			.box_1_list {
				padding: 0.1rem;
				border: 0.01rem solid #ddd;
				border-radius: 0.06rem;
			}
			
			.box_1_list>img,
			.storeInfo {
				display: inline-block;
				vertical-align: top;
			}
			
			.box_1_list>a {
				display: inline-block;
				width: 0.7rem;
				height: 0.7rem;
				border-radius: 50%;
				overflow: hidden;
			}
			.box_1_list>a>img {
				height: auto;
				width: 100%;
				
			}
			
			.storeInfo {
				width: 2.4rem;
				margin-left: 0.1rem;
			}
			
			.box_2>li {
				margin-bottom: 0.12rem;
				;
			}
			
			.box_2>li:nth-child(1) {
				font-size: 0.18rem;
				font-weight: bold;
			}
			
			.box_2>li:nth-child(2)>i {
				display: inline-block;
				margin-right: 0.1rem;
				vertical-align: top;
			}
			
			.box_2>li:nth-child(2)>i>img {
				width: 0.11rem;
				vertical-align: middle;
			}
			
			.box_2>li:nth-child(2)>span {
				display: inline-block;
				margin-right: 0.12rem;
				font-size: 0.12rem;
				vertical-align: middle;
			}
			
			.box_2>li:nth-child(3) span {
				display: inline-block;
				font-size: 0.12rem;
				vertical-align: middle;
				color: #333333;
			}
			
			.box_2>li:nth-child(3)>a {
				float: right;
			}
			
			.box_2>li:nth-child(4)>a {
				width: 0.7rem;
				display: inline-block;
				margin-right: 0.1rem;
			}
			
			.box_2>li:nth-child(4)>a>i {
				height: 0.75rem;
				overflow: hidden;
			}
			
			.box_2>li:nth-child(4)>a>i>img {
				width: 0.76rem;
				height: 0.75rem;
				border-radius: 0.06rem;
			}
			
			.box_2>li:nth-child(4)>a>p {
				font-size: 0.12rem;
			}
			
			.box_2>li:nth-child(4)>a>span {
				font-size: 0.12rem;
				color: #ff0000;
				font-weight: bold;
			}
			
			.lay {
				position: absolute;
				width: 100%;
				height: 100%;
				top: 0;
				background: black;
				opacity: 0.5;
				z-index: 1;
				display: none;
				cursor: pointer;
			}
		</style>
		<!--头-->
		<div class="box">

			<div class="navBox">
				<div class="head">
					<a style="margin-left:0.2rem; " href="javascript:history.go(-1);"><div><img style="width:0.3rem;" src="static/style_default/images/yongping_03.png" alt="" /></div></a>
					<div style="font-size: 0.18rem;">附近门店</div>
					<div></div>
				</div>
				<div class="nav">
					<span class="general navCur">综合排序</span>
					<span onclick="loop(1)">好评优先</span>
					<span onclick="loop(3)">距离最近</span>
					<ul class="sortBox">
						<li class="sortCur">综合排序</li>
						<li onclick="loop(1)" >好评优先</li>
						<li onclick="loop(2)">起送价最低</li>
						<li onclick="loop(4)">销量最高</li>
					</ul>
				</div>

			</div>
			<div class="storeBox">
				<ul class="box_1">

				</ul>
			</div>

		</div>
		<div class="lay"></div>
	</body>
<script type="text/javascript">
$(function() {
	// loop();
 	// nearby_store_list();
})
</script>
<script type="text/javascript" >
		//web端用户定位
		mapObj = new AMap.Map('iCenter');
		mapObj.plugin('AMap.Geolocation', function () {
		    geolocation = new AMap.Geolocation({
		        enableHighAccuracy: true,//是否使用高精度定位，默认:true
		        timeout: 10000,          //超过10秒后停止定位，默认：无穷大
		        maximumAge: 0,           //定位结果缓存0毫秒，默认：0
		        convert: true,           //自动偏移坐标，偏移后的坐标为高德坐标，默认：true
		        showButton: true,        //显示定位按钮，默认：true
		        buttonPosition: 'LB',    //定位按钮停靠位置，默认：'LB'，左下角
		        buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
		        showMarker: true,        //定位成功后在定位到的位置显示点标记，默认：true
		        showCircle: true,        //定位成功后用圆圈表示定位精度范围，默认：true
		        panToLocation: true,     //定位成功后将定位到的位置作为地图中心点，默认：true
		        zoomToAccuracy:true      //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
		    });
		    mapObj.addControl(geolocation);
		    geolocation.getCurrentPosition();
		    AMap.event.addListener(geolocation, 'complete', onComplete);//返回定位信息
		    AMap.event.addListener(geolocation, 'error', onError);      //返回定位出错信息
		});
	//解析定位结果
    function onComplete(data) {
    	var lng  = data.position.getLng();
    	var lat  = data.position.getLat();
    	$.post("get_user_location","user_lngs="+lng+"&user_lats="+lat,function(res){

    	},'json');
    }
 //解析定位错误信息
    function onError(data) {
        document.getElementById('tip').innerHTML = '定位失败';
    }    		
    </script>
	<script>
		
		//返回附近门店列表
		function loop(type) {
			$.post("nearby_store_list","type="+type,function(res){
				if(res.status == "ok") {
				var html = "";
				$(".storeBox>ul").empty();
				var storeList = res.data;
				
				for(var i = 0; i < storeList.length; i++) {
				var child = "";
				for(var n = 0; n < storeList[i].sale_prod.length; n++) {
					child += "<a href='item-0-"+storeList[i].sale_prod[n].product_id+"-"+storeList[i].store_id+"'>" +
						"<i><img src='" + storeList[i].sale_prod[n].pro_img + "'/></i>" +
						"<p>" + storeList[i].sale_prod[n].product_name + "</p>" +
						"<span>" + storeList[i].sale_prod[n].price + "</span>" +
						"</a>"

				}
					html += "<li class='box_1_list'>" +
						"<a href='list_store-"+storeList[i].store_id+"'>"+
						"<img src='" + storeList[i].store_touxiang + "' /></a>" +
						"<div class='storeInfo'>" +
						"<ul class='box_2'>" +
						"<li class='box_2_list'>" + storeList[i].store_name + "</li>" +
						"<li class='box_2_list'>" +
						"<i>" +
						"<img src='static/style_default/images/gouxiang_05.png'/>" +
						"<img src='static/style_default/images/gouxiang_05.png'/>" +
						"<img src='static/style_default/images/gouxiang_05.png'/>" +
						"<img src='static/style_default/images/gouxiang_05.png'/>" +
						"<img src='static/style_default/images/gouxiang_05.png'/>" +
						"</i>" +
						"<span>" + storeList[i].all_score + "</span>" +
						"<span>月售" + storeList[i].month_sale + "</span>" +
						"</li>" +
						"<li class='box_2_list'>" +
						"<span>起送 ¥" + storeList[i].transport_start + "</span>|<span>配送" + storeList[i].set.set_parameter+ "</span>" +
						"<a><span>" + 40 + "分钟</span>|<span>" + storeList[i].distance+ " KM</span></a>" +
						"</li>" +
						"<li class='box_2_list'>" +
						//								storeList[i].shopList[n].imgs
						child +
						"</li>" +
						"</ul>" +
						"</div>"
					"</li>"
				}

			$(".storeBox>ul").append(html);					
					
				}
			}, "json");

		}

		loop(4);
		$("body").on("click", ".lay", function() {
			$(this).hide();
			$(".sortBox").hide();
		});
		$("body").on("click", ".nav>span", function() {
			$(this).addClass("navCur");
			$(".nav>span").not($(this)).removeClass("navCur");
			if($(".nav>span").not($(".nav>span:nth-child(1)"))){
				$(".sortBox").hide();
				$(".lay").hide();
			}
		});
		$("body").on("click", ".sortBox>li", function() {
			$(".box_1>li").remove();
			$(this).addClass("sortCur");
			$(".sortBox>li").not($(this)).removeClass("sortCur");
			$(".sortBox").hide();
			$(".lay").hide();
			loop(4);
		});
		$("body").on("click", ".general", function() {
			$(".sortBox").show();
			$(".lay").show();
		});
		
		
	</script>
