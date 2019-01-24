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
    <link rel="stylesheet" href="static/style_default/style/invited.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <title>我的邀请</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 我的邀请 -->
    <div class="invited">
        <p class="pjoTitle">
            <img src="static/style_default/images/kefu_03.png" onclick="javascript:window.location.href='shopman_detail';" />
            <span>我的邀请</span>
        </p>

        <!-- 搜索框 -->
        <div class="search">
            <input type="text" id="searchinput" name="keywords" oninput="referee_search()" />
        </div>
        <!-- 搜索框 -->

        <!-- 邀请列表 -->
        <div class="invitedList">
            <dl>
                <?php foreach ($a_view_data as $key => $value): ?>
                <dd>
                    <a href="javascript:;">
                        <?php if (empty($value['user_pic'])) {
                            echo '<img src="static/style_default/images/tou_03.png" />';
                        } else {
                            echo '<img src="'.$value['user_pic'].'" />';
                        } ?>
                        <span><?php echo $value['user_name']; ?></span>
                    </a>
                </dd>
                <?php endforeach ?>
            </dl>
        </div>
        <!-- 邀请列表 -->

    </div>
    <!-- 我的邀请 -->
</body>
</html>

<script>

function referee_search() {
    var keywords = $("input[name='keywords']").val();
    $.ajax({
        url: 'referee_search',
        type: 'POST',
        dataType: 'json',
        data: {keywords: keywords},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                $('.invitedList dl').children('dd').remove();
                var append_content = '';
                $.each(res.data, function(index, el) {
                    append_content += '<dd>';
                    append_content += '<a href="javascript:;">';
                    if (el.user_pic == '') {
                        append_content += '<img src="static/style_default/images/tou_03.png"/>';
                    } else {
                        append_content += '<img src="'+el.user_pic+'" />';
                    }
                    append_content += '<span>'+el.user_name+'</span>';
                    append_content += '</a>';
                    append_content += '</dd>';
                });
                $('.invitedList dl').append(append_content);
            }
        }
    })
}

</script>