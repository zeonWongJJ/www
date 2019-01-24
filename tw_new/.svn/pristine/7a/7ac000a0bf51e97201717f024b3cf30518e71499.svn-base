<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <title>收货地址</title>
    <link rel="stylesheet" type="text/css" href="./static/style_default/style/common.css" />
    <link rel="stylesheet" href="https://cache.amap.com/lbs/static/main1119.css" />
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript" charset="utf-8"></script>
  
    <script src="./static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
</head>

<body ms-controller="test">

    <style type="text/css">
        .box {
            background: #fff;
            height: 100%;
            font-size: 0.14rem;
        }

        .head {
            background: #fff;
            height: 0.44rem;
            display: flex;
            justify-content: space-between;
        }

        .head div {
            line-height: .44rem;
            /*color: #FF6633;*/
        }

        .head div:nth-child(1) {
            flex: 0 0 0.7rem;
            padding: 0.02rem 0 0 .15rem;
            /*text-align: center;*/
        }

        .head div:nth-child(1) img {
            width: .3rem;
            /*height: .18rem;*/
        }

        .head div:nth-child(2) {
            flex: 1;
            text-align: center;

            font-size: .18rem;
        }

        .head div:nth-child(3) {
            flex: 0 0 0.7rem;
            font-size: .12rem;
            text-align: center;
            cursor: pointer;
        }

        .com_box {
            width: 100%;
            /*height: 100%;*/
            padding: 0 .15rem;
            background: #fff;
            border-top: 0.01rem solid #EEEEEE;
        }

        .ul_box {}

        .li_box {
        	position:relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 0.01rem solid #eee;
            padding-bottom: .15rem;
        }

        .li_box_r {
            flex: 0 0 .3rem;
            margin-top: 0.35rem;
            text-align: center;
            cursor: pointer;
        }

        .li_box_r img {
            width: .15rem;
            height: .15rem;
        }

        .div_box {
            flex: 1;
        }

        .tit {
            height: .45rem;
            line-height: .45rem;
            font-size: .18rem;
            font-weight: 700;
        }

        .add {
            font-size: .14rem;
        }

        .contact {
            margin: .05rem 0 0 0;
        }

        .contact span {
            color: #888;
        }
        /*	//超出定位*/

        .add_b {
            border-top: .1rem solid #EEEEEE;
            position: relative;
            z-index: 20;
        }

        .add_b_tit {
            height: .45rem;
            line-height: .45rem;
            padding: 0 .15rem;
            font-size: .18rem;
            border-bottom: 0.01rem solid #eee;
            font-weight: 700;
        }

        .po_btr {
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .05);
            z-index: 20;
        }

        .li_box_bey {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 0.01rem solid #eee;
            padding: 0 .15rem .15rem;
        }

        .li_box_r_bey {
            flex: 0 0 .3rem;
            margin-top: 0.35rem;
            text-align: center;
        }

        .li_box_r_bey img {
            width: .15rem;
            height: .15rem;
        }

        .div_box_bey {
            flex: 1;
        }

        .tit_bey {
            height: .45rem;
            line-height: .45rem;
            font-size: .18rem;
            font-weight: 700;
        }

        .add_bey {
            font-size: .14rem;
        }

        .contact_bey {
            margin: .05rem 0 0 0;
        }

        .contact_bey span {
            color: #888;
        }
        /*新加地址*/

        .added {
            display: none;
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 100;
            background: #fff;
        }

        .boxed {

            font-size: 0.14rem;
        }


        .boxed .head {
            background: #fff;
            height: 0.44rem;
            display: flex;
            justify-content: space-between;
        }

        .boxed .head div {
            line-height: .44rem;
        }

        .boxed .head div:nth-child(1),
        .boxed .head div:nth-child(3) {
            flex: 0 0 0.3rem;
            text-align: center;
        }

        .boxed .head div:nth-child(1) {
            font-size: .18rem;
            padding: 0.02rem 0 0 .15rem;
        }

        .boxed .head div:nth-child(1) img {
            width: .3rem;
        /*    height: .18rem;*/
        }

        .boxed .com_box {
            width: 100%;
            height: 100%;
            padding: 0 .15rem;
            background: #fff;
        }

        .boxed .contact {
            display: flex;
            margin-top: .1rem;
            border-bottom: .01rem solid #eee;
        }

        .boxed .contact>div:nth-child(1) {
            flex: 0 0 .87rem;
            font-size: .18rem;
            font-weight: 700;
            height: .55rem;
            line-height: .55rem;
        }

        .boxed .contact_2 {
            width: 100%;
        }

        .boxed .contact_2 div {
            width: 100%;
            font-size: 0.14rem;
            height: .55rem;
            line-height: .55rem;
        }

        .boxed .contact_2 div input {
            font-size: 0.14rem;
        }

        .boxed .contact_2 div:nth-child(1) {
            border-bottom: .01rem solid #eee;
        }

        .boxed .but_n,
        .boxed .but_m {
            width: .62rem;
            height: .3rem;
            font-size: 0.14rem;
            background: #fff;
            border: .01rem solid #eee;
            border-radius: 0.05rem;
            cursor: pointer;
        }

        .boxed .but_colco {
            border: .01rem solid #f63;
            color: #f63;
        }

        .boxed .ul_div {}

        .boxed .li_add {
            display: flex;
            height: 0.55rem;
            line-height: 0.55rem;
            border-bottom: .01rem solid #EEEEEE;
            align-items: center;
        }

        .boxed .li_add>div:nth-child(1) {
            flex: 0 0 .87rem;
            font-size: .18rem;
            font-weight: 700;
        }

        .boxed .li_add>div:nth-child(2) {
            flex: 1;
        }

        .boxed .li_add>div input {
            font-size: 0.14rem;
        }

        .boxed .li_add>div:nth-child(3) {
            flex: 0 0 .60rem;
            color: #f60;
            text-align: right;
        }

        .boxed .li_add>div:nth-child(3) img {
            width: .09rem;
            height: .18rem;
            margin-top: .2rem;
        }

        .boxed .but {
            padding: 0 .15rem;
            margin-top: .35rem;
        }

        .boxed .but button {
            height: .5rem;
            line-height: .5rem;
            width: 100%;
            border-radius: .5rem;
            background: #f63;
            color: #FFFFFF;
            font-size: .18rem;
            cursor: pointer;
        }
        /*编辑地址*/

        .adddel {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            display: none;
            z-index: 110;
            background: #fff;
        }

        .box_del {
            font-size: 0.14rem;
        }

        .box_del .head {
            background: #fff;
            height: 0.44rem;
            display: flex;
            justify-content: space-between;
        }

        .box_del .head div {
            line-height: .44rem;
        }

        .box_del .head div:nth-child(1),
        .box_del .head div:nth-child(3) {
            flex: 0 0 0.3rem;
            text-align: center;
        }

        .box_del .head div:nth-child(3) {
            padding: 0.02rem .15rem 0 0;
        }

        .box_del .head div:nth-child(1) {
            font-size: .18rem;
            padding: 0.02rem 0 0 .15rem;
        }

        .box_del .head div:nth-child(1) img {
            width: .3rem;
            /*height: .18rem;*/
        }

        .box_del .head div:nth-child(3) img {
            width: .14rem;
            height: .17rem;
        }

        .box_del .com_box {
            width: 100%;
            height: 100%;
            padding: 0 .15rem;
            background: #fff;
        }

        .box_del .contact {
            display: flex;
            margin-top: .1rem;
            border-bottom: .01rem solid #eee;
        }

        .box_del .contact>div:nth-child(1) {
            flex: 0 0 .87rem;
            font-size: .18rem;
            font-weight: 700;
            height: .55rem;
            line-height: .55rem;
        }

        .box_del .contact_2 {
            width: 100%;
        }

        .box_del .contact_2 div {
            width: 100%;
            font-size: 0.14rem;
            height: .55rem;
            line-height: .55rem;
        }

        .box_del .contact_2 div input {
            font-size: 0.14rem;
        }

        .box_del .contact_2 div:nth-child(1) {
            border-bottom: .01rem solid #eee;
        }

        .box_del .but_n,
        .box_del .but_m {
            width: .62rem;
            height: .3rem;
            font-size: 0.14rem;
            background: #fff;
            border: .01rem solid #eee;
            border-radius: 0.05rem;
            cursor: pointer;
            margin-right:0.1rem;
        }

        .box_del .but_colco {
            border: .01rem solid #f63;
            color: #f63;
        }

        .box_del .ul_div {}

        .box_del .li_add {
            display: flex;
            height: 0.55rem;
            line-height: 0.1rem;
            border-bottom: .01rem solid #EEEEEE;
            align-items: center;
            cursor: pointer;
        }

        .box_del .li_add>div:nth-child(1) {
            flex: 0 0 .87rem;
            font-size: .18rem;
            font-weight: 700;
        }

        .li_add>div:nth-child(2) {
            flex: 1;
        }

        .box_del .li_add>div input {
            font-size: 0.14rem;
        }

        .box_del .li_add>div:nth-child(3) {
            flex: 0 0 .60rem;
            color: #f60;
            text-align: right;
        }

        .box_del .li_add>div:nth-child(3) img {
            width: .09rem;
            height: .18rem;
            margin-top: .2rem;
        }

        .box_del .but {
            padding: 0 .15rem;
            margin-top: .35rem;
        }

        .box_del .but button {
            height: .5rem;
            line-height: .5rem;
            width: 100%;
            border-radius: .5rem;
            background: #f63;
            color: #FFFFFF;
            font-size: .18rem;
            cursor: pointer;
        }
        /*确定删除*/

        .dels_div {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .1);
            z-index: 200;
            display: none;
        }

        .dels_div_box {
            width: 2rem;
            height: 1.2rem;
            margin: 30% auto 0;
            background: #fff;
            border-radius: .1rem;
        }

        .dels_div_box p {
            height: .7rem;
            line-height: .7rem;
            font-size: .16rem;
            font-weight: 800;
            text-align: center;
        }

        .dels_div_but {
            font-size: .12rem;
            text-align: center;
        }

        .dels_div_but button {
            border: .01rem solid #f63;
            border-radius: .03rem;
            padding: .05rem .08rem;
            margin: 0 0.05rem;
            background: none;
        }
        /*地图*/

        #map_div {
            position: absolute;
            top: 0;
            display: none;
            z-index: 555;
            width: 100%;
            height: 100%;
            /*background: #fff;*/
        }

        #page {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0px;
            display: -webkit-flex;
            -webkit-flex-direction: column;
            overflow: auto;
						background-color: #fff;
						z-index: 666;
        }

     /*   .amap-touch-toolbar .amap-zoomcontrol {
            display: none;
        }*/
/*   #panel {
            position: fixed;
            background-color: #fff;
            max-height: 90%;
            overflow-y: auto;
            top: 350px;
            right: 0px;
            width: 100%;
            border-bottom: solid 1px silver;
					z-index: 666;
        }*/
        #panel {
            position: absolute;
            top: 350px;
            width: 100%;
						height: 100%;
						overflow: auto;
            z-index: 9999;
        }



        #showHideBtn:after,
        #showHideBtn:before {
            content: "";
            width: 0;
            height: 0;
            position: absolute;
            left: 0;
            right: 0;
            margin: auto;
            cursor: pointer;
        }

        #showHideBtn:before {
            width: 60px;
            height: 30px;
            background: rgba(255, 255, 255, 0.9);
            top: 0;
            border-radius: 30px 30px 0 0;
            border: 1px solid #ccc;
            border-bottom: 0;
        }

        #showHideBtn:after {
            content: "";
            top: 7px;
            border: 10px solid rgba(255, 0, 0, 0);
            z-index: 99999;
            border-top-color: #ccc;
            /* -webkit-transition: all 0.2s;*/
        }

        #poiList {
            -webkit-overflow-scrolling: touch;
            width: 100%;
            height: 100%;
            overflow: scroll;
            position: relative;
            background: #fff;
						z-index: 555;
        }

        #poiList .amap_lib_placeSearch {
            border: none;
        }

        #panel.hidden_map {
            position: absolute;
            max-height: 60%;
            width: 100%;
            top: 350px;
						z-index: 555;
        }

        #panel.hidden_map #showHideBtn {
            /*  top: -30px;*/
        }

        #panel.hidden_map #showHideBtn:after {
            /*  -webkit-transform: rotate(180deg);
								    -webkit-transform-origin: 50% 4px;*/
            top: -5px;
            border-bottom-color: #ccc;
            border-top-color: transparent;
        }

        #panel .amap_lib_placeSearch .pageLink {
            font-size: 120%;
            margin: 0 3px;
        }

        #searchBox {
            position: fixed;
            width: 80%;
            margin: 15px 0 0 15%;
            left: 0;
            right: 0;
            z-index: 999;
            top: 0px;
            height: 30px;
            display: flex;
						z-index: 555;
        }
        .searchBox_img{
	  position: absolute;
    left: -35px;
    top: 0;
		height: 30px;
    line-height: 30px;
    width: 24px;
		padding: 3px 0 0 0;
}
.searchBox_img  img{
	float: left;
	width:24px ;
}

        #tipinput {
            width: 100%;
            height: 30px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            line-height: 30px;
            padding: 0 7px;
            box-sizing: border-box;
        }

        #clearSearchBtn {
            position: absolute;
            right: 8px;
            top: 0;
            margin: auto;
            width: 20px;
            height: 20px;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
            font-size: 14px;
            color: #999;
						z-index: 555;
        }

        #clearSearchBtn .del {
            background: #eee;
            border-radius: 12px;
            width: 20px;
            height: 20px;
        }

        #page.searching #clearSearchBtn {
            display: none;
        }

        #loader {
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: 1;
            margin: -75px 0 0 -75px;
            border: 16px solid #eee;
            border-radius: 50%;
            border-top: 16px solid #0b83ea;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            display: none;
						z-index: 555;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .searching #loader {
            display: block;
        }

        .searching #page {
            filter: grayscale(1);
            opacity: 0.5;
        }

        #panel.empty #showHideBtn {
            opacity: 0.5;
        }

        #emptyTip {
            display: none;
        }

        #panel.empty #emptyTip {
            display: block;
            position: relative;
            background: #fff;
            width: 100%;
            text-align: center;
            padding: 30px 0;
            color: #666;
			z-index: 555;
        }
        .amap_lib_placeSearch_page{
            display: none;
        }

        .poi-more {
            display: none!important;
        }
		.add_in_x , .add_in{
			overflow: hidden;
			white-space: nowrap;
			text-overflow: ellipsis;
		}
		.setAddr{
			position: absolute;
			top:0.12rem;
			right:0;
			cursor: pointer;
		}
		.momoAddr{
			color:#ff6633;
		}
    </style>
    <!--地图定位-->
    <div id="map_div">
			<div>
				
			
        <div id="page">
            <div id="container" class="map" tabindex="0" style="width: 100%;height: 350px;"></div>
            <!-- 搜索框-->
            <div id="searchBox">
            <div style="cursor: pointer;" class="searchBox_img"><img src="./static/style_default/images/back_round.png" ></div>
                <input id="tipinput" type="input" placeholder="请输入关键字搜索" />
                <div id="clearSearchBtn">
                    <div class="del">&#10005;</div>
                </div>
            </div>
            <!-- 结果面板 -->
            <div id="panel" class="hidden_map">
                <!-- 隐藏按钮 -->
                <a id="showHideBtn"></a>
                <div id="emptyTip">没有内容！</div>
                <!--搜索结果列表 -->
                <div id="poiList">
                </div>
            </div>

            <!-- loading -->
            <div id="loader"></div>
        </div>
    </div>
</div>
    </div>


    <!--确定删除？-->
    <div class="dels_div">
        <div class="dels_div_box">
            <p>确定要删除该地址？</p>
            <div class="dels_div_but">
                <button class="dels_but_shan" data-desid="0">确定</button>
                <button class="dels_but_quxiao">取消</button>
            </div>
        </div>
    </div>
    <!--编辑地址-->
    <div class="adddel editinput">
        <div class="box_del">
            <div class="head">
                <div style="flex:0 0 0.4rem;cursor: pointer;" class="but_del" style="flex:0 0 0.5rem">
                    <img  src="./static/style_default/images/yongping_03.png">
                </div>
                <div>编辑地址</div>
                <div>
                    <span class="dels">
                        <img src="./static/style_default/images/addr_07.png">
                    </span>
                </div>
            </div>
            <!--联系人-->
            <div class="com_box ">
                <form name="input" action="" id="edit_form" method="post">
                <div class="f_edit_show">
                    <div class="contact">
                        <div>联系人</div>
                        <div class="contact_2">
                            <div>
                                <input type="text" name="" id="name_in" placeholder="姓名" />
                            </div>
                            <div class="contact_2_but">
                                <button class="but_n b1" data-sex="1" type="button">先生</button>
                                <button class="but_m b2" data-sex="2" type="button">女生</button>
                                <input id="edit_sex" type="hidden" name="sex" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="ul_div">
                        <ul >
                            <li class="li_add">
                                <div>电话</div>
                                <div>
                                    <input type="text" name="" id="mobile_in" placeholder="手机号码" />
                                </div>
                                <div>+通讯录</div>
                            </li>
                            <li class="li_add">
                                <div>地址</div>
                                <div>
                                    <input type="text" id="edit_in" class="add_in" placeholder="定位" />
                                </div>
                                <input type="hidden" id="edit_locat" name="location" value="" >
                                <div class="edit_map_click">
                                    <img src="./static/style_default/images/more_gray.png">
                                </div>
                            </li>
                            <li class="li_add">
                                <div>门牌号</div>
                                <div>
                                    <input type="text" name="" id="edit_door" placeholder="16栋6号" />
                                </div>
                            </li>
                        </ul>
                    </div>
                 </div>
                </form>

            </div>
            <div class="but">
                <button type="button" id="but" class="edit_button">保存并使用</button>
            </div>
        </div>

    </div>
    <!--新加地址-->
    <div class="added addinput">
        <div class="boxed">
            <div class="head">
                <div class="but_ed" style="cursor: pointer; flex:0 0 0.4rem">
                    <img style="height:auto;" src="./static/style_default/images/yongping_03.png">
                </div>
                <div>新增地址</div>
                <div></div>
            </div>
            <!--联系人-->
            <div class="com_box">
            <form  action="" id="add_form" method="post">
                <div class="contact">
                    <div>联系人</div>
                    <div class="contact_2">
                        <div>
                            <input type="text" name="user_name" id="name_in" placeholder="姓名" />
                        </div>
                        <div class="contact_2_but add_butss" >
                            <button class="but_n b1" data-sex="1" type="button">先生</button>
                            <button class="but_m b2" data-sex="2" type="button">女士</button>
                            <input id="add_sex" type="hidden" name="nei" value="0">
                        </div>
                    </div>
                </div>
                <div class="ul_div">
                    <ul>
                        <li class="li_add">
                            <div>电话</div>
                            <div>
                                <input type="text" name="mob_phone" id="mobile_in" placeholder="手机号码" />
                            </div>
                            <div>+通讯录</div>
                        </li>
                        <li class="li_add">
                            <div>地址</div>
                            <div class="map_click">
                                <input type="text" name="address" id="add_in" class="add_in_x" placeholder="定位" />
                            </div>
                            <div class="map_click">
                                <img src="./static/style_default/images/more_gray.png">
                            </div>
                            <input type="hidden" id="add_locat" name="location" >
                           <input type="hidden" value="4" name="type" >
                        </li>
                        <li class="li_add">
                            <div>门牌号</div>
                            <div>
                                <input type="text" name="house" id="add_door" placeholder="16栋6号" />
                            </div>
                        </li>
                    </ul>
                </div>
                </form>
            </div>
            <div class="but">
                <button type="button" id="but" class="add_button">保存并使用</button>
            </div>
        </div>
    </div>
    <!--头-->
      <input type="hidden" id="addr_status" value="add" >
    <div class="box">
        <div class="head">
            <div>
                <a href="javascript:history.go(-1)">
                    <img src="./static/style_default/images/yongping_03.png">
                </a>
            </div>
            <div>收货地址</div>

            <div id="added">新增地址</div>
        </div>
        <div class="com_box">
            <ul class="ul_box">
                <!--正常配送范围-->
            </ul>
        </div>
        <div class="add_b">
            <div class="add_b_tit">
                以下地址超出配送范围
            </div>
            <div class="po_btr"></div>
            <ul class="ul_box_bey">
                <!--超过配送范围-->
            </ul>
        </div>
    </div>
  
  <script type="text/javascript">
$(function(){
    $.post("naddress_list",{type:1,store_id:<?php echo !empty($this->router->get(1))?$this->router->get(1):0;?>},function(res){
        if(res.code == 200) {
				var arr =res.data;
		        var html = '';
		        var html_set = '';
		        for (var i = 0; i < arr.length; i++) {
		            if (arr[i].set == 1) {
		                html +=
		                    `<li class="li_box list_show_${arr[i].address_id}">
							<div class="div_box">
								<div class='tit'>${arr[i].address}</div>
								<div class="add">
									${arr[i].house}
								</div>
								<div class="contact">
									<span>${arr[i].user_name}</span>
									<span>${arr[i].mob_phone}</span>
								</div>
							</div> `;
                            if(arr[i].is_default ==1){
                    html+=`<div class="setAddr momoAddr"  onclick="setAddr(event,$(this))" data-aid="${arr[i].address_id}">默认地址</div> `;
                            }else{
                     html+= `<div class="setAddr"  onclick="setAddr(event,$(this))" data-aid="${arr[i].address_id}">设为默认地址</div> ` ;
                            }
							 
							 html+=`<div class="li_box_r ">
								<span id="edit_del" class="edit_del" data-addrid="${arr[i].address_id}">
									<img src="./static/style_default/images/addr_10.png">
								</span>
							</div>
						</li>`;
		            } else {
		                html_set +=
		                    `<li class="li_box_bey">
		                    <div class="div_box_bey">
		                        <div class="tit_bey">${arr[i].address}</div>
		                        <div class="add_bey">
		                           ${arr[i].house}
		                        </div>
		                        <div class="contact_bey" >
		                            <span>${arr[i].user_name}</span>
		                            <span>${arr[i].mob_phone}</span>
		                        </div>
		                    </div>
		             
		                </li>`;
		            }
		        }
		        $(".ul_box").append(html);
		        $(".ul_box_bey").append(html_set);        	
        }	
    	
      },"json");
$(".ul_box>li").each(function (i) {
    $(this).addClass("list_" + i);
});

})

//弹出编辑地址
var dels = '';
$(document).on('click',".li_box",function() {
	dels = $(this);
    $(".adddel").show();
    var addr_id = $(this).find(".li_box_r >span").data("addrid");
    $(".dels_but_shan").data("desid",addr_id);
    $.post('naddress_list',{type:2, addr_id:addr_id},function(res){
    if(res.code =="200" ) {
    	var data =res.data;
    	$(".f_edit_show").empty();
    	html = '';
    	html='<div class="contact">'+
            '<div>联系人</div>'+
            '<div class="contact_2"><div>'+
				'<input type="text" name="user_name" value="'+data.user_name+'" id="name_in" placeholder="姓名" />'+
              '</div>'+
                '<div class="contact_2_but edit_input">'+
                '<button class="but_n b1 "  data-sex="1" type="button">先生</button>'+
                '<button class="but_m b2"  data-sex="2" type="button">女生</button>'+
                '<input id="edit_sex" type="hidden" name="nei" value="'+data.nei+'">'+
                '</div>'+
            '</div>'+
        '</div>'+
       ' <div class="ul_div">'+
	   '<ul><li class="li_add">'+
            '<div>电话</div><div>'+
			'<input type="text" name="mob_phone" value="'+data.mob_phone+'" id="mobile_in" placeholder="手机号码" />'+
                    '</div>'+
                    '<div>+通讯录</div>'+
                '</li>'+
                '<li class="li_add">'+
                    '<div>地址</div>'+
                    '<div >'+
       '<input type="text" name="address" value="'+data.address+'" id="edit_in" class="add_in" placeholder="定位" />'+
                    '</div>'+
                    '<input type="hidden" id="edit_locat"  name="location" value="'+data.longitude+'" >'+
                    '<input type="hidden"   name="type" value="3" >'+
                    '<input type="hidden"   name="address_id" value="'+data.address_id+'" >'+
                    '<input type="hidden"   name="user_id" value="'+data.user_id+'" >'+
                    '<div class="edit_map_click">'+
                    '<img src="./static/style_default/images/more_gray.png">'+
                    '</div>'+
                '</li>'+
                '<li class="li_add">'+
                    '<div>门牌号</div>'+
                    '<div>'+
                        '<input type="text" name="house" value="'+data.house+'" name="" id="edit_door" placeholder="16栋6号" />'+
                    '</div>'+
                '</li></ul> </div>';
      $(".f_edit_show").append(html); 
      if(data.nei ==1){
      	$(".edit_input .b1").addClass('but_colco');
      	$(".edit_input .b2").removeClass("but_colco");
      }else if(data.nei ==2){
      	$(".edit_input .b2").addClass('but_colco');
      	$(".edit_input .b1").removeClass("but_colco");
      }
    }

    },"json");
      
});
//设置默认地址

function setAddr(e,$this){
    var id=$this.data("aid");
    e.stopPropagation();
    $.post("upaddress",{id:id},function(res){
        if(res.code ==200){
           $this.addClass("momoAddr");
            $this.html("默认地址");
             $(".setAddr").not($this).removeClass("momoAddr").html("设为默认地址"); 
        }

    },"json");
	
}
 
//弹出新加地址
$("#added").click(function () {
    $(".added").show();
});
//隐藏编辑地址
$(document).on("click",".but_del",function(){
	$(".adddel").hide();
});
$(document).on("click",".dels",function () {
    $(".dels_div").show();
});
//删除
$(document).on('click',"button.dels_but_shan",function () {
	var desid = ($(this).data("desid"));
		$.post("naddress_list",{type:5,address_id:desid},function(rees){
		if(rees.code ==200) {
	 	$(".dels_div").hide();
    	$(".adddel").hide();
    	$(".list_show_" + desid).remove();			
		}else {
			alert(rees.msg);
			return false;
		}

	},"json");	
   
});
$(document).on("click","button.dels_but_quxiao",function () {
    $(".dels_div").hide()
});

//隐藏新加地址
$(document).on("click",".but_ed",function () {
    $(".added").hide();
});
//隐藏新加地址
$(document).on("click",".add_button",function () {
	if($("#add_locat").val() =="" || $("#add_locat").val()==0 ){
		alert("请选择地址!");
		return false;
	}
		$.post("naddress_list",$("#add_form").serialize(),function(rees){
		if(rees.code ==200) {
			$('#add_form')[0].reset();
			 $(".added").hide();
			 $("#add_sex").val(0);
			 $("#add_locat").val(0);
			 $(".add_butss>button").removeClass("but_colco");  
			 var arr = rees.data;
 			 htmls =`<li class="li_box list_show_${arr.address_id}">
							<div class="div_box">
								<div class='tit'>${arr.address}</div>
								<div class="add">
									${arr.house}
								</div>
								<div class="contact">
									<span>${arr.user_name}</span>
									<span>${arr.mob_phone}</span>
								</div>
							</div>
							<div class="li_box_r ">
								<span id="edit_del" class="edit_del" data-addrid="${arr.address_id}">
									<img src="./static/style_default/images/addr_10.png">
								</span>
							</div>
						</li>`;	
					 $(".ul_box").prepend(htmls);			
		}else {
			alert(rees.msg);
			return false;
		}

	},"json");
    
});
//隐藏编辑地址
$(document).on("click",".edit_button",function () {
	$.post("naddress_list",$("#edit_form").serialize(),function(rees){
		if(rees.code ==200) {
			window.location.reload();
			$(".adddel").hide();
		}else {
			alert(rees.msg);
			return false;
		}

	},"json");
    
});
//地图
$(document).on("click",".map_click",function () {
    $("#map_div").show();
    $("#addr_status").val("add")
});
 $(document).on('click',".edit_map_click",function () {
    $("#map_div").show();
    $("#addr_status").val("edit")
});            

$(document).on('click','#showHideBtn',function () {
    $('#panel').toggleClass('hidden_map');
});
$(document).on("click",'#clearSearchBtn',function () {
    //清除搜索框内容
    $('#tipinput').val('');
    //清除结果列表
    placeSearch.clear();
    $('#panel').addClass('hidden_map');
    checkPoiList();
});			
//选择男女
$(document).on('click',".edit_input>button",function(){
		$(this).addClass("but_colco");
        var sex = $(this).data("sex");
        $("#edit_sex").val(sex);
		$(".edit_input>button").not($(this)).removeClass("but_colco");
});
//选择男女
$(document).on('click',".addinput .contact_2_but>button",function(){
        $(this).addClass("but_colco");
         var sex = ($(this).data("sex"));
         $("#add_sex").val(sex);
        $(".contact_2_but>button").not($(this)).removeClass("but_colco");
}); 
$(document).on("click",".searchBox_img",function(){
 $("#map_div").hide();
});
</script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.6&key=7cdc3618b78ac72f5d4d516263f3f56f"></script>
    <script type="text/javascript" src="https://cache.amap.com/lbs/static/addToolbar.js"></script>
    <script type='text/javascript' src='https://g.alicdn.com/sj/lib/zepto/zepto.min.js'></script>
<script type="text/javascript">

        //地图
        var map = new AMap.Map("container", {
            zoom: 13, //设置地图显示的缩放级别
            // center: [116.397428, 39.90923]， //设置地图中心点坐标
            // layers: [new AMap.TileLayer.Satellite()], //设置图层,可设置成包含一个或多个图层的数组
            // mapStyle: 'amap://styles/whitesmoke', //设置地图的显示样式
            viewMode: '2D', //设置地图模式
            lang: 'zh_cn', //设置地图语言类型
        });

        //加载地图，调用浏览器定位服务
        map.plugin('AMap.Geolocation', function () {
            geolocation = new AMap.Geolocation({
                enableHighAccuracy: true, //是否使用高精度定位，默认:true
                resizeEnable: true,
                timeout: 10000, //超过10秒后停止定位，默认：无穷大
                maximumAge: 0,
                showButton: true,
                buttonPosition: 'LB',
                showMarker: true,
                showCircle: true,
                panToLocation: true, //定位成功后将定位到的位置作为地图中心点，默认：true
                zoomToAccuracy: true
            });
            map.addControl(geolocation);
            geolocation.getCurrentPosition();
            AMap.event.addListener(geolocation, 'complete', onComplete); //返回定位信息
            AMap.event.addListener(geolocation, 'error', onError); //返回定位出错信息
        });

        function onComplete(obj) {
            AMap.service(["AMap.PlaceSearch", "AMap.Autocomplete"], function () {
                try {
                    readys(obj)
                } catch (e) {
                    console.error(e);
                }
            });
            AMap.service(["AMap.PlaceSearch"], function () {
                var placeSearch = new AMap.PlaceSearch({ //构造地点查询类
                    pageSize: 5,
                    type: '',
                    pageIndex: 1,
                    //city: "020", //城市
                    map: map,
                    panel: "panel"
                });
                var cpoint = obj.position; //中心点坐标
               
                // var editlocat = $("#edit_locat").val();
                // console.log(editlocat);
                // if(editlocat){
                //     var arr = editlocat.split(",");
                //     var editlngs =parseFloat(arr[0]);
                //     var editlats =parseFloat(arr[1]);
                //     var cpoints ={P:editlats,O:editlngs,lng:editlngs,lat:editlats};
                // }

                placeSearch.searchNearBy('',cpoint , 200, function (status, result) {});
                AMap.event.addListener(placeSearch, 'selectChanged', function (results) {
                    //获取当前选中的结果数据
                var location_inner = (results.selected.data.location.lat +","+results.selected.data.location.lng);
				var add_dx  = results.selected.data.name;
				var a_addr  = results.selected.data.address;
                var edit_type =$("#addr_status").val();
				if(edit_type =="add"){
                    $("#map_div").hide();
					$("#add_in").val(add_dx);
					 $("#add_door").val(a_addr);
                    // $("#add_dx").val(add_dx);
                    $("#add_locat").val(location_inner)	;
                }else {
                    $("#map_div").hide();
                    $("#edit_in").val(add_dx);
                    // $("#edit_dx").val(add_dx);
                    $("#edit_door").val(a_addr);
                    $("#edit_locat").val(location_inner) ;
                }
	
                });
            });
        }

        function onError(obj) {
            
        }

     function readys(obj) {
            //搜索框支持自动完成提示
            var auto = new AMap.Autocomplete({
                input: "tipinput"
            });
            //构造地点查询类
            var placeSearch = new AMap.PlaceSearch({
                pageSize: 5,
                pageIndex: 1,
                map: map,
                panel: "panel"
            });
            //监听搜索框的提示选中事件
            AMap.event.addListener(auto, "select", function (e) {
                //设置搜索的城市
                placeSearch.setCity(e.poi.adcode);
                //开始搜索对应的poi名称
                placeSearch.search(e.poi.name, function (status, results) {
                    if (results.pois && results.pois.length > 0) {
                        $('#panel').toggleClass('empty');
                    }
                    //显示结果列表
                    $('#panel').removeClass('hidden_map');
                    //隐藏loading状态
                    $(document.body).removeClass('searching');
                });
                //显示loading状态
                $(document.body).addClass('searching');
            });
            //检查结果列表是否为空， 为空时显示必要的提示，即#emptyTip
            function checkPoiList() {
                $('#panel').toggleClass('empty', !($.trim($('#poiList').html())));
            }
            checkPoiList();
            //监听搜索列表的渲染完成事件
            AMap.event.addListener(placeSearch, 'renderComplete', function () {
                checkPoiList();
            });
            //监听marker/列表的选中事件
            AMap.event.addListener(placeSearch, 'selectChanged', function (results) {
                //获取当前选中的结果数据
                // console.log(results.selected.data);
				var location_inner = (results.selected.data.location.lat +","+results.selected.data.location.lng);
                var add_map = results.selected.data.pname+results.selected.data.cityname+results.selected.data.adname;
                var add_dx  = results.selected.data.name;
               var addr_door =results.selected.data.address; 
                var edit_type =$("#addr_status").val();
                if(edit_type =="add"){
                    $("#map_div").hide();
					$("#add_in").val(add_dx);
					 $("#add_door").val(addr_door);                   
                    $("#add_locat").val(location_inner) ;
                }else {
                    $("#map_div").hide();
                    $("#edit_in").val(add_dx);
                     $("#edit_door").val(addr_door);
                    $("#edit_locat").val(location_inner) ;                    
                }
            });
      }
</script>
</body>

</html>
