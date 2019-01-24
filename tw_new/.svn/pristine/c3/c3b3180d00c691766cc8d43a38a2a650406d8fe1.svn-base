<template>
	<div class="header">
		<div class="box">
			<div class="title">
				ODP
			</div>

			<div class="headerTabs">
				<!--<div class="icon"><img src="../../assets/img/search.png" alt="" /></div>-->
				<!--<div class="icon"><img src="../../assets/img/message.png" alt="" /></div>-->
				<Dropdown trigger="hover" @on-click="notify">
					<a class="icon">
						<img src="../../assets/img/message.png" alt="" />
					</a>
					<DropdownMenu slot="list" class="dropMenu">
						<div class="dropTitle">通知</div>
						<template v-if="messageList.length == 0">
							<div class="dropItem" style="text-align: center;">暂无通知</div>
						</template>
						<template v-else>
							<DropdownItem v-for="(item,key) in messageList" :key="key" class="dropItem">
								{{item.connect}}
							</DropdownItem>
						</template>
					</DropdownMenu>
				</Dropdown>
				<div class="headBox">
					<img src="../../assets/img/erweima.png" />
				</div>
				<!--<div class="headBox_img">
					asdf
					<em></em>
				</div>-->
			</div>
		</div>

	</div>
</template>

<script>
	import api from '@/api/api'
	export default {

		data() {
			return {
				messageList: []
			}
		},
		mounted() {
			var that = this;
			var qs = require('qs');
			let odata = {};
			odata.token = that.$store.state.token;
			odata.rows = 100;
			that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.notice_list,
					data: qs.stringify(odata) //传参变量
				})
				.then(function(res) {
					if(!res.data.error) {
						var data = res.data.data;
						$.each(data.list,function(idx,obj){
							if(!obj.have_read){
								that.messageList.push(obj);		
							}
						})
					} else {
						that.$Message.error(res.data.msg);
					}
				});
		},
		methods: {
			
			notify(){
				let that = this;
				that.$router.push({
					path: 'systemNoti'
				})
			},
//			handleOpen() {
//				this.visible = true;
//			},
//			handleClose() {
//				this.visible = false;
//			}

			//  		
			//  			handleSelect(name) {
			//						 bus.$emit("updateOpened","");
			//			 			bus.$emit("updateActiveName","");
			//				this.$router.push(name)
			//			},
			//		heada(){
			//			let that =this;
			//							 bus.$emit("updateOpened",that.active);
			//			 				 bus.$emit("updateActiveName",that.active);
			//				that.$router.push({
			//						path: 'heada'
			//					})
			//				
			//		},
		}
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
	.header {}
	
	.box {
		width:1280px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		color: #0ab3e9;
		height: 90px;
		border-bottom: 1px solid #cef0fb;
		padding: 0 33px;
		background: #cef0fb;
	}
	
	.title {
		font-size: 33px;
	}
	
	.headerTabs {
		display: flex;
		align-items: center;
	}
	
	.headerTabs .icon {
		line-height: 1;
		display: flex;
		align-items: flex-end;
		margin-right: 55px;
	}
	
	.headerTabs .headBox {
		height: 42px;
		width: 42px;
		border-radius: 50%;
		overflow: hidden;
		background: #394044;
	}
	
	.headerTabs .headBox img {
		height: 42px;
		width: 42px;
	}
	
	.header_tab {
		/*position: relative;*/
		/*width: 600px;*/
		/*height: 90px;*/
	}
	
	.headBox_img {
		width: 200px;
		height: 200px;
		position: absolute;
		top: 80px;
		right: 0;
		background: #fff;
		padding: 20px;
		border-radius: 15px;
		z-index: 999;
	}
	
	.headBox_img em {
		width: 0px;
		height: 0px;
		position: absolute;
		top: -20px;
		right: 42px;
		border-width: 10px;
		border-style: solid;
		border-color: transparent transparent red transparent;
		z-index: 999;
	}
	
	.dropMenu {
		max-height: 323px;
		width: 279px;
		overflow-y: auto;
		overflow-x: hidden;
	}
	
	.dropTitle {
		padding: 5px 15px;
		color: #283033;
	}
	
	.dropItem {
		font-size: 14px;
		overflow: hidden;
		text-overflow: ellipsis;
		/*white-space: nowrap;*/
		border-top: 1px solid #eeeeee;
		color: rgba(40, 48, 51, .4);
		 /*display:-webkit-box;
		-webkit-line-clamp:2;
		-webkit-box-orient:vertical;*/
	}
</style>