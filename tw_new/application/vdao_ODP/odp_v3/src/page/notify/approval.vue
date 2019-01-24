<template>
	<div class="approval">
		<div class="tit_box">
			<ul class="tit_box_ul">
				<li @click="message" >系统通知</li>
				<li @click="allNoti">公告通知</li>
				<li class="tit_box_li">代办审批</li>
			</ul>
		</div>
		<div class="leaveRecord">
		<div class="task_details_header">
			<div class="return_blue"></div>
			<div class="header_text">审批记录</div>
		</div>
		<div class="content">
			<Scroll :on-reach-bottom="handleReachBottom" height="600">
				<div class="leaveBox">
					<div class="leaveLabel" v-for="item in record">
						<div class="leaveType" :class="getBgColor(item.is_pass)">{{item.absence_status}}</div>
						<div class="left">
							<div class="nameBox">
								<div class="name" :class="item.is_pass == 0 ? 'new' : ''">{{item.real_name}}</div>
								<div class="time">{{item.absence_ask_time}}</div>
							</div>
							<div class="infoBox">
								<div class="info">{{item.absence_desc}}</div>
							</div>
						</div>
						<!--未审批，可操作-->
						<div v-if="item.is_pass == '0'" class="right pointer">
							<div class="btn b_pink" @click="updateRecord(item.absence_id,-1)">驳回</div>
							<div class="btn b_blue" @click="updateRecord(item.absence_id,1)">同意</div>
							<div class="jiantou" @click="toDetails(item.absence_id)">
								<img src="@/assets/img/right.png" alt="" />
							</div>
						</div>
						<!--已审批，不可操作-->
						<div v-else class="right">
							<div class="btn" :class="item.is_pass  == '-1' ? 'b_pink' : ''">
								{{item.is_pass == '-1' ? '已驳回' : '驳回'}}
							</div>
							<div class="btn b_blue" :class="item.is_pass  == '-1' ? 'b_gray' : ''">
								{{item.is_pass == '1' ? '已同意' : '同意'}}
							</div>
							<div class="jiantou" @click="toDetails(item.absence_id)">
								<img src="@/assets/img/right.png" alt="" />
							</div>
						</div>
					</div>
					<div v-if="offset == total" style="text-align: center;padding: 20px;">已经到底啦</div>
				</div>
			</Scroll>
		</div>
	</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default{
		data(){
			return{
				offset:0,
				total:0,
				record:[]
			}
		},
		mounted(){
			this.getRecord();
		},
		methods:{
			message(){
				let that = this;
				that.$router.push({
					path: 'systemNoti'
				})
			},
			allNoti(){
				let that = this;
				that.$router.push({
					path: 'allNoti'
				})
			},
			toDetails(absence_id){
				this.$router.push({
					path: 'approvalDetails',
					query: {
						absence_id
					}
				})
			},
			getRecord(resolve){
				var that = this;
				var qs = require('qs');
				let odata = {};
				odata.token = that.$store.state.token;
				odata.is_todo = 1;
				odata.offset = that.offset;
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.todo_approval,
					data: qs.stringify(odata) //传参变量
				})
				.then(function(res) {
					if(!res.data.error){
						var data = res.data.data;
						if(data.list){
							that.offset += data.list.length;//增加偏移量
							that.total = data.count;//统计总数
							that.record = that.record.concat(data.list);
						}
					}else{
						that.$Message.error(res.data.msg);
					}
					if(resolve){
                    	resolve();//一定要返回
					}
				});
			},
			handleReachBottom () {
				if(this.offset != this.total){
					return new Promise(resolve => {
	                	this.getRecord(resolve)
	                });
				}
           },
           updateRecord(id,type){
                var that = this;
				var qs = require('qs');
				let odata = {};
				odata.token = that.$store.state.token;
				odata.absence_id = id;
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
						for(var j=0;j<that.record.length;j++){
	                        if(that.record[j].absence_id == id){
	                            that.record.splice(j,1);//删除修改匹配项
	                            break;
	                        }
	                    }
					}else{
						that.$Message.error(res.data.msg);
					}
				});
            },
           
            getBgColor(type){
				switch(Number(type)){
					case -1:
						return 'bgc_pink'
						break;
					case 0:
						return 'bgc_yellow'
						break;
					case 1:
						return ''
						break;
				}
			},
		}
	}
</script>

<style scoped>
	.approval{
		position: absolute;
		top:0px;
		width: 1090px;
		height: 100%;
		background: #fff;
	}
	/*任务详情头部*/
	
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
	
	.task_details_title {
		/*min-height: 155px;*/
	}
	
	.tit_box {
		position: absolute;
		top: -88px;
		left: 0px;
		height: 85px;
		margin: 0 0 0 50px;
		border-bottom: 1px solid rgba(186, 233, 249, .5);
		z-index: 999;
	}
	
	.tit_box_ul {
		display: flex;
		width: 800px;
		margin: 0 auto;
	}
	
	.tit_box_ul>li {
		text-align: center;
		font-size: 18px;
		width: 160px;
		line-height: 85px;
		height: 85px;
		position: relative;
		z-index: 99;
	}
	
	.tit_box_ul>li:hover:before {
		content: "";
		position: absolute;
		bottom: 0;
		left: 30px;
		height: 2px;
		width: 100px;
		background-color: #0ab3e9;
	}
	.tit_box_li {
		color: #0ab3e9;
	}
	.tit_box_li:before {
		content: "";
		position: absolute;
		bottom: 0;
		left: 30px;
		height: 2px;
		width: 100px;
		background-color: #0ab3e9;
	}
	/*内容*/
	.content{
		margin-top: 43px;
	}
	.leaveLabel{
		font-size: 18px;
		padding: 40px 60px 34px 84px;
		display: flex;
		justify-content: space-between;
		position: relative;
		align-items: center;
		border: 1px solid #EEEEEE;
		border-left: 0;
		border-right: 0;
		margin-top: 60px;
	}
	.leaveType{
		position: absolute;
		top: -23px;
		width: 99px;
		height: 46px;
		background: #8bc34a;
		border: 6px solid #e8f3db;
		border-radius: 23px;
		text-align: center;
	    line-height: 34px;
		font-size: 20px;
		color: #fff;
	}
	.bgc_pink{/*驳回*/
		background: #ff5a6e;
		border-color: #ffdee2;
	}
	.bgc_yellow{/*审批*/
		background: #ffc324;
		border-color: #fbe9bb;
	}
	.left{
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		color: rgba(40,48,51,.6);
		flex: 1;
	}
	.right{
		display: flex;
	}
	.nameBox{
		display: flex;
		align-items: flex-end;
	}
	.nameBox .name{
		position: relative;
		font-size: 30px;
		margin-right: 30px;
	}
	.nameBox .name.new:after{
		content: '';
		display: inline-block;
		height: 10px;
		width: 10px;
		border-radius: 50%;
		background: #ff5a6e;
		position: absolute;
		top: 0;
	}
	.right.pointer .btn{
		cursor: pointer;
	}
	.right .btn{
		width: 67px;
		height: 32px;
		border-radius: 16px;
		border: 1px solid rgba(82,98,105,.6);
		color: rgba(82,98,105,.6);
		line-height: 32px;
		text-align: center;
		font-size: 14px;
		margin: 0 6px;
	}
	.right .btn.b_blue{
		border-color: #0AB2E9;
		color:#0AB2E9;
	}
	.right .btn.b_pink{
		border-color: #ff5a6e;
		color:#ff5a6e;	
	}
	.right .btn.b_gray{
		border-color: rgba(82,98,105,.6);
		color:rgba(82,98,105,.6);	
	}
	.right .jiantou{
		margin-left: 28px;
		width: 30px;
		height: 30px;
		cursor: pointer;
	}
	.right .jiantou img{
		width: 100%;
		height: auto;
	}
</style>