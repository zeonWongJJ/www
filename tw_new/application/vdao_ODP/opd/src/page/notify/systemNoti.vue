<template>
	<div class="systNoti">
		<div class="tit_box">
			<ul class="tit_box_ul">
				<li class="tit_box_li">系统通知</li>
				<li @click="allNoti">公告通知</li>
				<li @click="approval">代办审批</li>

			</ul>
		</div>
		
		<Scroll :on-reach-bottom="handleReachBottom" height="600">
			<ul class="mess_box">
				<li v-for="(item,index) in messList">
					<p>
						<span class="messName">{{item.notice_publisher_name}}</span>
						<span class="messTimer">{{item.post_add}}</span>
					</p>
					<div class="dataBox">
						<div class="someDetail" :class="'someDetail'+index">
							<p>{{someDatails(item.connect)}}</p>
							<div class="show_more_details" @click="showAll(index)">展开&nbsp;&nbsp;<Icon type="chevron-down"></Icon></div>
						</div>
						<div class="allDetail" :class="'allDetail'+index">
							<p :class="'em'+index">{{item.connect}}</p>
							<span style="margin-right:36px;" @click="golink(item.belong_id,item.notice_type)">链接</span>
							<span class="show_more_details" @click="closeDown(index)">收起&nbsp;&nbsp;<Icon type="chevron-up"></Icon></span>
						</div>
					</div>
				</li>
			</ul>
			<div v-if="offset == total" style="text-align: center;padding: 20px;">已经到底啦</div>
		</Scroll>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default{
		data(){
			return{
				offset:0,
				total:0,
				messList:[],
				
			}
		},
		mounted(){
			this.insert();
		},
		methods:{
			//标签
			allNoti(){
				let that = this;
				that.$router.push({
					path: 'allNoti'
				})
			},
			approval(){
				let that = this;
				that.$router.push({
					path: 'approvalSV'
				})
			},
			
			//显示隐藏
			showAll(id){
				$(".someDetail"+id).hide();
				$(".allDetail"+id).show();
			},
			closeDown(id){
				$(".someDetail"+id).show();
				$(".allDetail"+id).hide();
			},
			//截取内容
			someDatails(data){
				var len=data.length;
				if( len>100 ){
					len=100;
				}
				return data.slice(0,len);
			},
			//下拉
			handleReachBottom () {
				if(this.offset != this.total){
					return new Promise(resolve => {
	                	this.insert(resolve)
	                });
				}
            },
			insert(resolve){
				var that = this;
				var qs = require('qs');
				let odata = {};
				odata.token = that.$store.state.token;
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.notice_list,
					data: qs.stringify(odata) //传参变量
				})
				.then(function(res) {
					if(!res.data.error){
						var data =res.data.data;
						if(data.list){
							that.offset += data.list.length;//增加偏移量
							that.total = data.count;
							that.messList = that.messList.concat(data.list);
						}
					}else{
						that.$Message.error(res.data.msg);
					}
					if(resolve){
						resolve();
					}
				});
			},
			//跳转链接
			golink(id,type){
				let that = this;
				console.log('系统通知id:'+id+'------'+'类型:'+type);
				if(type == 'bulletin'){
					that.$router.push({
						path: 'notice',
						query: {
							id
						}
					})
				}else if(type == 'task'){
					that.$router.push({
						path: 'task_detail',
						query: {
							task_id:id
						}
					})
				}else{
					that.$router.push({
						path: 'plan_details',
						query: {
							oid_details:id
						}
					})
				}
			}
		}
	}
</script>

<style scoped>
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
	.systNoti{
		height:100%;
		background:white;
	}
	ul.mess_box>li{
		border-bottom: 1px solid #ddd;
	}
	ul.mess_box>li>p>span.messName,
	ul.mess_box>li>p>span.messTimer,
	.dataBox{
		color:#283033;
	}
	ul.mess_box>li>p>span.messName{
		font-size:30px;
	}
	ul.mess_box>li>p>span.messTimer{
		font-size:18px;
	}
	.mess_box>li{
		padding-left:60px;
		padding-top:48px;
		padding-right:158px;
		padding-bottom: 40px;
	}
	.mess_box>li>p:first-child{
		margin-bottom: 20px;
	}
	.mess_box>li>p:first-child>span:nth-child(2){
		margin-left: 34px;
	}
	.dataBox>div{
		line-height:24px;
		font-size:14px;
		color:#283033;
	}
	.dataBox .allDetail span,.dataBox .someDetail .show_more_details{
		cursor: pointer;
		font-size:15px;
		color:#0ab3e9;
	}
	.dataBox .allDetail{
		display: none;
	}
</style>