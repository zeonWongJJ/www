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
    <link rel="stylesheet" href="./static/style_default/style/selectSeat.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/flexible.js"></script>
    <script src="./static/style_default/script/selectSeat.js"></script>
    <title>选择座位</title>
</head>
<body>
<!-- 拉框开始 -->
<?php echo $this->display('head'); ?>
<!-- 拉框结束 -->
<!--  选择座位  -->
<div class="selectSeat">
    <p class="pjoTitle">
        <a href="office_appoint-<?php echo $a_view_data['orderinfo']['office_id']; ?>"><img src="./static/style_default/images/gouxiang_18.png" /></a>
        <span>选择座位</span>
    </p>
    <div class="roomBox">
        <ul>
            <li class="roomtype">
                <span><?php echo $a_view_data['roomtype']['type_name']; ?></span><em>-</em><dfn><?php echo $a_view_data['room']['room_name']; ?></dfn>
            </li>
            <li class="roomTime">
                <span>今天</span><em><?php if (!empty($a_view_data['orderinfo']['beginseat'])) { echo date('H:i', $a_view_data['orderinfo']['beginseat']); } else { echo '未选择'; }; ?></em>-<dfn><?php if (!empty($a_view_data['orderinfo']['endseat'])) { echo date('H:i', $a_view_data['orderinfo']['endseat']); } else { echo '未选择'; }; ?></dfn>
            </li>
            <li class="roomPosition">
                <ol>
                    <li>
                        <img src="./static/style_default/images/seat_03.png" />
                        <span>可选</span>
                    </li>
                    <li>
                        <img src="./static/style_default/images/seat_05.png" />
                        <span>已售</span>
                    </li>
                    <li>
                        <img src="./static/style_default/images/seat_07.png" />
                        <span>已选</span>
                    </li>
                    <li>
                        <img src="./static/style_default/images/seat_09.png" />
                        <span>门</span>
                    </li>
                    <li>
                        <img src="./static/style_default/images/seat_11.png" />
                        <span>窗口</span>
                    </li>
                </ol>
            </li>
        </ul>
    </div>
    <!--  座位 -->
    <div class="seat">
        <ul>
            <?php $m=2; for($i=0; $i<$a_view_data['plan'][0]; $i++){ ?>
            <li class="row">
                <ol>
                    <?php for($j=0; $j<$a_view_data['plan'][1]; $j++){ ?>
                    <li class="col <?php if ($a_view_data['plan'][$m] == 4) { echo 'su'; } ?>"
                        name="<?php echo $a_view_data['plan'][$m]; ?>"
                        seatname="<?php echo $a_view_data['seatname'][$m-2]; ?>">
                    <?php if ($a_view_data['plan'][$m] == 1) {
                        echo '<img src="./static/style_default/images/seat_09.png" />';
                    } else if ($a_view_data['plan'][$m] == 2)  {
                        echo '<img src="./static/style_default/images/seat_11.png" />';
                    } else if ($a_view_data['plan'][$m] == 4)  {
                        echo '<img src="./static/style_default/images/seat_03.png" />';
                    } ?>
                    </li>
                    <?php $m++; }; ?>
                </ol>
            </li>
            <?php }; ?>
        </ul>
    </div>
    <!--  座位 -->
</div>
<!-- 选择座位 -->

<input type="hidden" name="occupy" value="<?php echo $a_view_data['occupy']; ?>">

<!-- 底部 -->
<div class="bottom">
    <dl>
        <dt>已选座位</dt>
        <dd>
            <span>请选择座位</span>
            <img class="clearSeat" src="./static/style_default/images/seat_19.png" />
        </dd>
    </dl>
    <input type="button" class="sureSeat disabled" value="确认选座" />
</div>
<!-- 底部 -->

<div class="tips"></div>


<form id="seatform" action="office_appoint2" method="post">

<input type="hidden" name="office_seat">
<input type="hidden" name="office_seatname">
<input type="hidden" name="office_id" value="<?php echo $a_view_data['orderinfo']['office_id']; ?>">
<input type="hidden" name="beginseat" value="<?php echo $a_view_data['orderinfo']['beginseat']; ?>">
<input type="hidden" name="endseat" value="<?php echo $a_view_data['orderinfo']['endseat']; ?>">
<input type="hidden" name="linkman" value="<?php echo $a_view_data['orderinfo']['linkman']; ?>">
<input type="hidden" name="link_phone" value="<?php echo $a_view_data['orderinfo']['link_phone']; ?>">
<input type="hidden" name="code" value="<?php echo $a_view_data['orderinfo']['code']; ?>">
<input type="hidden" name="pay_type" value="<?php echo $a_view_data['orderinfo']['pay_type']; ?>">
<input type="hidden" name="actual_pay" value="<?php echo $a_view_data['orderinfo']['actual_pay']; ?>">
<input type="hidden" name="appointment_type" value="2">

</form>


</body>
</html>

<script>

// 已占用的座位
function seat_occupy() {
    var i = 1;
    var occupy = $("input[name='occupy']").val();
    occupy = occupy.split(",");
    $('.seat .row .col').each(function(index, el) {
        // 设置座位号
        $(this).attr('office_seat', i);
        // 标注已占用的座位
        for (var j=0; j<occupy.length; j++) {
            if (i==occupy[j]) {
                $(this).addClass('have');
                $(this).children('img').attr('src','./static/style_default/images/seat_05.png');
            }
        }
        i++;
    });
}

// 提交表单
$('.sureSeat').click(function(event) {
    $('#seatform').submit();
});

</script>