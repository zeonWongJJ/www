/**
 * Created by 7du-29 on 2018/3/30.
 */
$(function(){
    $(".lay").click(function(){
        $(this).hide();
        $(".popbottom").hide();
        $(".card_boxTips").hide();
    });
    
    $("#subBtn").click(function(){
    	if( $(".shou_type").attr("data-type") == 2 ){
    		var point=$(".pointForm ul>li:nth-child(4)>input").val();//获取积分
    		var charge=Number(point)-Number(1);
    		$(".tipsList>a:nth-child(2)>em").html(charge.toFixed(2)+"元");
    		$(".tipsList>a:nth-child(3)>em").html("1元");
    		$(".card_boxTips").show();
    		$(".lay").show();
    		return false;
    	}else{
    		$(".card_boxTips").hide();
//  		$(this).attr("href")
    	}
    });
});





