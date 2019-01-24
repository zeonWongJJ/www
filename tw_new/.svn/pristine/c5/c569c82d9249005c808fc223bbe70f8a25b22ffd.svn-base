<template>
	<div class="sub_eval">
<!--计划-->
		<div v-if="lists_plan != undefined">
			<div class="divp_box" v-for="(itek,ket,index) in lists_plan">
				<div></div>
						<div class="divp">
					<p>{{itek.my_name}} 回复 {{itek.reply_name}} <span style="font-size: 12px;color: #999;"> {{itek.plan_record_add_date}} </span></p>
					<div style="display: flex;justify-content: space-between;align-items: baseline;">
						<div style="margin: 20px 0 0 0;border: 1px solid #fff;flex: 0 0 700px; padding:8px 5px;border-radius: 5px;"> {{itek.plan_record_desc}} </div>

						<div style="float: right;" @click="oevales(itek,index)">
							<img src="../../assets/img/reply.png" />
						</div>
					</div>
					<div class="del_file">
						<div v-for="itfile in itek.plan_record_file_data">
							<a :href="uploadFileUrls + '/' +itfile" :download="itfile">{{itfile}}</a>
						</div>

					</div>
					<div class="del_file">
						<div v-for="itpic in itek.plan_record_pic_data">
							<a :href="uploadFileUrls + '/' + itpic" :download="itpic"><img style="width: 80px;" :src="uploadFileUrls + '/' + itpic" /></a>
						</div>
					</div>
				</div>
		
			</div>
		</div>
		
		<!--任务-->
		<div v-if="lists != undefined">
			<div class="divp_box" v-for="(itek,ket,index) in lists">
				<div></div>
				<div class="divp">
					<p>{{itek.my_name}} 回复 {{itek.reply_name}} <span style="font-size: 12px;color: #999;"> {{itek.task_record_add_date}} </span></p>
					<div style="display: flex;justify-content: space-between;align-items: baseline;">
						<div style="margin: 20px 0 0 0;border: 1px solid #fff;flex: 0 0 700px; padding:8px 5px;border-radius: 5px;"> {{itek.task_record_desc}} </div>

						<div style="float: right;" @click="oevales(itek,index)">
							<img src="../../assets/img/reply.png" />
						</div>
					</div>
					<div class="del_file">
						<div v-for="itfile in itek.task_record_file_data">
							<a :href="uploadFileUrls + '/' +itfile" :download="itfile">{{itfile}}</a>
						</div>

					</div>
					<div class="del_file">
						<div v-for="itpic in itek.task_record_pic_data">
							<a :href="uploadFileUrls + '/' + itpic" :download="itpic"><img style="width: 80px;" :src="uploadFileUrls + '/' + itpic" /></a>
						</div>
					</div>
				</div>
			</div>
		</div>
<!--////-->
		<div class="evaluate" v-show="!ishow">
			<div class="evaluate_top">
				<div>
					<textarea ref="postcontent" rows="4" placeholder="请输入" v-model="texte" @click="isshow = true"></textarea>
					<div>

						<Upload ref="upload" :format="['jpg','jpeg','png']" name='image' :action="imgs" :headers="{ 'x-token' : this.$store.state.token}" :data="token_i" accept="image/jpg,image/jpeg,image/png" :show-upload-list="false" :on-success="handleSuccess" :default-file-list="defaultList" :max-size="2048" :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :before-upload="handleBeforeUpload" multiple type="drag" style="display: inline-block;width:58px;">
							<div style="width: 54px;height:54px;line-height: 54px;border: 1px solid #0ab3e9 ;border-radius: 5px;background: #fff;">
								<Icon type="camera" size="20"></Icon>
							</div>
						</Upload>
						<Modal title="预览" v-model="visible">
							<img :src="this.indexs" alt="" v-if="visible" style="width: 100%" />
						</Modal>
					</div>
					<div>

						<Upload name='file' :action="upFile" :on-success="attachmentsSuccess" :headers="{ 'x-token' : this.$store.state.token}" :show-upload-list='false'>
							<Button type="ghost" icon="ivu-icon ivu-icon-upload" style=" font-size: 20px;width: 54px;height:54px;line-height: 40px;border: 1px solid #0ab3e9 ;border-radius: 5px;background: #fff;"></Button>
						</Upload>
					</div>
				</div>

				<div>
					<div>
						<!--文件列表-->
						<div class="upload-file">
							<div v-if="file !== null">
								<div class="fileBox" v-for="(item,index) in uploadFile">
									<div class="file-win"></div>
									<div class="file-name">{{item}}</div>
									<div class="del_image" @click="o_remove(index)"></div>
								</div>
							</div>
						</div>
					</div>
					<div>
						<!--图片列表-->
						<div class="upload-img">

							<div class="demo-upload-list" v-for="item in uploadList" @click="handleView(item)">
								<template v-if="item.status === 'finished'">
									<img :src="item.url">
							
									<div class="del_images" @click.stop="handleRemove(item)">
									</div>
								</template>
								<template v-else>
									<Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
								</template>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div>
				<button v-show="!isshow">评论</button>
				<button v-show="isshow" @click="oshow(),tijiao()">评论</button>
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
				imgs: api.uploadFileUrl + api.upload_image, //图片接口
				imges: [], //图片存储
				upFile: api.uploadFileUrl + api.upload_file, //文件接口
				uploadFile: [], //文件存储
				uploadFiles: [], //文件存储
				uploadFileUrls: api.uploadFileUrl,
				token_i: {},
				task_id: '',
				member_id: '',
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
				lists_plan: [],
				id_record: '',
				my_name: '',
			}
		},
		created() {
			this.liset()
		},
		mounted() {
			this.uploadList = this.$refs.upload.fileList;

		},
		methods: {
			oshow() {
				let that = this;
				that.isshow = !that.isshow

			},
			oevales(items, index) {
				let that = this;
				//				console.log('----2111--', items)
				if(this.$route.query.oid_details != undefined) {
					that.id_record = items.plan_record_id
					that.my_name = items.my_name
					that.ishow = !that.ishow
					console.log('33333', items.plan_record_id)
					console.log(that.id_record)
					console.log('33333', items.task_record_id)
				} else {
					that.id_record = items.task_record_id
					that.my_name = items.my_name
					that.ishow = !that.ishow
					console.log(that.id_record)
					console.log('333111133', items)
				}

			},
			//			
			liset() {
				let that = this;


				if(this.$route.query.oid_details != undefined) {
					for(var i = 0; i < that.divp.length; i++) {
						if(that.divp[i].plan_record_id == that.idsi) {
							that.lists_plan = that.divp[i].sub
							console.log('----2计划列表', that.divp[i].sub)
						}
					}
				} else {

					console.log(that.divp)
					for(var i = 0; i < that.divp.length; i++) {
						if(that.divp[i].task_record_id == that.idsi) {
							that.lists = that.divp[i].sub
							console.log('----21任务列表', that.divp[i].sub)
						}
					}
				}

			},
			//			p评论
			tijiao() {
				let that = this;
				if(this.$route.query.oid_details != undefined) {
					let value = that.texte
					value = value.replace(/(^\s*)|(\s*$)/g, "");
					if(value.length > 0) {
						if(that.id_record) {
							let josn = {};
							josn.token = this.$store.state.token
							josn.plan_id = this.$route.query.oid_details
							josn.member_id = this.$store.state.member_id
							josn.plan_record_desc = that.texte
							josn.plan_record_id = that.id_record
							josn.plan_record_file = that.uploadFiles // 文件
							josn.plan_record_pic = that.imges //  图片
							josn.rows = 500
							var qs = require('qs');
							that.axios({
									method: 'post',
									headers: {
										"Content-Type": "application/x-www-form-urlencoded"
									},
									url: api.plan_record_insert,
									data: qs.stringify(josn) //传参变量
								})
								.then(function(res) {

									console.log('----2111--', res.data.data)
									if(res.data.error == 0) {
										let item = {};
										item.plan_record_desc = res.data.data.record.plan_record_desc
										item.reply_name = res.data.data.record.reply_name
										item.my_name = res.data.data.record.my_name
										item.plan_record_add_date = res.data.data.record.plan_record_add_date
										item.plan_record_file_data = res.data.data.record.plan_record_file_data
										item.plan_record_pic_data = res.data.data.record.plan_record_pic_data

											that.lists_plan.push(item)
										that.uploadFile = []
										that.uploadList = []
										that.evales = !that.evales
										that.texte = '';
										//								console.log('----211111111111reply_n',that.divp[index].sub)
									} else {
										that.$Message.error(res.data.msg);
										//								console.log('----22---', res.data.msg)
									}
								})
						} else {
							let josn = {};
							josn.plan_id = this.$route.query.oid_details
							josn.member_id = this.$store.state.member_id
							josn.token = this.$store.state.token
							josn.plan_record_desc = that.texte
							josn.plan_record_id = that.idsi
							josn.plan_record_file = that.uploadFiles // 文件
							josn.plan_record_pic = that.imges //  图片

							josn.rows = 500
							console.log('josn2222222', josn)
							var qs = require('qs');
							that.axios({
									method: 'post',
									headers: {
										"Content-Type": "application/x-www-form-urlencoded"
									},
									url: api.plan_record_insert,
									data: qs.stringify(josn) //传参变量
								})
								.then(function(res) {

									console.log('----21111aa--', res)
									if(res.data.error == 0) {
										let item = {};
										item.plan_record_desc = res.data.data.record.plan_record_desc
										item.reply_name = res.data.data.record.reply_name
										item.my_name = res.data.data.record.my_name
										item.plan_record_add_date = res.data.data.record.plan_record_add_date
										item.plan_record_file_data = res.data.data.record.plan_record_file_data
										item.plan_record_pic_data = res.data.data.record.plan_record_pic_data

											that.lists_plan.push(item)
										that.uploadFile = []
										that.uploadList = []
										that.evales = !that.evales
										that.texte = '';
										//								console.log('----211111111111reply_n',that.divp[index].sub)
									} else {
										that.$Message.error(res.data.msg);
										//								console.log('----22---', res.data.msg)
									}
								})
						}

					} else {
						that.$Message.error('请输入评论');
					}

				} 
//				任务
				
				else {
					let value = that.texte
					value = value.replace(/(^\s*)|(\s*$)/g, "");
					if(value.length > 0) {

						if(that.id_record) {
							let josn = {};

							josn.task_id = this.$store.state.task_id
							josn.member_id = this.$store.state.member_id
							josn.token = this.$store.state.token
							josn.task_record_desc = that.texte
							josn.task_record_id = that.id_record
							josn.task_record_file = that.uploadFiles // 文件
							josn.task_record_pic = that.imges //  图片
							josn.rows = 500
							console.log('josn1333333', josn)
							var qs = require('qs');
							that.axios({
									method: 'post',
									headers: {
										"Content-Type": "application/x-www-form-urlencoded"
									},
									url: api.task_record_insert,
									data: qs.stringify(josn) //传参变量
								})
								.then(function(res) {

									if(res.data.error == 0) {
										let item = {};
										item.task_record_desc = res.data.data.record.task_record_desc
										item.reply_name = that.my_name
										item.my_name = res.data.data.record.my_name
										item.task_record_add_date = res.data.data.record.task_record_add_date
										item.task_record_file_data = res.data.data.record.task_record_file_data
										item.task_record_pic_data = res.data.data.record.task_record_pic_data

											that.lists.push(item)
										that.uploadFile = []
										that.uploadList = []
										that.evales = !that.evales
										that.texte = '';
									} else {
										that.$Message.error(res.data.msg);
									}
								})
						} else {
							let josn = {};
							let p
							josn.token = this.$store.state.token
							josn.task_id = this.$store.state.task_id
							josn.member_id = this.$store.state.member_id
							josn.task_record_desc = that.texte
							josn.task_record_id = that.idsi
							josn.task_record_file = that.uploadFiles // 文件
							josn.task_record_pic = that.imges //  图片
							josn.rows = 500
							console.log('josn144444', josn)
							var qs = require('qs');
							that.axios({
									method: 'post',
									headers: {
										"Content-Type": "application/x-www-form-urlencoded"
									},
									url: api.task_record_insert,
									data: qs.stringify(josn) //传参变量
								})
								.then(function(res) {
									console.log('//////////////////', res)
									if(res.data.error == 0) {
										let item = {};
										item.task_record_desc = res.data.data.record.task_record_desc
										item.reply_name = res.data.data.record.reply_name
										item.my_name = res.data.data.record.my_name
										item.task_record_add_date = res.data.data.record.task_record_add_date
										item.task_record_file_data = res.data.data.record.task_record_file_data
										item.task_record_pic_data = res.data.data.record.task_record_pic_data
										console.log('//////////////////', item)

											that.lists.push(item)
										that.uploadFile = []
										that.uploadList = []
										that.evales = !that.evales
										that.texte = '';
										//								console.log('----211111111111reply_n',that.divp[index].sub)
									} else {
										that.$Message.error(res.data.msg);
										//								console.log('----22---', res.data.msg)
									}
								})
						}

					} else {
						that.$Message.error('请输入评论');
					}
				}

			},
			//文件
			attachmentsSuccess(val, file) {
				let that = this;
				//				file.url = val.data.path;
				file.name = val.data.source_name;
				//				console.log(val)
				that.uploadFiles.push(val.data.path)
				that.uploadFile.push(val.data.source_name)

			},
			handleFormatError(file) {
				this.$Notice.warning({
					title: '文件格式不正确',
					desc: '文件 ' + file.name + ' 格式不正确，请上传 jpg 或 png 格式的图片。'
				});
			},
			handleMaxSize(file) {
				this.$Notice.warning({
					title: '超出文件大小限制',
					desc: '文件 ' + file.name + ' 太大，不能超过 200M。'
				});
			},
			handleBeforeUpload() {
				const check = this.uploadList.length < 10;
				if(!check) {
					this.$Notice.warning({
						title: '最多只能上传 10 张图片.'
					});
				}
				return check;
			},
			//图片上传

			handleView(item) {
				this.indexs = item.url;
				this.visible = true;
			},
			handleRemove(file) {
				const fileList = this.$refs.upload.fileList;
				this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
				this.imges.splice(file, 1)

			},
			o_remove(file) {
				const fileList = this.$refs.upload.fileList;
				//				this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
				this.uploadFile.splice(file, 1)
			},
			handleSuccess(res, file) {
				let that = this;
				console.log(res)
				file.url = api.uploadFileUrl + '/' + res.data.path;
				file.name = '';
				that.imges.push(res.data.path)

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