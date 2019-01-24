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
    //选择收款账户
    $(".choiceAccout>dl>dd").click(function(){
        $(".lay").hide(200);
        $(".choiceAccout").hide(200);
        $(".payMethod>em").attr("class",$(this).attr("class"));
        $(".payMethod>em>img").attr("src",$(this).children("img").attr("src"));
        $(".payMethod>em>span").html($(this).children("span").html());
        $("input[name='pay_type']").val($(this).attr('value'));
    })
});
















