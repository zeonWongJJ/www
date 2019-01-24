
<link href="static/pc_default/style/date-slider.css" type="text/css" rel="stylesheet"/>
<script src="static/pc_default/script/jquery-2.1.4.min.js"></script>
<script language="javascript" src="static/pc_default/script/jquery-ui.min.js"></script>
<script language="javascript" src="static/pc_default/script/date-slider.js"></script>

 <script type="text/javascript">
   	var Months = ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"];
   	$(function(){
		createDemos();
	});
	
	function createDemos(){
		var	date = $("<div id='date' />").appendTo($("#date-axis"));//渲染日期组件
		var dateSilderObj=date.dateRangeSlider({
			arrows:true,//是否显示左右箭头
			bounds: {min: new Date(<?php echo date('Y, n, j', $_SERVER['REQUEST_TIME'] - 864000);?>), max: new Date(<?php echo date('Y, n, j', $_SERVER['REQUEST_TIME'] + 8640000);?>, 12, 59, 59)},//最大 最少日期
			defaultValues: {min: new Date(<?php echo date('Y, n, j', $_SERVER['REQUEST_TIME'] - 864000);?>), max: new Date(<?php echo date('Y, n, j', $_SERVER['REQUEST_TIME'] + 86400);?>)}//默认选中区域
			,scales:[{
					first: function(value){return value; },
					end: function(value) {return value; },
					next: function(val){
						var next = new Date(val);
						return new Date(next.setMonth(next.getMonth() + 1));
					 },
					label: function(val){
						return Months[val.getMonth()];
					},
					format: function(tickContainer, tickStart, tickEnd){
						tickContainer.addClass("myCustomClass");
					}
			}]
			
					
		});//日期控件
		
		//重新赋值（整个时间轴）
		dateSilderObj.dateRangeSlider("bounds", new Date(<?php echo date('Y, n, j', $_SERVER['REQUEST_TIME'] - 3456000);?>), new Date(<?php echo date('Y, n, j', $_SERVER['REQUEST_TIME'] + 3024000);?>, 12, 59, 59));

		//重新赋值（选中区域）
		dateSilderObj.dateRangeSlider("values", new Date(<?php echo date('Y, n, j', $_SERVER['REQUEST_TIME'] - 2678400);?>), new Date(<?php echo date('Y, n, j', $_SERVER['REQUEST_TIME'] - 1296000);?>));

		
		//拖动完毕后的事件
		dateSilderObj.bind("valuesChanged", function(e, data){
			var val=data.values;
			var stime=val.min.getFullYear()+"-"+(val.min.getMonth()+1)+"-"+val.min.getDate();
			var etime=val.max.getFullYear()+"-"+(val.max.getMonth()+1)+"-"+val.max.getDate();
			$("#time_axis_start").val(stime);
			$("#time_axis_end").val(etime);
		  	console.log("起止时间："+stime+" 至 "+etime);
		});
	}
   </script> 
<!-- 时间轴 -->
	<input type="hidden" id="time_axis_start" name="time_start" value="<?php echo date('Y-m-d');?>" />
	<input type="hidden" id="time_axis_end" name="time_end" value="<?php echo date('Y-m-d', $_SERVER['REQUEST_TIME'] + 1296000);?>" />
	<div class="dateSlider" id="date-axis" style="height:40px;">&nbsp;</div>
<!-- 时间轴 -->

