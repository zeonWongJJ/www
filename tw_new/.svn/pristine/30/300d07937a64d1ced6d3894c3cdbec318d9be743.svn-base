$(function(){
    //全部状态
    $(".stateBox").mouseover(function(){
        $(this).css({"background":"white","border":"1px solid #ddd","border-bottom":"none"});
        $(".state").removeClass("hide");
    });
    $(".stateBox").mouseout(function(){
        $(this).css({"background":"none","border":"1px solid #f4f7fc","border-bottom":"none"});
        $(".state").addClass("hide");
    });

    // 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });

})