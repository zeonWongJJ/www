/**
 * Created by 7du-29 on 2017/11/4.
 */
$(function(){
    //初始化状态
    var initState={
        deviceName:true,
        deviceNum:true,
        openClose:true
    };

    // 添加原有的图片
    upload_update();

    //房间名称
    $("#device_name").blur(function(){
        $(".deviceName>span").show();
        var val=$(this).val();
        if( val=="" ){
            $(".deviceName>span").removeClass("hide");
            $(".deviceName>span>em").html("不能为空");
            $(".deviceName>span>img").attr("src","/static/style_default/image/f_03.png");
            initState.deviceName=false;
            return false;
        }
    });
    function keyCode(codeNum,eleThis,findEle1,findEle2,img1,img2){
        var limitNum =codeNum;
        var pattern = '还可以输入' + limitNum + '字符/汉字';
        findEle1.html(pattern);
        var remain = eleThis.val().length;
        if(remain >codeNum){
            pattern = "字数超过限制！";
            findEle2.attr("src",img2);
            initState.deviceName=false;
        }else{
            var result = limitNum - remain;
            pattern = '还可以输入' + result + '字符/汉字';
            findEle2.attr("src",img1);
            initState.deviceName=true;
        }
        findEle1.html(pattern);
    }
    //耗材名称
    $("#device_name").keyup(function(){
        keyCode(14,$(this),$(".deviceName>span>em"),$(".deviceName>span>img"),"/static/style_default/image/t_03.png","/static/style_default/image/f_03.png");
    });

    //设备型号
    $("#device_num").blur(function(){
        $(".deviceNum>span").show();
        var val=$(this).val();
        if( val=="" ){
            $(".deviceNum>span").removeClass("hide");
            $(".deviceNum>span>em").html("不能为空");
            $(".deviceNum>span>img").attr("src","/static/style_default/image/f_03.png");
            initState.deviceNum=false;
            return false;
        }else{
            $(".deviceNum>span").removeClass("hide");
            $(".deviceNum>span>em").html("");
            $(".deviceNum>span>img").attr("src","/static/style_default/image/t_03.png");
            initState.deviceNum=true;
            return true;
        }
    });


    //是否开放
    $(".deviceDisplay>em").click(function(){
        initState.openClose=true;
        $(".deviceDisplay>span").removeClass("hide");
        if($(this).index()==1){
            $(this).parent("li.deviceDisplay").find(".sure>img").attr("src","/static/style_default/image/pro_36.png");
            $(".deviceDisplay>em.deny>img").attr("src","/static/style_default/image/pro_38.png");
        }else if($(this).index()==2){
            $(this).parent("li.deviceDisplay").find(".deny>img").attr("src","/static/style_default/image/pro_36.png");
            $(".deviceDisplay>em.sure>img").attr("src","/static/style_default/image/pro_38.png");
        }
        $("input[name='device_state']").val($(this).attr('value'));
    });

    //提交
    $("#deviceSub").click(function(){
            if( initState.deviceName && initState.deviceNum && initState.openClose ){
                $(this).submit();
            }else{
                alert("格式错误或有选项未选！");
                return false;
            }
    });
});














