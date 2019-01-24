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
    <link rel="stylesheet" href="static/style_default/style/bindCard.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <title></title>
</head>
<body>

    <div class="contentContainer">
        <p class="pjoTitle">
            <a href="javascript:window.history.back();" style="top:0.45rem;"><img src="static/style_default/images/kefu_03.png" /></a>
            <span>绑定银行卡</span>
        </p>
        <!-- 表单 -->
        <div class="formContainer">
            <form action="">
                <dl>
                    <dt>请绑定需要提现的银行卡</dt>
                    <dd>
                        <span>姓名</span>
                        <input type="text" name="bank_realname" placeholder="请输入收款人姓名"/>
                    </dd>
                    <dd>
                        <span>卡号</span>
                        <input type="text" name="bank_number" placeholder="请输入银行卡账号"/>
                    </dd>
                    <dd>
                        <span>开户行名称</span>
                        <input type="text" name="bank_name" placeholder="请输入开户行名称"/>
                    </dd>
                    <dd>
                        <span>收款人开户行所在省</span>
                        <input type="text" name="bank_province" placeholder="请输入开户行所在省"/>
                    </dd>
                    <dd>
                        <span>收款人开户行所在地区</span>
                        <input type="text" name="bank_city" placeholder="请输入开户行所在地区"/>
                    </dd>
                    <dd>
                        <span>开户支行名称</span>
                        <input type="text" name="sub_bank" placeholder="请输入开户行名称"/>
                    </dd>
                </dl>
                <input type="submit" id="sub" value="提交"/>
            </form>
        </div>
        <!-- 表单 -->
    </div>

</body>
</html>


<script>

$('#sub').click(function(event) {
    var bank_realname = $.trim($("input[name='bank_realname']").val());
    var bank_number   = $.trim($("input[name='bank_number']").val());
    var bank_name     = $.trim($("input[name='bank_name']").val());
    var bank_province = $.trim($("input[name='bank_province']").val());
    var bank_city     = $.trim($("input[name='bank_city']").val());
    var sub_bank      = $.trim($("input[name='sub_bank']").val());
    if (bank_realname != '' && bank_number != '' && bank_name != '' && bank_province != '' && bank_city != '' && sub_bank != '') {
        // 发送ajax请求
        $.ajax({
            url: 'account_add',
            type: 'POST',
            dataType: 'json',
            data: {bank_realname: bank_realname, bank_number:bank_number, bank_name:bank_name, bank_province:bank_province, bank_city:bank_city, sub_bank:sub_bank, type:1},
            success: function(res) {
                console.log(res);
                if (res.code == 200) {
                    window.location.replace("account_manage");
                }
            }
        })
    }
    return false;
});

</script>