/**
 * Created by 7du-29 on 2017/12/1.
 */
$(function(){
    $(".lay").hide();
    $(".spec").hide();
    //选择杯型大小
    $(".cup .temType i").click(function(){
        $(this).addClass("cupCur").siblings().removeClass('cupCur');
        if( $(".cupCur").index()==0){
            $(".shopPrice .span1").html("￥24.00");
            $(".shopPrice em").html("小杯");
        }else if( $(".cupCur").index()==1 ){
            $(".shopPrice .span1").html("￥28.00");
            $(".shopPrice em").html("中杯");
        }else if( $(".cupCur").index()==2 ){
            $(".shopPrice .span1").html("￥32.00");
            $(".shopPrice em").html("大杯");
        }
    });
	//选择温度
	$('body').on('click','.temperature1 .temType i',function(){
		$(this).addClass('temCur').siblings().removeClass('temCur');
		if( $(".temCur").index()==0){
            $(".shopPrice dfn").html("默认");
        }else if( $(".temCur").index()==1 ){
            $(".shopPrice dfn").html("冷");
        }else if( $(".temCur").index()==2 ){
            $(".shopPrice dfn").html("热");
        }
	})
	// //选择添加的果肉
	// $('body').on('click','.add .temType i',function(){
	// 	$(this).toggleClass('addCur');
	// })

    $(".choiceSpec").click(function(){
        var goods = $(this).attr('value');
        console.log(goods);
        $(".lay").show();
        $(".li_"+goods).show(100);
    });

    $(".closeSpec").click(function(){
        $(".lay").hide();
        $(".spec").hide(100);
    });
});



















