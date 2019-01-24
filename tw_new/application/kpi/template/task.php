<!DOCTYPE html>
<html>
<head>
	<title>任务发表</title>
	<link rel="stylesheet" type="text/css" href="style/index.css" />	
	<link href="style/default.css" rel="stylesheet" />
	<script src="script/kindeditor-min.js"></script>
	<script src="script/emoticons.js"></script>
	<script src="script/zh_CN.js"></script>	
	<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="content"]', {
					resizeType : 1,
					allowPreviewEmoticons : false,
					allowImageUpload : false,
					items : [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link']
				});
			});
	</script>
</head>
<body>
	<div class="puts">
    	<?php echo $this->display('header');?>
	    <div class="task">
			<form action="task" method="post">
				<div class="logininput">
					标题 ：<input type="text" name="title">
					<br>
					内容 ：
						<textarea name="content" style="width:500px;height:200px;visibility:hidden;"></textarea>
					执行人 ：
					<select id="executor" name="executor">
						<option value=""></option>
						<option value="xiaogang">梁金钢</option> 
						<option value="24hyy11">梁金钢</option>
						<option value="zhumei">朱妹</option>
						<option value="chunbing">陈春兵</option>
						<option value="meixian">谢美贤</option>
						<option value="mujuan">袁穆娟</option>
						<option value="yon">刘小勇</option>
						<option value="jun">周艳君</option>
						<option value="xia">陆朝霞</option>
						<option value="ming">陈元明</option>
						<option value="zuming">康祖明</option>
						<option value="ying">戚毅瀛</option>
						<option value="waifu">李外福</option>
						<option value="na">吴细娜</option>
					</select>
					<br>
					任务开始时间 ：<input type="text" class="sang_Calender"  name="start">
					<br>
					任务结束时间 ：<input type="text" class="sang_Calender"  name="end">
				</div>
				<input type="submit" value="确定" > 
			</form>
	    </div>
	</div>
<script type="text/javascript" src="script/datetime.js"></script>
</body>
</html>