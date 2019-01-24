<template>
	<div class="sub_eval">

		<div class="divp_box" v-for="(itek,index) in lists">
			<div></div>
			<div class="divp">
				<p style="font-size: 14px;">{{itek.my_name}} 回复 {{itek.reply_name}} <span style="font-size: 12px;color: #999;"> &nbsp;&nbsp;{{itek.add_date}} </span></p>
				<div style="display: flex;justify-content: space-between;align-items: baseline;">
					<div style="margin: 20px 0 0 0;border: 1px solid #fff;flex: 0 0 700px; padding:8px 5px;border-radius: 5px;font-size: 14px;">
							<pre style="width: 700px;white-space: pre-wrap;word-wrap: break-word;">{{itek.content}}</pre>

					</div>

					<div style="float: right;" @click="oevales(itek,index)">
						<img src="../../assets/img/reply.png" />
					</div>
				</div>
				<!--<div class="del_file">
					<div v-for="itpic in itek.task_record_pic_data">
						<a :href="uploadFileUrls + '/' + itpic" :download="itpic"><img style="width: 80px;" :src="uploadFileUrls + '/' + itpic" /></a>
					</div>
				</div>-->
			</div>
		</div>
		<!--////-->
		<div class="evaluate" v-show="!indexVal">
			<div class="evaluate_top">
				<div>
					<textarea ref="postcontent" rows="3" placeholder="请输入" v-model="texte" @click="isshow = true"></textarea>
					<!--<div>

						<Upload ref="upload" :format="['jpg','jpeg','png']" name='image' :action="imgs" :headers="{ 'x-token' : this.$store.state.token}" :data="token_i" accept="image/jpg,image/jpeg,image/png" :show-upload-list="false" :on-success="handleSuccess" :default-file-list="defaultList" :max-size="2048" :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :before-upload="handleBeforeUpload" multiple type="drag" style="display: inline-block;width:58px;">
							<div style="width: 54px;height:54px;line-height: 54px;border: 1px solid #0ab3e9 ;border-radius: 5px;background: #fff;">
								<Icon type="camera" size="20"></Icon>
							</div>
						</Upload>
						<Modal title="预览" v-model="visible">
							<img :src="this.indexs" alt="" v-if="visible" style="width: 100%" />
						</Modal>
					</div>-->
					<!--<div>

						<Upload name='file' :action="upFile" :on-success="attachmentsSuccess" :headers="{ 'x-token' : this.$store.state.token}" :show-upload-list='false'>
							<Button type="ghost" icon="ivu-icon ivu-icon-upload" style=" font-size: 20px;width: 54px;height:54px;line-height: 40px;border: 1px solid #0ab3e9 ;border-radius: 5px;background: #fff;"></Button>
						</Upload>
					</div>-->
				</div>

				<div>

					<!--图片列表-->
					<!--<div>
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
					</div>-->
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
		props: ['item_p', 'indexVal', 'discuss'],
		data() {
			return {
				//				imgs: api.uploadFileUrl + api.upload_image, //图片接口
				//				imges: [], //图片存储
				//				upFile: api.uploadFileUrl + api.upload_file, //文件接口
				//				uploadFile: [], //文件存储
				//				uploadFiles: [], //文件存储
				//				uploadFileUrls: api.uploadFileUrl,
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
				id_record: '',
				item_discuss_id: '',
				item_member_id: ''
			}
		},
		created() {},
		mounted() {
			this.lists = this.item_p.children_discusses
			//			this.liset()
			//			this.uploadList = this.$refs.upload.fileList;

		},
		methods: {
			oshow() {
				let that = this;
				that.isshow = !that.isshow

			},
			oevales(itek, index) {
				console.log("itemitemitemitem", itek)
				let that = this;
				that.item_discuss_id = itek.discuss_id
				that.item_member_id = itek.member_id
				that.indexVal = !that.indexVal
			},

			//			p评论
			tijiao() {
				let that = this;
				let value = that.texte
				value = value.replace(/(^\s*)|(\s*$)/g, "");
				let josn = {};
				if(that.item_member_id) {
					josn.member_id = that.item_member_id
				} else {

					josn.member_id = that.$store.state.member_id
				}
				
				josn.content = value
				josn.id = that.item_p.id

				josn.discuss_type = that.item_p.discuss_type
				josn.type = that.item_p.type

				if(that.item_discuss_id) {
					josn.discuss_id = that.item_discuss_id
				} else {
						josn.discuss_id = that.item_p.discuss_id

				}
				josn.rows = 999
				var qs = require('qs');
				that.axios({
						method: 'post',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						url: api.plan_discuss,
						data: qs.stringify(josn) //传参变量
					})
					.then(function(res) {

						if(res.data.error == 0) {
							let item = {};
							item.content = res.data.data.discuss.content
							item.reply_name = res.data.data.discuss.reply_name
							item.my_name = res.data.data.discuss.my_name
							item.reply_id = res.data.data.discuss.reply_id
							item.parent_id = res.data.data.discuss.parent_id
							item.add_date = res.data.data.discuss.add_date
							item.discuss_id = res.data.data.discuss.discuss_id

							if(that.lists == undefined) {
								let arr = []
								arr.push(item);
								that.lists = arr
							} else {
								that.lists.push(item)

							}
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

				//				if(value.length > 0) {
				//					if(that.id_record) {
				//						let josn = {};
				//						josn.task_id = this.taskId //
				//						josn.member_id = this.$store.state.member_id
				//						josn.task_record_desc = that.texte
				//						josn.task_record_id = that.id_record //
				//						josn.task_record_type = that.type
				//						josn.department = that.department
				//						josn.task_record_file = that.uploadFiles // 文件
				//						josn.task_record_pic = that.imges //  图片
				//						josn.rows = 999
				//						var qs = require('qs');
				//						that.axios({
				//								method: 'post',
				//								headers: {
				//									"Content-Type": "application/x-www-form-urlencoded"
				//								},
				//								url: api.plan_discuss,
				//								data: qs.stringify(josn) //传参变量
				//							})
				//							.then(function(res) {
				//								console.log('----21111111111111111111111111111122222--', res)
				//								if(res.data.error == 0) {
				//									let item = {};
				//									item.task_record_desc = res.data.data.record.task_record_desc
				//									item.reply_name = res.data.data.record.reply_name
				//									item.my_name = res.data.data.record.my_name
				//									item.task_record_id = res.data.data.record.my_name.task_record_id
				//									item.task_record_add_date = res.data.data.record.task_record_add_date
				//									item.task_record_file_data = res.data.data.record.task_record_file_data
				//									item.task_record_pic_data = res.data.data.record.task_record_pic_data
				//
				//									that.lists.push(item)
				//									that.uploadFile = []
				//									that.uploadList = []
				//									that.evales = !that.evales
				//									that.texte = '';
				//									//								console.log('----211111111111reply_n',that.divp[index].sub)
				//								} else {
				//									that.$Message.error(res.data.msg);
				//									//								console.log('----22---', res.data.msg)
				//								}
				//							})
				//					} else {
				//						let josn = {};
				//						josn.task_id = this.taskId //
				//						josn.member_id = this.$store.state.member_id
				//						josn.task_record_desc = that.texte
				//						josn.task_record_id = that.idsi //
				//						josn.task_record_type = that.type
				//						josn.department = that.department
				//						josn.task_record_file = that.uploadFiles // 文件
				//						josn.task_record_pic = that.imges //  图片
				//						josn.rows = 150
				//						var qs = require('qs');
				//						that.axios({
				//								method: 'post',
				//								headers: {
				//									"Content-Type": "application/x-www-form-urlencoded"
				//								},
				//								url: api.task_department_records_insert,
				//								data: qs.stringify(josn) //传参变量
				//							})
				//							.then(function(res) {
				//
				//								console.log('----2aaaaaaa111111122222--', res)
				//								if(res.data.error == 0) {
				//									let item = {};
				//									item.task_record_desc = res.data.data.record.task_record_desc
				//									item.reply_name = res.data.data.record.reply_name
				//									item.my_name = res.data.data.record.my_name
				//									item.task_record_add_date = res.data.data.record.task_record_add_date
				//									item.task_record_file_data = res.data.data.record.task_record_file_data
				//									item.task_record_pic_data = res.data.data.record.task_record_pic_data
				//										that.lists.push(item)
				//									that.uploadFile = []
				//									that.uploadList = []
				//									that.evales = !that.evales
				//									that.texte = '';
				//									//								console.log('----211111111111reply_n',that.divp[index].sub)
				//								} else {
				//									that.$Message.error(res.data.msg);
				//									//								console.log('----22---', res.data.msg)
				//								}
				//							})
				//
				//					}
				//
				//				} else {
				//					that.$Message.error('请输入评论');
				//				}
			},
			//文件
			//			attachmentsSuccess(val, file) {
			//				let that = this;
			//				//				file.url = val.data.path;
			//				file.name = val.data.source_name;
			//				//				console.log(val)
			//				that.uploadFiles.push(val.data.path)
			//				that.uploadFile.push(val.data.source_name)
			//
			//			},
			//			handleFormatError(file) {
			//				this.$Notice.warning({
			//					title: '文件格式不正确',
			//					desc: '文件 ' + file.name + ' 格式不正确，请上传 jpg 或 png 格式的图片。'
			//				});
			//			},
			//			handleMaxSize(file) {
			//				this.$Notice.warning({
			//					title: '超出文件大小限制',
			//					desc: '文件 ' + file.name + ' 太大，不能超过200M。'
			//				});
			//			},
			//			handleBeforeUpload() {
			//				const check = this.uploadList.length < 10;
			//				if(!check) {
			//					this.$Notice.warning({
			//						title: '最多只能上传 10 张图片.'
			//					});
			//				}
			//				return check;
			//			},
			//			//图片上传
			//
			//			handleView(item) {
			//				this.indexs = item.url;
			//				this.visible = true;
			//			},
			//			handleRemove(file) {
			//				const fileList = this.$refs.upload.fileList;
			//				this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
			//				this.imges.splice(file, 1)
			//
			//			},
			//			o_remove(file) {
			//				const fileList = this.$refs.upload.fileList;
			//				//				this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
			//				this.uploadFile.splice(file, 1)
			//			},
			//			handleSuccess(res, file) {
			//				let that = this;
			//				console.log(res)
			//				file.url = api.uploadFileUrl + '/' + res.data.path;
			//				file.name = '';
			//				that.imges.push(res.data.path)
			//
			//			},
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