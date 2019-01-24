$(function(){
	//fix 浏览器后退时地址框为空
	var stockaddress=$("input[name=area_info]").val();
	if(stockaddress!=""){
	$("#stockaddress").text(stockaddress);
	}

	$(".save_address").click(function(){
		var mobile_status=mobile_check();
		var name_status=name_do_check();
		var select_status=select_address_check();
		var tel_status=tel_check();
		if(mobile_status==true && name_status==true && select_status==true && tel_status==true){
			$("form").submit();
		}
	})
//****************输完手机号执行 start***********************
		$(".userMobile-text").blur(function(){
		mobile_check();
		})

		//手机号检测方法
		function mobile_check(){
			var mobile=$(".userMobile-text").val();		
			var mobile_status=is_mobile(mobile);

			if(mobile_status){
				$(".userMobile-error-text").fadeOut();
			}else{
				$(".userMobile-error-text").fadeIn();
			}

			return mobile_status;
		}


		//是否为手机
		function is_mobile(string) {
			var pattern = /^1[34578]\d{9}$/;
			if (pattern.test(string)) {
				return true;
			}else{
				return false;
			}
		};
//****************输完手机号执行 end***********************

//****************输完姓名立刻执行 start***********************

		$(".userName-text").blur(function(){
			name_do_check();
		})
		//执行的函数动作
		function name_do_check(){
			var str=$(".userName-text").val();
			var status=name_symbol_check(str);
			if(status==true){
				$(".user-error-text").fadeOut();
			}else{
				$(".user-error-text").fadeIn();
			}
			return status;
		}

		//检测内容是否有特殊字符,是否为空
		function name_symbol_check(str){
			if(str!=""){
	            var myReg = /^[^@\/\'\\\"#$%&\^\*]+$/;
	            if(myReg.test(str)){
	            return name_null_check(str);
	        	}else{
	            return false;
	            }
	        }else{
	        	return false;
	        }
        }
        //检测内容是否有空格
        function name_null_check(str){
			if (str.indexOf(" ") == -1) {
			   return true;
			} else {
			   return false;
			}
		}
//****************是否已经选择区域start*****************
		$(".userAddress-text").blur(function(){
			select_address_check();
		});

		function select_address_check(){
				var area_id=$("input[name=area_id]").attr("value");
				var address_detail=$("input[name=address]").attr("value");

				if( area_id<=30 || area_id==null || area_id=="" ){
					$(".userAddress-error-text").fadeIn();
					return false;
				}else if( address_detail==""){
					$(".userAddress-error-text").fadeIn();
					return false;
				}else{
					$(".userAddress-error-text").fadeOut();
					return true;
				}
			}
//****************是否已经选择区域end*******************

//****************填写固定电话*************************
		$(".userPhone-text").blur(function(){
			tel_check();
		});

		function tel_check(){
		var tel_number=$("input[name=tel_phone]").attr("value");
			tel_status=true;

		if(tel_number!=''){
			var tel_group=tel_number.split("-");
			var length=tel_group.length;

				if(length==2){
						for(var i=0;i<length;i++){
							if( isNaN(tel_group[i]) || tel_group[i]==''  ){
								tel_status=false;
								break;
							}else{
								tel_status=true;
							}
						
						}	

				}else{
				
				tel_status=false;

				}

				if(tel_status==true){
					var first=tel_group[0].toString().length;
					var second=tel_group[1].toString().length;

					if( (first==3 && second==8) || (first==4 && second==7) ){
						tel_status=true;
					}else{
						tel_status=false;
					}
				}	
		}

		if(tel_status==true){  
			$(".userTel-error-text").fadeOut();
		}else if(tel_status==false){
			$(".userTel-error-text").fadeIn();
		}

	return tel_status;
	}
//****************填写固定电话*************************
})