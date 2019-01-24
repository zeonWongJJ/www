/**
 * Created by 7du-29 on 2017/11/10.
 */
$(function (){
    //开关
    // $(".listSwitch>img").click(function(){
    //     if( ($(this).hasClass("choice")) ){
    //         $(this).removeClass("choice");
    //         $(this).attr("src","/static/style_default/image/pro_33.png");
    //     }else{
    //         $(this).addClass("choice");
    //         $(this).attr("src","/static/style_default/image/pro_10.png");
    //     }
    // });

    $(".listCon>input").hide();
    $(".listCon").keyup(function(){
        $(this).val().replace(/[^0-9-]+/,'');
    });

        $(".edit>span").live("click",function(){
            $(this).parent().prev(".listCon").find("span").hide(200);
            $(this).parent().prev(".listCon").find("input").show(200);
            $(this).parent().prev(".listCon").find("input").focus();
            $(this).parent().removeClass("edit");
            $(this).parent().addClass("com");
            $(this).html("完成");
            console.log($(this).parent().prev(".listCon").find("input").val()  )
        });

        $(".com>span").live("click",function(){
            var val=$(this).parent().prev().children("input").val();
            if( val=="" ){
                alert("请输入！");
            }else{
                $(this).parent().prev(".listCon").find("span").html($(this).parent().prev(".listCon").find("input").val());
                $(this).parent().prev(".listCon").find("span").show();
                $(this).parent().prev(".listCon").find("input").hide();
                $(this).parent().removeClass("com");
                $(this).parent().addClass("edit");
                var set_name = $(this).attr('value');
                var set_parameter = val;
                $.ajax({
                    url: 'set_update',
                    type: 'POST',
                    dataType: 'json',
                    data: {set_name: set_name, set_parameter: set_parameter},
                    success: function(res) {
                        console.log(res);
                    }
                })
                $(this).html("修改");
            }
        })



});











