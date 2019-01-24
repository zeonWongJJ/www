/**
 * Created by 7du-29 on 2018/2/27.
 */
$(function(){
    var timeTeg=/^[0-9]{1}[0-9]{1}:[0-9]{1}[0-9]{1}$/;
    var timeState={
        stage_name:true,
        stage_timeA:true,
        stage_timeB:true
    };

    $("#stage_name").blur(function(){
        var val=$(this).val();
        if( val!="" ){
            $(".stageName>span").removeClass("hide");
            $(".stageName>span>img").attr("src","images/t_03.png");
            $(".stageName>span>em").html("");
            timeState.stage_name=true;
        }else{
            $(".stageName>span").removeClass("hide");
            $(".stageName>span>img").attr("src","images/f_03.png");
            $(".stageName>span>em").html("请输入");
            timeState.stage_name=false;
        }
    });

    $("#stage_timeA").blur(function(){
        var val=$(this).val();
        var stageTimeB=$("#stage_timeB").val();
        if( val!="" ){
            if( (timeTeg.test(val)) && (timeTeg.test(stageTimeB)) ){
                $(".stageTime>span").removeClass("hide");
                $(".stageTime>span>img").attr("src","images/t_03.png");
                $(".stageTime>span>em").html("");
                timeState.stage_timeA=true;
                timeState.stage_timeB=true;
            }else{
                $(".stageTime>span").removeClass("hide");
                $(".stageTime>span>img").attr("src","images/f_03.png");
                $(".stageTime>span>em").html("格式错误或有另一个时间段没输入,格式为 00:00");
                timeState.stage_timeA=false;
                timeState.stage_timeB=false;
            }
        }else{
            $(".stageTime>span").removeClass("hide");
            $(".stageTime>span>img").attr("src","images/f_03.png");
            $(".stageTime>span>em").html("请输入！格式为 00:00");
            timeState.stage_timeA=false;
        }
    });


    $("#stage_timeB").blur(function(){
        var val=$(this).val();
        var stageTimeA=$("#stage_timeA").val();
        if( val!="" ){
            if( (timeTeg.test(val)) && (timeTeg.test(stageTimeA)) ){
                $(".stageTime>span").removeClass("hide");
                $(".stageTime>span>img").attr("src","images/t_03.png");
                $(".stageTime>span>em").html("");
                timeState.stage_timeA=true;
                timeState.stage_timeB=true;
            }else{
                $(".stageTime>span").removeClass("hide");
                $(".stageTime>span>img").attr("src","images/f_03.png");
                $(".stageTime>span>em").html("格式错误或有另一个时间段没输入,格式为 00:00");
                timeState.stage_timeA=false;
                timeState.stage_timeB=false;
            }
        }else{
            $(".stageTime>span").removeClass("hide");
            $(".stageTime>span>img").attr("src","images/f_03.png");
            $(".stageTime>span>em").html("请输入！格式为 00:00");
            timeState.stage_timeB=false;
        }
    });



    $("#timeSub").click(function(){
        if( timeState.stage_name && timeState.stage_timeA && timeState.stage_timeB ){
            $(this).submit();
        }else{
            return false;
        }
    });
});







