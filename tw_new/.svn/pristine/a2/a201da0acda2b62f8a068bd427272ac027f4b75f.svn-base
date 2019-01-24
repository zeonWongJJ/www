<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML,ASP,PHP,SQL">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=6" ><!-- 使用IE6 -->
    <meta http-equiv="X-UA-Compatible" content="IE=7" ><!-- 使用IE7 -->
    <meta http-equiv="X-UA-Compatible" content="IE=8" ><!-- 使用IE8 -->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" type="text/css" href="./static/style_default/style/common.css"/>
    <link rel="stylesheet" type="text/css" href="./static/style_default/style/header.css"/>
    <link rel="stylesheet" href="./static/style_default/style/storeIndex.css"/>
    <link rel="stylesheet" href="./static/style_default/layui/css/layui.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
    <script src="./static/style_default/script/storeIndex.js"></script>
    <script src="./static/style_default/script/echarts.common.min.js"></script>
    <script src="./static/style_default/layui/layui.js"></script>
    <title>门店首页</title>
</head>
<body style="background:#efefef;">
    <!-- 门店首页 -->
    <div class="storeIndex">
        <!-- 头部 -->
        <?php echo $this->display('top'); ?>
        <!-- 头部 -->

        <!-- 导航 -->
        <?php echo $this->display('left'); ?>
        <!-- 导航 -->

        <!--  右侧内容 -->
        <article>
            <!--  信息列表 -->
            <div class="infoList">
                <a href="" class="sales">
                    <div class="listL">
                        <p>累计销售金额</p>
                        <span><?php echo $a_view_data['store']['store_amount']; ?></span>
                    </div>
                    <div class="listR">
                        <img src="./static/style_default/images/lis_12.png" />
                    </div>
                </a>
                <a href="" class="orders">
                    <div class="listL">
                        <p>累计成交饮品订单</p>
                        <span><?php echo $a_view_data['store']['store_order']; ?></span>
                    </div>
                    <div class="listR">
                        <img src="./static/style_default/images/lis_06.png" />
                    </div>
                </a>
                <a href="" class="roomOrders">
                    <div class="listL">
                        <p>累计成交房间订单</p>
                        <span><?php echo $a_view_data['store']['store_officeorder']; ?></span>
                    </div>
                    <div class="listR">
                        <img src="./static/style_default/images/lis_03.png" />
                    </div>
                </a>
                <a href="javascript:;" class="flux">
                    <div class="listL">
                        <p>门店日流量</p>
                        <span><?php echo $a_view_data['todaypassenger'] ?></span>
                    </div>
                    <div class="listR">
                        <img src="./static/style_default/images/lis_09.png" />
                    </div>
                </a>
            </div>
            <!--  信息列表 -->

            <!-- 概况与订单 -->
            <div class="conten_boxA">
                <!-- 店铺概况 -->
                <div class="storeSurvey">
                    <p>店铺概况</p>
                    <!-- 概况标题 -->
                    <div class="survetTit">
                        <input type="hidden" name="office_total" value="<?php echo $a_view_data['office_total']; ?>">
                        <input type="hidden" name="office_useing" value="<?php echo $a_view_data['office_useing']; ?>">
                        <input type="hidden" name="office_stop" value="<?php echo $a_view_data['office_stop']; ?>">
                        <input type="hidden" name="office_free" value="<?php echo $a_view_data['office_free']; ?>">
                        <span class="room_tit surCur">房间数</span>
                        <span class="product_tit">生产量</span>
                    </div>
                    <!-- 概况标题 -->
                    <!-- 房间数 -->
                    <div class="roomNum ">
                        <div id="pieMain" style="width:400px; height:300px"></div>
                        <div class="saleNum">
                            <em class="saleMonth">
                                <span><?php echo $a_view_data['coffee_month']; ?></span>
                                <p>月餐饮销售额</p>
                            </em>
                            <em class="saleMonth">
                                <span><?php echo $a_view_data['coffee_today']; ?></span>
                                <p>今日销售额</p>
                            </em>
                        </div>
                    </div>
                    <!-- 房间数 -->
                    <!-- 生产量 -->
                    <div class="productNum hide">
                        <div class="progressBg">
                            <div class="progress"></div>
                        </div>
                        <div class="salesBox">
                            <em class="volume">
                                <p><?php echo $a_view_data['coffee_cup']; ?></p>
                                <span>今日销售量（杯）</span>
                            </em>
                            <span></span>
                            <em class="limit">
                                <p><?php echo $a_view_data['store']['store_output']; ?></p>
                                <span>日销售上限（杯）</span>
                            </em>
                            <a href="delivery">查看销售记录</a>
                        </div>
                        <div class="saleNum">
                            <em class="saleMonth">
                                <span><?php echo $a_view_data['coffee_month']; ?></span>
                                <p>月咖啡销售额</p>
                            </em>
                            <em class="saleMonth">
                                <span><?php echo $a_view_data['coffee_today']; ?></span>
                                <p>今日销售额</p>
                            </em>
                        </div>
                    </div>
                    <!-- 生产量 -->
                </div>
                <!-- 店铺概况 -->
                <!-- 最新咖啡订单 -->
                <div class="coffeeOrders">
                    <p>附近最新餐饮订单</p>
                   <div class="thead">
                        <span class="c1">用户名</span>
                        <span class="c2">下单时间</span>
                        <span class="c3">预约时间</span>
                        <span class="c4">距离</span>
                        <span class="c5">订单详情</span>
                        <span class="c6">金额</span>
                        <span class="c7">操作</span>
                    </div>
                    <ul></ul>
                </div>
                <!-- 最新咖啡订单 -->
            </div>
            <!-- 概况与订单 -->

            <!-- 店铺信息与其他 -->
            <div class="conten_boxB">
                <!-- 左边店铺信息 -->
                <div class="storeLeft">
                    <div  class="store_bg"></div>
                    <img src="./static/style_default/images/tt_03.png" />
                    <div class="evaluate">
                        <a>
                           <p>好评率</p>
                            <span><?php echo $a_view_data['good_ratio']; ?>%</span>
                        </a>
                        <a>
                            <p>服务态度</p>
                            <span><?php echo $a_view_data['service_score']; ?></span>
                        </a>
                        <a>
                            <p>服务质量</p>
                            <span><?php echo $a_view_data['goods_score']; ?></span>
                        </a>
                    </div>
                </div>
                <!-- 左边店铺信息 -->

                <!--  其他 -->
                <div class="otherRight">
                    <!-- 资金管理 -->
                    <div class="capital">
                        <p>资金管理</p>
                        <div class="balance">
                            <span>
                                <em><?php echo $a_view_data['store']['store_balance']; ?></em>
                                <p>账户余额</p>
                            </span>
                            <a href="balance_showlist">提现</a>
                            <img src="./static/style_default/images/zhexian_04_03.png" />
                        </div>
                    </div>
                    <!-- 资金管理 -->
                    <!-- 代办事项 -->
                    <div class="matter">
                        <p>待办事项</p>
                        <div class="mat_cofe">
                            <p>餐饮订单</p>
                            <a href="delivery-20">
                                <?php if (!empty($a_view_data['order_jiedan'])) {
                                    echo '<i>'. $a_view_data['order_jiedan']. '</i>';
                                } ?>
                                <img src="./static/style_default/images/store_47.png"/>
                                <span>待接单</span>
                            </a>
                            <a href="delivery-25">
                                <?php if (!empty($a_view_data['order_waitsong'])) {
                                    echo '<i>'. $a_view_data['order_waitsong']. '</i>';
                                } ?>
                                <img src="./static/style_default/images/store_43.png" />
                                <span>待配送</span>
                            </a>
                            <a href="delivery-30">
                                <?php if (!empty($a_view_data['order_waiting'])) {
                                    echo '<i>'. $a_view_data['order_waiting']. '</i>';
                                } ?>
                                <img src="./static/style_default/images/store_45.png" />
                                <span>待配送</span>
                            </a>
                        </div>
                        <div class="mat_room">
                             <p>会议订单</p>
                            <a href="appointment_order-1-1">
                                <?php if (!empty($a_view_data['appointment_state1'])) {
                                    echo '<i>'. $a_view_data['appointment_state1']. '</i>';
                                } ?>
                                <img src="./static/style_default/images/store_47.png" />
                                <span>待接单</span>
                            </a>
                            <a href="appointment_order-1-2">
                                <?php if (!empty($a_view_data['appointment_state2'])) {
                                    echo '<i>'. $a_view_data['appointment_state2']. '</i>';
                                } ?>
                                <img src="./static/style_default/images/store_49.png" />
                                <span>待入座</span>
                            </a>
                            <a href="appointment_order-1-3">
                                <?php if (!empty($a_view_data['appointment_state3'])) {
                                    echo '<i>'. $a_view_data['appointment_state3']. '</i>';
                                } ?>
                                <img src="./static/style_default/images/store_51.png" />
                                <span>已入座</span>
                            </a>
                        </div>
                    </div>
                    <!-- 代办事项 -->

                    <!--  账户安全 -->
                    <div class="account">
                        <p>账户安全</p>
                        <i><img src="./static/style_default/images/safe_03.png" /></i>
                        <em>安全等级：<s>中</s></em>
                        <a class="revisePass" href="javascript:;">修改密码</a>
                    </div>
                    <!--  账户安全 -->

                    <!-- 最新评价 -->
                    <div class="newEvaluate">
                        <p>最新评价</p>
                        <a href="comment_room">
                            <span>查看更多</span>
                            <img src="./static/style_default/images/indexPic_34.png" />
                        </a>
                        <ul>
                            <?php foreach ($a_view_data['comment_recently'] as $key => $value): ?>
                            <li>
                                <?php if (empty($value['user_pic'])) {
                                    echo '<img src="static/style_default/images/yong_03.png" />';
                                } else if(strpos($value['user_pic'], 'http') === false) {
                                    echo '<img src="'.get_config_item('vdao_mobile').$value['user_pic'].'" />';
                                } else {
                                    echo '<img src="'.$value['user_pic'].'" />';
                                } ?>
                                <span><?php echo $value['user_name']; ?></span>
                                <em>评价订单：<?php echo $value['order_number']; ?>：</em>
                                <s><?php echo $value['comment_content']; ?></s>
                                <a>
                                    <img src="./static/style_default/images/store_59.png" />
                                    <span><?php echo date('Y-m-d',$value['comment_time']); ?></span>
                                    <em><?php echo date('H:i:s',$value['comment_time']); ?></em>
                                </a>
                            </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <!-- 最新评价 -->
                </div>
                <!--  其他 -->

                <!-- 订单 -->
                <div class="cafeOrders hide">
                 
                </div> 
                <!-- 订单 -->
            </div>
            <!-- 店铺信息与其他 -->
        </article>
        <!--  右侧内容 -->
    </div>
    <!-- 门店首页 -->
    <!--修改密码弹框开始-->
    <div class="editBomb">
    	<div class="h2">
    		<span class="title">修改密码</span>
    		<a href="javascript:;" class="close"></a>
    	</div>
    	<!--表单开始-->
    	<div class="formBox">
    		<form id="updatepwdform" action="index" method="post">
    			<ul>
    				<li>
    					<span class="left">旧密码</span>
    					<div class="right">
    						<input type="password" class="input old" name="old_password" placeholder="请输入旧密码" />
    						<span class="red"><em></em><s class="wen">还没有输入旧密码</s></span>
    					</div>
    				</li>
    				<li>
    					<span class="left">新密码</span>
    					<div class="right">
    						<input type="password" class="input new" name="manager_password" placeholder="请输入新密码" />
    						<span class="red"><em></em><s class="wen">还没有输入新密码</s></span>
    					</div>
    				</li>
    				<li>
    					<span class="left">再次输入新密码</span>
    					<div class="right">
    						<input type="password" class="input againNew" name="manager_password2" placeholder="请再次输入新密码" />
    						<span class="red"><em></em><s class="wen">请再次输入新密码</s></span>
    					</div>
    				</li>
    			</ul>
    			<div class="sureBox">
    				<a href="javascript:;">确定</a>
    			</div>
    		</form>
    	</div>
    	<!--表单结束-->
    </div>
    <!--修改密码弹框结束-->
    <!--日流量弹框开始-->
    <div class="dayBomb">
    	<a href="javascript:;" class="close"></a>
    	<div class="selectBox" style="display:none;">
    		<input type="text" id="test1">
    	</div>
    	<div class="timeBox">
    		<a href="javascript:;" class="month">月</a>
    		<a href="javascript:;" class="week">周</a>
    		<a href="javascript:;" class="day timeCur">日</a>
    	</div>
    	<div id="dayMain" style="width: 620px; height: 320px;"></div>
    </div>
    <!--日流量弹框结束-->
    <!--周流量弹框开始-->
    <div class="weekBomb">
    	<a href="javascript:;" class="close"></a>
    	<div class="selectBox" style="display:none;">
    		<input type="text" id="test2">
    	</div>
    	<div class="timeBox">
    		<a href="javascript:;" class="month">月</a>
    		<a href="javascript:;" class="week timeCur">周</a>
    		<a href="javascript:;" class="day">日</a>
    	</div>
    	<div id="weekMain" style="width: 620px; height: 320px;"></div>
    </div>
    <!--周流量弹框结束-->
    <!--月流量弹框开始-->
    <div class="monthBomb">
    	<a href="javascript:;" class="close"></a>
    	<div class="selectBox" style="display:none;">
    		<input type="text" id="test3">
    	</div>
    	<div class="timeBox">
    		<a href="javascript:;" class="month timeCur">月</a>
    		<a href="javascript:;" class="week">周</a>
    		<a href="javascript:;" class="day">日</a>
    	</div>
    	<div id="monthMain" style="width: 620px; height: 320px;"></div>
    </div>
    <!--月流量弹框结束-->
    <!--遮罩层开始-->
    <div class="shade"></div>
    <!--遮罩层结束-->
</body>
<!--生产量比开始-->
<script type="text/javascript">
	$(function(){
		//alert(0);
		//var volume  = $('.salesBox .volume p').text();
		//var limit = number($('.salesBox .limit p').text());
		//alert(volume);
		//alert(limit);
		//var proWidth = math.ceil((volume/limit)*197);
		//alert(proWidth);
		//var proHtml = math.ceil(volume/limit);
		//alert(proHtml);
		//$(".progress").css("width", '120px'); //控制#loading div宽度
	    //$(".progress").html(proHtml); //显示百分比		
	})	
</script>
<!--生产量比结束-->
<!--加载日流量的日期开始-->
<script type="text/javascript">
	layui.use('laydate', function(){
	  var laydate = layui.laydate;
	  laydate.render({
	    elem: '#test1',
	    value: '2017年10月10日',
	    format: 'yyyy年MM月dd日'
	  })
	});
</script>
<!--加载日流量的日期结束-->
<!--加载周流量的日期开始-->
<script type="text/javascript">
	layui.use('laydate', function(){
	  var laydate = layui.laydate;
	  laydate.render({
	    elem: '#test2',
	    value: '2017年10月10日',
	    format: 'yyyy年MM月dd日'
	  })
	});
</script>
<!--加载周流量的日期结束-->
<!--加载周流量的日期开始-->
<script type="text/javascript">
	layui.use('laydate', function(){
	  var laydate = layui.laydate;
	  laydate.render({
	    elem: '#test3',
	    value: '2017年10月10日',
	    format: 'yyyy年MM月dd日'
	  })
	});
</script>
<!--加载周流量的日期结束-->

<script>
$("#updatesure").click(function(event) {
    $("#updatepwdform").submit();
});
</script>

</html>


<script type="text/javascript">
        var weixuan = {

            url: 'delivery_weixuan',

            dataType:'json',

            success:function(res) {
                html = "";
                $.each(res.data.orde, function(index, item){
                    html += '<li class="cofeOrderList">';
                    html += '<span class="c1">';
                                html += '<img src="'+item.user_pic+'" />';
                                html += '<em>'+item.user_name+'</em>';
                    html += '</span>';
                    html += '<span class="c2">'+formatDate('Y-m-d H:i',item.order_time)+'</span>';
                    html += '<span class="c3">'+item.time_delay+'</span>';
                    html += ' <span class="c4">'+res.data.store[index]+'km</span>';
                    html += '<a class="c5" style="color:#61acf4;" value="'+item.order_id+'" onclick="chankan('+item.order_id+');">查看详情</a>';
                    html += '<span class="c6">'+item.order_price+'元</span>';
                    html += '<a class="c7" id="qian_'+item.order_id+'" style="color:#61acf4;" onclick="qiandan('+item.order_id+');">抢单</a>';
                    html += '</li>';
                    $('.coffeeOrders ul').html(html);
                });
            }
            // ,error : function() {  
            //      // view("异常！");  
            //      alert("异常！");  
            // }  

        };

//关键在这里，Ajax定时访问服务端，不断获取数据 ，这里是1秒请求一次。

window.setInterval(function(){$.ajax(weixuan)},1000);
    //查看订单详情
    function chankan(order_id){
        $(".cafeOrders").removeClass("hide");
        $.ajax({
            type : 'post',
            url  : 'order_detail',
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
                        var price  = data[0].order_price;
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
                    var html = "";
                    html += '<div class="ordersNums">'
                                +'<em>'
                                   +'<i></i>'
                                    +'<hr/>'
                                +'</em>'
                                +'<div class="ordersContent">'
                                    +'<h4>订单编号</h4>'
                                   +' <p>'+number+'</p>'
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
                                 +'<h4>收获信息</h4>'
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
                                 +'<h4>订单编号</h4>';
                                 for(var it in data){
                                    html += '<p>';
                                        html += '<span>'+data[it].product_name+'<i>('+data[it].spec+')</i></span>';
                                        html += '<em>x'+data[it].goods_num+'</em>';
                                        html += '<dfn>¥'+data[it].money+'</dfn>';
                                     html+'= </p>';
                                 };
                                 html +='<div class="redPacket">'
                                     +'<em>积分优惠</em>'
                                     +'<span>-¥'+points+'</span>'
                                 +'</div>'
                                 +'<div class="redPacket carryM">'
                                        +'<em>配送费</em>'
                                        +'<span>¥'+fee+'</span>'
                                    +'</div>'
                                 +'<div class="weChatPay">'
                                     +'<span>'+code+'</span>'
                                     +'<em>¥'+price+'</em>'
                                 +'</div>'
                             +'</div>'
                         +'</div>'
                     html += '<div class="closeLay" style="margin-top:15px;"><span>关闭窗口</span></div>';
                $('.cafeOrders').html(html);
            }
        })
    }

    // 抢单
    function qiandan(order_id) {
        console.log(order_id);
        $.ajax({
            type : 'post',
            url  : 'single',
            data : {id:order_id},
            dataType : 'json',
            success  : function(data) {
                if(data.stuo == 55){
                    alert('抢单成功！');
                    $("#qian_"+order_id).html('<a class="c7" id="qian_'+order_id+'">已抢单</a>');
                } else {
                    alert('该订单已被其他门店抢走了！');
                }
            }
        })
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
</script>


<script>
//------日流量echarts开始------
$(function(){
    var dayChart = echarts.init(document.getElementById('dayMain'));
    option = {
        title: {
            text: '流量统计',
            x:'10',
            y:'10',
            textStyle:{
                fontSize:'14',
            }
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data:['进店','离店','在店'],
            x:'380',
            y:'10'
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: [
                <?php foreach ($a_view_data['passenger_min'] as $key => $value) {
                    $newtime = strtotime($value['time']);
                    echo '"'.date('H', $newtime).':00",';
                } ?>
            ],
            axisTick: {//坐标轴小标志
                alignWithLabel: true,
                interval:0,
                lineStyle:{
                    color:'#f1f1f1',
                }
            },
            axisLabel:{//坐标轴文本标签
                show:true,
                interval:0,
                textStyle:{
                    fontSize:'10',
                    color:'#999999',
                },
                formatter:function(params){
                    var newParamsName = "";// 最终拼接成的字符串
                    var params = params.replace('~','');
                    var paramsNameNumber = params.length;// 实际标签的个数
                    var provideNumber = 5;// 每行能显示的字的个数
                    var rowNumber = Math.ceil(paramsNameNumber / provideNumber);// 换行的话，需要显示几行，向上取整
                    //* 判断标签的个数是否大于规定的个数， 如果大于，则进行换行处理 如果不大于，即等于或小于，就返回原标签
                    // 条件等同于rowNumber>1
                    if (paramsNameNumber > provideNumber) {
                        /** 循环每一行,p表示行 */
                        for (var p = 0; p < rowNumber; p++) {
                            var tempStr = "";// 表示每一次截取的字符串
                            var start = p * provideNumber;// 开始截取的位置
                            var end = start + provideNumber;// 结束截取的位置
                            // 此处特殊处理最后一行的索引值
                            if (p == rowNumber - 1) {
                                // 最后一次不换行
                                tempStr = params.substring(start, paramsNameNumber);
                            } else {
                                // 每一次拼接字符串并换行
                                tempStr = params.substring(start, end) + "\n";
                            }
                            newParamsName += tempStr;// 最终拼成的字符串
                        }

                    } else {
                        // 将旧标签的值赋给新标签
                        newParamsName = params;
                    }
                    //将最终的字符串返回
                    return newParamsName;
                }
            },
            splitLine:{//分割线
                show:false,
            },
            axisLine:{//坐标轴线
                lineStyle:{
                    color: "#f1f1f1",
                }
            }
        },
        yAxis: {
            type: 'value',
            axisLabel:{
                textStyle:{
                    color:'#999999',
                    fontSize:10
                }
            },
            splitLine:{
                show:false,
            },
            axisLine:{
                lineStyle:{
                    color: "#f1f1f1"
                }
            }

        },
        series: [
            {
                name:'进店',
                type:'line',
                data:[
                    <?php foreach ($a_view_data['passenger_min'] as $key => $value) {
                        echo $value['in'].',';
                    } ?>
                ],
                itemStyle:{
                    normal:{
                        color:'#21c393',
                        lineStyle:{
                            color:'#21c393',
                            width:'2',
                        }
                    }
                }
            },
            {
                name:'离店',
                type:'line',
                data:[
                    <?php foreach ($a_view_data['passenger_min'] as $key => $value) {
                        echo $value['out'].',';
                    } ?>
                ],
                itemStyle:{
                    normal:{
                        color:'#fad567',
                        lineStyle:{
                            width:'2',
                        }
                    }
                }
            },
            {
                name:'在店',
                type:'line',
                data:[
                    <?php $i_in = 0; $i_out = 0; foreach ($a_view_data['passenger_min'] as $key => $value) {
                        $i_in = $i_in + $value['in'];
                        $i_out = $i_out + $value['out'];
                        echo $i_in-$i_out.',';
                    } ?>
                ],
                itemStyle:{
                    normal:{
                        color:'#6a8ee3',
                        lineStyle:{
                            width:'2',
                        }
                    }
                }
            }

        ],

    };
    dayChart.setOption(option);
})
//------日流量echarts结束------
//------周流量echarts开始------
$(function(){
    var weekChart = echarts.init(document.getElementById('weekMain'));
    option = {
        title: {
            text: '流量统计',
            x:'10',
            y:'10',
            textStyle:{
                fontSize:'14',
            }
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data:['进店'],
            x:'508',
            y:'10'
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: [
                <?php $timeii = 0; foreach ($a_view_data['passenger_day']['content'] as $key => $value) {
                    if ($timeii == 0 || $timeii%7 == 0) {
                        $newtime = strtotime($value['time']);
                        echo '"'.date('m-d', $newtime).'",';
                    }
                    $timeii++;
                } ?>
            ],
            //data: ['11-01','11-02','11-03','11-04','11-05','昨天','今天'],
            axisTick: {//坐标轴小标志
                alignWithLabel: true,
                interval:0,
                lineStyle:{
                    color:'#f1f1f1',
                }
            },
            axisLabel:{//坐标轴文本标签
                show:true,
                interval:0,
                textStyle:{
                    fontSize:'10',
                    color:'#999999',
                }
            },
            splitLine:{//分割线
                show:false,
            },
            axisLine:{//坐标轴线
                lineStyle:{
                    color: "#f1f1f1",
                }
            }
        },
        yAxis: {
            type: 'value',
            axisLabel:{
                textStyle:{
                    color:'#999999',
                    fontSize:10
                }
            },
            splitLine:{
                show:false,
            },
            axisLine:{
                lineStyle:{
                    color: "#f1f1f1"
                }
            }

        },
        series: [
            {
                name:'进店',
                type:'line',
                //data:[300,200,250,100,390,100,210],
                data:[
                <?php $timeii = 0; $i_in = 0; foreach ($a_view_data['passenger_day']['content'] as $key => $value) {
                    $i_in = $i_in + $value['in'];
                    if ($timeii == 0 || $timeii%7 == 0) {
                        $newtime = strtotime($value['time']);
                        echo  $i_in.',';
                        $i_in = 0;
                    }
                    $timeii++;
                } ?>
                ],
                itemStyle:{
                    normal:{
                        color:'#21c393',
                        lineStyle:{
                            color:'#21c393',
                            width:'2',
                        }
                    }
                }
            },
        ],

    };
    weekChart.setOption(option);
})
//------周流量echarts结束------
//------月流量echarts开始------
$(function(){
    var monthChart = echarts.init(document.getElementById('monthMain'));
    option = {
        title: {
            text: '流量统计',
            x:'10',
            y:'10',
            textStyle:{
                fontSize:'14',
            }
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data:['进店'],
            x:'508',
            y:'10'
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: [
                <?php foreach ($a_view_data['passenger_day']['content'] as $key => $value) {
                    $newtime = strtotime($value['time']);
                    echo '"'.date('m-d', $newtime).'",';
                } ?>
            ],
            axisTick: {//坐标轴小标志
                alignWithLabel: true,
                interval:0,
                lineStyle:{
                    color:'#f1f1f1',
                }
            },
            axisLabel:{//坐标轴文本标签
                show:true,
                //interval:0,
                textStyle:{
                    fontSize:'10',
                    color:'#999999',
                }
            },
            splitLine:{//分割线
                show:false,
            },
            axisLine:{//坐标轴线
                lineStyle:{
                    color: "#f1f1f1",
                }
            }
        },
        yAxis: {
            type: 'value',
            axisLabel:{
                textStyle:{
                    color:'#999999',
                    fontSize:10
                }
            },
            splitLine:{
                show:false,
            },
            axisLine:{
                lineStyle:{
                    color: "#f1f1f1"
                }
            }

        },
        series: [
            {
                name:'进店',
                type:'line',
                data:[
                    <?php foreach ($a_view_data['passenger_day']['content'] as $key => $value) {
                        echo $value['in'].',';
                    } ?>
                ],
                itemStyle:{
                    normal:{
                        color:'#21c393',
                        lineStyle:{
                            color:'#21c393',
                            width:'2',
                        }
                    }
                }
            },
        ],

    };
    monthChart.setOption(option);
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
//------周流量echarts结束------
</script>