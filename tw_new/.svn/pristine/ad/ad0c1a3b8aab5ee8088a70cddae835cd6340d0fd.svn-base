<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>添加新闻</title>
	<script type="text/javascript" charset="utf-8" src="plugin/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="plugin/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="plugin/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
	<h1>添加新闻</h1>
	<form action="<?php echo $this->router->url('news_add'); ?>" method='post'>
		新闻标题：<input type="text" name="news_title"><br>
		新闻关键词：<input type="text" name="news_keywords"><br>
		新闻描述：<textarea name="news_description"></textarea><br>
		新闻分类：
		<select name="cate_id">
			<?php foreach ($a_view_data as $key => $value): ?>
				<option value="<?php echo $value['cate_id']; ?>"><?php echo str_repeat('--', $value['cate_level']) . $value['cate_name']; ?></option>
			<?php endforeach ?>
		</select>
		<br>
		新闻内容：
		<script id="editor" name="news_content" type="text/plain"></script>
		<br>
		<input type="submit" value="添加新闻">
	</form>
</body>
</html>

<script>
	var ue = UE.getEditor('editor');
</script>