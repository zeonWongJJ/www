<script type="text/javascript" src="org/js/jquery.js"></script>
<div class="main-div">
    <form name="main_form" method="POST" action="__SELF__" enctype="multipart/form-data">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">角色名称：</td>
                <td>
                    <input  type="text" name="role_name" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">权限列表：</td>
                <td>    
                 <?php
                foreach($a_view_data as $k=>$v){?>
                    <?php foreach($v as $key=>$value){?>
                    <?php echo str_repeat('-', 8*($value['level']-1)); ?>
                    <input checked="checked" level_id="<?php echo $value['level']?>" type="checkbox" name="pri_id[]" value="1"><?php echo $value['auth_name']?><br>
                    <?php } ?>

                <?php }
                 ?>
                
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>
<script>
// 为所有的复选框绑定一个点击事件
$(":checkbox").click(function(){
    // 先获取点击的这个level_id
    var tmp_level_id = level_id = $(this).attr("level_id");
    // 判断是选中还是取消
    if($(this).prop("checked"))
    {
        // 所有的子权限也选中
        $(this).nextAll(":checkbox").each(function(k,v){
            if($(v).attr("level_id") > level_id)
                $(v).prop("checked", "checked");
            else
                return false;
        });
        // 所有的上级权限也选中
        $(this).prevAll(":checkbox").each(function(k,v){
            if($(v).attr("level_id") < tmp_level_id)
            {
                $(v).prop("checked", "checked");
                tmp_level_id--; // 再找更上一级的
            }
        });
    }
    else
    {
        // 所有的子权限也取消
        $(this).nextAll(":checkbox").each(function(k,v){
            if($(v).attr("level_id") > level_id)
                $(v).removeAttr("checked");
            else
                return false;
        });
    }
});
</script>














