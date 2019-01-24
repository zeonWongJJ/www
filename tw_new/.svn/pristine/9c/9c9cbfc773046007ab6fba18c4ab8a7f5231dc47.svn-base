<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>产品搜索</title>
		<link rel="stylesheet" type="text/css" href="./static/style_default/style/common.css"/>
		<script src="./static/style_default/plugin/jquery-3.1.1.min.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
		<style type="text/css">
			.body{font-size: .14rem;height: 100%;background: #fff;overflow-y: auto;}
			.header{display: flex;justify-content: space-between;align-items: center;padding: .1rem;border-bottom: 1px solid #f4f4f4;}
			.header .left{width: .25rem;height: .1rem;background: url(./static/style_default/images/yongping_03.png) no-repeat;background-size: .25rem .1rem;background-position: center;}
			.header .search{width: 2.84rem;height: .33rem;background: #f4f4f4;display: flex;align-items: center;border-radius: .165rem;padding:0 .1rem 0 .2rem;}
			.header .search #search{height: 100%;width: 100%;background: #f4f4f4;padding:0 .1rem;}
			.header .search .search_logo{width: .2rem;height: .2rem;background: url(./static/style_default/images/search2.png) no-repeat;background-size: .16rem .15rem;background-position: center;}
			.header .search .empty{width: .2rem;height: .2rem;background: url(./static/style_default/images/empty.png) no-repeat;background-size: .15rem .15rem;background-position: center;}
			.center{padding: .1rem;}
			.center .history .title{display: flex;justify-content: space-between;align-items: center;padding: .1rem 0;}
			.center .history .title .delete{width: .2rem;height: .2rem;background: url(./static/style_default/images/delete.png) no-repeat;background-size: .13rem .14rem;background-position: center;}
			.center .hot .title{padding: .1rem 0;}
			.center .foods{display: flex; flex-wrap:wrap;}
			.center .foods .food{padding: .1rem;background: #f4f4f4;margin: 0 .1rem .1rem 0;}
			
			.clickList{display: none;}
			.clickList .list{padding: .15rem .1rem;border-bottom: 1px solid #F4F4F4;}
			
			.searchList .food{display: flex;justify-content: space-between;padding: .1rem;background: #fff;margin-bottom: .1rem;}
			.searchList .food .img{width: .75rem;height: .75rem;background: #A0A0A0; border-radius: .025rem;flex: 0 0 .75rem;margin-right: .1rem;}
			.searchList .food .img>img{width: 100%;height: auto;}
			.searchList .food .other{display: flex;flex-direction: column;justify-content: space-between;flex: 1;}
			.searchList .food .other .info{font-size: .11rem;}
			.searchList .food .other .sale{color: #333333;}
			.searchList .food .other .priceBox{font-size: .16rem;display: flex;justify-content: space-between;align-items: center;color: #999999;}
			.searchList .food .other .price{color: #fe563c;}
			.searchList .food .other .add{width: .3rem;height: .3rem;background: url(./static/style_default/images/add.png) no-repeat;background-size:.2rem .2rem;background-position: center;}
			.c_gray{color: #666666;}
			
		</style>
	</head>
	<body>
		<div class="body">
			<!--头部-->
			<div class="header">
				<a class="left" href="javascript:history.back(-1);"></a>
				<div class="search">
					<div class="search_logo"></div>
					<input type="" name="" id="search" value="" onkeydown="entersearch1(event)" placeholder="搜索你要的商品" />
					<div class="empty"></div>
				</div>
				<div class="right" onclick="search()">搜索</div>
			</div>
			
			<!--默认显示-->
			<div class="center">
				<div class="hot">
					<div class="title">热门推荐</div>

					<div class="foods">
				<?php foreach ($a_view_data['product'] as $key => $val): ?>
				<a href="item-<?php echo $val['proid_id_1'];?>-<?php echo $val['product_id'];?>" class="food"><?php echo $val['product_name'];?></a>
				
				 <?php endforeach ?>
					</div>
				</div>
				<div class="history">
					<div class="title">
						<div>最近搜索</div>
						<div class="delete search_del"></div>
					</div>
					<div class="foods searchFoods">
						<?php foreach ($a_view_data['history'] as $key => $val): ?>
						<div class="food his_foods"><?php echo $val['user_seasrch'];?></div>
						<!-- <div class="food">鸳鸯咖啡</div>
						<div class="food">鸳鸯咖啡</div>
						<div class="food">鸳鸯咖啡</div>
						<div class="food">鸳鸯咖啡</div>
						<div class="food">鸳鸯咖啡</div> -->
						<?php endforeach ?>
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
	var clickList = [
		{
			id:1,
			name:'摩卡咖啡'
		},
		{
			id:2,
			name:'鸳鸯咖啡'
		},
	] 
	
	var searchList = [
		{
			id:1,
			name:'柚子冰红茶',
			info:'香浓摩卡酱与咖啡原液，在牛奶加冰 块中绽放快乐',
			sale:3,
			good:98,
			price:32,
			src:'./static/style_default/images/add.png'
		},
		{
			id:2,
			name:'桂花茶',
			info:'香浓摩卡酱与咖啡原液，在牛奶加冰 块中绽放快乐',
			sale:30,
			good:100,
			price:32,
			src:'./static/style_default/images/add.png'
		}
	]
	$(function(){
		// $('.body .center').on('click','.food',function(){
		// 	$('.center').hide();
		// 	var list = ''
		// 	$.each(clickList,function(idx,obj){
		// 		list += '<div class="list" id="'+obj.id+'">'+obj.name+'</div>'
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
	// function search(){
	// 	if($('#search').val() != ''){
	// 		$('.center').hide();

	// 		//渲染产品
	// 		var food = '';
	// 		$.each(searchList,function(idx,obj){
	// 			food += '<div class="food">'+
	// 						'<div class="img"><img src="'+obj.src+'" alt=""></div>'+
	// 						'<div class="other">'+
	// 							'<div class="name font_w">'+obj.name+'</div>'+
	// 							'<div class="info c_gray">'+obj.info+'</div>'+
	// 							'<div class="sale"> 月售'+obj.sale+'    好评率'+obj.good+'% </div>'+
	// 							'<div class="priceBox">'+
	// 								'<div><span class="price">￥'+obj.price+'</span>起</div>'+
	// 								'<div class="add" id='+obj.id+'></div>'+
	// 							'</div>'+
	// 						'</div>'+
	// 					'</div>'
	// 		})
	// 		//清空再添加
	// 		$('.searchList').empty().append(food);
	// 	}else{
	// 		alert('请填写关键字')
	// 	}
	// }
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
	$(document).on("click",".empty",function(){
		$("#search").val("");
	})

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

	function entersearch(){  
    var event = window.event || arguments.callee.caller.arguments[0];  
    if (event.keyCode == 13)  
       {  
          search();  
       }  
}  
  
// 按Enter键,执行事件  
function entersearch1(event){  
    if (event.keyCode == 13)  
       {  
          search();  
       }  
} 
</script>