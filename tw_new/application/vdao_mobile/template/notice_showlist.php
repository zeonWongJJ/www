<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>公告列表</title>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>公告列表</h1>
	<div id="div_max">
		<?php foreach ($a_view_data as $key => $value): ?>
			<li style="height:40px; line-height:40px;"><a href="<?php echo $this->router->url('notice_detail',['id'=>$value['notice_id']]); ?>"><?php echo $value['notice_id'].'--'.$value['notice_title'].'--'.date('Y-m-d',$value['notice_time']); ?></a></li>
		<?php endforeach ?>
	</div>
	<div id="no_more"></div>
	<button onclick="get_news_more()">查看更多</button>
</body>
</html>

<script>
var page = 1;
function get_news_more() {
	page++;
	//通过ajax将个数传递过去并获取更多数据回来
	$.ajax({
		url: '<?php echo $this->router->url('notice_showlist'); ?>',
		type: 'post',
		data: {'page':page},
		dataType: 'json',
		success: function(data){
			console.log(data);
			//将数据追加到页面
			if (data.code==400) {
				$('#no_more').html('没有更多数据了');
			} else {
	 			$.each(data, function (n, value) {
	               $("#div_max:last").append("<li style='color:red;'><a href='/notice_detail-"+value.notice_id+"'>"+value.notice_id+'--'+value.notice_title+'--'+value.notice_time+"</li>");
	           });
			}
		}
	});
}
</script>