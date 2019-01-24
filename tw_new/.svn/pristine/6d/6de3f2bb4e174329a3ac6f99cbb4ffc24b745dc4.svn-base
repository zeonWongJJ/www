/**
 * Created by 7du-29 on 2017/9/24.
 */
$(function(){
    //初始化状态
    var initState={
        slideName:true,
        slideNum:true,
        slideHref:true
    };

    //标题
    $("#slideName").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".slide_name>span").removeClass("hide");
            $('.slide_name>span>img').attr("src","static/style_default/image/f_03.png");
            $('.slide_name>span>em').html("请输入");
            initState.slideName=false;
        }else{
            $(".slide_name>span").removeClass("hide");
            $('.slide_name>span>img').attr("src","static/style_default/image/t_03.png");
            $('.slide_name>span>em').html("");
            initState.slideName=true;
        }
    });

    //序号
    $("#slideNum").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".slide_num>span").removeClass("hide");
            $('.slide_num>span>img').attr("src","static/style_default/image/f_03.png");
            $('.slide_num>span>em').html("请输入");
            initState.slideNum=false;
        }else{
            $(".slide_num>span").removeClass("hide");
            $('.slide_num>span>img').attr("src","static/style_default/image/t_03.png");
            $('.slide_num>span>em').html("");
            initState.slideNum=true;
        }
    });

    //图片链接
    $("#slideHref").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".slide_href>span").removeClass("hide");
            $('.slide_href>span>img').attr("src","static/style_default/image/f_03.png");
            $('.slide_href>span>em').html("请输入");
            initState.slideHref=false;
        }else{
            $(".slide_href>span").removeClass("hide");
            $('.slide_href>span>img').attr("src","static/style_default/image/t_03.png");
            $('.slide_href>span>em').html("");
            initState.slideHref=true;
        }
    });

    $("#reSub").click(function(){
        if( initState.slideName && initState.slideNum && initState.slideHref ){
            $(this).submit();
        }else{
            alert("有选项未输入或未选择");
            return false;
        }
    });
});











