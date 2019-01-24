$(function(){
	var top;
	$(".lay").height($(document).height());
    $(".lay").hide();
    $(".spec").hide();
    $(".shopCart").hide();
    $(".tips").hide();
	//点击遮罩层关闭
	$(".lay").click(function(){
		top = $(window).scrollTop();
		$("body").css("top",top);
        $(this).hide();
        $(this).css("z-index","1");
        $(".spec").hide(200);
        $(".yuan").removeClass("show");
        $(".shopCart").slideUp(200);
        $(".tips").hide(200);
        $("body").removeClass("ovfHiden");
    });

	//点击加入购物车
    $(".joinCart").live("click",function(){
    	var $this=$(this);
        $(".lay").show();
        setDivCenter($(".spec"));
		if( $(".spec>.choiceBox>ul>li").length==1 ){
			$(".shopPrice>em").html( $(".spec>.choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html() );
            $('#xuic').val($(".spec>.choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html());
		}else if( $(".spec>.choiceBox>ul>li").length==2 ){
			$(".shopPrice>em").html( $(".spec>.choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$(".spec>.choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html() );
             $('#xuic').val($(".spec>.choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$(".spec>.choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html() );
		}else if( $(".spec>.choiceBox>ul>li").length==3 ){
			$(".shopPrice>em").html( $(".spec>.choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$(".spec>.choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html()+"/"+$(".spec>.choiceBox>ul>li:nth-child(3)>a.choiceCur>span").html() );
             $('#xuic').val($(".spec>.choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$(".spec>.choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html()+"/"+$(".spec>.choiceBox>ul>li:nth-child(3)>a.choiceCur>span").html() );
		}
    });

	$(".choiceBox>ul>li").each(function(i){
		var $this=$(this);
		$this.addClass("c"+i);
		$(".c"+i+">a").live("click",function(){
			$(this).addClass("choiceCur");
			$(".c"+i+">a").not($(this)).removeClass("choiceCur");
			if( $(".spec>.choiceBox>ul>li").length==1 ){
			$(".shopPrice>em").html( $(".spec>.choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html() );
             $('#xuic').val($(".spec>.choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html() );
		}else if( $(".spec>.choiceBox>ul>li").length==2 ){
			$(".shopPrice>em").html( $(".spec>.choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$(".spec>.choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html() );
             $('#xuic').val($(".spec>.choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$(".spec>.choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html() );
		}else if( $(".spec>.choiceBox>ul>li").length==3 ){
			$(".shopPrice>em").html( $(".spec>.choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$(".spec>.choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html()+"/"+$(".spec>.choiceBox>ul>li:nth-child(3)>a.choiceCur>span").html() );
             $('#xuic').val($(".spec>.choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$(".spec>.choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html()+"/"+$(".spec>.choiceBox>ul>li:nth-child(3)>a.choiceCur>span").html() );
		}
            var cup   = $(".spec>.choiceBox>ul>li:nth-child(1)>a.choiceCur").attr('value');
            var goods = $('.product_id').attr('value');
            $.ajax({
                type : 'post',
                url  : 'list_price',
                data : {cup:cup,goods:goods},
                dataType : 'json',
                success  : function(data) {
                   $('#manoe').html(data.price);
                }
            }) 
        });
	});

    $(".closeSpec").click(function(){
        $(".lay").hide();
        $(".lay").css("z-index","1");
        $(".spec").hide(100);
		$(".spec>.cupSize").removeClass("cuptt");
        $(".spec>#xuic").removeClass('xuic');
		$(".spec>.shopPrice").removeClass('ppt');
		$(".spec>#ouate").removeClass('ouate');
        $(".spec>p").removeClass('goodsid');
     	$("body").removeClass("ovfHiden");
    });
    usorep();  
    //点击购物车
    $(".yuan").click(function(){
        var ddTol=0;
        var usore = $('#pjoTitle').attr('value');
        $.ajax({
            type : 'post',
            url  : 'shop_inex',
            data : {usore:usore},
            dataType : 'json',
            success  : function(data) {
                // console.log(data);
                if(data.code == 200) {
                    var html = "";
                    html += '<dl>'
                        +'<dt class="cartTitle">'
                            +'<span>已选商品</span>'
                            +'<em class="clearCart" onclick="qinh();">清空</em>'
                        +'</dt>';
                        for(var it in data.data.goods){
                            html += '<dd class="cartList html_'+data.data.goods[it].cart_id+'">';
                                html += '<div class="commodity">';
                                    html += '<p>'+data.data.goods[it].product_name+'</p>';
                                    html += '<span>'+data.data.goods[it].shux_name+'</dfn>';
                                html += '</div>';
                                html += '<div class="shopPriceBox">';
                                    html += '<span class="shopNumPrice">￥<em>'+data.data.goods[it].money+'</em></span>';
                                    html += '<em class="shopNum">';
                                        html += '<img class="reduce" src="static/style_default/images/add_03.png" alt="" onclick="reduce('+data.data.goods[it].cart_id+');"/>';
                                        html += '<span id="ou_'+data.data.goods[it].cart_id+'">'+data.data.goods[it].prot_count+'</span>';
                                        html += '<img class="add" src="static/style_default/images/add_05.png" alt="" onclick="add('+data.data.goods[it].cart_id+');"/>';
                                    html += '</em>';
                                html += '</div>';
                            html += '</dd>';
                        };
                     html += '<dt class="shopText">商品如需分开打包，请在下单时备注</dt>';
                   html += '</dl>';
                   $('.shopCart').html(html);
                }
            }
        })
        
        
        if( $(this).hasClass("show") ){
            $(this).removeClass("show");
            $(".lay").hide();
            $(".bottom").css("z-index","1");
            $(".shopCart").slideUp(200);
            top = $(window).scrollTop();
			$("body").css("top",top);
          	$("body").removeClass("ovfHiden");
        }else{
            $(".shopCart>dl>dd").each(function(i){
                var ddLen=$(".shopCart>dl>dd").eq(i).length;
                ddTol=ddTol+ddLen;
            });
            	$(".yuan>i").show();
                $(this).addClass("show");
                $(".lay").show();
                $(".bottom").css("z-index","3");
                $(".shopCart").slideDown(200);
                top = $(window).scrollTop();
//           	$("body").addClass("ovfHiden");
             	top = $(window).scrollTop();
             	$(".body").css("top",-top);
             	$("body").addClass("ovfHiden");
             	$(".shopCart").css("overflow","scroll");
        }
    });

    //清空购物车
    $(".clearCart").click(function(){
    	setDivCenter($(".tips"));
//      $(".tips").show(100);
    });
    $(".cancelClear").click(function(){
        $(".tips").hide(100);
    });
    $(".sureClear").click(function(){
        var stoue = $(this).attr('value');
        $.ajax({
            type : 'post',
            url  : 'shop_delete',
            data : {stoue:stoue},
            dataType : 'json',
            success  : function (data) {
                // console.log(data);
                if (data.code == 200) {
                    $(".shopCart>dl>dd").remove();
                    $(".shopCart").hide();
                    $(".tips").hide(100);
                    $(".yuan>i").html(0);
//                  $(".yuan>i").hide();
                    $(".lay").hide();
                    $('#poutt').text(0);
                };
            }
        })
        top = $(window).scrollTop();
        $(".yuan").removeClass("show");
		$("body").css("top",top);
        $("body").removeClass("ovfHiden");
    });
    
    // 添加购物车
    $(".cart").click(function(){
        var goods = $('.product_id').attr('value');
        var manoe = $("#manoe").text();
        var shuxi = $('#xuic').attr('value');
        var tost  = $('#pjoTitle').attr('value');
        var name  = $('#store_name').attr('value');
        var spec  = $('.choiceCur').attr('value');
        $.ajax({
            type : 'post',
            url  : 'shop_add',
            data : {tost:tost,goods:goods,manoe:manoe,shuxi:shuxi,name:name,spec:spec,oute:1},
            dataType : 'json',
            success  : function(data) {
                if (data.code == 200) {
                    $(".lay").hide();
                    $(".spec").hide(100);
                    usorep();
                };
            }
        });
        top = $(window).scrollTop();
        $("body").css("top",top);
        $("body").removeClass("ovfHiden");
    });
    
 	$(".shopPrice>em").html($(".cupCur").html()+"");
 	$(".shopPrice>dfn").html($(".terCur").html());
 	$(".shopPrice>s").html($(".feedCur").html());
 	
 	//让指定的DIV始终显示在屏幕正中间  
    function setDivCenter(divName){  
        var top = ($(window).height() - divName.height())/4;  
        var left = ($(window).width() - divName.width())/2;  
        var scrollTop = $(document).scrollTop();  
//      var scrollLeft = $(document).scrollLeft();  
        divName.css( { 'top' : top + scrollTop } ).show(); 
    }
	
	
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
	$('.head .share').click(function(){
		$('.shade').show();
		$('.shareBomb').show();
	})
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

	
	
})
