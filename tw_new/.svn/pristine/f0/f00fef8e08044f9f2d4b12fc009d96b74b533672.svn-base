/*** Created by 7du-29 on 2017/9/7.*/
$(function(){
    var head_allselect=$(".cateHead>em.v1>img");//全选
    var body_roomselect=$(".varieties>em.v1>img");//房间用途
    var room_type=$(".varietiesCateList>a>em.v1>img");//房间类型
    var showList=$(".varieties>em.v1>p");//显示/隐藏 房间类型列表
    var ableBtnA=$(".varieties>em.v6>img");// 是否开放按钮
    var ableBtnB=$(".varietiesCateList>a>em.v6>img");// 是否开放按钮
    var bottom_allselect=$(".bottomAllSelect>img");//底部全选

    // 全选
    function allselect(eleThis,selectEleA,selectEleB,selectEleC,add_class1,add_class2,add_class3,add_class4,img1,img2){
        if( !(eleThis.hasClass(add_class1)) ){
            eleThis.addClass(add_class1);
            eleThis.attr("src",img1);
            selectEleA.addClass(add_class2);
            selectEleA.attr("src",img1);
            selectEleB.addClass(add_class3);
            selectEleB.attr("src",img1);
            selectEleC.addClass(add_class4);
            selectEleC.attr("src",img1);
        }else{
            eleThis.removeClass(add_class1);
            eleThis.attr("src",img2);
            selectEleA.removeClass(add_class2);
            selectEleA.attr("src",img2);
            selectEleB.removeClass(add_class3);
            selectEleB.attr("src",img2);
            selectEleC.removeClass(add_class4);
            selectEleC.attr("src",img2);
        }
    }
    head_allselect.click(function(){
        allselect($(this),body_roomselect,room_type,bottom_allselect,"all_select","body_selectA","body_selectB","bottom_allselect","/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    });

    function bottomAllselect(eleThis,add_class1,add_class2,add_class3,add_class4,img1,img2){
        if( !(eleThis.hasClass(add_class1)) ){
            eleThis.addClass(add_class1);
            eleThis.attr("src",img1);
            body_roomselect.addClass(add_class2);
            body_roomselect.attr("src",img1);
            room_type.addClass(add_class3);
            room_type.attr("src",img1);
            head_allselect.addClass(add_class4);
            head_allselect.attr("src",img1);
        }else{
            eleThis.removeClass(add_class1);
            eleThis.attr("src",img2);
            body_roomselect.removeClass(add_class2);
            body_roomselect.attr("src",img2);
            room_type.removeClass(add_class3);
            room_type.attr("src",img2);
            head_allselect.removeClass(add_class4);
            head_allselect.attr("src",img2);
        }
    }
    bottom_allselect.click(function(){
        bottomAllselect($(this),"bottom_allselect","body_selectA","body_selectB","all_select","/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    })

    //选择房间用途
    function room_user(eleThis,allSelect,bottomAllselect,add_class1,add_class2,add_class3,add_class4,findEle_child,img1,img2){
        var roomUser_len;
        var roomUserClass_len;
        if( !(eleThis.hasClass(add_class1)) ){
            eleThis.addClass(add_class1);
            eleThis.attr("src",img1);
            findEle_child.addClass(add_class3);
            findEle_child.attr("src",img1);
        }else{
            eleThis.removeClass(add_class1);
            eleThis.attr("src",img2);
            findEle_child.removeClass(add_class3);
            findEle_child.attr("src",img2);
        }
        roomUserClass_len=$(".varieties>em.v1>img.body_selectA").length;
        roomUser_len=$(".varieties>em.v1>img").length;
        console.log(roomUserClass_len);
        if(roomUser_len==roomUserClass_len ){
            allSelect.addClass(add_class2);
            allSelect.attr("src",img1);
            bottomAllselect.addClass(add_class4);
            bottomAllselect.attr("src",img1);
        }else{
            allSelect.removeClass(add_class2);
            allSelect.attr("src",img2);
            bottomAllselect.removeClass(add_class4);
            bottomAllselect.attr("src",img2);
        }
    }
    body_roomselect.click(function(){
        room_user($(this),head_allselect,bottom_allselect,"body_selectA","all_select","body_selectB","bottom_allselect",$(this).parent("em.v1").parent(".varieties").next(".varietiesCate").find(".varietiesCateList>a>em.v1>img"),"/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    });

    //房间类型
    function roomType(eleThis,add_class1,add_class2,roomUser,img1,img2){
        var roomType_len;
        var roomTypeClass_len;
        if( !(eleThis.hasClass(add_class1)) ){
            eleThis.addClass(add_class1);
            eleThis.attr("src",img1);
        }else{
            eleThis.removeClass(add_class1);
            eleThis.attr("src",img2);
        }
        //获取房间用途复选框的个数
        roomType_len=eleThis.parent("em.v1").parent("a").parent(".varietiesCateList").parent(".varietiesCate").find(".varietiesCateList>a>em.v1>img").length;
        //获取房间用途复选框选中的个数
        roomTypeClass_len=eleThis.parent("em.v1").parent("a").parent(".varietiesCateList").parent(".varietiesCate").find(".varietiesCateList>a>em.v1>img.body_selectB").length;
        console.log(roomTypeClass_len);
        if( roomType_len==roomTypeClass_len ){
            roomUser.addClass(add_class2);
            roomUser.attr("src",img1);
        }else{
            roomUser.removeClass(add_class2);
            roomUser.attr("src",img2);
        }
        room_user($(this),head_allselect,bottom_allselect,"body_selectA","all_select","body_selectB","bottom_allselect",$(this).parent("em.v1").parent(".varieties").next(".varietiesCate").find(".varietiesCateList>a>em.v1>img"),"/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    }

    room_type.click(function(){
        roomType($(this),"body_selectB","body_selectA",$(this).parent("em.v1").parent("a").parent(".varietiesCateList").parent(".varietiesCate ").prev(".varieties").find("em.v1>img"),"/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    })

    //显示分级列表
    function roomList(thisImg,hide,findEle1,img1,img2){
        if( findEle1.hasClass(hide) ){
            findEle1.removeClass(hide);
            thisImg.attr("src",img1);
        }else{
            findEle1.addClass(hide);
            thisImg.attr("src",img2);
        }
    }

    showList.click(function(){
        roomList($(this).children("img"),"hide",$(this).parent("em.v1").parent(".varieties").next(".varietiesCate"),"/static/style_default/image/pro_13.png","/static/style_default/image/pro_48.png");
    })

    //是否开放按钮
    function disable_btnA(eleThis,add_class1,add_class2,add_class3,add_class4,findThisEleA,img1,img2){
        if( !(eleThis.hasClass(add_class1)) ){
            eleThis.addClass(add_class1);
            eleThis.attr("src",img2);
        }else{
            eleThis.removeClass(add_class1);
            eleThis.attr("src",img1);
        }
    }

    ableBtnA.click(function(){
        disable_btnA(
            $(this),
            "disabled",
            "roomUse_disabled",
            "body_selectA",
            "body_selectB",
            $(this).parent("em.v6").parent(".varieties").find("em.v1>img"),
            "/static/style_default/image/pro_10.png",
            "/static/style_default/image/pro_33.png"
        );
    })

    function disable_btnB(eleThis,add_class1,img1,img2){
        if( !(eleThis.hasClass(add_class1)) ){
            eleThis.addClass(add_class1);
            eleThis.attr("src",img1);

        }else{
            eleThis.removeClass(add_class1);
            eleThis.attr("src",img2);
        }
    }

    ableBtnB.click(function(){
        disable_btnB(
            $(this),
            "disabled",
            "/static/style_default/image/pro_33.png",
            "/static/style_default/image/pro_10.png"
        );
    });

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
    var tiph   = $('.tips').outerHeight();
    var tipw   = $('.tips').outerWidth();
    $('.tips').css('top', (nagheight-tiph)/2);
    $('.tips').css('left', (nagwidth-tipw)/2);


})