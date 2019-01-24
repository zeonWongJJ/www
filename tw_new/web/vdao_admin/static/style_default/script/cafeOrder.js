﻿/**
 * Created by 7du-29 on 2017/10/19.
 */
$(function(){
	$(".cafeOrders").hide();
    //备注
    $(".remark>img").click(function(e){
        $(this).next($("#disappare")).show(300).delay(3000).hide(300);

    });

	   //让指定的DIV始终显示在屏幕正中间  
    function setDivCenter(divName){  
        var top = ($(window).height() - divName.height())/4;  
        var left = ($(window).width() - divName.width())/2;  
        var scrollTop = $(document).scrollTop();  
//      var scrollLeft = $(document).scrollLeft();  
        divName.css( { 'top' : top + scrollTop } ).show(); 
    }

    $('.order_id').click(function() {
        var order_id = $(this).attr('value');
//      $('.cafeOrders').removeClass("hide");
        setDivCenter($('.cafeOrders'))
        $.ajax({
            type : 'post',
            url  : 'order_details',
            data : "id="+order_id,
            dataType : 'json',
            success  : function(data) {
                    for(var i in data){
                        var number = data[0].order_number;
                        var name   = data[0].reciver_name;
                        var addres = data[0].addres;
                        var phone  = data[0].mob_phone;
                        var points = data[0].use_points;
                        var fee    = data[0].shipping_fee;
                        var price  = data[0].actual_pay;
                        var code   = data[0].payment_code;
                        var create = formatDate('Y-m-d H:i',data[0].time_create);
                        var delay  = data[0].time_delay;
                    }
                    if (code == 'offline') {
                       var code = '微信付款';
                    } else if (code == 'online') {
                       var code = '在线支付';
                    } else if (code == 'alipay') {
                       var code = '支付宝';
                    };
                    var html = '<div class="ordersNums">'
                                +'<em>'
                                    +'<i></i>'
                                    +'<hr/>'
                                +'</em>'
                                +'<div class="ordersContent">'
                                    +'<h4>订单编号</h4>'
                                    +'<p>'+number+'</p>'
                                +'</div>'
                            +'</div>'
                            +'<div class="ordersTime">'
                                +'<em>'
                                    +'<i></i>'
                                    +'<hr/>'
                                +'</em>'
                                +'<div class="ordersContent">'
                                    +'<h4>下单时间/预约时间</h4>'
                                    +'<p>'+create+'/'+delay+'</p>'
                                +'</div>'
                            +'</div>'
                            +'<div class="takeOver">'
                                +'<em>'
                                    +'<i></i>'
                                    +'<hr/>'
                                +'</em>'
                                +'<div class="ordersContent">'
                                   +' <h4>收获信息</h4>'
                                    +'<p>联系人：'+name+'</p>'
                                    +'<p>联系电话：'+phone+'</p>'
                                    +'<p>联系地址：'+addres+'</p>'
                                +'</div>'
                            +'</div>'
                            +'<div class="placeOrders">'
                               +'<em>'
                                    +'<i></i>'
                                +'</em>'
                                +'<div class="ordersContent">'
                                    +'<h4>订单产品</h4>';
                                for(var it in data){                   
                                    html += '<p>'
                                                +'<span>'+data[it].product_name+'</span>'
                                                +'<em>x'+data[it].goods_num+'</em>'
                                                +'<dfn>¥'+data[it].money+'</dfn>'
                                             +'</p>';
                                };
                                html += '<div class="redPacket">'
                                       +'<em>积分优惠</em>'
                                        +'<span>-¥'+points+'</span>'
                                    +'</div>'
                                    +'<div class="distributionFee">'
                                        +'<em>配送费</em>'
                                        +'<span>¥'+fee+'</span>'
                                    +'</div>'
                                    +'<div class="weChatPay">'
                                        +'<span>'+code+'</span>'
                                        +'<em>¥'+price+'</em>'
                                    +'</div>'
                                +'</div>'
                            +'</div>'
                            +'<div class="closeLay" style="margin-top:15px;"><span>关闭窗口</span></div>';
                $('.cafeOrders').html(html);
            }
        })
    })
    $('.cafeOrders').click(function() {
        $(this).hide();
    })
});
var i = 0;
function doProgress(eleNum) {
    if (i > 1000) {
        return;
    }
    if (i <=eleNum) {
        setTimeout("doProgress(700)",10);
        SetProgress(i);
        i+=10;
    }
}

function formatDate(format, timestamp){   
    var a, jsdate=((timestamp) ? new Date(timestamp*1000) : new Date());  
    var pad = function(n, c){  
        if((n = n + "").length < c){  
            return new Array(++c - n.length).join("0") + n;  
        } else {  
            return n;  
        }  
    };  
    var txt_weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];  
    var txt_ordin = {1:"st", 2:"nd", 3:"rd", 21:"st", 22:"nd", 23:"rd", 31:"st"};  
    var txt_months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];   
    var f = {  
        // Day  
        d: function(){return pad(f.j(), 2)},  
        D: function(){return f.l().substr(0,3)},  
        j: function(){return jsdate.getDate()},  
        l: function(){return txt_weekdays[f.w()]},  
        N: function(){return f.w() + 1},  
        S: function(){return txt_ordin[f.j()] ? txt_ordin[f.j()] : 'th'},  
        w: function(){return jsdate.getDay()},  
        z: function(){return (jsdate - new Date(jsdate.getFullYear() + "/1/1")) / 864e5 >> 0},  
        
        // Week  
        W: function(){  
            var a = f.z(), b = 364 + f.L() - a;  
            var nd2, nd = (new Date(jsdate.getFullYear() + "/1/1").getDay() || 7) - 1;  
            if(b <= 2 && ((jsdate.getDay() || 7) - 1) <= 2 - b){  
                return 1;  
            } else{  
                if(a <= 2 && nd >= 4 && a >= (6 - nd)){  
                    nd2 = new Date(jsdate.getFullYear() - 1 + "/12/31");  
                    return date("W", Math.round(nd2.getTime()/1000));  
                } else{  
                    return (1 + (nd <= 3 ? ((a + nd) / 7) : (a - (7 - nd)) / 7) >> 0);  
                }  
            }  
        },  
        
        // Month  
        F: function(){return txt_months[f.n()]},  
        m: function(){return pad(f.n(), 2)},  
        M: function(){return f.F().substr(0,3)},  
        n: function(){return jsdate.getMonth() + 1},  
        t: function(){  
            var n;  
            if( (n = jsdate.getMonth() + 1) == 2 ){  
                return 28 + f.L();  
            } else{  
                if( n & 1 && n < 8 || !(n & 1) && n > 7 ){  
                    return 31;  
                } else{  
                    return 30;  
                }  
            }  
        },  
        
        // Year  
        L: function(){var y = f.Y();return (!(y & 3) && (y % 1e2 || !(y % 4e2))) ? 1 : 0},  
        //o not supported yet  
        Y: function(){return jsdate.getFullYear()},  
        y: function(){return (jsdate.getFullYear() + "").slice(2)},  
        
        // Time  
        a: function(){return jsdate.getHours() > 11 ? "pm" : "am"},  
        A: function(){return f.a().toUpperCase()},  
        B: function(){  
            // peter paul koch:  
            var off = (jsdate.getTimezoneOffset() + 60)*60;  
            var theSeconds = (jsdate.getHours() * 3600) + (jsdate.getMinutes() * 60) + jsdate.getSeconds() + off;  
            var beat = Math.floor(theSeconds/86.4);  
            if (beat > 1000) beat -= 1000;  
            if (beat < 0) beat += 1000;  
            if ((String(beat)).length == 1) beat = "00"+beat;  
            if ((String(beat)).length == 2) beat = "0"+beat;  
            return beat;  
        },  
        g: function(){return jsdate.getHours() % 12 || 12},  
        G: function(){return jsdate.getHours()},  
        h: function(){return pad(f.g(), 2)},  
        H: function(){return pad(jsdate.getHours(), 2)},  
        i: function(){return pad(jsdate.getMinutes(), 2)},  
        s: function(){return pad(jsdate.getSeconds(), 2)},  
        //u not supported yet  
        
        // Timezone  
        //e not supported yet  
        //I not supported yet  
        O: function(){  
            var t = pad(Math.abs(jsdate.getTimezoneOffset()/60*100), 4);  
            if (jsdate.getTimezoneOffset() > 0) t = "-" + t; else t = "+" + t;  
            return t;  
        },  
        P: function(){var O = f.O();return (O.substr(0, 3) + ":" + O.substr(3, 2))},  
        //T not supported yet  
        //Z not supported yet  
        
        // Full Date/Time  
        c: function(){return f.Y() + "-" + f.m() + "-" + f.d() + "T" + f.h() + ":" + f.i() + ":" + f.s() + f.P()},  
        //r not supported yet  
        U: function(){return Math.round(jsdate.getTime()/1000)}  
    };  
        
    return format.replace(/[\\]?([a-zA-Z])/g, function(t, s){  
        if( t!=s ){  
            // escaped  
            ret = s;  
        } else if( f[s] ){  
            // a date function exists  
            ret = f[s]();  
        } else{  
            // nothing special  
            ret = s;  
        }  
        return ret;  
    });  
    
 
}  