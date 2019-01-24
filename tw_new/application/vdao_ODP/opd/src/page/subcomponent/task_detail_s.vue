<template>
	<div class="sub">
		<div class="evaluate">
			<div class="evaluate_top">
				<div>
					<textarea ref="postcontent" rows="4" placeholder="请输入" v-model="texts" @click="isshow = true"></textarea>
					<div>
						<Upload ref="upload" :format="['jpg','jpeg','png']" name='image' :headers="{ 'x-token' : this.$store.state.token}" :action="imgs" :data="token_i" accept="image/jpg,image/jpeg,image/png" :show-upload-list="false" :on-success="handleSuccess" :default-file-list="defaultList" :max-size="2048" :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :before-upload="handleBeforeUpload" multiple type="drag" style="display: inline-block;width:58px;">
							<div style="width: 54px;height:54px;line-height: 54px;border: 1px solid #0ab3e9 ;border-radius: 5px;background: #fff;">
								<Icon type="camera" size="20"></Icon>
							</div>
						</Upload>
						<Modal title="预览" v-model="visible">
							<img :src="indexs" alt="" v-if="visible" style="width: 100%" />
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
		<!--评论区-->
		<div class="evaluate_box">




<div class="evaluate_con"  v-for="(item,index) in list_plan" :key='index' v-if="list_plan != ''">
				<div class="evaluate_con_img">
				</div>
				<div class="evaluate_con_com">
					<div> <span class="span_con_img"><img src="../../assets/img/erweima.png"/></span>{{item.my_name}} <span>{{item.plan_record_add_date}}</span></div>
					<div>{{item.plan_record_desc}}</div>
					<!--样式-->
					<div class="del_file">
						<div v-for="itfile in item.plan_record_file_data">
							<a :href="uploadFileUrls + '/' +itfile" :download="itfile">{{itfile}}</a>
						</div>

					</div>
					<div class="del_file">
						<div v-for="itpic in item.plan_record_pic_data">
							<a :href="uploadFileUrls + '/' + itpic" :download="itpic"><img style="width: 80px;" :src="uploadFileUrls + '/' + itpic" /></a>
						</div>
					</div>
				</div>
				<div class="evaluate_con_p" @click="oeval(item,index)">
					<img src="../../assets/img/reply.png" />
				</div>
				<div>
					<s-eval :ksid='kid' :name='item.name' :taskId='item.plan_id' :indexVal='index_val' :idsi="item.plan_record_id" :ishow='item.parent_id' :divp='list_plan'></s-eval>
				</div>

			</div>

			<!--任务评价-->
			<div class="evaluate_con" v-if="list != ''" v-for="(item,index) in list" :key='index'>
				<div class="evaluate_con_img">
				</div>
				<div class="evaluate_con_com">
					<div> <span class="span_con_img"><img src="../../assets/img/erweima.png"/></span>{{item.my_name}} <span>{{item.task_record_add_date}}</span></div>
					<div>{{item.task_record_desc}}</div>
					<!--样式-->
					<div class="del_file">
						<div v-for="itfile in item.task_record_file_data">
							<a :href="uploadFileUrls + '/' +itfile" :download="itfile">{{itfile}}</a>
						</div>

					</div>
					<div class="del_file">
						<div v-for="itpic in item.task_record_pic_data">
							<a :href="uploadFileUrls + '/' + itpic" :download="itpic"><img style="width: 80px;" :src="uploadFileUrls + '/' + itpic" /></a>
						</div>
					</div>
				</div>
				<div class="evaluate_con_p" @click="oeval(item,index)">
					<img src="../../assets/img/reply.png" />
				</div>
				<div>
					<s-eval :ksid='kid' :name='item.my_name' :taskId='item.task_id' :indexVal='index_val' :idsi="item.task_record_id" :ishow='item.parent_id' :divp='list'></s-eval>

				</div>

			</div>
			<!--...-->
		</div>
	</div>
</template>

<script>import api from '@/api/api'
import sEval from '@/page/subcomponent/task_detail_s_eval'
export default {
	components: {
		sEval
	},
	props: ["kid"],
	data() {
		return {
			uploadFileUrls: api.uploadFileUrl,
			imgs: api.uploadFileUrl + api.upload_image, //图片接口
			imges: [], //图片存储
			upFile: api.uploadFileUrl + api.upload_file, //文件接口
			uploadFile: [], //文件存储
			uploadFiles: [],
			token_i: {},
			//				task_record_id: '',
			index_val: '',
			isshow: false,
			texts: '',
			divp: [],
			list: [],
			list_plan: [],
			defaultList: [],
			file: [],
			loadingStatus: false,
			imgName: '',
			visible: false,
			uploadList: [],
		}
	},
	created() {
		this.list_pl();
	},
	mounted() {
		//			this.list_pl();
		//			this.isShows()
		this.uploadList = this.$refs.upload.fileList;
	},
	methods: {

		list_pl() {
			let that = this;
			if(this.$route.query.oid_details != undefined) {
				let lists = {};
				lists.token = this.$store.state.token;
				lists.plan_id = this.$route.query.oid_details
				lists.rows = 500
				var qs = require('qs');
				that.axios({
						method: 'post',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						url: api.plan_records,
						data: qs.stringify(lists) //传参变量
					})
					.then(function(res) {
						if(res.data.error == 0) {

							that.list_plan = res.data.data
						} else {
							that.$Message.error(res.data.msg);
						}

					})

			} else {
				let lists = {};
				lists.token = this.$store.state.token;
				lists.task_id = this.kid
				lists.rows = 500
				var qs = require('qs');
				that.axios({
						method: 'post',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						url: api.task_records,
						data: qs.stringify(lists) //传参变量
					})
					.then(function(res) {
							if(res.data.error == 0) {

								that.list = res.data.data
						} else {
							that.$Message.error(res.data.msg);
						}
					

					})
			}

		},
		tijiao() {
			let that = this;
			//计划评价
			if(this.$route.query.oid_details != undefined) {
				let value = that.texts
				value = value.replace(/(^\s*)|(\s*$)/g, "");
				if(value.length > 0) {
					let josn = {};
					josn.token = this.$store.state.token
					josn.plan_id = this.$route.query.oid_details
					josn.plan_record_desc = that.texts
					josn.member_id = this.$store.state.member_id
					josn.plan_record_file = that.uploadFiles // 文件
					josn.plan_record_pic = that.imges //  图片

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
							if(res.data.error == 0) {
									if(that.list_plan == ''){
										that.list_plan = res.data.data.record
									}else{
										
										that.list_plan.push(res.data.data.record)
									}
								
								that.uploadFile = []
								that.uploadList = []
								that.texts = ''
							} else {
								console.log('----22---', res.data.msg)
							}

						})

				} else {
					that.$Message.error('请输入评论');
				}

			} else { //任务评价
				let value = that.texts
				value = value.replace(/(^\s*)|(\s*$)/g, "");

				if(value.length > 0) {
					let josn = {};
					josn.task_id = this.$route.query.task_id
					josn.task_record_desc = that.texts
					josn.member_id = this.$store.state.member_id
					josn.task_record_file = that.uploadFiles // 文件
					josn.task_record_pic = that.imges //  图片
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
//								that.list.push(res.data.data.record)
								if(that.list == ''){
										that.list = res.data.data.record
									}else{
										
										that.list.push(res.data.data.record)
									}
								
								that.uploadFile = []
								that.uploadList = []
								that.texts = ''
							} else {
								that.$Message.error(res.data.msg);
							}

						})

				} else {
					that.$Message.error('请输入评论');
				}
			}

		},
		oshow() {
			let that = this;
			that.isshow = !that.isshow
		},
		oeval(item, index) {
			let that = this;
			item.parent_id = !item.parent_id
			that.list[index].task_record_id_index = item.task_record_id
			that.index_val = index

		},

		//文件
		attachmentsSuccess(val, file) {
			let that = this;
			file.name = val.data.source_name;
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
		//			delFile(idx) {
		//				this.file.splice(idx, 1);
		//			}
	},

}</script>

<style></style>
<style scoped>.sub {
	margin-top: 50px;
	margin-bottom: 200px;
}

.evaluate {
	width: 900px;
	display: flex;
	font-size: 16px;
	margin: 0 0 0 80px;
	padding-bottom: 50px;
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
	resize: none;
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

.evaluate_con {
	width: 900px;
	display: flex;
	font-size: 16px;
	align-items: center;
	flex-wrap: wrap;
	padding: 50px 0;
	margin: 0px 0 0 80px;
	border-bottom: 1px solid #efefef;
}

.evaluate_con_img {
	flex: 0 0 0px;
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
	display: flex;
	align-items: center;
}

.span_con_img {
	margin: 0 15px 0 0 !important;
}

.span_con_img img {
	width: 44px;
	border-radius: 50%;
}

.evaluate_con_com div:nth-child(1) span {
	margin-left: 15px;
	font-size: 10px !important;
	color: #868686;
}

.evaluate_con_com div:nth-child(2) {
	margin-left: 25px;
}

.evaluate_con_p {
	flex: 0 0 150px;
	text-align: center;
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

.upload-file {
	margin-bottom: 8px;
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
	z-index: 9999;
}

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


/*图*/

.demo-upload-list {
	display: inline-block;
	width: 60px;
	height: 60px;
	text-align: center;
	line-height: 60px;
	border: 1px solid transparent;
	border-radius: 4px;
	overflow: hidden;
	background: #fff;
	position: relative;
	box-shadow: 0 1px 1px rgba(0, 0, 0, .2);
	margin-right: 4px;
}

.demo-upload-list img {
	width: 100%;
	height: 100%;
}

.demo-upload-list-cover {
	display: none;
	position: absolute;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0;
	background: rgba(0, 0, 0, .6);
}

.demo-upload-list:hover .demo-upload-list-cover {
	display: block;
}

.demo-upload-list-cover i {
	color: #fff;
	font-size: 20px;
	cursor: pointer;
	margin: 0 2px;
}

.del_file {
	display: flex;
	/*flex-wrap: wrap;*/
}

.del_file div {
	margin-top: 20px;
	margin-right: 20px;
}</style>
<style>.ivu-upload-drag {
	border: none;
	background: none;
}

.ivu-upload-drag:hover {
	border: none;
}

.ivu-upload-input {
	border: 1px solid #eee !important;
}</style>