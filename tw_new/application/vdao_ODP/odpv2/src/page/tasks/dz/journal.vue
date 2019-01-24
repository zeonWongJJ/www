<template>
	<div class="sub_tab">
		<!--<div class="evaluate_box">
			
		</div>-->

						
		<div class="evaluate" v-show="t_show">
			<div class="task_details_headers">
				<div class="return_blue"></div>
				<div class="header_text" @click="letf_fb()">计划列表</div>
				<div class="return_blue"></div>
				<div class="header_text" @click="aaaa()">动作记录</div>
				<div class="return_blue"></div>
				<div class="header_text">发布动作记录</div>
			</div>
			
			<Form :label-width="180" @submit.native.prevent>
				<FormItem label="动作类型" class='formItem'>
					<div class="type">
						<div class="radio" v-for="item in type">
							<input :id="item.type" type="radio" :value="item.type" name="type" v-model="form.type_id" checked>
							<label :for="item.type">{{item.name}}</label>
						</div>
					</div>
				</FormItem>
				<FormItem label="动作描述" class='formItem'>
					<Input type="textarea" :autosize="{minRows: 4,maxRows: 6}" v-model="form.textareas" placeholder="请写出详细的动作描述，小伙伴能更好理解"></Input>
				</FormItem>
				
				<FormItem label="流程进度" class='formItem'>
					<div style="display: flex;align-items: center;">
						<div class="" style="width: 400px;margin:  0 20px 0 0;">
						<Slider v-model="itlistsss"  show-tip="never" :tip-format="format" :step="10" ></Slider>
						<!--<Slider v-model="itlist.progress" disabled show-tip="never" :tip-format="format" @on-change="prog(item,itlist,index)"></Slider>-->
						</div>
						<div><span>{{itlistsss}}%</span></div>
					</div>
					
				</FormItem>
				<!--<FormItem label="上传文件" class='formItem'>
				
					<Upload ref="files" name='file' :action="upFile" :on-success="attachmentsSuccess" :show-upload-list="false" :headers="{ 'x-token' : this.$store.state.token}">
						<Button type="ghost" icon="ios-cloud-upload-outline">点击上传</Button>
					</Upload>
					<div class="files">
						<div class="file" v-for="item in uploadFile">
							<div class="left"></div>
							<div class="center">{{item}}</div>
							<div class="right" @click="o_remove(item)"></div>
						</div>
					</div>
				</FormItem>-->
				<!--<FormItem label="上传图片" class='formItem'>
					<div class="demo-upload-list" v-for="item in imges">
						<img :src="uploadFileUrls+'/'+item">
						<div class="demo-upload-list-cover">
							<Icon type="ios-eye-outline" @click.native="handleView(uploadFileUrls+'/'+item)"></Icon>
							<Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
						</div>
					</div>

					<Upload ref="upload" :format="['jpg','jpeg','png']" name='image' :action="imgs" :data="token_i" accept="image/jpg,image/jpeg,image/png" :show-upload-list="false" :on-success="handleSuccess" :default-file-list="defaultList" :max-size="2048" :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :before-upload="handleBeforeUpload" multiple type="drag" style="display: inline-block;width:58px;" :headers="{ 'x-token' : this.$store.state.token}">
						<div style="width: 58px;height:58px;line-height: 58px;">
							<Icon type="camera" size="20"></Icon>
						</div>
					</Upload>
					<Modal title="View Image" v-model="visible">
						<img :src="indexs" alt="" v-if="visible" style="width: 100%" />
					</Modal>
				</FormItem>-->
		

				<FormItem class='formItem'>
					<div class="but_b">
						<button @click="click_but()">确认发布</button>
						<button>取消</button>
					</div>
				</FormItem>

			</Form>

		</div>
		<div class="tit_box">

			<Tabs value="1">
				<TabPane label="日志" name="1">
					<div v-if="list ==''">
						<div class="task_details_header">
							<div>
								<div class="return_blue"></div>
								<div class="header_text" @click="letf_click()">计划列表</div>
								<div class="return_blue"></div>
								<div class="header_text">动作记录</div>
							</div>
							<div>
								<div @click="aaaa()">
									发布动作记录
								</div>
							</div>
						</div>
						<p style="text-align: center;margin-top: 50px;">暂无评论</p>
					</div>
					<div class="evaluate_box test-1" v-else>
						<div class="task_details_header">
							<div>
								<div class="return_blue"></div>
								<div class="header_text" @click="letf_click()">计划列表</div>
								<div class="return_blue"></div>
								<div class="header_text">动作记录</div>
							</div>
							<div>
								<div @click="aaaa()">
									发布动作记录
								</div>
							</div>
						</div>
						<div class="evaluate_con" v-for="(item,index) in list" v-if="item.type == 1" :key='index'>
							<div class="evaluate_con_com">
								<div> <span class="span_con_img"><img src="../../../assets/img/erweima.png"/></span>{{item.my_name}} <span>{{item.add_date}}</span></div>
								<div style="width: 700px;word-wrap: break-word;word-break: normal;">
									<pre style="width: 700px;white-space: pre-wrap;word-wrap: break-word;">{{item.content}}</pre>
								</div>
								<!--样式-->
								<!--<div class="del_file">
									<div v-for="itfile in item.task_record_file_data">
										<a :href="uploadFileUrls + '/' +itfile" :download="itfile">{{itfile}}</a>
									</div>

								</div>-->
								<!--<div class="del_file">
									<div v-for="itpic in item.task_record_pic_data">
										<a :href="uploadFileUrls + '/' + itpic" :download="itpic"><img style="width: 80px;" :src="uploadFileUrls + '/' + itpic" /></a>
									</div>
								</div>-->
							</div>
							<div class="evaluate_con_p" @click="oeval(item,index)">
								<img src="../../../assets/img/reply.png" />
							</div>
							<div>
								<s-eval :item_p="item" :indexVal='item.parent_id'></s-eval>
							</div>
						</div>
					</div>
				</TabPane>
				<TabPane label="疑问" name="2">
					<div v-if="list ==''">
						<div class="task_details_header">
							<div>
								<div class="return_blue"></div>
								<div class="header_text" @click="letf_click()">计划列表</div>
								<div class="return_blue"></div>
								<div class="header_text">动作记录</div>
							</div>
							<div>
								<div @click="aaaa()">
									发布动作记录
								</div>
							</div>
						</div>
						<p style="text-align: center;margin-top: 50px;">暂无评论</p>
					</div>
					<div class="evaluate_box test-1" v-else>
						<div class="task_details_header">
							<div>
								<div class="return_blue"></div>
								<div class="header_text" @click="letf_click()">计划列表</div>
								<div class="return_blue"></div>
								<div class="header_text">动作记录</div>
							</div>
							<div>
								<div @click="aaaa()">
									发布动作记录
								</div>
							</div>
						</div>
						<div class="evaluate_con" v-for="(item,index) in list" v-if="item.type == 2" :key='index'>
							<div class="evaluate_con_com">
								<div> <span class="span_con_img"><img src="../../../assets/img/erweima.png"/></span>{{item.my_name}} <span>{{item.add_date}}</span></div>
								<div style="width: 700px;word-wrap: break-word;word-break: normal;">
										<pre style="width: 700px;white-space: pre-wrap;word-wrap: break-word;">{{item.content}}</pre>
								</div>
								<!--样式-->
								<!--<div class="del_file">
									<div v-for="itfile in item.task_record_file_data">
										<a :href="uploadFileUrls + '/' +itfile" :download="itfile">{{itfile}}</a>
									</div>

								</div>-->
								<!--<div class="del_file">
									<div v-for="itpic in item.task_record_pic_data">
										<a :href="uploadFileUrls + '/' + itpic" :download="itpic"><img style="width: 80px;" :src="uploadFileUrls + '/' + itpic" /></a>
									</div>
								</div>-->
							</div>
							<div class="evaluate_con_p" @click="oeval(item,index)">
								<img src="../../../assets/img/reply.png" />
							</div>
							<div>
								<s-eval :item_p="item" :indexVal='item.parent_id'></s-eval>
								<!--<s-eval :taskId='item.task_id' :type='item.task_record_type' :department='item.department' :indexVal='index_val' :idsi="item.task_record_id" :ishow='item.parent_id' :divp='list'></s-eval>-->
							</div>
						</div>
					</div>
				</TabPane>
				<TabPane label="提问" name="name3">
					<div v-if="list ==''">
						<div class="task_details_header">
							<div>
								<div class="return_blue"></div>
								<div class="header_text" @click="letf_click()">计划列表</div>
								<div class="return_blue"></div>
								<div class="header_text">动作记录</div>
							</div>
							<div>
								<div @click="aaaa()">
									发布动作记录
								</div>
							</div>
						</div>
						<p style="text-align: center;margin-top: 50px;">暂无评论</p>
					</div>
					<div class="evaluate_box test-1" v-else>
						<div class="task_details_header">
							<div>
								<div class="return_blue"></div>
								<div class="header_text" @click="letf_click()">计划列表</div>
								<div class="return_blue"></div>
								<div class="header_text">动作记录</div>
							</div>
							<div>
								<div @click="aaaa()">
									发布动作记录
								</div>
							</div>
						</div>
						<div class="evaluate_con" v-for="(item,index) in list" v-if="item.type == 3" :key='index'>
							<div class="evaluate_con_com">
								<div> <span class="span_con_img"><img src="../../../assets/img/erweima.png"/></span>{{item.my_name}} <span>{{item.add_date}}</span></div>
								<div style="width: 700px;word-wrap: break-word;word-break: normal;">
										<pre style="width: 700px;white-space: pre-wrap;word-wrap: break-word;">{{item.content}}</pre>
								</div>
								<!--样式-->
								<!--<div class="del_file">
									<div v-for="itfile in item.task_record_file_data">
										<a :href="uploadFileUrls + '/' +itfile" :download="itfile">{{itfile}}</a>
									</div>

								</div>
								<div class="del_file">
									<div v-for="itpic in item.task_record_pic_data">
										<a :href="uploadFileUrls + '/' + itpic" :download="itpic"><img style="width: 80px;" :src="uploadFileUrls + '/' + itpic" /></a>
									</div>
								</div>-->
							</div>
							<div>
								<s-eval :item_p="item" :indexVal='item.parent_id'></s-eval>
								<!--<s-eval :taskId='item.task_id' :type='item.task_record_type' :department='item.department' :indexVal='index_val' :idsi="item.task_record_id" :ishow='item.parent_id' :divp='list'></s-eval>-->
							</div>
						</div>
					</div>
				</TabPane>
				<TabPane label="BUG" name="name4">
					<div v-if="list ==''">
						<div class="task_details_header">
							<div>
								<div class="return_blue"></div>
								<div class="header_text" @click="letf_click()">计划列表</div>
								<div class="return_blue"></div>
								<div class="header_text">动作记录</div>
							</div>
							<div>
								<div @click="aaaa()">
									发布动作记录
								</div>
							</div>
						</div>
						<p style="text-align: center;margin-top: 50px;">暂无评论</p>
					</div>
					<div class="evaluate_box test-1" v-else>
						<div class="task_details_header">
							<div>
								<div class="return_blue"></div>
								<div class="header_text" @click="letf_click()">计划列表</div>
								<div class="return_blue"></div>
								<div class="header_text">动作记录</div>
							</div>
							<div>
								<div @click="aaaa()">
									发布动作记录
								</div>
							</div>
						</div>
						<div class="evaluate_con" v-for="(item,index) in list" v-if="item.type == 4" :key='index'>
							<div class="evaluate_con_com">
								<div> <span class="span_con_img"><img src="../../../assets/img/erweima.png"/></span>{{item.my_name}} <span>{{item.add_date}}</span></div>
								<div style="width: 700px;word-wrap: break-word;word-break: normal;">
									<pre style="width: 700px;white-space: pre-wrap;word-wrap: break-word;">{{item.content}}</pre>
								</div>
								<!--样式-->
								<!--<div class="del_file">
									<div v-for="itfile in item.task_record_file_data">
										<a :href="uploadFileUrls + '/' +itfile" :download="itfile">{{itfile}}</a>
									</div>

								</div>
								<div class="del_file">
									<div v-for="itpic in item.task_record_pic_data">
										<a :href="uploadFileUrls + '/' + itpic" :download="itpic"><img style="width: 80px;" :src="uploadFileUrls + '/' + itpic" /></a>
									</div>
								</div>-->
							</div>

							<div class="evaluate_con_p" @click="oeval(item,index)">
								<img src="../../../assets/img/reply.png" />
							</div>
							<div>
								<s-eval :item_p="item" :indexVal='item.parent_id' :discuss='item_p.discuss_id'></s-eval>
								<!--<s-eval :taskId='item.task_id' :type='item.task_record_type' :department='item.department' :indexVal='index_val' :idsi="item.task_record_id" :ishow='item.parent_id' :divp='list'></s-eval>-->
							</div>
						</div>
					</div>
				</TabPane>
			</Tabs>
		</div>
<div v-show="!onshows" style="position: fixed;top: 0;left: 0;right: 0;bottom: 0;width: 100%;height: 100%;background: rgba(0,0,0,0); z-index: 999999;">

		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	import sEval from '@/page/subcomponent/records_s_eval'
	export default {
		components: {
			sEval
		},
		//		props: ["kid"],
		data() {
			return {
				//				uploadFileUrls: api.uploadFileUrl,
				//				imgs: api.uploadFileUrl + api.upload_image, //图片接口
				//				imges: [], //图片存储
				//				upFile: api.uploadFileUrl + api.upload_file, //文件接口
				//				uploadFile: [], //文件存储
				//				uploadFiles: [],
				itlistsss:this.$store.state.progress,
				token_i: {},
				task_record_id: '',
				index_val: '',
				isshow: false,
				t_show: false,
				task_id: '',
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
				//				aaa: '',
				b: '',
				c: '',

				form: {
					//					task_id: '', //任务id
					//					department: '', //当前评论部门
					type_id: '',
					textareas: '', //mianshu
				},

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
				onshows:true,

			}
		},
		created() {
		},
		mounted() {
			this.list_rec()

		},
		methods: {

			letf_fb() {
				let that = this;
				that.$router.back(-2)
			},
			letf_click() {
				let that = this;
				that.$router.back(-1)
			},
			format(val) {

			},
			list_rec() {
				let that = this;
				let josn = {};
				josn.id = that.$store.state.process_id
				josn.discuss_type = 2
				//				josn.type =

				josn.rows = 500
				var qs = require('qs');
				that.axios({
						method: 'post',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						url: api.plan_discusses,
						data: qs.stringify(josn) //传参变量
					})
					.then(function(res) {
						if(res.data.error == 0) {
							for(let i = 0; i < res.data.data.list.length; i++) {
								//																console.log('---11----', res.data.data.list[i].type)
								if(res.data.data.list[i].type == 1) {
									that.c = res.data.data.list[i].type
									//																		console.log('---2222----', res.data.data.list[i])
									that.list.push(res.data.data.list[i])
								} else if(res.data.data.list[i].type == 2) {
									that.c = res.data.data.list[i].ype
									//									console.log('---2222----', res.data.data[i])
									that.list.push(res.data.data.list[i])
								} else if(res.data.data.list[i].type == 3) {
									that.c = res.data.data.list[i].type
									//									console.log('---2222----', res.data.data[i])
									that.list.push(res.data.data.list[i])
								} else if(res.data.data.list[i].type == 4) {
									that.c = res.data.data.list[i].type
									//									console.log('---2222----', res.data.data[i])
									that.list.push(res.data.data.list[i])
								}
							}
						} else {
							that.$Message.error(res.data.msg)
						}
					})
			},
			aaaa() {
				let that = this;
				that.t_show = !that.t_show
			},
			click_but() {
				let that = this;
				if(that.onshows){
					that.onshows = false
				let josn = {};
				josn.content = that.form.textareas
				josn.member_id = that.$store.state.member_id
				josn.id = that.$store.state.process_id
				josn.progress = that.itlistsss
				josn.discuss_type = 2
				josn.type = that.form.type_id
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
							that.t_show = !that.t_show
							that.form.type_id = ''
							that.form.textareas = ''
							if(res.data.data.discuss.type == 1) {
								that.list.push(res.data.data.discuss)
							} else if(res.data.data.discuss.type == 2) {
								that.list.push(res.data.data.discuss)
							} else if(res.data.data.discuss.type == 3) {
								that.list.push(res.data.data.discuss)
							} else if(res.data.data.discuss.type == 4) {
								that.list.push(res.data.data.discuss)
							}

							that.$Message.success('提交成功');
							setTimeout(() => {
									that.onshows = true
							}, 2000);
							//							setTimeout(() => {
							//								window.location.reload()
							//							
							//							}, 2000);

						} else {
							that.$Message.error(res.data.msg);
						}

					})
				}
	
			},
			//			handleView(item) {
			//				this.indexs = item;
			//				this.visible = true;
			//			},
			//			handleRemove(file) {
			//				const fileList = this.$refs.upload.fileList;
			//				this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
			//				this.imges.splice(file, 1)
			//
			//			},
			//			o_remove(file) {
			//				this.uploadFile.splice(file, 1)
			//			},
			//			handleSuccess(res, file) {
			//				let that = this;
			//				file.url = api.uploadFileUrl + '/' + res.data.path;
			//				file.name = '';
			//				that.imges.push(res.data.path)
			//
			//			},
			//文件
			//			attachmentsSuccess(val, file) {
			//				let that = this;
			//				file.name = val.data.source_name;
			//				that.uploadFiles.push(val.data.path)
			//				that.uploadFile.push(val.data.source_name)
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
			//					desc: '文件 ' + file.name + ' 太大，不能超过 200M。'
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

			oeval(item, index) {
				let that = this;
				console.log('123123123', item)

				that.num = index
				item.parent_id = !item.parent_id

			},

			//			journal() {
			//				let that = this;
			//				that.$router.push({
			//					path: 'journal'
			//				})
			//			},
			//			doubt() { //疑问
			//				let that = this;
			//				that.$router.push({
			//					path: 'doubt'
			//				})
			//			},
			//			proposal() {
			//				let that = this;
			//				that.$router.push({
			//					path: 'proposal'
			//				})
			//			},
			//			bugs() {
			//				let that = this;
			//				that.$router.push({
			//					path: 'bugs'
			//				})
			//			},
			//			toEvaluate() {
			//				let that = this;
			//				that.$router.push({
			//					path: 'evaluate'
			//				})
			//			},

			oshow() {
				let that = this;
				that.isshow = !that.isshow
			},

		},

	}
</script>

<style type="text/css">
	.sub_tab .ivu-tabs {
		width: 1090px !important;
	}
	
	.sub_tab .ivu-tabs-nav {
		width: 160px important;
		height: 44px;
		line-height: 30px !important;
	}
	
	.sub_tab .ivu-tabs-bar {
		margin: 0 0 0 0 !important;
	}
	
	.sub_tab .ivu-tabs-nav .ivu-tabs-tab {
		width: 160px !important;
		text-align: center;
		font-size: 18px;
		
	}
	.sub_tab .ivu-tabs-ink-bar .ivu-tabs-ink-bar-animated {
		width: 160px !important;
	}
	
	.sub_tab .ivu-tabs .ivu-tabs-tabpane {
		height: 820px !important;
	}
	
	.sub_tab .ivu-tabs .ivu-tabs-content-animated {
		width: 100%;
	}
</style>
<style scoped>
	.evaluate_box {
		/*position: absolute;*/
		/*top: 0px;*/
		width: 1090px;
		height: 100%;
		overflow: hidden;
		overflow-y: scroll;
		overflow-x: auto;
		background: #fff;
	}
	
	.header_text {
		cursor: pointer;
	}
	
	.tit_box {
		position: absolute;
		top: 0px;
		left: 0px;
		height: 45px;
		/*line-height: 45px !important;*/
		margin: 0 0 0 0px;
		border-bottom: 1px solid rgba(186, 233, 249, .5);
		z-index: 999;
	}
	
	.zj_lise {
		background: #e4f6fd;
		overflow: auto;
	}
	
	.sub {
		margin-top: 50px;
		margin-bottom: 200px;
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
		background: url(../../../assets/img/file_blue.png);
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
		background: url(../../../assets/img/win.png);
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
		background: url(../../../assets/img/del_img.png);
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
		background: url(../../../assets/img/del_img.png);
	}
	
	.image_blue {
		width: 22px;
		height: 20px;
		display: inline-block;
		background: url(../../../assets/img/image_blue.png);
	}
	
	.task_details_headers {
		height: 44px;
		border-bottom: 1px solid rgba(186, 233, 249, .8);
		display: flex;
		align-items: center;
		color: #0ab3e9;
		margin-bottom: 20px;
	
	}
	
	.task_details_header {
		height: 44px;
		border-bottom: 1px solid rgba(186, 233, 249, .8);
		display: flex;
		align-items: center;
		justify-content: space-between;
		color: #0ab3e9;
		background: #fff !important;
	}
	
	.task_details_header>div:nth-child(1) {
		display: flex;
		align-items: center;
	}
	
	.task_details_header>div:nth-child(2) {
		margin-right: 50px;
		padding: 5px 10px;
		border-radius: 4px;
		border: 1px solid #eee;
		cursor: pointer;
	}
	
	.del_file {
		display: flex;
		/*flex-wrap: wrap;*/
	}
	
	.del_file div {
		margin-top: 20px;
		margin-right: 20px;
	}
	
	.return_blue {
		width: 8px;
		height: 12px;
		background: url(../../../assets/img/return_bllue.png);
		margin: 0 7px 0 25px;
	}
	
	.evaluate {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: #fff;
		z-index: 9999;
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
	
	.files {
		display: flex;
		margin-top: 30px;
		flex-wrap: wrap;
	}
	
	.files>.file {
		position: relative;
		width: 234px;
		height: 53px;
		display: flex;
		border-radius: 5px;
		overflow: hidden;
		justify-content: space-between;
		border: 1px solid rgba(0, 0, 0, .15);
		line-height: 53px;
		font-size: 12px;
		margin-right: 10px;
	}
	
	.files>.file .left {
		width: 53px;
		height: 53px;
		background: #0ab3e9;
	}
	
	.files>.file .center {
		width: 128px;
		height: 53px;
		padding: 0 40px 0 10px;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		flex: 1;
	}
	
	.files>.file .right {
		position: absolute;
		right: 0;
		top: 0;
		width: 35px;
		height: 35px;
		background: #fff url(../../../assets/img/del_img.png) no-repeat;
		background-position: center;
		background-size: 35px 35px;
	}
	
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