$(function(){	
	// //点击接单按钮
	// $('body').on('click','.tableBox .row .getOrder',function(){
	// 	$(this).text('配送');
	// 	$(this).attr('class','carry');
	// 	$(this).parent().siblings().find('.waitLis').find('b').text('待配送');
	// 	$(this).parent().siblings().find('.waitLis').attr('class','waitCar');
	// 	$(this).parent().siblings().find('.bigBar2').find('s').text('待配送');
	// 	$(this).parent().siblings().find('.bigBar2').attr('class','bigBar3');
	// 	$('.row span .bigBar3 .smallBar').css('width','120px');
 //        $('.row span .bigBar3 .state').css('left','92px')
	// })
	
	// //点击配送按钮
	// $('body').on('click','.tableBox .row .carry',function(){
	// 	$(this).text('已完成');
	// 	$(this).attr('class','hadFinish');
	// 	$(this).parent().siblings().find('.waitCar').find('b').text('配送中');
	// 	$(this).parent().siblings().find('.waitCar').attr('class','inCar');
	// 	$(this).parent().siblings().find('.bigBar3').find('s').text('配送中');
	// 	$(this).parent().siblings().find('.bigBar3').attr('class','bigBar4');
	// 	$('.row span .bigBar4 .smallBar').css('width','160px');
 //        $('.row span .bigBar4 .state').css('left','132px')
	// })
	
	// //点击已完成按钮 
	// $('body').on('click','.tableBox .row .hadFinish',function(){				
	// 	$(this).parent().siblings().find('.inCar').find('b').text('已完成');
	// 	$(this).parent().siblings().find('.inCar').attr('class','hasFin');
	// 	$(this).parent().siblings().find('.bigBar4').find('s').text('已完成');
					
	// 				$(this).parent().siblings().find('.bigBar4').attr('class','bigBar5');
	// 				$('.row span .bigBar5 .smallBar').css('width','200px');
	// 		        $('.row span .bigBar5 .state').css('left','172px');
	// 		        $(this).parent('span').empty();
				
	// })
	
	// 订单切换
	$('.allOrder li a').click(function(){
	 	$(this).parent().addClass('current').siblings().removeClass('current');
	})
	 
	//显示交易状态下拉
	$('.tabThead .dealState .biaoti').click(function(){
		$(this).parent('.dealState').toggleClass('clickState');
		$(this).siblings('.selectBox').toggle();
	})
	//点击空白下拉消失
	$('body').on('click',function(e){
		var target = $(e.target);
		if(target.closest('.tabThead .dealState .biaoti').length == 0 && target.closest('.tabThead .dealState .selectBox').length == 0){
			$('.tabThead .dealState').removeClass('clickState');
			$('.tabThead .dealState .selectBox').hide();
		}
	})
	//选择下拉
	$('.tabThead .dealState .selectBox a').click(function(){
		var aText = $(this).text();
		$(this).parent().siblings('.biaoti').find('.jiao').text(aText);
		$(this).closest('.dealState').removeClass('clickState');
		$(this).closest('.selectBox').hide();
	})
	 
	//显示取消订单弹框
	$('body').on('click','.tableBox .row .cancel',function(){
		$('.cancelBomb').show();
	})
	//关闭取消订单弹框
	$('.cancelBomb .close').click(function(){
		$('.cancelBomb').hide();
	})
	$('.cancelBomb .think').click(function(){
		$('.cancelBomb').hide();
	})

	// $('body').on('click','.tableBox .row .detail a',function(){
	// 	$('.detailBomb').show();
	// })
	//显示订单详情弹框
	// $('.order_id').click(function() {
 //        var order_id = $(this).attr('value');
 //        console.log(order_id);
 //        $('.detailBomb').show();
 //        $.ajax({
 //            type : 'post',
 //            url  : 'order_details',
 //            data : "id="+order_id,
 //            dataType : 'json',
 //            success  : function(data) {
 //                    for(var i in data){
 //                        var number = data[0].order_number;
 //                        var name   = data[0].reciver_name;
 //                        var addres = data[0].addres;
 //                        var phone  = data[0].mob_phone;
 //                        var points = data[0].use_points;
 //                        var fee    = data[0].shipping_fee;
 //                        var price  = data[0].order_price;
 //                        var code   = data[0].payment_code;
 //                        var create = formatDate('Y-m-d H:i',data[0].time_create);
 //                        var delay  = data[0].time_delay;
 //                    }
 //                    if (code == 'offline') {
 //                       var code = '微信付款';
 //                    } else if (code == 'online') {
 //                       var code = '在线支付';
 //                    } else if (code == 'alipay') {
 //                       var code = '支付宝';
 //                    };
 //                    var html = "";
 //                    html += '<div class="messageBox">'
	// 		        		+'<div class="numberBox">'
	// 		        			+'<p class="dingdan"><i></i>订单编号</p>'
	// 		        			+'<div class="cont">'
	// 		        				+'<p>'+number+'</p>'
	// 		        			+'</div>'
	// 		        			+'<span class="shang"></span>'
	// 		        			+'<span class="xia"></span>'
	// 		        		+'</div>'
	// 		        		+'<div class="numberBox timeBox">'
	// 		        			+'<p class="dingdan"><i></i>下单时间/预约时间</p>'
	// 		        			+'<div class="cont">'
	// 		        				+'<p>'+create+'/'+delay+'</p>'
	// 		        			+'</div>'
	// 		        			+'<span class="shang"></span>'
	// 		        			+'<span class="xia"></span>'
	// 		        		+'</div>'
	// 		        		+'<div class="numberBox takeBox">'
	// 		        			+'<p class="dingdan"><i></i>收货信息</p>'
	// 		        			+'<div class="cont">'
	// 		        				+'<p>联系人：'+name+'</p>'
	// 		        				+'<p>联系电话：'+phone+'</p>'
	// 		        				+'<p>联系地址：'+addres+'</p>'
	// 		        			+'</div>'
	// 		        			+'<span class="shang"></span>'
	// 		        			+'<span class="xia"></span>'
	// 		        		+'</div>'
	// 		        		+'<div class="numberBox proBox">'
	// 		        			+'<p class="dingdan"><i></i>下单产品</p>'
	// 		        			+'<div class="cont">'
	// 			        			+'<ul>';
	//         							for(var it in data){                   
	// 	                                    html += '<li>';
	// 			        						html += '<i class="wen1">'+data[it].product_name+'('+data[it].spec+')</i>';
	// 			        						html += '<i class="wen2">x'+data[it].goods_num+'</i>';
	// 			        						html += '<i class="wen3">¥'+data[it].money+'</i>';
	// 			        					html += '</li>';
	// 	                                };    					
	// 			        			html += '</ul>'
	// 	        				+'<p class="redPaper">'
	// 	        					+'<i class="red">积分优惠</i>'
	// 	        					+'<i class="money">-¥'+points+'</i>'
	// 	        				+'</p>'
	// 	        				+'<p class="redPaper carryM">'
	// 	        					+'<i class="red">配送费</i>'
	// 	        					+'<i class="money">¥'+fee+'</i>'
	// 	        				+'</p>'
	//         				+'</div>'	        			
	// 	        		+'</div>'
	// 			    +'</div>';
	// 	        	html += '<div class="payBox">'
	//     				+'<span class="payType">'+code+'</span>'
	//     				+'<span class="allMon">¥'+price+'</span>'
	//     			+'</div>';
 //                 	html += '<div class="closeBox"><a href="javascript:;">关闭窗口</a></div>';
 //                $('.detailBomb').html(html);
 //            }
 //        })
 //    })
	//关闭订单详情弹框
	$('body').on('click','.detailBomb .closeBox a',function(){
		$('.detailBomb').hide();
	})
	
	//鼠标经过显示消息提醒
	$('.tableBox .messageTip .imgT').hover(function(){
		$(this).siblings('.messCha').toggle();
	})
	
	//鼠标经过状态显示
	$('.tableBox .row span:nth-child(3)').hover(function(){
		$(this).find('.state').toggle();
	})
	 
	//点击显示取消订单原因下拉
	$('.cancelBomb .reasonSel .choose').click(function(){
		$('.cancelBomb .select').toggle();		
	})
	//点击下拉
	$('.cancelBomb .select li').click(function(){
		//alert(0);
		$(this).closest('.select').hide();
		var sText = $(this).find('.rea').text();
		//alert(sText)
		$(this).closest('.select').siblings('.choose').find('.cho').text(sText);
		if(sText == '其他'){
			$(this).closest('.reasonBox').siblings('.remark').show();
		}else{
			$(this).closest('.reasonBox').siblings('.remark').hide();
			$(this).closest('.reasonBox').siblings('.remark').find('.txt').val('');
		}

	})
	//点击空白下拉消息
	$('body').on('click',function(e){
		var target = $(e.target);
		if(target.closest('.cancelBomb .reasonSel .choose').length == 0 && target.closest('.cancelBomb .reasonSel .select').length == 0){
			$('.cancelBomb .reasonSel .select').hide();
		}
	})
	
	// 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });
	
})
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

	

