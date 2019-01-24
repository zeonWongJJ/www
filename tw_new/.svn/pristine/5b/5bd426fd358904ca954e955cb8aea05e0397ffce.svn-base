<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="author" content=""/>
    <script src="https://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
    <title>交易进度提示</title>
    <style>
        html, body, div, span, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, abbr, address, cite, code, del, dfn, em, img, ins, kbd, q, samp, small, strong, sub, sup, var, b, i, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, figcaption, figure, footer, header, hgroup, menu, nav, section, summary, time, mark, audio, video {
            margin: 0;
            padding: 0;
        }

        table, caption, tbody, tfoot, thead, tr, th, td {
            vertical-align: middle;
        }

        li {
            list-style: none outside none;
        }

        body {
            line-height: 1;
            background: #eee;
            color: #363636;
            font-family: "微软雅黑";
        }

        :focus {
            outline: 1;
        }

        article, aside, canvas, details, figcaption, figure, footer, header, hgroup, menu, nav, section {
            display: block;
        }

        nav ul {
            list-style: none;
        }

        a {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            vertical-align: baseline;
            background: transparent;
            text-decoration: none;
            color: inherit;
        }

        em {
            font-style: normal;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        hr {
            display: block;
            height: 1px;
            margin: 1em 0;
            padding: 0;
            border: 0;
            border-top: 1px solid #ccc;
        }

        input, select {
            vertical-align: middle;
        }

        .fix {
            zoom: 1;
        }

        .fix:after {
            content: '';
            height: 0;
            width: 0;
            clear: both;
            display: block;
            overflow: hidden;
        }

        .fl {
            float: left;
        }

        .fr {
            float: right;
        }

        /*********公共按钮样式**********/
        .ui-header {
            text-align: center;
            background: #d6a41f;
            color: #fff;
            position: relative;
            height: 89px;
            line-height: 89px;
        }

        .ui-header h1 {
            font-size: 36px;
            font-weight: normal;
        }

        .ui-header .left {
            position: absolute;
            left: 32px;
            display: inline-block;
            top: 24px;
        }

        .ui-header .right {
            position: absolute;
            right: 32px;
            display: inline-block;
            top: 31px;
        }

        .icon-back {
            width: 25px;
            height: 40px;
            background-image: url(../img/icon-back.png);
            background-position: center;
            display: block;
            background-repeat: no-repeat;
            background-size: contain;
        }

        .header-tab {
            font-size: 36px;
        }

        .icon-add {
            width: 26px;
            height: 26px;
            background-image: url(../img/icon-add.png);
            background-position: center;
            background-repeat: no-repeat;
            display: block;
            background-size: contain;
        }

        .head-tab-left {
            background: #e8c56b;
            padding: 5px 15px;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .head-tab-right {
            background: #e8c56b;
            padding: 5px 15px;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .header-tab .active {
            color: #363636;
            background: #fff;;
        }

        .header-tab span {
            cursor: pointer;
        }

        .ui-row {
            margin-top: 24px;
            background: #fff;
        }

        .ui-base-cont li {
            padding: 20px 30px;
            border-bottom: 2px solid #e9e9e9;
        }

        .ui-base-cont {
            background: #fff;
        }

        .icon-box {
            position: relative;
            display: inline-block;
        }

        .icon-select {
            background-image: url(../img/icon-select.png);
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
        }

        .icon-cal-minus {
            background-image: url(../img/icon-cal-minus.png);
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
        }

        .icon-cal-add {
            background-image: url(../img/icon-cal-add.png);
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
        }

        .icon-select, .icon-cal-minus, .icon-cal-add {
            width: 42px;
            height: 42px;
            display: block;
        }

        .icon-arrow-right {
            width: 26px;
            height: 38px;
            background-image: url(../img/icon-arrow-right.png);
            background-position: center;
            background-repeat: no-repeat;
            display: block;
            background-size: contain;
        }

        .btn-checkbox {
            position: relative;
            display: inline-block;
        }

        .btn-checkbox input {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 5;
            opacity: 0;
            cursor: pointer;
        }

        .btn-checkbox label:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 50px;
            border-radius: 100%;
            left: 4px;
            top: -5px;
            z-index: 2;
            background: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            -webkit-transition: 0.4s;
            transition: 0.4s;
        }

        .btn-checkbox label {
            width: 90px;
            height: 50px;
            background: #e0e0e0;
            position: relative;
            display: inline-block;
            border-radius: 46px;
            -webkit-transition: 0.4s;
            transition: 0.4s;
        }

        .btn-checkbox input:checked + label:after {
            left: 40px;
        }

        .btn-checkbox label:after {
            top: 4px;
            width: 42px;
            height: 42px;
        }

        .btn-checkbox input:checked + label:after {
            left: 58px;
        }

        .btn-checkbox label {
            width: 104px;
        }

        .btn-checkbox input:checked + label {
            background: #d6a41f;
        }

        @media screen and (max-width: 320px) {
            .ui-header {
                height: 50px;
                line-height: 50px;
            }

            .ui-header h1 {
                font-size: 18px;
            }

            .icon-back {
                width: 14px;
                height: 23px;
            }

            .ui-header .left {
                top: 14px;
                left: 14px;
            }

            .ui-header .right {
                top: 17px;
                right: 14px;
            }

            .header-tab {
                font-size: 16px;
            }

            .icon-add {
                width: 18px;
                height: 18px;
            }

            .ui-base-cont li {
                padding: 14px 14px;
                border-bottom: 1px solid #e9e9e9;
            }

            .ui-row {
                margin-top: 10px;
            }

            .icon-select, .icon-cal-minus, .icon-cal-add {
                width: 18px;
                height: 18px;
            }

            .icon-arrow-right {
                width: 16px;
                height: 18px;
            }

            .btn-checkbox label {
                width: 42px;
                height: 21px;
            }

            .btn-checkbox label:after {
                top: 1px;
                left: 1px;
                width: 18px;
                height: 18px;
            }

            .btn-checkbox input:checked + label:after {
                left: 23px;
            }
        }

        @media screen and (max-width: 375px) {
            .ui-header {
                height: 50px;
                line-height: 50px;
            }

            .ui-header h1 {
                font-size: 18px;
            }

            .icon-back {
                width: 14px;
                height: 23px;
            }

            .ui-header .left {
                top: 14px;
                left: 14px;
            }

            .ui-header .right {
                top: 17px;
                right: 14px;
            }

            .header-tab {
                font-size: 16px;
            }

            .icon-add {
                width: 18px;
                height: 18px;
            }

            .ui-base-cont li {
                padding: 14px 14px;
                border-bottom: 1px solid #e9e9e9;
            }

            .ui-row {
                margin-top: 10px;
            }

            .icon-select, .icon-cal-minus, .icon-cal-add {
                width: 20px;
                height: 20px;
            }

            .icon-arrow-right {
                width: 16px;
                height: 18px;
            }

            .btn-checkbox label {
                width: 46px;
                height: 24px;
            }

            .btn-checkbox label:after {
                top: 2px;
                left: 2px;
                width: 19px;
                height: 19px;
            }

            .btn-checkbox input:checked + label:after {
                left: 25px;
            }
        }

        @media screen and (max-width: 414px) {
            .ui-header {
                height: 50px;
                line-height: 50px;
            }

            .ui-header h1 {
                font-size: 18px;
            }

            .icon-back {
                width: 14px;
                height: 23px;
            }

            .ui-header .left {
                top: 14px;
                left: 14px;
            }

            .ui-header .right {
                top: 17px;
                right: 14px;
            }

            .header-tab {
                font-size: 16px;
            }

            .icon-add {
                width: 18px;
                height: 18px;
            }

            .ui-base-cont li {
                padding: 14px 14px;
                border-bottom: 1px solid #e9e9e9;
            }

            .ui-row {
                margin-top: 10px;
            }

            .icon-select, .icon-cal-minus, .icon-cal-add {
                width: 23px;
                height: 23px;
            }

            .icon-arrow-right {
                width: 17px;
                height: 22px;
            }

            .btn-checkbox label {
                width: 50px;
                height: 26px;
            }

            .btn-checkbox label:after {
                top: 2px;
                left: 2px;
                width: 22px;
                height: 22px;
            }

            .btn-checkbox input:checked + label:after {
                left: 25px;
            }
        }

        /***************公共弹窗部分开始***************/
        /**公共蒙版**/
        .window-masking {
            width: 100%;
            height: 100%;
            background: #000;
            opacity: .5;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: 99;
            display: none;
        }

        .success, .window-container {
            width: 78%;
            background: #fff;
            position: fixed;
            top: 30%;
            left: 50%;
            margin-left: -39%;
            z-index: 100;
            border-radius: 4px;
            overflow: hidden;
            display: none;
        }

        .success .window-content, .window-container .window-content {
            padding: 20px 5%;
            border-bottom: 1px solid #bdbdbd;
        }

        .success p, .window-container .window-content p {
            font-size: 14px;
            color: #676767;
            line-height: 24px;
            text-align: center;
        }

        .window-btn a {
            display: block;
            height: 40px;
            width: 49%;
            text-align: center;
            line-height: 40px;
            font-size: 16px;
            font-weight: bold;
            color: #363636;
            display: none;
        }

        .window-btn a.cancel-button {
            border-right: 1px solid #bdbdbd;
        }

        .window-btn a.confirm-button {
            color: #d6a41f;
        }

        .window-container h2 {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: #363636;
            padding-top: 22px;
            display: none;
        }

        .window-btn .ack-button {
            display: none;
            height: 40px;
            width: 100%;
            text-align: center;
            line-height: 40px;
            font-size: 16px;
            font-weight: bold;
            color: #d6a41f;;
        }

        .window-btn .ack-button:active {
            background: #d6a41f;
            color: #fff;
        }

        .jy-password {
            width: 90%;
            height: 34px;
            display: block;
            margin: 20px auto 0;
        }

        /**加载中蒙版**/
        .loading {
            width: 100%;
            height: 100%;
            background: #000;
            opacity: .5;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: 99;
            display: none;
        }

        .loading img {
            display: block;
            width: 150px;
            height: 150px;
            position: fixed;
            top: 50%;
            left: 50%;
            margin-left: -75px;
            margin-top: -75px;
        }

        /***********媒体查询设置弹窗宽度************/
        @media only screen and (min-width: 568px) and (max-width: 1024px) {
            .success, .window-container {
                width: 100%;
                left: 50%;
                margin-left: -250px;
                max-width: 500px;
                top: 20%;
            }
        }

        /***************公共弹窗部分结束***************/
        /*底部滑出弹窗公共样式*/
        .bottom-popup {
            width: 96%;
            left: 2%;
            position: fixed;
            z-index: 100;
            display: none;
        }

        .popup-top, .popup-btn {
            border-radius: 8px;
            background: #fff;
            margin-bottom: 10px;
        }

        .popup-btn, .popup-title {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            line-height: 98px;
            margin-bottom: 0;
        }

        .popup-title {
            line-height: 116px;
        }

        .popup-fenx-ul {
            display: flex;
            justify-content: space-around;
        }

        .popup-fenx-ul li {
            width: 116px;
            margin-bottom: 44px;
            text-align: center;
            font-size: 28px;
        }

        .popup-fenx-ul li img {
            width: 116px;
            margin-bottom: 20px;
        }

        .popup-ul li, .list-title {
            height: 99px;
            border-bottom: 1px solid #eee;
            text-align: center;
            line-height: 99px;
            font-size: 32px;
            font-weight: bold;
        }

        .popup-ul li:last-child {
            border-bottom: none;
        }

        .popup-ul li.active {
            color: #ff4900;
        }

        .list-title {
            font-weight: normal;
        }

        /*按钮样式*/
        .btn {
            border-radius: 6px;
            font-size: 28px;
            line-height: 80px;
            background: #d6a41f;
            color: #fff;
            margin: 0 30px;
            text-align: center;
        }

        .btn-email {
            background: #fff;
            border: 1px solid #D6A41F;
            color: #D6A41F;
        }

        .btn-email-over {
            border: 1px solid #676767;
            color: #676767;
        }

        .btn-login {
            box-shadow: 0 3px #ac7e02;
            cursor: pointer;
        }

        .btn-login:active {
            background: #b98c14;
        }

        @media only screen and (max-width: 414px) {
            .bottom-popup {
                width: 96%;
                left: 2%;
            }

            .popup-fenx-ul li, .popup-fenx-ul li img {
                width: 66px;
                margin-bottom: 10px;
            }

            .popup-fenx-ul li {
                font-size: 16px;
                margin-bottom: 24px;
            }

            .popup-btn, .popup-title {
                font-size: 18px;
                line-height: 54px;
            }

            .popup-title {
                line-height: 64px;
            }

            .popup-ul li, .list-title {
                font-size: 18px;
                line-height: 54px;
                height: 54px;
            }

            .btn {
                font-size: 18px;
                line-height: 44px;
            }
        }

        @media only screen and (max-width: 320px) {
            .bottom-popup {
                width: 94%;
                left: 3%;
            }

            .popup-fenx-ul li, .popup-fenx-ul li img {
                width: 50px;
                margin-bottom: 8px;
            }

            .popup-fenx-ul li {
                font-size: 12px;
                margin-bottom: 20px;
            }

            .popup-btn, .popup-title {
                font-size: 14px;
                line-height: 42px;
            }

            .popup-title {
                line-height: 50px;
            }

            .popup-ul li, .list-title {
                font-size: 14px;
                line-height: 42px;
                height: 42px;
            }

            .btn {
                font-size: 14px;
                line-height: 34px;
            }
        }
    </style>
</head>
<body>
<script type="text/javascript">
    (function () {
        //弹窗公共部分js，所有弹窗已经写好，调用时按照页面中注释方法使用即可
        var $oMasking;
        var $oWindowContainer;
        //打开弹窗方法
        $.fn.openWindow = function (setTitle, setContents, setButton) {

            //拼接弹窗内容，并且在调用打开弹窗方法时将内容塞进body
            var _html = '<div class="window-masking"></div>' +
                '<div class="window-container fix" id="addNew">' +
                '<h2></h2>' +
                '<div class="window-content">' +
                '<p class="window-text"></p>' +
                '</div>' +
                '<div class="window-btn fix">' +
                '<a class="cancel-button fl" href="javascript:;"></a>' +
                '<a class="confirm-button fr" href="javascript:;"></a>' +
                '<a class="ack-button fr" href="javascript:;"></a>' +
                '</div>' +
                '</div>';
            //将拼接好的html塞进body里面
            $('body').append(_html);
            $oMasking = $('.window-masking');
            $oWindowContainer = $('.window-container');
            //点击取消按钮关闭弹窗
            $('.cancel-button,.window-masking,.ack-button').on('click', function () {
                closeWindow();
            });
            //设置蒙版展示
            modal = new Modal();
            console.log(setButton + "," + setContents + "," + setButton)
            modal.setTitle(setTitle);
            modal.setContents(setContents);
            //设置按钮个数和链接
            modal.setButton(setButton);
            $oMasking.show();
            //设置弹窗面板展示
            $oWindowContainer.show();
        }

        //关闭弹窗方法
        function closeWindow() {
            $oMasking = $('.window-masking');
            $oWindowContainer = $('.window-container');
            //关闭弹窗的时候将蒙版和html从页面中移除掉
            $oMasking.remove();
            $oWindowContainer.remove();
        }

        //初始化
        var Modal = function () {
            thismodal = $('#addNew');
        };
        //修改内容方法
        Modal.prototype = {
            setContents: function (obj) {
                //找到需要修改内容的标签p，获取调用中设置的提示语
                thismodal.find('p.window-text').html(obj);
            },
            setTitle: function (obj) {
                //找到需要修改的弹窗标题，获取调用中设置的弹窗标题
                if (obj != "") {
                    thismodal.find('h2').show().html(obj);
                }

            },
            setButton: function (obj) {
                console.log(obj)
                //解析传过来的参数json
                var json = eval(obj);


                if (json.length == 1) {
                    //一个按钮
                    thismodal.find('a.ack-button').show().html(json[0]);
                }
                if (json.length == 2) {
                    //两个按钮
                    thismodal.find('a.cancel-button').show().html(json[0]);
                    thismodal.find('a.confirm-button').show().html(json[1]);

                }
            }
        }

    })();
</script>

<script>
    var setTitle = '提示';
    var setContents = '<?php echo $contents; ?>';
    var redirect_url = '<?php echo $redirect_url; ?>';
    var setButton = '["确定"]';
    $(this).openWindow(setTitle, setContents, setButton);

    $(function () {
        $('body').on('click', '.ack-button', function () {
            window.location.href = redirect_url;
        });
    })
</script>
</body>
</html>
