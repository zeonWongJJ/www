/**
 * Created by 7du-29 on 2018/1/5.
 */
$(function(){
    // var pit=400;//收益
    $("#yesEx").hide();
    $("#shareEx").hide();
    $("#storeEx").hide();
    // $("#yesCipher").attr("value",pit);
    // $("#yesEx").attr("value",pit);
    // $("#shareCipher").attr("value",pit);
    // $("#shareEx").attr("value",pit);
    // $("#storeCipher").attr("value",pit);
    // $("#storeEx").attr("value",pit);
    //点击切换密文或明文
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
    // 当前定位
    current_location();
});

