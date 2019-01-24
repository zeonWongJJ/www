<template>
	<div class="sub">
		<div class="tit_box">
			<ul class="tit_box_ul">
				<li class="tit_box_li">日志</li>
				<li @click="doubt">疑问</li>
				<li @click="proposal">建议</li>
				<li @click="bugs">bug</li>
			</ul>
		</div>
		
		<!--评论区-->
		<div class="evaluate_box">
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
					<s-eval :name='item.name' :taskId='task_record_id_index' :indexVal='index_val' :idsi="item.task_record_id" :ishow='item.task_id' :divp='list'></s-eval>
				</div>

			</div>
		
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	import sEval from '@/page/subcomponent/task_detail_s_eval'
	export default {
		components: {
			sEval
		},
		props: ["kid"],
		data() {
			return {
	
			
				uploadFiles: [],
				task_record_id: '',
				task_record_id_index: '',
				index_val: '',
				isshow: false,
				task_id:'',
				department: '',
				texts: '',
				divp: [],
				list: [],
				defaultList: [],
				file: [],
				loadingStatus: false,
				imgName: '',
				visible: false,
				uploadList: [],
			}
		},
		created() {
//			this.list_pl();
		},
		mounted() {
			this.department = this.$route.query.department;
			this.task_id = this.$route.query.kid;
			this.list_rec()
			this.uploadList = this.$refs.upload.fileList;
		},
		methods: {
			list_rec() {
				let that = this;
				let josn = {};
				josn.task_id = that.task_id;
				josn.department = that.department
				josn.rows = 999
				var qs = require('qs');
				that.axios({
						method: 'post',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						url: api.task_department_records,
						data: qs.stringify(josn) //传参变量
					})
					.then(function(res) {
						if(res.data.error == 0) {
							console.log('-------', res.data.data)
							for(let i = 0; i, res.data.data.length; i++) {
								console.log('---11----', res.data.data[i].task_record_type)
								if(res.data.data[i].task_record_type == 1) {
									console.log('---2222----', res.data.data[i])
									that.list = res.data.data[i]
								}
							}
						} else {
							console.log('-------', res.data.msg)
						}
					})
			},

			journal() {
				let that = this;
				that.$router.push({
					path: 'journal'
				})
			},
			doubt() { //疑问
				let that = this;
				that.$router.push({
					path: 'doubt'
				})
			},
			proposal() {
				let that = this;
				that.$router.push({
					path: 'proposal'
				})
			},
			bugs() {
				let that = this;
				that.$router.push({
					path: 'bugs'
				})
			},
			toEvaluate() {
				let that = this;
				that.$router.push({
					path: 'evaluate'
				})
			},
			list_pl() {
				let that = this;
				let lists = {};
				lists.task_id = this.kid
				lists.rows = 150
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
						that.list = res.data.data
						console.log('ttttt', that.list)

					})

			},
			
			oshow() {
				let that = this;
				that.isshow = !that.isshow
			},
			oeval(item, index) {
				let that = this;
				console.log("itemitemitemitem", item.task_record_id)
				//				that.evales = !that.evales
				item.task_id = !item.task_id
				that.task_record_id_index = item.task_record_id
				that.index_val = index

				//						that.divp = that.list[ind]
				//				if(that.evales) {
				//					item.task_id = !item.task_id
				//					that.task_record_id_index = that.list[index].task_record_id
				//					that.divp = that.list[index].sub
				//				}
			},

			//if(str&&!/^\s+$/.test(str)){
			////str不为空,且不全是空格
			//}
			//文件上传
			handleUpload(file) {
				this.file.push(file);
				return false;
			},
			upload() {
				this.loadingStatus = true;
				setTimeout(() => {
					//                  this.file = null;
					this.loadingStatus = false;
					this.$Message.success('Success')
				}, 1500);
			},

			//图片上传
			handleView(name) {
				this.imgName = name;
				this.visible = true;
			},
			handleRemove(file) {
				const fileList = this.$refs.upload.fileList;
				this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
			},
			handleSuccess(res, file) {
				file.url = 'https://o5wwk8baw.qnssl.com/7eb99afb9d5f317c912f08b5212fd69a/avatar';
				file.name = '7eb99afb9d5f317c912f08b5212fd69a';
			},
			handleFormatError(file) {
				this.$Notice.warning({
					title: 'The file format is incorrect',
					desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
				});
			},
			handleMaxSize(file) {
				this.$Notice.warning({
					title: 'Exceeding file size limit',
					desc: 'File  ' + file.name + ' is too large, no more than 5M.'
				});
			},
			handleBeforeUpload() {
				const check = this.uploadList.length < 5;
				if(!check) {
					this.$Notice.warning({
						title: 'Up to five pictures can be uploaded.'
					});
				}
				return check;
			},
			delFile(idx) {
				this.file.splice(idx, 1);
			}
		},

	}
</script>

<style>

</style>
<style scoped>
	.tit_box {
		position: absolute;
		top: -85px;
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
	
	.tit_box_ul li {
		text-align: center;
		font-size: 18px;
		width: 160px;
		line-height: 85px;
		height: 85px;
		position: relative;
	}
	
	.tit_box_ul li:hover:before {
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
	
	.zj_lise {
		background: #e4f6fd;
		overflow: auto;
	}
	
	.sub {
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