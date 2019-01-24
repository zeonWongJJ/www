$(function(){
	//点击添加按钮显示弹框
	$('.picture .addBtn a').click(function(){
		$('.lightGrey').show();
		$('.putinBomb').show();
//		var shux = $('.temCur').text();
		var upr = $('.cupCur').text();
//		$('#shux').val(upr+'/'+shux);
		$(".putinBomb").each(function(i){	
   			var p1=$(".putinBomb").eq(i).find(".temperature").eq(1).find(".temType>i.temCur").html();
   			var p2=$(".putinBomb").eq(i).find(".temperature").eq(2).find(".temType>i.temCur").html();	
   			if( $(".putinBomb").eq(i).find(".temperature").length==1 ){
				console.log(1)
				$('#shux').val(upr);	
			}else if( $(".putinBomb").eq(i).find(".temperature").length==2 ){
				$('#shux').val(upr+'/'+p1);
				console.log(2)
			}else if( $(".putinBomb").eq(i).find(".temperature").length==3 ){
				$('#shux').val(upr+'/'+p1+'/'+p2);
				console.log(3)
			}
   		});
	});
	
	//关闭弹窗
	$('.putinBomb .close').click(function(){
		$('.putinBomb').hide();
		$('.lightGrey').hide();
	})
	
	//选择杯型
	$('.cup .temType i').click(function(){
		var upr = $(this).attr('value');
		$('#pric').val(upr);
		var goods = $('#goods').attr('value');
		$.ajax({
            type : 'post',
            url  : 'list_price',
            data : {cup:upr,goods:goods},
            dataType : 'json',
            success  : function(data) {
                $('.pShu').html(data.price);
                $('#money').val(data.price);
            }
        })
		$(this).addClass('cupCur').siblings().removeClass('cupCur');
//		var shux = $('.temCur').text();
		var upr = $('.cupCur').text();
		$(".putinBomb").each(function(i){
			var p1=$(".putinBomb").eq(i).find(".temperature").eq(1).find(".temType>i.temCur").html();
   			var p2=$(".putinBomb").eq(i).find(".temperature").eq(2).find(".temType>i.temCur").html();	
			if( $(".putinBomb").eq(i).find(".temperature").length==1 ){
				console.log(1)
				$('#shux').val(upr);	
			}else if( $(".putinBomb").eq(i).find(".temperature").length==2 ){
				$('#shux').val(upr+'/'+p1);
				console.log(2)
			}else if( $(".putinBomb").eq(i).find(".temperature").length==3 ){
				$('#shux').val(upr+'/'+p1+'/'+p2);
				console.log(3)
			}
	
   		});
	})
	
	
	//选择温度
	$('.temperature1 .temType i').click(function(){
		$(this).addClass('temCur').siblings().removeClass('temCur');
		var shux,ahux;
		var upr = $('.cupCur').text();
	})
	
	$(".putinBomb").each(function(i){	
			var upr = $('.cupCur').text();
   			$(".putinBomb").eq(i).find(".temperature").eq(1).find(".temType>i").click(function(){
   				var nextVal=$(this).parent().parent().next().find(".temType>i.temCur");
   				if( $(".putinBomb").eq(i).find(".temperature").length==2 ){
					$('#shux').val(upr+'/'+$(this).html());
					console.log(2)
				}else if( $(".putinBomb").eq(i).find(".temperature").length==3 ){
					$('#shux').val(upr+'/'+$(this).html()+'/'+nextVal.html());
					console.log(3)
				}
   				
   			});
   			$(".putinBomb").eq(i).find(".temperature").eq(2).find(".temType>i").click(function(){
   				var prevVal=$(this).parent().parent().prev().find(".temType>i.temCur");
   				console.log("vv");
   				if( $(".putinBomb").eq(i).find(".temperature").length==2){
					$('#shux').val(upr+'/'+$(this).html());
					console.log(2)
				}else if( $(".putinBomb").eq(i).find(".temperature").length==3 ){
					$('#shux').val(upr+'/'+prevVal.html()+'/'+$(this).html());
					console.log(3)
				}
   			})
   			/*$(".putinBomb").eq(i).find(".temperature").each(function(j){
   				$(".putinBomb").eq(i).find(".temperature").eq(j).find(".temType>i").click(function(){
   				 	var nextVal=$(this).parent().parent().next().find(".temType>i.temCur");
   					if( $(".putinBomb").eq(i).find(".temperature").length==2 ){
						$('#shux').val(upr+'/'+$(this).html());
						console.log(2)
					}else if( $(".putinBomb").eq(i).find(".temperature").length==3 ){
						$('#shux').val(upr+'/'+$(this).html()+'/'+nextVal.html());
						console.log(3)
					}
   				})
   			})*/
   	})
	// //选择添加的果肉
	// $('body').on('click','.add .temType i',function(){
	// 	if($(this).hasClass('addCur')){
	// 		$(this).removeClass('addCur');
	// 	}else{
	// 		$(this).addClass('addCur');
	// 	}
	// })
	

	//添加数量
	$('.quantity .numBox .more').click(function(){
		var nTxt = Number($(this).siblings('.num').text())+1;
		$(this).siblings('.num').text(nTxt);
		$('#num').val(nTxt);		
	})
	//减少数量
	$('.quantity .numBox .less').click(function(){
		var yTxt = $(this).siblings('.num').text();
		var nTxt = Number($(this).siblings('.num').text())-1;
		$(this).siblings('.num').text(nTxt);
		$('#num').val(nTxt);
		if(yTxt == 1){
			$(this).siblings('.num').text('1');
			$('#num').val('1');
		}
	});
	
//	加
	//小图ul宽度
	var liLen = $('.picture .picList li').length;
	var ulWidth = liLen * 25;
	$('.picture .picList ul').css('width',''+ulWidth+'%');
	//点击小图显示大图弹框
	$('.picList li').click(function(){
		var liIndex = $(this).index();
		$('.shade').show();
		$('.picBomb').show();
		$('.picBomb .picShow ul li').eq(liIndex).addClass('show').siblings().removeClass('show');
	})
	//关闭大图弹框
	$('.picBomb .close2 a').click(function(){
		$('.shade').hide();
		$('.picBomb').hide();
	})
	//点击右键
	$('.picBomb .picWrap .right').click(function(){
		$('.picBomb .picShow ul li.show').next().addClass('show').siblings().removeClass('show');		
	});
	
	//点击左键
	$('.picBomb .picWrap .left').click(function(){
		$('.picBomb .picShow ul li.show').prev().addClass('show').siblings().removeClass('show');		
	})
	
	//点击分享
	// $('.head .share').click(function(){
	// 	$('.shade').show();
	// 	$('.shareBomb').show();
	// })
	//关闭弹框
	$('.shareBomb .cancel a').click(function(){
		$('.shade').hide();
		$('.shareBomb').hide();
	})
	
//	加
	//点击收藏改变颜色
	$('.control .collect').click(function(){
		var goods = $(this).attr('value');
		if($(this).hasClass('cCur')){
			$.ajax({
				type : 'post',
				url  : 'item_colle',
				data : {goods:goods},
				dataType : 'json',
				success  : function (data) {
					if (data.code == 200) {
					};
				}
			})
			$(this).removeClass('cCur');
			$(this).find('img').attr('src','static/style_default/images/fa.png');			
		}else{
			$.ajax({
				type : 'post',
				url  : 'item_colle',
				data : {goods:goods},
				dataType : 'json',
				success  : function (data) {
					if (data.code == 200) {
					};
				}
			})			
			$(this).addClass('cCur');
			$(this).find('img').attr('src','static/style_default/images/unfavourite.png');
		}
	})

	// 加入购物车
	$('.addCar').click(function(){
		var goods = $('#goods').attr('value');
        var manoe = $('#money').attr('value');
        var shuxi = $('#shux').attr('value');
        var tost  = $('#stuo_id').attr('value');
        var name  = $('#store').attr('value');
        var spec  = $("#pric").attr('value');
        var oute  = $('#num').attr('value');
        var share_userid  = $('#share_userid').attr('value');
        $.ajax({
            type : 'post',
            url  : 'shop_add',
            data : {tost:tost,goods:goods,manoe:manoe,shuxi:shuxi,name:name,spec:spec,oute:oute,share_userid:share_userid},
            dataType : 'json',
            success  : function(data) {
                if (data.code == 200) {
                	// window.location.reload();
                	// alert('添加购物车成功！');
                	$('.putinBomb').hide();
                	$('.lightGrey').hide();
                };
            }
        })
	})
	
})
