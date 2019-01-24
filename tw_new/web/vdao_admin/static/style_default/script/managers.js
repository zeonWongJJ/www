/**
 * Created by 7du-29 on 2017/9/11.
 */
$(function(){
    var head_allselect=$(".cateHead>em.v1>img");//全选
    var bottomAllselect=$(".bottomAllSelect>img");//底部全选按钮
    var choice_role=$(".varieties>em.v1>img");//选择角色
    var varietiesDisable=$(".varieties>em.v4>img");//是否开放

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
    //全选
    head_allselect.click(function(){
        allSelect($(this),"all_select","bottom_allSelect","varietiesChoice",bottomAllselect,$(".varieties>em.v1>img"),"/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png")
    });
    //底部工具栏全选
    bottomAllselect.click(function(){
        allSelect($(this),"bottom_allSelect","all_select","varietiesChoice",head_allselect,$(".varieties>em.v1>img"),"/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    });

    //  选择角色
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
        len=choice_role.length;
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

    choice_role.click(function(){
        varieties($(this),"varietiesChoice","all_select","bottom_allSelect","/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png")
    });

    //启用/暂用
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


    //初始化状态
    var subState={
        roleName:false,
        per:false,
        roleDes:false,
        roleJu:false
    };
    //
    function keyCode(codeNum,eleThis,findEle1,findEle2,img1,img2){
        var limitNum =codeNum;
        var pattern = limitNum;
        findEle1.html(pattern);
        var remain = eleThis.val().length;
        if(remain >codeNum){
            pattern = "字数超过限制！";
            findEle2.attr("src",img2);
            subState.roleName=false;
        }else{
            var result = limitNum - remain;
            pattern = '还可以输入' + result + '字符/汉字';
            findEle2.attr("src",img1);
            subState.roleName=true;
        }
        findEle1.html(pattern);
        event.stopPropagation();
    }
    //角色名称
    $("#role_name").keyup(function(){
        keyCode(5,$(this),$(".roleName>em>span"),$(".roleName>em>img"),"/static/style_default/image/t_03.png","/static/style_default/image/f_03.png");
    });
    $("#role_name").blur(function(){
        if($(this).val()==""){
            $(".roleName>em>span").html("不能为空");
            $(".roleName>em>img").attr("src","/static/style_default/image/f_03.png");
            subState.roleName=false;
        }
    });

    //是否启用
    $(".managersDisplay>em").click(function(){
        if($(this).index()==1){
            $(this).parent("li.managersDisplay").find(".sure>img").attr("src","/static/style_default/image/pro_36.png");
            $(".managersDisplay>em.deny>img").attr("src","/static/style_default/image/pro_38.png");
            $(this).addClass("choice");
            $(".managersDisplay>em").not($(this)).removeClass("choice");
            $("input[name='role_state']").val($(this).attr('value'));
        }else if($(this).index()==2){
            $(this).parent("li.managersDisplay").find(".deny>img").attr("src","/static/style_default/image/pro_36.png");
            $(".managersDisplay>em.sure>img").attr("src","/static/style_default/image/pro_38.png");
            $(this).addClass("choice");
            $(".managersDisplay>em").not($(this)).removeClass("choice");
            $("input[name='role_state']").val($(this).attr('value'));
        }
        $(".managersDisplay>img").removeClass("hide");
        subState.per=true;
    });
    //角色描述
    $("#role_des").click(function(){
        subState.roleDes=true;
    });
    $("#role_des").focus(function(){
        console.log("fff");
        if(!($(this).val()=="")){
            $(".roleDescription>em>img").attr("src","/static/style_default/image/t_03.png");
        }
    });
    $("#role_des").blur(function(){
        if($(this).val()==""){
            $(".roleDescription>em>span").html("不能为空");
            $(".roleDescription>em>img").attr("src","/static/style_default/image/f_03.png");
            subState.roleDes=false;
        }else{
            $(".roleDescription>em>span").html("");
            $(".roleDescription>em>img").attr("src","/static/style_default/image/t_03.png");
        }
    });

    //角色权限
    $(".useMan>i").click(function(){
        console.log($(this).parent("li.useMan").find("i"));
        if(!($(this).find("img").hasClass("useChoice"))){
            $(this).find("img").addClass("useChoice");
            $(this).find("img").attr("src","/static/style_default/image/qx_03.png");
        }else{
            $(this).find("img").removeClass("useChoice");
            $(this).find("img").attr("src","/static/style_default/image/qx_05.png");
        }
        role_auth_all();
        subState.roleJu=true;
    });
    //关闭 编辑角色
    $(".closeRole").click(function(){
        $(".editRole").addClass("hide");
    });

    //提交
    $("#manSub").click(function(){
        if(subState.roleName && subState.per && subState.roleDes && subState.roleJu){
            $(this).submit();
        }else{
            return false;
        }
    })

    // 重置弹出窗口的屏幕显示位置
    var nagheight = $(window).height(); //浏览器时下窗口可视区域高度
    var nagwidth  = $(window).width(); //浏览器时下窗口可视区域宽
    var tiph   = $('.pop_tips').outerHeight();
    var tipw   = $('.pop_tips').outerWidth();
    $('.pop_tips').css('top', (nagheight-tiph)/2);
    $('.pop_tips').css('left', (nagwidth-tipw)/2);

    var editRoleh   = $('.editRole').outerHeight();
    var editRolew   = $('.editRole').outerWidth();
    $('.editRole').css('top', (nagheight-editRoleh)/2);
    $('.editRole').css('left', (nagwidth-editRolew)/2);

});

function role_auth_all() {
    var role_auth = new Array();
    var i = 0;
    // 组装权限ids
    $('.useChoice').each(function(index, el) {
        role_auth[i] = $(this).attr('value');
        i++;
    });
    role_auth = role_auth.join('-')
    $("input[name='role_auth']").val(role_auth);
}












