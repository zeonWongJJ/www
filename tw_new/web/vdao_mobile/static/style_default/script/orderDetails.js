/**
 * Created by 7du-29 on 2018/1/4.
 */
$(function(){
    $(".lay").hide();
    $(".tips").hide();
    $(".lay").height($(document).height());

    //������ֲ�ָ�
    $(".lay").click(function(){
        $(this).hide();
        $(".tips").hide();
    });
    // //�ӵ�
    // $(".catch").click(function(){
    //     $(".lay").show();
    //     setDivCenter($(".tips"));
    //     $(".tips").show();
    // });
    //ȡ��
    $(".cancel").click(function(){
        $(".lay").hide();
        $(".tips").hide();
    });

    //��ָ����DIVʼ����ʾ����Ļ���м�
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/2;
        var left = ($(window).width() - divName.width())/2;
        var scrollTop = $(document).scrollTop();
        //var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop});
    }

    var nagheight = $(window).height(); //�����ʱ�´��ڿ�������߶�
    var nagwidth  = $(window).width(); //�����ʱ�´��ڿ��������
    var tiph   = $('.tips').outerHeight();
    var tipw   = $('.tips').outerWidth();
    $('.tips').css('top', (nagheight-tiph)/2);
    $('.tips').css('left', (nagwidth-tipw)/2);

});










