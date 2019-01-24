<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>用户中心-设置-意见与反馈</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/setUp_suggestion.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/script/common.js"></script>
		<script src="static/style_default/script/setUp_suggestion.js" type="text/javascript"></script>
		 <script src="static/style_default/plugin/layer/layer.js?v=4.0"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="javascript:history.go(-1);"><img src="static/style_default/images/kefu_03.png"/></a><i>意见与反馈</i></header>
			<form id="feedbackform" action="user_feedback" method="post">
			<div class="import">
				<textarea class="txt" name="feedback_content" placeholder="请输入意见与反馈，至少输入十个字"></textarea>
				<p class="num"><span>0</span>/<span>200</span></p>
			</div>
			</form>
			<div class="submitBox">
				<a href="javascript:;" class="submitup">提交</a>
			</div>
		</div>
		<!--提交成功弹框开始-->
		<div class="successBomb">提交成功</div>
		<!--提交成功弹框结束-->
		<!--提交失败弹框开始-->
		<div class="failBomb">请至少输入十个字</div>
		<!--提交失败弹框结束-->
	</body>
</html>
<script type="text/javascript">
		$(".submitup").click(function(){
			$.post("user_feedback",$("#feedbackform").serialize(),function(res){
					if(res.code==200){
						 layer.msg(res.msg,{
                          offset:['50%'],
                          time: 1000 //2秒关闭（如果不配置，默认是3秒）
                    },function(){
                       window.location.replace("user_set");
                    }); 
					}else{
						layer.msg(res.msg); 
					}
			},"json");

		});
</script>