function initTitleBarLayoutIsVisible(num) {
	var u = navigator.userAgent;
	var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
	var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
	//原生那边标题栏 0显示 1不显示
	if(isAndroid) {
		var obj = {
			"isShowTitle": num
		}
		titleBarLayoutIsVisible(obj);
		if(num == 0) {
			$(".head,.pjoTitle").hide();
		} else if(num == 1) {
			$(".head,.pjoTitle").show();
		}

	} else if(isiOS) {
		// alert("ios");
		var obj = {
			"isShowTitle": num
		}
		window.webkit.messageHandlers.vdao.postMessage({
			body: obj,
			callback: '',
			command: 'titleBarLayoutIsVisible'
		});
		/*if(num == 0) {
			$(".head,.pjoTitle").hide();
		} else if(num == 1) {
			$(".head,.pjoTitle").show();
		}*/
	}
}