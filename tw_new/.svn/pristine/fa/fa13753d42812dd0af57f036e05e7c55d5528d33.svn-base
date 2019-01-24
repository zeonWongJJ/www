<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改新闻</title>
	<script type="text/javascript" charset="utf-8" src="plugin/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="plugin/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="plugin/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
	<h1>修改新闻</h1>
	<form action="<?php echo $this->router->url('news_update'); ?>" method='post'>
		<input type="hidden" name="news_id" value="<?php echo $a_view_data['news']['news_id']; ?>">
		新闻标题：<input type="text" name="news_title" value="<?php echo $a_view_data['news']['news_title']; ?>"><br>
		新闻关键词：<input type="text" name="news_keywords" value="<?php echo $a_view_data['news']['news_keywords']; ?>"><br>
		新闻描述：<textarea name="news_description"><?php echo $a_view_data['news']['news_description']; ?></textarea><br>
		新闻分类：
		<select name="cate_id">
			<?php foreach ($a_view_data['cate'] as $key => $value): ?>
				<option value="<?php echo $value['cate_id']; ?>" <?php if($value['cate_id']==$a_view_data['news']['cate_id']){ echo 'selected'; } ?>><?php echo str_repeat('--', $value['cate_level']) . $value['cate_name']; ?></option>
			<?php endforeach ?>
		</select>
		<br>
		新闻内容：
		<script id="editor" name="news_content" type="text/plain"><?php echo $a_view_data['news']['news_content']; ?></script>
		<br>
		<input type="submit" value="修改新闻">
	</form>
</body>
</html>

<script>
	var ue = UE.getEditor('editor');
</script>