/**
 * Created by 7du-29 on 2017/10/18.
 */
$(function(){
    var bottomAllselect=$(".bottomAllSelect>img");//底部全选按钮
    var dynaSelect=$(".choiceDynamic>em.v1>img");//用户选择

    //全选
    function allSelect(eleThis,addClassA,img1,img2){
        if(eleThis.hasClass(addClassA)){
            eleThis.removeClass(addClassA);
            eleThis.attr("src",img2);
            $(".choiceDynamic>em.v1>img").removeClass("dynaSelect");
            $(".choiceDynamic>em.v1>img").attr("src",img2);
        }else{
            eleThis.addClass(addClassA);
            eleThis.attr("src",img1);
            $(".choiceDynamic>em.v1>img").addClass("dynaSelect");
            $(".choiceDynamic>em.v1>img").attr("src",img1);
        }
    }
    bottomAllselect.click(function(){
        allSelect($(this),"allSelect","/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    });

    function dyna_select(eleThis,addClassA,img1,img2){
        var len;
        var classLen;
        if(eleThis.hasClass(addClassA)){
            eleThis.removeClass(addClassA);
            eleThis.attr("src",img2);
        }else{
            eleThis.addClass(addClassA);
            eleThis.attr("src",img1);
        }
        len=dynaSelect.length;
        classLen=$(".choiceDynamic>em.v1>img.dynaSelect").length;
        if( len==classLen ){
            bottomAllselect.addClass("allSelect");
            bottomAllselect.attr("src","/static/style_default/image/pro_23.png");
        }else{
            bottomAllselect.removeClass("allSelect");
            bottomAllselect.attr("src","/static/style_default/image/pro_07.png");
        }
    }
    dynaSelect.click(function(){
        dyna_select($(this),"dynaSelect","/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    });

    function stateBoxA(eleThis,style,ele,classA){
        eleThis.css(style);
        ele.removeClass(classA);
    };
    function stateBoxB(eleThis,style,ele,classA){
        eleThis.css(style);
        ele.addClass(classA);
    };

    $(".auditStatusBox").mouseover(function(){
        stateBoxA($(this),{"background":"white","border":"1px solid #ddd","border-bottom":"none"},$(".auditStatus"),"hide")
    });
    $(".auditStatusBox").mouseout(function(){
        stateBoxB($(this),{"background":"white","border":"1px solid #fff"},$(".auditStatus"),"hide")
    });
    $(".displayStatusBox").mouseover(function(){
        stateBoxA($(this),{"background":"white","border":"1px solid #ddd","border-bottom":"none"},$(".displayStatus"),"hide")
    });
    $(".displayStatusBox").mouseout(function(){
        stateBoxB($(this),{"background":"white","border":"1px solid #fff"},$(".displayStatus"),"hide")
    });
    $(".releaseTimeBox").mouseover(function(){
        stateBoxA($(this),{"background":"white","border":"1px solid #ddd","border-bottom":"none"},$(".releaseTime"),"hide")
    });
    $(".releaseTimeBox").mouseout(function(){
        stateBoxB($(this),{"background":"white","border":"1px solid #fff"},$(".releaseTime"),"hide")
    });

    //添加标签
    // function addTag(){
    //     var tagVal=$("#tag_name").val();
    //     if(tagVal==""){
    //         alert("不能为空");
    //     }else{
    //         $(".dragBox").append($("<div class='item dads-children dad-draggable-area'>"+"<span>"+tagVal+"</span>"+"<img class='moveTag' src='/static/style_default/image/pro_19.png'/>"+"</div>"));
    //     }
    //     console.log($(".dragBox>div"));
    // }
    // $(".addTag>a").click(function(){
    //     addTag();
    // });

    //删除标签
    // $(document).on("click",".moveTag",function(){
    //     $(this).parent(".item").remove();
    // });

    $(".tagShell").click(function(){
        $(".tagLay").removeClass("hide");
    });

    //关闭标签层
    $(".closeTag").click(function(){
        $(".tagLay").addClass("hide");
    });

    //查看图片
    function clickImg($this,imgSrc,lookPicSrc,eleClass){
        var $thisImg=imgSrc;
        var lookPic=lookPicSrc.attr("src",$thisImg);
        $(".picIndex").html($this.index()+1);
        $(".picLen").html($this.parent().children().length);
        $this.addClass(eleClass);
        $(".previewImg>i").not($this).removeClass(eleClass);
        $(".lookPicture").removeClass("hide");
    }
    $(".previewImg>i").click(function(){
        clickImg($(this),$(this).children("img").attr("src"),$(".pictureContent>img"),"picCur");
    });

    //下一张图片
    function changeNextImg(){
        var cImg=$(".previewImg>i.picCur").next().children().attr("src") ;
        $(".pictureContent>img").attr("src",cImg);
        $(".previewImg>i.picCur").next().addClass("picCur");
        $(".previewImg>i.picCur").prev().removeClass("picCur");
        $(".picIndex").html($(".previewImg>i.picCur").index()+1);
    }
    //上一张图片
    function changePrevImg(){
        var cImg=$(".previewImg>i.picCur").prev().children().attr("src") ;
        $(".pictureContent>img").attr("src",cImg);
        $(".previewImg>i.picCur").prev().addClass("picCur");
        $(".previewImg>i.picCur").next().removeClass("picCur");
        $(".picIndex").html($(".previewImg>i.picCur").index()+1);
    }

    $(".picNext").click(function(){
        changeNextImg();
    });
    $(".picPrev").click(function(){
        changePrevImg();
    });
    //关闭查看照片
    $(".closePic").click(function(){
        $(".lookPicture").addClass("hide");
    });

    //显示动态层
    $(".showDynamic").click(function(){
        $(".aynaPreview").removeClass("hide");
    });
    $(".closePreview").click(function(){
        $(".aynaPreview").addClass("hide");
    });

    function addTag($this,checkedTag,imgSrc){
        if($this.hasClass(checkedTag)){
            $this.removeClass(checkedTag);
            $this.children("img").remove();
        }else{
            $this.addClass(checkedTag);
            $this.append($("<img src='"+imgSrc+"'>"))
        }
    }
    //添加标签
   $(".tagList>ul>li").click(function(){
       addTag($(this),"checkedTag","/static/style_default/image/ac_03.png");
   });

    // $(".addTagPic").click(function(){
    //     $(".addTagContainer").removeClass("hide");
    // });
    $(".closeTag").click(function(){
        $(".addTagContainer").addClass("hide");
        $(".tagList ul li").each(function(index, el) {
            $(this).children('img').remove();
            $(this).removeClass('checkedTag');
        });
    });
    // $(".sureTag").click(function(){
    //     $(".addTagContainer").addClass("hide");
    // });

    // 分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });

    // 重置弹出窗口的屏幕显示位置
    var nagheight = $(window).height(); //浏览器时下窗口可视区域高度
    var nagwidth  = $(window).width(); //浏览器时下窗口可视区域宽
    var addtagh   = $('.addTagContainer').outerHeight();
    var addtagw   = $('.addTagContainer').outerWidth();
    $('.addTagContainer').css('top', (nagheight-addtagh)/2);
    $('.addTagContainer').css('left', (nagwidth-addtagw)/2);
    var tagLayh = $('.tagLay').outerHeight();
    var tagLayw = $('.tagLay').outerWidth();
    $('.tagLay').css('top', (nagheight-tagLayh)/2);
    $('.tagLay').css('left', (nagwidth-tagLayw)/2);
    var aynaPreviewh = $('.aynaPreview').outerHeight();
    var aynaPrevieww = $('.aynaPreview').outerWidth();
    $('.aynaPreview').css('top', (nagheight-aynaPreviewh)/2);
    $('.aynaPreview').css('left', (nagwidth-aynaPrevieww)/2);
    var pop_tipsh = $('.pop_tips').outerHeight();
    var pop_tipsw = $('.pop_tips').outerWidth();
    $('.pop_tips').css('top', (nagheight-pop_tipsh)/2);
    $('.pop_tips').css('left', (nagwidth-pop_tipsw)/2);


});












