<?php include_once APPPATH . 'template/default/common/header.php'; ?>
<style>
    .upload_review_block {
        display: none;
    }

    #store_pic li {
        float: left;
        padding: 10px;
    }

    td {
        padding: 30px;
    }

    .show_img_box {
        display: inline-block;
        height: 250px;
        position: relative
    }

    .show_img_box .fuck_img_what {
        position: absolute;
        width: 100%;
        height: 90px;
        line-height: 90px;
        top: 0;
        left: 0;
        background: rgba(255, 255, 255, 0.6);
        text-align: center;
        display: none;
    }

    .show_img_box:hover .fuck_img_what {
        display: block;
        cursor: pointer;
    }

    .show_img_box .fuck_img_what .layui-icon {
        font-size: 50px;
        color: #41aaff;
    }
</style>
<body class="childrenBody" style="background: #efefef">
<form class="layui-form">
    <div class="layui-form-item">
        <label class="layui-form-label">上级分类</label>
        <div class="layui-input-block">
            <select name="parent_id" id="tree-box"></select>
            <!--                <input type="text" disabled class="layui-input" value="" id="parent_text">-->
            <!--                <input type="hidden" name="parent_id">-->
            <!--                <ul id="tree-options"></ul>-->
            <!--                <select name="parent_id" id="pid_contrainer" lay-search></select>-->
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">名称</label>
        <div class="layui-input-block">
            <input type="text" name="cat_name" class="layui-input" placeholder="分类名称">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">收费类型</label>
        <div class="layui-input-block">
            <input type="radio" name="pay_type" value="1" title="按时收费">
            <input type="radio" name="pay_type" value="2" title="按次收费">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">栏目图标</label>
        <div class="layui-input-block">
            <input type="hidden" name="cate_icon" value="">
            <button type="button" class="layui-btn" id="upload_cate_img">
                <i class="layui-icon">&#xe67c;</i>上传栏目图标
            </button>
        </div>
        <table class="layui-input-block upload_review_block" id="upload_cate_ico_block" border="1"
               style="margin-top: 20px;">
            <tr>
                <td>栏目图标</td>
                <td>
                    <ul id="store_id_card_positive" style="width: 950px;"></ul>
                </td>
            </tr>
        </table>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="post_cate">立即提交</button>
        </div>
    </div>
</form>
<?php include_once APPPATH . 'template/default/common/footer.php'; ?>
