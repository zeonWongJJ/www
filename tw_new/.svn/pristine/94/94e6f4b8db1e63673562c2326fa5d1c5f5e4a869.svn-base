<template>
	<div class="approvalDetails">
		<div class="task_details_header">
			<div class="return_blue"></div>
			<div class="header_text">审批详情</div>
		</div>
		<div class="details">
			<div>请假人&nbsp;&nbsp;&nbsp;<span>{{details.real_name}}</span></div>
			<div>请假类型<span>{{details.absence_status}}</span></div>
			<div>申请时间<span>{{details.absence_ask_time}}</span></div>
			<div>请假时间<span>{{details.absence_start_time}}——{{details.absence_end_time}}</span></div>
			<div>请假原因<span>{{details.absence_desc}}</span></div>
		</div>
		<div class="btnBox" v-if="details.is_pass == '0'">
			<div class="btn bgc_blue" @click="updateRecord(1)">同意</div>
			<div class="btn" @click="updateRecord(-1)">驳回</div>
		</div>
		<div class="btnBox pass" v-else>
			<div class="btn" :class="details.is_pass == 1 ? 'bgc_blue' : ''">{{details.is_pass == 1 ? '已同意' : '同意'}}</div>
			<div class="btn" :class="details.is_pass == 1 ? '' : 'bgc_gray'">{{details.is_pass == 1 ? '驳回' : '已驳回'}}</div>
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default{
		data(){
			return{
				details:{
				},
				absence_id:null,
			}
		},
		mounted(){
			this.absence_id = this.$route.query.absence_id;
			this.getRecord();
		},
		methods:{
			getRecord(){
				if(this.absence_id){
					var that = this;
					var qs = require('qs');
					let odata = {};
					odata.token = that.$store.state.token;
					odata.absence_id  = that.absence_id;
					that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.approval_detail,
						data: qs.stringify(odata) //传参变量
					})
					.then(function(res) {
						if(!res.data.error){
							that.details = res.data.data.list;
						}else{
							that.$Message.error(res.data.msg);
						}
					});
				}
			},
			updateRecord(type){
				var that = this;
				var qs = require('qs');
				let odata = {};
				odata.token = that.$store.state.token;
				odata.absence_id = that.absence_id;
				odata.is_pass = type;
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.approval_update,
					data: qs.stringify(odata) //传参变量
				})
				.then(function(res) {
					if(!res.data.error){
						that.$Message.success(res.data.msg);
						that.details.is_pass = type;
					}else{
						that.$Message.error(res.data.msg);
					}
				});
			}
		}
	}
</script>

<style scoped>
	.approvalDetails{
		background: #fff;
		font-size: 18px;
		position: absolute;
		top:0px;
		width: 1090px;
		height: 100%;
	}
	/*头部*/
	.task_details_header {
		height: 44px;
		border-bottom: 1px solid rgba(186, 233, 249, .8);
		display: flex;
		align-items: center;
		color: #0ab3e9;
	}
	.return_blue {
		width: 8px;
		height: 12px;
		background: url(../../assets/img/return_bllue.png);
		margin: 0 7px 0 25px;
	}
	
	.details{
		padding-top: 34px;
	}
	.details>div{
		border: 1px solid #eeeeee;
		border-left: none;
		border-right: none;
		margin-bottom: 16px;
		padding: 26px 46px;
		color: rgba(40,48,51,.85);
	}
	.details>div>span{
		margin-left: 57px;
		color: #283033;
	}
	.btnBox{
		display: flex;
		margin: 104px 0 0 46px;
	}
	.btnBox .btn{
		width: 228px;
		height: 63px;
		border: 1px solid rgba(0,0,0,.2);
		border-radius: 31.5px;
		line-height: 63px;
		text-align: center;
		font-size: 24px;
		margin: 0 22px;
		cursor: pointer;
	}
	.btnBox .btn.bgc_blue{
		background: #0ab3e9;
		color: #fff;
		border: none;
	}
	.btnBox .btn.bgc_gray{
		background: rgba(0,0,0,.2);
		color: #fff;
		border: none;
	}
	.btnBox.pass .btn{
		cursor: default;
	}
</style>