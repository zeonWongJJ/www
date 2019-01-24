/**
 * Created by 7du-29 on 2017/9/11.
 */
$(function(){

    //初始化状态
    var addInitState={
        addRoleName:true,
        addPer:true,
        addRoleDes:true,
        addRoleJu:true
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
            addInitState.addRoleName=false;
        }else{
            var result = limitNum - remain;
            pattern = '还可以输入' + result + '字符/汉字';
            findEle2.attr("src",img1);
            addInitState.addRoleName=true;
        }
        findEle1.html(pattern);
        event.stopPropagation();
    }
    //角色名称
    $("#addRole_name").keyup(function(){
        keyCode(5,$(this),$(".addRoleName>em>span"),$(".addRoleName>em>img"),"/static/style_default/image/t_03.png","/static/style_default/image/f_03.png");
    });
    $("#addRole_name").blur(function(){
        if($(this).val()==""){
            $(".addRoleName>em>span").html("不能为空");
            $(".addRoleName>em>img").attr("src","/static/style_default/image/f_03.png");
            addInitState.addRoleName=false;
        }
    });

    //操作权限
    $(".addManagersDisplay>em").click(function(){
        if($(this).index()==1){
            $(this).parent("li.addManagersDisplay").find(".sure>img").attr("src","/static/style_default/image/pro_36.png");
            $(".addManagersDisplay>em.deny>img").attr("src","/static/style_default/image/pro_38.png");
            $(this).addClass("choice");
            $(".addManagersDisplay>em").not($(this)).removeClass("choice");
        }else if($(this).index()==2){
            $(this).parent("li.addManagersDisplay").find(".deny>img").attr("src","/static/style_default/image/pro_36.png");
            $(".addManagersDisplay>em.sure>img").attr("src","/static/style_default/image/pro_38.png");
            $(this).addClass("choice");
            $(".addManagersDisplay>em").not($(this)).removeClass("choice");

        }
        $(".addManagersDisplay>img").removeClass("hide");
        $("input[name='role_state']").val($(this).attr('value'));
        addInitState.addPer=true;
    });
    //角色描述
    $("#addRole_des").click(function(){
        addInitState.addRoleDes=true;
    });
    $("#addRole_des").focus(function(){
        console.log("fff");
        if(!($(this).val()=="")){
            $(".addRoleDescription>em>img").attr("src","/static/style_default/image/t_03.png");
        }
    });
    $("#addRole_des").blur(function(){
        if($(this).val()==""){
            $(".addRoleDescription>em").removeClass("hide");
            $(".addRoleDescription>em>span").html("不能为空");
            $(".addRoleDescription>em>img").attr("src","/static/style_default/image/f_03.png");
            addInitState.addRoleDes=false;
        }else{
            $(".addRoleDescription>em").removeClass("hide");
            $(".addRoleDescription>em>span").html("");
            $(".addRoleDescription>em>img").attr("src","/static/style_default/image/t_03.png");
        }
    });

    //角色权限
    $(".addUseMan>i").click(function(){
        console.log($(this).parent("li.useMan").find("i"));
        if(!($(this).find("img").hasClass("useChoice"))){
            $(this).find("img").addClass("useChoice");
            $(this).find("img").attr("src","/static/style_default/image/qx_03.png");
        }else{
            $(this).find("img").removeClass("useChoice");
            $(this).find("img").attr("src","/static/style_default/image/qx_05.png");
        }
        role_auth_all();
        addInitState.addRoleJu=true;
    });

    //提交
    $("#addRole").click(function(){
        if( addInitState.addRoleName && addInitState.addPer && addInitState.addRoleDes && addInitState.addRoleJu ){
            $(this).submit();
        }else{
            alert("格式错误！");
            return false;
        }
    })
});

function role_auth_all() {
    var role_auth = new Array();
    var i = 0;
    // 组装权限ids
    $('.useChoice').each(function(index, el) {
        role_auth[i] = $(this).attr('value');
        i++;
    });
    role_auth = role_auth.join(',')
    $("input[name='role_auth']").val(role_auth);
}










