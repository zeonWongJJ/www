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
    <link rel="stylesheet" href="static/style_default/style/webAddress.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/webAddress.js"></script>
    <title>新增收货地址</title>
</head>
<body>
<!-- 拉框 -->
        <?php echo $this->display('head'); ?>
    <!-- 了解使用 -->
    <div class="webAddress">
        <p class="pjoTitle">
            <a href="<?php echo $_GET['add'];?>?oldurl=<?php echo $_GET['oldurl'];?>"><img src="static/style_default/images/yongping_03.png" alt=""/></a>
            <span>新增收货地址</span>
        </p>

        <div class="addressForm">
            <form action="address_add?oldurl=<?php echo $_GET['oldurl'];?>" method="post">
                <ul class="addressContainer">
                    <li class="userName">
                        <span>联系人</span>
                        <input type="text" id="user_name" placeholder="请输入联系人" name="name" />
                    </li>
                    <li class="userSex" style="padding-left:2rem;">
                        <em class="man" value="1">
                            <img src="static/style_default/images/redbag_10.png" alt=""/>
                            <span>先生</span>
                        </em>
                        <em class="lady" value="2">
                            <img src="static/style_default/images/redbag_10.png" alt=""/>
                            <span>女士</span>
                        </em>
                        <input type="hidden" id="nei" name="nei">
                    </li>
                    <li class="userPhone">
                        <span>手机号</span>
                        <input type="text" id="user_phone" placeholder="请输入手机号" name="mob"/>
                    </li>
                    <li class="region">
                        <span>所在地区</span>
                        <a class="regionChoice">
                            <span class="region_mychoose">如有多家，任选一家即可</span>
                            <img src="static/style_default/images/shezhi_03.png" alt=""/>
                        </a>
                    </li>
                    <input type="hidden" name="join_province">
                    <input type="hidden" name="join_city">
                    <input type="hidden" name="join_district">
                    <input type="hidden" name="address" value="">
                    <input type="text" id="user_address" placeholder="详细地址"  name="house"/>

                </ul>
                <input type="submit" value="保存" id="addrSub"/>
            </form>
        </div>

    </div>
    <!-- 了解使用 -->

    <!-- 遮罩层 -->
    <div class="lay"></div>
    <!-- 遮罩层 -->

    <!-- 地区 -->
    <div class="regionContainer" style="height:300px;">
        <p><span>所在地区</span><img class="harea" src="static/style_default/images/y_03.png" /></p>
        <div class="regionBox">
            <a class="province" onclick="choose_province(2)">选择省</a>
            <a class="city">选择市</a>
            <a class="district">选择区</a>
        </div>
        <div class="choiceRegion">
            <ul class="provinceList"></ul>
            <ul class="cityList"></ul>
            <ul class="areaList"></ul>
        </div>
    </div>
    <!-- 地区 -->

</body>
</html>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=fc088640a32f5ccf91f1702022f88ac0&plugin=AMap.DistrictSearch"></script>
<script>
// 选择省份
function choose_province(code) {
    if (code == 2) {
        $("input[name='join_province']").val('');
        $("input[name='join_city']").val('');
        $("input[name='join_district']").val('');
        $('.province').html('选择省');
        $('.city').html('选择市');
        $('.district').html('选择区');
        $('.region_mychoose').html('请选择省市区');
    }
    AMap.service('AMap.DistrictSearch',function(){ //回调函数
        // 实例化DistrictSearch
        // 在对象初始化的时候设定
        var districtSearch = new AMap.DistrictSearch({
            level : 'country',
            subdistrict : 1
        });

        // 调用查询方法
        districtSearch.search('中国',function(status, result){
            // TODO : 按照自己需求处理查询结果
            var subDistricts = result.districtList[0].districtList;
            $('.provinceList').children('li').remove();
            for (var i = 0; i < subDistricts.length; i += 1) {
                var name = subDistricts[i].name;
                $('.provinceList').append('<li onclick="choose_city('+"'"+name+"'"+')">'+name+'</li>')
            }
        })
    })
}

// 选择城市
function choose_city(province) {
    $('.province').html(province);
    $("input[name='join_province']").val(province);
    $("input[name='join_city']").val('');
    $("input[name='join_district']").val('');
    $('.city').html('选择市');
    $('.district').html('选择区');
    $('.region_mychoose').html(province);
    $("input[name='address']").val(province);
    AMap.service('AMap.DistrictSearch',function(){//回调函数
        // 实例化DistrictSearch
        // 在对象初始化的时候设定
        var districtSearch = new AMap.DistrictSearch({
            level : 'province',
            subdistrict : 1
        });

        // 调用查询方法
        districtSearch.search(province,function(status, result){
            // TODO : 按照自己需求处理查询结果
            var subDistricts = result.districtList[0].districtList;
            $('.provinceList').children('li').remove();
            for (var i = 0; i < subDistricts.length; i += 1) {
                var name = subDistricts[i].name;
                $('.provinceList').append('<li onclick="choose_district('+"'"+name+"'"+')">'+name+'</li>')
            }
        })
    })
}

// 选择区
function choose_district(city) {
    $('.city').html(city);
    $("input[name='join_city']").val(city);
    $("input[name='join_district']").val('');
    $('.district').html('选择区');
    var province = $("input[name='join_province']").val();
    $('.region_mychoose').html(province+city);
    $("input[name='address']").val(province+city);
    AMap.service('AMap.DistrictSearch',function(){//回调函数
        // 实例化DistrictSearch
        // 在对象初始化的时候设定
        var districtSearch = new AMap.DistrictSearch({
            level : 'district',
            subdistrict : 1
        });

        // 调用查询方法
        districtSearch.search(city,function(status, result){
            // TODO : 按照自己需求处理查询结果
            var subDistricts = result.districtList[0].districtList;
            $('.provinceList').children('li').remove();
            for (var i = 0; i < subDistricts.length; i += 1) {
                var name = subDistricts[i].name;
                $('.provinceList').append('<li onclick="choose_biz_area('+"'"+name+"'"+')">'+name+'</li>')
            }
        })
    })
}

function choose_biz_area(district) {
    $('.district').html(district);
    $("input[name='join_district']").val(district);
    var province = $("input[name='join_province']").val();
    var city = $("input[name='join_city']").val();
    $('.region_mychoose').html(province+city+district);
    $("input[name='address']").val(province+city+district);
}

// 点击头部城市时
$('.city').live('click', function(event) {
    var join_province = $("input[name='join_province']").val();
    if (join_province == '') {
        choose_province(2);
    } else {
        choose_city(join_province);
    }
});

// 点击头部区时
$('.district').live('click', function(event) {
    var join_city = $("input[name='join_city']").val();
    if (join_city == '') {
        choose_province(2);
    } else {
        choose_district(join_city);
    }
});
</script>