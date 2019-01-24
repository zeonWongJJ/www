    function send_phone(send_data){
            send_data['device_number']=device_number;
      
        console.log(send_data);
            $.ajax({
                  type: 'POST',
                  data: send_data,
                  url : 'send_code',
                  beforeSend:function(){
 
                  },
                  success: function(json) {
                    var json_data = eval('(' + json + ')');
                    if(json_data['status']){
                         console.log("ok");
                        regTips.text("");
                        regTips.css("display","block");
                        regTips.text("ok");
                        sPhone.attr("disabled",true);
                        $(this).hide();
                        $(".userCode>b").css("display","inline");
                        timer();
                    }else{
                        regTips.text("发送失败");
                    }
                       

                  },
                  error: function() {
                      alert('请检查网络配置,稍后再试');
                  }
              });
    }