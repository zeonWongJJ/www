/**
 * Created by 7du-29 on 2017/12/1.
 */
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

    $(".choiceSpec").live("click",function(e){
    	top = $(window).scrollTop();
    	e.preventDefault();
        var id = $(this).attr('value');
        $(".lay").show();
        $(".li_"+id).css("z-index","2");
//      $(".li_"+id).show();
        setDivCenter($(".li_"+id));
        $(".li_"+id).find(".cupSize").addClass("cuptt");
        var cup  = $(".li_"+id).find('.cupSize>.cupCur>span').text();
		var shux = $(".li_"+id).find('.temperature').eq(0).find(".terCur>span").length;
		var ahux = $(".li_"+id).find('.temperature').eq(1).find(".terCur>span").length;
		// console.log(shux);
        var ttd = '';
        var tta = '';
        for (var i = 0; i < shux; i++) {
            ttd += '/';
            tta += '/';
            ttd += $(".li_"+id).find(".shux_"+[0]).find('.terCur>span').text();
            tta += $(".li_"+id).find(".shux_"+[1]).find('.terCur>span').text();
            $(".li_"+id).find(".shux_"+i).addClass('shuxi');
        };
        $(".li_"+id).find('.shopPrice>em').html(cup);
        $(".li_"+id).find('.shopPrice>dfn').html(ttd);
        $(".li_"+id).find('.shopPrice>s').html(tta);
        $(".li_"+id).find("#goodsid").addClass('goodsid');
        $(".li_"+id).find("#ouate").addClass('ouate');
        $(".li_"+id).find("#xuic").addClass('xuic');
        $(".li_"+id).find(".shopPrice").addClass('ppt');
        $(".li_"+id).find("#xuic").val(cup+ttd+tta);
     	$("body").addClass("ovfHiden");
     	$("body").css("top",-top);
    });

    //选择杯型大小    
    $(".spec>div.cupSize>a").click(function(){
    	$(this).addClass("cupCur");
        $(".cuptt>a").not($(this)).removeClass("cupCur");
        var name = $(".cuptt").find('.cupCur span').text();
        $(".shopPrice>em").html(name);
        var ttd = $('.shopPrice>dfn').html();
        var tta = $('.shopPrice>s').html();
        $(".xuic").val(name+ttd+tta);
        var cup = $(this).attr('value');
        var goods = $('.goodsid').attr('value');
        // console.log(goods);
        $.ajax({
            type : 'post',
            url  : 'list_price',
            data : {cup:cup,goods:goods},
            dataType : 'json',
            success  : function(data) {
                $('.ppt>#ouate').html('￥'+data.price);
            }
        })
    })
   
    // 属性
    $(".temperature>a").click(function(){
        $(this).addClass("terCur").siblings().removeClass("terCur") ;
    })


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
        var usore = $('.pjoTitle').attr('value');
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
          /* if( ddTol<=0 ){
                $(".yuan>i").hide();
                $(".shopCart").slideUp(200);
                $(".lay").hide();
            }else{
                $(".yuan>i").show();
                $(this).addClass("show");`
                $(".lay").show();
                $(".shopCart").slideDown(200);               
            }*/
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
		$("body").css("top",top);
        $("body").removeClass("ovfHiden");
    });
    //加入购物车
    /*$(".cart").click(function(){
        var goods = $('.goodsid').attr('value');
		var manoe =$(this).prev().prev().find(".ouate").text();
        console.log(manoe);
        manoe = manoe.slice(1, manoe.length);
        var shuxi = $('.xuic').attr('value');
        var tost  = $('.pjoTitle').attr('value');
        var name  = $('#store_name').attr('value');
        var spec  = $(".cuptt").find('.cupCur').attr('value');
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
        })
        window.document.ontouchmove = move;
    });*/
    $(".cart").each(function(i){
//  	$(".lay").css("z-index","1");
    	$(this).click(function(){
    		var goods = $(this).parent().find('.goodsid').attr('value');
			var manoe = $(this).parent().find("#ouate").text();
        	manoe = manoe.slice(1, manoe.length);
        	var shuxi = $('.xuic').attr('value');
        	var tost  = $('.pjoTitle').attr('value');
        	var name  = $('#store_name').attr('value');
        	var spec  = $(".cuptt").find('.cupCur').attr('value');
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
    })
    
 	$(".spec").each(function(i){
   		$(".spec").eq(i).find(".temperature").eq(0).click(function(){
   			$(".shopPrice>dfn").html("/"+$(this).children("a.terCur").children("span").html());
// 			$(".shopPrice>s").html("/"+$(this).next().children("a.terCur").children("span").text());
			$(this).next().next().next().val($(this).prev().find('.cupCur>span').html()+'/'+$(this).children("a.terCur").children("span").html()+'/'+($(this).next().find("a.terCur>span").html()));
   		});
   		$(".spec").eq(i).find(".temperature").eq(1).click(function(){
// 			$(".shopPrice>dfn").html("/"+$(this).prev().children("a.terCur").children("span").text());
   			$(".shopPrice>s").html("/"+$(this).children("a.terCur").children("span").html());   			
   			$(this).next().next().val($(this).prev().prev().find('.cupCur>span').html()+'/'+($(this).prev().find("a.terCur>span").html())+'/'+$(this).children("a.terCur").children("span").html());
   		});
   	})
 	
 	//让指定的DIV始终显示在屏幕正中间  
    function setDivCenter(divName){  
        var top = ($(window).height() - divName.height())/4;  
        var left = ($(window).width() - divName.width())/2;  
        var scrollTop = $(document).scrollTop();  
//      var scrollLeft = $(document).scrollLeft();  
        divName.css( { 'top' : top + scrollTop } ).show(); 
    }
	
	

	/*$(window).bind("load", function() {
        var footerHeight = 0,
        footerTop = 0,
        $footer = $(".bottom");
        positionFooter();
		//定义positionFooter function
       	function positionFooter() {
		//取到div#footer高度
        footerHeight = $footer.height();
		//div#footer离屏幕顶部的距离
        footerTop = ($(window).scrollTop()+$(window).height()-footerHeight)+"px";     
		//如果页面内容高度小于屏幕高度，div#footer将绝对定位到屏幕底部，否则div#footer保留它的正常静态定位
        if ( ($(document.body).height()+footerHeight) > $(window).height()) {
            $footer.css({
                position: "absolute"
            }).stop().animate({
                top: footerTop
            },0);
        } else {
             	$footer.css({
                    position: "static"
                });
            }
        }
        $(window).scroll(positionFooter).resize(positionFooter);
    });*/
});

 	  















