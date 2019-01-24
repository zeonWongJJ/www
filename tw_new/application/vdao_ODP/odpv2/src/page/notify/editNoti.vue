<template>
	<div class="rele">
		<div class="tit_box">
			<ul class="tit_box_ul">
				<li @click="message">系统通知</li>
				<li @click="allNoti" class="tit_box_li">公告通知</li>
				<li @click="approval">代办审批</li>

			</ul>
		</div>
		<div class="box_body ediNoti">
			<div class="task_details_header">
				<div class="return_blue"></div>
				<div class="header_text">发布公告</div>
			</div>

			<div class="rele_box">
				<Form :model="formItem" :label-width="180" :rules="validate" ref="formItem" >
					<FormItem label="公告主题" class='formItem' prop="input">
						<Input v-model="formItem.input" placeholder="请填写公告的主题"></Input>
					</FormItem>
					<FormItem label="描述" class='formItem' prop="textarea">
						<Input v-model="formItem.textarea" type="textarea" :autosize="{minRows: 4,maxRows: 6}" placeholder="请输入你想要的公告内容"></Input>
					</FormItem>

					<FormItem label="通知" class='formItem' prop="task_belonged">

						<ul class="ul_Checkbox">
							<li v-for='(label,index) in label'>
								<div style="fontWeight:700;">{{label.group.group_name}}</div>
								<div v-for='labels in label.list'>
									<div>
										<input type="checkbox" :id="'member_id'+labels.member_id" :value="labels.member_id" v-model="formItem.task_belonged">
										<label :for="'member_id'+labels.member_id">{{labels.real_name}}</label>
									</div>
								</div>
							</li>
						</ul>

					</FormItem>

					<FormItem label="上传文件" class='formItem'>
						<Upload ref="files" name='file' :action="upFile"  :on-success="attachmentsSuccess" :show-upload-list="false" :headers="{ 'x-token' : this.$store.state.token}">
							<Button type="ghost" icon="ios-cloud-upload-outline">点击上传</Button>
						</Upload>
						<div class="files">
			        		<div class="file" v-for="item in uploadFile">
			        			<div class="left"></div>
			        			<div class="center">{{item.name}}</div>
			        			<div class="right" @click="o_remove(item)"></div>
			        		</div>
			        </div>
					</FormItem>
					<FormItem label="上传图片" class='formItem' style="display: none;">
						<div class="demo-upload-list" v-for="item in imges">
							<img :src="uploadFileUrl+item">
							<div class="demo-upload-list-cover">
								<Icon type="ios-eye-outline" @click.native="handleView(uploadFileUrl+item)"></Icon>
								<Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
							</div>
						</div>

						<Upload ref="upload" :format="['jpg','jpeg','png','pds']" name='image'   :action="imgs" :data="token_i"  accept="image/jpg,image/jpeg,image/png" :show-upload-list="false" :on-success="handleSuccess"
							:default-file-list="defaultList" :max-size="2048" :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :before-upload="handleBeforeUpload" multiple type="drag" style="display: inline-block;width:58px;"
							:headers="{ 'x-token' : this.$store.state.token}">
							<div style="width: 58px;height:58px;line-height: 58px;">
								<Icon type="camera" size="20"></Icon>
							</div>
						</Upload>
						<Modal title="View Image" v-model="visible">
							<img :src="this.indexs" alt="" v-if="visible" style="width: 100%" />
						</Modal>

					</FormItem>
					<FormItem class='formItem'>
						<Button type="primary" @click="bulletin_add('formItem')">{{id ? '确认修改' : '确认发布'}}</Button>
		            	<Button type="ghost" style="margin-left: 8px">取消</Button>
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
				uploadFileUrl:api.uploadFileUrl+'/',
				id:0,
				imgs: api.uploadFileUrl + api.upload_image, //图片接口
				imges: [], //图片存储
				upFile: api.uploadFileUrl + api.upload_file, //文件接口
				uploadFile: [], //文件存储
				token_id:'',
				token_i:{},
				label: [],
				formItem: {
					input: '',
					textarea: '',
					task_belonged: [], //参与人
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
				visible: false,
				uploadList: [],
				indexs: '', //保存传值
				validate:{//表单验证
                    input: [
                        { required: true, message: '请填写公告主题', trigger: 'blur' }
                    ],
                    textarea: [
                        { required: true, message: '请填写描述', trigger: 'blur' },
                        { type: 'string', min: 15, message: '描述不能少于15个字符', trigger: 'blur' }
                    ],
                    task_belonged:[
                    	{ required: true, type: 'array', min: 1, message: '最少选择一个人', trigger: 'change' }
                    ]
	         	},

			}
		},

		methods: {
		
			message(){
				let that = this;
				that.$router.push({
					path: 'systemNoti'
				})
			},
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
			bulletin_add(name){
            	let that = this;
				that.$refs[name].validate((valid) => {
                    if (valid) {
						let liform = {};
						var oUrl = api.bulletin_add;
						if(that.id){
							liform.id = that.id;
							oUrl = api.bulletin_update;
						}
						liform.bulletin_title = that.formItem.input;
						liform.bulletin_content = that.formItem.textarea;
						liform.bulletin_member = that.formItem.task_belonged;
						liform.bulletin_files = [];// 文件
						for(var i =0;i<that.uploadFile.length;i++){
							liform.bulletin_files.push(that.uploadFile[i].path);
						}
						liform.bulletin_images = that.imges;//  图片
						var qs = require('qs');
						that.axios({
								method: 'post',
								header: {
									'Content-Type': 'application/x-www-form-urlencoded'
								},
								url: oUrl,
								data: qs.stringify(liform) //传参变量
							})
							.then(function(res) {
								let data = res.data;
								if(!data.error) {
									that.$Message.success(res.data.msg);
									setTimeout(function(){
										that.$router.push({
											path: 'allNoti'
										})
									},2000)
								} else {
									that.$Message.error(res.data.msg);
								}
		
							})
//                      this.$Message.success('Success!');
                    } else {
//                      this.$Message.error('Fail!');
                    }
                })
				
			},
			handleView(item) {
				this.indexs = item;
				this.visible = true;
			},
			handleRemove(file) {
				const fileList = this.$refs.upload.fileList;
				this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
				this.imges.splice(file, 1)

			},
			o_remove(file) {
				this.uploadFile.splice(file, 1)
			},
			handleSuccess(res, file) {
				let that = this;
				file.url = api.uploadFileUrl + '/' + res.data.path;
				file.name = '';
				that.imges.push(res.data.path)

			},
			//文件
			attachmentsSuccess(val, file) {
				let that = this;
				if(!val.error){
					var data = {}
					data.path = val.data.path;
					data.name = val.data.source_name;
					that.uploadFile.push(data);
				}else{
					that.$Message.error(val.msg);
				}
			},
			handleFormatError(file) {
				this.$Notice.warning({
					title: '文件格式不正确',
					desc: '文件 ' + file.name + ' 格式不正确，请上传 jpg 或 png 或psd 格式的图片。'
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
			getRecord(){
				var that = this;
				var qs = require('qs');
				let odata = {};
				odata.id  = that.id;
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.bulletin,
					data: qs.stringify(odata) //传参变量
				})
				.then(function(res) {
					if(!res.data.error){
						var data = res.data.data.list;
						that.formItem.input = data.bulletin_title;
						that.formItem.textarea = data.bulletin_content;
						for(var i = 0;i<data.members.length;i++){
							that.formItem.task_belonged.push(data.members[i].member_id);
						}
						that.uploadFile = data.files;
						for(var i = 0;i<data.images.length;i++){
							that.imges.push(data.images[i].path);
						}
					}else{
						that.$Message.error(res.data.msg);
					}
				});
			},
		},
		mounted() {
			this.id = this.$route.query.id;
			if(this.id){//编辑公告，获取公告信息
				this.getRecord();
			}
			this.uploadList = this.$refs.upload.fileList;//图片
			let that = this;
			var qs = require('qs');
			//通知人
			that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.group_members
				})
				.then(function(members) {
					console.log(members.data.data.list)
//					var arr = members.data.data;
//					var test = {};
//					var typeKey = 'department_name';
//					for(var i = 0; i < arr.length; i++) {
//						var user = arr[i];
//						var type = user[typeKey];
//						if(!test[type]) test[type] = [];
//						test[type].push(user);
//					}
					that.label = members.data.data.list
				})
		},
	}
</script>
<style>
	.box_body.ediNoti .ivu-form-item-label{text-align: left;}
</style>
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
		margin: 30px;
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
		width: 100px;
		display: flex;
		align-items: center;
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
		width: 20px;
		height: 20px;
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
	
	input {
		/*position: absolute;*/
		/*clip: rect(0, 0, 0, 0);*/
		display:none;
	}
	
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
	
	.missList,
	.perList {
		display: inline-block;
	}
	.missList>label>img,
	.perList>label>img {
		width:24px;
		height:24px;
		vertical-align:middle;
	}
	.perList{
		margin-left:10px;
	}
	.missList>label>span,
	.perList>label>span {
		font-size:16px;
		vertical-align:middle;
		margin-left:10px;
	}
	.files{
		display: flex;
		margin-top: 30px;
		flex-wrap:wrap;
	}
	.files>.file{
		position: relative;
		width: 234px;
		height: 53px;
		display: flex;
		border-radius: 5px;
		overflow: hidden;
		justify-content: space-between;
		border: 1px solid rgba(0,0,0,.15);
		line-height: 53px;
		font-size: 12px;
		margin-right: 10px;
	}
	.files>.file .left{
		width: 53px;
		height: 53px;
		background: #0ab3e9;
	}
	.files>.file .center{
		width: 128px;
		height: 53px;
		padding: 0 40px 0 10px;
		overflow: hidden;
	    text-overflow: ellipsis;
	    white-space: nowrap;
	    flex: 1;
	}
	.files>.file .right{
		position: absolute;
		right: 0;
		top: 0;
		width: 35px;
		height: 35px;
		background:#fff url(../../assets/img/del_img.png) no-repeat;
		background-position: center;
		background-size: 35px 35px;
		
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