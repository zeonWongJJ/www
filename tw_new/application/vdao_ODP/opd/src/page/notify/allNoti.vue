<template>
	<div class="allNoti">
		<div class="tit_box">
			<ul class="tit_box_ul">
				<li @click="message">系统通知</li>
				<li class="tit_box_li">公告通知</li>
				<li @click="approval">代办审批</li>
			</ul>
		</div>
		<div class="content">
			<div class="butt">
				<div class="add" @click="editNoti(0)">发布公告</div>
				<div @click="addBlue(1)" :class="isBlue == 1 ? 'blue' : ''">收到的通知</div>
				<div @click="addBlue(2)" :class="isBlue == 1 ? '' : 'blue'">发起的通知</div>
			</div>
			<div v-show="isBlue == 1">
				<Scroll :on-reach-bottom="handleReachBottom" height="600">
					<div class="label" v-for="item in getNoti">
						<div class="nameBox">
							<div class="name" :class="!item.is_read? 'new' : ''">{{item.bulletin_sponsor_name}}</div>
							<div class="time">{{item.bulletin_post_at}}</div>
						</div>
						<div class="notiTitle">{{item.bulletin_title}}</div>
						<div class="notice">
							<p>{{item.bulletin_content}}</p>
							<div class="btnBox">
								<div class="btn" @click="bulletin_delete(item.id,1)">删除公告</div>
								<div class="btn c_blue" @click="editNoti(item.id)">编辑公告</div>
								<div class="jiantou" @click="notice(item.id)"><img src="../../assets/img/right.png" /></div>
							</div>
						</div>
					</div>
					<div v-if="getoffset == gettotal" style="text-align: center;padding: 20px;">已经到底啦！</div>
				</Scroll>
			</div>
			<div v-show="isBlue == 2">
				<Scroll :on-reach-bottom="handleReachBottom" height="600">
					<div class="label" v-for="item in sendNoti">
						<div class="nameBox">
							<div class="name">{{item.bulletin_sponsor_name}}</div>
							<div class="time">{{item.bulletin_post_at}}</div>
						</div>
						<div class="notiTitle">{{item.bulletin_title}}</div>
						<div class="notice">
							<p>{{item.bulletin_content}}</p>
							<div class="btnBox">
								<div class="btn" @click="bulletin_delete(item.id,2)">删除公告</div>
								<div class="btn c_blue" @click="editNoti(item.id)">编辑公告</div>
								<div class="jiantou" @click="notice(item.id)"><img src="../../assets/img/right.png" /></div>
							</div>
						</div>
					</div>
					<div v-if="sendoffset == sendtotal" style="text-align: center;padding: 20px;">已经到底啦！</div>
				</Scroll>
			</div>
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default {
		data() {
			return {
				isBlue: 1,
				getoffset:0,
				gettotal:null,
				sendoffset:0,
				sendtotal:null,
				getNoti:[],
				sendNoti:[]
			}
		},
		mounted(){
			this.bulletin();
		},
		methods: {
			message() {
				let that = this;
				that.$router.push({
					path: 'systemNoti'
				})
			},
			approval(){
				let that = this;
				that.$router.push({
					path: 'approvalSV'
				})
			},
			editNoti(id) {
				let that = this;
				if(id){//编辑任务
					that.$router.push({
						path: 'editNoti',
						query: {
							id
						}
					})
				}else{//发布任务
					that.$router.push({
						path: 'editNoti'
					})
				}
			},
			notice(id){
				this.$router.push({
					path: 'notice',
					query: {
						id
					}
				})
			},
			addBlue(index) {
				this.isBlue = index;
				var type = index;
				var total = this.gettotal;
				if(type == 2){
					total = this.sendtotal;
				}
				if(!total){
					this.bulletin();
                }
			},
			
			//滚动加载更多
			handleReachBottom(){
				var type = this.isBlue;
				var offset = this.getoffset;
				var total = this.gettotal;
				if(type == 2){
					offset = this.sendoffset;
					total = this.sendtotal;
				}
				if(offset != total){
					return new Promise(resolve => {
	                	this.bulletin(resolve);
	                });
                }
			},
			
			//获取公告列表
			bulletin(resolve){
				var that = this;
				var type = that.isBlue;
				var qs = require('qs');
				let odata = {};
				odata.token = that.$store.state.token;
				odata.offset = that.getoffset;
				var oUrl = api.bulletin_received;
				if(type == 2){
					oUrl = api.bulletin_initiated;
					odata.offset = that.sendoffset;
					odata.offset = that.sendoffset;
				}
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: oUrl,
					data: qs.stringify(odata) //传参变量
				})
				.then(function(res) {
					if(!res.data.error){
						var data = res.data.data;
						if(type == 1){
							if(data.list){
								that.getoffset += data.list.length;
								that.gettotal = data.count;
								that.getNoti = that.getNoti.concat(data.list);
							}
						}else{
							if(data.list){
								that.sendoffset += data.list.length;
								that.sendtotal = data.count;
								that.sendNoti = that.sendNoti.concat(data.list);
							}
						}
					}else{
						that.$Message.error(res.data.msg);
					}
					if(resolve){
                    	resolve();//一定要返回
					}
				});
			},
			
			//删除公告
			bulletin_delete(id,type){
				var that = this;
				var qs = require('qs');
				let odata = {};
				odata.token = that.$store.state.token;
				odata.id = id;
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.bulletin_delete,
					data: qs.stringify(odata) //传参变量
				})
				.then(function(res) {
					if(!res.data.error){
						var data = res.data;
						if(type == 1){
							for(var j=0;j<that.getNoti.length;j++){
		                        if(that.getNoti[j].id == id){
		                            that.getNoti.splice(j,1);//删除修改匹配项
		                            break;
		                        }
		                    }
						}else{
							for(var j=0;j<that.sendNoti.length;j++){
		                        if(that.sendNoti[j].id == id){
		                            that.sendNoti.splice(j,1);//删除修改匹配项
		                            break;
		                        }
		                    }
						}
						that.$Message.success(res.data.msg);
					}else{
						that.$Message.error(res.data.msg);
					}
				});
			}
		}
	}
</script>

<style scoped>
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
	
	.content {
		position: absolute;
		top:0px;
		width: 1090px;
		height: 100%;
		overflow: hidden;
		overflow-y: scroll;
		overflow-x: auto;
		background: #fff;
	}
	.content::-webkit-scrollbar-track {
		/*滚动条里面轨道*/
		/*-webkit-box-shadow: inset 0 0 5px #b0c0d0;*/
		border-radius: 10px;
		background: #fff;
	}
	
	.butt {
		padding: 22px 56px;
		display: flex;
		justify-content: flex-end;
		border-bottom: 1px solid rgba(10, 179, 233, .1);
	}
	
	.butt div {
		width: 90px;
		height: 40px;
		line-height: 40px;
		text-align: center;
		font-size: 15px;
		cursor: pointer;
		background: #fff;
		border: 1px solid #d4d6d6;
	}
	
	.butt .add {
		border-radius: 6px;
		margin-right: 26px;
	}
	
	.butt div:nth-child(2) {
		border-radius: 6px 0 0 6px;
		border-right: none;
		/*box-shadow: 0 0 2px #0ab3e9;*/
	}
	
	.butt div:nth-child(3) {
		border-radius: 0 6px 6px 0;
		border-left: none;
		/*color: #fff;*/
	}
	
	.butt .blue {
		background: #0AB2E9;
		color: #fff;
	}
	
	.label {
		padding: 27px 41px 21px 97px;
		border: 1px solid #eeeeee;
		border-left: none;
		border-right: none;
		margin-bottom: 18px;
	}
	
	.label>div {
		display: flex;
	}
	
	.nameBox {
		margin-bottom: 18px;
	}
	
	.nameBox,
	.notice {
		justify-content: space-between;
		align-items: center;
		color: rgba(40, 48, 51, .6);
		font-size: 14px;
	}
	
	.nameBox .time,
	.notiTitle {
		font-size: 18px;
	}
	
	.nameBox .name {
		position: relative;
		color: #283033;
		font-size: 30px;
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
	
	.notice>p {
		width: 623.31px;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	
	.btnBox {
		flex-shrink: 0;
		display: flex;
		align-items: center;
	}
	
	.btnBox .btn {
		width: 82px;
		height: 32px;
		border: 1px solid rgba(40, 48, 51, .6);
		border-radius: 16px;
		line-height: 32px;
		text-align: center;
		cursor: pointer;
	}
	
	.btnBox .btn+.btn {
		margin-left: 12px;
	}
	
	.btnBox .btn.c_blue {
		border-color: #0AB2E9;
		color: #0AB2E9;
	}
	
	.btnBox .jiantou {
		width: 30px;
		height: 30px;
		cursor: pointer;
		margin-left: 30px;
	}
	
	.btnBox .jiantou>img {
		width: 100%;
		height: auto;
	}
</style>