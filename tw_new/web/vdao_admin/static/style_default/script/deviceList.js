/**
 * Created by 7du-29 on 2017/9/11.
 */
$(function(){
    var head_allselect=$(".cateHead>em.v1>img");//ȫѡ
    var bottomAllselect=$(".bottomAllSelect>img");//�ײ�ȫѡ��ť
    var choice_device=$(".varieties>em.v1>img");//ѡ���豸
    var varietiesDisable=$(".varieties>em.v4>img");//�Ƿ񿪷�

    function allSelect(eleThis,addClass1,addClass2,addClass3,ele1,ele2,img1,img2){
        if( !(eleThis.hasClass(addClass1)) ){
            eleThis.addClass(addClass1);
            eleThis.attr("src",img1);
            ele1.addClass(addClass2);
            ele1.attr("src",img1);
            ele2.addClass(addClass3);
            ele2.attr("src",img1);
        }else{
            eleThis.removeClass(addClass1);
            eleThis.attr("src",img2);
            ele1.removeClass(addClass2);
            ele1.attr("src",img2);
            ele2.removeClass(addClass3);
            ele2.attr("src",img2);
        }
        console.log(eleThis);
    }
    //ȫѡ
    head_allselect.click(function(){
        allSelect($(this),"all_select","bottom_allSelect","varietiesChoice",bottomAllselect,$(".varieties>em.v1>img"),"/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png")
    });
    //�ײ�������ȫѡ
    bottomAllselect.click(function(){
        allSelect($(this),"bottom_allSelect","all_select","varietiesChoice",head_allselect,$(".varieties>em.v1>img"),"/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    });

//  ѡ���豸
    function varieties(eleThis,addClass1,addClass2,addClass3,img1,img2){
        var len;
        var classLen;
        if(!(eleThis.hasClass(addClass1))){
            eleThis.addClass(addClass1);
            eleThis.attr("src",img1);
        }else{
            eleThis.removeClass(addClass1);
            eleThis.attr("src",img2);
        }
        len=choice_device.length;
        classLen=$(".varieties>em.v1>img.varietiesChoice").length;
        if(len==classLen){
            head_allselect.addClass(addClass2);
            head_allselect.attr("src",img1);
            bottomAllselect.addClass(addClass3);
            bottomAllselect.attr("src",img1);
        }else{
            head_allselect.removeClass(addClass2);
            head_allselect.attr("src",img2);
            bottomAllselect.removeClass(addClass3);
            bottomAllselect.attr("src",img2);
        }
    }

    choice_device.click(function(){
        varieties($(this),"varietiesChoice","all_select","bottom_allSelect","/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png")
    });

    //�Ƿ񿪷�
    // function varieties_disabled(eleThis,addClass1,img1,img2){
    //     if( !(eleThis.hasClass(addClass1)) ){
    //         eleThis.addClass(addClass1);
    //         eleThis.attr("src",img1);
    //     }else{
    //         eleThis.removeClass(addClass1);
    //         eleThis.attr("src",img2);
    //     }
    // }
    // varietiesDisable.click(function(){
    //     varieties_disabled($(this),"disabled","/static/style_default/image/pro_33.png","/static/style_default/image/pro_10.png")
    // })

    // �ı䵱ǰ��ҳ����ʽ
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });

    // ���õ������ڵ���Ļ��ʾλ��
    var nagheight = $(window).height(); //�����ʱ�´��ڿ�������߶�
    var nagwidth  = $(window).width(); //�����ʱ�´��ڿ��������
    var tiph   = $('.pop_tips').outerHeight();
    var tipw   = $('.pop_tips').outerWidth();
    $('.pop_tips').css('top', (nagheight-tiph)/2);
    $('.pop_tips').css('left', (nagwidth-tipw)/2);

})












