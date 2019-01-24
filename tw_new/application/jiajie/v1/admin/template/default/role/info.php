<?php include_once APPPATH . 'template/default/common/header.php';?>
<body class="childrenBody">
<form class="layui-form">
    <div class="layui-form-item">
        <label class="layui-form-label">所属上级</label>
        <div class="layui-input-block">
            <select name="parent_id" id="tree-box"></select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">角色组名称</label>
        <div class="layui-input-block">
            <input type="text" name="role_name" class="layui-input" placeholder="角色组名称" lay-verify="required">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">角色描述</label>
        <div class="layui-input-block">
            <textarea name="role_info" placeholder="角色描述" class="layui-textarea"></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否开启</label>
        <div class="layui-input-block">
            <input type="checkbox" name="role_status" lay-skin="switch" lay-text="ON|OFF">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="post_role">立即提交</button>
        </div>
    </div>
</form>
<?php include_once APPPATH . 'template/default/common/footer.php';?>
