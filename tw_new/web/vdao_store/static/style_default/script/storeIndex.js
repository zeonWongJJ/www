/**
 * Created by 7du-29 on 2017/9/14.
 */
$(function (){

    // 基于准备好的dom，初始化echarts图表
	var office_total  = $("input[name='office_total']").val();
	var office_useing = $("input[name='office_useing']").val();
	var office_stop   = $("input[name='office_stop']").val();
	var office_free   = $("input[name='office_free']").val();
	var myChart = echarts.init(document.getElementById('pieMain'));
    var option = {
        calculable : true,
        series : [
            {
                name:'访问来源',
                type:'pie',
                radius : '60%',
                center: ['50%', '50%'],
                data:[
//                  {value:310, name:'使用中（'+office_useing+'）'},
//                  {value:234, name:'空闲中（'+office_free+'）'},
//                  {value:234, name:'停用中（'+office_stop+'）'},
                    {value:office_useing, name:'使用中（'+office_useing+'）'},
                    {value:office_free, name:'空闲中（'+office_free+'）'},
                    {value:office_stop, name:'停用中（'+office_stop+'）'},
                ],
                itemStyle: {
                    normal: {
                        color: function(params) {
                            // build a color map as your need.
                            var colorList = [
                                '#3e50b4','#2095f2','#e81d62','#ccdb38'
                            ];
                            return colorList[params.dataIndex];
                        }
                    }
                }
            }

        ]
    };
    // 为echarts对象加载数据
    myChart.setOption(option);

  	//抢单
	// $(".cofeOrderList>a.c7").click(function(){
	// 	var id =$(this).attr('value');
	// 	console.log(id);
	// 	$.ajax({
	// 		type : 'post',
	// 		url  : 'single',
	// 		data : {id:id},
	// 		dataType : 'json',
	// 		success  : function(data) {
	// 			if(data.stuo == 55){
	// 				alert('抢单成功！');

	// 			} else {
	// 				alert('该订单已被其他门店抢走了！');
	// 			}
	// 		}
	// 	})
	// })

    //查看详情
    // $(".coffeeOrders>ul>li.cofeOrderList>a.c5").click(function(){
    //     $(".cafeOrders").removeClass("hide");
    //     var id = $(this).attr('value');
    //     console.log(id);
    //     $.ajax({
    //         type : 'post',
    //         url  : 'order_details',
    //         data : "id="+id,
    //         dataType : 'json',
    //         success  : function(data) {
    //                 for(var i in data){
    //                     var number = data[0].order_number;
    //                     var name   = data[0].reciver_name;
    //                     var addres = data[0].addres;
    //                     var phone  = data[0].mob_phone;
    //                     var points = data[0].use_points;
    //                     var fee    = data[0].shipping_fee;
    //                     var price  = data[0].order_price;
    //                     var code   = data[0].payment_code;
    //                     var create = formatDate('Y-m-d H:i',data[0].time_create);
    //                     var delay  = formatDate('Y-m-d H:i',data[0].time_delay);
    //                 }
    //                 if (code == 'offline') {
    //                    var code = '微信付款';
    //                 } else if (code == 'online') {
    //                    var code = '在线支付';
    //                 } else if (code == 'alipay') {
    //                    var code = '支付宝';
    //                 };
    //                 var html = "";
    //                 html += '<div class="ordersNums">'
		  //                       +'<em>'
		  //                          +'<i></i>'
		  //                           +'<hr/>'
		  //                       +'</em>'
		  //                       +'<div class="ordersContent">'
		  //                           +'<h4>订单编号</h4>'
		  //                          +' <p>'+number+'</p>'
	   //                      +'</div>'
				// 	        +'</div>'
				// 	        +'<div class="ordersTime">'
				// 	            +'<em>'
				// 	                +'<i></i>'
				// 	                +'<hr/>'
				// 	            +'</em>'
				// 	            +'<div class="ordersContent">'
				// 	                +'<h4>下单时间/预约时间</h4>'
				// 	                +'<p>'+create+'/'+delay+'</p>'
				// 	            +'</div>'
				// 	        +'</div>'
				// 	        +'<div class="takeOver">'
				// 	            +'<em>'
				// 	                +'<i></i>'
				// 	                +'<hr/>'
				// 	            +'</em>'
				// 	            +'<div class="ordersContent">'
				// 	                +'<h4>收获信息</h4>'
				// 	                +'<p>联系人：'+name+'</p>'
				// 	                +'<p>联系电话：'+phone+'</p>'
				// 	                +'<p>联系地址：'+addres+'</p>'
				// 	            +'</div>'
				// 	        +'</div>'
				// 	        +'<div class="placeOrders">'
				// 	            +'<em>'
				// 	               +'<i></i>'
				// 	            +'</em>'
				// 	            +'<div class="ordersContent">'
				// 	                +'<h4>订单编号</h4>';
				// 					for(var it in data){
				// 		               html += '<p>';
				// 		                   html += '<span>'+data[it].product_name+'<i>('+data[it].cup_name+')</i></span>';
				// 		                   html += '<em>x'+data[it].goods_num+'</em>';
				// 		                   html += '<dfn>¥'+data[it].money+'</dfn>';
				// 		                html+'= </p>';
				// 					};
				// 	                html +='<div class="redPacket">'
				// 	                    +'<em>积分优惠</em>'
				// 	                    +'<span>-¥'+points+'</span>'
				// 	                +'</div>'
				// 	                +'<div class="redPacket carryM">'
		  //                               +'<em>配送费</em>'
		  //                               +'<span>¥'+fee+'</span>'
		  //                           +'</div>'
				// 	                +'<div class="weChatPay">'
				// 	                    +'<span>'+code+'</span>'
				// 	                    +'<em>¥'+price+'</em>'
				// 	                +'</div>'
				// 	            +'</div>'
				// 	        +'</div>'
				// 	    html += '<div class="closeLay" style="margin-top:15px;"><span>关闭窗口</span></div>';
    //             $('.cafeOrders').html(html);
    //         }
    //     })
    // })
    //关闭窗口
	$('body').on('click','.closeLay>span',function(){
		$(".cafeOrders").addClass("hide");
	})
    //店铺概况
    $(".survetTit>span").click(function(){
        if($(this).hasClass("room_tit")){
            $(".roomNum").removeClass("hide");
            $(".productNum").addClass("hide");
            $(this).addClass("surCur");
            $(".survetTit>span").not($(this)).removeClass("surCur");
        }else if($(this).hasClass("product_tit")){
            doProgress();
            $(".roomNum").addClass("hide");
            $(".productNum").removeClass("hide");
            $(this).addClass("surCur");
            $(".survetTit>span").not($(this)).removeClass("surCur");
        }
    })

    //点击修改密码显示弹框
	$('.account .revisePass').click(function(){
		$('.editBomb').show();
	})

	//关闭修改密码弹框
	$('.editBomb .h2 .close').click(function(){
		$('.editBomb').hide();
	})

	//点击修改密码的确定按钮
	$('.editBomb .sureBox a').click(function(){
		//alert(0);
		var oldVal = $('.editBomb .old').val();
		var newVal = $('.editBomb .new').val();
		var againNew = $('.editBomb .againNew').val();
		var thisok1 = false;
		var thisok2 = false;
		var thisok3 = false;
		if(oldVal == ''){
			$('.old').siblings('.red').show();
		}else{
			$('.old').siblings('.red').hide();
			thisok1 = true;
		}
		if(newVal == ''){
			$('.new').siblings('.red').show();
		}else{
			$('.new').siblings('.red').hide();
			thisok2 = true;
		}
		if(againNew == ''){
			$('.againNew').siblings('.red').show();
		}else{
			$('.againNew').siblings('.red').hide();
			thisok3 = true;
		}
		if (thisok1 == true && thisok2 == true && thisok3 == true) {
			$("#updatepwdform").submit();
		}
	})
	
	//生产量
	//alert(0);
	//var volume  = Number($('.salesBox .volume p').text());
	//var proNum = 0;
	//var limit = Number($('.salesBox .limit p').text());
	//alert(volume);
	//alert(limit);
	//var proWidth = Math.ceil(50/limit*197);
	//alert(proWidth);
	//var proHtml = math.ceil(volume/limit);
	//alert(proHtml);
	//$(".progress").css("width", ''+proWidth+'px'); //控制#loading div宽度
    //$(".progress").html(123); //显示百分比	
//  setTimeout(function(){
//  	proNum++;
//  },8000)

})

//生产量
function doProgress(timer){
	var proNum = 0;
    var timer = null;
	var volume  = Number($('.salesBox .volume p').text());	
	var limit = Number($('.salesBox .limit p').text());
	var proWidth = Math.ceil(volume/limit*197);
	timer = setInterval(function(){
    	proNum++;
    	$(".progress").css("width", ''+proNum+'px'); //控制#loading div宽度
    	if(proNum == proWidth){
    		proNum == proWidth;
    		clearInterval(timer);
    	}
    	if(proWidth == 1){
    		proNum == 2;
    		$(".progress").css("width", '2px');
    		clearInterval(timer);
    	}
    	if(proWidth == 0){
    		clearInterval(timer);
    	}
    },20)	  
}
//function SetProgress(progress) {
//  if (progress) {
//      $(".progress").css("width", ((String(progress))/1000)*100+"%"); //控制#loading div宽度
//  }
//}
//var i = 0;
//function doProgress() {
//  if (i > 1000) {
//      return;
//  }
//  if (i <= 730) {
//      setTimeout("doProgress()",10);
//      SetProgress(i);
//      i+=10;
//  }
//}
$(function(){
	//关闭流量弹框
	$('.dayBomb .close').click(function(){
		$('.dayBomb').hide();
		$('.shade').hide();
	})
	$('.weekBomb .close').click(function(){
		$('.weekBomb').hide();
		$('.shade').hide();
	})
	$('.monthBomb .close').click(function(){
		$('.monthBomb').hide();
		$('.shade').hide();
	})
	//显示日流量弹框
	$('.infoList .flux').click(function(){
		$('.dayBomb').show();
		$('.shade').show();
	})
	$('.dayBomb .week').click(function(){
		$('.dayBomb').hide();
		$('.monthBomb').hide();
		$('.weekBomb').show();
	})
	$('.dayBomb .month').click(function(){
		$('.dayBomb').hide();
		$('.weekBomb').hide();
		$('.monthBomb').show();
	})
	$('.weekBomb .day').click(function(){
		$('.weekBomb').hide();
		$('.monthBomb').hide();
		$('.dayBomb').show();
	})
	$('.weekBomb .month').click(function(){
		$('.dayBomb').hide();
		$('.weekBomb').hide();
		$('.monthBomb').show();
	})
	$('.monthBomb .day').click(function(){
		$('.weekBomb').hide();
		$('.monthBomb').hide();
		$('.dayBomb').show();
	})
	$('.monthBomb .week').click(function(){
		$('.dayBomb').hide();
		$('.monthBomb').hide();
		$('.weekBomb').show();
	})
})
// //------日流量echarts开始------
// $(function(){
// 	var dayChart = echarts.init(document.getElementById('dayMain'));
// 	option = {
// 	    title: {
// 	        text: '流量统计',
// 	        x:'10',
// 	        y:'10',
// 	        textStyle:{
// 	        	fontSize:'14',
// 	        }
// 	    },
// 	    tooltip: {
// 	        trigger: 'axis'
// 	    },
// 	    legend: {
// 	        data:['进店','离店','在店'],
// 	        x:'380',
// 	        y:'10'
// 	    },
// 	    grid: {
// 	        left: '3%',
// 	        right: '4%',
// 	        bottom: '3%',
// 	        containLabel: true
// 	    },
// 	    xAxis: {
// 	        type: 'category',
// 	        boundaryGap: false,
// 	        data: ['00:00~01:00','02:00~03:00','04:00~05:00','06:00~07:00','08:00~09:00','10:00~11:00','12:00~13:00','14:00~15:00','16:00~17:00','18:00~19:00','20:00~21:00','22:00~23:00'],
// 	    	axisTick: {//坐标轴小标志
//                 alignWithLabel: true,
//                 interval:0,
//                 lineStyle:{
//                 	color:'#f1f1f1',
//                 }
//             },
//             axisLabel:{//坐标轴文本标签
//             	show:true,
//             	interval:0,
//             	textStyle:{
//             		fontSize:'10',
//             		color:'#999999',
//             	},
//             	formatter:function(params){
//             		var newParamsName = "";// 最终拼接成的字符串
//             		var params = params.replace('~','');
// 				    var paramsNameNumber = params.length;// 实际标签的个数
// 				    var provideNumber = 5;// 每行能显示的字的个数
// 				    var rowNumber = Math.ceil(paramsNameNumber / provideNumber);// 换行的话，需要显示几行，向上取整
// 				    //* 判断标签的个数是否大于规定的个数， 如果大于，则进行换行处理 如果不大于，即等于或小于，就返回原标签
// 				    // 条件等同于rowNumber>1
// 				    if (paramsNameNumber > provideNumber) {
// 				        /** 循环每一行,p表示行 */
// 				        for (var p = 0; p < rowNumber; p++) {
// 				            var tempStr = "";// 表示每一次截取的字符串
// 				            var start = p * provideNumber;// 开始截取的位置
// 				            var end = start + provideNumber;// 结束截取的位置
// 				            // 此处特殊处理最后一行的索引值
// 				            if (p == rowNumber - 1) {
// 				                // 最后一次不换行
// 				                tempStr = params.substring(start, paramsNameNumber);
// 				            } else {
// 				                // 每一次拼接字符串并换行
// 				                tempStr = params.substring(start, end) + "\n";
// 				            }
// 				            newParamsName += tempStr;// 最终拼成的字符串
// 				        }

// 				    } else {
// 				        // 将旧标签的值赋给新标签
// 				        newParamsName = params;
// 				    }
// 				    //将最终的字符串返回
// 				    return newParamsName;
//             	}
//             },
// 	    	splitLine:{//分割线
//                 show:false,
//             },
//             axisLine:{//坐标轴线
//                 lineStyle:{
//                     color: "#f1f1f1",
//                 }
//             }
// 	    },
// 	    yAxis: {
// 	        type: 'value',
// 	        axisLabel:{
//                 textStyle:{
//                     color:'#999999',
//                     fontSize:10
//                 }
//             },
//             splitLine:{
//                 show:false,
//             },
//             axisLine:{
//                 lineStyle:{
//                     color: "#f1f1f1"
//                 }
//             }

// 	    },
// 	    series: [
// 	        {
// 	            name:'进店',
// 	            type:'line',
// 	            data:[300,200,250,100,390,100,210,350,180,60,150,300],
// 	            itemStyle:{
// 	            	normal:{
// 	            		color:'#21c393',
// 	            		lineStyle:{
// 	            			color:'#21c393',
// 	            			width:'2',
// 	            		}
// 	            	}
// 	            }
// 	        },
// 	        {
// 	            name:'离店',
// 	            type:'line',
// 	            data:[220,182,191,20,100,30,110,80,300,40,50,150],
// 	            itemStyle:{
// 	            	normal:{
// 	            		color:'#fad567',
// 	            		lineStyle:{
// 	            			width:'2',
// 	            		}
// 	            	}
// 	            }
// 	        },
// 	        {
// 	            name:'在店',
// 	            type:'line',
// 	            data:[50,132,80,90,290,70,100,200,50,30,120,300],
// 	            itemStyle:{
// 	            	normal:{
// 	            		color:'#6a8ee3',
// 	            		lineStyle:{
// 	            			width:'2',
// 	            		}
// 	            	}
// 	            }
// 	        }

// 	    ],

// 	};
// 	dayChart.setOption(option);
// })
// //------日流量echarts结束------
// //------周流量echarts开始------
// $(function(){
// 	var weekChart = echarts.init(document.getElementById('weekMain'));
// 	option = {
// 	    title: {
// 	        text: '流量统计',
// 	        x:'10',
// 	        y:'10',
// 	        textStyle:{
// 	        	fontSize:'14',
// 	        }
// 	    },
// 	    tooltip: {
// 	        trigger: 'axis'
// 	    },
// 	    legend: {
// 	        data:['进店'],
// 	        x:'508',
// 	        y:'10'
// 	    },
// 	    grid: {
// 	        left: '3%',
// 	        right: '4%',
// 	        bottom: '3%',
// 	        containLabel: true
// 	    },
// 	    xAxis: {
// 	        type: 'category',
// 	        boundaryGap: false,
// 	        data: ['11-01','11-02','11-03','11-04','11-05','昨天','今天'],
// 	    	axisTick: {//坐标轴小标志
//                 alignWithLabel: true,
//                 interval:0,
//                 lineStyle:{
//                 	color:'#f1f1f1',
//                 }
//             },
//             axisLabel:{//坐标轴文本标签
//             	show:true,
//             	interval:0,
//             	textStyle:{
//             		fontSize:'10',
//             		color:'#999999',
//             	}
//             },
// 	    	splitLine:{//分割线
//                 show:false,
//             },
//             axisLine:{//坐标轴线
//                 lineStyle:{
//                     color: "#f1f1f1",
//                 }
//             }
// 	    },
// 	    yAxis: {
// 	        type: 'value',
// 	        axisLabel:{
//                 textStyle:{
//                     color:'#999999',
//                     fontSize:10
//                 }
//             },
//             splitLine:{
//                 show:false,
//             },
//             axisLine:{
//                 lineStyle:{
//                     color: "#f1f1f1"
//                 }
//             }

// 	    },
// 	    series: [
// 	        {
// 	            name:'进店',
// 	            type:'line',
// 	            data:[300,200,250,100,390,100,210],
// 	            itemStyle:{
// 	            	normal:{
// 	            		color:'#21c393',
// 	            		lineStyle:{
// 	            			color:'#21c393',
// 	            			width:'2',
// 	            		}
// 	            	}
// 	            }
// 	        },
// 	    ],

// 	};
// 	weekChart.setOption(option);
// })
// //------周流量echarts结束------
// //------月流量echarts开始------
// $(function(){
// 	var monthChart = echarts.init(document.getElementById('monthMain'));
// 	option = {
// 	    title: {
// 	        text: '流量统计',
// 	        x:'10',
// 	        y:'10',
// 	        textStyle:{
// 	        	fontSize:'14',
// 	        }
// 	    },
// 	    tooltip: {
// 	        trigger: 'axis'
// 	    },
// 	    legend: {
// 	        data:['进店'],
// 	        x:'508',
// 	        y:'10'
// 	    },
// 	    grid: {
// 	        left: '3%',
// 	        right: '4%',
// 	        bottom: '3%',
// 	        containLabel: true
// 	    },
// 	    xAxis: {
// 	        type: 'category',
// 	        boundaryGap: false,
// 	        data: ['09-15','09-16','09-17','09-18','09-19','09-20','09-21','09-22','09-23','09-24','09-25','09-26','09-27','09-28','09-29','09-30','10-01','10-02','10-03','10-04','10-05','10-06','昨天','今天'],
// 	    	axisTick: {//坐标轴小标志
//                 alignWithLabel: true,
//                 interval:0,
//                 lineStyle:{
//                 	color:'#f1f1f1',
//                 }
//             },
//             axisLabel:{//坐标轴文本标签
//             	show:true,
//             	//interval:0,
//             	textStyle:{
//             		fontSize:'10',
//             		color:'#999999',
//             	}
//             },
// 	    	splitLine:{//分割线
//                 show:false,
//             },
//             axisLine:{//坐标轴线
//                 lineStyle:{
//                     color: "#f1f1f1",
//                 }
//             }
// 	    },
// 	    yAxis: {
// 	        type: 'value',
// 	        axisLabel:{
//                 textStyle:{
//                     color:'#999999',
//                     fontSize:10
//                 }
//             },
//             splitLine:{
//                 show:false,
//             },
//             axisLine:{
//                 lineStyle:{
//                     color: "#f1f1f1"
//                 }
//             }

// 	    },
// 	    series: [
// 	        {
// 	            name:'进店',
// 	            type:'line',
// 	            data:[300,200,250,100,390,100,210,150,250,130,188,175,124,80,110,199,130,110,210,200,250,100,390,240],
// 	            itemStyle:{
// 	            	normal:{
// 	            		color:'#21c393',
// 	            		lineStyle:{
// 	            			color:'#21c393',
// 	            			width:'2',
// 	            		}
// 	            	}
// 	            }
// 	        },
// 	    ],

// 	};
// 	monthChart.setOption(option);
// })
// function formatDate(format, timestamp){
//     var a, jsdate=((timestamp) ? new Date(timestamp*1000) : new Date());
//     var pad = function(n, c){
//         if((n = n + "").length < c){
//             return new Array(++c - n.length).join("0") + n;
//         } else {
//             return n;
//         }
//     };
//     var txt_weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
//     var txt_ordin = {1:"st", 2:"nd", 3:"rd", 21:"st", 22:"nd", 23:"rd", 31:"st"};
//     var txt_months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
//     var f = {
//         // Day
//         d: function(){return pad(f.j(), 2)},
//         D: function(){return f.l().substr(0,3)},
//         j: function(){return jsdate.getDate()},
//         l: function(){return txt_weekdays[f.w()]},
//         N: function(){return f.w() + 1},
//         S: function(){return txt_ordin[f.j()] ? txt_ordin[f.j()] : 'th'},
//         w: function(){return jsdate.getDay()},
//         z: function(){return (jsdate - new Date(jsdate.getFullYear() + "/1/1")) / 864e5 >> 0},

//         // Week
//         W: function(){
//             var a = f.z(), b = 364 + f.L() - a;
//             var nd2, nd = (new Date(jsdate.getFullYear() + "/1/1").getDay() || 7) - 1;
//             if(b <= 2 && ((jsdate.getDay() || 7) - 1) <= 2 - b){
//                 return 1;
//             } else{
//                 if(a <= 2 && nd >= 4 && a >= (6 - nd)){
//                     nd2 = new Date(jsdate.getFullYear() - 1 + "/12/31");
//                     return date("W", Math.round(nd2.getTime()/1000));
//                 } else{
//                     return (1 + (nd <= 3 ? ((a + nd) / 7) : (a - (7 - nd)) / 7) >> 0);
//                 }
//             }
//         },

//         // Month
//         F: function(){return txt_months[f.n()]},
//         m: function(){return pad(f.n(), 2)},
//         M: function(){return f.F().substr(0,3)},
//         n: function(){return jsdate.getMonth() + 1},
//         t: function(){
//             var n;
//             if( (n = jsdate.getMonth() + 1) == 2 ){
//                 return 28 + f.L();
//             } else{
//                 if( n & 1 && n < 8 || !(n & 1) && n > 7 ){
//                     return 31;
//                 } else{
//                     return 30;
//                 }
//             }
//         },

//         // Year
//         L: function(){var y = f.Y();return (!(y & 3) && (y % 1e2 || !(y % 4e2))) ? 1 : 0},
//         //o not supported yet
//         Y: function(){return jsdate.getFullYear()},
//         y: function(){return (jsdate.getFullYear() + "").slice(2)},

//         // Time
//         a: function(){return jsdate.getHours() > 11 ? "pm" : "am"},
//         A: function(){return f.a().toUpperCase()},
//         B: function(){
//             // peter paul koch:
//             var off = (jsdate.getTimezoneOffset() + 60)*60;
//             var theSeconds = (jsdate.getHours() * 3600) + (jsdate.getMinutes() * 60) + jsdate.getSeconds() + off;
//             var beat = Math.floor(theSeconds/86.4);
//             if (beat > 1000) beat -= 1000;
//             if (beat < 0) beat += 1000;
//             if ((String(beat)).length == 1) beat = "00"+beat;
//             if ((String(beat)).length == 2) beat = "0"+beat;
//             return beat;
//         },
//         g: function(){return jsdate.getHours() % 12 || 12},
//         G: function(){return jsdate.getHours()},
//         h: function(){return pad(f.g(), 2)},
//         H: function(){return pad(jsdate.getHours(), 2)},
//         i: function(){return pad(jsdate.getMinutes(), 2)},
//         s: function(){return pad(jsdate.getSeconds(), 2)},
//         //u not supported yet

//         // Timezone
//         //e not supported yet
//         //I not supported yet
//         O: function(){
//             var t = pad(Math.abs(jsdate.getTimezoneOffset()/60*100), 4);
//             if (jsdate.getTimezoneOffset() > 0) t = "-" + t; else t = "+" + t;
//             return t;
//         },
//         P: function(){var O = f.O();return (O.substr(0, 3) + ":" + O.substr(3, 2))},
//         //T not supported yet
//         //Z not supported yet

//         // Full Date/Time
//         c: function(){return f.Y() + "-" + f.m() + "-" + f.d() + "T" + f.h() + ":" + f.i() + ":" + f.s() + f.P()},
//         //r not supported yet
//         U: function(){return Math.round(jsdate.getTime()/1000)}
//     };

//     return format.replace(/[\\]?([a-zA-Z])/g, function(t, s){
//         if( t!=s ){
//             // escaped
//             ret = s;
//         } else if( f[s] ){
//             // a date function exists
//             ret = f[s]();
//         } else{
//             // nothing special
//             ret = s;
//         }
//         return ret;
//     });
// }
// //------周流量echarts结束------













