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
    <link rel="stylesheet" href="static/style_default/style/credentials.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/credentials.js"></script>
    <title>资质申请修改</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 资质认证 -->
    <div class="credentials">
        <p class="pjoTitle">
            <a href="audit"><img src="static/style_default/images/yongping_03.png" alt=""/></a>
            <span>资质认证</span>
        </p>
        <div class="joinList">
            <form action="qualifi_up" method="post"  id="qualifi">
                <input type="hidden" name="id" value="<?php echo $a_view_data['qua_id']?>"/>
                <!-- 营业执照 -->
                <ul class="licenseList">
                    <li class="license" onclick="choose_pic(1,1)">
                        <span>营业执照</span>
                        <a>
                            <span><?php if(empty($a_view_data['business_imge'])){echo "请上传图片";} else {echo "已选择照片";}?></span>
                            <img src="static/style_default/images/shezhi_03.png" alt=""/>
                        </a>
                    </li>
                    <li class="regNum">
                        <span>注册号</span>
                        <input type="text" placeholder="注册号或统一社会信用代码" name="business_hao" value="<?php echo $a_view_data['business_hao']?>" />
                    </li>
                    <li class="licenseName">
                        <span>执照名称</span>
                        <input type="text" placeholder="营业执照名称这一行的内容" name="business_name" value="<?php echo $a_view_data['business_name']?>"/>
                    </li>
                    <li class="region">
                        <span>所在地区</span>
                        <a class="regionChoice">
                            <span class="region_mychoose"><?php echo $a_view_data['unit_province'].$a_view_data['unit_city'].$a_view_data['unit_district']?></span>
                            <img src="static/style_default/images/shezhi_03.png" alt=""/>
                        </a>
                    </li>
                    <input type="hidden" name="unit_province" value="<?php echo $a_view_data['unit_province']?>">
                    <input type="hidden" name="unit_city" value="<?php echo $a_view_data['unit_city']?>">
                    <input type="hidden" name="unit_district" value="<?php echo $a_view_data['unit_district']?>">
                    <li class="address">
                        <span>详细地址</span>
                        <input type="text" placeholder="例：1号楼1单元101室" name="unit_address" value="<?php echo $a_view_data['unit_address']?>"/>
                    </li>
                    <li class="legalName">
                        <span>法人姓名</span>
                        <input type="text" placeholder="请输入法人姓名" name="unit_legal_name" value="<?php echo $a_view_data['unit_legal_name']?>"/>
                    </li>
                    <li class="legalName">
                        <span>有效期</span>
                        <div class="legalChoiceBox">
                            <a class="legalLongTime <?php if ($a_view_data['business_imt'] == 9) {echo 'legCur';}?>">
                                <?php if ($a_view_data['business_imt'] == 9) {?>
                                    <img src="static/style_default/images/redbag_06.png" alt=""/>
                                <?php } else {?>
                                    <img src="static/style_default/images/redbag_10.png" alt=""/>
                                <?php }?>
                                <span>长期有效</span>
                            </a>
                            <a class="legalChoiceTime <?php if ($a_view_data['business_imt'] != 9) {echo 'legCur';}?>" style="margin-left:0.37rem;">
                                 <?php if ($a_view_data['business_imt'] != 9) {?>
                                    <img src="static/style_default/images/redbag_06.png" alt=""/>
                                <?php } else {?>
                                    <img src="static/style_default/images/redbag_10.png" alt=""/>
                                <?php }?>
                                <span>选择时间</span>
                            </a>
                            <p class="longText"><?php if ($a_view_data['business_imt'] == 9) {
                               echo "长期有效";
                            } else {echo date('Y年m月d日', $a_view_data['business_imt']);}?></p>
                            <p class="choiceText"><a onclick="choose_expirydate()"><span>选择经营期限截止日期</span><img src="static/style_default/images/shezhi_03.png" alt=""/></a></p>
                        </div>
                    </li>
                    <input type="hidden" name="business_imt" value="<?php echo $a_view_data['business_imt']?>">
                </ul>
                <!-- 营业执照 -->
                <!-- 申请人 -->
                <ul class="applicant">
                    <li class="apply">
                        <span>申请人</span>
                        <div class="applyChoiceBox">
                            <a class="applyLongTime <?php if ($a_view_data['applicant'] == 1) {echo 'legCur';}?>">
                                <?php if ($a_view_data['applicant'] == 1) {?>
                                    <img src="static/style_default/images/redbag_06.png" alt=""/>
                                <?php } else {?>
                                    <img src="static/style_default/images/redbag_10.png" alt=""/>
                                <?php }?>
                                <span>法人申请</span>
                            </a>
                            <a class="applyChoiceTime <?php if ($a_view_data['applicant'] == 2) {echo 'legCur';}?>" style="margin-left:0.37rem;">
                                <?php if ($a_view_data['applicant'] == 2) {?>
                                    <img src="static/style_default/images/redbag_06.png" alt=""/>
                                <?php } else {?>
                                    <img src="static/style_default/images/redbag_10.png" alt=""/>
                                <?php }?>
                                <span>非法人申请</span>
                            </a>
                        </div>
                        <input type="hidden" name="applicant" class="applicant" value="<?php echo $a_view_data['applicant']?>">
                    </li>
                    <li class="legalIDcard" onclick="choose_pic(2,2)">
                        <span>法人身份证</span>
                        <a class="legalIDcardPic">
                            <span><?php if (empty($a_view_data['unit_legal_imge'])) {echo "请上传法人身份证图片";} else {echo "已选择图片";}?></span>
                            <img src="static/style_default/images/shezhi_03.png" alt=""/>
                        </a>
                    </li>
                    <li class="legalIDcardNum">
                        <span>法人身份证号</span>
                        <input type="text" id="legal_id_card" placeholder="请输入法人身份证号码" name="unit_legal_number" value="<?php echo $a_view_data['unit_legal_number']?>"/>
                    </li>
                    <li class="applyName" <?php if ($a_view_data['applicant'] == 1) {echo 'style="display: none;"';}?>>
                        <span>申请人姓名</span>
                        <input type="text" placeholder="请输入申请人姓名" name="applicant_name" value="<?php echo $a_view_data['applicant_name']?>"/>
                    </li>
                    <li class="applyIDcard" onclick="choose_pic(3,2)" <?php if ($a_view_data['applicant'] == 1) {echo 'style="display: none;"';}?>>
                        <span>申请人身份证</span>
                        <a class="applyIDcardPic">
                            <span><?php if (empty($a_view_data['applicant_imge'])) {echo "请上传申请人身份证图片";} else {echo "已选择图片";}?></span>
                            <img src="static/style_default/images/shezhi_03.png" alt=""/>
                        </a>
                    </li>
                    <li class="applyIDcardNum" <?php if ($a_view_data['applicant'] == 1) {echo 'style="display: none;"';}?>>
                        <span>申请人身份证号</span>
                        <input type="text" id="apply_id_card" placeholder="请输入申请人身份证号码" name="applicant_number" value="<?php echo $a_view_data['applicant_number']?>"/>
                    </li>
                </ul>
                <!-- 申请人 -->
                <input type="hidden" name="business_imge" value="<?php echo $a_view_data['business_imge']?>">
                <input type="hidden" name="unit_legal_imge" value="<?php echo $a_view_data['unit_legal_imge']?>">
                <input type="hidden" name="identity_positive_url" value="<?php if ( ! empty($a_view_data['unit_legal_imge'])) {echo explode(',', $a_view_data['unit_legal_imge'])[0]; }?>">
                <input type="hidden" name="identity_native_url" value="<?php if ( ! empty($a_view_data['unit_legal_imge'])) { echo explode(",", $a_view_data['unit_legal_imge'])[1]; }?>">
                <input type="hidden" name="applicant_imge" value="<?php echo $a_view_data['applicant_imge']?>">
                <input type="hidden" name="applicant_imge_positive" value="<?php if ( ! empty($a_view_data['applicant_imge'])) {echo explode(",", $a_view_data['applicant_imge'])[0];}?>">
                <input type="hidden" name="applicant_imge_native" value="<?php if ( ! empty($a_view_data['applicant_imge'])) {echo explode(",", $a_view_data['applicant_imge'])[1];}?>">
                <!-- 联系方式 -->
                <ul class="contactCon">
                    <li class="contactPhone">
                        <span>联系电话</span>
                        <input type="text" id="contact_phone" placeholder="请输入手机号" name="phone" value="<?php echo $a_view_data['phone']?>"/>
                    </li>
                    <li class="contactCode">
                        <span>验证码</span>
                        <input type="text" id="contact_code" placeholder="请输入验证码" name="phone_code" /><input value="发送验证码" type="button" id="codeBtn" class=" removeBtn">
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
    <!-- 资质认证 -->

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
    <script type="text/javascript" src="http://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://qiduvdaolink.js"></script>
<?php } ?>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=fc088640a32f5ccf91f1702022f88ac0&plugin=AMap.DistrictSearch"></script>

<script>
var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

// 选择省份
function choose_province(code) {
    if (code == 2) {
        $("input[name='unit_province']").val('');
        $("input[name='unit_city']").val('');
        $("input[name='unit_district']").val('');
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
    $("input[name='unit_province']").val(province);
    $("input[name='unit_city']").val('');
    $("input[name='unit_district']").val('');
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
    $("input[name='unit_city']").val(city);
    $("input[name='unit_district']").val('');
    $('.district').html('选择区');
    var province = $("input[name='unit_province']").val();
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
    $("input[name='unit_district']").val(district);
    var province = $("input[name='unit_province']").val();
    var city = $("input[name='unit_city']").val();
    $('.region_mychoose').html(province+city+district);
}

// 点击头部城市时
$('.city').live('click', function(event) {
    var unit_province = $("input[name='unit_province']").val();
    if (unit_province == '') {
        choose_province(2);
    } else {
        choose_city(unit_province);
    }
});

// 点击头部区时
$('.district').live('click', function(event) {
    var unit_city = $("input[name='unit_city']").val();
    if (unit_city == '') {
        choose_province(2);
    } else {
        choose_district(unit_city);
    }
});

// 营业执照有效期
function choose_expirydate() {
    if (isAndroid || isiOS) {
        var callbackSuccess = function(json) {
            var myjson = JSON.parse(json);
            $("input[name='business_imt']").val(myjson.timeStamp/1000);
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
function choose_pic(type,code) {
    if (isAndroid || isiOS) {
        var callbackSuccess = function(json){
            var myjson = JSON.parse(json);
            if (type == 1 && code==1) {
                if (myjson.business_license_url != '') {
                    $("input[name='business_imge']").val(myjson.business_license_url);
                    $(".license a span").html('已选择一张图片');
                } else {
                    $(".license a span").html('未选择任何图片');
                }
            } else if(type == 2 && code==2) {
                if (myjson.identity_positive_url != '') {
                    $("input[name='identity_positive_url']").val(myjson.identity_positive_url);
                    $("input[name='unit_legal_imge']").val(myjson.identity_positive_url);
                    $(".legalIDcardPic span").html('已选择一张图片');
                }
                if (myjson.identity_native_url != '') {
                    $("input[name='identity_native_url']").val(myjson.identity_native_url);
                    $("input[name='unit_legal_imge']").val(myjson.identity_native_url);
                    $(".legalIDcardPic span").html('已选择一张图片');
                }
                if (myjson.identity_positive_url != '' && myjson.identity_native_url != '') {
                    $("input[name='unit_legal_imge']").val(myjson.identity_positive_url+','+myjson.identity_native_url);
                    $(".legalIDcardPic span").html('已选择二张图片');
                }
                if (myjson.identity_positive_url == '' && myjson.identity_native_url == '') {
                    $(".legalIDcardPic span").html('未选择任何图片');
                }
            } else if(type == 3 && code==2)  {
                if (myjson.identity_positive_url != '') {
                    $("input[name='applicant_imge_positive']").val(myjson.identity_positive_url);
                    $("input[name='applicant_imge']").val(myjson.identity_positive_url);
                    $(".applyIDcardPic span").html('已选择一张图片');
                }
                if (myjson.identity_native_url != '') {
                    $("input[name='applicant_imge_native']").val(myjson.identity_native_url);
                    $("input[name='applicant_imge']").val(myjson.identity_native_url);
                    $(".applyIDcardPic span").html('已选择一张图片');
                }
                if (myjson.identity_positive_url != '' && myjson.identity_native_url != '') {
                    $("input[name='applicant_imge']").val(myjson.identity_positive_url+','+myjson.identity_native_url);
                    $(".applyIDcardPic span").html('已选择二张图片');
                }
                if (myjson.identity_positive_url == '' && myjson.identity_native_url == '') {
                    $(".applyIDcardPic span").html('未选择任何图片');
                }
            }
        }
        //营业执照上传 1, 法人身份证 2， 申请人身份证3
        if (type == 1 && code==1) {
            var business_license_url = $("input[name='business_imge']").val();
            if (business_license_url != '') {
                business_license_url = business_license_url;
            } else {
                business_license_url = "";
            }
            var obj = {"uploadClickType":code, "business_license_url": business_license_url}
        } else if (type == 2 && code==2) {
            var identity_positive_url = $("input[name='identity_positive_url']").val();
            var identity_native_url = $("input[name='identity_native_url']").val();
            var obj = {"uploadClickType":code, "identity_positive_url":identity_positive_url, 'identity_native_url':identity_native_url }
        } else if(type == 3 && code==2) {
            var applicant_imge_positive = $("input[name='applicant_imge_positive']").val();
            var applicant_imge_native = $("input[name='applicant_imge_native']").val();
            var obj = {"uploadClickType":code, "identity_positive_url":applicant_imge_positive, 'identity_native_url':applicant_imge_native }
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

// 保存草稿
$('.saveDraft').click(function(event) {
    $("#qualifi").attr('action','qualifi_up-1');
    $("#qualifi").submit();
});
</script>