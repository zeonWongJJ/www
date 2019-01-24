<template>
	<div class="rele">

		<div class="box_body test-1">
			<div class="task_details_header">
				<div class="return_blue"></div>
				<div class="header_text" @click="letf_click()">计划列表</div>
				<div class="return_blue"></div>
				<div class="header_text" v-if="itemlist != undefined">编辑计划</div>
				<div class="header_text" v-else>发布计划</div>
			</div>

			<div class="rele_box test-1">

				<Form :model="formItem" :label-width="180" @submit.native.prevent>

					<FormItem label="计划标题" class='formItem'>
						<Input type="text" v-model="itemlist.plan_name" placeholder="请填写计划标题" v-if="itemlist != undefined"></Input>
						<Input type="text" v-model="formItem.title" placeholder="请填写计划标题" v-else></Input>

					</FormItem>
					<FormItem label="计划描述" class='formItem'>
						<Input type="textarea" v-model="itemlist.plan_desc" :autosize="{minRows: 4,maxRows: 6}" placeholder="请写出详细的计划描述" v-if="itemlist != undefined"></Input>
						<Input type="textarea" v-model="formItem.textarea" :autosize="{minRows: 4,maxRows: 6}" placeholder="请写出详细的计划描述" v-else></Input>

					</FormItem>
					<FormItem label="完成日期" class='formItem'>
						<!--<DatePicker type="date" placeholder="请依次写出年月日" v-model="itemlist.plan_date_limit"  v-if="itemlist != undefined"></DatePicker>-->
						<!--<DatePicker type="date" placeholder="请依次写出年月日" v-model="formItem.dates" v-else></DatePicker>-->

						<DatePicker type="datetime" placeholder="请依次写出年月日时" v-model="itemlist.plan_date_limit" v-if="itemlist != undefined"></DatePicker>
						<DatePicker type="datetime" placeholder="请依次写出年月日时" v-model="formItem.dates" v-else></DatePicker>
					</FormItem>

					<FormItem label="参与人" class='formItem'>
						<ul class="ul_Checkbox" v-if="itemlist != undefined">
							<li v-for='(label,index) in group_members_x'>
								<!--<div>{{label}}</div>-->
								<div>
									{{label.group.group_name}}
								</div>
								<div v-for='(labels,index) in label.list'>
									<div>
										<input type="checkbox" :id="'member_id'+labels.member_id" :value="labels.member_id" v-model="task_belonged">
										<label :for="'member_id'+labels.member_id">{{labels.real_name}}</label>
									</div>
								</div>
							</li>
						</ul>
						<ul class="ul_Checkbox" v-else>
							<li v-for='(label,index) in group_members_x'>
								<!--<div>{{label}}</div>-->
								<div>
									{{label.group.group_name}}
								</div>
								<div v-for='(labels,index) in label.list'>
									<div>
										<input type="checkbox" :id="'member_id'+labels.member_id" :value="labels.member_id" v-model="task_belonged">
										<label :for="'member_id'+labels.member_id">{{labels.real_name}}</label>
									</div>
								</div>
							</li>
						</ul>
					</FormItem>
					<FormItem class='formItem'>
						<!--<div class="but_b">
							<button @click="asiospust()">确认发布</button>
							<button>取消</button>
						</div>-->
						<div class="but_b">
							<button @click="asiospust()" v-if="itemlist != undefined">确认更新</button>
							<button @click="asiospust()" v-else>确认发布</button>
							<button @click="asiospust_qux()">取消</button>
						</div>
						<!--<Button type="primary">确认发布</Button>
						<Button type="ghost" style="margin-left: 8px">取消</Button>-->
					</FormItem>
				</Form>
			</div>
		</div>
		<div v-show="!onshows" style="position: fixed;top: 0;left: 0;right: 0;bottom: 0;width: 100%;height: 100%;background: rgba(0,0,0,0); z-index: 999999;">

		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default {
		data() {
			return {
				itemlist: [], //编辑
				riod_ress: [],
				checkedNames: [], //项目
				task_belonged: [], //参与人
				dax: [], //增加计划列表
				dax_bj: [], //编辑计划列表
				token_id: '',
				token_i: {},
				formItem: {
					title: '',
					checkbox: [],
					dates: '',
					time: '',
					textarea: '',
					ka: [],
					members: [],
					xmlist: [],
					label: []

				},

				imgName: '',
				visible: false,
				uploadList: [],
				isshow: false,
				indexs: '', //保存传值

				//				v2
				group_members_x: [],
				onshows: true,
			}
		},

		methods: {
			letf_click() {
				let that = this;
				that.$router.back(-1)
			},
			//发布
			oadd_text() {
				let that = this;

				if(this.$route.query.oid != undefined) {
					if(that.formItem.textarea == '') {
						that.$Message.warning('添加计划不能为空')

					} else {
						let arrar = {};
						arrar.plan_name = that.formItem.textarea
						arrar.plan_sub_id = ''
						that.dax_bj.push(arrar);
						that.formItem.textarea = '';
					}
				} else {
					if(that.formItem.textarea == '') {
						that.$Message.warning('添加计划不能为空')

					} else {
						that.dax.push(that.formItem.textarea);
						that.formItem.textarea = '';
					}
				}

			},
			delcpss(tem, index) { //删除主营产品x
				let that = this;
				var qs = require('qs');
				if(tem.plan_sub_id) {
					let tem_id = {}
					tem_id.plan_sub_id = tem.plan_sub_id
					that.axios({
							method: 'post',
							header: {
								'Content-Type': 'application/x-www-form-urlencoded'
							},
							url: api.plan_deletesub,
							data: qs.stringify(tem_id) //传参变量
						})
						.then(function(value) {
							let data = value.data
							if(data.error == 0) {
								that.$Message.success("已删除");
								that.dax_bj.splice(index, 1);
							} else {
								that.$Message.error(data.msg)
							}

						})
				} else {
					that.dax.splice(index, 1);
					that.$Message.success("已删除");
				}

			},
			//			取消
			asiospust_qux() {
				this.$router.back(-1)
			},
			//更新提交
			asiospust() {

				let that = this;
				let date = ''

				if(that.itemlist) {
					date = that.itemlist.plan_date_limit
				} else {
					date = that.formItem.dates;
				}
				//				let date = that.itemlist.add_date
				let datas = new Date(date);
				let date_value = datas.getFullYear() + '-' + (datas.getMonth() + 1) + '-' + datas.getDate() + ' ' + datas.getHours() + ':' + datas.getMinutes() + ':' + datas.getSeconds();
				//计划id不为空就更新
				if(that.itemlist != undefined) {
					if(that.itemlist.plan_date_limit == '') {
						that.$Message.warning('请选择完成日期')
						return false
					} else {
						var qs = require('qs');
						let lis = {};
						lis.plan_sub_id = that.itemlist.plan_sub_id
						lis.member_id = that.$store.state.member_id;
						lis.plan_name = that.itemlist.plan_name
						lis.plan_desc = that.itemlist.plan_desc
						lis.plan_belonged = that.task_belonged
						lis.plan_time_limit = date_value
						if(that.onshows) {

							that.axios({
									method: 'post',
									header: {
										'Content-Type': 'application/x-www-form-urlencoded'
									},
									url: api.plan_update,
									data: qs.stringify(lis) //传参变量
									//							data: lis //传参变量
								})
								.then(function(lis) {
									let data = lis.data
									if(data.error == 0) {
//										that.onshows = false
										that.$Message.success('更新成功');
										setTimeout(() => {
											that.onshows = true
											that.$router.back(-1)
										}, 2000);

									} else {
										that.$Message.error(data.msg)
//										that.onshows = false
										setTimeout(() => {
											that.onshows = true
										}, 2000);
									}

								})
						}

					}
				} else {
					//发布提交
					if(that.formItem.dates == '') {
						that.$Message.warning('请选择完成日期')
						return false
					} else {
						let liform = {};
						//					let testarr = []
						//					testarr.push(that.formItem.textarea)
						//					liform.plan_type = that.riod_ress
						//					liform.plan_member_id = that.$store.state.member_id;// 项目idf
						//					if(that.dax == ''){
						//						liform.plan_sub = testarr
						//					}else{
						//						liform.plan_sub = that.dax 
						//					}
						liform.member_id = that.$store.state.member_id; // 项目idf
						liform.plan_id = that.$route.query.pula_id_x
						liform.plan_name = that.formItem.title
						liform.plan_desc = that.formItem.textarea
						liform.plan_belonged = that.task_belonged
						liform.plan_time_limit = date_value
						//					liform.plan_file = 

						//console.log(liform)
						//return
						var qs = require('qs');
						
						if(that.onshows) {
							that.onshows = false
							that.axios({
									method: 'post',
									header: {
										'Content-Type': 'application/x-www-form-urlencoded'
									},
									url: api.plan_insert,
									data: qs.stringify(liform) //传参变量
								})
								.then(function(value) {
									let data = value.data
									if(data.error == 0) {
										if(that.$route.query.plan_type_x == 2) {
											that.$Message.success('添加成功');
											setTimeout(() => {
												//									that.$router.push({
												//										path: 'plan_x',
												//									})
												that.onshows = true
												that.$router.back(-1)
											}, 2000);
										} else {
											that.$Message.success('添加成功');
											setTimeout(() => {
												//									that.$router.push({
												//										path: 'plan_x',
												//									})
												that.onshows = true
												that.$router.back(-1)
											}, 2000);
										}

									} else {
										that.$Message.error(data.msg)
										setTimeout(() => {
											that.onshows = true
										}, 2000);
									}

								})

						}

					}
				}

			},

			//拿数据
			oplan_children() {
				let that = this
				let liform = {};
				liform.plan_id = this.$route.query.oid
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.plan_children,
						data: qs.stringify(liform) //传参变量
					})
					.then(function(res_val) {
						let data = res_val.data
						if(data.error == 0) {
							let arre = data.data.sub
							for(var j = 0; j < arre.length; j++) {
								let idsu = arre[j].plan_sub_id
								that.riod_ress = arre[j].plan_type
								let plan_ids = arre[j].plan_project_ids.split(",");
								let plan_belonged = arre[j].plan_belonged.split(",");
								that.checkedNames = plan_ids
								that.task_belonged = plan_belonged

								//								let date = arre[j].plan_add_time
								//								let datas = new Date(date);
								//								let date_value = datas.getFullYear() + '-' + (datas.getMonth() + 1) + '-' + datas.getDate() ;
								//								that.formItem.dates = date_value
								//								alert(date_value)
								let oar = [{
									plan_sub_id: idsu,
									plan_name: arre[j].plan_name
								}]
								for(var l = 0; l < oar.length; l++) {
									that.dax_bj.push(oar[l])
									console.log(that.dax_bj)
								}
							}

						} else {
							that.$Message.error(data.msg)
						}
					})
			},

			oisshow(index) {
				let that = this;
				that.isshow = !that.isshow
			},

		},
		created() {
			//			let that = this;
			//			let oarrs = this.$route.query.oarr
			//			//			return
			if(this.$route.query.oid != undefined) {
				this.oplan_children()
				//				let plan_belonged = this.$route.query.oarr.plan_belonged.split(",");
				//				let plan_ids = this.$route.query.oarr.plan_project_ids.split(",");
				//				that.dax.push(oarrs.plan_name)
				//				that.riod_ress = this.$route.query.oarr.plan_type;
				//				that.formItem.dates = this.$route.query.oarr.plan_time_limit;
				//				that.checkedNames = plan_ids
				//				that.task_belonged = plan_belonged
			}

		},
		mounted() {

			let that = this;
			that.itemlist = that.$route.query.item
//			if(that.itemlist) {
//				that.task_belonged = that.itemlist.plan_belonged.split(","); // 任务所属人
//			}
			if(that.itemlist) {
				if( that.itemlist.plan_belonged.length != undefined ){
					that.task_belonged = that.itemlist.plan_belonged.split(","); // 任务所属人
				}else{
					that.task_belonged.push('-1',that.itemlist.plan_belonged);
				}
				
			}
			//项目

			var qs = require('qs');
			//	

			//参与人	
			that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.group_members,
					//					data: qs.stringify(tokens) //传参变量
				})
				.then(function(members) {
					if(members.data.error == 0) {
						console.log('11111111', members)

						that.group_members_x = members.data.data.list
						//						that.formItem.members = members.data.data
						//						var arr = that.formItem.members;
						//						var test = {};
						//						var typeKey = 'department_name';
						//						for(var i = 0; i < arr.length; i++) {
						//							var user = arr[i];
						//							var type = user[typeKey];
						//							if(!test[type]) test[type] = [];
						//							test[type].push(user);
						//						}
						//						that.formItem.label = test
						//						that.formItem.ka = members.data.data
					} else {
						this.$Message.error(members.data.msg);
					}

				})

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
	
	.header_text {
		cursor: pointer;
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
	
	.cpkuang {
		/*display: flex;*/
	}
	
	.cpkuang>div {
		display: flex;
		justify-content: space-between;
		padding: 0px 8px;
		border: 1px solid #ccd9e6;
		margin-right: 5px;
		margin-bottom: 10px;
		font-size: 14px;
		color: #415161;
		border-radius: 5px;
	}
	
	.cpkuang>div span {
		/*float: right;*/
		margin-left: 25px;
	}
	
	.cpkuang div span:hover {
		color: #00c1de;
		cursor: pointer;
	}
	
	.addqukuangnr_del {
		background: #ddd;
		padding: 3px 8px;
		border-radius: 50%;
	}
	
	.but_j {
		border: 1px solid #ddd;
		padding: 0 10px;
		background: none;
		height: 40px;
		border-radius: 20px;
	}
</style>

<style type="text/css">
	.div_text .ivu-input-wrapper {
		width: 90%;
		margin-right: 8px;
	}
	
	.ivu-form .ivu-form-item-label {
		font-size: 16px !important;
		color: #283033 !important;
	}
	
	.ivu-date-picker {
		width: 720px;
	}
</style>