<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML,ASP,PHP,SQL">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=6" ><!-- 使用IE6 -->
    <meta http-equiv="X-UA-Compatible" content="IE=7" ><!-- 使用IE7 -->
    <meta http-equiv="X-UA-Compatible" content="IE=8" ><!-- 使用IE8 -->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/public.css"/>
    <link rel="stylesheet" href="static/style_default/style/cupSize.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/cupSize.js"></script>
    <title>杯型管理</title>
    <style>
    .tips_del {
	    width: 320px;
	    position: absolute;
	    top: 40%;
	    left: 50%;
	    padding: 30px;
	    font-size: 14px;
	    background: white;
	    box-shadow: 3px 5px 23px #888888;
	}
	.tips_del>img {
	    width: 15px;
	    position: absolute;
	    right: 10px;
	    top: 10px;
	}
    </style>
</head>
<body style="background:#efefef;">
<!--  后台管理 -->
<div class="productClassification">
 	<?php echo $this->display('header'); ?>
    <!--  右侧内容 -->
    <article>
        <!--  标题 -->
        <?php echo $this->display('top'); ?>
        <!--  标题 -->

        <!-- 杯型管理 -->
        <div class="cupSize">
            <p>产品管理>杯型管理</p>
            <div class="cup_content">
                <form action="cup" method='post' id="formId">
                    <a><img src="static/style_default/image/pro_03.png" alt=""/>添加杯型</a>
                    <div class="search_cup">
                        <input type="text" placeholder="杯型名称" onfocus="javascript:if(this.value=='杯型名称')this.value='';" name="name"/>
                        <i onclick="document.getElementById('formId').submit();"><img src="static/style_default/image/s_03.png" alt=""/></i>
                    </div>
                </form>
            </div>
            <!-- 选择 -->
            <div class="choice_cup">
                <table>
                    <thead>
                        <tr>
                            <td class="all_select">
                                <img src="static/style_default/image/pro_07.png" alt=""/>
                                <span>全选</span>
                            </td>
                            <td class="cup_name">
                                <span>杯型名称</span>
                            </td>
                            <td class="cup_operate">
                                <span>操作</span>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php foreach ($a_view_data as $cup) {?>
                        <tr>
                            <td class="choice_list">
                                <img src="static/style_default/image/pro_07.png" alt="" value="<?php echo $cup['cup_id']?>"/>
                            </td>
                            <td class="cup_size">
                                <span><?php echo $cup['cup_name']?></span>
                            </td>
                            <td class="chocie_select">
                                <img src="static/style_default/image/pro_26.png" alt="" onclick="dele(<?php echo $cup['cup_id']?>)"/>
                                <img class="revise" src="static/style_default/image/pro_28.png" alt="" onclick="upta(<?php echo $cup['cup_id']?>)"/>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <!-- 选择 -->
            <!-- 底部工具栏 -->
            <div class="tool_bottom">
                <a class="bottomAllSelect">
                    <img src="static/style_default/image/pro_07.png" alt=""/>
                    <span>全选</span>
                </a>
                <a class="bottomDelect">
                    <img src="static/style_default/image/pro_26.png" alt=""/>
                    <span>删除</span>
                </a>
            </div>
            <!-- 底部工具栏 -->
        </div>
        <!-- 杯型管理 -->

        <!-- 添加杯型 -->
        <div class="add_cup hide">
            <p>
                <span>添加杯型</span>
                <img class="cup_close" src="static/style_default/image/pro_19.png" alt=""/>
            </p>
            <!-- <form action=""> -->
                <div class="cup_info">
                    <span>杯型名称</span>
                    <input type="text" placeholder="输入10字符/汉字" name="cupname" />
                    <em class="info_tips">
                        <img src="static/style_default/image/t_03.png" alt=""/>
                        <span>还可以输入10字符/汉字</span>
                    </em>
                </div>
                <input type="submit" id="cup_sub" value="确定"/>
            <!-- </form> -->
        </div>
        <!-- 添加杯型 -->

        <!--  修改杯型 -->
        <div class="revise_cup hide">
            <p>
                <span>修改杯型</span>
                <img class="reviseCup_close" src="static/style_default/image/pro_19.png" alt=""/>
            </p>
            <!-- <form action=""> -->
                <div class="reviseCup_info">
               		<input type="hidden" name="id" id="id"/>
                    <span>杯型名称</span>
                    <input type="text" name="name" id="name"/>
                    <em class="cupInfo_tips">
                        <img src="static/style_default/image/t_03.png" alt=""/>
                        <span>还可以输入10字符/汉字</span>
                    </em>
                </div>
                <input type="submit" id="reviseCup_sub" value="确定"/>
            <!-- </form> -->
        </div>
        <!--  修改杯型 -->

        <!-- 重要提示 -->
        <div class="tips_lay hide">
            <h4>重要提示</h4>
            <p>*确认要删除这一部分杯型吗？</p>
            <span>*删除后不可恢复，平台将停止销售此部分杯型</span>
            <img class="tipsClose" src="static/style_default/image/pro_19.png" alt=""/>
            <div class="tips_btn">
            	<input type="hidden" name="id" id="duo_id"/>
                <em class="duo_id">确认</em>
                <span class="guanb">在看看</span>
            </div>
        </div>
        <!-- 重要提示 -->
        <div class="tips_del hide">
            <h4>重要提示</h4>
            <p>*确认要删除这个杯型吗？</p>
            <span>*删除后不可恢复，平台将停止销售此部分杯型</span>
            <img class="tipsClose" src="static/style_default/image/pro_19.png" alt=""/>
            <div class="tips_btn">
                <input type="hidden" name="id" id="cup_id"/>
                <em class="cup_id">确认</em>
                <span class="guanb">在看看</span>
            </div>
        </div>
    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>
<script>
	$('#cup_sub').click(function() {
		var name = $(" input[ name='cupname' ] ").val();
		if( $(".cup_info>input[name='cupname']").val()=="" ){
		    alert('杯型名称不能为空！');
		}else{
		    $.ajax({
        		    type : 'post',
        		    url  : '<?php echo $this->router->url('cup_add'); ?>',
        		    data : {name:name},
        		    datdaType : 'json',
        		    success : function(data) {
        		        if (data == 55) {
        		            alert('添加成功！');
        		            window.location.reload();
        		        } else if (data == 33) {
        		        	alert('杯型名称不能为空！');
        		        } else {
        		            alert('添加失败！');
        		            window.location.reload();
        		        };
        		    }
        	})
		}

    })
	function upta(cup_id) {
		$(".revise_cup").show();
		$.ajax({
			url: '<?php echo $this->router->url('cup_update'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {id: cup_id},
			success: function(data) {
				$('#id').attr("value", data.cup_id);
				$('#name').attr("value", data.cup_name);
			}
		})
	}
	$('#reviseCup_sub').click(function() {
		var id   = $('#id').attr("value");
		var name = $('#name').attr("value");
		$.ajax({
			url: '<?php echo $this->router->url('cup_update'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {id: id, name: name},
			success: function(data) {
				if (data == 8) {
					alert('修改杯型成功！');
					window.location.reload();
				} else {
					alert('修改杯型失败！');					
				};
			}
		})
	})
	$('.cup_id').click(function() {
		var cup_id = $('#cup_id').attr("value");
		$.ajax({
			url: '<?php echo $this->router->url('cup_del'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {id: cup_id, vart: 1},
			success: function(data) {
				if (data == 1) {
					alert('删除杯型成功！');
					window.location.reload();
				} else {
					alert('删除杯型失败！');					
				};
			}
		})
	})
	$('.bottomDelect').click(function() {
		$(".tips_lay").show();
	})
	$('.duo_id').click(function() {
		var id = new Array();
		var i = 0;
		$('.checkbox_list').each(function(){
		   	id[i] = $(this).attr('value');
		  	i++;
		});
		$.ajax({
			url: '<?php echo $this->router->url('cup_del'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {id: id, vart: 2},
			success: function(data) {
				if (data == 1) {
					alert('删除杯型成功！');
					window.location.reload();
				} else {
					alert('删除杯型失败！');					
				};
			}
		})
	})
	function dele(cup_id) {
		$(".tips_del").show();
		$('#cup_id').attr("value", cup_id);
	}
	$('.guanb').click(function() {
		$('.tips_lay').hide();
		$('.tips_del').hide();
	})
	$('.tipsClose').click(function() {
		$('.tips_lay').hide();
		$('.tips_del').hide();
	})
</script>