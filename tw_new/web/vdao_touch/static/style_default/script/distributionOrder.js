/**
 * Created by 7du-29 on 2017/12/2.
 */
$(function(){
    $(".lay").hide();
    $(".lay1").hide();
    $(".payment").hide();
    $(".choiceTime").hide();

    // $(".deductible>ul>li.blance>img").click(function(){
    //     var mone = $('.mone').text();
    //     console.log(mone);
    //     var noue = $('#pute').text();
    //     var noue = noue.replace(/￥/g,"");
    //     if (mone > 0) {
    //         if( $(this).hasClass("deg") ){
    //             yute = Number(noue) + Number(mone);
    //             $('#pute').text('￥'+yute.toFixed(2));
    //             $('.surePay>a>span>em').text('￥'+yute.toFixed(2));
    //             $('#actual_pay').val(yute);
    //             $('#mone').val(1);
    //             $('#balance_deduction').val('');
    //             $(this).removeClass("deg");
    //             $(this).attr("src","static/style_default/images/dr_03.png");
    //             nout();
    //         }else{
    //             yute = Number(noue) - Number(mone);
    //             $('#pute').text('￥'+yute.toFixed(2));
    //             $('.surePay>a>span>em').text('￥'+yute.toFixed(2));
    //             $('#actual_pay').val(yute);
    //             $('#balance_deduction').val(mone);
    //             $('#mone').val(2);
    //             $(this).addClass("deg");
    //             $(this).attr("src","static/style_default/images/dr_09.png");
    //             nout();
    //         }
    //     }
    // });
    // $(".deductible>ul>li.point>img").click(function(){
    //     var score = $('.score').text();
    //     console.log(score);
    //     var noue = $('#pute').text();
    //     var noue = noue.replace(/￥/g,"");
    //     if (score > 0) {
    //         if( $(this).hasClass("deg") ){
    //             yute = Number(noue) + Number(score);
    //             $('#pute').text('￥'+yute.toFixed(2));
    //             $('.surePay>a>span>em').text('￥'+yute.toFixed(2));
    //             $('#actual_pay').val(yute);
    //             $('#score').val(1);
    //             $('#score_deduction').val('');
    //             $(this).removeClass("deg");
    //             $(this).attr("src","static/style_default/images/dr_03.png");
    //             none();
    //         }else{
    //             yute = Number(noue) - Number(score);
    //             $('#pute').text('￥'+yute.toFixed(2));
    //             $('.surePay>a>span>em').text('￥'+yute.toFixed(2));
    //             $('#actual_pay').val(yute);
    //             $('#score').val(2);
    //             $('#score_deduction').val(score);
    //             $(this).addClass("deg");
    //             $(this).attr("src","static/style_default/images/dr_09.png");
    //             none();
    //         }
    //     };        
    // });
   	/*$(".deductible>ul>li.blance>img").click(function(){
   		var subtotal = $('.totalBox>em>dfn').text();//小计的价格
   		subtotal=subtotal.replace(/￥/g,"");
   		Number(subtotal);
        var noue = $('#pute');//最终付款的价格
//      noue = noue.replace(/￥/g,"");   
        Number(noue);
        var balance=$(".blance>em>span").html();//余额
        Number(balance);
        var mone=$(".mone");//抵扣的余额
        if( $(this).hasClass("deg") ){
        	$(this).removeClass("deg");
        	$(this).attr("src","static/style_default/images/dr_03.png");
        }else{
        	if( balance>=subtotal ){
//      		mone.html(balance-subtotal);
        	}
        	$(this).addClass("deg");
        	$(this).attr("src","static/style_default/images/dr_09.png");
        }
   	})*/
   	
   	
   
    //总计
    // function price(){
    //     var sn=0;
    //     var sp=0;
    //     var pri=0;
    //     var total=0;
    //     var gf;
    //     $(".dishes").each(function(i){
    //         var strNum=$(".dishes").eq(i).children("em").html();
    //         var strPri=$(".dishes").eq(i).children("dfn").html();
    //         strNum=strNum.substring(1);
    //         strPri=strPri.substring(1);
    //         Number(strPri);
    //         var ss=Math.floor(strPri*100)/100;
    //         pri=Number(strNum)*ss;
    //         total=Number(total)+pri;
    //         gf=Math.floor(total*100)/100;
    //         Number(gf);
    //         sn=sn+Number(strNum);
    //         sp=sp+Number(strPri);
    //     });
    //     var send=$(".distri>dfn").html();
    //     send=send.substring(1);
    //     $(".totalBox>span>em").html(sn);
    //     $(".totalBox>em>dfn").html("￥"+(gf+Number(send)));
    //     $('#actual_pay').val(parseInt(total+parseInt(send)));
    //     $('#goods_amount').val(parseInt(total+parseInt(send)));
    //     $('#pute').html("￥"+(gf+Number(send)));
    //     $('#moune').html("￥"+(gf+Number(send)));
    //     // $("input[name='goods_amount']").val(parseInt(total+parseInt(send)));
    //     // $("input[name='order_count']").val(sn);
    // }
    // price();
    //送达时间
    $(".serviceTime").click(function(){
        $(".lay1").show();
        $(".choiceTime").slideDown(100);
        $("html,body").addClass("ovfHiden");
    });

    $(".time>ul>li").click(function(){
        $(this).addClass("timeCur");
        $(".time>ul>li").not($(this)).removeClass("timeCur");
        var time = $('.timeCur>span').text();
        $('#time').text(time);
        $('#time_delay').val(time);       
        setTimeout(function(){
        	$('.lay1').hide();//加
        	$(".choiceTime").slideUp(100);	
        },300)
        $("html,body").removeClass("ovfHiden");
    });

    $(".closeTime").click(function(){
        $(".lay1").hide();
        $(".choiceTime").slideUp(100);
        $("html,body").removeClass("ovfHiden");
    });

    //付款
    $(".bottom>a").click(function(){
        $(".lay").show();
        $(".payment").slideDown(100);
        getTime();
    });

    $(".payment>dl>dd.clickdd").click(function(){
        $(this).addClass("payCur");
        $(".payment>dl>dd").not($(this)).removeClass("payCur");
        $(".payCur>i").show();
        $(".payment>dl>dd>i").not($(".payCur>i")).hide();
        $("input[name='pay_type']").val($(this).attr('value'));
    });

    $(".closeSurplus").click(function(){
        $(".lay").hide();
        $(".payment").slideUp(100);
    });
    //点击灰屏弹框消失
    $('.lay1').click(function(){
    	$('.lay1').hide();//加
        $(".choiceTime").slideUp(100);
    })
    //30分钟倒计时
    function getTime(){
        var x=30,t;
        var d = new Date("1111/1/1,0:" + x + ":0");
        t = setInterval(function() {
            var m = d.getMinutes();
            var s = d.getSeconds();
            m = m < 10 ? "0" + m : m;
            s = s < 10 ? "0" + s : s;
            $(".surplusTime>span>em").html(m + "分" + s+"秒");
            if (m == 0 && s == 0) {
                clearInterval(t);
                return;
            }
            d.setSeconds(s - 1);
        }, 1000);
    }
    none();
    nout();
    function none () {
        var noet = $("#pute").text();
        mout = noet.replace(/￥/g,"");
        // console.log(mout);
        var id = $(".deductible>ul>li.blance>em>span").text();
        if ( Number(id) > Number(mout)) {
            $(".mone").text(mout);
        } else {
            $(".mone").text(id);
        };
    }
    function nout () {
        var noet = $("#pute").html();
        mout = noet.replace(/￥/g,"");
        // console.log(mout);
        var te = $(".deductible>ul>li.point>em>span").html();
        if (Number(te) > Number(mout)) {
            $(".score").text(mout);
        } else {
            $(".score").text(te);
        };
    }
});


















