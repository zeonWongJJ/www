<?php
$a_max_msg = $this->db->get_row('messagess', NULL, 'mess_id', ['mess_id' => 'desc']);
$a_max_order = $this->db->get_row('order', ['order_type' =>1,'order_state' =>20,'store_id' => $_SESSION['store_id']], 'order_id', ['order_id' => 'desc']);
$a_new_max_order = $this->db->get_row('order', ['order_type' =>2 ,'order_state' =>20], 'order_id', ['order_id' => 'desc']);
$a_max_appointment = $this->db->get_row('appointment', NULL, 'appointment_id', ['appointment_id' => 'desc']);
?>
<?php
// 调用安卓
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) {
?>
<script type="text/javascript" charset="utf-8" src="http://cordova.js"></script>
<script type="text/javascript" charset="utf-8" src="http://qiducashregisterlink.js"></script>
<?php
}
?>
<script>
var max_msg_id = "<?php echo $a_max_msg['mess_id'];?>";
var max_order_id = <?php echo $a_max_order['order_id'];?>;
var max_new_order_id = "<?php echo $a_new_max_order['order_id'];?>";
var max_appointment_id = "<?php echo $a_max_appointment['appointment_id'];?>";
// 启动轮询
var polling_obj = window.setInterval(polling_new_msg_order, 5000);
function polling_new_msg_order() {
    // console.log("max_msg_id:"+max_msg_id);
    // console.log("max_order_id:"+max_order_id);
	$.ajax({
		url: "<?php echo $this->router->url('new_msg_order');?>",
		type: "post",
		data: "",
		dataType: "json",
		success: function(result) {
		    // console.log(result);
           if(result.order_id > max_order_id){
               $("#new_remind_msg").css("display", "block");
               $("#order_online").css("color","red");
               max_msg_id = result.order_id;
               play(1);
           }



			if (result.mess_id > max_msg_id) {
				max_msg_id = result.mess_id;
				$("#new_remind_order").css("display", "block");

			}
			// if (result.order_id > max_order_id) {
			// 	$("#new_remind_msg").css("display", "block");
			// 	$("#order_online").css("color","red");
			// 	play(1);
             //    max_msg_id = result.order_id;
			// }else{
			//     console.log(11111222);
            // }

			if (result.new_order_id > max_new_order_id) {
				console.log(2)
				max_msg_id = result.new_order_id;
				$("#new_remind_msg").css("display", "block");
				$("#order_new").css("color","red");
				play(1);
			}			

			if (result.appointment_id > max_appointment_id) {
				console.log(3)
				max_msg_id = result.appointment_id;
				$("#new_remind_msg").css("display", "block");
				$("#book_order_list").css("color","red");
				// play(1);				

			}
			
		},
		error:function(msg){
			//alert('');
		}
	});
}

function play(val){ 
	if(val == 1) {
        //IE9+,Firefox,Chrome均支持<audio/>   
        $('#newMessageDIV').html('<audio controls="controls" autoplay="autoplay"><source src="static/default/plugin/notify.mp3"'   
        + 'type="audio/wav"/><source src="static/default/plugin/notify.mp3" type="audio/mpeg"/></audio>');
    }    
     
}

$(document).ready(function() {
	$("#moneybox").click(function (event) {
		$("#moneybox_window").show();
	});
	$("#moneybox_window_clobtn").click(function (event) {
		$("#moneybox_window").hide();
	});
	$("#moneybox_pswd").keydown(function (e) {
		var cur_key = e.which;
		var passwd = $("#moneybox_pswd").val();
		
		if (cur_key == 13) {
			$.ajax({
				url: "<?php echo $this->router->url('moneybox_pswd');?>",
				type: "post",
				data: {password: passwd},
				dataType: "json",
				success: function(result) {
					if (result.status == 'success') {
						openCashBoxMachine();
						$("#moneybox_window").hide();
					}
				},
				error:function(msg){
					//alert('');
				}
			});
		}
    });
});
</script>

<style type="text/css">
.moneybox {
	background-color: #2fd07d;
	border: solid 1px #ccc;
	position: absolute;
	display: none;
	top:50%;
	left:50%;
	width: 500px;
	height: 300px;
	margin-top:-150px;
	margin-left:-250px;
	padding: 5px;
	z-index: 999;
}
</style>
			<div class="left">
			<div id="newMessageDIV" style="display:none"></div>  
				<div class="message message1 <?php if ($this->router->get_index() == 'msg_show') {echo 'current';}?>">
					<a class="mPic clearfix" href="<?php echo $this->router->url('msg_show');?>">
						<span class="sImg">
							<img class="img" src="static/default/images/diancan_03.png"/>
					        <i class="yuan" id="new_remind_msg" style="display:none"></i>
						</span>
						<span class="wen">消息</span>
					</a>
				</div>
				<div class="message order <?php if ($this->router->get_index() == 'index') {echo 'current';}?>">
					<a class="mPic clearfix" href="<?php echo $this->router->url('index');?>">
						<span class="sImg">
							<img class="img" src="static/default/images/diancan_29.png"/>
						</span>
						<span class="wen">点餐</span>
					</a>
				</div>
				<div class="message takeOut <?php if ($this->router->get_index() == 'order_new') {echo 'current';}?>">
					<a class="mPic clearfix" href="<?php echo $this->router->url('order_new');?>">
						<span class="sImg">
							<img class="img" src="static/default/images/diancan_32.png"/>
					        <i class="yuan" id="new_remind_order" style="display:none"></i>
						</span>
						<span class="wen">订单</span>
					</a>
				</div>
				<div class="message" id="moneybox">
					<a href="javascript:void(0)">
						<img src="static/default/images/zzz.png" width="22px" height="13.42px" />
						<span style="display:block; margin-top:5px; font-size:12px; color:white;">钱箱</span>
					</a>
				</div>
				<div class="closeBtn">
					<a href="<?php echo $this->router->url('logout');?>"><img src="static/default/images/guanbi.png"/></a>
				</div>
			</div>
			
			<!-- 钱柜弹窗 -->
			 <div id="moneybox_window" style="background-color: #2fd07d;border: solid 1px #ccc;	position: absolute;display: none;top:50%;left:50%;width: 500px;height: 300px;margin-top:-150px;margin-left:-250px;padding:30px;z-index:999;">
				<div class="div" style="width: 100%; height: 100%; overflow-y: auto; text-align:center">
					<h2>请输入钱箱密码：</h2> <br />
					<input type="password" name="moneybox_pswd" id="moneybox_pswd" style="width:200px; height:50px; margin: 0 0 30px 0; font-size:18px" /> <br />
					<a id="moneybox_window_clobtn" style="cursor:pointer;">关闭</a>
				</div>
			</div>