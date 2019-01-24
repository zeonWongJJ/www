<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>编辑地址</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="style/reset.css">
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <link rel="stylesheet" type="text/css" href="style/member.css">
    <script src="script/jquery-1.js"></script>
    <script src="js/layer.js"></script>
    
</head>
<body>
    <header id="header">
        <div class="header-wrap">
            <a class="header-back" href="address.html"><span>返回</span> </a>
            <h2>地址修改</h2>
        </div>
    </header>
    <div class="address-opera">
        <div class="address-ocnt">
            <form action="address_add_or_update" method="post">
            <input type="hidden" name="address_id" value="<?php echo $a_view_data['address_data']['address_id']?>">
            <div class="address-octlt">收货人信息</div>
            <p>姓名：<span class="opera-tips">(*必填)</span></p>
            <p>
                <input type="text" class="input-30" id="true_name" name="true_name" value="<?php echo $a_view_data['address_data']['true_name']?>" />
            </p>
            <p>手机号码：<span class="opera-tips">(*必填)</span></p>
            <p>
                <input type="text" class="input-30" id="mob_phone" name="mob_phone" value="<?php echo $a_view_data['address_data']['mob_phone']?>"/>
            </p>
            <p>固话号码：</p>
            <p>
                <input type="text" class="input-30" name="tel_phone" value="<?php echo $a_view_data['address_data']['tel_phone']?>"/>
            </p>
            <div class="address-octlt">地址信息</div>
            <div id="area">
	            <p>省份：<span class="opera-tips">(*必填)</span></p>
	            <div class="new-select-wp" id="prov">
			        <select class="select-30" id="prov_select">
                    
                    <option value=<?php echo $value['area_id']?>><?php echo $value['area_name']?></option>
			        </select>	
	            </div>
	            <p>城市：<span class="opera-tips">(*必填)</span></p>
	            <div class="new-select-wp" id="city">
			 		<select class="select-30" id="city_select" name="city_id">
				

			        </select>           	
	            </div>
	            <p>区县：<span class="opera-tips">(*必填)</span></p>
	            <div class="new-select-wp" id="region">
			       	<select class="select-30" id="region_select" name="area_id">
					
			        </select>
	            </div>
		        <p>详细地址：<span class="opera-tips">(*必填)</span></p>
	            <p>
					<input type="text" class="input-30" id="address" name="address" value="<?php echo $a_view_data['address_data']['address']?>">
	            </p>
            </div>
        </div>
        <div class="error-tips"></div>
        <input class="add_address mt10" type="submit" value="保存地址" />
        </form>
    </div>
    <!-- <?php echo $this->display('footer1');?> -->
    <script>
$(function(){
    //调用文本里的文件
    $.ajaxSettings.async = false;
    $.getJSON("script/address_json_data.js", function(jsonString){
    json_address_data=jsonString;
    });

    $("select").change(function(){
        var tips="<option>请选择</option>";
        $(this).parents(".new-select-wp").nextAll(".new-select-wp").find("select").children("option").remove();
        $(this).parents(".new-select-wp").nextAll(".new-select-wp").find("select").append(tips);
        var address_id=$(this).attr("value");
        var children_data=json_address_data['low'][address_id];

         var string;
         for(var item in children_data){ 
            string+="<option value="+item+">"+children_data[item]+"</option>";
         }

         $(this).parents(".new-select-wp").next().next().find("select").append(string);
    })
    first();
    second();
    third();
    function first(){
        var string;
        for(var item in json_address_data['top']){ 
            string+="<option value="+item+">"+json_address_data['top'][item]+"</option>";
         }
        $("select:eq(0)").append(string);

        var selected=<?php echo $a_view_data['address_data']['first']?>;
        $("select option[value="+selected+"]").attr("selected",true);
    }

    function second(){
         var string;
         var first=<?php echo $a_view_data['address_data']['first']?>;
        var second=<?php echo $a_view_data['address_data']['second']?>;
        
         var first_id=first;
         var children_data=json_address_data['low'][first_id];
         
        for(var item in children_data){ 
            string+="<option value="+item+">"+children_data[item]+"</option>";
         }
         $("select:eq(1)").append(string);
         $("select option[value="+second+"]").attr("selected",true);
    }
    function third(){
        var second=<?php echo $a_view_data['address_data']['second']?>;
        var third=<?php echo $a_view_data['address_data']['third']?>;
        var children_data=json_address_data['low'][second];
        var string;
        for(var item in children_data){ 
            string+="<option value="+item+">"+children_data[item]+"</option>";
         }

        $("select:eq(2)").append(string);
         $("select option[value="+third+"]").attr("selected",true);
    }


})
//手机判断
$("#mob_phone").blur(function(){
        mobile_check();
})

        //手机号检测方法
        function mobile_check(){
            var mobile=$("#mob_phone").val();     
            var mobile_status=is_mobile(mobile);

            if(mobile_status){
                layer.open({
                    content: '手机填写真确!',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                  });
                // alert(123);
            }else{
                layer.open({
                    content: '手机填写有误！',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                  });                
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
//名字判断
$("#true_name").blur(function(){
            name_do_check();
        })
        //执行的函数动作
        function name_do_check(){
            var str=$("#true_name").val();
            var status=name_symbol_check(str);
            if(status==true){
                layer.open({
                    content: '姓名填写真确!',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                  });
            }else{
                layer.open({
                    content: '姓名填写错误!',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                  });
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
</script>
</body>
</html>