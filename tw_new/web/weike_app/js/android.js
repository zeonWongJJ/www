		window.callActivityPlugin = function(str) {
			cordova.exec(pluginSuccess, pluginFailed, "CallActivityPlugin", "device", [ str ]);
		};
		//android端返回的error回调
		var pluginFailed = function(message) {
			alert("failed>>" + message);
		}
		var pluginSuccess=function(echoValue) {
			//例如Android端callbackContext.success("success");返回的"success"就是echoValue
				console.log("callActivityPlugin echo>>"+echoValue);
		}

		function java_call(lll){
			alert('android 调用js方法');
		}