/**
 * Created by 7du-29 on 2018/3/30.
 */
var relieve_type;
$(function(){
    $(".lay").hide();
    $(".popbottom").hide();
    //$(".payChannel>ul>li>a").hide();
    //点击管理弹出底部
    $(".cardAdmin").click(function(){
        relieve_type = $(this).attr('value');
        $(this).parent().addClass("payCur");
        $(".payChannel>ul>li").not($(this).parent()).removeClass("payCur");
        $(".popbottom>p:nth-child(1)").html("您正对"+$(this).prev().prev().html()+"进行操作");
        $(".lay").show();
        $(".popbottom").show();
        window.addEventListener('touchmove', startdt);
    });
    //解除绑定
    $(".relieve").click(function(){
        $(".payCur>span").hide();
        $(".payCur>.payCard").hide();
        $(".payCur>a").show();
        $(".payCur").removeClass("payCur");
        // 发送ajax请求
        $.ajax({
            url: 'account_relieve',
            type: 'POST',
            dataType: 'json',
            data: {relieve_type: relieve_type},
            success: function(res) {
                console.log(res);
            }
        })
        $(".lay").hide();
        $(".popbottom").hide();
        $(".tips").stop().show(100).delay(3000).hide(100);
        $(".tips").html("解绑成功");
        window.removeEventListener('touchmove', startdt);
    });
    //取消
    $(".cancel").click(function(){
        $(".lay").hide();
        $(".popbottom").hide();
    });
    function startdt(event) {
        event.preventDefault();
    }
});















