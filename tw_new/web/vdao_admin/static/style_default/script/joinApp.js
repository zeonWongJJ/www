/**
 * Created by 7du-29 on 2017/10/17.
 */
$(function(){

    $(".IDcard").hide();
    $(".license").hide();
    $(".applyDetails").hide();
    $(".deleTips").hide();
    $(".applyTips").hide();
    $(".rejectReason").hide();
    $(".adoptReason").hide();
    //申请栏样式的高度
    $(".applyerInfo>em>hr").height( $(".applyerInfo>.content").height() );
    $(".applyerTime>em>hr").height( $(".applyerTime>.content").height() );
    $(".storeInfo>em>hr").height( $(".storeInfo>.content").height() );

    //遮罩层高度
    $(".lay").height($(document).height());
    $(".lay").hide();

    //全部状态
    $(".stateBox").mouseover(function(){
        $(this).css({"background":"white","border":"1px solid #ddd","border-bottom":"none"});
        $(".state").removeClass("hide");
    });
    $(".stateBox").mouseout(function(){
        $(this).css({"background":"none","border":"1px solid #f4f7fc","border-bottom":"none"});
        $(".state").addClass("hide");
    });

    //让指定的DIV始终显示在屏幕正中间
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/3;
        var left = ($(window).width() - divName.width())/1.8;
        var scrollTop = $(document).scrollTop();
        var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop,'left' : left + scrollLeft } ).show();
    }

    //点击遮罩层关闭弹窗
    $(".lay").click(function(){
        $(".license").hide();
        $(".IDcard").hide();
        $(".applyDetails").hide();
        $(".applyTips").hide();
        $(".adoptReason").hide();
        $(".rejectReason").hide();
        $(this).hide();
    });

    function show(ele){
        $(".lay").show();
        setDivCenter(ele);
    }

    // 营业执照
    // $(".cateBody>em.v5>a").click(function(){
    //     var join_licence = $(this).attr('value');
    //     var vdaom = $(this).attr('vdaom');
    //     $('.license dl').html('');
    //     if (join_licence != '') {
    //         licence_pic = join_licence.split(',');
    //         var append_content = '<dt>查看营业执照</dt>';
    //         for (var i = 0; i < licence_pic.length; i++) {
    //             append_content += '<dd><img src="'+vdaom+licence_pic[i]+'" /></dd>';
    //         }
    //         $('.license dl').html(append_content);
    //     } else {
    //         $('.license dl').html('<dt>查看营业执照</dt>');
    //     }
    //     show($(".license"));
    // });
    // // 法人身份证
    // $(".cateBody>em.v6>a").click(function(){
    //     var join_idcardpic = $(this).attr('value');
    //     var vdaom = $(this).attr('vdaom');
    //     $('.IDcard dl').html('');
    //     if (join_idcardpic != '') {
    //         idcardpic_pic = join_idcardpic.split(',');
    //         var append_content = '<dt>查看法人身份证</dt>';
    //         for (var i = 0; i < idcardpic_pic.length; i++) {
    //             append_content += '<dd><img src="'+vdaom+idcardpic_pic[i]+'" /></dd>';
    //         }
    //         $('.IDcard dl').html(append_content);
    //     } else {
    //         $('.IDcard dl').html('<dt>查看法人身份证</dt>');
    //     }
    //     show($(".IDcard"));
    // });
    //申请订单
    $(".see").click(function(){
        var join_id = $(this).attr('value');
        $.ajax({
            url: 'join_info',
            type: 'POST',
            dataType: 'json',
            data: {join_id: join_id},
            success: function(res) {
                console.log(res);
                if (res.code == 200) {
                    $('.applyDetails .join_user').html(res.data.user_name);
                    $('.applyDetails .join_linkman').html(res.data.join_linkman);
                    $('.applyDetails .join_phone').html(res.data.join_phone);
                    $('.applyDetails .join_idcard').html(res.data.join_idcard);
                    $('.applyDetails .join_time1').html(res.data.join_time1);
                    $('.applyDetails .join_time2').html(res.data.join_time2);
                    $('.applyDetails .join_size').html(res.data.join_size+'m<sup>2</sup>');
                    $('.applyDetails .join_floor').html(res.data.join_floor+'楼');
                    $('.applyDetails .join_passenger').html(res.data.join_passenger+'/天');
                    $('.applyDetails .join_address1').html(res.data.join_address1);
                }
            }
        })
        show($(".applyDetails"));
    });
    // //申请详情
    // $(".cateBody>em.v7>a").click(function(){
    //     var join_id = $(this).attr('value');
    //     $.ajax({
    //         url: 'join_info',
    //         type: 'POST',
    //         dataType: 'json',
    //         data: {join_id: join_id},
    //         success: function(res) {
    //             console.log(res);
    //             if (res.code == 200) {
    //                 if (res.data.join_state == 3) {
    //                     $(".applyTips .em_title").html('已通过此加盟申请');
    //                     $(".applyTips .span_reason").html('理由：'+res.data.join_agreereason);
    //                     $(".applyTips .span_time").html('批准时间：'+res.data.join_agreetime1);
    //                 }
    //                 if (res.data.join_state == 5) {
    //                     $(".applyTips .em_title").html('已驳回此加盟申请');
    //                     $(".applyTips .span_reason").html('理由：'+res.data.join_refusereason);
    //                     $(".applyTips .span_time").html('批准时间：'+res.data.join_refusetime1);
    //                 }
    //                 if (res.data.join_state == 2) {
    //                     $(".applyTips .em_title").html('此申请等待处理中');
    //                     $(".applyTips .span_reason").html('状态：申请中');
    //                     $(".applyTips .span_time").html('申请时间：'+res.data.join_time1+ ' ' +res.data.join_time2);
    //                 }
    //                 if (res.data.join_state == 4) {
    //                     $(".applyTips .em_title").html('此申请已被搁置');
    //                     $(".applyTips .span_reason").html('状态：已搁置');
    //                     $(".applyTips .span_time").html('申请时间：'+res.data.join_time1+ ' ' +res.data.join_time2);
    //                 }
    //             }
    //         }
    //     })
    //     show($(".applyTips"));
    // });
    //通过
    $(".adopt").click(function(){
        $("input[name='join_id']").val($(this).attr('value'));
        show($(".adoptReason"));
    });
    //驳回
    $(".reject").click(function(){
        $("input[name='join_id2']").val($(this).attr('value'));
        show($(".rejectReason"));
    });

    function close(ele){
        $(".lay").hide();
        ele.hide();
    }

    //关闭
    $(".closeLicense").click(function(){ close($(".license"))});
    $(".closeID").click(function(){ close($(".IDcard"))});
    $(".applyTips>img").click(function(){ close($(".applyTips")) });
    $(".applyTipsBtn>em").click(function(){ close($(".applyTips")) });
    $(".rejectReason>img").click(function(){ close($(".rejectReason")) });
    $(".adoptReason>img").click(function(){ close($(".adoptReason")) });
    $(".closeLay").click(function(){ close($(".applyDetails")) });

    // 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });

    // 重置弹出窗口的屏幕显示位置
    var nagheight = $(window).height(); //浏览器时下窗口可视区域高度
    var nagwidth  = $(window).width(); //浏览器时下窗口可视区域宽
    var tiph   = $('.deleTips').outerHeight();
    var tipw   = $('.deleTips').outerWidth();
    $('.deleTips').css('top', (nagheight-tiph)/2);
    $('.deleTips').css('left', (nagwidth-tipw)/2);

});