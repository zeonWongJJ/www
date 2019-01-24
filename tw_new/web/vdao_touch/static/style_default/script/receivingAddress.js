/**
 * Created by 7du-29 on 2017/12/5.
 */
$(function(){
    $(".choDefault").click(function(){
    	var id = $(this).attr('value');
    	$.ajax({
    		type : 'post',
    		url  : 'upaddress',
    		data : {id:id},
    		dataType : 'json',
    		success  : function (data){
    			if (data.code == 200) {
                   
                };
    		}
    	})
        $(this).addClass("choCur");
        $(".choCur>img").attr("src","static/style_default/images/addr_03.png");
        $(".choCur>span").html("已设为默认");
        $(".choDefault").not($(this)).removeClass("choCur");
        $(".choDefault>img").not( $(".choCur>img")).attr("src","static/style_default/images/check_06.png");
        $(".choDefault>span").not( $(".choCur>span")).html("设为默认");
    });
});












