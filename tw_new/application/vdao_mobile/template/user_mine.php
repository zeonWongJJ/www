<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <title>个人信息</title>
    <link rel="stylesheet" type="text/css" href="static/style_default/style/common.css" />
    <script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
    <script src="static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
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

        .kg {
            height: .1rem;
            width: 100%;
            background: #f7f7f7;
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
            background: url(static/style_default/images/back.png) no-repeat;
            background-size: .1rem .18rem;
            background-position: center;
        }

        .content .item {
            padding: .15rem;
            background: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content .item+.item {
            border-top: 1px solid #eeeeee;
        }

        .content .item.nameBox .input {
            flex: 1;
            padding: 0 .1rem;
            display: none;
        }

        .content .item .img {
            height: .525rem;
            width: .525rem;
            border-radius: 50%;
            overflow: hidden;
        }

        .content .item .img>img {
            width: 100%;
            height: 100%;
        }

        .content .item .img>.inner_img {
            width: 100%;
            height: 100%;
        }

        .bg_gray {
            background: rgba(0, 0, 0, .4);
            font-size: 0.14rem;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            display: none;
            flex-direction: column-reverse;
            align-items: center;
        }

        .bg_gray .select {
            display: none;
        }

        .bg_gray .select>div {
            background: #fff;
            text-align: center;
            width: 3.45rem;
            border-radius: .05rem;
            font-size: .16rem;
        }

        .bg_gray .select .type>div {
            height: .55rem;
            line-height: .55rem;
        }

        .bg_gray .select .type>div+div {
            border-top: 1px solid rgba(0, 0, 0, .4);
        }

        .bg_gray .cancel {
            margin-top: .15rem;
            height: .55rem;
            line-height: .55rem;
        }

        .c_gray {
            color: #666666;
        }
    </style>
</head>

<body>
<!--办公室订单-->
<div class="body">
    <div class="box">
        <div class="head">
            <div class="left" onclick="go_back()"></div>
            <div>个人信息</div>
            <div></div>
        </div>
        <div class="kg"></div>
        <div class="content">
            <div class="item">
                <div>头像</div>
                <div class="img z_photo">
                    <div class="inner_img" style="background: url('<?php
                    if (!empty($a_view_data['user']['user_pic'])) {
                        echo $a_view_data['user']['user_pic'];
                    } else {
                        echo 'static/style_default/images/tou_03.png';
                    }?>'); background-size: 100% auto; background-repeat: no-repeat">
                        <div class="z_file" style="height: 100%;">
                            <input type="file" style="color:transparent; opacity:0;height: 100%;" name="file[]"
                                   id="file"
                                   accept="images/*"
                                   onchange="user_pic_change();" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="item nameBox">
                <div>昵称</div>
                <div class="name c_gray"><?php echo $a_view_data['user']['user_nickname']; ?></div>
                <div class="input">
                    <input type="text" value="<?php echo $a_view_data['user']['user_nickname']; ?>">
                </div>
            </div>
            <div class="item">
                <div>会员号</div>
                <div class="c_gray"><?php echo $a_view_data['user']['user_name']; ?></div>
            </div>
            <div class="item sexBox">
                <div>性别</div>
                <?php
                    $s_user_sex = '';
                    switch ($a_view_data['user']['user_sex']) {
                        case '0':
                        default:
                            $s_user_sex = '未知';
                            break;
                        case '1':
                            $s_user_sex = '男';
                            break;
                        case 2:
                            $s_user_sex = '女';
                            break;
                } ?>
                <div class="sex c_gray"><?php echo $s_user_sex; ?></div>
            </div>
        </div>
    </div>
</div>

<div class="bg_gray">
<!--    <div class="select selectImg">-->
<!--        <div class="type">-->
<!--            <div class="photp" onclick="userpic_camera()">拍照</div>-->
<!--            <div class="img" onclick="userpic_photo()">去手机相册选择</div>-->
<!--        </div>-->
<!--        <div class="cancel">取消</div>-->
<!--    </div>-->
    <div class="select selectSex">
        <div class="type">
            <div class="sex" value="男">男</div>
            <div class="sex" value="女">女</div>
        </div>
        <div class="cancel">取消</div>
    </div>
</div>
<script type="text/javascript">

    /**
     * 回退上页
     */
    function go_back() {
        window.history.go(-1);
    }

    function user_pic_change() {
        //获取的图片文件
        var fileList = $('#file')[0].files;
        var _file = fileList[0];
        var imgUrl = window.URL.createObjectURL(_file);
        $('.inner_img').css({
            'background': 'url('+imgUrl+') no-repeat',
            'background-size': '100% auto'
        });
        // ajax 上传
        var formData = new FormData();
        formData.append('user_pic', $('#file')[0].files[0]);
        $.ajax({
            url: 'user_update_pic',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(rs) {
                console.log(rs)
            }
        })
    }

    /**
     * ajax更新用户名称
     * @param val
     */
    function ajax_update_nickname (val) {
        $.ajax({
            url: 'update_nickname',
            type: 'POST',
            dataType: 'json',
            data: {user_nickname: val},
            success: function (rs) {
                // console.log(rs)
                var realcode = rs.code;
                if (realcode && realcode == 200) {
                    $('.nameBox').find('.name').text(val).show();
                    $('.nameBox .input').hide();
                } else {
                    $('.nameBox .input').hide();
                    $('.nameBox').find('.name').show();
                }
            }
        });
    }

    $(function() {
        //头像
        // $('.img').click(function() {
        //     $('.bg_gray').css('display', 'flex').find('.selectImg').show();
        // });
        // 性别
        $('.sexBox').click(function() {
            $('.bg_gray').css('display', 'flex').find('.selectSex').show();
        });
        // 昵称
        $('.nameBox').click(function() {
            $(this).find('.name').hide();
            $(this).find('.input').show().find('input').focus();
        })
        //确定昵称
        $('.nameBox .input>input').blur(function() {
            var val = $(this).val();
            // ajax修改昵称
            ajax_update_nickname(val);

        });
        $('.nameBox .input>input').keypress(function() {
            if(event.keyCode == 13) {
                var val = $(this).val();
                // ajax修改昵称
                ajax_update_nickname(val);
            }
        });

        // 取消按钮
        $('.bg_gray,.bg_gray .cancel').click(function() {
            $('.bg_gray').hide().find('.select').hide();
        });

        // 选择性别
        $('.selectSex .sex').click(function() {
            var value = $(this).attr('value');
            var _value = '';
            switch (value) {
                case '男':
                    _value = 1;
                    break;
                case '女':
                    _value = 2;
                    break;
                default:
                    _value = 0;
            }
            // ajax 修改性别
            $.ajax({
                url: 'update_sex',
                type: 'POST',
                dataType: 'json',
                data: {user_sex: _value},
                success: function (rs) {
                    var realcode = rs.code;
                    if (realcode == 200) {
                        $('.sexBox .sex').text(value)
                    } else {
                        alert('修改失败');
                    }
                }
            });
        });
    })
</script>
</body>

</html>
