<template>
	<div class="sub_eval">
		<div>
	
		<!--***/-->
			<div class="divp_box" v-for="(itek,index) in list_plan">
				<div></div>
				<div class="divp">
					<p>{{itek.my_name}} 回复 {{itek.reply_name}} <span style="font-size: 12px;color: #999;"> {{itek.add_date}} </span></p>
					<div style="display: flex;justify-content: space-between;align-items: baseline;">
						<div style="margin: 20px 0 0 0;border: 1px solid #fff;flex: 0 0 700px; padding:8px 5px;border-radius: 5px;"> {{itek.content}} </div>

						<div style="float: right;" @click="oevales(itek,index)">
							<img src="../../assets/img/reply.png" />
						</div>
					</div>
				
				</div>
			</div>
		
<!--////-->

		<div class="evaluate" v-show="!ishow">
			<div class="evaluate_top">
				<div>
					<textarea ref="postcontent" rows="4" placeholder="请输入" v-model="texte" @click="isshow = true"></textarea>
				</div>
	
			</div>
			<div>
				<button v-show="!isshow">评论</button>
				<button v-show="isshow" @click="oshow(),tijiao()">评论</button>
			</div>
		</div>
	</div>
	</div>
</template>

<script>
		import api from '@/api/api'
	export default {
		props: ['name', 'taskId', 'idsi', 'indexVal', 'ishow', 'divp', 'ksid'],
		data() {
			return {
				token_i: {},
				uploadFileUrls: api.uploadFileUrl,
				task_id: '',
				isshow: false,
				evales: false,
				texte: '',
				defaultList: [],
				file: [],
				loadingStatus: false,
				imgName: '',
				visible: false,
				uploadList: [],
				lists: [],
				list_plan: [],
				id_record: '',
				my_name: '',
				reply_name:'',
				types:'',
			}
		},
		created() {
			this.liset()
		},
		mounted() {
			this.reply_name = this.indexVal.my_name
		},
		methods: {
	
			oshow() {
				let that = this;
				that.isshow = !that.isshow

			},
			oevales(itek, index) {
				let that = this;
					that.id_record = itek.id
					that.my_name = itek.my_name
					that.ishow = !that.ishow
					console.log('abbba',itek)
					console.log('abbba',itek.id)
			
				
			},
			//			
			liset() {
			let that = this;
			let arr = [] 
					for(var i = 0; i < that.divp.length; i++) {
					
						if(that.divp[i].id == that.idsi) {
							that.list_plan = that.divp[i].sub
							
							if(that.divp[i].type){
								  that.types =  that.divp[i].type
								  arr = that.divp[i]
								  that.list_plan  = arr
								  console.log('----111列表',   that.list_plan)
							}
						}
					
					
						
						
					}
					
				

			},
			//			p评论
			tijiao() {
				let that = this;
				
					let value = that.texte
					let oid = '';
					value = value.replace(/(^\s*)|(\s*$)/g, "");
					if(value.length > 0) {
							let josn = {};
						if(that.id_record){
							josn.member_id = this.$store.state.member_id
							josn.content = value
							josn.id = that.id_record 
							josn.rows = 500
									console.log('33333', josn)
							var qs = require('qs');
							that.axios({
									method: 'post',
									headers: {
										"Content-Type": "application/x-www-form-urlencoded"
									},
									url: api.dynamic_save,
									data: qs.stringify(josn) //传参变量
								})
								.then(function(res) {

									console.log('----2111--', res.data.data.reply_name)
									if(res.data.error == 0) {
										console.log('----2111--', res.data.data)
										let item = {};
										item.add_date = res.data.data.record.add_date
										item.my_name = res.data.data.record.my_name
										item.content = res.data.data.record.content
										item.reply_name = res.data.data.record.reply_name
//										item.plan_record_file_data = res.data.data.record.plan_record_file_data
//										item.plan_record_pic_data = res.data.data.record.plan_record_pic_data
										that.list_plan.push(item)
										that.uploadFile = []
										that.uploadList = []
										that.evales = !that.evales
										that.texte = '';
										//								console.log('----211111111111reply_n',that.divp[index].sub)
									} else {
										that.$Message.error(res.data.msg);
												console.log('----22---', res.data.msg)
									}
								})
							
						}else{
						
							josn.member_id = this.$store.state.member_id
							josn.content = value
							
							josn.id = that.idsi
							josn.rows = 500
									console.log('33333', josn)
							var qs = require('qs');
							that.axios({
									method: 'post',
									headers: {
										"Content-Type": "application/x-www-form-urlencoded"
									},
									url: api.dynamic_save,
									data: qs.stringify(josn) //传参变量
								})
								.then(function(res) {

									console.log('----2111--', res.data.data.reply_name)
									if(res.data.error == 0) {
										console.log('----2111--', res.data.data)
										let item = {};
										item.add_date = res.data.data.record.add_date
										item.my_name = res.data.data.record.my_name
										item.content = res.data.data.record.content
										item.reply_name = res.data.data.record.reply_name
//										item.plan_record_file_data = res.data.data.record.plan_record_file_data
//										item.plan_record_pic_data = res.data.data.record.plan_record_pic_data
										that.list_plan.push(item)
										that.uploadFile = []
										that.uploadList = []
										that.evales = !that.evales
										that.texte = '';
										//								console.log('----211111111111reply_n',that.divp[index].sub)
									} else {
										that.$Message.error(res.data.msg);
												console.log('----22---', res.data.msg)
									}
								})
						}
						
						
							
							
						
					} else {
						that.$Message.error('请输入评论');
					}

			},
			
			tok() {
				var op = {}
				var token_ids = this.$store.state.token;
				op = JSON.stringify(token_ids);
				var str1 = JSON.parse(op);
				this.token = str1
				//				this.token_i = JSON.parse(token_id)
			},
		},

	}
</script>

<style>

</style>
<style scoped>
	.sub_eval {
		/*margin-top: 50px;*/
		/*margin-bottom: 200px;*/
	}
	
	.evaluate {
		width: 900px;
		display: flex;
		font-size: 16px;
		margin-top: 30px;
		/*padding-bottom: 50px;*/
		/*align-items: center;*/
		border-bottom: 1px solid #efefef;
	}
	
	.evaluate_top {
		border-radius: 10px;
		padding: 10px;
	}
	
	.evaluate_top>div:nth-child(1) {
		width: 760px;
		border: 1px solid #ddd;
		background: #eee;
		border-radius: 10px;
		overflow: hidden;
		display: flex;
	}
	
	.evaluate_top>div:nth-child(1) textarea {
		flex: 0 0 640px;
		background: #eee;
		padding: 10px;
		resize: none
	}
	
	.evaluate_top>div:nth-child(1)>div {
		flex: 0 0 50px;
		margin-top: 57px;
		text-align: center;
	}
	
	.evaluate_top>div:nth-child(2) {
		margin: 15px 0 0 0;
	}
	
	.evaluate>div:nth-child(2) button {
		border: 0;
		width: 120px;
		height: 50px;
		border-radius: 25px;
		line-height: 50px;
		text-align: center;
		color: #c0c1c2;
		margin-left: 30px;
	}
	
	.evaluate>div:nth-child(2) button:nth-child(1) {
		background: #eee;
	}
	
	.evaluate>div:nth-child(2) button:nth-child(2) {
		color: #fff;
		background: #0ab3e9;
	}
	/*.evaluate_con {
		width: 900px;
		display: flex;
		font-size: 16px;
		align-items: center;
		padding: 50px 0;
		margin: 0px 0 0 80px;
		border-bottom: 1px solid #efefef;
	}
	
	.evaluate_con_img {
		flex: 0 0 80px;
	}
	
	.evaluate_con_img div {
		text-align: center;
	}
	
	.evaluate_con_img img {
		width: 50px;
		height: 50px;
		border-radius: 50%;
	}
	
	.evaluate_con_com {
		flex: 0 0 670px;
	}
	
	.evaluate_con_com div:nth-child(1) {
		font-size: 16px;
		font-weight: 700;
		margin-bottom: 20px;
	}
	
	.evaluate_con_com div:nth-child(1) span {
		padding: 0 0 0 30px;
		font-size: 10px !important;
		color: #868686;
	}
	
	.evaluate_con_com div:nth-child(2) {}
	
	.evaluate_con_p {
		flex: 0 0 150px;
		text-align: center;
	}*/
	/*文件上传*/
	
	.file_blue {
		width: 18px;
		height: 20px;
		display: inline-block;
		background: url(../../assets/img/file_blue.png);
		cursor: pointer;
	}
	
	.fileBox {
		width: 234px;
		height: 53px;
		border-radius: 5px;
		border: 1px solid #aaaaaa;
		background: #ffffff;
		overflow: hidden;
		display: inline-flex;
		justify-content: space-between;
		align-items: center;
		margin-right: 14px;
	}
	
	.file-win {
		width: 53px;
		height: 53px;
		flex-shrink: 0;
		background: url(../../assets/img/win.png);
		margin-right: 14px;
	}
	
	.file-name {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	
	.upload-file .del_image {
		width: 35px;
		height: 35px;
		flex-shrink: 0;
		background: url(../../assets/img/del_img.png);
		margin-left: 14px;
		align-self: flex-start;
	}
	/*图片上传*/
	
	.del_images {
		position: absolute;
		top: 0;
		right: 0;
		width: 35px;
		height: 35px;
		flex-shrink: 0;
		background: url(../../assets/img/del_img.png);
		margin-left: 14px;
		align-self: flex-start;
		z-index: 999;
	}
	/*图片上传*/
	
	.upload-img .demo-upload-list {
		display: inline-block;
		width: 184px;
		height: 133px;
		text-align: center;
		line-height: 60px;
		border-radius: 5px;
		overflow: hidden;
		background: #fff;
		position: relative;
		border: 1px solid #aaaaaa;
		/*box-shadow: 0 1px 1px rgba(0,0,0,.2);*/
		margin-right: 10px;
	}
	
	.upload-img .demo-upload-list img {
		width: 100%;
		height: auto;
	}
	
	.upload-img .demo-upload-list-cover {
		position: absolute;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		text-align: right;
	}
	
	.demo-upload-list-cover i {
		color: #fff;
		font-size: 20px;
		cursor: pointer;
	}
	
	.upload-img .del_image {
		width: 35px;
		height: 35px;
		display: inline-block;
		background: url(../../assets/img/del_img.png);
	}
	
	.image_blue {
		width: 22px;
		height: 20px;
		display: inline-block;
		background: url(../../assets/img/image_blue.png);
	}
	/*回复*/
	/*.divp_box_div{
	
		
		margin-top: 20px;
		border-radius: 10px;
	}*/
	
	.divp_box {
		width: 780px;
		margin: 0 auto;
		padding: 0px 0px 0 0px;
	}
	
	.divp_box>div:nth-child(1) {
		width: 0;
		height: 0;
		margin-left: 30px;
		border-width: 8px;
		border-style: solid;
		border-color: transparent transparent #eee transparent;
	}
	
	.divp {
		padding: 15px;
		border-radius: 10px;
		background: #eee;
		/*border-radius: 15px;*/
	}
	
	.del_file {
		display: flex;
		flex-wrap: wrap;
	}
	
	.del_file div {
		margin-top: 20px;
		margin-right: 20px;
	}
</style>
<style>
	.ivu-upload-drag {
		border: none;
		background: none;
	}
	
	.ivu-upload-drag:hover {
		border: none;
	}
</style>