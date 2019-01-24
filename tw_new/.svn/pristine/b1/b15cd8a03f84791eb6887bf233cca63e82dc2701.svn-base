/**
 * Created by 7du-29 on 2017/10/14.
 */
$(function(){
    var accountState={
        correct:false,//是否正确
        price:false,//金额
        remarksr:false//备注
    };

    //积分盈余额度
    $("#edit_Price").blur(function(){
        var totalNum=$(".totalNum").text();//总额
        var calculationNum=$(".calculationNum");
        if($(this).val()==""){
            $(this).next("em").removeClass("hide");
            $(this).next("em").children("img").attr("src","/static/style_default/image/f_03.png");
            $(this).next("em").children("span").html("请输入修改后的结算金额");
            $(this).next("em").children("em").addClass("hide");
            accountState.price=false;
            return false;
        }else if($(this).val()==parseInt(totalNum)){
        	console.log("0");
            $(this).next("em").children("span").html("");
            $(this).next("em").removeClass("hide");
            $(this).next("em").children("img").attr("src","/static/style_default/image/f_03.png");
            $(this).next("em").children("em").removeClass("hide");
            $(".pointNumText").html("不能相同！");
            calculationNum.html(totalNum-$(this).val());
            accountState.price=false;
            return false;
        }else if($(this).val()<parseInt(totalNum)){
        	console.log("1");
            $(this).next("em").children("span").html("");
            $(this).next("em").removeClass("hide");
            $(this).next("em").children("img").attr("src","/static/style_default/image/t_03.png");
            $(this).next("em").children("em").removeClass("hide");
            $(".pointNumText").html("减少了");
            calculationNum.html(totalNum-$(this).val());
            accountState.price=true;
            return true;
        }else if($(this).val()>parseInt(totalNum)){
        	console.log("2");
            $(this).next("em").children("span").html("");
            $(this).next("em").removeClass("hide");
            $(this).next("em").children("img").attr("src","/static/style_default/image/t_03.png");
            $(this).next("em").children("em").removeClass("hide");
            $(".pointNumText").html("增加了");
            calculationNum.html($(this).val()-totalNum);
            accountState.price=true;
            return true;
        }
    });
    //备注
    $("#account_remarks").blur(function(){
        if($(this).val()==""){
            $(this).next("em").removeClass("hide");
            $(this).next("em").children("img").attr("src","/static/style_default/image/f_03.png");
            $(this).next("em").children("span").html("请输入备注");
            accountState.remarksr=false;
            return false;
        }else if($(this).val().length>0){
            $(this).next("em").removeClass("hide");
            $(this).next("em").children("img").attr("src","/static/style_default/image/t_03.png");
            $(this).next("em").children("span").html("");
            accountState.remarksr=true;
            return true;
        }
    });

    //是否正确
    $(".correct>em").click(function(){
        if($(this).index()==1){
            $(this).parent("li.correct").find(".sure>img").attr("src","/static/style_default/image/pro_36.png");
            $(".correct>em.deny>img").attr("src","/static/style_default/image/pro_38.png");
        }else if($(this).index()==2){
            $(this).parent("li.correct").find(".deny>img").attr("src","/static/style_default/image/pro_36.png");
            $(".correct>em.sure>img").attr("src","/static/style_default/image/pro_38.png");
        }
        $("input[name='is_correct']").val($(this).attr('value')); // 渲染模板时修改的
        $(".correct>img").attr("src","/static/style_default/image/t_03.png");
        accountState.correct=true;
        return true;
    });

    //提交
    $("#accountSub").click(function(){
        if( accountState.correct && accountState.remarksr && accountState.price ){
            //$(this).submit();
            // $(".accountAm >form").submit();
            var account_id    = $("input[name='account_id']").val();
            var is_correct    = $("input[name='is_correct']").val();
            var money_update  = $("input[name='money_update']").val();
            var remark_update = $("textarea[name='remark_update']").val();
            $.ajax({
                url: 'account_update',
                type: 'POST',
                dataType: 'json',
                data: {account_id: account_id, is_correct: is_correct, money_update: money_update, remark_update: remark_update},
                success: function(res) {
                    $(window.parent.close_he(res.code));
                }
            })
        }else{
            alert("格式错误或有选项未选择!")
            return false;
        }
    });
})














