/**
 * Created by 7du-29 on 2018/4/9.
 */
$(function(){
    $(".lay").height( $(document).height() );
    $(".lay").hide();
    $(".popMess").hide();
    var mySwiper = new Swiper ('.carousel .swiper-container', {
        autoplay: 3000,
        loop: true,
        // 如果需要分页器
        pagination: '.swiper-pagination'
    });

    //二维码固定
    if( $(document).scrollTop()>=600){
        $(".codeContainer").css("top","514px");
    }

    //显示
    function show(lay,ele){
        lay.show();
        // ele.show(100);
    }
    //关闭
    function close(lay,ele){
        lay.hide();
        ele.hide(100);
    }
    //显示弹窗
    $(".messageList>dl>dt>a").click(function(){
        var id = $(this).attr('value');
        $.ajax({
            type : 'post',
            url  : 'new_list',
            data : {id:id},
            dataType : 'json',
            success  : function(ort) {
                $('#popMess').html('<dl>'
                                +'<dt>'+ort.data.notice_content+'<dt>'
                            +'</dl>');
            }
        })
        $('body').css({
            "overflow-x":"hidden",
            "overflow-y":"hidden"
        });
        show($(".lay"),setDivCenter($(".popMess")));
    });
    //隐藏弹窗
    $(".closeMess").click(function(){
        close($(".lay"),$(".popMess"));
        $('body').css({
            "overflow-x":"auto",
            "overflow-y":"auto"
        });
    });

    //让指定的DIV始终显示在屏幕正中间.
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/4;
        var left = ($(window).width() - divName.width())/2;
        var scrollTop = $(document).scrollTop();
//      var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop } ).show();
    }
});