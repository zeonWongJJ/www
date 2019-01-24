<template>
	<div class="achievements">
		<div class="top">
			<div class="avatarBox">
				<div class="avatar">
					<img src="../../assets/img/erweima.png"/> 
				</div>
				<div class="nameBox">
					<p class="name">{{real_name}}</p>
					<p class="job">{{name}}</p>
				</div>
			</div>
			<div class="inquiry">
				<div>
					<span class="inquiryLabel">绩效月历统计</span>
					 <DatePicker type="month" placeholder="选择月份" v-model="time" size="large" style="width: 200px"
					 	 :editable="dateProp.editable" :clearable="dateProp.clearable" @on-change="work" :options="options"></DatePicker>
				</div>
				<div>
					<span class="inquiryLabel">查看他人</span>
				    <Select v-model="department_id" size="large" style="width:200px" @on-change="work">
				        <Option v-for="(item,index) in persons" :value="item.member_id" :key="index">{{ item.real_name }}</Option>
				    </Select>
				</div>
			</div>
		</div>
		<div class="content">
			<div class="row">
				<div class="label">
					<div>出勤天数</div><div>{{work_total_date}}天</div>
				</div>
				<!--<div class="label">
					<div>出勤时间</div><div>{{work_total_time}}小时</div>
				</div>-->
				<div class="label">
					<div>月计划评分</div><div>{{plan_avg_score}}分</div>
				</div>
			</div>
			<div class="row">
				<div class="label grade_num" v-for = "item in grade_num">
					<div>{{item.grade}}</div><div>{{item.num}}个</div>
				</div>
			</div>
		</div>
		<div class="bottom">
			<!--<div class="label" @click="toAttendance">
				<img src="@/assets/img/attendance.png" alt="" />考勤记录
			</div>-->
			<div class="label" @click="toLeaveRecord">
				<img src="@/assets/img/leave.png" alt="" />请假记录
			</div>
			<div class="label" @click="toApproval">
				<img src="@/assets/img/approval.png" alt="" />审批记录
			</div>
			<div class="label" @click="toSign">
				<img v-if="sign" src="@/assets/img/signIn.png" alt=""/>
				<img v-else src="@/assets/img/unSign.png" alt=""/>
				考勤打卡
			</div>
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default {
		data() {
			return {
				options:{
					disabledDate(date){
						return date && date.valueOf() > Date.now() - 86400000;
					}
				},
				department_id:null,
				real_name:this.$store.state.real_name,
				name:this.$store.state.department,
				dateProp:{//日期选择器样式
					editable:false,
					clearable:false,
				},
				persons:[],
				time:null,
				plan_avg_score:'', //月平均计划分
				work_total_date:'',//月考勤天数
				work_total_time:'',//月考勤时间
				grade_num:[], //级别评分
				
				sign:-1//签到权限
			}
		},
		computed:{
		},
		mounted(){
			this.init();
		},
		methods: {
			toAttendance(){
				this.$router.push({
					path: 'attendance'
				})
			},
			toLeaveRecord(){
				var that = this;
				if(that.time){
					that.$router.push({
						path: 'leaveRecord',
						query:{
							time:that.time.getTime()/1000
						}
					})
				}else{
					that.$router.push({
						path: 'leaveRecord'
					})
				}
			},
			toApproval(){
				var that = this;
				if(that.time){
					that.$router.push({
						path: 'approval',
						query:{
							time:that.time.getTime()/1000
						}
					})
				}else{
					that.$router.push({
						path: 'approval'
					})
				}
			},
			//绩效
			work(){
				let that = this;
				var qs = require('qs');
				let odata = {};
				odata.token = that.$store.state.token;
				if(that.person != ''){odata.member_id  = that.department_id;}
				if(that.time != ''){odata.query_time = that.time.getTime()/1000;}
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.work,
					data: qs.stringify(odata) //传参变量
				})
				.then(function(res) {
					if(!res.data.error){
						var data = res.data.data;
						that.plan_avg_score = data.plan_avg_score;
						that.work_total_date = data.work_total_date;
						that.work_total_time = data.work_total_time;
						that.grade_num = data.list;
						if(data.member_info){
							that.real_name = data.member_info.real_name;
							that.name = data.member_info.name;
							that.department_id = data.member_info.member_id;
						}
					}
				});
			},
			
			//签到
			toSign(){
				let that = this;
				if(!that.sign){
					that.getSign();
				}else{
					var qs = require('qs');
					let data = {};
					data.token = that.$store.state.token
					that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.work_sign_in,
						data: qs.stringify(data) //传参变量
					})
					.then(function(res) {
						if(!res.data.error){
							if(res.data.data.status){
								that.$Message.success(res.data.msg);
								that.sign = 0;
							}else{
								that.$Message.error(res.data.msg);
							}
						}else{
							that.$Message.error(res.data.msg);
						}
					});
				}
			},
			//判断签到权限
			getSign(){
				let that = this;
				let data = {};
				var qs = require('qs');
				data.token = that.$store.state.token
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.work_sign,
					data: qs.stringify(data) //传参变量
				})
				.then(function(res) {
					if(!res.data.error){
						if(that.sign !== -1 && res.data.data.is_sign){
							that.$Message.success(res.data.msg);
						}else if(that.sign !== -1 && !res.data.data.is_sign){
							that.$Message.error(res.data.msg);
						}
						that.sign = res.data.data.is_sign;
					}else{
						that.$Message.error(res.data.msg);
					}
				});
			},
			init(){
				let that = this;
				that.department_id = that.$store.state.member_id;
				var qs = require('qs');
				that.work();
				that.getSign();
				//获取用户列表
				let data = {};
				data.token = that.$store.state.token
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.members,
					data: qs.stringify(data) //传参变量
				})
				.then(function(res) {
					if(!res.data.error){
						var data = res.data.data;
						that.persons = data;
					}else{
						that.$Message.error(res.data.msg);
					}

				});
			}
		}
	}
</script>

<style scoped>
	/*top*/
	.top {
		height: 248px;
		background: #0ab3e9;
		display: flex;
		align-items: center;
		padding:0 80px;
		justify-content: space-between;
		margin: 6px 0 0 6px;
	}
	.avatarBox{
		height: 126px;
		color: #fff;
		display: flex;
		align-items: center;
	}
	.avatar{
		width: 126px;
		height: 126px;
		border-radius: 50%;
		overflow: hidden;
	}
	.avatar>img{
		width: 100%;
		height: auto;
	}
	.nameBox{
		margin-left: 28px;
	}
	.name{
		font-size: 30px;
	}
	.job{
		font-size: 18px;
	}
	.inquiry>div{
		display: flex;
		align-items: center;
	}
	.inquiry>div:nth-child(1){
		margin-bottom: 14px;
	}
	.inquiryLabel{
		display: inline-block;
		text-align: end;
		width: 120px;
		color: white;
		margin-right: 18px;
		font-size: 18px;
	}
	/*content*/
	.content{
		padding: 47px 83px 20px;
		border-bottom: 1px solid #f5f5f5;
	}
	.row{
		display: flex;
		flex-wrap:wrap;
	}
	.row .label{
		font-size: 22px;
		display: inline-flex;
		align-items: center;
		flex: 0 0 33%;
		padding: 20px 0;
	}
	.row .label>div{
		flex-shrink:0;
	}
	.row .label:before{
		content: '';
		display: block;
		width: 8px;
		height: 26px;
		background: #ffc324;
		border-radius: 4px;
		margin-right: 15px;
		flex-shrink:0;
	}
	.label.grade_num:before{
		content: '';
		display: inline-block;
		width: 8px;
		height: 26px;
		background: #0ab3e9;
		border-radius: 4px;
	}
	.label>div:nth-child(2){
		margin-left: 30px;
		color: rgba(40,48,51,.5);
	}
	/*bottom*/
	.bottom{
		display: flex;
		padding: 20px 83px;
		justify-content: space-between;
		font-size: 22px;
	}
	.bottom>.label{
		cursor: pointer;
		display: flex;
		align-items: center;
		width: 155px;
		justify-content: space-between;
	}
</style>