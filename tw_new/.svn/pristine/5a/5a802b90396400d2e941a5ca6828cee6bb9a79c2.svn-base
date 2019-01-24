/**
 * Created by 7du-29 on 2017/11/4.
 */
$(function(){
    //初始化状态
    var initState={
        roomName:false,
        roomCate:false,
        openClose:false,
        roomArea:false,
        roomSeat:false,
        roomKeyWord:false
    };

    //选择设备
    function device($this,classA,img1){
        if( $this.hasClass(classA) ){
            $this.removeClass(classA);
            $this.children("img").remove();
        }else{
            $this.addClass(classA);
            $this.append($("<img src='"+img1+"'>"));
        }
    }
    $(".deviceBox>a").click(function(){
        device($(this),"check","/static/style_default/image/ac_03.png");
        var device_ids = new Array();
        var i = 0;
        $(".deviceBox .check").each(function(index, el) {
            device_ids[i] = $(this).attr('value');
            i++;
        });
        device_ids = device_ids.join(',')
        $("input[name='device_ids']").val(device_ids);
    });

    //房间名称
    $("#room_name").blur(function(){
        $(".roomName>span").show();
        var val=$(this).val();
        if( val=="" ){
            $(".roomName>span").removeClass("hide");
            $(".roomName>span>em").html("不能为空");
            $(".roomName>span>img").attr("src","/static/style_default/image/f_03.png");
            initState.roomName=false;
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
            initState.roomName=false;
        }else{
            var result = limitNum - remain;
            pattern = '还可以输入' + result + '字符/汉字';
            findEle2.attr("src",img1);
            initState.roomName=true;
        }
        findEle1.html(pattern);
    }
    //耗材名称
    $("#room_name").keyup(function(){
        keyCode(14,$(this),$(".roomName>span>em"),$(".roomName>span>img"),"/static/style_default/image/t_03.png","/static/style_default/image/f_03.png");
    });


    //二级联动
    $("#room_cate_A").change(function(){
        $("#room_cate_A option").each(function(i,o){
            if($(this).attr("selected")){
                $(".room_cate_B").hide();
                $(".room_cate_B").eq(i).show();
            }
        });
    });
    $("#room_cate_A").change();
    $("#room_cate_A").click(function(){
        if($(this).get(0).selectedIndex!=0){
            $(".roomCate>span").removeClass("hide");
            $(".roomCate>span>em").html("");
            $(".roomCate>span>img").attr("src","/static/style_default/image/t_03.png");
            initState. roomCate=true;
            return true;
        }else{
            $(".roomCate>span").removeClass("hide");
            $(".roomCate>span>img").attr("src","/static/style_default/image/f_03.png");
            $(".roomCate>span>em").html("请选择");
            initState. roomCate=false;
            return false;
        }
    });

    //是否开放
    $(".roomDisplay>em").click(function(){
        initState.openClose=true;
        $(".roomDisplay>span").removeClass("hide");
        if($(this).index()==1){
            $(this).parent("li.roomDisplay").find(".sure>img").attr("src","/static/style_default/image/pro_36.png");
            $(".roomDisplay>em.deny>img").attr("src","/static/style_default/image/pro_38.png");
        }else if($(this).index()==2){
            $(this).parent("li.roomDisplay").find(".deny>img").attr("src","/static/style_default/image/pro_36.png");
            $(".roomDisplay>em.sure>img").attr("src","/static/style_default/image/pro_38.png");
        }
        $("input[name='room_state']").val($(this).attr('value'));
    });

    //房间面积
    $("#room_area").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".roomArea>span").removeClass("hide");
            $(".roomArea>span>em").html("不能为空");
            $(".roomArea>span>img").attr("src","/static/style_default/image/f_03.png");
            initState.roomArea=false;
            return false;
        }else{
            $(".roomArea>span").removeClass("hide");
            $(".roomArea>span>em").html("");
            $(".roomArea>span>img").attr("src","/static/style_default/image/t_03.png");
            initState.roomArea=true;
            return true;
        }
    });
    //座位
    $("#room_seat").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".roomSeat>span").removeClass("hide");
            $(".roomSeat>span>em").html("不能为空");
            $(".roomSeat>span>img").attr("src","/static/style_default/image/f_03.png");
            initState.roomSeat=false;
            return false;
        }else{
            $(".roomSeat>span").removeClass("hide");
            $(".roomSeat>span>em").html("");
            $(".roomSeat>span>img").attr("src","/static/style_default/image/t_03.png");
            initState.roomSeat=true;
            return true;
        }
    });
    //关键字
    $("#key_word").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".roomKeyWord>span").removeClass("hide");
            $(".roomKeyWord>span>em").html("不能为空");
            $(".roomKeyWord>span>img").attr("src","/static/style_default/image/f_03.png");
            initState.roomKeyWord=false;
            return false;
        }else{
            $(".roomKeyWord>span").removeClass("hide");
            $(".roomKeyWord>span>em").html("");
            $(".roomKeyWord>span>img").attr("src","/static/style_default/image/t_03.png");
            initState.roomKeyWord=true;
            return true;
        }
    });

    //提交
    $("#roomsSub").click(function(){
            if( initState.roomName && initState.roomCate && initState.openClose && initState.roomArea && initState.roomSeat && initState.roomKeyWord ){
                $(this).submit();
            }else{
                alert("格式错误或有选项未选！");
                return false;
            }
    });
});














