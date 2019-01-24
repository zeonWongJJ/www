/**
 * Created by 7du-29 on 2017/10/17.
 */
$(function(){

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

    //申请订单
    $(".see").click(function(){
        show($(".applyDetails"));
    });
    //申请详情
    $(".cateBody>em.v7>a").click(function(){
        show($(".applyTips"));
    });
    //通过
    $(".adopt").live("click", function(){
        var id = $(this).attr('value');
        // console.log(id);
        $('#adoptSub').click(function() {
            var name = $(" input[ name='ton' ] ").val();
            // console.log(name);
            $.ajax({
                type : 'post',
                url  : 'qualifi_state',
                data : {state:1,id:id,liyou:name},
                dataType : 'json',
                success  : function(data) {
                    if (data.code == 200) {
                        $('.audit_'+id).text('已通过');
                        $('.stye_'+id).html('<a class="see ton" value="'+id+'">查看</a>');
                        close($(".adoptReason"));
                    };
                }
            })   
        })
        show($(".adoptReason"));
    });
    //驳回
    $(".reject").live("click", function(){
        var id = $(this).attr('value');
        // console.log(id);
        $('#rejectSub').click(function() {
            var name = $(" input[ name='bohui' ] ").val();
            // console.log(name);
            $.ajax({
                type : 'post',
                url  : 'qualifi_state',
                data : {state:2,id:id,liyou:name},
                dataType : 'json',
                success  : function(data) {
                    if (data.code == 200) {
                        $('.audit_'+id).text('已驳回');
                        $('.stye_'+id).html('<a class="see bo" value="'+id+'">查看</a>');
                        close($(".rejectReason"));
                    };
                }
            })   
        })
        show($(".rejectReason"));
    });
    //搁置
    $(".shelve").live("click",function(){
        var id = $(this).attr('value');  
        $.ajax({
            type : 'post',
            url  : 'qualifi_state',
            data : {state:3,id:id},
            dataType : 'json',
            success  : function(data) {
                if (data.code == 200) {
                    $('.audit_'+id).text('已搁置');
                    $('.stye_'+id).html('<a class="adopt" value="'+id+'">通过</a>&nbsp;&nbsp;<a class="reject" value="'+id+'">驳回</a>');
                };
            }
        })   
    });
    //查看
    $(".see").live("click", function(){
        show($(".applyTips"));
    });
    $('.ton').live("click", function() {
        var id = $(this).attr('value');
        $.ajax({
            type : 'post',
            url  : 'qualifi_chan',
            data : {id:id},
            dataType : 'json',
            success : function (rot) {
                // console.log(rot);
                if (rot.code == 200) {
                    $('.applyTips>p').html(' <span>理由：'+rot.data.qualifi.reason+'</span><span>批准时间：'+rot.data.time+'</span>');
                };
            }
        })
        show($(".applyDetails"));
        $('.applyTips>em').text('已通过此加盟申请');
    })
    $('.bo').live("click", function() {
        var id = $(this).attr('value');
        $.ajax({
            type : 'post',
            url  : 'qualifi_chan',
            data : {id:id},
            dataType : 'json',
            success : function (rot) {
                if (rot.code == 200) {
                    $('.applyTips>p').html(' <span>理由：'+rot.data.qualifi.reason+'</span><span>批准时间：'+rot.data.time+'</span>');
                };
            }
        })
        show($(".applyDetails"));
        $('.applyTips>em').text('已驳回此加盟申请');
    })       

    function close(ele){
        $(".lay").hide();
        ele.hide();
    }

    //关闭
    $(".applyTips>img").click(function(){ close($(".applyTips")) });
    $(".applyTipsBtn>em").click(function(){ close($(".applyTips")) });
    $(".rejectReason>img").click(function(){ close($(".rejectReason")) });
    $(".adoptReason>img").click(function(){ close($(".adoptReason")) });
    $(".closeLay").click(function(){ close($(".applyDetails")) });
});