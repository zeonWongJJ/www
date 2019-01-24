<div class="footer">
	<div class="footer-inner">
		<div class="footer-content">
			<span class="bigger-120">
				<span class="blue bolder" id="tmp_test">I</span>
				used to be an adventurer like you, then I took an arrow in the knee
			</span>

			&nbsp; &nbsp;
			<span class="action-buttons">
				<a href="#">
					<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
				</a>

				<a href="#">
					<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
				</a>

				<a href="https://project.7dugo.com/download/XDevOps.rar" title="不兼容xp">
					<i class="ace-icon fa fa-download orange bigger-150"></i>
				</a>
				
				<a href="https://project.7dugo.com/download/xds.rar" title="不能输入中文">
					<i class="ace-icon fa fa-cloud-download orange bigger-150"></i>
				</a>
			</span>
		</div>
	</div>
</div>

<?php
// 获取最后一条通知
$a_notice_last = $this->db->get_row('notice', '', 'id_notice', ['id_notice' => 'DESC']);

?>
<script>
var id_notice_last = <?php echo $a_notice_last['id_notice'];?>;
var id_notice_last_tmp = 0;
function polling() {
	$.ajax({
		url: "<?php echo $this->router->url('notice_get_last');?>",
		type: "post",
		data: "notice=" + id_notice_last,
		dataType: "json",
		success: function(result) {
			$.each(result, function(i, res) {
				if (res.id_notice > id_notice_last) {
					id_notice_last_tmp = res.id_notice > id_notice_last_tmp ? res.id_notice : id_notice_last_tmp;
					//notify('你有新的通知！', 'static/pc_default/image/notice.png', res.content, res.link);
					notice_desktop(res.content, res.link);
				}
			});
			id_notice_last = id_notice_last_tmp > id_notice_last ? id_notice_last_tmp : id_notice_last;
		},
		error:function(msg){
			alert(msg);
		}
	});
}
// 启动轮询
var polling_obj = window.setInterval(polling, 2000);

function notify(title, icon, body, link){
	if (!('Notification' in window)) {
		alert('你的浏览器不支持Notification')
	}
	
	//检查是否拥有通知权限；有就通知，没有请求；
	else if (Notification.permission=='granted') {
		var options={
			icon:icon,
			body:body
		};
		var notification=new Notification(title,options);
		notification.onclick = function() {
			window.location.href=link;
		}

	}else if (Notification.permission !== 'denied'){
		Notification.requestPermission().then(function(result){
			if(result=='granted'){
				var options={
					icon:icon,
					body:body
				};
				var notification=new Notification(title,options);
			}
		})
	}
	Notification.onerror();
}

function notice_desktop(content, link) {
	//window.external.notice_desktop(content, link);
	jsobj.notice_desktop(content, link);
}
</script>