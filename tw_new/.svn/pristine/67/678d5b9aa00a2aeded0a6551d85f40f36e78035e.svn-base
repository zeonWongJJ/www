<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
		<meta content="black" name="apple-mobile-web-app-status-bar-style">
		<meta content="telephone=no" name="format-detection">
		<meta content="yes" name="apple-touch-fullscreen">
		<title>购物车</title>
		<link rel="stylesheet" type="text/css" href="./static/style_default/style/common.css" />
		<script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
		<title></title>
		<style>
			.box {
				position: relative;
				height: 100%;
				font-size: 0.14rem;
			}
			
			.head,
			.choiceBox,
			.productContainer>dl>dt,
			.productContainer>dl>dd,
			.productContainer>dl>dt>label,
			.productContainer>dl>dd>label,
			.productContainer>dl>dt>label>i,
			.productContainer>dl>dd>a,
			.productContainer>dl>dd>a>ul>li,
			.pro_calc,
			.pro_calc>i,
			.pro_calc>span,
			.allChoice,
			.allChoice>label,
			.totoal_box,
			.totoal_box>span,
			.totoal_box>a {
				display: -webkit-flex;
				/* Safari */
				display: flex;
			}
			
			.head {
				width: 100%;
				height: 0.47rem;
				justify-content: space-between;
				align-items: center;
				background: #ff6633;
			}
			
			.head>span:first-child {
				flex: 0 0 .5rem;
			}
			
			.head>span {
				font-size: 0.18rem;
				color: white;
				cursor: pointer;
			}
			
			.head>span.adminX {
				font-size: 0.15rem;
				flex: 0 0 .5rem;
			}
			
			.sc_container {
				width: 100%;
				background: white;
				/*position: absolute;*/
			}
			
			.choiceBox {
				justify-content: flex-end;
				align-items: center;
				padding: 0.1rem 0;
				visibility: hidden;
			}
			
			.choiceBox>a {
				font-size: 0.13rem;
				height: 0.3rem;
				line-height: 0.3rem;
				margin-right: 0.12rem;
				text-align: center;
				border: 1px solid #ff6633;
				border-radius: 0.4rem;
				color: #ff6633;
				flex: 0 0 0.6rem;
				align-items: center;
				cursor: pointer;
			}
			
			.productContainer {
				width: 100%;
				height: calc( 100% - 2rem);
				top: 0.9rem;
				position: absolute;
				background: white;
				overflow: scroll;
			}
			
			.productContainer>dl>dt>label input,
			.productContainer>dl>dd>label input {
				display: none;
			}
			
			.productContainer>dl>dt>label>i>img,
			.productContainer>dl>dd>label>img {
				width: 0.2rem;
				height: 0.2rem;
			}
			
			.productContainer>dl>dt>label>i {
				width: 0.52rem;
				justify-content: center;
			}
			
			.productContainer>dl>dt>label>img {
				width: 0.2rem;
				margin-right: 0.1rem;
			}
			
			.productContainer>dl>dt {
				margin-top: 0.1rem;
			}
			
			.productContainer>dl>dt>label {
				align-items: center;
			}
			
			.productContainer>dl>dd {
				margin-top: 0.1rem;
				padding-bottom: 0.1rem;
			}
			
			.productContainer>dl>dd {
				justify-content: flex-start;
				align-items: center;
			}
			
			.productContainer>dl>dd>label {
				justify-content: center;
				align-items: center;
				width: 0.52rem;
				height: 0.96rem;
			}
			
			.productContainer>dl>dd>a {
				align-items: center;
			}
			
			.productContainer>dl>dd>a>img {
				width: 0.95rem;
				height: 0.95rem;
			}
			
			.productContainer>dl>dd>a>ul {
				width: 2rem;
				margin-left: 0.13rem;
			}
			
			.productContainer>dl>dd>a>ul>li:nth-child(2) {
				height: 0.28rem;
				align-items: center;
				margin-top: 0.1rem;
				padding-left: 0.1rem;
				margin-bottom: 0.17rem;
				background: #f7f7f7;
			}
			
			.productContainer>dl>dd>a>ul>li:nth-child(3) {
				justify-content: space-between;
			}
			
			.productContainer>dl>dd>a>ul>li:nth-child(3)>span {
				color: #ff6633;
			}
			
			.pro_calc,
			.pro_calc>i {
				align-items: center;
			}
			
			.pro_calc>i {
				width: 0.24rem;
				height: 0.2rem;
				justify-content: center;
				cursor: pointer;
			}
			
			.pro_calc>span {
				width: 0.34rem;
				height: 0.2rem;
				justify-content: center;
				border: 1px solid #ddd;
				align-items: center;
			}
			
			.pro_calc>i>img {
				width: 0.1rem;
			}
			
			.pro_min {
				border: 1px solid #ddd;
				border-right: none;
				border-top-left-radius: 0.02rem;
				border-bottom-left-radius: 0.02rem;
			}
			
			.pro_add {
				border: 1px solid #ddd;
				border-left: none;
				border-top-right-radius: 0.02rem;
				border-bottom-right-radius: 0.02rem;
			}
			
			.allChoice {
				width: 100%;
				height: 0.5rem;
				position: absolute;
				bottom: 0.58rem;
				justify-content: space-between;
				align-items: center;
				background: White;
			}
			
			.allChoice>label {
				width: 1rem;
				justify-content: center;
				align-items: center;
			}
			
			.allChoice>label>img {
				width: 0.2rem;
				height: 0.2rem;
			}
			
			.allChoice>label>span {
				margin-left: 0.16rem;
			}
			
			.allChoice input {
				display: none;
			}
			
			.totoal_box>span {
				height: 0.5rem;
				color: #ff6633;
				justify-content: center;
				align-items: center;
				margin-right: 0.2rem;
			}
			
			.totoal_box>a {
				width: 1rem;
				height: 0.5rem;
				justify-content: center;
				align-items: center;
				background: #ff6633;
				font-size: 0.18rem;
				color: White;
			}
			
			.footer {
				position: fixed;
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
				visibility: hidden;
				color: white;
				top: -0.32rem;
				left: 0.18rem;
				background-image: url(./static/style_default/images/tuoooo.png);
				background-repeat: no-repeat;
				background-size: 100% 100%;
			}
			
			.tips {
				/*width:4rem;*/
				height:0.3rem;
				line-height: 0.2rem;
				text-align: center;
				padding: 0.05rem 0.1rem;
				position: absolute;
				background: black;
				color: white;
				font-size: 0.14rem;
				border-radius: 0.03rem;
				display: none;
				opacity: 0.8;
			}
			.deleTips{
				width:2.8rem;
				padding:0.28rem 0.24rem;
				position: absolute;
				font-size:0.14rem;
				display: none;
				background: white;
				z-index: 99;
			}
			.deleTips>p{
				font-size:0.18rem;
				margin-bottom:0.24rem;
			}
			.deleTips>span{
				font-size:0.16rem;
				color:#666666;
			}
			.btnBox{
				margin-top:0.3rem;
				text-align: right;
			}
			.btnBox>a{
				font-size:0.13rem;
				margin-left:0.3rem;
			}
			.btnBox>a:nth-child(2){
				color:#ff6633;
			}
			
			.lay{
				width:100%;
				height:100%;
				top:0;
				position: absolute;
				background: black;
				opacity: 0.5;
				z-index: 90;
				display: none;
				cursor: pointer;
			}
		</style>
	</head>

	<body>
		<div class="box">
			<div class="sc_container">
				<div class="head">
					<span></span>
					<span>购物车</span>
					<span class="adminX">管理</span>
				</div>
				<div class="choiceBox">
					<a class="coll">收藏</a>
					<a class="dele">删除</a>
				</div>
			</div>
			<div class="productContainer">

			</div>

			<div class="allChoice">
				<label for="all_choice">
					<input type="checkbox" id="all_choice" />
					<img src="./static/style_default/images/cb.png" alt="" />
					<span>全选</span>
				</label>
				<div class="totoal_box">
					 <form action="new_bill?oldurl=<?php echo $this->router->get_url(); ?>" method="post">
					<input type="hidden" name="cart_ids">
         			 <input type="hidden" name="come_type" value="1">
          			<input type="hidden" name="oldurl" value="<?php echo $this->router->get_url(); ?>">
          			 <input type="hidden" value="<?php echo $a_view_data['set']['set_parameter']?>" class="set">
          			</form>
					<span class="totoal">合计：121324</span>
					<a class="blance" href="javascript:;">结算(0)</a>
				</div>

			</div>

	    <!-- 底部导航 -->
        <div class="footer">
            <a href="index">
                <img src="./static/style_default/images/nav1.png" alt="" />
                <span>首页</span>
            </a>
            <a href="n_goods_list">
                <img src="./static/style_default/images/nav2.png" alt="" />
                <span>分类</span>
            </a>
            <a href="mood_showlist">
                <img src="./static/style_default/images/nav3.png" alt="" />
                <span>动态</span>
            </a>
            <a  class="shopCart" href="javascript:;">
                <img src="./static/style_default/images/nav4.png" alt="" />
                <span>购物车</span>
                <i class="cartImg"><?php echo $a_view_data['cart_count'] ;?></i>
            </a>
            <a href="nuser_center">
                <img src="./static/style_default/images/nav5.png" alt="" />
                <span>会员</span>
            </a>
        </div>
    <!-- 底部导航 -->

		</div>

		<div class="tips"></div>
		<div class="deleTips">
			<p>提示</p>
			<span></span>
			<div class="btnBox">
				<a class="cancel">取消</a>
				<a class="sure">删除</a>
			</div>
		</div>
		<div class="lay"></div>
	</body>

</html>

<script>
	$(function() {


		//添加选择id
		function addId() {
			$(".productContainer>dl dt>label").each(function(i) {
				$(this).find("dl>dt>label").attr("for", "st_" + i);
				$(this).find("dl>dt>label>input[type='checkbox']").attr("id", "st_" + i);
			});
			$(".productContainer>dl dd>label").each(function(i) {
				$(this).attr("for", "sp_" + i);
				$(this).find("input[type='checkbox']").attr("id", "sp_" + i);
			});
		}

		//渲染
		function loop() {
			$.post("shopping_msg",{status:1},function(res){
				if(res.code ==200){
					var data = res.data.data;
					var html = "";
					for(var i = 0; i < data.length; i++) {
						var child = "";
						for(var n = 0; n < data[i].goods.length; n++) {
							child +=
								"<dd >" +
								"<label>" +
								"<input type='checkbox' value='"+data[i].goods[n].cart_id+"'  prodId='"+data[i].goods[n].product_id+"'>" +
								"<img src='./static/style_default/images/cb.png'>" +
								"</label>" +
								"<a>" +
								"<img src='" + data[i].goods[n].pro_img + "'>" +
								"<ul class='productInfo'>" +
								"<li>" + data[i].goods[n].product_name + "</li>" +
								"<li>" + data[i].goods[n].shux_name + "</li>" +
								"<li>" +
								"<span>" + data[i].goods[n].money + "</span>" +
								"<div class='pro_calc'>" +
								"<i class='pro_min' value='"+data[i].goods[n].cart_id+"'><img src='./static/style_default/images/jian.png' alt=''/></i>" +
								"<span>"+data[i].goods[n].prot_count+"</span>" +
								"<i class='pro_add' value='"+data[i].goods[n].cart_id+"'><img src='./static/style_default/images/jia.png' alt='' /></i>" +
								"</div>" +
								"</li>" +
								"</ul>" +
								"</a>" +
								"</dd>"
						}
						html += "<dl>" +
							"<dt>" +
							"<label>" +
							"<input type='checkbox'>" +
							"<i><img src='./static/style_default/images/cb.png'></i>" +
							"<img src=''>" +
							"<span>" + data[i].store_name + "</span>" +
							"</label>" +
							"</dt>" +
							child +
							"</dl>"
					}
					$(".productContainer").append(html);
					addId();
				}
			},"json");
		
		}
		loop();

		$(".lay").click(function(){
			$(".lay").hide();
			$(".deleTips").hide ();
		})
		$(".deleTips .cancel").click(function(){
			$(".lay").hide();
			$(".deleTips").hide ();
		})

		//点击管理显示隐藏
		$(".adminX").click(function() {
			$(".choiceBox").hasClass("c_show") ? $(".choiceBox").css("visibility", "hidden").removeClass("c_show") : $(".choiceBox").css("visibility", "inherit").addClass("c_show");
		})
		//点击收藏
		$(".coll").click(function() {
			var list = $(".productContainer dd>label>input[type='checkbox']:checked");
			if( list.length > 0 ){
				$(".tips").html("收藏成功！")
				letDivCenter($(".tips"));
				$(".tips").show ().delay (2000).fadeOut ();
				var cid ='';
				list.each(function(){
					cid += $(this).attr("prodId")+",";
				})
					var id = cid.substring(0, cid.length-1);
					// console.log(id);return;
					if (id != '') {
							$.ajax({
								type : 'post',
								url  : 'collection_add',
								data : {id:id,type:3},
								dataType : 'json',
								success  : function(data) {
									console.log(data);
									// if (data.code == 200) {
									// 	window.location.reload();
									// }
								}
							})
					};

			
			}else{
				$(".tips").html("请选择要收藏的产品！");
				letDivCenter($(".tips"));
				$(".tips").show ().delay (2000).fadeOut ();
			}
		})
		//点击删除
		$(".dele").click(function() {
			var list = $(".productContainer dd>label>input[type='checkbox']:checked");
			if( list.length > 0 ){
				$(".deleTips>span").html("确认要删除"+list.length+"件商品吗？");
				letDivCenter($(".deleTips"));
				$(".lay").show();
				$(".deleTips").show ();
			
			
	
			}else{
				$(".tips").html("请选择要删除的产品！");
				letDivCenter($(".tips"));
				$(".tips").show ().delay (2000).fadeOut ();
			}
		})
		//删除
		$(".sure").click(function(){
			var list = $(".productContainer dd>label>input[type='checkbox']:checked");
			list.parent().parent().remove();
			totalPrice();
			$(".lay").hide();
			$(".deleTips").hide ();
			list.each(function(i){
				var id = $(this).attr("value");
				if (id != '') {
					$.ajax({
						type : 'post',
						url  : 'shop_dele',
						data : {id:id},
						dataType : 'json',
						success  : function(data) {
						}
					})
				};
			})
		});
		// function select_dd($this){
		// 	var ddLen = $this.parent().parent().parent().find("dd").length; //商品长度
		// 	var ddChoiceLen = $this.parent().parent().parent().find("dd>label>input[type='checkbox']:checked").length; //选中商品的长度
		// 	var title = $this.parent().parent().parent(); //标题

		// 	if($this.is(":checked")) {
		// 		$this.next().attr("src", "./static/style_default/images/ca.png");
		// 	} else {
		// 		$this.next().attr("src", "./static/style_default/images/cb.png");
		// 	}
		// 	if(ddLen == ddChoiceLen) {
		// 		title.find("dt>label>input").prop("checked", true);
		// 		title.find("dt>label>i>img").attr("src", "./static/style_default/images/ca.png");
		// 	} else {
		// 		title.find("dt>label>input").prop("checked", false);
		// 		title.find("dt>label>i>img").attr("src", "./static/style_default/images/cb.png");
		// 	}
		// 	totalPrice();
		// }

		//全选
		$(document).on("click",".productContainer>dl>dt input[type='checkbox']",function() {	
			var dd = $(this).parent().parent().parent(); //商品列表
			if($(this).is(":checked")) {
				$(this).next().find("img").attr("src", "./static/style_default/images/ca.png");
				dd.find("dd>label>input").prop("checked", true);
				dd.find("dd>label>img").attr("src", "./static/style_default/images/ca.png");
			} else {
				$(this).next().find("img").attr("src", "./static/style_default/images/cb.png");
				dd.find("dd>label>input").prop("checked", false);
				dd.find("dd>label>img").attr("src", "./static/style_default/images/cb.png");
			}
			totalPrice();
		});

		//单选
		$(document).on("click",".productContainer>dl>dd input[type='checkbox']",function() {
			var ddLen = $(this).parent().parent().parent().find("dd").length; //商品长度
			var ddChoiceLen = $(this).parent().parent().parent().find("dd>label>input[type='checkbox']:checked").length; //选中商品的长度
			var title = $(this).parent().parent().parent(); //标题

			if($(this).is(":checked")) {
				$(this).next().attr("src", "./static/style_default/images/ca.png");
			} else {
				$(this).next().attr("src", "./static/style_default/images/cb.png");
			}
			if(ddLen == ddChoiceLen) {
				title.find("dt>label>input").prop("checked", true);
				title.find("dt>label>i>img").attr("src", "./static/style_default/images/ca.png");
			} else {
				title.find("dt>label>input").prop("checked", false);
				title.find("dt>label>i>img").attr("src", "./static/style_default/images/cb.png");
			}
			totalPrice();
		});
		//全选
		$("#all_choice").click(function() {
			if($(this).is(":checked")) {
				$(this).next().attr("src", "./static/style_default/images/ca.png");
				$(".productContainer dt>label>input").prop("checked", true);
				$(".productContainer dt>label>i>img").attr("src", "./static/style_default/images/ca.png");
				$(".productContainer dd>label>input").prop("checked", true);
				$(".productContainer dd>label>img").attr("src", "./static/style_default/images/ca.png");
			} else {
				$(this).next().attr("src", "./static/style_default/images/cb.png");
				$(".productContainer dt>label>input").prop("checked", false);
				$(".productContainer dt>label>i>img").attr("src", "./static/style_default/images/cb.png");
				$(".productContainer dd>label>input").prop("checked", false);
				$(".productContainer dd>label>img").attr("src", "./static/style_default/images/cb.png");
			}
			totalPrice();
		});
		//加
		function addNum($this) {
			var totalPrice = 0;
			var shopNum = $this.prev().html();
			Number(shopNum++);
			$this.prev().html(shopNum);
				// ajax请求更改购物车数量
			var cart_id = $this.attr('value');
			$.ajax({
			url: 'shopcar_update',
			type: 'POST',
			dataType: 'json',
			data: {cart_id: cart_id, num:shopNum},
			success: function (res) {
				// console.log(res);
			}
		})
		}
		//减
		function minNum($this) {
			var totalPrice = 0;
			var shopNum = $this.next().html();
			Number(shopNum--);
			shopNum < 2 ? $this.next().html(1) : $this.next().html(shopNum);

		// ajax请求更改购物车数量
		var cart_id = $this.attr('value');
		$.ajax({
			url: 'shopcar_update',
			type: 'POST',
			dataType: 'json',
			data: {cart_id: cart_id, num:shopNum},
			success: function (res) {
				// console.log(res);
			}
		})
		}

		$("body").on("click", ".pro_add", function() {
			addNum($(this));
			totalPrice($(this))
		});
		$("body").on("click", ".pro_min", function() {
			minNum($(this));
			totalPrice();
		});

		//计算购物车总价
		function totalPrice() {
			var list = $(".productContainer dd>label>input[type='checkbox']:checked").parent().parent().find(".productInfo>li:nth-child(3)");
			var unival;
			var shopNum;
			var totolNum = 0; //商品数量
			var totolPrice = 0; //总价
			var Tn = $(".productContainer dd>label>input[type='checkbox']:checked").length; //选中商品的数量
			for(var i = 0; i < list.length; i++) {
				unival = list[i].children[0].innerHTML;
				shopNum = list[i].children[1].children[1].innerHTML;
				totolNum += Number(shopNum);
				totolPrice += Number(unival) * Number(shopNum);
			}
			//			$(".cartImg>i").html(totolNum);
			$(".totoal").html("¥" + totolPrice.toFixed(2));
			$(".blance").html("结算(" + Tn + ")");
		var cart_arr = new Array();
		var i = 0;
		var lists = $(".productContainer dd>label>input[type='checkbox']:checked");
		lists.each(function(index, el) {
			cart_arr[i] = $(this).attr('value');
			i++;
		});
		cart_ids = cart_arr.join(',');
		$("input[name='cart_ids']").val(cart_ids);
		}
		totalPrice();

		function letDivCenter(divName) {
			var top = ($(window).height() - $(divName).height()) / 2;
			var left = ($(window).width() - $(divName).width()) / 2;
			var scrollTop = $(document).scrollTop();
			var scrollLeft = $(document).scrollLeft();
			$(divName).css({
				position: 'absolute',
				'top': top + scrollTop,
				left: left + scrollLeft
			})
		}
			//订单结算
	$('.blance').click(function(){
		if($("input[name='cart_ids']").val()){
			$(this).children('input').remove();
			$("form").submit();
		}else{
			alert("请选择结算商品!");
		}
		
	})
	});
</script>