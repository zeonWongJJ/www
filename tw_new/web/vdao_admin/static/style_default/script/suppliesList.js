/**
 * Created by 7du-29 on 2017/9/21.
 */
$(function(){
    //Ñ¡Ôñ¿§·ÈÖÖÀà
    function choiceCafe(eleThis,add_class,ele){
        eleThis.addClass(add_class);
        ele.not(eleThis).removeClass(add_class);
    }

    $(".coffee_cate>span").click(function(){
        choiceCafe($(this),"cateCur",$(".coffee_cate>span"))
    });
    $(".coffee_type>span").click(function(){
        choiceCafe($(this),"typeCur",$(".coffee_type>span"))
    });
    $(".coffee_grade>span").click(function(){
        choiceCafe($(this),"typeCur",$(".coffee_grade>span"))
    });
    $(".coffee_key>span").click(function(){
        choiceCafe($(this),"typeCur",$(".coffee_key>span"))
    });


    //½ûÓÃÆôÓÃ
    $(".proDisable>img").click(function(){
        if(!($(this).hasClass("disabled"))){
            $(this).addClass("disabled");
            $(this).attr("src","images/pro_33.png");
        }else{
            $(this).removeClass("disabled");
            $(this).attr("src","images/pro_10.png");
        }
    });

    //µ¯³ö²ã
    $(".suppliesTips").click(function(e){
        $(this).next(".popLay").removeClass("hide");
        e.stopPropagation();
    });
    $(".popLay").click(function(e){
        e.stopPropagation();
    });
   $(document.body).click(function(){
       $(".popLay").addClass("hide");
   });
   $('.delete').click(function(){
        var id = $(this).attr('value');
        console.log(id);
        $('.tips').removeClass("hide");
        $('.duetw').unbind("click").click(function() {
            $.ajax({
                type : 'post',
                data : {id:id},
                url  : 'annex_delete',
                dataType : 'json',
                success  : function(data) {
                    if (data == 33) {
                        window.location.reload();
                    } else {
                        alert('删除失败！');
                    };
                }
            })
        })
   })
   $('.quxiao').click(function(){
        $('.tips').addClass("hide");
   })

    //ÅÐ¶ÏÔ¤¾¯Öµ
    function warningNum(){
        var num=$(".cateBody>em.v4");
        var warnNum=$(".cateBody>em.v6");
        for( var i=0,n=0;i<num.length,n<warnNum.length;i++,n++ ){
           if( parseInt(num.eq(i).html())<parseInt(warnNum.eq(n).html()) ){
               num.eq(i).addClass("cateRed");
           }else{
               num.eq(i).removeClass("cateRed");
           }
        }
    }
    warningNum()
});



















