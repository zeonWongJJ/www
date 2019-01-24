<template>
	<div class="sub">

		<div class="tit_box">
			<ul class="tit_box_ul">
				<!--<li class="tit_box_li"  @click="my_task()">好友动态 </li>
				<li @click.stop="mydynamic">我的动态</li>
				<li @click="dynamic">动态信息</li>-->
				<li v-for="(item,index) in lists" :class="{tit_box_li : index == num}" @click="linum(item,index)">
					{{item.name}}
				</li>
			</ul>
			<div style="position: absolute;top:30px;left: 450px;" v-if="node_count > 0">
				<span><img src="../../assets/img/eye_blue.png"/></span>
			</div>
		</div>

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
				</div>
				<div>
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
				<button v-show="!isshow">发表</button>
				<button v-show="isshow" @click="oshow(),tijiao()">发表</button>
			</div>
		</div>
		<!--评论区-->
			<div class="evaluate_box test-1">
				
			<!--333-->
			<div class="evaluate_con" v-for="(item,index) in list_plan" v-if="item.forwarded_id">
				<div class="evaluate_con_img">
				</div>
				<div class="evaluate_con_com" >
					<div v-show="absoshow" @click="del_h()" @touchmove.prevent="del_h()"  style="position: fixed;top: 0;left: 0;right: 0;bottom: 0; background: rgba(0,0,0,0);">
						<div style="display: block; position: absolute;top: 50%;left: 40%;background: #f8f8f8;border-radius: 10px; height: 200px;width: 300px;">
							<p style="text-align: center;margin: 25px 0;font-size: 18px;">
							      提示
							</p>
							<p style="text-align: center;font-size: 16px;margin: 0 0 45px 0;">
							     确定删除该动态吗?
							</p>
							<div style="text-align: center;" class="buts_del">
							    <button @click="structure_name()">取消</button>
							    <button @click="del_que()">确定</button>
							</div>
						</div>
					</div>
					
					<div style="display: flex;align-items: center;">
						<span class="span_con_img">
							<img src="../../assets/img/erweima.png"/>
						</span>
						{{item.my_name}} 
						<span style="margin: 0 15px;font-size: 12px; ">{{item.add_date}}</span>
						<span style="color: #00C1DE;" @click="odels(item,index)">删除</span>
					</div>
					<p style="word-break: break-all ;margin: 10px 0 10px 25px; ">{{item.content}}</p>

					<div class="del_file" v-if="item.pic != ''">
						<div>
							<img style="width: 80px;" :src="uploadFileUrls + '/' + item.pic" />
						</div>
					</div>
					<div v-if="item.forwarded" style="margin:10px 0 20px  0;background: #f5f5f5;padding: 10px 20px;">
						<div>
							转发 {{item.forwarded.real_name}} 的动态
						</div>
						<div style="margin: 0 0 20px 0;">
							{{item.forwarded.content}}
						</div>
						<div v-if="!item.forwarded">
							<img style="width: 80px;" :src="uploadFileUrls + '/' + item.forwarded.pic" />
						</div>
					</div>

					<div class="dzan" style="display: flex;justify-content: flex-end;">
						<div style="color: #b2b2b2;">{{item.likes}} </div>
						<div @click="zanz(item,index),item.likes ++" v-show="item.is_like == 0"><img src="../../assets/img/zan.png" /></div>
						<div @click="zanz_h(item,index),item.likes --" v-show="item.is_like == 1"><img src="../../assets/img/zan_h.png" /></div>

						<div @click="fenxiang(item,index)"><img src="../../assets/img/fenx.png" /></div>
						<!--<div @click="fenxiang(item,index)" v-show="fenx_h"><img src="../../assets/img/fenx_h.png" /></div>-->

					</div>

				</div>
				<div class="evaluate_con_p" @click="oeval(item,index)">
					<img src="../../assets/img/reply.png" />
				</div>
				<div>
					<s-eval :ksid='kid' :name='item.name' :taskId='item.plan_id' :indexVal='item' :idsi="item.id" :ishow='item.parent_id' :divp='list_plan'></s-eval>
				</div>
			</div>
			
				
				
			</div>
		
		
		
		
		
		
		
		
		<div class="evaluate_box2  test-1">

		<!--**********-->
				<div class="evaluate_con" v-for="(item,index) in list_plan" v-if="item.type" >
				<div class="evaluate_con_img">
				</div>
				<div class="evaluate_con_com" >
					<div v-if="item.type == 1"> <span class="span_con_img"></span>{{item.storey_name}} 点赞 </div>
					<div v-if="item.type == 2"> <span class="span_con_img"></span>{{item.storey_name}} 评论&nbsp;:&nbsp;&nbsp;  <p style="width:520px;font-size:16px !important;font-weight: 600;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;">{{item.content}} </p> </div>
					<div v-if="item.type == 3"> <span class="span_con_img"></span>{{item.storey_name}} 转发 &nbsp;:&nbsp;&nbsp;<p style="width:520px;font-size:16px !important;font-weight: 600;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;">{{item.content}} </p> </div>

					<p style="word-break: break-all">{{item.dynamic.content}}</p>
					
					<div class="del_file">
						<div v-if="item.dynamic.pic != ''" style="margin: 25px 0 0 25px;" >
							<img style="width: 80px;" :src="uploadFileUrls + '/' + item.dynamic.pic" />
						</div>
					</div>
					<!--<div style="margin:10px 0 20px  0;background: #f5f5f5;padding: 10px 20px;">-->
						<!--<div >
							转发 {{item.dynamic.real_name}} 的动态
						</div>-->
						<!--<div style="margin: 0 0 20px 0;">
							{{item.dynamic.content}}
						</div>-->
						<!--<div>
							<img style="width: 80px;" :src="uploadFileUrls + '/' + item.dynamic.pic" />
						</div>-->
					<!--</div>-->
				<div style="font-size: 12px;color: #b2b2b2;margin: 20px 0 0 25px;">{{item.add_date}}</div>
				</div>
				
				<div class="evaluate_con_p" @click="oeval_a(item,index),idshowsd()" v-if="item.type == 2 || item.type == 3">
					<img src="../../assets/img/reply.png" />
				</div>
				<!--<div>
					<s-eval :ksid='kid' :name='item.name' :taskId='item.plan_id' :indexVal='item' :idsi="item.id" :ishow='item.parent_id' :divp='list_plan'></s-eval>
				</div>-->
			</div>

		</div>
	<!--*****-->
			













		<div v-show="idshow" class="idshows" @click.stop="idshows()">
			<div style="display: flex;margin-top: 50px;">
					<span @click.stop="idshows()" style="position: absolute;top: 0;right: 0;width: 30px;height: 30px; background: #fff;"><img src="../../assets/img/del_img.png"/></span>
			
				<div class="evaluate_top">
					<div>
						<textarea ref="postcontent" rows="4" placeholder="请输入" v-model="textsid" @click="isshow = true"></textarea>
					</div>
				</div>
				<div class="buts">
					<button v-show="!isshow">分享</button>
					<button v-show="isshow" @click="oshow(),fenx()">分享</button>
				</div>
			</div>

			<div @click.stop="idshows()">
				<div class="evaluate_con">
					<div class="evaluate_con_img">
					</div>
					<div class="evaluate_con_com" style="border-bottom: 1px solid #eee;">
						<div> <span class="span_con_img"><img src="../../assets/img/erweima.png"/></span>{{itemlise.my_name}}  <span>{{itemlise.add_date}}</span> </div>
						<div>{{itemlise.content}}</div>
						<div class="del_file">
							<div v-if="itemlise.pic != ''">
								<img style="width: 80px;" :src="uploadFileUrls + '/' + itemlise.pic" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	<!--动态回去-->
	<div v-show="idshowd" class="idshows" >
			<div style="display: flex;margin-top: 50px;">
				<span @click.stop="idshowsd()" style="position: absolute;top: 0;right: 0;width: 30px;height: 30px; background: #fff;"><img src="../../assets/img/del_img.png"/></span>
				<div class="evaluate_top">
					<div>
						<textarea ref="postcontent" rows="4" placeholder="请输入" v-model="textsidd" @click="isshow = true"></textarea>
					</div>
				</div>
				<div class="buts">
					<button v-show="!isshow">回复</button>
					<button v-show="isshow" @click="oshow(),fenxd()">回复</button>
				</div>
			</div>

			<div >
				<div class="evaluate_con">
					<div class="evaluate_con_img">
					</div>
					<div class="evaluate_con_com">
						<div v-if="item_oeval_a.type == 2"> <span class="span_con_img"></span>{{item_oeval_a.storey_name}} &nbsp;&nbsp;评论<span>{{item_oeval_a.add_date}}</span> </div>
						<div v-if="item_oeval_a.type == 3"> <span class="span_con_img"></span>{{item_oeval_a.storey_name}} &nbsp;&nbsp;转发<span>{{item_oeval_a.add_date}}</span> </div>
						
						<div >{{item_oeval_a.content}}</div>
						
						<div class="del_file">
							<!--<div v-if="item_oeval_a.pic != ''">
								<img style="width: 80px;" :src="uploadFileUrls + '/' + item_oeval_a.pic" />
							</div>-->
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</template>

<script>
	import api from '@/api/api'
	import sEval from '@/page/dynamic/dynamic_pl_s'
	export default {
		components: {
			sEval
		},
		props: ["kid"],
		data() {
			return {
				absoshow:false,
				uploadFileUrls: api.uploadFileUrl,
				imgs: api.uploadFileUrl + api.upload_image, //图片接口
				imges: [], //图片存储
				uploadFiles: [],
				token_i: {},
				//				task_record_id: '',
				index_val: '',
				isshow: false,
				idshow: false,
				zan_h: true,
				fenx_h: false,
				texts: '',
				textsid: '',
				divp: [],
				list: {},
				list_plan: [],
				defaultList: [],
				file: [],
				loadingStatus: false,
				imgName: '',
				visible: false,
				uploadList: [],
				itemlise: {},
				num: 0,
				liknum: '' ,
				lists: [{
						name: '好友动态'
					},
					{
						name: '我的动态'
					},
					{
						name: '动态信息'
					},
				],
				node_count: '',
				types: false,
				list_type: [],
				idshowd:false,
				textsidd:'',
				item_ddid:'',
				likes:'',
				item_oeval_a:'',
				lists_id:'',
				lists_index:'',
			}

		},

		created() {
			this.linum();

		},
		mounted() {
			this.uploadList = this.$refs.upload.fileList;
		},
		methods: {
			linum(item, index) {
				let that = this;
				var qs = require('qs');
				that.num = index
				let lists = {};
				if(index == 1) {
					that.idshow = false
					that.idshowd = false
					lists.dynamic_member_id = this.$store.state.member_id
					lists.member_id = this.$store.state.member_id
					lists.rows = 500
					that.axios({
							method: 'post',
							headers: {
								"Content-Type": "application/x-www-form-urlencoded"
							},
							url: api.dynamic_list,
							data: qs.stringify(lists) //传参变量
						})
						.then(function(res) {
							if(res.data.error == 0) {
								console.log('7115', res.data.data.list)
								if(res.data.data.count > 0) {
									that.node_count = res.data.data.count
								}
								that.list_plan = res.data.data.list
								for(let i = 0;i<that.list_plan.length;i++){
								 that.liknum = that.list_plan[i].likes
										console.log('711',that.liknum)
								}
							console.log('711',that.liknum)

							} else {
								that.$Message.error(res.data.msg);
							
							}

						})
				} else if(index == 2) {
					that.types = true
						that.idshow = false
					that.idshowd = false
					that.node_count = 0
					lists.member_id = this.$store.state.member_id
					lists.rows = 500
					that.axios({
							method: 'post',
							headers: {
								"Content-Type": "application/x-www-form-urlencoded"
							},
							url: api.dynamic_notice_list,
							data: qs.stringify(lists) //传参变量
						})
						.then(function(res) {
							if(res.data.error == 0) {
//								console.log('7115', res.data.msg)

								that.list_plan = res.data.data.list
								let arr = res.data.data.list
							for(let i = 0;i<that.list_plan.length;i++){
								 that.liknum = that.list_plan[i].likes
										console.log('711',that.liknum)
								}
							console.log('711',that.liknum)
							} else {
								that.$Message.error(res.data.msg);
								
								console.log('711', res.data.msg)
							}

						})
				} else {
					lists.rows = 500
						that.idshow = false
					that.idshowd = false
					lists.member_id = this.$store.state.member_id
					that.axios({
							method: 'post',
							headers: {
								"Content-Type": "application/x-www-form-urlencoded"
							},
							url: api.dynamic_list,
							data: qs.stringify(lists) //传参变量
						})
						.then(function(res) {
							if(res.data.error == 0) {
//								console.log('7115', res.data.msg)
								if(res.data.data.count > 0) {
									that.node_count = res.data.data.count
								}
								that.list_plan = res.data.data.list
								for(let i = 0;i<that.list_plan.length;i++){
								 that.liknum = that.list_plan[i].likes
										console.log('711',that.liknum)
								}
							console.log('711',that.liknum)
//							console.log('ssss', res.data.data.list.likes)
							} else {
								that.$Message.error(res.data.msg);
								console.log('711', res.data.msg)
							}

						})
				}

			},
			//点赞
			zanz(item, index) {
				let that = this;
				item.is_like = 1
				let lists = {};
				lists.rows = 500
				lists.member_id = this.$store.state.member_id
				lists.id = item.id
				var qs = require('qs');
				that.axios({
						method: 'post',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						url: api.dynamic_like,
						data: qs.stringify(lists) //传参变量
					})
					.then(function(res) {
						if(res.data.error == 0) {
							console.log('asdfsdfasdfs', res)
							that.$Message.success('点赞');
							
						} else {
							that.$Message.error(res.data.msg);
						}

					})

			},
			//取消点赞
			zanz_h(item, index) {

				let that = this;
				item.is_like = 0
				let lists = {};
				lists.rows = 500
				lists.member_id = this.$store.state.member_id
				lists.id = item.id
				var qs = require('qs');
				that.axios({
						method: 'post',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						url: api.dynamic_unlike,
						data: qs.stringify(lists) //传参变量
					})
					.then(function(res) {
						if(res.data.error == 0) {
							console.log('asdfsdfasdfs', res)
							that.$Message.success('取消点赞');
							
						} else {
							that.$Message.error(res.data.msg);
						}

					})

			},
//分享
			fenx(item, index) {

				let that = this;
				that.idshow = false
				let lists = {};
				lists.rows = 500
				lists.member_id = this.$store.state.member_id
				lists.forwarded_id = that.itemlise.id
				lists.content = that.textsid
				var qs = require('qs');
				that.axios({
						method: 'post',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						url: api.dynamic_save,
						data: qs.stringify(lists) //传参变量
					})
					.then(function(res) {
						if(res.data.error == 0) {
							console.log(res)
							that.$Message.success(res.data.msg);
							that.list_plan.unshift(res.data.data.record)
						} else {
							that.$Message.error(res.data.msg);
							console.log('7', res.data.msg)
						}

					})

			},
//			提交
			tijiao() {
				let that = this;
				//计划评价

				let value = that.texts
				value = value.replace(/(^\s*)|(\s*$)/g, "");
				if(value.length > 0) {
					let josn = {};
					josn.member_id = this.$store.state.member_id
					josn.content = value
					//						josn.id =
					//						josn.forwarded_id = 
					josn.pic = that.imges //  图片

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
							console.log(res)
							if(res.data.error == 0) {
								that.$router.go(0)
								if(that.list_plan == '') {
									that.list_plan = res.data.data.record
								} else {

									that.list_plan.unshift(res.data.data.record)
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

			},
//			删除
			odels(item, index) {
				let that = this;
				that.absoshow = true
				that.lists_id = item.id
				 that.lists_index =  index
//				let lists = {};
//				lists.rows = 500
//				lists.member_id = this.$store.state.member_id
//			
//				console.log(item)
//				var qs = require('qs');
//				that.axios({
//						method: 'post',
//						headers: {
//							"Content-Type": "application/x-www-form-urlencoded"
//						},
//						url: api.dynamic_delete,
//						data: qs.stringify(lists) //传参变量
//					})
//					.then(function(res) {
//						if(res.data.error == 0) {
//							console.log(res)
//							that.list_plan.splice(index, 1);
//							that.$Message.success(res.data.msg);
//						} else {
//							that.$Message.error(res.data.msg);
//							console.log('7', res.data.msg)
//						}
//
//					})
			},
			del_h(){
				let that = this;
				that.absoshow = false
				
			},
		del_que(){
				let that = this;
				that.absoshow = false
				let lists = {};
				lists.rows = 500
				lists.member_id = this.$store.state.member_id
				lists.id = that.lists_id
				var qs = require('qs');
				that.axios({
						method: 'post',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						url: api.dynamic_delete,
						data: qs.stringify(lists) //传参变量
					})
					.then(function(res) {
						if(res.data.error == 0) {
							console.log(res)
							that.list_plan.splice(that.lists_index, 1);
							that.$Message.success(res.data.msg);
						} else {
							that.$Message.error(res.data.msg);
							console.log('7', res.data.msg)
						}

					})
			
		},
			oshow() {
				let that = this;
				that.isshow = !that.isshow
			},
			oeval(item, index) {
				console.log('aadd', item)
				console.log('aadd', item.id)
				let that = this;
				item.parent_id = !item.parent_id
				//				that.list[index].task_record_id_index = item.id
				that.index_val = index

			},
			oeval_a(item,index) {
				console.log('aadd', item)
				console.log('aadd', item.id)
				this.item_oeval_a = item
				this.item_ddid = item.dynamic_id
				
			},
			fenxiang(item, index) {
				console.log('aavvbvb', item)
				let that = this;
				that.itemlise = item
				that.idshow = !that.idshow
			},
			//图片上传
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
				that.imges.unshift(res.data.path)

			},
			tok() {
				var op = {}
				var token_ids = this.$store.state.token;
				op = JSON.stringify(token_ids);
				var str1 = JSON.parse(op);
				this.token = str1
				//				this.token_i = JSON.parse(token_id)
			},
			idshows() {
				let that = this;
				that.idshow = !that.idshow
			},
			idshowsd() {
				let that = this;
				that.idshowd = !that.idshowd
			},
			fenxd(item, index) {

				let that = this;
				
				let value = that.textsidd
				value = value.replace(/(^\s*)|(\s*$)/g, "");
				if(value.length > 0) {
					let josn = {};
					josn.member_id = this.$store.state.member_id
					josn.content = value
					josn.id = that.item_ddid //  图片
					console.log(josn) 
//					return
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
							console.log(res)
							if(res.data.error == 0) {
								that.idshowd = false
								that.$Message.success('回复成功');
								that.uploadFile = []
								that.uploadList = []
								that.textsidd = ''
							} else {
								console.log('----22---', res.data.msg)
							}

						})

				} else {
					that.$Message.error('请输入评论');
				}

			},
		},

	}
</script>

<!--<style></style>-->
<style scoped>
	.sub {
		margin-top: 10px;
		margin-bottom: 100px;
	}
	
	.evaluate {
		width: 900px;
		display: flex;
		font-size: 16px;
		margin: 0 0 0 80px;
		padding-bottom: 20px;
		/*align-items: center;*/
		border-bottom: 1px solid #efefef;
	}
	
	.evaluate_box {
		overflow: auto;
		max-height: 630px;
		background: #fff;
	}
	.evaluate_box2 {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		overflow: auto;
		max-height: 820px;
		background: #fff;
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
		margin-top: 20px;
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
		/*align-items: center;*/
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
	}
	
	.dzan {
		display: flex;
		justify-content: flex-end;
		font-weight: 500 !important;
	}
	
	.dzan div {
		margin-left: 20px;
		margin-bottom: 20px;
	}
	
	.dzanlist {}
	
	.dzanlist div {
		font-weight: 500 !important;
		margin: 0 0 !important;
	}
	
	.idshows {
		position: fixed;
		top: 50%;
		left: 50%;
		width: 1010px;
		min-height: 300px;
		margin: -150px 0 0 -405px;
		background: #cef0fb;
		border-radius: 10px;
	}
	
	.buts button {
		border: 0;
		width: 120px;
		height: 50px;
		border-radius: 25px;
		line-height: 50px;
		text-align: center;
		color: #c0c1c2;
		margin-left: 30px;
		margin-top: 20px;
	}
	
	.buts button:nth-child(1) {
		background: #eee;
	}
	
	.buts button:nth-child(2) {
		color: #fff;
		background: #0ab3e9;
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
.buts_del button{
	border: 0;
	width: 90px;
	height: 40px;
	border-radius: 10px;
	color: #fff;
}
.buts_del button:nth-child(2){
	background: #0ab3e9;
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
	
	.ivu-upload-input {
		border: 1px solid #eee !important;
	}
</style>