/**
 * Created by 7du-29 on 2018/1/2.
 */
$(function(){
    $(".lay").height( $(document).height() );
    $(".lay").hide();
    $(".upTips").hide();
    $(".downTips").hide();
    $(".deleTips").hide();
    $(".nav>a").live("click",function(){
        $(this).addClass("navCur");
        $(".nav>a").not($(this)).removeClass("navCur")
    });

    $(".lay").click(function(){
        $(this).hide();
        $(".upTips").hide();
        $(".downTips").hide();
        $(".deleTips").hide();
    });

    //显示隐藏
    function show(ele){
        $(".lay").show();
        setDivCenter(ele);
    }
    function hide(ele){
        $(".lay").hide();
        ele.hide();
    }
    //下架
    $(".up").live("click",function(){
        show($(".upTips"));
        var id = $(this).attr('value');
        $('.xia').click(function(){
            $.ajax({
                type : 'post',
                url  : 'share_goods_ster',
                data : {id:id,ster:2},
                dataType : 'json',
                success  : function (data) {
                    if (data.code == 200) {
                        window.location.reload(); 
                        // hide($(".upTips"));
                    };
                }
            })
        })
    });
    $(".upBtn>.cancel").live("click",function(){
        hide($(".upTips"));
    });
    // 上架
    $(".down").live("click",function(){
        show($(".downTips"));
        var id = $(this).attr('value');
        $('.shan').click(function(){
            $.ajax({
                type : 'post',
                url  : 'share_goods_ster',
                data : {id:id,ster:1},
                dataType : 'json',
                success  : function (data) {
                    if (data.code == 200) {
                        window.location.reload(); 
                        // hide($(".downTips"));
                    };
                }
            })
        })
    });
    $(".downBtn>.cancel").live("click",function(){
        hide($(".downTips"));
    });
    //删除
    $(".dele").live("click",function(){
        show($(".deleTips"));
        var id = $(this).attr('value');
        $('.sure').click(function(){
            $.ajax({
                type : 'post',
                url  : 'share_goods_del',
                data : {id:id},
                dataType : 'json',
                success  : function (data) {
                    if (data.code == 200) {
                        $(".li_"+id).remove();
                        hide($(".deleTips"));
                    };
                }
            })
       
        })
    });
    $(".deleBtn>.cancel").live("click",function(){
        hide($(".deleTips"));
    });

    //让指定的DIV始终显示在屏幕正中间
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/2;
        var left = ($(window).width() - divName.width())/2;
        var scrollTop = $(document).scrollTop();
//      var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop }).show();
    }
});










