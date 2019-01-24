/**
 * Created by 7du-29 on 2017/12/1.
 */
$(function(){
	var top;
	$(".lay").height($(document).height());
	$(".cartLay").height($(document).height());
    $(".lay").hide();
    $(".cartLay").hide();
    $(".spec").hide();
    $(".shopCart").hide();
    $(".tips").hide();
    
	//点击遮罩层关闭
	$(".lay").click(function(){
		top = $(window).scrollTop();
		$("body").css("top",top);
        $(this).hide();
        $(this).css("z-index","1");
        $(".spec").hide();
//      $(".yuan").removeClass("show");
//      $(".shopCart").hide();
        $(".tips").hide();
        $("body").removeClass("ovfHiden");
        
    });
    

    $(".choiceSpec").live("click",function(e){
    	var $this=$(this);
    	var liList=$this.parent().parent().parent().next();
    	var goods = $this.attr('value');
    	top = $(window).scrollTop();
    	e.preventDefault();
        $(".lay").show();
        $(".li_"+goods).css("z-index","2");
        setDivCenter($(".li_"+goods));
        console.log($this);
      	if( liList.find(".choiceBox>ul>li").length==1 ){
        		$(".shopPrice>em").html( liList.find("li:nth-child(1)>a.choiceCur>span").html() );
                $("#xuic").val( liList.find("li:nth-child(1)>a.choiceCur>span").html() );
        }else if( liList.find(".choiceBox>ul>li").length==2 ){
        		// console.log("ss");
        		$(".shopPrice>em").html( liList.find("li:nth-child(1)>a.choiceCur>span").html()+"/"+liList.find("li:nth-child(2)>a.choiceCur>span").html() );
                $("#xuic").val( liList.find("li:nth-child(1)>a.choiceCur>span").html()+"/"+liList.find("li:nth-child(2)>a.choiceCur>span").html() );
        }else if( liList.find(".choiceBox>ul>li").length==3 ){
        		
        		$(".shopPrice>em").html( liList.find("li:nth-child(1)>a.choiceCur>span").html()+"/"+liList.find("li:nth-child(2)>a.choiceCur>span").html()+"/"+liList.find("li:nth-child(3)>a.choiceCur>span").html() );
                $("#xuic").val(liList.find("li:nth-child(1)>a.choiceCur>span").html()+"/"+liList.find("li:nth-child(2)>a.choiceCur>span").html()+"/"+liList.find("li:nth-child(3)>a.choiceCur>span").html() );
        }
    });

    $(".choiceBox>ul>li").each(function(i){
    	var $this=$(this);
    	$this.addClass("c"+i);
    	$(".c"+i+">a").live("click",function(){
    		$(this).addClass("choiceCur");
            $(".c"+i+">a").not($(this)).removeClass("choiceCur");
            // console.log( $this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)") );
            if( $this.parent().parent().parent().find(".choiceBox>ul>li").length==1 ){
            	$(".shopPrice>em").html( $this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html() );
                $("#xuic").val($this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html() );
            }else if( $this.parent().parent().parent().find(".choiceBox>ul>li").length==2 ){
            	$(".shopPrice>em").html( $this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html() );
                $("#xuic").val($this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html() );
            }else if( $this.parent().parent().parent().find(".choiceBox>ul>li").length==3 ){
            	$(".shopPrice>em").html( $this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html()+"/"+$this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(3)>a.choiceCur>span").html() );
                $("#xuic").val($this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html()+"/"+$this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(3)>a.choiceCur>span").html() );
            }
            var cup   = $this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)>a.choiceCur").attr('value');
            var goods = $this.parent().parent().parent().find('.product_id').attr('value');
            $.ajax({
                type : 'post',
                url  : 'list_price',
                data : {cup:cup,goods:goods},
                dataType : 'json',
                success  : function(data) {
                   $this.parent().parent().parent().find('#manoe').html(data.price);
                }
            }) 
    	});
    });


    $(".closeSpec").click(function(){
        $(".lay").hide();
        $(".lay").css("z-index","1");
        $(".spec").hide();
		$(".spec>.cupSize").removeClass("cuptt");
        $(".spec>#xuic").removeClass('xuic');
		$(".spec>.shopPrice").removeClass('ppt');
		$(".spec>#ouate").removeClass('ouate');
        $(".spec>p").removeClass('goodsid');
     	$("body").removeClass("ovfHiden");
    });
    usorep();  
    //点击购物车
    $(".yuan").click(function() {
	var $this = $(this);
	var ddTol = 0;
	var usore = $('.pjoTitle').attr('value');

	function save() {
		if($this.hasClass("show")) {
			$this.removeClass("show");
			$(".cartLay").hide();
			$(".bottom").css("z-index", "1");
			$(".shopCart").slideUp(100);
//			$(".shopCart").hide();
			top = $(window).scrollTop();
			$("body").css("top", top);
			$("body").removeClass("ovfHiden");

		} else {

			$(".shopCart>dl>dd").each(function(i) {
				var ddLen = $(".shopCart>dl>dd").eq(i).length;
				ddTol = ddTol + ddLen;
			});
			$(".yuan>i").show();
			$this.addClass("show");
			$(".cartLay").show();
			$(".bottom").css("z-index", "3");
			$(".shopCart").slideDown(100);
//			$(".shopCart").show();
			top = $(window).scrollTop();
			$(".body").css("top", -top);
			$("body").addClass("ovfHiden");
			$(".shopCart").css("overflow", "scroll");
		}
	}

	$.ajax({
		type: 'post',
		url: 'shop_inex',
		data: {
			usore: usore
		},
		dataType: 'json',
		success: function(data) {

			if(data.code == 200) {
				save();
				var html = "";
				html += '<dl>' +
					'<dt class="cartTitle">' +
					'<span>已选商品</span>' +
					'<em class="clearCart" onclick="qinh();">清空</em>' +
					'</dt>';
				for(var it in data.data.goods) {
					html += '<dd class="cartList html_' + data.data.goods[it].cart_id + '">';
					html += '<div class="commodity">';
					html += '<p>' + data.data.goods[it].product_name + '</p>';
					html += '<span>' + data.data.goods[it].shux_name + '</dfn>';
					html += '</div>';
					html += '<div class="shopPriceBox">';
					html += '<span class="shopNumPrice">￥<em>' + data.data.goods[it].money + '</em></span>';
					html += '<em class="shopNum">';
					html += '<img class="reduce" src="static/style_default/images/add_03.png" alt="" onclick="reduce(' + data.data.goods[it].cart_id + ');"/>';
					html += '<span id="ou_' + data.data.goods[it].cart_id + '">' + data.data.goods[it].prot_count + '</span>';
					html += '<img class="add" src="static/style_default/images/add_05.png" alt="" onclick="add(' + data.data.goods[it].cart_id + ');"/>';
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

});

   
   
    $(".cancelClear").click(function(){
    	$("body").removeClass("ovfHiden");
        $(".tips").hide();
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
                    $(".tips").hide();
                    $(".yuan>i").html(0);
//                  $(".yuan>i").hide();
                    $(".cartLay").hide();
                    $('#poutt').text(0);
                };
            }
        })
        top = $(window).scrollTop();
        $(".yuan").removeClass("show");
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
    		var goods = $(this).parent().find('.product_id').attr('value');
            var manoe = $(this).parent().find("#manoe").text();
            // manoe = manoe.slice(1, manoe.length);
            var shuxi = $('#xuic').attr('value');
            var tost  = $('.pjoTitle').attr('value');
            var name  = $('#store_name').attr('value');
            var spec  = $(this).parent().find('.choiceCur').attr('value');
            console.log(goods);
        	$.ajax({
            	type : 'post',
            	url  : 'shop_add',
            	data : {tost:tost,goods:goods,manoe:manoe,shuxi:shuxi,name:name,spec:spec,oute:1},
            	dataType : 'json',
            	success  : function(data) {
                	if (data.code == 200) {
                    	$(".lay").hide();
                    	$(".spec").hide();
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
 	
 	
	 
});

 	  //让指定的DIV始终显示在屏幕正中间  
    function setDivCenter(divName){  
        var top = ($(window).height() - divName.height())/4;  
        var left = ($(window).width() - divName.width())/2;  
        var scrollTop = $(document).scrollTop();  
//      var scrollLeft = $(document).scrollLeft();  
        divName.css( { 'top' : top + scrollTop } ).show(); 
    }
	function qinh() { 
		$("body").css("top",top);
		$("body").removeClass("ovfHiden");
		var top = ($(window).height() - $(".tips").height())/3;  
        var left = ($(window).width() - $(".tips").width())/2;  
        var scrollTop = $(document).scrollTop();  
//      var scrollLeft = $(document).scrollLeft();  

	 	if( $(".shopCart>dl>dd").length>0 ){
//          	$(".tips").show(100);
 				$(".tips").css( { position : 'absolute', 'top' : top + scrollTop } ).show();  
        }else{
            console.log("none");
        }
	 }
	














