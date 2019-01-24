/**
 * Created by 7du-29 on 2017/10/11.
 */
$(function(){
    // $("#userPoints").click(function(e){$(this).submit();e.stopPropagation();});

    $(".pointListContent>i").mouseenter(function(){
        $(this).find(".toolBox").removeClass("hide");
    });
    $(".pointListContent>i").mouseleave(function(){
        $(this).find(".toolBox").addClass("hide");
    });

    var pointsState={
        surplus:false,//盈余
        remarksr:false//备注
    };
    //积分盈余额度
    $("#points_surplus").blur(function(){
        var totalNum=parseFloat($(".totalNum").text());//总额
        var calculationNum=$(".calculationNum");
        if($(this).val()==""){
            $(this).next("em").removeClass("hide");
            $(this).next("em").children("img").attr("src","/static/style_default/image/f_03.png");
            $(this).next("em").children("span").html("请输入修改后的积分盈余");
            $(this).next("em").children("em").addClass("hide");
            pointsState.surplus=false;
            return false;
        }else if($(this).val()<parseFloat(totalNum)){
            $(this).next("em").children("span").html("");
            $(this).next("em").removeClass("hide");
            $(this).next("em").children("img").attr("src","/static/style_default/image/t_03.png");
            $(this).next("em").children("em").removeClass("hide");
            $(".pointNumText").html("减少了");
            var add_total_score  = parseFloat($(this).val());
            var totalNums = numSub(add_total_score ,totalNum);
            totalNums = parseFloat(totalNums.replace('-',''));
            calculationNum.html(totalNums);
            pointsState.surplus=true;
            return true;
        }else if($(this).val()>parseFloat(totalNum)){
            $(this).next("em").children("span").html("");
            $(this).next("em").removeClass("hide");    
            $(this).next("em").children("img").attr("src","/static/style_default/image/t_03.png");
            $(this).next("em").children("em").removeClass("hide");
            $(".pointNumText").html("增加了");
            var add_total_score  = parseFloat($(this).val());
            var totalNums = numSub(totalNum ,add_total_score);
             totalNums = parseFloat(totalNums.replace('-',''));
            calculationNum.html(totalNums);
            pointsState.surplus=true;
            return true;
        }
    });

 /**
 * 加法运算，避免数据相减小数点后产生多位数和计算精度损失。
 *
 * @param num1被减数  |  num2减数
 */
function numSub(num1, num2) {

 var baseNum, baseNum1, baseNum2;

 var precision;// 精度

 try {

  baseNum1 = num1.toString().split(".")[1].length;

 } catch (e) {

  baseNum1 = 0;

 }

 try {

  baseNum2 = num2.toString().split(".")[1].length;

 } catch (e) {

  baseNum2 = 0;

 }

 baseNum = Math.pow(10, Math.max(baseNum1, baseNum2));

 precision = (baseNum1 >= baseNum2) ? baseNum1 : baseNum2;

 return ((num1 * baseNum - num2 * baseNum) / baseNum).toFixed(precision);

};

    //备注
    $("#points_remarks").blur(function(){
        if($(this).val()==""){
            $(this).next("em").removeClass("hide");
            $(this).next("em").children("img").attr("src","/static/style_default/image/f_03.png");
            $(this).next("em").children("span").html("请输入备注");
            pointsState.remarksr=false;
            return false;
        }else if($(this).val().length>0){
            $(this).next("em").removeClass("hide");
            $(this).next("em").children("img").attr("src","/static/style_default/image/t_03.png");
            $(this).next("em").children("span").html("");
            pointsState.remarksr=true;
            return true;
        }
    });
    //提交
    $("#editPointsSub").click(function(){
        if( pointsState.remarksr && pointsState.surplus ){
            $(".editPoint>form").submit();
        }else{
            $(".subWrong").removeClass("hide");
            return false;
        }
    });

    $(".editPoints").click(function(e){
        e.stopPropagation();
        var user_score = $(this).attr('value');
        $('.totalNum').html(user_score);
        $("input[name='user_id']").val($(this).attr('uid'));
        $(".editPoint").removeClass("hide");
    });

    $(".closePoint").click(function(){
        $(".tips").removeClass("hide");
    });

    $(".ensure").click(function(){
        $(".editPoint").addClass("hide");
        $(".tips").addClass("hide");
    });
    $(".subSure").click(function(){
        $(".subWrong").addClass("hide");
    })

    $(".notsure,.thinkpic").click(function(){
        $(".tips").addClass("hide");
    });

    // 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });

});







