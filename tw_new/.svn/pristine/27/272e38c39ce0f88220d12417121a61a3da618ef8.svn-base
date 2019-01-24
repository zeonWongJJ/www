<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>门店资金-资金管理</title>
		<link rel="stylesheet" href="./static/style_default/style/common.css"/>
        <link rel="stylesheet" href="./static/style_default/style/header.css"/>
        <link rel="stylesheet" href="./static/style_default/style/storeFund_fundManage.css"/>
        <link rel="stylesheet" href="./static/style_default/layui/css/layui.css" />
        <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="./static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="./static/style_default/script/storeFund_fundManage.js" type="text/javascript" charset="utf-8"></script>
        <script src="./static/style_default/layui/layui.js"></script>
        <script src="./static/style_default/script/cycle.js"></script>
        <script src="./static/style_default/script/raphael.js"></script>
        <script src="./static/style_default/script/echarts.common.min.js"></script>
	</head>
	<body>
		<!-- 头部 开始-->
        <?php echo $this->display('top'); ?>
        <!-- 头部结束 -->
        <div class="bottom clearfix">
        	<!-- 导航 开始-->
	        <?php echo $this->display('left'); ?>
	        <!-- 导航结束-->
	        <!--右边内容开始-->
	        <div class="rightSide">
	        	<!--面包屑导航开始-->
        		<div class="breadNav">
        			<a href="javascript:;">门店资金</a>
        			<span>></span>
        			<a href="javascript:;">资金管理</a>
        		</div>
	        	<!--面包屑导航结束-->
	        	<!--返单记录开始-->
	        	<div class="repeatOrder">
	        		<div class="orderL">
	        			<p class="tit">我的余额</p>
	        			<p class="money"><?php echo $a_view_data['store']['store_balance']; ?></p>
	        			<div class="cashSurplus">
	        				<div class="surPic">
	        					<div id="processingbar" class="processingbar"><font>40%</font></div>
	        				</div>
	        				<div class="surNum">
	        					<p class="xian">现金盈余</p>
	        					<p class="yuan xianjin"><?php echo $a_view_data['store']['store_balance']; ?></p>
	        				</div>
	        			</div>
	        			<div class="cashSurplus integral">
	        				<div class="surPic">
	        					<div id="processingbar2" class="processingbar"><font>80%</font></div>
	        				</div>
	        				<div class="surNum">
	        					<p class="xian">积分盈余</p>
	        					<p class="yuan jifen"><?php echo $a_view_data['store']['store_score']; ?></p>
	        				</div>
	        			</div>
	        			<div class="takeCash">
	        				<a href="javascript:;">提现</a>
	        			</div>
	        		</div>
	        		<div class="orderR">
	        			<p class="h3">近期抢单积返记录</p>
	        			<div class="integralBox clearfix">
	        				<div id="main" style="width: 840px;height:200px; margin-top: -25px;"></div>
	        			</div>
	        			<div class="summaryBox">
	        				<ul>
	        					<li>
	        						<p class="wen">累积现金盈利</p>
	        						<p class="shu"><?php echo $a_view_data['store']['accumulate_money']; ?></p>
	        					</li>
	        					<li>
	        						<p class="wen">累积积分盈利</p>
	        						<p class="shu"><?php echo $a_view_data['store']['accumulate_score']; ?></p>
	        					</li>
	        					<li>
	        						<p class="wen">累积现金提现</p>
	        						<p class="shu"><?php echo $a_view_data['store']['mony_withdraw']; ?></p>
	        					</li>
	        					<li>
	        						<p class="wen">累积积分提现</p>
	        						<p class="shu"><?php echo $a_view_data['store']['score_withdraw']; ?></p>
	        					</li>
	        				</ul>
	        			</div>
	        		</div>
	        	</div>
	        	<!--返单记录结束-->
	        	<!--表格模块开始-->
	        	<div class="tableModule">
	        		<!--交易记录开始-->
	        		<div class="dealBox">
	        			<p class="jiaoyi">交易记录</p>
	        			<div class="nearTime">
	        				<div class="timeL">
	        					<span class="shijian">时间：</span>
	        					<div class="time">
	        						<input type="text" id="test1" placeholder="<?php if($a_view_data['btime'] == 9){ echo '2017-11-11'; } else { echo date('Y-m-d',$a_view_data['btime']); } ?>">
	        						<span class="heng">-</span>
	        						<input type="text" id="test2" placeholder="<?php if($a_view_data['etime'] < 10){ echo date('Y-m-d'); } else { echo date('Y-m-d',$a_view_data['etime']); } ?>">
	        					</div>
	        				</div>
	        				<div class="timeR">
	        					<span class="zuijin">最近：</span>
	        					 <div class="close">
	        					 	<a href="balance_showlist-9-9-9" <?php if ($a_view_data['etime'] == 9) { echo 'class="current"'; } ?>>全部</a>
	        					 	<a href="balance_showlist-9-9-1" <?php if ($a_view_data['etime'] == 1) { echo 'class="current"'; } ?>>1个月</a>
	        					 	<a href="balance_showlist-9-9-3" <?php if ($a_view_data['etime'] == 3) { echo 'class="current"'; } ?>>3个月</a>
	        					 	<a href="balance_showlist-9-9-6" <?php if ($a_view_data['etime'] == 6) { echo 'class="current"'; } ?>>6个月</a>
	        					 </div>
	        				</div>
	        			</div>
	        		</div>
	        		<!--交易记录结束-->
	        		<!--变动事项开始-->
	        		<div class="changeBox">
	        			<span class="bian">变动事项：</span>
	        			<div class="shi">
	        				<a href="balance_showlist-9" <?php if ($a_view_data['type'] == 9) { echo 'class="current"'; } ?> >全部</a>
	        				<a href="balance_showlist-1" <?php if ($a_view_data['type'] == 1) { echo 'class="current"'; } ?> >进账</a>
    					 	<a href="balance_showlist-2" <?php if ($a_view_data['type'] == 2) { echo 'class="current"'; } ?> >出账</a>
	        			</div>
	        		</div>
	        		<!--变动事项结束-->
	        		<!--表格列表开始-->
	        		<div class="tableBox">
	        			<ul>
	        				<li class="thead">
	        					<span>日期</span>
	        					<span>变动事项</span>
	        					<span>变动数目</span>
	        					<span>现金盈余</span>
	        					<span>积分盈余</span>
	        					<span>备注</span>
	        				</li>
	        				<?php foreach ($a_view_data['balance'] as $key => $value): ?>
	        				<li class="row">
	        					<span><?php echo date('Y-m-d H:i:s',$value['balance_time']); ?></span>
	        					<span><?php echo $value['balance_item']; ?></span>
	        					<span><?php if ($value['balance_type']==1) { echo '+'.$value['balance_number']; } else { echo '-'.$value['balance_number']; } ?></span>
	        					<span><?php echo $value['balance_remain']; ?></span>
	        					<span><?php echo $value['score_remain']; ?></span>
	        					<span><?php echo $value['balance_description']; ?></span>
	        				</li>
	        				<?php endforeach ?>
	        			</ul>

	        		</div>
	        		<!--表格列表结束-->
	        	</div>
	        	<!--表格模块结束-->
	        	<!--分页开始-->
	        	<div class="page">
					<?php echo $this->pages->link_style_one($this->router->url('balance_showlist-'.$a_view_data['type'].'-'.$a_view_data['btime'].'-'.$a_view_data['etime'].'-', [], false, false)); ?>
		            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
	        	</div>
	        	<!--分页结束-->
	        </div>
	        <!--右边内容结束-->
	        <!--资金提取弹框开始-->
	        <div class="editBomb">
	        	<div class="h2">
	        		<span class="title">资金提现</span>
	        		<a href="javascript:;" class="close"></a>
	        	</div>
	        	<!--表单开始-->
	        	<div class="formBox">
	        		<form id="withdrawform" action="balance_withdraw" method="post">
	        			<ul>
	        				<li class="cashLi tot">
	        					<span class="left">现金提取</span>
	        					<div class="right">
	        						<input type="text" name="balance_number" class="input accountInt" placeholder="可提现金<?php echo $a_view_data['store']['store_balance']; ?>" />
	        						<span class="red"><em></em><s class="wen">还没输入提现数目</s></span>
	        					</div>
	        				</li>
	        				<li class="integralLi">
	        					<span class="left">积分提现</span>
	        					<div class="right">
	        						<input type="text" name="balance_score" class="input nameInt" placeholder="可提取积分<?php echo $a_view_data['store']['store_score'];?>"/>
	        						<span class="red"><em></em><s class="wen">还没输入提现数目</s></span>
	        					</div>
	        				</li>
	        				<li class="sex wayLi tot">
	        					<span class="left">提取方式</span>
	        					<div class="right">
	        						<span class="boy">
	        							<input type="radio" name="withdraw_type" class="sexItn" name="sex" id="sex" value="1" />
	        							<label for="sex" class="pattern ding1">支付宝</label>
	        							<input type="radio" name="withdraw_type" class="sexItn" name="sex" id="sex2"  value="2" />
	        							<label for="sex2" class="pattern ding2">银行卡</label
	        						</span>
	        						<span class="red"><em></em><s class="wen">请选择提现方式</s></span>
	        					</div>
	        				</li>
	        				<li class="passLi tot">
	        					<span class="left">提现密码</span>
	        					<div class="right">
	        						<input type="password" name="store_password" autocomplete="off" class="input phoneInt" placeholder="请输入提现密码" />
	        						<span class="red"><em></em><s class="wen">请输入提现密码</s></span>
	        					</div>
	        				</li>
	        			</ul>
	        			<div class="sureBox">
	        				<a href="javascript:;">确定</a>
	        			</div>
	        		</form>
	        	</div>
	        	<!--表单结束-->
	        </div>
	        <!--资金提取弹框结束-->
	        <!-- 未设置提现银行卡弹框开始-->
	        <div class="delePart bankBomb">
	        	<a href="javascript:;" class="close"></a>
	        	<p>重要提示</p>
	        	<p>*还没设置提现银行卡设置？</p>
	        	<p>*请在门店设置-提现账户先设置银行卡账户再申请提现</p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">再看看</a>
	        	</div>
	        </div>
	        <!--未设置提现银行卡弹框结束-->
	        <!-- 未设置提现支付宝弹框开始-->
	        <div class="delePart alipayBomb">
	        	<a href="javascript:;" class="close"></a>
	        	<p>重要提示</p>
	        	<p>*还没设置提现支付宝设置？</p>
	        	<p>*请在门店设置-提现账户先设置支付宝账户再申请提现</p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">再看看</a>
	        	</div>
	        </div>
	        <!--未设置提现支付宝弹框结束-->
	        <!-- 申请成功弹框开始-->
	        <div class="delePart successBomb">
	        	<a href="javascript:;" class="close"></a>
	        	<p>重要提示</p>
	        	<p>*申请提现成功</p>
	        	<p>*将在三个工作日内为你办理，请注意查收</p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">好的</a>
	        	</div>
	        </div>
	        <!--申请成功弹框结束-->
	</body>
	<!--日期引入开始-->
	<script type="text/javascript">
		var btime = <?php if($a_view_data['btime'] == 9) { echo mktime(0, 0, 0, date(11), date(11), date(2017)); } else { echo $a_view_data['btime']; }; ?>;
		var etime = <?php if($a_view_data['etime'] < 10) { echo time(); } else { echo $a_view_data['etime']; } ?>;
		layui.use('laydate', function(){
		  var laydate = layui.laydate;
		  laydate.render({
		    elem: '#test1',
		    value: '',
		  	done: function(value, date, endDate){
			    console.log(value); //得到日期生成的值，如：2017-08-18
				btime = Date.parse(new Date(value));
				btime = btime / 1000;
		  	}
		  })
		  laydate.render({
		    elem: '#test2',
		    value: '',
		  	done: function(value, date, endDate){
			    console.log(value); //得到日期生成的值，如：2017-08-18
				etime = Date.parse(new Date(value));
				etime = etime / 1000;
				window.location.href = "balance_showlist-9-" + btime + '-' + etime;
		  	}
		  })
		});
	</script>
	<!--日期引入结束-->
	<!--echarts引入开始-->
	<script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));
        // 指定图表的配置项和数据
		var option = {
		    color: ['#e6e6e6'],
		    tooltip : {
		        trigger: 'axis',
		        backgroundColor:'white',
		        borderColor:'#eeeeee',
		        borderWidth:'1',
		        textStyle:{
		        	color:'#333333',
		        	fontSize:'12'
		        },
		        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
		            type : 'line',      // 默认为直线，可选为：'line' | 'shadow'
		            lineStyle:{
		            	color:'#cacaca',
		            }
		        }
		    },
		    grid: {
		        left: '3%',
		        right: '4%',
		        bottom: '3%',
		        containLabel: true
		    },
		    xAxis : [
		        {
		            type : 'category',
		            data : [
		            	<?php foreach ($a_view_data['myscore'] as $key => $value) {
		            		echo '"'.date('m-d', $value['sc_time']).'",';
		            	} ?>
		            ],
		            //data : ['10-20','10-20','10-20','10-20','10-20','10-20','10-20','10-20','10-19','10-19','10-19','10-19'],
		            axisTick: {
		                alignWithLabel: true
		            },
		            splitLine:{
                        show:false
                    },
                    axisLabel:{
                        textStyle:{
                            color:'#999999',
                            fontSize:10
                        }
                    },
                    axisLine:{
                        lineStyle:{
                            color: "#ededed"
                        }
                    }
		        }
		    ],
		    yAxis : [
		        {
		            type : 'value',
		            axisLabel:{
                        textStyle:{
                            color:'#fff',
                            fontSize:10
                        }
                    },
                    splitLine:{
                        show:false,
                    },
                    axisLine:{
                        lineStyle:{
                            color: "#fff"
                        }
                    }
		        }
		    ],
		    series : [
		        {
		            name:'积分',
		            type:'bar',
		            barWidth: '60%',
		            // data:[10,10,10,10,10,10,10,10,10,10,10,23],
		            data:[
		            	<?php foreach ($a_view_data['myscore'] as $key => $value) {
		            		echo $value['sc_score'].',';
		            	} ?>
		            ],
		             //配置样式
		            itemStyle: {
		                //通常情况下：
		                normal:{
		　　　　　　　　　　　　//每个柱子的颜色即为colorList数组里的每一项，如果柱子数目多于colorList的长度，则柱子颜色循环使用该数组
		                    color: function (params){
		                        var colorList = ['#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#e6e6e6','#ed2554'];
		                        return colorList[params.dataIndex];
		                    }
		                },
		                //鼠标悬停时：
		                emphasis: {
		                		//color:'#dedddd',
		                        shadowBlur: 5,
		                        shadowOffsetX: 0,
		                        shadowColor: 'rgba(0, 0, 0, 0.2)'
		                }
		            },
		        }
		    ]
		};
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>
	<!--echarts引入结束-->
</html>
