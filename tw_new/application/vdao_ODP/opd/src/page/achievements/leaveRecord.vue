<template>
	<div class="leaveRecord">
		<div class="task_details_header">
			<div class="return_blue"></div>
			<div class="header_text">请假记录</div>
		</div>
		<div class="contact"> 
			<div class="leave"><Button class="leaveButton" @click="toApplyLeave">申请请假</Button></div>
			<Scroll :on-reach-bottom="handleReachBottom" height="600">
				<div class="leaveBox">
					<div class="leaveLabel" v-for="item in record">
						<div class="leaveType" :class="getBgColor(item.is_pass)">{{getStatus(item.absence_status)}}</div>
						<div class="infoBox">
							<div class="info">{{item.absence_desc}}</div>
							<div class="time">{{item.absence_ask_time}}</div>
						</div>
						<div class="timeBox">
							<div class="leaveTime">请假时间：{{item.absence_start_time}} — {{item.absence_end_time}}</div>
							<div class="state">状态：
								<span :class="getColor(item.is_pass)">{{getPass(item.is_pass)}}</span>
							</div>
						</div>
						<div class="realName">请假人：{{item.real_name}}</div>
						<div class="btnBox">
							<div class="revoke btn" @click="cancel(item.absence_id)">撤销请假</div>
							<div class="edit btn" @click="edit(item.absence_id)">编辑请假</div>
						</div>
					</div>
					<div v-if="offset == total" style="text-align: center;padding: 20px;">已经到底啦</div>
				</div>
		    </Scroll>
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
				record:[],
				time:null,
			}
		},
		mounted(){
			this.time = this.$route.query.time
			this.getRecord();
		},
		methods:{
			edit(id){
				this.$router.push({
					path: 'applyLeave',
					query: {
						id
					}
				})
			},
			cancel(id){
				var that = this;
				var qs = require('qs');
				let odata = {};
				odata.token = that.$store.state.token;
				odata.absence_id = id;
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.absence_cancle,
					data: qs.stringify(odata) //传参变量
				})
				.then(function(res) {
					if(!res.data.error){
						for(var j=0;j<that.record.length;j++){
	                        if(that.record[j].absence_id == id){
	                            that.record.splice(j,1);//删除修改匹配项
	                            break;
	                        }
	                    }
						that.$Message.success(res.data.msg);
						
					}else{
						that.$Message.error(res.data.msg);
					}
				});
			},
			toApplyLeave(){
				this.$router.push({
					path: 'applyLeave'
				})
			},
			getStatus(status){
				switch(Number(status)){
					case -2:
						return '病假'
						break;
					case -1:
						return '事假'
						break;
					case 0:
						return '调休'
						break;
					case 1:
						return '婚假'
						break;
					case 2:
						return '产假'
						break;
					case 3:
						return '年假'
						break;
				}
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
			getColor(type){
				switch(Number(type)){
					case -1:
						return 'c_pink'
						break;
					case 0:
						return 'c_yellow'
						break;
					case 1:
						return 'c_green'
						break;
				}
			},
			getPass(type){
				switch(Number(type)){
					case -1:
						return '已驳回'
						break;
					case 0:
						return '待审批'
						break;
					case 1:
						return '已批准'
						break;
				}
			},
			getRecord(resolve){
				var that = this;
				var qs = require('qs');
				let odata = {};
				odata.token = that.$store.state.token;
				if(that.time){odata.query_time = that.time;}
				odata.offset = that.offset;
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.absence_records,
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
            }
		}
	}
</script>

<style scoped>
	.contact{
		height: calc(100% - 44px);
	}
	.leaveRecord{
		position: absolute;
		top:0px;
		width: 1090px;
		height: 100%;
		background: #fff;
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
	/*内容*/
	.leave{
		display: flex;
		justify-content: flex-end;
	}
	.leaveButton{
		margin: 10px 60px 18px 0;
		width: 99px;
		height: 40px;
		font-size: 15px;
		border-radius: 5px;
	}
	.leaveLabel{
		font-size: 18px;
		padding: 20px 60px 20px 84px;
		display: flex;
		flex-direction: column;
		justify-content: space-around;
		position: relative;
		border: 1px solid #EEEEEE;
		border-left: 0;
		border-right: 0;
		margin-top: 40px;
	}
	
	.leaveType{
		position: absolute;
		top: -25px;
		width: 99px;
		height: 46px;
		background: #8bc34a;/*同意*/
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
	.infoBox,.timeBox{
		width: 100%;
		display: flex;
		justify-content: space-between;
		align-items: center;
		color: rgba(40,48,51,.6);
	}
	.infoBox .realName{
		color: rgba(40,48,51,.6);
	}
	.infoBox .info{
		font-size: 30px;
		color: #283033;
	}
	.c_green{
		color: #8bc34a;
	}
	.c_pink{
		color: #ff5a6e;
	}
	.c_yellow{
		color: #ffc324;
	}
	.leaveRecord .btnBox{
		margin-top: 20px;
		display: flex;
		justify-content: flex-end;
	}
	.leaveRecord .btnBox .btn{
		width: 82px;
	    height: 40px;
	    border-radius: 20px;
	    font-size: 16px;
	    line-height: 36px;
	    cursor: pointer;
	    border: 1px solid rgba(0,0,0,.4);
	    text-align: center;
	    margin-left: 30px;
	}
	.leaveRecord .btnBox .btn.edit{
        border: 1px solid rgba(255,90,110,.4);
    	color: #ff5a6e;
	}
</style>