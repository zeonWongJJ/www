/**
 * Created by 7du-29 on 2017/9/28.
 */
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

    //查看照片
    var mySwiper = new Swiper('.swiper-container', {
        autoplay:3000,//可选选项，自动滑动
        pagination : '.swiper-pagination',
        paginationClickable :true
    });
    var mySwiper = new Swiper('.swiper-containeres', {
        autoplay:4000,//可选选项，自动滑动
        pagination : '.swiper-pagination1',
        paginationClickable :true,
        slidesPerView : 3,
        slidesPerGroup : 3,
        spaceBetween : 10,
        slidesPerColumn : 3
    });
    $(".lookPicture").hide();

    $(".cateBody>.v7").click(function(){
        var id = $(this).attr('value');
        $.ajax({   
            type : 'post',
            url  : 'entry_record_imge',
            data : {id:id},
            dataType : 'json',
            success : function (rot) {
                var imge = rot.data;
                console.log(imge);
                var html = '';
                var i = 0;
                $.each(imge, function(i, int) {
                    html += '<div class="swiper-slide">'
                                +'<a href="#">'
                                +'<img src="'+imge[i]+'" alt="">'
                                +'</a>'
                            +'</div>';
                            i++;
                })
                $('.swiper-wrapper').html(html);
            }
        })
        $(".lookPicture").show();
    });
    $(".closePic").click(function(){
        $(".lookPicture").hide();
    });
});













