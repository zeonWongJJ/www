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
    <link rel="stylesheet" href="static/style_default/style/joinApplication.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/joinApplication.js"></script>
    <script src="static/style_default/plugin/layer/layer.js"></script>
    <title>加盟申请</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 加盟申请表 -->
    <div class="joinApplication">
        <p class="pjoTitle">
            <a href="index"><img src="static/style_default/images/yongping_03.png" /></a>
            <span>加盟申请</span>
        </p>
        <div class="joinList">
            <form id="joinform" action="join_apply" method="post" onsubmit="return false;">
                <!-- 门店 -->
                <ul class="storeContainer">
                    <li class="storeName">
                        <span>门店名称</span>
                        <input type="text" id="join_storeName" name="join_storename" placeholder="选填"/>
                    </li>
                    <li class="storeNum">
                        <span>门店数量</span>
                        <input type="text" id="store_Num" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" name="join_storecount" placeholder="请输入门店数量"/>
                    </li>
                    <li class="region">
                        <span>所在地区</span>
                        <a class="regionChoice">
                            <span class="region_mychoose">如有多家，任选一家即可</span>
                            <img src="static/style_default/images/shezhi_03.png" />
                        </a>
                    </li>
                    <input type="hidden" name="join_province">
                    <input type="hidden" name="join_city">
                    <input type="hidden" name="join_district">
                    <input type="hidden" name="join_passenger">
                    <input type="hidden" name="join_size">
                    <input type="hidden" name="join_floor">
                    <li class="address">
                        <span>详细地址</span>
                        <input type="text" id="store_address" name="join_address" placeholder="例：1号楼1单元101室"/>
                    </li>
                    <li class="section" style="height:auto;">
                        <i class="flowCon">
                            <span>人流量</span>
                            <a class="flow" onclick="choose_rsf(1)">请选择</a>
                        </i>
                        <i class="areaCon">
                            <span>面积</span>
                            <a class="area" onclick="choose_rsf(2)">请选择</a>
                        </i>
                        <i class="floorCon">
                            <span>楼层</span>
                            <a class="floor" onclick="choose_rsf(3)">请选择</a>
                        </i>
                    </li>
                </ul>
                <!-- 门店 -->
                <!-- 营业执照 -->
                <ul class="licenseList">
                    <li class="license" onclick="open_iframe('njoin_upload-business_license')">
<!--                    <li class="license" onclick="window.location.href='njoin_upload-business_license'">-->
                        <span>营业执照</span>
                        <a>
                            <span id="children_return_text">请上传图片</span>
                            <img src="static/style_default/images/shezhi_03.png" />
                        </a>
                    </li>
                    <li class="regNum">
                        <span>注册号</span>
                        <input type="text" id="reg_num" name="join_regmark" placeholder="注册号或统一社会信用代码"/>
                    </li>
                    <li class="licenseName">
                        <span>执照名称</span>
                        <input type="text" id="licenseName" name="join_licname" placeholder="营业执照名称这一行的内容"/>
                    </li>
                    <li class="legalName">
                        <span>法人姓名</span>
                        <input type="text" id="legal_name" name="join_corporation" placeholder="营业执照上法人姓名"/>
                    </li>
                    <li class="legalName">
                        <span>有效期</span>
                        <div class="choiceBox">
                            <a class="longTime legCur">
                                <img src="static/style_default/images/redbag_06.png" />
                                <span>长期有效</span>
                            </a>
                            <a class="choiceTime" style="margin-left:0.37rem;">
                                <img src="static/style_default/images/redbag_10.png" />
                                <span>选择时间</span>
                            </a>
                            <p class="longText">无营业期限、无截止日期、结束日期为永久时选择此项</p>
                            <p class="choiceText"><a onclick="choose_expirydate()"><span>选择经营期限截止日期</span><img src="static/style_default/images/shezhi_03.png" /></a></p>
                        </div>
                    </li>
                    <input type="hidden" name="join_expirydate" value="9">
                </ul>
                <!-- 营业执照 -->
                <input type="hidden" name="join_licence">
                <input type="hidden" name="join_idcardpic">
                <input type="hidden" name="identity_positive_url">
                <input type="hidden" name="identity_native_url">
                <!-- 身份证 -->
                <ul class="IDcardCon">
                    <li class="IDcard" onclick="open_iframe('njoin_upload-id_card')"> <!-- onclick="choose_pic(2)">-->
                        <span>身份证</span>
                        <a class="IDcardPic">
                            <span>请上传图片</span>
                            <img src="static/style_default/images/shezhi_03.png" />
                        </a>
                    </li>
                    <li class="IDcardNum">
                        <span>身份证号</span>
                        <input type="text" name="join_idcard" id="id_card" placeholder="请输入经营者身份证号码"/>
                    </li>
                </ul>
                <!-- 身份证 -->
                <!-- 联系方式 -->
                <ul class="contactCon">
                    <li class="contacts">
                         <span>联系人</span>
                         <input type="text" id="contacts" name="join_linkman" placeholder="请输入姓名"/>
                    </li>
                    <li class="contactPhone">
                        <span>联系电话</span>
                        <input type="text" name="join_phone" id="contact_phone" placeholder="请输入手机号"/>
                    </li>
                    <li class="contactCode">
                        <span>验证码</span>
                        <input type="text" id="contact_code" name="user_code" placeholder="请输入验证码"/><input value="发送验证码" type="button" id="codeBtn" class=" removeBtn">
                    </li>
                </ul>
                <!-- 联系方式 -->
                <div class="subBtn">
                    <a class="saveDraft">保存草稿</a>
                    <input type="submit" value="提交信息" id="subJoin"/>
                </div>
            </form>
        </div>
    </div>
    <!-- 加盟申请表 -->

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

    <!-- 提示层 -->
    <div class="tips"></div>
</body>
</html>


<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>

<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=fc088640a32f5ccf91f1702022f88ac0&plugin=AMap.DistrictSearch"></script>

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

var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

// 人流量 面积 楼层
function choose_rsf(code) {
    if (isAndroid || isiOS) {
        var callbackSuccess = function(json) {
            var myjson = JSON.parse(json);
            $("input[name='join_passenger']").val(myjson.customer);
            $("input[name='join_size']").val(myjson.acreage);
            $("input[name='join_floor']").val(myjson.floor);
            $('.flowCon a').html(myjson.customer+'/天');
            $('.areaCon a').html(myjson.acreage+'m<sup>2</sup>');
            $('.floorCon a').html(myjson.floor);
        }
        // 人流量 1,面积 2,楼层 3
        var join_passenger = $("input[name='join_passenger']").val();
        var join_size      = $("input[name='join_size']").val();
        var join_floor     = $("input[name='join_floor']").val();
        var obj = {
            "clickType" : code,
            "customer"  : join_passenger,
            "acreage"   : join_size,
            "floor"     : join_floor
        }
    }
    if (isAndroid) {
        franchiseesCustomerAcreageFloor(callbackSuccess, obj);
    } else if (isiOS) {
        obj = JSON.stringify(obj);
        window.webkit.messageHandlers.vdao.postMessage({
            body: obj,
            callback: callbackSuccess+'',
            command:'franchiseesCustomerAcreageFloor'
        });
    }
}


// 营业执照有效期
function choose_expirydate() {
    if (isAndroid || isiOS) {
        var callbackSuccess = function(json) {
            var myjson = JSON.parse(json);
            $("input[name='join_expirydate']").val(myjson.timeStamp/1000);
            $(".choiceText span").html(myjson.timeFormat);
        }
    }
    if (isAndroid) {
        businessLicenceTermOfValidity(callbackSuccess);
    } else if (isiOS) {
        window.webkit.messageHandlers.vdao.postMessage({
            body: '',
            callback: callbackSuccess+'',
            command:'businessLicenceTermOfValidity'
        });
    }
}

function choose_pic(code) {
    if (isAndroid || isiOS) {
        var callbackSuccess = function(json){
            var myjson = JSON.parse(json);
            // ios
            if (isiOS) {
                code = myjson.uploadClickType;
            }
            if (code == 1) {
                if (myjson.business_license_url != '') {
                    $("input[name='join_licence']").val(myjson.business_license_url);
                    $(".license a span").html('已选择一张图片');
                } else {
                    $(".license a span").html('未选择任何图片');
                }
            } else {
                if (myjson.identity_positive_url != '') {
                    $("input[name='identity_positive_url']").val(myjson.identity_positive_url);
                    $("input[name='join_idcardpic']").val(myjson.identity_positive_url);
                    $(".IDcardPic span").html('已选择一张图片');
                }
                if (myjson.identity_native_url != '') {
                    $("input[name='identity_native_url']").val(myjson.identity_native_url);
                    $("input[name='join_idcardpic']").val(myjson.identity_native_url);
                    $(".IDcardPic span").html('已选择一张图片');
                }
                if (myjson.identity_positive_url != '' && myjson.identity_native_url != '') {
                    $("input[name='join_idcardpic']").val(myjson.identity_positive_url+','+myjson.identity_native_url);
                    $(".IDcardPic span").html('已选择二张图片');
                }
                if (myjson.identity_positive_url == '' && myjson.identity_native_url == '') {
                    $(".IDcardPic span").html('未选择任何图片');
                }
            }
        }
        //营业执照上传 1,身份证 2
        if (code == 1) {
            var business_license_url = $("input[name='join_licence']").val();
            if (business_license_url != '') {
                business_license_url = business_license_url;
            } else {
                business_license_url = "";
            }
            var obj = {"uploadClickType":code, "business_license_url": business_license_url}
        } else {
            var identity_positive_url = $("input[name='identity_positive_url']").val();
            var identity_native_url = $("input[name='identity_native_url']").val();
            var obj = {"uploadClickType":code, "identity_positive_url":identity_positive_url, 'identity_native_url':identity_native_url }
        }
    }
    if (isAndroid) {
        credentialsUpload(callbackSuccess, obj);
    } else if (isiOS) {
        obj = JSON.stringify(obj);
        window.webkit.messageHandlers.vdao.postMessage({
            body: obj,
            callback: callbackSuccess+'',
            command:'credentialsUpload'
        });
    }
}

function open_iframe(url) {
    if (layer) {
        var index = layer.open({
            type: 2,
            title: false,
            shade: [0],
            content: url,
            closeBtn: 0, //不显示关闭按钮
        });
        layer.full(index);
    } else {
        alert('未加载layer!');
    }
}
// 保存草稿
$('.saveDraft').click(function(event) {
    $("#joinform").attr('action','join_apply-1');
    $("#joinform").submit();
});

// 提交申请
$('#subJoin').click(function (e) {
    e.stopPropagation();
    // 附加保存的图片信息到文本框中
    var join_licence = localStorage.getItem('business_license');
    join_licence && $('input[name=join_licence]').val(join_licence);
    var id_card_back = localStorage.getItem('id_card_back');
    var id_card_positive = localStorage.getItem('id_card_positive');
    if (id_card_back && id_card_positive) {
        $('input[name=join_idcardpic]').val(id_card_positive + ',' + id_card_back);
    }
    $.ajax({
        url: 'join_apply',
        type: 'POST',
        data: $('#joinform').serialize(),
        dataType: 'JSON',
        success: function (rs) {
            if (rs.code == 200) {
                // 提价成功后清除保存的图片
                var storage_key = ['business_license', 'id_card_back', 'id_card_positive'];
                $.each(storage_key, function(i, e) {
                    localStorage.removeItem(e);
                });
                layer.msg('提交成功!');
            } else {
                layer.msg(rs.msg);
            }
        }
    })
})
</script>