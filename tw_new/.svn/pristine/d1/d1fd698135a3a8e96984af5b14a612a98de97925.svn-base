<?php
    // 缓存页面
    // $seconds_to_cache = 1800;
    // $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
    // header("Expires: $ts"); header("Pragma: cache");
    // header("Cache-Control: max-age=$seconds_to_cache");
    // 不缓存页面
    // header("Cache-Control: no-store, no-cache, must-revalidate");
    // header("Cache-Control: post-check=0, pre-check=0", false);
    // header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/distributionOrder.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/distributionOrder.js"></script>
    <title>结算</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 订单配送  -->
    <div class="distributionOrder">
        <!-- 默认的收货地址 -->
        <input type="hidden" name="address_default" value="<?php if (!empty($a_view_data['memb'])) { echo $a_view_data['memb']['address_id']; } else { echo '0'; } ?>">
        <p class="pjoTitle">
            <a href="javascript:window.history.back(-2);"><img src="static/style_default/images/dri_03.png" /></a>
            <span>配送至</span>
        </p>
        <div class="addressInfo">
            <?php if (empty($a_view_data['memb'])) { ?>
            <a href="address?oldurl=<?php echo $_GET['oldurl']?>"><p>+添加配送地址</p></a>
            <?php } else {?>
            <a href="address?oldurl=<?php echo $_GET['oldurl']?>">
                <dl>
                    <dd class="contact">
                        <span class="userName"><?php echo $a_view_data['memb']['user_name']; ?>(<?php if ($a_view_data['memb']['nei'] == 1) {
                            echo "先生";
                        } else { echo "女士";}?>)</span>
                        <em class="phone"><?php echo $a_view_data['memb']['mob_phone']; ?></em>
                        <dfn>默认</dfn>
                    </dd>
                    <dd class="address">
                        <?php echo $a_view_data['memb']['address']; ?>（<?php echo $a_view_data['memb']['house']?>）
                    </dd>
                </dl>
            </a>
            <?php }?>
        </div>
        <!-- 订单 -->
        <form action="coffee_newpay?oldurl=<?php echo $_GET['oldurl']?>" method="post" id="payform">
        <div class="orders">
            <!-- 判断进来方式 -->
            <?php if ($a_view_data['come_type'] == 1) { ?>
            <!-- 有门店的产品 -->
            <?php if (!empty($a_view_data['goods']['store'])) { ?>
            <?php for($i=0; $i<count($a_view_data['goods']['store']); $i++) { ?>
            <dl>
                <dt class="storeName">
                    <span><?php echo $a_view_data['goods']['store'][$i]['store_name']; ?></span>
                </dt>
                <?php foreach ($a_view_data['goods']['store'][$i]['cart'] as $key => $value) { ?>
                <dd class="dishes">
                    <span><?php echo $value['product_name']; ?></span>
                    <em>x<?php echo $value['prot_count']; ?></em>
                    <dfn>￥<?php echo $value['new_price']; ?></dfn>
                </dd>
                <?php } ?>
                <dd class="distri">
                    <span>配送费</span>
                    <dfn>￥<?php echo $a_view_data['goods']['store'][$i]['freight']; ?></dfn>
                </dd>
                <dd class="message">
                    <span>留言：</span>
                    <input type="text" name="order_message_<?php echo $a_view_data['goods']['store'][$i]['store_id']; ?>" placeholder="选填"/>
                </dd>
            </dl>
            <?php } ?>
            <?php } ?>
            <!-- 无门店的产品 -->
            <?php if (!empty($a_view_data['goods']['nostore'])) { ?>
            <dl>
                <dt class="storeName">
                    <span><?php echo $a_view_data['goods']['nostore']['name'] ?></span>
                </dt>
                <?php foreach ($a_view_data['goods']['nostore']['cart'] as $key => $value) { ?>
                <dd class="dishes">
                    <span><?php echo $value['product_name']; ?></span>
                    <em>x<?php echo $value['prot_count']; ?></em>
                    <dfn>￥<?php echo $value['new_price']; ?></dfn>
                </dd>
                <?php } ?>
                <dd class="distri">
                    <span>配送费</span>
                    <dfn>￥<?php echo $a_view_data['goods']['nostore']['freight']; ?></dfn>
                </dd>
                <dd class="message">
                    <span>留言：</span>
                    <input type="text" name="order_message_0" placeholder="选填"/>
                </dd>
            </dl>
            <?php } ?>
            <!-- 分享的产品 -->
            <?php if (!empty($a_view_data['goods']['share'])) { ?>
            <dl>
                <dt class="storeName">
                    <span><?php echo $a_view_data['goods']['share']['name'] ?></span>
                </dt>
                <?php foreach ($a_view_data['goods']['share']['cart'] as $key => $value) { ?>
                <dd class="dishes">
                    <span><?php echo $value['product_name']; ?></span>
                    <em>x<?php echo $value['prot_count']; ?></em>
                    <dfn>￥<?php echo $value['new_price']; ?></dfn>
                </dd>
                <?php } ?>
                <dd class="distri">
                    <span>配送费</span>
                    <dfn>￥<?php echo $a_view_data['goods']['share']['freight'] ?></dfn>
                </dd>
                <dd class="message">
                    <span>留言：</span>
                    <input type="text" name="order_message_s" placeholder="选填"/>
                </dd>
            </dl>
            <?php } ?>
            <?php } else if ($a_view_data['come_type'] == 2) { ?>
            <!-- 此处为立即购买 -->
            <dl>
                <dt class="storeName">
                    <span><?php echo $a_view_data['product']['title']; ?></span>
                </dt>
                <dd class="dishes">
                    <span><?php echo $a_view_data['product']['product_name']; ?></span>
                    <em>x<?php echo $a_view_data['goods_count_total']; ?></em>
                    <dfn>￥<?php echo $a_view_data['product']['new_price']; ?></dfn>
                </dd>
                <dd class="distri">
                    <span>配送费</span>
                    <dfn>￥<?php echo $a_view_data['product']['freight']; ?></dfn>
                </dd>
                <dd class="message">
                    <span>留言：</span>
                    <input type="text" name="order_message" placeholder="选填"/>
                </dd>
            </dl>
            <!-- 数量 -->
            <input type="hidden" name="prot_count" value="<?php echo $a_view_data['goods_count_total']; ?>">
            <!-- 门店名称 -->
            <input type="hidden" name="store_name" value="<?php echo $a_view_data['product']['store_name']; ?>">
            <!-- 门店id -->
            <input type="hidden" name="store_id" value="<?php echo $a_view_data['product']['store_id']; ?>">
            <!-- 运费 -->
            <input type="hidden" name="shipping_fee" value="<?php echo $a_view_data['product']['freight']; ?>">
            <!-- 产品id -->
            <input type="hidden" name="product_id" value="<?php echo $a_view_data['product']['product_id']; ?>">
            <!-- 属性 -->
            <input type="hidden" name="shux_name" value="<?php echo $a_view_data['shux']; ?>">
            <!-- 产品主图 -->
            <input type="hidden" name="imge" value="<?php echo $a_view_data['product']['pro_img']; ?>">
            <!-- 单价 -->
            <input type="hidden" name="money" value="<?php echo $a_view_data['product']['new_price']; ?>">
            <!-- 产品名称 -->
            <input type="hidden" name="goods_name" value="<?php echo $a_view_data['product']['product_name']; ?>">
            <?php } ?>
            <!-- 小计 -->
            <dl>
                <dd class="totalBox">
                    <span>共<em style="font-style:normal;"><?php echo $a_view_data['goods_count_total']; ?></em>件商品</span>
                    <em>
                        <span>小计</span>
                        <dfn>￥<?php echo $a_view_data['order_price']; ?></dfn>
                    </em>
                </dd>
            </dl>
        </div>

        <!-- 购物车id -->
        <input type="hidden" name="cart_ids" value="<?php echo $a_view_data['cart_ids']; ?>">
        <!-- 实付款 -->
        <input type="hidden" name="actual_pay" value="<?php echo $a_view_data['order_price']; ?>" id="actual_pay">
        <!-- 商品总价 -->
        <input type="hidden" name="goods_amount" value="<?php echo $a_view_data['goods_amount_total']; ?>" id="goods_amount">
        <!-- 订单总价 -->
        <input type="hidden" name="order_price" value="<?php echo $a_view_data['order_price']; ?>">
        <!-- 运费 -->
        <?php if ($a_view_data['come_type'] != 2) { ?>
        <input type="hidden" name="shipping_fee" value="<?php echo $a_view_data['shipping_fee']; ?>">
        <?php } ?>
        <!-- 余额抵扣 -->
        <input type="hidden" name="balance_deduction" value="0" id="balance_deduction">
        <!-- 积分抵扣 -->
        <input type="hidden" name="score_deduction" value="0" id="score_deduction">
        <!-- 送达时间 -->
        <input type="hidden" name="time_delay" value="<?php echo date("H:i",strtotime("+40 minute"));?>" id="time_delay">
        <!-- 支付方式 -->
        <input type="hidden" name="pay_type" value="1">
        <!-- 进入方式 -->
        <input type="hidden" name="come_type" value="<?php echo $a_view_data['come_type']?>">
        <!-- 抵扣的座位订单 -->
        <input type="hidden" name="appointment_ids" value ="<?php echo $a_view_data['appointment_id_str']?>">
        </form>
        <!-- 订单 -->

        <!-- 抵扣 -->
        <div class="deductible" style="display:none;">
            <ul>
                <li class="blance">
                    <span>余额</span>
                    <em>共￥<span><?php echo $a_view_data['user']['user_balance']?></span></em>
                    <dfn>抵扣￥<span class="mone"></span></dfn>
                    <img class="" src="static/style_default/images/dr_03.png" />
                    <input type="hidden" id="mone" value="1">
                </li>
                <li class="point">
                    <span>积分</span>
                    <em>共<span><?php echo $a_view_data['user']['user_score']?></span>积分</em>
                    <dfn>抵扣￥<span class="score"></span></dfn>
                    <img class="" src="static/style_default/images/dr_03.png" />
                    <input type="hidden" id="score" value="1">
                </li>
            </ul>
        </div>
        <!-- 抵扣 -->

<div class="decContainer">
	<p id="dktips" style="color:red;"></p>
	<p class="userBalance">我的余额：<?php echo $a_view_data['user']['user_balance']; ?>元</p>
	<p>输入抵扣金额：<input style="width:50px;" type="text" name="mybanlanceto" value="0" oninput="banlance_change()"></p>

	<p>我的积分：<?php echo $a_view_data['user']['user_score']; ?>积分</p>
	<p>输入抵扣的积分：<input style="width:50px;" type="text" name="myscoreto" value="0" oninput="score_change()"> &nbsp;&nbsp;[一积分等于一元]</p>
</div>


<script>

var have_ban = "<?php echo $a_view_data['user']['user_balance']; ?>";
var have_score = "<?php echo $a_view_data['user']['user_score']; ?>";
var order_price = "<?php echo $a_view_data['order_price']; ?>";
var max_dk = "<?php echo $a_view_data['order_price']; ?>";
var ac_pay = "<?php echo $a_view_data['order_price']; ?>";

function banlance_change() {
    var this_ban = $("input[name='mybanlanceto']").val();
    if (parseFloat(this_ban) > parseFloat(have_ban) || parseFloat(this_ban) > parseFloat(order_price)) {
        $("input[name='mybanlanceto']").val('0');
        $("#dktips").html('抵扣金额有误');
    }
    ac_reset(1);
}


function score_change() {
    var this_score = $("input[name='myscoreto']").val();
    console.log(ac_pay);
    if (parseInt(this_score) > parseInt(have_score) || parseInt(this_score) > parseFloat(order_price)) {
        $("input[name='myscoreto']").val('0');
        $("#dktips").html('抵扣积分有误');
    }
    ac_reset(2);
}

function ac_reset(cometype) {
    var this_ban = $("input[name='mybanlanceto']").val();
    var this_score = $("input[name='myscoreto']").val();
    if (isNaN(parseFloat(this_ban)) && isNaN(parseInt(this_score))) {
        ac_pay = parseFloat(order_price);
    } else if (isNaN(parseInt(this_score))) {
        ac_pay = parseFloat(order_price) - parseFloat(this_ban);
    } else if (isNaN(parseFloat(this_ban))){
        ac_pay = parseFloat(order_price) - parseInt(this_score);
    } else {
        ac_pay = parseFloat(order_price) - (parseFloat(this_ban) + parseInt(this_score));
        ac_pay = Math.floor(ac_pay*100)/100;
    }

    var thisseatprice = 0;
    $('.selectseat').each(function(index, el) {
        if ($(this).attr('checked')) {
            if (isNaN(parseFloat(thisseatprice))) {
                thisseatprice = parseFloat($(this).attr('myprice'));
            } else {
                thisseatprice = thisseatprice + parseFloat($(this).attr('myprice'));
            }
        }
    });

    if (isNaN(parseFloat(thisseatprice)) == false) {
        if (parseFloat(thisseatprice) <= order_price) {
            ac_pay = parseFloat(ac_pay) - parseFloat(thisseatprice);
        } else {
            ac_pay = 0;
        }
    }

    if (parseFloat(ac_pay) < 0) {
        if (cometype == 1) {
            $("input[name='mybanlanceto']").val('0');
            banlance_change();
        } else if (cometype == 2) {
            $("input[name='myscoreto']").val('0');
            score_change();
        } else if (cometype == 3) {
            ac_pay = 0;
            $("#myacpay").html(ac_pay);
            $("#pute").html(ac_pay);
            $("#actual_pay").val(ac_pay);
            $("input[name='balance_deduction']").val(this_ban);
            $("input[name='score_deduction']").val(this_score);
            $("#moune").html(ac_pay);
        }
    } else {
        ac_pay = Math.floor(ac_pay*100)/100;
        $("#myacpay").html(ac_pay);
        $("#pute").html(ac_pay);
        $("#actual_pay").val(ac_pay);
        $("#balance_deduction").val(this_ban);
        $("input[name='score_deduction']").val(this_score);
        $("#moune").html(ac_pay);
    }
}


</script>


<?php if (!empty($a_view_data['store_arr']) && !empty($a_view_data['appointment'])) { ?>
<div class="seatContainer">
    <?php foreach ($a_view_data['store_info'] as $key => $value) { ?>
		<h3><?php echo $value['store_name']; ?></h3>
        <?php foreach ($a_view_data['appointment'] as $k => $v) { ?>
            <?php if ($value['store_id'] == $v['store_id']) { ?>
            	<label for="selectseat">
            		<!--- <img src="static/style_default/images/redbag_10.png" alt="" />-->
            		<span><?php echo '座位：'.str_replace(',', '、', $v['office_seatname']). '已抵扣'.$v['appointment_price'].'元'; ?></span>
            	</label>
                <input  type="hidden" class="selectseat" name="appointment_ids[]" value="<?php echo $v['appointment_id']; ?>" myprice="<?php echo $v['appointment_price']; ?>" >
                
                <br>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>
<?php } ?>




        <!-- 送达时间 -->
        <div class="serviceTime">
            <span>送达时间</span>
            <em>尽快送达[预计<span id="time"><?php echo date("H:i",strtotime("+40 minute"));?></span>]</em>
            <img src="static/style_default/images/shezhi_03.png" />
        </div>
        <!-- 送达时间 -->
    </div>
    <!-- 订单配送  -->

    <div class="lay"></div>
    <div class="lay1"></div>
    <!-- 底部 -->
    <div class="bottom">
        <div class="priceView">
            <span>实付款：￥<em id="pute"><?php echo $a_view_data['order_price']; ?></em></span>
        </div>
        <a>去支付</a>
    </div>
    <!-- 底部 -->

    <!-- 付款 -->
    <div class="payment">
        <dl>
            <dt class="surplusTime">
                <span>请在<em>30分00秒</em>内完成支付</span>
                <img class="closeSurplus" src="static/style_default/images/y_03.png" />
            </dt>
            <dd class="zhifubao payCur clickdd" value="1">
                <img src="static/style_default/images/zhifubao_03.png" />
                <span>支付宝支付</span>
                <i class="checkPay "><img src="static/style_default/images/dr_07.png" /></i>
            </dd>
            <dd class="weixin clickdd" value="2">
                <img src="static/style_default/images/weChat_03.png" />
                <span>微信支付</span>
                <i class="checkPay none"><img src="static/style_default/images/dr_07.png" /></i>
            </dd>
            <dd class="yinhangka clickdd" value="3">
                <img src="static/style_default/images/y_07.png" />
                <span>银行卡支付</span>
                <i class="checkPay none"><img src="static/style_default/images/dr_07.png" /></i>
            </dd>
            <dd class="surePay" onclick="gotopay()">
                <a href="javascript:;">
                    <span>继续支付￥<em id="moune"><?php echo $a_view_data['order_price']; ?></em></span>
                </a>
            </dd>
        </dl>
    </div>
    <!-- 付款 -->
    <!-- 选择送达时间 -->
    <div class="choiceTime">
        <dl>
            <dt>
                <span>送达时间</span>
                <img class="closeTime" src="static/style_default/images/y_03.png" />
            </dt>
            <dd class="date">
                <span>今天(周<?php echo mb_substr( "日一二三四五六",date("w"),1,"utf-8" );?>)</span>
            </dd>
            <dd class="time">
                <ul>
                    <li class="timeCur">
                        <span>尽快送达 [预计<em><?php echo date("H:i",strtotime("+40 minute"));?></em>]</span>
                    </li>
                      <?php
                            $start = strtotime(date("H:i",strtotime("+40 minute")));
                             // $start   = strtotime(date("10:00"));
                            $end   = strtotime(date("20:00"));
                        for($time  = $start; $time <= $end; $time = $time + 15 * 60){?>
                        <li>
                            <span><?php echo date("H:i", $time)?></span>
                        </li>
                    <?php }?>
                </ul>
            </dd>
        </dl>
    </div>
    <!-- 选择送达时间 -->
</body>
</html>

<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>

<script>

//防止页面后退
// history.pushState(null, null, document.URL);
// window.addEventListener('popstate', function () {
//     history.pushState(null, null, document.URL);
// });


var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

function address_choose() {
    if (isAndroid) {
        var callbackSuccess = function(address){
            alert(address);
        };
        addressLocation(callbackSuccess);
    }
}


var seatmyprice = 0;
$('.selectseat').click(function(event) {
    var appointment_arr = new Array();
    var i = 0;
    $('.selectseat').each(function(index, el) {
        if ($(this).attr('checked')) {
            appointment_arr[i] = $(this).val();
           
            if (isNaN(parseFloat(seatmyprice))) {
                seatmyprice = parseFloat($(this).attr('myprice'));
                console.log(seatmyprice)
            } else {
                seatmyprice = seatmyprice + parseFloat($(this).attr('myprice'));
            }
            i++;
        }
    });
    var appointment_str = appointment_arr.join(',');
    $("input[name='appointment_ids']").val(appointment_str);
    ac_reset(3);
});


$(function(){
    var timer = window.setInterval("weixin_ispay()", 1000);
})

function weixin_ispay(){
    var pay_type = $("input[name='pay_type']").val();
    if (pay_type == 2) {
        $.ajax({
            url: 'weixin_ispay_bill',
            type: 'POST',
            dataType: 'json',
            data: {pay_type: pay_type},
            success: function(res) {
                if (res.code == 200) {
                    window.location.href = "goods_order";
                }
            }
        })
    }
    // 验证收货地址是否变化
    // var this_address = $("input[name='address_default']").val();
    // $.ajax({
    //     url: 'address_default',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: {param1: 'value1'},
    //     success: function(res) {
    //         console.log(res);
    //         var oldurl = "<?php echo $_GET['oldurl']; ?>";
    //         if (res.code == 200) {
    //             if (res.data.address_id != this_address) {
    //                 var append_content = '';
    //                 append_content += '<a href="address?oldurl='+oldurl+'">';
    //                 append_content += '<dl>';
    //                 append_content += '<dd class="contact">';
    //                 append_content += '<span class="userName">';
    //                 append_content += res.data.user_name;
    //                 if (res.data.nei == 1) {
    //                     append_content += '（先生）';
    //                 } else {
    //                     append_content += '（女士）';
    //                 }
    //                 append_content += '</span>';
    //                 append_content += '<em class="phone">'+res.data.mob_phone+'</em>'
    //                 append_content += '<dfn>默认</dfn>';
    //                 append_content += '</dd>';
    //                 append_content += '<dd class="address">';
    //                 append_content += res.data.address + '('+res.data.house+')';
    //                 append_content += '</dd>';
    //                 append_content += '</dl>';
    //                 append_content += '</a>';
    //                 $('.addressInfo').html(append_content);
    //                 $("input[name='address_default']").val(res.data.address_id);
    //             }
    //         } else {
    //             $('.addressInfo').html('<a href="address?oldurl='+oldurl+'"><p>+添加配送地址</p></a>')
    //         }
    //     }
    // })
}


function gotopay() {
    $("#payform").submit();
}

</script>