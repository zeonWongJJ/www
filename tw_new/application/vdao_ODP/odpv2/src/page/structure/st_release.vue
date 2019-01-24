<template>
	<div class="rele">
		<div class="tit_box">
			<ul class="tit_box_ul">
				<li class="tit_box_li">我的任务</li>

			</ul>
		</div>
		<div class="box_body test-1">
			<div class="task_details_header">
				<div class="return_blue"></div>
				<div class="header_text">结构</div>
				<div class="return_blue"></div>
				<div class="header_text">发布任务</div>
			</div>

			<div class="rele_box">
				<Form :model="formItem" :label-width="180" @submit.native.prevent>
					<FormItem label="任务名称" class='formItem'>
						<Input v-model="formItem.input" placeholder="请输入任务名称"></Input>
					</FormItem>
					<FormItem label="任务描述" class='formItem'>
						<Input v-model="formItem.textarea" type="textarea" :autosize="{minRows: 4,maxRows: 6}" placeholder="请写出详细的任务描述，小伙伴能更好理解"></Input>
					</FormItem>

					<FormItem label="完成日期" class='formItem'>
						<DatePicker type="date" placeholder="请依次写出年月日" v-model="formItem.dates"></DatePicker>
					</FormItem>
					<FormItem label="关联项目" class='formItem'>
						<div class="xm_ri test-1">
							<div>
								<ul>
									<li v-for="(xmlabel,index) in formItem.ka">
										<input type="checkbox" :id="'project_id'+xmlabel.project_id" :value="xmlabel.project_id" v-model="checkedNames">
										<label :for="'project_id'+xmlabel.project_id">{{xmlabel.project_name}}</label>
									</li>
								</ul>
							</div>

						</div>
					</FormItem>
					<FormItem label="关联计划" class='formItem'>
						<div class="xm_ri test-1">
							<div>
								<ul>
									<li v-for="(daxlabel,index) in dax">
										<input type="checkbox" :id="'plan_id'+daxlabel.plan_id" :value="daxlabel.plan_id" v-model="picked">
										<label :for="'plan_id'+daxlabel.plan_id">{{daxlabel.plan_name}}</label>
									</li>
								</ul>
							</div>
						</div>
					</FormItem>

					<FormItem label="参与人" class='formItem'>

						<ul class="ul_Checkbox">
							<li v-for='(label,index) in formItem.label'>
								<div>{{index}}</div>
								<div v-for='labels in label'>
									<div>
										<input type="checkbox" :id="'member_id'+labels.member_id" :value="labels.member_id" v-model="task_belonged">
										<label :for="'member_id'+labels.member_id">{{labels.real_name}}</label>
									</div>
								</div>
							</li>
						</ul>

					</FormItem>

					<FormItem label="上传文件" class='formItem'>
						<Upload name='file' :action="upFile"  :on-success="attachmentsSuccess" :on-remove="o_remove" >
							<Button type="ghost" icon="ios-cloud-upload-outline">Upload files</Button>
						</Upload>
					</FormItem>

					<FormItem label="上传图片" class='formItem'>
						<div class="demo-upload-list" v-for="item in uploadList">
							<template v-if="item.status === 'finished'">
								<img :src="item.url">
								<div class="demo-upload-list-cover">
									<Icon type="ios-eye-outline" @click.native="handleView(item)"></Icon>
									<Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
								</div>
							</template>
							<template v-else>
								<Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
							</template>
						</div>

						<Upload ref="upload" :format="['jpg','jpeg','png']" name='image' :action="imgs" accept="image/jpg,image/jpeg,image/png" :show-upload-list="false" :on-success="handleSuccess" :default-file-list="defaultList" :max-size="2048" :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :before-upload="handleBeforeUpload" multiple type="drag" style="display: inline-block;width:58px;">
							<div style="width: 58px;height:58px;line-height: 58px;">
								<Icon type="camera" size="20"></Icon>
							</div>
						</Upload>
						<Modal title="View Image" v-model="visible">
							<img :src="this.indexs" alt="" v-if="visible" style="width: 100%"/>
							<!--<img :src="'http://odp/' + imgName + '/large'" v-if="visible" style="width: 100%">-->
						</Modal>

					</FormItem>

					<FormItem class='formItem'>
						<div class="but_b">
							<button @click="asiospust()">确认发布</button>
							<button>取消</button>
						</div>

						<!--<Button type="primary">确认发布</Button>
						<Button type="ghost" style="margin-left: 8px">取消</Button>-->
					</FormItem>

				</Form>

			</div>

		</div>

	</div>
</template>

<script>
	import api from '@/api/api'
	export default {
		data() {
			return {
				imgs: api.uploadFileUrl + api.upload_image,//图片接口
				imges:[],//图片存储
				upFile:api.uploadFileUrl + api.upload_file,//文件接口
				uploadFile:[],//文件存储
				checkedNames: [],//项目
				picked: [],//计划
				task_belonged: [],//参与人
				dax: [],
				formItem: {
					input: '',
					select: '可点击下拉框勾选项目',
					select2: '可点击下拉框勾选项目',
					checkbox: [],
					dates: '',
					time: '',
					textarea: '',
					ka: [],
					members: [],
					xmlist: [],
					label: []
				},
				defaultList: [
//				{
//						'name': 'a42bdcc1178e62b4694c830f028db5c0',
//						'url': 'https://o5wwk8baw.qnssl.com/a42bdcc1178e62b4694c830f028db5c0/avatar'
//					},
//					{
//						'name': 'bc7521e033abdd1e92222d733590f104',
//						'url': 'https://o5wwk8baw.qnssl.com/bc7521e033abdd1e92222d733590f104/avatar'
//					}
				],
				imgName: '',
				visible: false,
				uploadList: [],
				isshow: false,
				indexs: '', //保存传值

			}
		},

		methods: {
			asiospust() {
				let that = this;
				let date = that.formItem.dates;
				let datas = new Date(date);
				let date_value = datas.getFullYear() + '-' + (datas.getMonth() + 1) + '-' + datas.getDate() + ' ' + datas.getHours() + ':' + datas.getMinutes() + ':' + datas.getSeconds();

				if(that.formItem.input == '') {
					that.$Message.warning('请输入任务名称')
					return false
				} else if(that.formItem.textarea == '') {
					that.$Message.warning('请输入任务描述')
					return false
				} else if(that.formItem.dates == '') {
					that.$Message.warning('请选择完成日期')
					return false
				} else {
					let liform = {};
					liform.task_title = that.formItem.input
					liform.task_desc = that.formItem.textarea
					liform.task_time_limit = date_value
					liform.task_project_ids = that.checkedNames // 项目id
					liform.task_plan_ids = that.picked // 计划id
					liform.task_belonged = that.task_belonged // 任务所属人
					liform.task_file = that.uploadFile// 文件
					liform.task_pic = that.imges //  图片
					var qs = require('qs');
					that.axios({
							method: 'post',
							header: {
								'Content-Type': 'application/x-www-form-urlencoded'
							},
							url: api.insert,
							data: qs.stringify(liform) //传参变量
						})
						.then(function(res) {
							let data = res.data
							if(data.error) {
									
									
							} else {
								console.log('-------', res)
							}

						})
				}
			},

			oisshow(index) {
				let that = this;
				that.isshow = !that.isshow
			},

			handleView(item) {
				this.indexs = item.url;
				this.visible = true;
			},
			handleRemove(file) {
				const fileList = this.$refs.upload.fileList;
				this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
				this.imges.splice(file,1)
			
			},
			o_remove(file){
				const fileList = this.$refs.upload.fileList;
				this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
				this.uploadFile.splice(file,1)
			},
			handleSuccess(res, file) {
				let that=this;
				file.url = api.uploadFileUrl + '/' + res.data.path;
				file.name = '';
				that.imges.push(res.data.path) 
			 
			},
			//文件
			attachmentsSuccess(val, file){
				let that=this;
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
			}
		},
		mounted() {
			this.uploadList = this.$refs.upload.fileList;
			let that = this;
			//项目
			that.axios({
					method: 'GET',
					url: api.projects
				})
				.then(function(res) {
					that.formItem.ka = res.data.data
				});
			//计划
			that.axios({
					method: 'GET',
					url: api.plans
				})
				.then(function(plans) {
					that.dax = plans.data.data
				});
				
			//参与人	
			that.axios({
					method: 'GET',
					url: api.members
				})
				.then(function(members) {
					that.formItem.members = members.data.data
					var arr = that.formItem.members;
					var test = {};
					var typeKey = 'department_name';
					for(var i = 0; i < arr.length; i++) {
						var user = arr[i];
						var type = user[typeKey];
						if(!test[type]) test[type] = [];
						test[type].push(user);
					}
					that.formItem.label = test

				});
		},
	}
</script>

<style scoped>
	.rele {
		background: #fdfeff;
	}
	
	.box_body {
		position: absolute;
		top: 0px;
		width: 1090px;
		height: 100%;
		overflow: hidden;
		overflow-y: scroll;
		overflow-x: auto;
		background: #fff;
		padding-bottom: 50px;
	}
	
	.rele_box {
		margin-top: 30px;
		width: 900px;
	}
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
	
	.ul_Checkbox {}
	
	.ul_Checkbox li {
		display: flex;
		align-items: center;
		margin-bottom: 10px;
	}
	
	.ul_Checkbox li div {
		width: 145px;
		display: flex;
		align-items: center;
	}
	
	.ul_Checkbox li>div:nth-child(1) {
		width: 80px;
		font-size: 15px;
		padding-left: 10px;
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
	
	.isshow {
		width: 18px;
		height: 18px;
		border: 1px solid #ddd;
		margin-right: 8px;
		display: flex;
		align-items: flex-start;
	}
	
	.isshow span {
		display: flex;
		align-items: flex-start;
		width: 18px;
		height: 18px;
	}
	
	.isshow span img {
		width: 18px;
		height: 18px;
	}
	
	.xm_ri {
		width: 720px;
		height: 200px;
		border-radius: 10px;
		border: 1px solid #eee;
		padding: 10px 15px 30px;
		overflow: auto;
	}
	
	.xm_ri_for {
		display: flex;
		flex-wrap: wrap
	}
	
	.xm_ri_for div {
		flex: 0 0 320px;
		margin: 10px 0 0 10px;
		position: relative;
		display: flex;
		align-items: flex-end;
		/*margin-right: 15px;*/
	}
	
	.label_name {
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 1;
		overflow: hidden;
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
	
	input[type="checkbox"] {
		opacity: 0;
		width: 20px;
		height: 20px;
	}
	
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
		background-image: url(../../assets/img/g_check.png);
		background-size: 100% 100%;
	}
	
	input[type="checkbox"]+label::before {
		content: "\a0";
		/*不换行空格*/
		display: inline-block;
		vertical-align: 6px;
		width: 20px;
		height: 20px;
		margin-right: 6px;
		border-radius: 4px;
		/*background-color: #f00;*/
		border: 1px solid #eee;
		text-indent: 2px;
		line-height: .65;
		/*行高不加单位，子元素将继承数字乘以自身字体尺寸而非父元素行高*/
	}
	
	input[type="checkbox"]:checked+label::before {
		/*content: "\2713";*/
		color: #fff;
		line-height: .65;
		/*background-color: #0ab3e9;*/
		width: 20px;
		height: 20px;
		background-image: url(../../assets/img/g_check.png);
		background-size: 100% 100%;
	}
	/*input {*/
	/*position: absolute;*/
	/*clip: rect(0, 0, 0, 0);*/
	/*float: left;*/
	/*display: none;*/
	/*}*/
	
	.liList>label>img,
	.liList>label>span {
		vertical-align: middle;
	}
	
	.liList>label>img {
		width: 24px;
		height: 24px;
	}
	
	.liList>label>span {
		font-size: 16px;
		color: #283033;
		margin-left: 10px;
	}
	
	.allSelectPro>img,
	.allSelectPro>span {
		vertical-align: middle;
	}
	
	.allSelectPro>img {
		width: 24px;
		height: 24px;
	}
	
	.allSelectPro>span {
		font-size: 16px;
		color: #283033;
		margin-left: 10px;
	}
	
	.proList>label>img,
	.proList>label>span {
		vertical-align: middle;
	}
	
	.proList>label>img {
		width: 24px;
		height: 24px;
	}
	
	.proList>label>span {
		font-size: 16px;
		color: #283033;
		margin-left: 10px;
	}
</style>

<style type="text/css">
	.ivu-form .ivu-form-item-label {
		font-size: 16px !important;
		color: #283033 !important;
	}
	
	.ivu-date-picker {
		width: 720px;
	}
</style>