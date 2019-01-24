<template>
	<div class="attendance">
		<div class="task_details_header">
			<div style="display: flex;">
				<div class="return_blue"></div>
				<div class="header_text">考勤记录</div>
			</div>
			<div class="seleceTime">
				<span>选择时间</span>
				<DatePicker type="month" placeholder="选择月份" v-model="time" size="large"
					 	 :editable="dateProp.editable" :clearable="dateProp.clearable" @on-change="detail()"></DatePicker>
				<!--<DatePicker type="date" placeholder="Select date" v-model="date" size="large"></DatePicker>-->
			</div>
		</div>
		<div class="content">
			<Table size="large" :columns="columns1" :data="data1"></Table>
			<Page :current="offset" :total="total" simple @on-change="detail($event)"></Page>
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default {
		data() {
			return {
				dateProp:{//日期选择器样式
					editable:false,
					clearable:false,
				},
				offset:1,
				total:null,
				time:'',
				
				columns1: [{
						title: '日期',
						key: 'work_date'
					},
					{
						title: '状态',
						key: 'work_status',
						className: 'fontColor'
					},
					{
						title: '上班签到',
						key: 'work_time'
					},
					{
						title: '下班签到',
						key: 'unwork_time'
					}
				],
				data1: []
			}
		},
		mounted(){
			this.detail();
		},
		methods: {
			detail(offset){
				let that = this;
				var qs = require('qs');
				let odata = {};
				odata.token = that.$store.state.token;
				if(offset){that.offset = offset;odata.offset = (offset-1) * 10;}
				if(that.time != ''){odata.query_time = Math.round(new Date(that.time) / 1000);that.offset = 1;}
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.work_detail,
					data: qs.stringify(odata) //传参变量
				})
				.then(function(res) {
					if(!res.data.error){
						var data = res.data.data;
						if(!offset){that.total = Number(data.count)}
						if(data.list){
							for(var i = 0;i < data.list.length; i++){
								var list = data.list[i];
								list.cellClassName = {work_status: that.addColor(list.work_status)}
							}
							that.data1 = data.list
							console.log(data.list);
						}
					}else{
						that.$Message.error(res.data.msg);
					}
				});
			},
			addColor(type){
				switch (type){
					case '早退':
						return 'yellow'
						break;
					case '迟到':
						return 'yellow'
						break;
					case '休息':
						return 'black'
						break;
					case '请假':
						return 'blue'
						break;
					default:
						return 'fontColor'
				}
			}
		}
	}
</script>
<style>
	.ivu-table td.fontColor {
		color: #8bc34a;
	}
	
	.ivu-table td.black {
		color: #283033;
	}
	
	.ivu-table td.yellow {
		color: #ffc324;
	}
	
	.ivu-table td.blue {
		color: #0ab3e9;
	}
	
	.ivu-table td.pink {
		color: #ff5a6e;
	}
</style>
<style scoped>
	.attendance {
		position: absolute;
		top: 0px;
		width: 1090px;
		height: 100%;
		overflow: hidden;
		overflow-y: scroll;
		overflow-x: auto;
	}
	
	.attendance::-webkit-scrollbar-track {
		/*滚动条里面轨道*/
		/*-webkit-box-shadow: inset 0 0 5px #b0c0d0;*/
		border-radius: 10px;
		background: #fff;
	}
	
	.attendance {
		background: #fff;
	}
	
	.task_details_header {
		height: 44px;
		border-bottom: 1px solid rgba(186, 233, 249, .8);
		display: flex;
		align-items: center;
		color: #0ab3e9;
		justify-content: space-between;
	}
	
	.return_blue {
		width: 8px;
		height: 12px;
		background: url(../../assets/img/return_bllue.png);
		margin: 0 7px 0 25px;
	}
	
	.seleceTime {
		display: flex;
		align-items: center;
		margin-right: 30px;
	}
	.seleceTime>span{
		color: #283033;
		margin-right: 24px;	
	}
</style>