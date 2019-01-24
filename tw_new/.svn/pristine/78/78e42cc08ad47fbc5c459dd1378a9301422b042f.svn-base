<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
		<meta content="black" name="apple-mobile-web-app-status-bar-style">
		<meta content="telephone=no" name="format-detection">
		<meta content="yes" name="apple-touch-fullscreen">
		<title>产品分类</title>
		<link rel="stylesheet" type="text/css" href="./static/style_default/style/common.css" />
		<script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
		<style type="text/css">
			.body {
				font-size: .14rem;
				height: 100%;
				position: relative;
			}
			
			.header {
				display: flex;
				position: absolute;
				width:100%;
				background: #fff;
				justify-content: space-between;
				align-items: center;
				font-size: .18rem;
				padding: .15rem;
			}
			
			.searchs {
				width: .165rem;
				height: .165rem;
				background: url(./static/style_default/images/search11.png) no-repeat;
				background-size: .165rem .165rem;
				background-position: center;
				cursor: pointer;
			}
			
			.content {
				display: flex;
				width:100%;
				height:calc(100% - 1rem);
				position: absolute;
				top:0.56rem;
			}
			.content .left{
				width:20%;
			
			}
			.content .right{
				width:80%;
				right:0;
			}
			.content .left ,.content .right{
				position:absolute;
				height:calc(100% - 0.1rem);
				overflow: auto;
				-webkit-overflow-scrolling: touch;
			}
			
			.content .left .type {
				/*width: .8rem;*/
				height: .65rem;
				line-height: .65rem;
				text-align: center;
				color: #666666;
				cursor: pointer;
			}
			
			.content .left .type.check {
				background: #fff;
				color: #000000;
				cursor: pointer;
			}
			
			.content .right {
				flex: 1;
			}
			
			.content .right .food {
				display: flex;
				justify-content: space-between;
				padding: .1rem;
				background: #fff;
				margin-bottom: .1rem;
			}
			
			.content .right .food .img {
				width: .75rem;
				height: .75rem;
				background: #A0A0A0;
				border-radius: .025rem;
				flex: 0 0 .75rem;
				margin-right: .1rem;
			}
			
			.content .right .food .img>img {
				width: 100%;
				height: auto;
			}
			
			.content .right .food .other {
				display: flex;
				flex-direction: column;
				justify-content: space-between;
				flex: 1;
			}
			
			.content .right .food .other .info {
				font-size: .11rem;
			}
			
			.content .right .food .other .sale {
				color: #333333;
			}
			
			.content .right .food .other .priceBox {
				font-size: .16rem;
				display: flex;
				justify-content: space-between;
				align-items: center;
				color: #999999;
			}
			
			.content .right .food .other .price {
				color: #fe563c;
			}
			
			.content .right .food .other .add {
				width: .3rem;
				height: .3rem;
				background: url(./static/style_default/images/＋.png) no-repeat;
				background-size: .2rem .2rem;
				background-position: center;
				cursor: pointer;
			}
			
			.c_gray {
				color: #666666;
			}
			
			.type_box {
				width: 2.9rem;
				position: fixed;
				left: 0.5rem;
				top: 1rem;
				/*margin:-1.5rem 0 0 -1.5rem;*/
				z-index: 99;
				background: white;
				border-radius: 0.06rem;
				display: none;
			}
			
			.type_box>dl>dt {
				padding: 0.1rem 0;
				text-align: center;
				font-size: 0.15rem;
				position: relative;
			}
			
			.type_box>dl>dt>img {
				width: 0.13rem;
				position: absolute;
				right: 0.1rem;
				top: 0.13rem;
				cursor: pointer;
			}
			
			.type_box>dl>dd {
				margin-bottom: 0.18rem;
				padding: 0 0.1rem;
			}
			
			.type_box>dl>dd>p {
				font-size: 0.13rem;
				margin-bottom: 0.18rem;
			}
			
			.type_box>dl>dd>a {
				width: 0.35rem;
				height: 0.35rem;
				line-height: 0.35rem;
				text-align: center;
				display: inline-block;
				border-radius: 50%;
				/*background:#ff6633;*/
				border: 0.01rem solid #DDD;
				margin-right: 0.1rem;
				font-size: 0.1rem;
				cursor: pointer;
			}
			
			.type_box>dl>dd>a.typeCur {
				background: #ff6633;
				color: White;
			}
			
			.type_info>span {
				display: block;
				text-align: center;
				padding: 0.1rem;
				font-size: 0.16rem;
				color: #fb453a;
			}
			
			.type_info>p {
				text-align: center;
				font-style: normal;
				font-size: 0.16rem;
				padding: 0.05rem;
			}
			
			.joinCart {
				padding: 0.1rem 0;
				text-align: center;
				font-size: 0.14rem;
				color: white;
				background: #ff6633;
				cursor: pointer;
			}
			
			.footer {
				position: absolute;
				background:white;
				width: 100%;
				bottom: 0;
				font-size: 0;
				border-top: 0.01rem solid #ddd;
				z-index: 90;
			}
			
			.footer>a {
				position: relative;
				width: 20%;
				display: inline-block;
				padding: 0.05rem 0;
				background: white;
				text-align: center;
			}
			
			.footer>a>img {
				width: 0.24rem;
			}
			
			.footer>a>span {
				font-size: 0.12rem;
				display: block;
				margin-top: 0.05rem;
			}
			
			.cartImg {
				width: 0.34rem;
				height: 0.4rem;
				line-height: 0.38rem;
				position: absolute;
				display: inline-block;
				text-align: center;
				font-size: 0.18rem;
				font-style: normal;
				color: white;
				top: -0.32rem;
				left: 0.18rem;
				background-image: url(./static/style_default/images/tuoooo.png);
				background-repeat: no-repeat;
				background-size: 100% 100%;
				cursor: pointer;
			}
			
			.cartList_box {
				width: 100%;
				position: absolute;
				/*top: -2.5rem;*/
				font-size: 0.15rem;
				z-index: 2;
				bottom: 0.55rem;
				display: none;
			}
			
			.cartList_box>p {
				padding: 0.12rem;
				background: #ececee;
			}
			
			.cartList_box>p>em {
				float: right;
				font-style: normal;
				cursor: pointer;
			}
			
			.shop_list_box {
				background: white;
				height: 1.7rem;
				overflow: scroll;
			}
			
			.shop_list_box>li {
				padding: 0.13rem 0.15rem;
				border-bottom: 0.01rem solid #ddd;
			}
			
			.list_left {
				display: inline-block;
			}
			
			.list_left>span {
				font-size: 0.12rem;
				color: #666666;
			}
			
			.list_right {
				float: right;
				margin-top: 0.1rem;
			}
			
			.list_right>span,
			.list_right>img,
			.list_right>em {
				vertical-align: middle;
			}
			
			.list_right>span {
				font-size: 0.15rem;
				color: #ff6633;
				margin-right: 0.1rem;
			}
			
			.list_right>img {
				width: 0.19rem;
				cursor: pointer;
			}
			
			.list_right>em {
				font-size: 0.13rem;
				font-style: normal;
				margin: 0 0.05rem;
			}
			
			.lay {
				position: absolute;
				width: 100%;
				height: 100%;
				top: 0;
				left: 0;
				background: black;
				opacity: 0.5;
				z-index: 90;
				display: none;
				cursor: pointer;
			}
			
			
			.search_body {
				position: absolute;
				width:100%;
				top:0;
				font-size: .14rem;
				height: 100%;
				background: #fff;
				overflow-y: auto;
				display: none;
			}
			
			.search_body .header2 {
				display: flex;
				justify-content: space-between;
				align-items: center;
				padding: .1rem;
				border-bottom: 1px solid #f4f4f4;
			}
			
			.search_body .header2 .left_search {
				width: .1rem;
				height: .18rem;
				background: url(./static/style_default/images/back.png) no-repeat;
				background-size: .1rem .18rem;
				background-position: center;
			}
			
			.search_body .header2 .search {
				width: 2.84rem;
				height: .33rem;
				background: #f4f4f4;
				display: flex;
				align-items: center;
				border-radius: .165rem;
				padding: 0 .1rem 0 .2rem;
			}
			
			.search_body .header2 .search #search {
				height: 100%;
				width: 100%;
				background: #f4f4f4;
				padding: 0 .1rem;
			}
			
			.search_body .header2 .search .search_logo {
				width: .2rem;
				height: .2rem;
				background: url(./static/style_default/images/search2.png) no-repeat;
				background-size: .16rem .15rem;
				background-position: center;
			}
			
			.search_body .header2 .search .empty {
				width: .2rem;
				height: .2rem;
				background: url(./static/style_default/images/empty.png) no-repeat;
				background-size: .15rem .15rem;
				background-position: center;
			}
			
			.search_body .center {
				padding: .1rem;
			}
			
			.search_body .center .history .title {
				display: flex;
				justify-content: space-between;
				align-items: center;
				padding: .1rem 0;
			}
			
			.search_body .center .history .title .delete {
				width: .2rem;
				height: .2rem;
				background: url(./static/style_default/images/delete.png) no-repeat;
				background-size: .13rem .14rem;
				background-position: center;
			}
			
			.search_body .center .hot .title {
				padding: .1rem 0;
			}
			
			.search_body .center .foods {
				display: flex;
				flex-wrap: wrap;
			}
			
			.search_body .center .foods .food {
				padding: .1rem;
				background: #f4f4f4;
				margin: 0 .1rem .1rem 0;
				cursor: pointer;
			}
			
			.search_body .clickList {
				display: none;
			}
			
			.search_body .clickList .list {
				padding: .15rem .1rem;
				border-bottom: 1px solid #F4F4F4;
			}
			
			.search_body .searchList .food {
				display: flex;
				justify-content: space-between;
				padding: .1rem;
				background: #fff;
				margin-bottom: .1rem;
			}
			
			.search_body .searchList .food .img {
				width: .75rem;
				height: .75rem;
				background: #A0A0A0;
				border-radius: .025rem;
				flex: 0 0 .75rem;
				margin-right: .1rem;
			}
			
			.search_body .searchList .food .img>img {
				width: 100%;
				height: auto;
			}
			
			.search_body .searchList .food .other {
				display: flex;
				flex-direction: column;
				justify-content: space-between;
				flex: 1;
			}
			
			.search_body .searchList .food .other .info {
				font-size: .11rem;
			}
			
			.search_body .searchList .food .other .sale {
				color: #333333;
			}
			
			.search_body .searchList .food .other .priceBox {
				font-size: .16rem;
				display: flex;
				justify-content: space-between;
				align-items: center;
				color: #999999;
			}
			
			.search_body .searchList .food .other .price {
				color: #fe563c;
			}
			
			.search_body .searchList .food .other .add {
				width: .3rem;
				height: .3rem;
				background: url(./static/style_default/images/＋.png) no-repeat;
				background-size: .2rem .2rem;
				background-position: center;
			}
			
			.search_body .c_gray {
				color: #666666;
			}
			/*.wrapper2{
 				position:absolute;
  				top:0;
  				bottom:0;
  				left:0;
  				right:0; 
  				overflow-y:auto;
  				-webkit-overflow-scrolling : touch; 
			}*/
		</style>
	</head>

	<body>
		
		<div class="body">
			<div class="header">
				<div class="backNet" style="width:0.3rem;" onClick="javascript :history.back(-1);"><img src="./static/style_default/images/yongping_03.png" alt="" /></div>
				<div>产品分类</div>
				<div class="searchs"></div>
			</div>
			<div class="content">
				<div class="left">
					<?php foreach ($a_view_data['category'] as $key => $value): ?>
					<div id="<?php echo $value['pro_id']; ?>" class="type "><?php echo $value['pro_name']; ?></div>
					 <?php endforeach ?>
				</div>
					
				<div class="right">
					<?php foreach ($a_view_data['prod'] as $k => $val): ?>
					
					<div class="food">
						<div class="img"><a href="item-<?php echo $val['proid_id_1']?>-<?php echo $val['product_id']?>-0">
							<img src="<?php echo $val['pro_img']; ?>">	</a></div>
						<div class="other">
							<div class="name font_w"><?php echo $val['product_name']; ?></div>
							<div class="info c_gray"><?php echo $val['pro_details']?></div>
							<div class="sale"> 月售<?php echo $val['number']?> 好评率<?php echo $val['pingl']?>% </div>
							<div class="priceBox">
								<div><span class="price">￥<?php echo $val['prod_price']['price']; ?></span>起</div>
								<div class="add" prod_name="<?php echo $val['product_name']; ?>" id="<?php echo $val['product_id']; ?>"></div>
							</div>
						</div>
					</div>
				
					<?php endforeach ?>
					<!-- <span class="prodmore">更多</span> -->
				</div>
			</div>
			
			<div class="footer">
			<a href="index">
				<img src="./static/style_default/images/nav1.png" alt="" />
				<span>首页</span>
			</a>
			<a href="javascript:;">
				<img src="./static/style_default/images/bn2.png" alt="" />
				<span style="color:#ff6633">产品</span>
			</a>
			<a href="mood_showlist">
				<img src="./static/style_default/images/nav3.png" alt="" />
				<span>动态</span>
			</a>
			<a  class="shopCart" href="shopping"> 
			<img src="./static/style_default/images/nav4.png" alt="" />
				<span>购物车</span>
				<i class="cartImg"><?php echo $a_view_data['cart_count'] ;?></i>
			</a>
			<a href="nuser_center">
				<img src="./static/style_default/images/nav5.png" alt="" />
				<span>会员</span>
			</a>
		</div>
			
			<!-- 选规格 -->
			<div class="type_box">
				<dl>
				<dt>
					<span class="type_name">抹茶星冰乐</span>
					<img class="closeType" src="./static/style_default/images/y_03.png" alt="" />
				</dt>
					<dd class="priceType">
						<p>类型</p>
						<a class="typeCur">大</a>
						<a>中</a>
						<a>小</a>
					</dd>
				</dl>
				<dl class="typeList">
					<dd>
						<p>温度</p>
						<a>默认</a>
						<a class="typeCur">冷</a>
						<a>热</a>
					</dd>
					<dd>
						<p>加料</p>
						<a>椰果</a>
						<a class="typeCur">芝士</a>
						<a>珍珠</a>
					</dd>
				</dl>
			
				<div class="type_info">
					<span>¥32.00</span>
					<p></p>
				</div>
				<p class="joinCart">加入购物车</p>
			</div>
			<!-- 选规格 -->
		</div>

		<div class="lay"></div>

		

		<div class="cartList_box">
			<p>
				<span>已选商品</span>
				<em class="clear_list">清空</em>
			</p>
			<ul class="shop_list_box">
				<!--<li>
							<div class="list_left">
								<p>乌龙奶茶</p>
								<span>小杯/冷/加糖</span>
							</div>
							<div class="list_right">
								<span>¥32.00</span>
								<img class="minNum" src="./static/style_default/images/add_03.png" alt="" />
								<em>1</em>
								<img class="addNum" src="./static/style_default/images/add_05.png" alt="" />
							</div>
						</li>-->

			</ul>
			<p style="font-size:0.1rem; text-align: center;">商品如需分开打包，请在下单时备注</p>
		</div>
		
		
		<div class="search_body">
			<!--头部-->
			<div class="header2">
				<div style="cursor: pointer;" class="left_search"></div>
				<div class="search">
					<div class="search_logo"></div>
					<input type="" name="" id="search" value="" placeholder="搜索你要的商品"
					 onkeydown="entersearch1(event)"/>
					<div class="empty"></div>
				</div>
				<div class="right_search" style="cursor: pointer;" onclick="search()">搜索</div>
			</div>

			<!--默认显示-->
			<div class="center">
				<div class="hot">
					<div class="title">热门推荐</div>
					<div class="foods hotFoods">
					<!-- 	<div class="food">鸳鸯咖啡</div>
						<div class="food">鸳鸯咖啡</div>
						<div class="food">鸳鸯咖啡</div>
						<div class="food">鸳鸯咖啡</div>
						<div class="food">鸳鸯咖啡</div>
						<div class="food">鸳鸯咖啡</div> -->
					</div>
				</div>
				<div class="history">
					<div class="title">
						<div>最近搜索</div>
						<div class="delete search_del"></div>
					</div>
					<div class="foods searchFoods">
						<!-- <div class="food">鸳鸯咖啡</div>
						<div class="food">鸳鸯咖啡</div>
						<div class="food">鸳鸯咖啡</div>
						<div class="food">鸳鸯咖啡</div>
						<div class="food">鸳鸯咖啡</div>
						<div class="food">鸳鸯咖啡</div> -->
					</div>
				</div>
			</div>

			<!--点击后列表-->
			<div class="clickList">

			</div>
			<!--搜索列表-->
			<div class="searchList">
				<!--<div class="food">
					<div class="img">
						<img src="" alt="">
					</div>
					<div class="other">
						<div class="name font_w">柚子冰红茶</div>
						<div class="info c_gray">香浓摩卡酱与咖啡原液，在牛奶加冰 块中绽放快乐</div>
						<div class="sale"> 月售3    好评率100% </div>
						<div class="priceBox">
							<div><span class="price">￥32.00</span>起</div>
							<div class="add"></div>
						</div>
					</div>
				</div>-->
			</div>
		</div>
		
	</body>

</html>
<script type="text/javascript">

	$(function() {
		$(document).on('click','.content .left .type',function() {
			var check = $(this).is('.check');
			if(!check) {
				$(this).addClass('check').siblings('.check').removeClass('check');
				var id = $(this).attr('id');
				$.post("get_prod_list",{cid:id,type:2},function(res){
						//渲染产品
						$('.content .right').empty();
					if(res.code ==200) {
						var foods = res.data;
						if(foods ==""){
							$('.content .right').empty();
							return false;
						}
						var food = '';
						
						$.each(foods, function(idx, obj) {
							food += '<div class="food">' +
							'<div class="img"><a href="item-'+obj.proid_id_1+'-'+obj.product_id+'-0"><img src="'+obj.pro_img+'"></a></div>' +
							'<div class="other">' +
							'<div class="name font_w">' + obj.product_name + '</div>' +
							'<div class="info c_gray">' + obj.pro_details + '</div>' +
							'<div class="sale"> 月售' + obj.number + '    好评率' + obj.pingl + '% </div>' +
							'<div class="priceBox">' +
							'<div><span class="price">￥' + obj.prod_price.price + '</span>起</div>' +
							'<div class="add" prod_name="'+obj.product_name+'" id=' + obj.product_id + '></div>' +
							'</div>' +
							'</div>' +
							'</div>';
						})
						//清空再添加
						$('.content .right').empty().append(food);
					}
				
				},"json");

			}
		});

		//让指定的DIV始终显示在屏幕正中间  
		function setDivCenter(divName) {
			var top = ($(window).height() - divName.height()) / 4;
			var left = ($(window).width() - divName.width()) / 2;
			var scrollTop = $(document).scrollTop();
			//      var scrollLeft = $(document).scrollLeft();  
			divName.css({
				'top': top + scrollTop
			}).show();
		}

		//选规格
		function choiceType($this) {
			var list = $(".type_box>dl>dd");
			var html = "";
			$this.addClass("typeCur");
			$this.parent().find("a").not($this).removeClass("typeCur");
			list.each(function(i) {
				html += list.eq(i).children("a.typeCur").html() + " ";
			});

			$(".type_info>p").html(html);
		}

	

		$("body").on("click", ".type_box>dl>dd>a", function() {
			choiceType($(this));
			loopType($(this))
		});


		//选规格
		$("body").on("click", ".add", function(e) {
			var id = $(this).attr('id');
			var prod_name = $(this).attr('prod_name');
			$(".type_name").empty();
			$(".type_name").text(prod_name);
			$.post("get_prod_list",{type:3,pid:id},function(res){
				if(res.code ==200) {
					//基础类型
					var priceType = res.data.ptype;
					html = '';
					$(".priceType").empty();
					$.each(priceType, function(idx, obj) {
						if(idx ==0){
						html+='<a class="typeCur" pid="'+id+'" spec="'+obj.cup_id+'" price="'+obj.price+'">'+obj.cup_name+'</a>';
						}else{
							html+='<a class="" pid="'+id+'" spec="'+obj.cup_id+'" price="'+obj.price+'">'+
							 obj.cup_name+'</a>';
						}
						
					})
					html = '<p>类型</p>'+html;
					$(".priceType").append(html);
					//其他类型列表
					var typeList = res.data.attr_list;
					$(".typeList").empty();
					loopType($(this));

					var shtml = "";
					if(typeList !=""){
						$.each(typeList, function(idx, obj) {
						shtml+='<dd >'+
						'<p>'+obj.attri_name+'</p>';
						
						var  Chi  =obj.list;
						var chtml ='';
						for(var i=0;i<Chi.length;i++){
								
								if(i ==0){
									chtml+='<a class="typeCur">'+Chi[i].attri_name+'</a>';
								}else{
									chtml+='<a >'+Chi[i].attri_name+'</a>';
								}
						}
						shtml =shtml+chtml+'</dd>';
						})
				$(".typeList").append(shtml);
				loopType($(this));
					}

				}
			},"json");
			$(".lay").css("z-index", "91");
			$(".lay").show();
			setDivCenter($(".type_box"));	
//			$(".type_box").show();
			
			
		});
		
		function typeLoad(){
			var list = $(".type_box>dl.typeList>dd");
			var chtml = "";
			list.each(function(i) {
				chtml += list.eq(i).children("a.typeCur").html() + " ";
			});
			$(".type_info>p").html(chtml);
			
		}
		
		//弹出选规格窗口
		function loopType($this) {
			var list = $(".type_box>dl>dd");
			var chtml = "";
			var szPrice=$(".type_box>dl>dd.priceType>a.typeCur").attr("price");
			list.each(function(i) {
				chtml += list.eq(i).children("a.typeCur").html() + "/";
			});
			chtml=chtml.substring(0,chtml.length-1);
			// chtml=chtml.trimend('/');
			$(".type_box>dl>dt>span").html($this.parent().parent().find(".font_w").html());
			$(".type_info>span").html("¥"+szPrice);
			$(".type_info>p").html(chtml);
		}
		//关闭选规格
		$("body").on("click", ".closeType", function() {
			$(".type_box").hide();
			$(".lay").hide();
		});
		
		function zIndex() {
			$(".cartList_box").css("z-index", "2");
			$(".shopCart_box").css("z-index", "2");
			$(".footer").css("z-index", "1");
			$(".banc").css("z-index", "2");
		}

		//遮罩层
		$("body").on("click", ".lay", function() {
			$(".lay").hide();
			$(".type_box").hide();
			$(".cartList_box").hide();
			$(".cartImg").removeClass("cartShow");
			zIndex();
		});

		 function list_len() {
		 	var listLen = $(".shop_list_box>li").length;
		 	listLen < 1 ?
		 		$(".cartImg").hide() :
		 		$(".cartImg").show();
		 	$(".cartImg").html(listLen);
		 }
		 // list_len();

		//购物车显示的数量
		 function shopCart_num() {
		 	var sopListLen = $(".shop_list_box>li").length
		 	$(".cartImg").html(sopListLen);
		 }


		$(".type_list>li").each(function(i) {
			$(this).addClass("type_" + i);
		})

		//加入购物车
		function joinCart($this, shopName, shopType, shopMoney) {
			var html = "";
			html = "<li>" +
				"<div class='list_left'>" +
				"<p>" + shopName + "</p>" +
				"<span>" + shopType + "</span>" +
				"</div>" +
				"<div class='list_right'>" +
				"<span>" + shopMoney + "</span>" +
				"<img class='minNum' src='./static/style_default/images/add_03.png' />" +
				"<em>1</em>" +
				"<img  class='addNum' src='./static/style_default/images/add_05.png'  />"
			"</div>" +
			"</li>"
			$(".shop_list_box").append(html);
		}

		$("body").on("click", ".joinCart", function() {
			var $this = $(this);
			var shopName = $this.parent().parent().find("dl>dt>span").html();
			var shopType = $this.prev().find("p").html();
			var shopMoney = $this.prev().find("span").html();
			var szPrice=$(".type_box>dl>dd.priceType>a.typeCur").attr("price");
			var spec=$(".type_box>dl>dd.priceType>a.typeCur").attr("spec");
			var  pid = $(".type_box>dl>dd.priceType>a.typeCur").attr("pid");
			var shuxi = $(".type_info>p").text();
			$.post("shop_add",{tost:0,oute:1,shuxi:shuxi,spec:spec,goods:pid,manoe:szPrice},function(res){
				if(res.code == 200){
					joinCart($this, shopName, shopType, shopMoney);
					// shopCart_num();
					list_len();
					totalPrice();
					$(".type_box").hide();
					$(".lay").hide();
					$(".cartImg").html(res.count);
				}else if(res.code ==205){
					window.location.href="nuser_center";
				}
			},"json");
			
		});

		//购物车
		$("body").on("click", ".cartImg", function(e) {
			e.preventDefault();
			if($(this).hasClass("cartShow")) {
				$(this).removeClass("cartShow");
				$(".lay").hide();
				$(".cartList_box").hide();
				//				zIndex();
			} else {
				$(".shop_list_box").empty();
				$.post("shop_inex",{usore:0},function(res){
					if(res.code ==200) {
						var html = "";
						var data = res.data.goods;
					if(data !=""){
						for(var i=0; i<data.length;i++ ){
						html += "<li>" +
							"<div class='list_left'>" +
							"<p>" + data[i].product_name + "</p>" +
							"<span>" + data[i].shux_name + "</span>" +
							"</div>" +
							"<div class='list_right'>" +
							"<span>" + data[i].money + "</span>" +
							"<img class='minNum' src='./static/style_default/images/add_03.png' />" +
							"<em>"+data[i].prot_count+"</em>" +
							"<img  class='addNum' cid='"+data[i].cart_id+"' src='./static/style_default/images/add_05.png'  />"
							"</div>" +
							"</li>";
						}
					}
					
						$(".shop_list_box").append(html);
					}
				},"json");
				$(this).addClass("cartShow");
				$(".lay").show();
				$(".cartList_box").show();
				$(".cartList_box").css("z-index", "98");
				$(".shopCart_box").css("z-index", "99");
				$(".footer").css("z-index", "98");
				$(".banc").css("z-index", "99");
				 // list_len();
			}
		});
		//清空购物车
		$("body").on("click", ".clear_list", function() {
			listLen = $(".shop_list_box>li").length;
			if(listLen <1) return false;
			$.post("shop_delete",{stoue:0},function(res){
				if(res.code ==200) {
					$(".cartPrice>span>em").html("¥0.00");
					$(".cartImg").html(0);
					$(".shop_list_box>li").remove();
				}
			},"json");
			
			 // list_len();
		});

		// $(".footer>a").click(function(e){
		// 	e.preventDefault();
		// })

		// function list_len() {
		// 	var listLen = $(".shop_list_box>li").length;
		// 	listLen < 1 ?
		// 		$(".cartImg>i").hide() :
		// 		$(".cartImg>i").show();
		// 	$(".cartImg>i").html(listLen);
		// }
		// list_len();
		//购物车加减
		function addNum($this) {
			var totalPrice = 0;
			var shopNum = $this.prev().html();
			shopNum++;
			$this.prev().html(shopNum);

		}

		function minNum($this) {
			var totalPrice = 0;
			var shopNum = $this.next().html();
			shopNum--;
			shopNum < 1 ? $this.parent().parent().remove() : "";
			$this.next().html(shopNum);
		}
		$("body").on("click", ".addNum", function() {
			var $this=$(this);	
			var cid = $(this).attr("cid");
			$.post("shop_reudaa",{id:cid,stou:0,vart:1},function(res){
				if(res.code ==200){
					$(".cartImg").html(res.count);
					var totalPrice = 0;
				var shopNum = $this.prev().html();
				shopNum++;
				$this.prev().html(shopNum);
				totalPrice($this);

				}
			},"json");
			
		});
		$("body").on("click", ".minNum", function() {
			var $this=$(this);	
			var cid = $(".addNum").attr("cid");
			var shopNum = $(".addNum").prev().html();
			if(shopNum <2){
			$.post("shop_dele",{id:cid},function(res){
				if(res.code ==200){
					$(".cartImg").html(res.count);
					minNum($this);
					totalPrice();
				}
			},"json");
			}else{
				$.post("shop_reudaa",{id:cid,stou:0,vart:2},function(res){
				if(res.code ==200){
					$(".cartImg").html(res.count);
					minNum($this);
					totalPrice();
				}
				},"json");	
			}
		
			
		});

		//计算购物车总价
		function totalPrice() {
			var list = $(".shop_list_box>li>.list_right");
			var unival;
			var shopNum;
			var totolNum = 0; //商品数量
			var totolPrice = 0; //总价
			var disp = 0; //配送费
			for(var i = 0; i < list.length; i++) {
				unival = list[i].children[0].innerHTML.substring(1);
				shopNum = list[i].children[2].innerHTML;
				totolNum += Number(shopNum);
				totolPrice += Number(unival) * Number(shopNum);
			}
			// $(".cartImg").html(totolNum);
			$(".cartPrice>span>em").html("¥" + totolPrice.toFixed(2));

		}
		totalPrice();

		//搜索板块
		$("body").on("click", ".searchs", function() {
			$.post("get_prod_list",{type:4},function(res){
				$(".center").show();
				$("#search").val("");
				$(".hotFoods").empty();
				$(".searchFoods").empty();
				if(res.code ==200){
					html="";
					var data = res.data;
					for(var i=0;i<data.length;i++){
						html+='<a href="item-'+data[i].proid_id_1+'-'+data[i].product_id+'-0"><div class="food" >'+data[i].product_name+'</div></a>';
					}
					$(".hotFoods").append(html);
					if(res.history !=""){
					whtml="";
					var history = res.history;
					for(var y=0;y<history.length;y++){
						whtml+='<div class="food his_foods" >'+history[y].user_seasrch+'</div>';
					}
					$(".searchFoods").append(whtml);
					}
				}
			},"json");
			$(".search_body").show();
		});
$(document).on("click",".his_foods",function(){
	var search = $(this).text();
	if(search != '') {
			$('.searchList').empty()
			$.post("get_prod_list",{type:5,search:search},function(res){
			if(res.code==200){
				$('.center').hide();
				//渲染产品
				var food = '';
				var searchList = res.data;
				$.each(searchList, function(idx, obj) {
					food += '<div class="food">' +
						'<div class="img"><a href="item-'+obj.proid_id_1+'-'+obj.product_id+'-0"><img src="' + obj.pro_img + '" alt=""></a></div>' +
						'<div class="other">' +
						'<div class="name font_w">' + obj.product_name + '</div>' +
						'<div class="info c_gray">' + obj.pro_details + '</div>' +
						'<div class="sale"> 月售' + obj.number + '    好评率' + obj.pingl + '% </div>' +
						'<div class="priceBox">' +
						'<div><span class="price">￥' + obj.prod_price.price+ '</span>起</div>' +
						'<div class="add" id=' + obj.product_id + '></div>' +
						'</div>' +
						'</div>' +
						'</div>'
				})
				//清空再添加
			$('.searchList').empty().append(food);
			}else{
				alert("没有搜索到产品!");
				}
			},"json");

	
			
		} else {
			alert('请填写关键字')
		}
});

	
	
	})
</script>
<script type="text/javascript">
	$(document).on("click",".empty",function(){
		$("#search").val("");
	})
	$(function() {
		// $('.search_body .center').on('click', '.food', function() {
		// 	$('.center').hide();
		// 	var list = ''
		// 	$.each(clickList, function(idx, obj) {
		// 		list += '<div class="list" id="' + obj.id + '">' + obj.name + '</div>'
		// 	})
		// 	$('.clickList').empty().append(list).show();
		// })
	})

	function search() {
		if($('#search').val() != '') {
			var search  =$('#search').val();
			$('.searchList').empty()
			$.post("get_prod_list",{type:5,search:search},function(res){
			if(res.code==200){
				$('.center').hide();
				//渲染产品
				var food = '';
				var searchList = res.data;
				$.each(searchList, function(idx, obj) {
					food += '<div class="food">' +
						'<div class="img"><a href="item-'+obj.proid_id_1+'-'+obj.product_id+'-0"><img src="' + obj.pro_img + '" alt=""></a></div>' +
						'<div class="other">' +
						'<div class="name font_w">' + obj.product_name + '</div>' +
						'<div class="info c_gray">' + obj.pro_details + '</div>' +
						'<div class="sale"> 月售' + obj.number + '    好评率' + obj.pingl + '% </div>' +
						'<div class="priceBox">' +
						'<div><span class="price">￥' +  obj.prod_price.price+ '</span>起</div>' +
						'<div class="add" id=' + obj.product_id + '></div>' +
						'</div>' +
						'</div>' +
						'</div>'
				})
				//清空再添加
			$('.searchList').empty().append(food);
			}else{
				alert("没有搜索到产品!");
				}
			},"json");

	
			
		} else {
			alert('请填写关键字')
		}
	}
	$(document).on("click",".search_del",function(){
		if(confirm("确认删除全部历史记录？")){
			$.post("get_prod_list",{type:6},function(res){
				if(res.code==200){
					$(".searchFoods").empty();
				}else{
					alert(res.msg);
				}
			},"json");
		}
	});

	
	//关闭搜索板块
	$("body").on("click", ".left_search", function() {
			$(".search_body").hide();
			$(".searchList .food").empty();
	});
</script>


  <?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
    <?php } ?>
    <script type="text/javascript">
  	    var u = navigator.userAgent;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
            if (isAndroid) {
               var obj={"isArrowFinish":true}
                isArrowWindowFinish(obj);
            } else if (isiOS) {
               
            }  
 // 按Enter键,执行事件  
function entersearch1(event){  
    if (event.keyCode == 13)  
       {  
          search();  
       }  
}        
    </script>
    
<!--<script>
	var ScrollFix = function(elem) {
    // Variables to track inputs
    var startY, startTopScroll;
    
    elem = elem || document.querySelector(elem);
    
    // If there is no element, then do nothing    
    if(!elem)
        return;

    // Handle the start of interactions
    elem.addEventListener('touchstart', function(event){
        startY = event.touches[0].pageY;
        startTopScroll = elem.scrollTop;
        
        if(startTopScroll <= 0)
            elem.scrollTop = 1;

        if(startTopScroll + elem.offsetHeight >= elem.scrollHeight)
            elem.scrollTop = elem.scrollHeight - elem.offsetHeight - 1;
    }, false);
};

/*判断设备调用ScrollFix*/

var sUserAgent=navigator.userAgent.toLowerCase();
if(sUserAgent.match(/iphone os/i) == "iphone os"){
    $('.wrapper').addClass('wrapper2');
    ScrollFix($('.wrapper2')[0]); 
}

/*阻止用户双击使屏幕上滑*/
var agent = navigator.userAgent.toLowerCase();        //检测是否是ios
var iLastTouch = null;                                //缓存上一次tap的时间
if (agent.indexOf('iphone') >= 0 || agent.indexOf('ipad') >= 0)
{
    document.body.addEventListener('touchend', function(event)
    {
        var iNow = new Date()
            .getTime();
        iLastTouch = iLastTouch || iNow + 1 /** 第一次时将iLastTouch设为当前时间+1 */ ;
        var delta = iNow - iLastTouch;
        if (delta < 500 && delta > 0)
        {
            event.preventDefault();
            return false;
        }
        iLastTouch = iNow;
    }, false);
}
</script>-->