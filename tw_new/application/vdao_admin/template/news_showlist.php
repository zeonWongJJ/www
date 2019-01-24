<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>新闻列表</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
	<style>
		table {
			width: 700px;
			border-collapse: collapse;
		}
		th,td{
			padding: 5px;
			border: 1px solid green;
		}
	</style>
</head>
<body>
	<h1>新闻列表</h1>
	新闻搜索：<input type="text" name="news_search">&nbsp;<button onclick="news_search()">搜索</button>
	<br><br>
	<table>
		<tr>
			<th>选择</th>
			<th>id</th>
			<th>新闻标题</th>
			<th>分类</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
			<tr id="<?php echo "tr_".$value['news_id']; ?>">
				<td><input type="checkbox" name="news_id[]" value="<?php echo $value['news_id']; ?>"></td>
				<td><?php echo $value['news_id']; ?></td>
				<td><?php echo $value['news_title']; ?></td>
				<td><?php echo $value['cate_name']; ?></td>
				<td>
					<a href="<?php echo $this->router->url('news_update',['id'=>$value['news_id']]); ?>">修改</a> |
					<a href="<?php echo $this->router->url('news_preview',['id'=>$value['news_id']]); ?>">预览</a> |
					<a href="#" onclick="news_delete_one(<?php echo $value['news_id']; ?>)">删除</a> |
					<a href="#" onclick="news_switch(<?php echo $value['news_id']; ?>)" id="<?php echo 'switch_'.$value['news_id']; ?>"><?php if($value['news_state']==1){ echo "显示"; } else { echo "隐藏"; } ?></a>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
	<br>
	<br>
	<button onclick="news_delete_mony()">批量删除</button>
	<br><br>
	<h2><a href="<?php echo $this->router->url('news_add'); ?>">添加新闻</a></h2>
</body>
</html>


<script>

function news_delete_one(news_id) {
	if (confirm('你确定要删除这篇新闻吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('news_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {news_id: news_id, type: 1},
			success: function(data) {
				console.log(data);
				if (data.code==200) {
					$("#tr_"+news_id).remove();
				}
			}
		})
	}
}

function news_delete_mony() {
	var news_ids = new Array();
	var i = 0;
	$("input:checkbox[name='news_id[]']:checked").each(function(index, el) {
		news_ids[i] = $(this).val();
		i++
	});
	if (confirm('你确定要删除这'+news_ids.length+'条新闻吗?')) {
		$.ajax({
			url: '<?php echo $this->router->url('news_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {news_ids: news_ids, type: 2},
			success: function(data) {
				console.log(data);
				if (data.code==200) {
					for (var j=0; j<news_ids.length; j++) {
						$('#tr_'+news_ids[j]).remove();
					}
				}
			}
		})
	}
}

function news_switch(news_id) {
	var msg = $('#switch_'+news_id).html();
	if (msg=='显示') {
		var state = '隐藏';
	} else {
		state = '显示';
	}
	if (confirm('你确定要'+state+'这条新闻吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('news_switch'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {news_id: news_id},
			success:function(data) {
				console.log(data);
				if (data.code==200) {
					if (msg=='显示') {
						$('#switch_'+news_id).html('隐藏');
					} else {
						$('#switch_'+news_id).html('显示');
					}
				}
			}
		})
	}
}

function news_search() {
	var keywords = $("input[name='news_search']").val();
	if (keywords != '') {
		$.ajax({
			url: '<?php echo $this->router->url('news_search'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {keywords: keywords},
			success: function(data){
				console.log(data);
			}
		})
	}
}

</script>