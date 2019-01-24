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
    <link rel="stylesheet" href="static/style_default/style/addAddress.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/addAddress.js"></script>
    <title>地址新增</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 新增收货地址  -->
    <div class="addAddress">
        <p class="pjoTitle">
            <a href="address?oldurl=<?php echo $_GET['oldurl'];?>"><img src="static/style_default/images/yongping_03.png" alt=""/></a>
            <span>新增收货地址</span>
        </p>

        <div class="addressForm">
            <form  id="addressform" method="post">
                <ul>
                    <li class="addContact">
                        <span>联系人</span>
                        <input type="text" id="add_contact" placeholder="联系人姓名" name="name" />
                    </li>
                    <li class="addSex">
                        <a class="man" value="1">
                            <img src="static/style_default/images/check_06.png" alt=""/>
                            <span>先生</span>
                        </a>
                        <a class="lady" value="2">
                            <img src="static/style_default/images/check_06.png" alt=""/>
                            <span>女士</span>
                        </a>
                        <input type="hidden" id="nei" name="nei">
                    </li>
                    <li class="addPhone">
                        <span>手机号</span>
                        <input type="text" id="add_phone" placeholder="联系电话" name="mob" />
                    </li>
                    <li class="addAddrLocation">
                        <span>收货地址</span>
                        <a>
                            <em onclick="address_choose()" id="address">点击定位</em>
                            <img src="static/style_default/images/shezhi_03.png" alt=""/>
                        </a>
                        <input type="hidden" id="addr" name="address" value="">
                        <!-- 地址经纬度 -->
                        <input type="hidden" id="lon" name="lon" value="">
                    </li>
                    <li class="addDoorNum">
                        <span>门牌号</span>
                        <input type="text" id="add_doorNum" placeholder="例:1号楼1单元101室" name="house" />
                    </li>
                </ul>
                <input type="submit" id="addAddrSub" class="addrsubmit" value="保存"/>
            </form>
        </div>
    </div>
    <!-- 新增收货地址  -->

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
            var address = eval('('+address+')');
            $('#address').text(address.title);
            $('#addr').val(address.title);
            $('#lon').val(address.latitude+','+address.longitude);
        };
    }
    if (isAndroid) {
        var obj={"isAddressUseForHomePage":false};
        addressLocation(callbackSuccess, obj);
    } else if (isiOS) {
        var obj = '{"isAddressUseForHomePage":false}';
        // obj = JSON.stringify(obj);
        window.webkit.messageHandlers.vdao.postMessage({body: obj, callback: callbackSuccess+'',command:'addressLocation'});
    };
}
//添加地址表单post提交
$('.addrsubmit').click(function(){
    var _this = $(this);
  
    if(!(/^1[3456789]\d{9}$/.test($("#add_phone").val())) || $("#add_phone").val() == ''){ 
        alert("手机号码有误，请重填");  
        return false; 
    }       
    if (_this.data("sw")) {
      return false;
    }
    $(this).data("sw", true);

    $.post('address_add',$("#addressform").serialize(),function(res){
            alert(res.msg);
        if (res.status ==1) {
            window.location.href ='address';
            return false;
        }
             _this.data("sw", false);
    },'json');
    return false;
});

</script>