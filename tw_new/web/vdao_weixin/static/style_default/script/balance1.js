/**
 * Created by 7du-29 on 2017/11/15.
 */
$(function(){
    $(".lay").hide();
    $(".choiceAccout").hide();
    $(".payMethod").click(function(){
        $(".lay").show(200);
        $(".choiceAccout").show(200);
    });
    $(".lay").click(function(){
        $(this).hide(200);
        $(".choiceAccout").hide(200);
    });
    $(".closeAccount").click(function(){
        $(".lay").hide(200);
        $(".choiceAccout").hide(200);
    });
    //ѡ���տ��˻�
    $(".choiceAccout>dl>dd").click(function(){
        $(".lay").hide(200);
        $(".choiceAccout").hide(200);
        $(".payMethod>em").attr("class",$(this).attr("class"));
        $(".payMethod>em>img").attr("src",$(this).children("img").attr("src"));
        $(".payMethod>em>span").html($(this).children("span").html());
        $("input[name='withdraw_type']").val($(this).attr('value'));
    });
    
    $(".choiceAccout>dl>dd").click(function(){
    	if( $(this).attr("class")=="zhifubao" ){
    		$(".open_bank,.prov,.city,.sub_bank").hide();
    	}else if( $(this).attr("class")=="yinhangka" ){
    		$(".payList>li").show();
    	}
    });
    
    $(".payMethod").each(function(i){
    	if( $(this).children("em").attr("class")=="zhifubao" ){
    		$(".open_bank,.prov,.city,.sub_bank").hide();
    	}else if( $(this).Children("em").attr("class")=="yinhangka" ){
    		$(".payList>li").show();
    	}
    })
});
















