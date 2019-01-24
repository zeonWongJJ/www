/**
 * Created by 7du-29 on 2017/8/25.
 */
$(function(){
    $(".cateHead>em>img").click(function(){
        if(!($(this).hasClass("cateHeadAllSelcet"))){
            $(this).addClass("cateHeadAllSelcet");
            $(this).attr("src","static/style_default/image/pro_23.png");
            $(".cateBody>.varieties>em.v1>img").addClass("choiceCate");
            $(".cateBody>.varieties>em.v1>img").attr("src","static/style_default/image/pro_23.png");
            $(".varietiesCateList>a>em.v1>img").addClass("cateListChoice");
            $(".varietiesCateList>a>em.v1>img").attr("src","static/style_default/image/pro_23.png");
            $(".varietiesCateList>em>div>em.v1>img").addClass("cateTypeChoice");
            $(".varietiesCateList>em>div>em.v1>img").attr("src","static/style_default/image/pro_23.png");
        }else{
            $(this).removeClass("cateHeadAllSelcet");
            $(this).attr("src","static/style_default/image/pro_07.png");
            $(".cateBody>.varieties>em.v1>img").removeClass("choiceCate");
            $(".cateBody>.varieties>em.v1>img").attr("src","static/style_default/image/pro_07.png");
            $(".varietiesCateList>a>em.v1>img").removeClass("cateListChoice");
            $(".varietiesCateList>a>em.v1>img").attr("src","static/style_default/image/pro_07.png");
            $(".varietiesCateList>em>div>em.v1>img").removeClass("cateTypeChoice");
            $(".varietiesCateList>em>div>em.v1>img").attr("src","static/style_default/image/pro_07.png");
        }
    })


    $(".varieties>em.v1>p").click(function(){
        if($(".varietiesCate").hasClass("hide")){
            $(this).parent("em.v1").parent(".varieties").next(".varietiesCate").removeClass("hide");
            $(this).children("img").attr("src","static/style_default/image/pro_13.png");
        }else{
            $(this).parent("em.v1").parent(".varieties").next(".varietiesCate").addClass("hide");
            $(this).children("img").attr("src","static/style_default/image/pro_48.png");
        }
    })


    $(".varietiesCateList>a>em.v1>p").click(function(){
        if($(".varietiesCateList>em").hasClass("hide")){
            $(this).parent("em.v1").parent("a").parent(".varietiesCateList").children("em").removeClass("hide");
        }else{
            $(this).parent("em.v1").parent("a").parent(".varietiesCateList").children("em").addClass("hide");
        }
    });

    function checkBoxOne(a){
        if(!(a.hasClass("choiceCate"))){
            a.addClass("choiceCate");
            a.attr("src","static/style_default/image/pro_23.png");
            a.parent("em.v1").parent(".varieties").next(".varietiesCate").children(".varietiesCateList").children("a").children("em.v1").children("img").addClass("cateListChoice");
            a.parent("em.v1").parent(".varieties").next(".varietiesCate").children(".varietiesCateList").children("a").children("em.v1").children("img").attr("src","static/style_default/image/pro_23.png");
            a.parent("em.v1").parent(".varieties").next(".varietiesCate").find(".varietiesCateList>em>div>em.v1>img").addClass("cateTypeChoice");
            a.parent("em.v1").parent(".varieties").next(".varietiesCate").find(".varietiesCateList>em>div>em.v1>img").attr("src","static/style_default/image/pro_23.png");
        }else{
            a.removeClass("choiceCate");
            a.attr("src","static/style_default/image/pro_07.png");
            a.parent("em.v1").parent(".varieties").next(".varietiesCate").children(".varietiesCateList").children("a").children("em.v1").children("img").removeClass("cateListChoice");
            a.parent("em.v1").parent(".varieties").next(".varietiesCate").children(".varietiesCateList").children("a").children("em.v1").children("img").attr("src","static/style_default/image/pro_07.png");
            a.parent("em.v1").parent(".varieties").next(".varietiesCate").find(".varietiesCateList>em>div>em.v1>img").removeClass("cateTypeChoice");
            a.parent("em.v1").parent(".varieties").next(".varietiesCate").find(".varietiesCateList>em>div>em.v1>img").attr("src","static/style_default/image/pro_07.png");
        }

        if( ($(".varieties>em.v1>img").length)==($(".varieties>em.v1>img.choiceCate").length) ){
            a.parent("em.v1").parent(".varieties").parent("li.cateBody").parent("ul.cateList").children("li.cateHead").children("em.v1").children("img").addClass("cateHeadAllSelcet");
            a.parent("em.v1").parent(".varieties").parent("li.cateBody").parent("ul.cateList").children("li.cateHead").children("em.v1").children("img").attr("src","static/style_default/image/pro_23.png");
        }else{
            a.parent("em.v1").parent(".varieties").parent("li.cateBody").parent("ul.cateList").children("li.cateHead").children("em.v1").children("img").removeClass("cateHeadAllSelcet");
            a.parent("em.v1").parent(".varieties").parent("li.cateBody").parent("ul.cateList").children("li.cateHead").children("em.v1").children("img").attr("src","static/style_default/image/pro_07.png");
        }

    }


    $(".varieties>em.v1>img").click(function(){
        checkBoxOne($(this));
    })
    //$(".varieties>em.v1>img").click(function(){
    //    if(!($(this).hasClass("choiceCate"))){
    //        $(this).addClass("choiceCate");
    //        $(this).attr("src","static/style_default/image/pro_23.png");
    //        $(this).parent("em.v1").parent(".varieties").next(".varietiesCate").children(".varietiesCateList").children("a").children("em.v1").children("img").addClass("cateListChoice");
    //        $(this).parent("em.v1").parent(".varieties").next(".varietiesCate").children(".varietiesCateList").children("a").children("em.v1").children("img").attr("src","static/style_default/image/pro_23.png");
    //        $(this).parent("em.v1").parent(".varieties").next(".varietiesCate").find(".varietiesCateList>em>div>em.v1>img").addClass("cateTypeChoice");
    //        $(this).parent("em.v1").parent(".varieties").next(".varietiesCate").find(".varietiesCateList>em>div>em.v1>img").attr("src","static/style_default/image/pro_23.png");
    //    }else{
    //        $(this).removeClass("choiceCate");
    //        $(this).attr("src","static/style_default/image/pro_07.png");
    //        $(this).parent("em.v1").parent(".varieties").next(".varietiesCate").children(".varietiesCateList").children("a").children("em.v1").children("img").removeClass("cateListChoice");
    //        $(this).parent("em.v1").parent(".varieties").next(".varietiesCate").children(".varietiesCateList").children("a").children("em.v1").children("img").attr("src","static/style_default/image/pro_07.png");
    //        $(this).parent("em.v1").parent(".varieties").next(".varietiesCate").find(".varietiesCateList>em>div>em.v1>img").removeClass("cateTypeChoice");
    //        $(this).parent("em.v1").parent(".varieties").next(".varietiesCate").find(".varietiesCateList>em>div>em.v1>img").attr("src","static/style_default/image/pro_07.png");
    //    }
    //
    //    if( ($(".varieties>em.v1>img").length)==($(".varieties>em.v1>img.choiceCate").length) ){
    //        $(this).parent("em.v1").parent(".varieties").parent("li.cateBody").parent("ul.cateList").children("li.cateHead").children("em.v1").children("img").addClass("cateHeadAllSelcet");
    //        $(this).parent("em.v1").parent(".varieties").parent("li.cateBody").parent("ul.cateList").children("li.cateHead").children("em.v1").children("img").attr("src","static/style_default/image/pro_23.png");
    //    }else{
    //        $(this).parent("em.v1").parent(".varieties").parent("li.cateBody").parent("ul.cateList").children("li.cateHead").children("em.v1").children("img").removeClass("cateHeadAllSelcet");
    //        $(this).parent("em.v1").parent(".varieties").parent("li.cateBody").parent("ul.cateList").children("li.cateHead").children("em.v1").children("img").attr("src","static/style_default/image/pro_07.png");
    //    }
    //
    //});

    $(".varietiesCateList>a>em.v1>img").click(function(){
           if(!($(this).hasClass("cateListChoice"))){
               $(this).addClass("cateListChoice");
               $(this).attr("src","static/style_default/image/pro_23.png");
               $(this).parent("em.v1").parent("a").parent(".varietiesCateList").children("em").children("div").children("em.v1").children("img").addClass("cateTypeChoice");
               $(this).parent("em.v1").parent("a").parent(".varietiesCateList").children("em").children("div").children("em.v1").children("img").attr("src","static/style_default/image/pro_23.png");
           }else{
               $(this).removeClass("cateListChoice");
               $(this).attr("src","static/style_default/image/pro_07.png");
               $(this).parent("em.v1").parent("a").parent(".varietiesCateList").children("em").children("div").children("em.v1").children("img").removeClass("cateTypeChoice");
               $(this).parent("em.v1").parent("a").parent(".varietiesCateList").children("em").children("div").children("em.v1").children("img").attr("src","static/style_default/image/pro_07.png");
           }

            if( ($(".varietiesCateList>a>em.v1>img").length)==($(".varietiesCateList>a>em.v1>img.cateListChoice").length) ){
                $(this).parent("em.v1").parent("a").parent(".varietiesCateList").parent(".varietiesCate").prev(".varieties").children("em.v1").children("img").addClass("choiceCate");
                $(this).parent("em.v1").parent("a").parent(".varietiesCateList").parent(".varietiesCate").prev(".varieties").children("em.v1").children("img").attr("src","static/style_default/image/pro_23.png");
            }else{
                $(this).parent("em.v1").parent("a").parent(".varietiesCateList").parent(".varietiesCate").prev(".varieties").children("em.v1").children("img").removeClass("choiceCate");
                $(this).parent("em.v1").parent("a").parent(".varietiesCateList").parent(".varietiesCate").prev(".varieties").children("em.v1").children("img").attr("src","static/style_default/image/pro_07.png");
            }

        console.log($(".varietiesCateList>a>em.v1>img.cateListChoice").length);
    });

    $(".varietiesCateList>em>div>em.v1>img").click(function(){
            if(!($(this).hasClass("cateTypeChoice"))){
                $(this).addClass("cateTypeChoice");
                $(this).attr("src","static/style_default/image/pro_23.png");
            }else{
                $(this).removeClass("cateTypeChoice");
                $(this).attr("src","static/style_default/image/pro_07.png");
            }
        console.log($(".varietiesCateList>a>em.v1>img.cateListChoice").length);
            if( ($(".varietiesCateList>em>div>em.v1>img").length)==($(".varietiesCateList>em>div>em.v1>img.cateTypeChoice").length) ){
                $(this).parent("em.v1").parent("div").parent("em").prev("a").children("em.v1").children("img").addClass("cateListChoice");
                $(this).parent("em.v1").parent("div").parent("em").prev("a").children("em.v1").children("img").attr("src","static/style_default/image/pro_23.png");
                $(this).parent("em.v1").parent("div").parent("em").parent(".varietiesCateList").parent(".varietiesCate").prev(".varieties").find("em.v1>img").addClass("choiceCate");
                $(this).parent("em.v1").parent("div").parent("em").parent(".varietiesCateList").parent(".varietiesCate").prev(".varieties").find("em.v1>img").attr("src","static/style_default/image/pro_23.png");
                //$(this).parent("em.v1").parent("div").parent("em").parent(".varietiesCateList").parent(".varietiesCate").parent(".cateBody").parent(".cateList").find(".cateHead>em.v1>img").addClass("cateHeadAllSelcet");
                //$(this).parent("em.v1").parent("div").parent("em").parent(".varietiesCateList").parent(".varietiesCate").parent(".cateBody").parent(".cateList").find(".cateHead>em.v1>img").attr("src","static/style_default/image/pro_23.png");
            }else{
                $(this).parent("em.v1").parent("div").parent("em").prev("a").children("em.v1").children("img").removeClass("cateListChoice");
                $(this).parent("em.v1").parent("div").parent("em").prev("a").children("em.v1").children("img").attr("src","static/style_default/image/pro_07.png");
                $(this).parent("em.v1").parent("div").parent("em").parent(".varietiesCateList").parent(".varietiesCate").prev(".varieties").find("em.v1>img").removeClass("choiceCate");
                $(this).parent("em.v1").parent("div").parent("em").parent(".varietiesCateList").parent(".varietiesCate").prev(".varieties").find("em.v1>img").attr("src","static/style_default/image/pro_07.png");
                $(this).parent("em.v1").parent("div").parent("em").parent(".varietiesCateList").parent(".varietiesCate").parent(".cateBody").parent(".cateList").find(".cateHead>em.v1>img").removeClass("cateHeadAllSelcet");
                $(this).parent("em.v1").parent("div").parent("em").parent(".varietiesCateList").parent(".varietiesCate").parent(".cateBody").parent(".cateList").find(".cateHead>em.v1>img").attr("src","static/style_default/image/pro_07.png");
            }

    })


    $(".varieties>em.v4>img").click(function(){
        if(!($(this).hasClass("disable"))){
            $(this).addClass("disable");
            $(this).attr("src","static/style_default/image/pro_33.png");
            $(this).parent("em.v4").parent(".varieties").find("em.v1>img").addClass("varietiesDisable");
            $(this).parent("em.v4").parent(".varieties").find("em.v1>img").attr("src","static/style_default/image/pro_46.png");
            $(this).parent("em.v4").parent(".varieties").find("em.v1>p").unbind("click");
            $(".varietiesCate").addClass("hide");
        }else{
            $(this).removeClass("disable");
            $(this).attr("src","static/style_default/image/pro_10.png");
            $(this).parent("em.v4").parent(".varieties").find("em.v1>img").removeClass("varietiesDisable");
            $(this).parent("em.v4").parent(".varieties").find("em.v1>img").attr("src","static/style_default/image/pro_07.png");
            $(this).parent("em.v4").parent(".varieties").find("em.v1>p").bind("click",function(){
                if($(".varietiesCate").hasClass("hide")){
                    $(this).parent("em.v1").parent(".varieties").next(".varietiesCate").removeClass("hide");
                    $(this).children("img").attr("src","static/style_default/image/pro_13.png");
                }else{
                    $(this).parent("em.v1").parent(".varieties").next(".varietiesCate").addClass("hide");
                    $(this).children("img").attr("src","static/style_default/image/pro_48.png");
                }
            })
        }
    })

    // 添加一级菜单
    function keyCode(codeNum,text1,text2,eleText,ele,a){
        var limitNum =codeNum;
        var pattern =text1 + limitNum + text2;
        eleText.html(pattern);
        ele.keyup(function(){
                var remain = a.val().length;
                if(remain >codeNum){
                    pattern = "字数超过限制！";
                    $('.firstCateName>em>img').attr("src","static/style_default/image/f_03.png");
                }else{
                    var result = limitNum - remain;
                    pattern = text1 + result + text2;
                    $('.firstCateName>em>img').attr("src","static/style_default/image/t_03.png");
                }
                eleText.html(pattern);
            }
        );
    }

    $('#firstCate').click(function(){keyCode(12,'还可以输入','字符/汉字',$('.firstCateName>em>span'),$('#firstCate'),$(this))})
    $("#firstCateDescribe").click(function(){keyCode(200,'','',$('.addClassification>form>ul>li.cateDescribe>p>span'),$('#firstCateDescribe'),$(this))})

    $(".cateDisplay>em").click(function(){
        if($(this).index()==1){
            $(this).parent("li.cateDisplay").find(".sure>img").attr("src","static/style_default/image/pro_36.png");
            $(".cateDisplay>em.deny>img").attr("src","static/style_default/image/pro_38.png");
        }else if($(this).index()==2){
            $(this).parent("li.cateDisplay").find(".deny>img").attr("src","static/style_default/image/pro_36.png");
            $(".cateDisplay>em.sure>img").attr("src","static/style_default/image/pro_38.png");
        }
    })
})









