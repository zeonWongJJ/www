<?php
    $seconds_to_cache = 1800;
    $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
    header("Expires: $ts"); header("Pragma: cache");
    header("Cache-Control: max-age=$seconds_to_cache");
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
    <link rel="stylesheet" href="./static/style_default/style/common.css"/>
    <link rel="stylesheet" href="./static/style_default/style/makeOffice.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/flexible.js"></script>
    <script src="./static/style_default/script/makeOffice.js"></script>
    <title>预约办公室</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!--  预约办公室  -->
    <div class="makeOffice">
        <p class="pjoTitle">
            <a href="office_detail-<?php echo $a_view_data['office']['office_id']; ?>"><img src="./static/style_default/images/gouxiang_18.png" /></a>
            <span><?php if ($_SESSION['appointment_type'] == 1) { echo '预定办公室'; } else { echo '预约座位'; } ?></span>
        </p>
        <form id="seatform" action="office_appoint3" method="post">
            <div class="storeName">
                <?php if (empty($a_view_data['store']['store_touxiang'])) {
                    echo '<img src="./static/style_default/images/tou_03.png" />';
                } else {
                    echo '<img src="'.get_config_item('store_touxiang').$a_view_data['store']['store_touxiang'].'" />';
                } ?>
                <em>
                    <h1><?php echo $a_view_data['store']['store_name']; ?></h1>
                    <span><?php echo $a_view_data['roomtype']['type_name']; ?>-<?php echo $a_view_data['room']['room_name']; ?></span>
                </em>
                价格：<span style="color:red;"><?php echo $a_view_data['office']['office_price']; ?>元/小时</span>
            </div>
            <!-- 选择入座时间 -->
            <div class="seat">
                <ul>
                    <li class="seatTime">
                        <span>入座时间</span>
                        <em>离座时间</em>
                    </li>
                    <li class="seatTimeCho">
                        <span class="choiceTimeA" <?php if (!empty($a_view_data['orderinfo']['beginseat'])) { echo "style='color: rgb(255, 127, 0);'"; } ?> >
                        <?php if (empty($a_view_data['orderinfo']['beginseat'])) {
                            echo '选择时间';
                        } else {
                            echo '今天'.date('H:i', $a_view_data['orderinfo']['beginseat']);
                        } ?>
                        </span>
                        <em>-</em>
                        <span class="choiceTimeB" <?php if (!empty($a_view_data['orderinfo']['endseat'])) { echo "style='color: rgb(255, 127, 0);'"; } ?>>
                        <?php if (empty($a_view_data['orderinfo']['endseat'])) {
                            echo '选择时间';
                        } else {
                            echo '今天'.date('H:i', $a_view_data['orderinfo']['endseat']);
                        } ?>
                        </span>
                    </li>
                    <li class="seatNum">
                        <span>座位号</span>
                        <a href="javascript:;" onclick="seat_choose()">
                            <span>
                            <?php if (!empty($a_view_data['orderinfo']['office_seatname'])) {
                                echo $a_view_data['orderinfo']['office_seatname'];
                            } else {
                                echo '点击选择';
                            } ?>
                            </span>
                            <img src="./static/style_default/images/shezhi_03.png" />
                        </a>
                    </li>
                </ul>
            </div>
            <!-- 选择入座时间 -->
            <input type="hidden" name="office_id" value="<?php echo $a_view_data['office']['office_id']; ?>">
            <input type="hidden" name="beginseat" value="<?php echo $a_view_data['orderinfo']['beginseat']; ?>">
            <input type="hidden" name="endseat" value="<?php echo $a_view_data['orderinfo']['endseat'] ?>">
            <input type="hidden" name="office_seat" value="<?php echo $a_view_data['orderinfo']['office_seat'] ?>">
            <input type="hidden" name="office_seatname" value="<?php echo $a_view_data['orderinfo']['office_seatname'] ?>">
            <input type="hidden" name="room_id" value="<?php echo $a_view_data['room']['room_id'] ?>">
            <input type="hidden" name="store_id" value="<?php echo $a_view_data['store']['store_id'] ?>">
            <input type="hidden" name="room_name" value="<?php echo $a_view_data['room']['room_name'] ?>">
            <input type="hidden" name="room_type" value="<?php echo $a_view_data['roomtype']['type_name'] ?>">
            <input type="hidden" name="pay_type" value="<?php echo $a_view_data['orderinfo']['pay_type']; ?>">
            <input type="hidden" name="actual_pay" value="<?php echo $a_view_data['orderinfo']['actual_pay']; ?>">
            <input type="hidden" name="appointment_type" value="<?php echo $a_view_data['orderinfo']['appointment_type']; ?>">
            <!-- 联系人 -->
            <div class="contact">
                <ul>
                    <li class="contactName">
                        <span>联系人</span>
                        <input type="text" name="linkman" id="contact_name" placeholder="请填写联系人姓名" value="<?php echo $a_view_data['orderinfo']['linkman']; ?>" />
                    </li>
                    <li class="contactPhone">
                        <span>联系电话</span>
                        <input type="text" name="link_phone" id="contact_phone" placeholder="请填写联系电话" value="<?php echo $a_view_data['orderinfo']['link_phone']; ?>" />
                    </li>
                    <li class="contactCode">
                    	<em><input value="获取验证码" type="button" id="codeBtn" class=" removeBtn"></em>
                        <input type="text" name="code" value="<?php echo $a_view_data['orderinfo']['code']; ?>" placeholder="验证码" id="contact_code"/>
                    </li>
                </ul>
            </div>
            <!-- 联系人 -->

            <div class="payWay">
            	<input type="hidden" name="perprice" value="<?php echo $a_view_data['office']['office_price']; ?>">
            	<h2>需付：<span id="actual_payshow"><?php echo $a_view_data['orderinfo']['actual_pay']; ?></span>元</h2>
            	<input type="hidden" name="actual_pay" value="<?php echo $a_view_data['orderinfo']['actual_pay']; ?>">
            选择支付方式：
            	<select name="pay_type" onchange="cahnge_paytype()" id="sel_paytype">
                	<option value="1" <?php if ($a_view_data['orderinfo']['pay_type'] == 1) { echo 'selected'; } ?>>支付宝</option>
                	<option value="2" <?php if ($a_view_data['orderinfo']['pay_type'] == 2) { echo 'selected'; } ?>>微信</option>
                	<option value="3" <?php if ($a_view_data['orderinfo']['pay_type'] == 3) { echo 'selected'; } ?>>银行卡</option>
            	</select>

            </div>
            <br>
            <p class="contactText">*提交预约后，联系人信息将绑定此账号</p>

            <!-- 底部 -->
            <input type="submit" id="makeSub" value="确定预约"/>
            <!-- 底部 -->
        </form>
    </div>
    <!-- 预约办公室 -->

    <!-- 选择座位时间 -->
    <div class="choiceSeatTime">
         <p>
             <a class="cancel">取消</a>
             <span>入座时间</span>
             <input type="button" value="下一步" id="nextStep" />
         </p>
         <div class="timeBox">
             <a class="date"></a>
             <ul class="seated">
                 <?php
                    for ($i=0; $i < count($a_view_data['time']); $i++) {
                        echo '<li value="'.$a_view_data['time'][$i].'">'.date('H:i', $a_view_data['time'][$i]).'</li>';
                    }
                 ?>
             </ul>
             <ul class="leaveSeat">
                 <?php
                    for ($i=1; $i < count($a_view_data['time']); $i++) {
                        echo '<li value="'.$a_view_data['time'][$i].'">'.date('H:i', $a_view_data['time'][$i]).'</li>';
                    }
                 ?>
             </ul>
         </div>
    </div>
    <!-- 选择座位时间 -->

    <div class="tips"></div>
    <div class="lay"></div>
</body>
</html>

<script>

$(function(){
    var timer = window.setInterval("weixin_ispay()", 1000);
})

function cahnge_paytype() {
    sel_pay = $("#sel_paytype").val();
    $("input[name='pay_type']").val(sel_pay);
}

function seat_choose() {
    $("#seatform").attr('action', 'office_appoint');
    $("#seatform").submit();
}

function weixin_ispay(){
    var pay_type = $("input[name='pay_type']").val();
    var appointment_type = "<?php echo $_SESSION['appointment_type']; ?>";
    if (pay_type == 2) {
        $.ajax({
            url: 'weixin_ispay',
            type: 'POST',
            dataType: 'json',
            data: {appointment_type: appointment_type},
            success: function(res) {
                if (res.code == 200) {
                    if (appointment_type == 1) {
                        window.location.href = "order_office";
                    } else {
                        window.location.href = "book_order";
                    }
                }
            }
        })
    }
}

</script>