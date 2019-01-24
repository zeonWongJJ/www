layui.config({
	base : "assets/js/modules/"
}).use(['form','layer', 'fetch'],function(){
	var form = layui.form,
        fetch = layui.fetch,
		$ = layui.jquery;

	//登录按钮事件
	form.on("submit(login)",function(data) {
		$('#login_main_btn').addClass('layui-btn-disabled');
		var field = data.field;
		fetch.ajax('/user.login', field, function(rs) {
			var token = rs.token;
			sessionStorage.setItem('user_token', token);
			window.location.href = window.config.root_url + 'admin.index'
            $('#login_main_btn').removeClass('layui-btn-disabled');
		}, function () {
            $('#login_main_btn').removeClass('layui-btn-disabled');
        })
	})
})
