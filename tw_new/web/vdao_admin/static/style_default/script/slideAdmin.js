/**
 * Created by 7du-29 on 2018/3/9.
 */
$(function(){
    $(".lay").height( $(document).height() );
    $(".lay").hide();
    $(".tips_lay").hide();
    //点击遮罩层
    $(".lay").click(function(){
        $(this).hide();
        $('.tips_lay').hide();
    });
    function show(ele){
        ele.show();
        $(".lay").show();
    }
    function hide(ele){
        ele.hide();
        $(".lay").hide();
    }
    //点击显示弹窗
    //$(".revise").click(function(){show($(".tips_lay"))});
    //关闭弹窗
    $(".tipsClose").click(function(){
        hide($(".tips_lay"));
    });
    // //确认
    // $(".tips_btn > em").click(function(){
    //     hide($(".tips_lay"));
    // });
    //再看看
    $(".tips_btn >span").click(function(){
        hide($(".tips_lay"));
    });

    // 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });

});











