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
    <link rel="stylesheet" href="static/style_default/style/editAddress.css"/>
    <link rel="stylesheet" href="static/style_default/script/need/layer.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/layer.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/editAddress.js"></script>
    <title>地址修改</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
     <!-- 编辑收货地址  -->
    <div class="editAddress">
        <p class="pjoTitle">
            <a href="address?oldurl=<?php echo $_GET['oldurl'];?>"><img src="static/style_default/images/yongping_03.png" alt=""/></a>
            <span>编辑收货地址</span>
        </p>

        <div class="addressForm">
            <form id="addressform" method="post">
                <ul>
                    <input type="hidden" name="id" value="<?php echo $a_view_data['address_id']?>">
                    <li class="editContact">
                        <span>联系人</span>
                        <input type="text" id="edit_contact" placeholder="联系人姓名" name="name" value="<?php echo $a_view_data['user_name']?>" />
                    </li>
                    <li class="editSex">
                        <a class="man" value="1">
                            <?php if ($a_view_data['nei'] == 1) {
                              echo '<img src="static/style_default/images/ck_03.png" alt=""/>';
                            } else {
                              echo '<img src="static/style_default/images/check_06.png" alt=""/>';}?>
                            <span>先生</span>
                        </a>
                        <a class="lady" value="2">
                            <?php if ($a_view_data['nei'] == 2) {
                              echo '<img src="static/style_default/images/ck_03.png" alt=""/>';
                            } else { echo '<img src="static/style_default/images/check_06.png" alt=""/>';}?>
                            <span>女士</span>
                        </a>
                        <input type="hidden" id="nei" name="nei" value="<?php echo $a_view_data['nei']?>">
                    </li>
                    <li class="editPhone">
                        <span>手机号</span>
                        <input type="text" id="edit_phone" placeholder="联系电话" name="mob" value="<?php echo $a_view_data['mob_phone']?>" />
                    </li>
                    <li class="editAddrLocation">
                        <span>收货地址</span>
                        <a>
                            <em onclick="address_choose()" id="address"><?php
                                echo $a_view_data['address']; ?></em>
                            <img src="static/style_default/images/shezhi_03.png" alt=""/>
                        </a>
                         <input type="hidden" name="address" id="addresss" value="<?php echo $a_view_data['address']?>">
                        <!-- 地址经纬度 -->
                        <input type="hidden" name="lon" id="lonn" value="<?php echo $a_view_data['longitude']?>">

                        <input type="hidden" name="latln" id="latln" value="<?php echo $a_view_data['now_lon'][0]; ?>">
                        <input type="hidden" name="lonln" id="lonln" value="<?php echo $a_view_data['now_lon'][1]; ?>">
                    </li>
                    <li class="editDoorNum">
                        <span>门牌号</span>
                        <input type="text" id="edit_doorNum" placeholder="例:1号楼1单元101室" name="house" value="<?php echo $a_view_data['house']?>"/>
                    </li>
                </ul>
                <input type="submit" class="addrsubmit" id="editAddrSub" value="保存"/>
            </form>
        </div>
    </div>
    <!-- 编辑收货地址  -->

    <div class="tips"></div>

</body>
</html>
<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>
<script>

var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

function address_choose() {
    if (isAndroid || isiOS) {
        var callbackSuccess = function(address){
            var addresss = eval('('+address+')');
            
            $('#address').text(addresss.title);
             $('#addresss').val(addresss.title);
            $('#addr').val(addresss.title);
            $('#lonn').val(addresss.latitude+','+addresss.longitude);
            //记录最新的经纬度
            $("#latln").val(addresss.latitude);
            $("#lonln").val(addresss.longitude);
        };
    }
    if (isAndroid) {
        var latln = $("#latln").val();
        var lonln = $("#lonln").val();
        var obj={"isAddressUseForHomePage":false,"latln":latln,"lonln":lonln};
        addressLocation(callbackSuccess, obj);
    } else if (isiOS) {
        var obj = {"isAddressUseForHomePage":false,"latln":latln,"lonln":latln};
        var json = JSON.stringify(obj);
        window.webkit.messageHandlers.vdao.postMessage({body: json, callback: callbackSuccess+'',command:'addressLocation'});
    };
}

//编辑地址表单post提交
$('.addrsubmit').click(function(){
    var _this = $(this);
    if ($("#edit_phone").val() == '') {
        alert("请输入手机号码!")
        return false;
    }
    if(!(/^1[3456789]\d{9}$/.test($("#edit_phone").val()))){ 
        alert("手机号码有误，请重填");  
        return false; 
    }       
    if (_this.data("sw")) {
      return false;
    }
    $(this).data("sw", true);

    $.post('address_update',$("#addressform").serialize(),function(res){
            alert(res.msg);
        if (res.status ==1) {
            window.location.reload();
        }
             _this.data("sw", false);
    },'json');
    return false;
});
</script>

