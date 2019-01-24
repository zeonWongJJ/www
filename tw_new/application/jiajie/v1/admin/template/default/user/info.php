<?php include_once APPPATH . 'template/default/common/header.php';?>
    <body class="childrenBody">
    <form class="layui-form" lay-filter="user_info">
        <div class="layui-form-item">
            <label class="layui-form-label">账号名</label>
            <div class="layui-input-block">
                <input type="text" name="user_name" class="layui-input" placeholder="账号名"  lay-verify="required">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block">
                <input type="radio" name="user_sex" value="1" title="男">
                <input type="radio" name="user_sex" value="2" title="女" checked>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">手机号码</label>
            <div class="layui-input-block">
                <input type="text" name="user_phone" class="layui-input" placeholder="手机号码" lay-verify="required|phone">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block">
                <input type="text" name="user_email" class="layui-input" placeholder="邮箱" lay-verify="required|email">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block" id="user_password">
                <input type="password" name="user_password" class="layui-input" placeholder="密码" lay-verify="required">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">确认密码</label>
            <div class="layui-input-block" id="user_password2">
                <input type="password" name="user_password2" class="layui-input" placeholder="确认密码" lay-verify="required">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">积分</label>
            <div class="layui-input-block">
                <input type="text" name="user_score" class="layui-input" placeholder="积分">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">余额</label>
            <div class="layui-input-block">
                <input type="text" name="user_balance" class="layui-input" placeholder="余额">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="submit_user_info">立即提交</button>
            </div>
        </div>
    </form>
<?php include_once APPPATH . 'template/default/common/footer.php';?>