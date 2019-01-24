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
    <link rel="stylesheet" href="static/style_default/style/productShare.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/productShare.js"></script>
    <title>发布产品</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 订单列表 -->
    <div class="productShare">
        <p class="pjoTitle">
            <a href=""><img src="static/style_default/images/lefB.png" /></a>
            <span>糖果/巧克力</span>
        </p>
        <div class="productContainer">
            <form action="share_goods" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $this->router->get(1);?>">
                <!-- 上传图片 -->
                <div class="container">
                    <div class="z_photo">
                        <?php $i=1; foreach (explode(",", $a_view_data['pro_image']) as $imge) {?>
                            <div class="z_addImg" id="myimg_y<?php echo $i; ?>" <?php if ($imge == $a_view_data['pro_img']) { echo 'style="border:1px solid orange;"'; } ?>>
                                <a class="link">
                                <img onclick="set_mainpic('y<?php echo $i; ?>', '<?php echo $imge; ?>')" src="<?php echo $imge; ?>" />
                                <i><img src="static/style_default/images/y_03.png"></i>
                                </a>
                            </div>
                        <?php $i++; }; ?>

                    <!--    照片添加    -->
                        <div class="z_file">
                            <input type="file" style="color:transparent; opacity:0;" name="file[]" id="file" value="" accept="static/style_default/images/*" multiple onchange="imgChange('z_photo','z_file');" />
                        </div>
                    </div>
                </div>
                <!-- 上传图片 -->
                <input type="hidden" name="pro_img" value="<?php echo $a_view_data['pro_img']; ?>">
                <!-- 产品信息 -->
                <div class="productInfo">
                    <ul>
                        <li class="productName">
                            <span>产品名称</span>
                            <input type="text" id="product_name" value="<?php echo $a_view_data['product_name']?>" name="product_name" />
                        </li>
                        <li class="productPrice">
                            <span>单价</span>
                            <input type="text" id="product_price" value="<?php echo $a_view_data['price']?>" name="price" />
                        </li>
                        <li class="productLicence">
                            <span>许可证号</span>
                            <input type="text" id="product_licence" value="<?php echo $a_view_data['goods_license']?>" name="goods_license" />
                        </li>
                        <li class="productDescribe">
                            <span>产品描述</span>
                            <textarea name="pro_details" id="product_describe" cols="30" rows="10" value="<?php echo $a_view_data['pro_details']?>"><?php echo $a_view_data['pro_details']?></textarea>
                        </li>
                    </ul>
                </div>
                <!-- 产品信息 -->
                <!-- 产品地址 -->
                <div class="productAddr">
                    <ul>
                        <li class="deliver">
                            <span>发货地</span>
                            <a class="regionChoice">
                                <span class="region_mychoose"><?php echo $a_view_data['join_province'] . $a_view_data['join_city'] . $a_view_data['join_district']?></span>
                                <img src="static/style_default/images/shezhi_03.png" />
                            </a>
                        </li>
                        <input type="hidden" name="join_province" value="<?php echo $a_view_data['join_province']?>">
                        <input type="hidden" name="join_city" value="<?php echo $a_view_data['join_city']?>">
                        <input type="hidden" name="join_district" value="<?php echo $a_view_data['join_district']?>">
                        <li class="productAddress">
                            <span>详细地址</span>
                            <input type="text" id="product_address" value="<?php echo $a_view_data['addre']?>" name="addre" />
                        </li>
                        <li class="productDelive">
                            <span>配送费</span>
                            <input type="text" id="product_delive" value="<?php echo $a_view_data['distribution']?>" name="distribution" />
                        </li>
                    </ul>
                </div>
                <!-- 产品地址 -->
                <div class="sub">
                    <input type="submit" id="shareSub" value="确定发布"/>
                </div>
            </form>
        </div>
    </div>
    <!-- 订单列表 -->


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

    <!-- 遮罩层 -->
    <div class="lay"></div>
    <!-- 遮罩层 -->

    <!-- 提示 -->
    <div class="tips"></div>
    <!-- 提示 -->

    <!-- 提示 -->
    <div class="tipstwo">
        <p>提示</p>
        <span>你确定要将此图设为主图吗？</span>
        <div class="tipsBtn">
            <a class="sure">确定</a>
            <a class="cancel">取消</a>
        </div>
    </div>

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

// 设置主图
function set_mainpic(num, picname) {
    $('.lay').show();
    $('.tipstwo').show();
    $('.tipsBtn .sure').click(function(event) {
        $("input[name='pro_img']").val(picname);
        $('.z_addImg').css('border','1px solid #ddd');
        $('#myimg_'+num).css('border','1px solid orange');
        $('.lay').hide();
        $('.tipstwo').hide();
    });
    $('.tipsBtn .cancel').click(function(event) {
        $('.lay').hide();
        $('.tipstwo').hide();
    });
}


</script>