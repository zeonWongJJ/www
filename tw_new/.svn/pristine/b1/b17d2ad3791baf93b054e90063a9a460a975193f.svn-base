<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>上传营业执照</title>
    <link rel="stylesheet" href="./static/style_default/style/common.css">
    <script src="./static/style_default/plugin/jquery-3.1.1.min.js"></script>
    <script src="./static/style_default/plugin/rem.js"></script>
    <style>
        .body {
            position: relative;
            height: 100%;
            font-size: 0.16rem;
        }
        .box {
            background: #f7f7f7;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            height: 100%;
            overflow: auto;
        }
        .head {
            height: 0.44rem;
            display: flex;
            justify-content: space-between;
            padding: 0 .15rem;
            font-size: .18rem;
            background: #fff;
        }

        .head div {
            line-height: .44rem;
            color: #000000;
        }
        .head .left {
            flex: 0 0 .1rem;
            background: url(./static/style_default/images/back.png) no-repeat;
            background-size: .1rem .18rem;
            background-position: center;
        }
        .kg {
            height: .1rem;
            width: 100%;
            background: #f7f7f7;
        }
        .top-bar {
            padding: 0 .06rem;
            height: .3rem;
            line-height: .3rem;
            background: #b8b8b8;
        }
        .top-bar span:first-child {
            color: #000000;
        }
        .top-bar span:nth-child(2) {
            float: right;
            color: #ff6710;
        }
        .upload_area {
            position: relative;
            height: 1.27rem;
            width: 2.375rem;
            margin: .2rem auto;
            margin-bottom: .125rem;
            background-image: url(./static/style_default/images/zj_03.png);
            background-repeat: no-repeat;
            background-size: 100% 100%;
            border-radius: .05rem;
        }

        /* 中间照相机外层圆圈 */
        .upload_area .camera_icon {
            position: absolute;
            top: 50%;
            left: 50%;
            width: .575rem;
            height: .575rem;
            margin: -0.2875rem;
            background-color: #72befe;
            border-radius: 50%;
        }
        /* 中间照相机图标 */
        .upload_area .camera_icon span {
            display: block;
            width: 100%;
            height: 100%;
            background-image: url(./static/style_default/images/camera_1.png);
            background-repeat: no-repeat;
            background-size: 50% 50%;
            background-position: 50% 50%;
        }
        /* 文件上传框 */
        .upload_area input[type=file] {
            color:transparent;
            opacity:0;
            width: 100%;
            height: 100%;
        }
        /* 上传描述 */
        .upload_area_text {
            text-align: center;
        }

        /* 要求遮罩层 */
        .lay {
            display: none;
            position: absolute;
            left: 50%;
            width: 2.83rem;
            margin-left: -1.415rem;
            background: #fff;
            border-radius: .1rem;
            overflow: hidden;
        }
        .lay .phone_img {
            height: 1.5rem;
            width: 2.5rem;
            margin: .4rem auto 0 auto;
            background: url(./static/style_default/images/圆角矩形5拷贝.png) no-repeat;
            background-size: 100% 100%;
        }
        .lay ul {
            width: 1.8rem;
            margin: .585rem auto;
        }
        .lay ul li {
            background: url(./static/style_default/images/√.png) no-repeat;
            background-size: auto 50%;
            background-position: left;
            padding-left: 0.2rem;
            margin-top: .125rem;
        }
        .lay ul li:first-child {
            margin-top: 0;
        }
        .lay .bottom {
            border-top: 1px #f1f1f1 solid;
            height: .55rem;
            color: #ff6710;
            line-height: .55rem;
            text-align: center;
        }
    </style>

    <script>

        function close_self() {
            var index = parent.layer.getFrameIndex(window.name);
            // 关闭页面前操作
            var count = 0;
            var parent_text = '';
            if (localStorage.getItem('business_license')) count ++;
            switch (count) {
                case 0:
                    parent_text = '请上传图片';
                    break;
                case 1:
                    parent_text = '已选择一张图片';
                    break;
            }
            parent.$('.license').find('#children_return_text').html(parent_text);
            parent.layer.close(index);
        }

        function imgChange () {
            //获取的图片文件
            var fileList = $('#file')[0].files;
            var _file = fileList[0];
            var imgUrl = window.URL.createObjectURL(_file);

            // ajax 上传
            var formData = new FormData();
            formData.append('business_license', $('#file')[0].files[0]);
            $.ajax({
                url: 'njoin_upload-business_license',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(rs) {
                    // console.log(rs)
                    if (rs.code == 200) {
                        localStorage.setItem('business_license', rs.path);

                        $('#upload_area').css({
                            'background-image': 'url('+imgUrl+')'
                        });
                    }
                }
            })
        }

        $(function() {
            // 获取添加但未上传的图片
            var business_license = localStorage.getItem('business_license');
            if (business_license) {
                $('#upload_area').css({
                    'background-image': 'url('+business_license+')'
                });
            }
            // 打开tip层
            $('#open_tip').click(function() {
                $('.box').css({
                    'background-color': 'rgba(162, 162, 162, 0.4)'
                })
                $('.lay').slideDown(100);
            });

            // 关闭tip层
            $('#close_tip').click(function() {
                $('.lay').slideUp(100);
                $('.box').css({
                    'background-color': '#fff'
                });
            });
            var top = (window.screen.height - $('.lay').height())/3;
            var scrollTop = $(document).scrollTop();
            $('.lay').css({ 'top' : top + scrollTop })
        });
    </script>
</head>
<body>
<div class="body">
    <div class="box">
        <div class="head">
            <div class="left" onclick="close_self()"></div>
            <div>营业执照</div>
            <div></div>
        </div>
        <div class="kg"></div>
        <div class="top-bar">
            <span>上传营业执照</span>
            <span id="open_tip">拍照要求</span>
        </div>

        <!-- 中间营业执照上传div -->
        <div class="upload_area" id="upload_area">
            <div class="camera_icon"><span></span></div>
            <input type="file" name="file[]" accept="images/*" id="file" onchange="imgChange();">
        </div>
        <div class="upload_area_text">营业执照正面</div>

    </div>

    <!-- 拍照要求 -->
    <div class="lay">
        <div class="phone_img"></div>
        <ul>
            <li>上传原件图片</li>
            <li>横向拍摄</li>
            <li>边框完整 亮度均匀</li>
            <li>字体清晰 无信息遮挡</li>
        </ul>
        <div class="bottom" id="close_tip">我已知晓</div>
    </div>
</div>
</body>
</html>