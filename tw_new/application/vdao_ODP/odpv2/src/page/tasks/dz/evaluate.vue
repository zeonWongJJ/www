<template>
	<div class="evaluate">
		<div class="task_details_header">
			<div class="return_blue"></div>
			<div class="header_text">任务详情</div>
			<div class="return_blue"></div>
			<div class="header_text">动作记录</div>
			<div class="return_blue"></div>
			<div class="header_text">发布动作记录</div>
		</div>

		<Form :label-width="180" @submit.native.prevent>
			<FormItem label="动作类型" class='formItem'>
				<div class="type">
					<div class="radio" v-for="item in type">
						<input :id="item.type" type="radio" :value="item.type" name="type" v-model="type_id" checked>
						<label :for="item.type">{{item.name}}</label>
					</div>
				</div>
			</FormItem>
			<FormItem label="动作描述" class='formItem'>
				<Input type="textarea" :autosize="{minRows: 4,maxRows: 6}" v-model="textareas" placeholder="请写出详细的动作描述，小伙伴能更好理解"></Input>
			</FormItem>
			<FormItem label="上传文件" class='formItem'>
				<Upload action="//jsonplaceholder.typicode.com/posts/">
					<Button type="ghost" icon="ios-cloud-upload-outline">Upload files</Button>
				</Upload>
			</FormItem>
			<FormItem label="上传文件" class='formItem'>
				<div class="demo-upload-list" v-for="item in uploadList">
					<template v-if="item.status === 'finished'">
						<img :src="item.url">
						<div class="demo-upload-list-cover">
							<Icon type="ios-eye-outline" @click.native="handleView(item.name)"></Icon>
							<Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
						</div>
					</template>
					<template v-else>
						<Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
					</template>
				</div>
				<Upload ref="upload" :show-upload-list="false" :default-file-list="defaultList" :on-success="handleSuccess" :format="['jpg','jpeg','png']" :max-size="2048" :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :before-upload="handleBeforeUpload" multiple type="drag" action="//jsonplaceholder.typicode.com/posts/" style="display: inline-block;width:58px;">
					<div style="width: 58px;height:58px;line-height: 58px;">
						<Icon type="camera" size="20"></Icon>
					</div>
				</Upload>
				<Modal title="View Image" v-model="visible">
					<img :src="'https://o5wwk8baw.qnssl.com/' + imgName + '/large'" v-if="visible" style="width: 100%">
				</Modal>
			</FormItem>

			<FormItem class='formItem'>
				<div class="but_b">
					<button @click="click_but()">确认发布</button>
					<button>取消</button>
				</div>
			</FormItem>

		</Form>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default {
		data() {
			return {
				task_id: '', //任务id
				//				member_id:'',//会员id
				//		    	real_name:'',//会员名字
				department: '', //当前评论部门
				type_id: '',
				textareas: '', //mianshu
				imgs: api.uploadFileUrl + api.upload_image, //图片接口
				imges: [], //图片存储
				upFile: api.uploadFileUrl + api.upload_file, //文件接口
				uploadFile: [], //文件存储
					type: [{
							type: 1,
							name: '日志'
						},
						{
							type: 2,
							name: '疑问'
						},
						{
							type: 3,
							name: '建议'
						},
						{
							type: 4,
							name: 'BUG'
						},
					],

				defaultList: [],
				imgName: '',
				visible: false,
				uploadList: [],
				isshow: false,
				indexs: '', //保存传值
			}
		},
		mounted() {
			this.task_id = this.$route.query.kid
			this.department = this.$route.query.department

		},
		methods: {
			click_but() {
				let that = this;
				let josn = {};
				josn.task_id = this.task_id;
				josn.department = this.department
				josn.task_record_type = that.type_id
				josn.task_record_desc = that.textareas
				josn.member_id = this.$store.state.member_id
				var qs = require('qs');
				that.axios({
						method: 'post',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						url: api.task_department_records_insert,
						data: qs.stringify(josn) //传参变量
					})
					.then(function(res) {
						//							console.log('-------',res.data)
						if(res.data.error == 0) {
							that.$Message.success('提交成功');
								setTimeout(() => {
									that.$router.push({
										path: 'task_detail'
									})
								}, 2000);
						} else {
							that.$Message.error(res.data.msg);
							console.log('-------', res.data.msg)
						}

					})
			},
			handleView(item) {
				this.indexs = item.url;
				this.visible = true;
			},
			handleRemove(file) {
				const fileList = this.$refs.upload.fileList;
				this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
				this.imges.splice(file, 1)

			},
			handleSuccess(res, file) {
				let that = this;
				console.log(res)
				file.url = api.uploadFileUrl + '/' + res.data.path;
				file.name = '';
				that.imges.push(res.data.path)

			},
			//文件
			attachmentsSuccess(val, file) {
				let that = this;
				//				file.url = val.data.path;
				file.name = val.data.source_name;
				that.uploadFile.push(val.data.path)
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
					desc: '文件 ' + file.name + ' 太大，不能超过200M。'
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
		},

	}
</script>

<style scoped>
	.evaluate {
		position: absolute;
		top: 0px;
		width: 1090px;
		height: 100%;
		overflow: hidden;
		overflow-y: scroll;
		overflow-x: auto;
		background: #fff;
	}
	
	.evaluate::-webkit-scrollbar-track {
		/*滚动条里面轨道*/
		/*-webkit-box-shadow: inset 0 0 5px #b0c0d0;*/
		border-radius: 10px;
		background: #fff;
	}
	
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
		background: url(../../../assets/img/return_bllue.png);
		margin: 0 7px 0 25px;
	}
	
	.type {
		display: flex;
		align-items: center;
	}
	
	.radio {}
	
	input[type="radio"] {
		width: 20px;
		height: 20px;
		opacity: 0;
	}
	
	input[type="radio"]+label::before {
		content: "\a0";
		display: inline-block;
		vertical-align: 6px;
		width: 20px;
		height: 20px;
		margin-right: 6px;
		border-radius: 4px;
		border: 1px solid #eee;
		text-indent: 2px;
		line-height: .65;
	}
	
	input[type="radio"]:checked+label::before {
		color: #fff;
		line-height: .65;
		width: 20px;
		height: 20px;
		background-image: url(../../../assets/img/g_check.png);
		background-size: 100% 100%;
	}
	
	.but_b button {
		width: 136px;
		height: 40px;
		border-radius: 20px;
		border: 0;
	}
	
	.but_b button:nth-child(1) {
		background: #0ab3e9;
		color: #fff;
		margin-right: 25px;
	}
	
	.but_b button:nth-child(2) {
		background: #fff;
		border: 1px solid #eee;
	}
</style>