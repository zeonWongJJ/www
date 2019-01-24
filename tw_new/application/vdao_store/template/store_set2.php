<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>门店设置</title>
		<link rel="stylesheet" href="static/style_default/style/common.css"/>
        <link rel="stylesheet" href="static/style_default/style/header.css"/>
        <link rel="stylesheet" href="static/style_default/style/storeSet.css"/>
        <link rel="stylesheet" href="static/style_default/head/cropper.min.css" />
        <link rel="stylesheet" href="static/style_default/head/sitelogo.css" />
        <link rel="stylesheet" type="text/css" href="http://www.jq22.com/jquery/bootstrap-3.3.4.css">
        <link rel="stylesheet" type="text/css" href="http://www.jq22.com/jquery/font-awesome.4.6.0.css">
        <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="static/style_default/plugin/upload_image.js"></script>
        <script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
        <script src="static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="static/style_default/script/storeSet.js" type="text/javascript" charset="utf-8"></script>
        <script src="http://www.jq22.com/jquery/bootstrap-3.3.4.js"></script>
        <script src="static/style_default/head/cropper.js"></script>
        <script src="static/style_default/head/sitelogo.js"></script>
        <style type="text/css">
			.avatar-btns button {
			    height: 35px;
			}
		</style>
	</head>
	<body>
		<!-- 头部 开始-->
        <?php echo $this->display('top'); ?>
        <!-- 头部结束 -->
        <div class="bottom clearfix">
        	<!-- 导航 开始-->
	        <?php echo $this->display('left'); ?>
	        <!-- 导航结束-->
	        <!--右边内容开始-->
	        <div class="rightSide">
	        	<!--面包屑导航开始-->
        		<div class="breadNav">
        			<a href="javascript:;">门店设置</a>
        			<!--<span>></span>
        			<a href="javascript:;">角色列表</a>-->
        		</div>
	        	<!--面包屑导航结束-->
	        	<!--右下半部分开始-->
	        	<div class="rightDown">
	        		<div class="rightNav">
	        			<ul>
	        				<li class="current"><a href="javascript:;">基本设置</a></li>
	        				<li><a href="javascript:;">提现账户</a></li>
	        			</ul>
	        		</div>
	        		<div class="wrapBox">
	        			 <!--基本设置开始-->
	        			 <div class="basicBox clearfix">
	        			 	<div class="bLeft">
	        			 		<form id="basesetform" action="store_set" method="post">
	        			 		<input type="hidden" id="record_id" name="store_id" value="<?php echo $a_view_data['store_id']; ?>">
	        			 		<ul>
	        			 			<li>
	        			 				<p class="smallTitle">门店名称</p>
	        			 				<p class="fill"><?php echo $a_view_data['store_name']; ?></p>
	        			 			</li>
	        			 			<li>
	        			 				<p class="smallTitle">门店地址</p>
	        			 				<p class="fill"><?php echo $a_view_data['store_address']; ?></p>
	        			 			</li>
	        			 			<li class="mapLi">
	        			 				<p class="smallTitle"><i class="xing"></i>门店定位</p>
	        			 				<div class="fillBox">
	        			 					<input type="text" class="int" name="store_position" value="<?php echo $a_view_data['store_position']; ?>" placeholder="点击右侧定位"/>
	        			 					<a href="javascript:;" class="position">点击重新定位</a>
	        			 					<div class="mapBox">
	        			 						<p class="tit">门店定位<a href="javascript:;" class="guan"></a></p>
	        			 						<div class="map" id="container"></div>
	        			 						<p class="guanbi"><a href="javascript:;">关闭</a></p>
	        			 					</div>
	        			 				</div>
	        			 				<div class="tipsBox">
	        			 					<span class="red"><i></i>请设置门店定位</span>
	        			 				</div>
	        			 			</li>
	        			 			<input type="hidden" name="store_areanum" value="<?php echo $a_view_data['store_areanum']; ?>">
	        			 			<input type="hidden" name="store_citycode" value="<?php echo $a_view_data['store_citycode']; ?>">
	        			 			<li class="sell">
	        			 				<p class="smallTitle"><i class="xing"></i>日销售上限</p>
	        			 				<div class="fillBox">
	        			 					<input type="text" class="int" name="store_output" placeholder="设置每日最高产量" value="<?php echo $a_view_data['store_output']; ?>"/>
	        			 				</div>
	        			 				<div class="tipsBox">
	        			 					<span class="red"><i></i>请输入日销售上限</span>
	        			 				</div>
	        			 			</li>
	        			 			<li class="makings">
	        			 				<p class="smallTitle"><i class="xing"></i>钱箱密码</p>
	        			 				<div class="fillBox">
	        			 					<input type="text" class="int" name="monybox_pwd" placeholder="不填表示不修改"/>
	        			 				</div>
	        			 				<div class="tipsBox">
	        			 					<span class="red"><i></i>请输入耗材预警值</span>
	        			 				</div>
	        			 			</li>
	        			 			<li class="order">
	        			 				<p class="smallTitle"><i class="xing"></i>一键抢单距离</p>
	        			 				<div class="fillBox">
	        			 					<input type="text" class="int" name="order_distance" placeholder="在一定距离内自动抢单" value="<?php echo $a_view_data['order_distance']; ?>"/>&nbsp;&nbsp;km
	        			 				</div>
	        			 				<div class="tipsBox">
	        			 					<span class="red"><i></i>请设置一键抢单距离</span>
	        			 				</div>
	        			 			</li>
	        			 			<li class="phone">
	        			 				<p class="smallTitle"><i class="xing"></i>联系电话</p>
	        			 				<div class="fillBox">
	        			 					<input type="text" class="int" name="store_contact" value="<?php echo $a_view_data['store_contact']; ?>" placeholder="请输入手机号码" />&nbsp;&nbsp;或&nbsp;
	        			 					<input type="text" class="int" name="store_tel" value="<?php echo $a_view_data['store_tel']; ?>" placeholder="固定电话" />
	        			 				</div>
	        			 				<div class="tipsBox">
	        			 					<span class="red"><i></i>请至少输入一个联系电话</span>
	        			 				</div>
	        			 			</li>
	        			 			<li class="traffic">
	        			 				<p class="smallTitle">交通路线</p>
	        			 				<div class="fillBox">
	        			 					<textarea class="txt" name="store_traffic" placeholder="请输入门店交通路线..."><?php echo $a_view_data['store_traffic']; ?></textarea>
	        			 					<p class="num"><span>0</span>/<span>200</span></p>
	        			 				</div>
	        			 				<div class="tipsBox">
	        			 					<span class="red"><i></i>请输入交通路线</span>
	        			 				</div>
	        			 			</li>
	        			 			<li class="traffic introduce">
	        			 				<p class="smallTitle">门店介绍</p>
	        			 				<div class="fillBox">
	        			 					<textarea class="txt" name="store_introduction" placeholder="请输入门店介绍"><?php echo $a_view_data['store_introduction']; ?></textarea>
	        			 					<p class="num"><span>0</span>/<span>200</span></p>
	        			 				</div>
	        			 			</li>
	        			 			<li class="pic clearfix">
	        			 				<p class="smallTitle"><i class="xing"></i>门店照片</p>
	        			 				<div class="fillBox">
	        			 					<!--图片上传开始-->
	        			 					<div class="upBox clearfix">

<div id="maxbox">
    <input type="file" name="mypic" id="mypic" multiple="multiple" onchange="upload_preview()" />
    <div id="picbox"></div>
</div>
<div id="choose_box" onclick="javascript:document.getElementById('mypic').click();">选择图片</div>
<div id="upload_box" onclick="upload_now()">上传图片</div>
<input type="hidden" name="mainpic_path" value="<?php echo $a_view_data['store_mainimg']; ?>">
<input type="hidden" name="otherpic_path" value="<?php echo $a_view_data['store_img']; ?>">

	        			 					</div>
	        			 					<!--图片上传结束-->
	        			 					<p class="wen">至少上传一张照片；支持jpg/png格式，单张（长 &lt;XXXm,宽 &lt;XXXm，高&lt;XXXm），最多支持10张图片，将按上传顺序展示图片，支持批量上传</p>
<!-- 	        			 					<div class="tipsBox">
		        			 					<span class="red"><i></i>请至少上传一张门店照片</span>
		        			 				</div> -->
	        			 				</div>
	        			 			</li>
	        			 		</ul>
	        			 		</form>
	        			 		<div class="saveBox">
	        			 			<a href="javascript:$('#basesetform').submit();">保存设置</a>
	        			 		</div>
	        			 	</div>
	        			 	<div class="bRight">
	        			 		<div class="headBox">
	        			 			<div class="leftImg">
	        			 				<img src="<?php echo $a_view_data['store_touxiang']; ?>" />
	        			 			</div>
	        			 			<div class="rightCha">
	        			 				<p class="wen2">消费者搜索您店铺的时候,将显示您设置的店铺头像</p>
	        			 				<!--<a href="javascript:;" class="setUp">点击重新设置</a>-->
	        			 				<button type="button" class="setUp"  data-toggle="modal" data-target="#avatar-modal" >
												点击重新设置
										</button>
										<div class="user_pic" style="margin: 10px;">
											<img src=""/>
										</div>
										<!--头像层开始-->
										<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<!--<form class="avatar-form" action="upload-logo.php" enctype="multipart/form-data" method="post">-->
													<form class="avatar-form">
														<div class="modal-header">
															<button class="close" data-dismiss="modal" type="button">&times;</button>
															<h4 class="modal-title" id="avatar-modal-label">更改头像</h4>
														</div>
														<div class="modal-body">
															<div class="avatar-body">
																<div class="avatar-upload">
																	<input class="avatar-src" name="avatar_src" type="hidden">
																	<input class="avatar-data" name="avatar_data" type="hidden">
																	<!--<label for="avatarInput" style="line-height: 35px;">图片上传</label>-->
																	<button class="btn btn-danger"  type="button" style="height: 35px;" onclick="$('input[id=avatarInput]').click();">请选择图片</button>
																	<span id="avatar-name"></span>
																	<input class="avatar-input hide" id="avatarInput" name="avatar_file" type="file"></div>
																<div class="row">
																	<div class="col-md-9">
																		<div class="avatar-wrapper"></div>
																	</div>
																	<div class="col-md-3">
																		<div class="avatar-preview preview-lg" id="imageHead"></div>
																		<!--<div class="avatar-preview preview-md"></div>
																        <div class="avatar-preview preview-sm"></div>-->
																	</div>
																</div>
																<div class="row avatar-btns">
																	<div class="col-md-4">
																		<div class="btn-group">
																			<button class="btn btn-danger fa fa-undo" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees"> 向左旋转</button>
																		</div>
																		<div class="btn-group">
																			<button class="btn  btn-danger fa fa-repeat" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees"> 向右旋转</button>
																		</div>
																	</div>
																	<div class="col-md-5" style="text-align: right;">
																		<button class="btn btn-danger fa fa-arrows" data-method="setDragMode" data-option="move" type="button" title="移动">
															            <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
															            </span>
															          </button>
															          <button type="button" class="btn btn-danger fa fa-search-plus" data-method="zoom" data-option="0.1" title="放大图片">
															            <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;zoom&quot;, 0.1)">
															              <!--<span class="fa fa-search-plus"></span>-->
															            </span>
															          </button>
															          <button type="button" class="btn btn-danger fa fa-search-minus" data-method="zoom" data-option="-0.1" title="缩小图片">
															            <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;zoom&quot;, -0.1)">
															              <!--<span class="fa fa-search-minus"></span>-->
															            </span>
															          </button>
															          <button type="button" class="btn btn-danger fa fa-refresh" data-method="reset" title="重置图片">
																            <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;reset&quot;)" aria-describedby="tooltip866214">
																       </button>
															        </div>
																	<div class="col-md-3">
																		<button class="btn btn-danger btn-block avatar-save fa fa-save" type="button" data-dismiss="modal"> 保存修改</button>
																	</div>
																</div>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
										<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
										<!--头像层结束-->
	        			 			</div>
	        			 		</div>
	        			 	</div>
	        			 </div>
	        			 <!--基本设置结束-->

	        			 <!--提现账户开始-->
	        			 <div class="accountBox">
	        			 	<form id="accountsetform" action="store_withdraw" method="post">
	        			 	<ul>
	        			 		<li>
	        			 			<span class="name">真实姓名</span>
	        			 			<input type="text" class="int" name="store_remittee" value="<?php echo $a_view_data['store_remittee']; ?>" placeholder="请输入真实姓名" />
	        			 			<span class="red"><i></i>请输入真实姓名</span>
	        			 		</li>
	        			 		<li>
	        			 			<span class="name">银行卡</span>
	        			 			<input type="text" class="int width170" name="store_bankcard" value="<?php echo $a_view_data['store_bankcard']; ?>" placeholder="请输入银行卡账号" />
	        			 			<span class="red"><i></i>请输入银行卡账号</span>
	        			 		</li>
	        			 		<li>
	        			 			<span class="name">开户行名称</span>
	        			 			<input type="text" name="open_bank" class="int width170" placeholder="请输入开户行名称" value="<?php echo $a_view_data['open_bank']; ?>" />
	        			 			<span class="red"><i></i>请输入开户行名称</span>
	        			 		</li>
	        			 		<li>
	        			 			<span class="name">开户行所在省</span>
	        			 			<input type="text" name="bank_prov" class="int width170" placeholder="请输入开户行所在省" value="<?php echo $a_view_data['bank_prov']; ?>" />
	        			 			<span class="red"><i></i>请输入开户行所在省</span>
	        			 		</li>
	        			 		<li>
	        			 			<span class="name">开户行所在地区</span>
	        			 			<input type="text" name="bank_city" class="int width170" placeholder="请输入开户行所在地区" value="<?php echo $a_view_data['bank_city']; ?>" />
	        			 			<span class="red"><i></i>请输入开户行所在地区</span>
	        			 		</li>
	        			 		<li>
	        			 			<span class="name">开户支行名称</span>
	        			 			<input type="text" name="sub_bank" class="int width170" placeholder="请输入开户支行名称" value="<?php echo $a_view_data['sub_bank']; ?>" />
	        			 			<span class="red"><i></i>请输入开户支行名称</span>
	        			 		</li>
	        			 		<li>
	        			 			<span class="name">支付宝</span>
	        			 			<input type="text" class="int width170" name="store_alipay" value="<?php echo $a_view_data['store_alipay']; ?>" placeholder="请输入支付宝账号" />
	        			 			<span class="red"><i></i>请输入支付宝账号</span>
	        			 		</li>
	        			 		<li>
	        			 			<span class="name">提现密码</span>
	        			 			<input type="text" class="int width170" name="store_password" placeholder="不填表示不修改"/>
	        			 		</li>
	        			 	</ul>
	        			 	</form>
	        			 	<div class="saveBox">
        			 			<a href="javascript:$('#accountsetform').submit();">保存设置</a>
        			 		</div>
	        			 </div>
	        			 <!--提现账户结束-->
	        		</div>
	        	</div>
	        	<!--右下半部分结束-->
	        </div>
	        <!--右边内容结束-->
	</body>
	<!--上传头像引用开始-->
	<script src="static/style_default/head/html2canvas.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		//做个下简易的验证  大小 格式
		$('#avatarInput').on('change', function(e) {
			var filemaxsize = 1024 * 5;//5M
			var target = $(e.target);
			var Size = target[0].files[0].size / 1024;
			if(Size > filemaxsize) {
				alert('图片过大，请重新选择!');
				$(".avatar-wrapper").childre().remove;
				return false;
			}
			if(!this.files[0].type.match(/image.*/)) {
				alert('请选择正确的图片!')
			} else {
				var filename = document.querySelector("#avatar-name");
				var texts = document.querySelector("#avatarInput").value;
				var teststr = texts; //你这里的路径写错了
				testend = teststr.match(/[^\\]+\.[^\(]+/i); //直接完整文件名的
				filename.innerHTML = testend;
			}

		});

		$(".avatar-save").on("click", function() {
			var img_lg = document.getElementById('imageHead');
			// 截图小的显示框内的内容
			html2canvas(img_lg, {
				allowTaint: true,
				taintTest: false,
				onrendered: function(canvas) {
					canvas.id = "mycanvas";
					//生成base64图片数据
					var dataUrl = canvas.toDataURL("image/jpeg");
					var newImg = document.createElement("img");
					newImg.src = dataUrl;
					imagesAjax(dataUrl)
				}
			});
		})

		function imagesAjax(src) {
			var data = {};
			data.img = src;
			data.jid = $('#jid').val();
			console.log(data);
			$.ajax({
				url: "store_touxiang",
				data: data,
				type: "POST",
				dataType: 'json',
				success: function(re) {
					console.log(re);
					if(re.code == 200) {
						$('.leftImg img').attr('src', src);
					}
				}
			});
		}
	</script>
	<!--上传头像引用结束-->
</html>

<script type="text/javascript">

var file_arr      = new Array(); // 用于保存文件信息
var mainpic_imgid = 0; // 主图的图片id 默认第一张图片为主图
var max_count     = 10; // 允许上传最大文件数
var max_size      = 1048576; // 单个文件允许上传的最大值 1024*1024=1M
var max_allsize   = 10485760; // 允许上传的文件总大小 10M
var upload_url    = 'image_upload'; // 上传的服务器地址
var delete_url    = 'storetem_delete'; // 删除服务上图片的地址
var input_name    = 'file'; // 后台接收时的表单name值
var module_name   = 'store'; // 服务器上存放图片的模块文件夹
var upload_accept = new Array('image/jpeg', 'image/png','image/gif'); // 允许上传的格式

</script>


<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=fc088640a32f5ccf91f1702022f88ac0&plugin=AMap.DistrictSearch"></script>
<script type="text/javascript">

// 门店之前的位置信息
var longitude = <?php echo $a_view_data['position_x']; ?>;
var latitude = <?php echo $a_view_data['position_y']; ?>;
// 判断是否设置了门店位置 如果设置了则显示 没有则默认显示当前城市
if (longitude == 9999 && latitude == 9999) {
    // 若center及level属性缺省，地图默认显示用户当前城市范围
    var map = new AMap.Map('container', {
        resizeEnable: true,
        zoom: 10,
    });
} else {
    // 创建地图
    var map = new AMap.Map('container',{
        resizeEnable: true,
        zoom: 17,
        center: [<?php echo $a_view_data['position_x'] . ',' . $a_view_data['position_y']; ?>]
    });
    // 给默认位置标记
    var marker = new AMap.Marker({
        position: [<?php echo $a_view_data['position_x'] . ',' . $a_view_data['position_y']; ?>],//marker所在的位置
        map:map//创建时直接赋予map属性
    });
}
// 加载插件
AMap.plugin(['AMap.ToolBar','AMap.AdvancedInfoWindow', 'AMap.OverView', 'AMap.Autocomplete', 'AMap.PlaceSearch'],function(){
    //创建并添加工具条控件
    var toolBar = new AMap.ToolBar();
    map.addControl(toolBar);
})
// 点击事件
var _onClick = function(e){
    // 如果之前设置了位置信息则移除标记 没有则移除提示
    if (longitude == 9999 && latitude == 9999) {

    } else {
        // 清除原来的标记
        map.remove(marker);
    }
    // 给点击的府标加上标记
    marker = new AMap.Marker({
        position : e.lnglat,
        map : map
    })
    // 点击的座标
    longitude = e.lnglat.getLng();
    latitude = e.lnglat.getLat();
    $("input[name='store_position']").val(longitude+','+latitude);

    AMap.service('AMap.Geocoder',function(){//回调函数
        //实例化Geocoder
        geocoder = new AMap.Geocoder({});
        //TODO: 使用geocoder 对象完成相关功能
        //逆地理编码
        var lnglatXY=[longitude, latitude];//地图上所标点的坐标
        geocoder.getAddress(lnglatXY, function(status, result) {
            if (status === 'complete' && result.info === 'OK') {
               //获得了有效的地址信息:
               //即，result.regeocode.formattedAddress
               // console.log(result.regeocode);
               $('#amc_clik').html(result.regeocode.formattedAddress);
               get_city_number(result.regeocode.addressComponent.province,result.regeocode.addressComponent.city);
               $("input[name='store_citycode']").val(result.regeocode.addressComponent.citycode);
            }else{
               //获取地址失败
               alert('获取失败');
            }
        });
    })
}

// 绑定事件，返回监听对象
var clickListener = AMap.event.addListener(map, "click", _onClick);
// 输入提示
var autoOptions = {
    input: "tipinput"
};
var auto = new AMap.Autocomplete(autoOptions);
var placeSearch = new AMap.PlaceSearch({
    map: map
});  //构造地点查询类
AMap.event.addListener(auto, "select", select);//注册监听，当选中某条记录时会触发
function select(e) {
    placeSearch.setCity(e.poi.adcode);
    placeSearch.search(e.poi.name);  //关键字查询查询
}

AMap.service('AMap.DistrictSearch',function(){//回调函数
    //实例化DistrictSearch
    districtSearch = new AMap.DistrictSearch();
    //TODO: 使用districtSearch对象调用行政区查询的功能
})
var districtSearch = new AMap.DistrictSearch({
    level : 'country',
    subdistrict : 1
});

function get_city_number(province, city) {
    districtSearch.search(province, function(status, result){
        var subDistricts = result.districtList[0].districtList;
        for(var i=0; i<subDistricts.length; i+=1){
                var name = subDistricts[i].name;
                var adcode = subDistricts[i].adcode;
                if (name == city) {
                    $("input[name='store_areanum']").val(adcode);
                }
        }
    })
}

</script>