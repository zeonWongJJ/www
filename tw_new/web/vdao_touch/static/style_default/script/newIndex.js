/**
 * Created by 7du-29 on 2018/1/5.
 */
$(function(){
    // var pit=400;//ÊÕÒæ
    $("#yesEx").hide();
    $("#shareEx").hide();
    $("#storeEx").hide();
    // $("#yesCipher").attr("value",pit);
    // $("#yesEx").attr("value",pit);
    // $("#shareCipher").attr("value",pit);
    // $("#shareEx").attr("value",pit);
    // $("#storeCipher").attr("value",pit);
    // $("#storeEx").attr("value",pit);
    //µã»÷ÇÐ»»ÃÜÎÄ»òÃ÷ÎÄ
    $(".ciphertext").click(function(){
        if( $(this).hasClass("showText") ){
            $(this).removeClass("showText");
            $(this).attr("src","/static/style_default/images/closeE.png");
            $("#yesCipher").hide();
            $("#yesEx").show();
            $("#shareCipher").hide();
            $("#shareEx").show();
            $("#storeCipher").hide();
            $("#storeEx").show();
        }else{
            $(this).addClass("showText");
            $(this).attr("src","/static/style_default/images/eye.png");
            $("#yesCipher").show();
            $("#yesEx").hide();
            $("#shareCipher").show();
            $("#shareEx").hide();
            $("#storeCipher").show();
            $("#storeEx").hide();
        }
    });
    // µ±Ç°¶¨Î»
    // current_location();

    $(".popAppTips").hide();
    $(".lay").height( $(document).height() );

    $(".lay").click(function(){
        $(this).hide();
        $(".popAppTips").hide();
    });
    $(".cancelDw").click(function(){
        $(".lay").hide();
        $(".popAppTips").hide();
    })

    // 重置弹出窗口的屏幕显示位置
    var nagheight = $(window).height(); //浏览器时下窗口可视区域高度
    var nagwidth  = $(window).width(); //浏览器时下窗口可视区域宽
    var tiph   = $('.popAppTips').outerHeight();
    var tipw   = $('.popAppTips').outerWidth();
    $('.popAppTips').css('top', (nagheight-tiph)/2);
    $('.popAppTips').css('left', (nagwidth-tipw)/2);

});

