<?php include_once APPPATH . 'template/default/common/header.php';?>
<link rel="stylesheet" href="<?=ASSETS ?>/css/jquery.treetable.css"/>
<link rel="stylesheet" href="<?=ASSETS ?>/css/jquery.treetable.theme.default.css"/>
<script>
    function checknode(obj) {
        var chk = $("input[type='checkbox']");
        var count = chk.length;
        var num = chk.index(obj);
        var level_top = level_bottom = chk.eq(num).attr('level');
        for (var i = num; i >= 0; i--) {
            var le = chk.eq(i).attr('level');
            if (le <level_top) {
                chk.eq(i).prop("checked", true);
                var level_top = level_top - 1;
            }
        }
        for (var j = num + 1; j < count; j++) {
            var le = chk.eq(j).attr('level');
            if (chk.eq(num).prop("checked")) {
                if (le > level_bottom){
                    chk.eq(j).prop("checked", true);
                }
                else if (le == level_bottom){
                    break;
                }
            } else {
                if (le >level_bottom){
                    chk.eq(j).prop("checked", false);
                }else if(le == level_bottom){
                    break;
                }
            }
        }
    }
</script>
<body class="childrenBody">
<div id="rule_tree_container">
    <form action="" id="main-form">
        <table class="treetable" id="example-advanced" style="font-size: 14px;">
            <colgroup>
                <col>
            </colgroup>
            <thead>
            <tr>
                <th style="text-align:left;">规则名称</th>
            </tr>
            </thead>
            <tbody class="news_content" id="main_table"></tbody>
        </table>
    </form>
    <div class="layui-inline">
        <a class="layui-btn layui-btn-sm page_action" data-type="allow_post">提交</a>
    </div>
</div>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js?2.1.4"></script>
<script src="<?=ASSETS?>/js/jquery.treetable.js"></script>
<?php include_once APPPATH . 'template/default/common/footer.php';?>

