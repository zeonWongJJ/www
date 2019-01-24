<template>
	<div class="rele">

		<div class="box_body test-1">
			<div class="task_details_header">
				<!--<div class="return_blue"></div>
				<div class="header_text">计划</div>-->
				<div class="return_blue"></div>
				<div class="header_text" v-if="this.$route.query.oid != undefined">编辑</div>
				<div class="header_text" v-else>发布计划</div>
			</div>

			<div class="rele_box test-1">

				<Form :model="formItem" :label-width="180" @submit.native.prevent>

					<!--<FormItem label="计划类型" class='formItem'>
						<div>
							<ul style="display: flex;">
								<li v-for="(oradio,index) in formItem.oinput">
									<input type="radio" :id="oradio.plan_type" :value="oradio.plan_type" v-model="riod_ress">
									<label :for="oradio.plan_type" style="color: #bbb;">{{oradio.name}}</label>
								</li>
							</ul>
						</div>
					</FormItem>-->

					<!--//编辑-->
					<!--<FormItem label="添加计划" class='formItem' v-if="this.$route.query.oid != undefined">
						<div>
							<div v-for='(ten,index) in dax_bj' class="cpkuang" >
								<div v-model="ten.value">
									<div>
										<label>计划 :</label> <input type="text" name="" :id="index"  v-model="ten.plan_name"  style="width: 600px;"/>
									</div>
									<div>
										<span class="addqukuangnr_del" @click="delcpss(ten,index)">X</span></div>
								</div>
							</div>
							
						</div>
						<div class="div_text">
							<Input v-model="formItem.textarea" type="text" placeholder="请填写任务名称"></Input>
							<button @click="oadd_text()" class="but_j">添加</button>
						</div>

					</FormItem>
					
					
					
					<FormItem label="添加计划" class='formItem' v-else>
						<div>
							<div v-for='(ten,index) in dax' class="cpkuang" :key="index">
								<div v-model="ten.value">
									<div>
										计划{{index+1}} : {{ten}}
									</div>
									<div>
										<span class="addqukuangnr_del" @click="delcpss(ten,index)">X</span></div>
								</div>
							</div>
						</div>
						<div class="div_text">
							<Input v-model="formItem.textarea" type="text" placeholder="请填写任务名称"></Input>
							<button @click="oadd_text()" class="but_j">添加</button>
						</div>

					</FormItem>-->
					<FormItem label="计划标题" class='formItem'>
						<Input  type="text" placeholder="请填写任务名称"></Input>
					</FormItem>
					<FormItem label="计划描述" class='formItem'>
						<Input type="textarea"  :autosize="{minRows: 4,maxRows: 6}" placeholder="请写出详细的计划描述"></Input>
					</FormItem>
					<FormItem label="完成日期" class='formItem'>
						<DatePicker type="date" placeholder="请依次写出年月日" v-model="formItem.dates"></DatePicker>
					</FormItem>
					<!--<FormItem label="关联项目" class='formItem'>
						<div class="xm_ri test-1">
							<div>
								<ul>
									<li v-for="(xmlabel,index) in formItem.ka">
										<input type="checkbox" :id="'xmlabel'+xmlabel.project_id" :value="xmlabel.project_id" v-model="checkedNames">
										<label :for="'xmlabel'+xmlabel.project_id">{{xmlabel.project_name}}</label>
									</li>
								</ul>
							</div>

						</div>
					</FormItem>-->
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

					<FormItem class='formItem'>
						<!--<div class="but_b">
							<button @click="asiospust()">确认发布</button>
							<button>取消</button>
						</div>-->
						<div class="but_b">
							<button @click="asiospust()" v-if="this.$route.query.oid != undefined">确认更新</button>
							<button @click="asiospust()" v-else>确认发布</button>
							<button @click="asiospust_qux()" >取消</button>
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
				riod_ress: [],
				checkedNames: [], //项目
				task_belonged: [], //参与人
				dax: [], //增加计划列表
				dax_bj: [], //编辑计划列表
				token_id: '',
				token_i: {},
				formItem: {
					oinput: [{
							name: '周计划',
							plan_type: 1
						},
						{
							name: '定制计划',
							plan_type: 2
						}
					],
					//					select: '可点击下拉框勾选项目',
					//					select2: '可点击下拉框勾选项目',
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

			}
		},

		methods: {
			
			//发布
			oadd_text() {
				let that = this;
		
				if(this.$route.query.oid != undefined) {
					if(that.formItem.textarea == '') {
						that.$Message.warning('添加计划不能为空')

					} else {
						let arrar= {};
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
					if(tem.plan_sub_id){
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
					}else{
						that.dax.splice(index, 1);
						that.$Message.success("已删除");
					}
			
			},
//			取消
		asiospust_qux(){
			this.$router.back(-1)
		},
			//更新提交
			asiospust() {
				let that = this;
				let date = that.formItem.dates;
				let datas = new Date(date);
				let date_value = datas.getFullYear() + '-' + (datas.getMonth() + 1) + '-' + datas.getDate() + ' ' + datas.getHours() + ':' + datas.getMinutes() + ':' + datas.getSeconds();
				//计划id不为空就更新
				if(that.$route.query.oid != undefined){
					if(that.formItem.dates == '') {
					that.$Message.warning('请选择完成日期')
					return false
				} else {
					var qs = require('qs');
					let lis = {};
				
					lis.plan_id = that.$route.query.oid //计划id
					lis.plan_member_id = this.$store.state.member_id;
					lis.plan_type = that.riod_ress //类型
					lis.plan_sub = JSON.stringify(that.dax_bj ) // 子计划
					lis.plan_time_limit = this.formItem.dates
					lis.plan_project_ids = that.checkedNames // 项目id
					lis.plan_belonged = that.task_belonged // 任务所属人
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
								that.$Message.success('更新成功');
								setTimeout(() => {
									that.$router.push({
										path: 'plan'
									})
								}, 2000);

							} else {
								that.$Message.error(data.msg)
							}

						})
				}
				}else{	//发布提交
					if(that.formItem.dates == '') {
					that.$Message.warning('请选择完成日期')
					return false
				} else {
					let liform = {};
						let testarr = []
					testarr.push(that.formItem.textarea)
					liform.plan_type = that.riod_ress
					liform.plan_member_id = this.$store.state.member_id;// 项目idf
					if(that.dax == ''){
						liform.plan_sub = testarr
					}else{
						liform.plan_sub = that.dax 
					}
					
					liform.plan_time_limit = that.formItem.dates
					liform.plan_project_ids = that.checkedNames // 计划id
					liform.plan_belonged = that.task_belonged // 任务所属人

					//console.log(liform)
					//return
					var qs = require('qs');
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
								that.$Message.success('添加成功');
								setTimeout(() => {
									that.$router.push({
										path: 'plan'
									})
								}, 2000);

							} else {
								that.$Message.error(data.msg)
							}

						})
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
			//项目
			var qs = require('qs');
			that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.projects,
				})
				.then(function(res) {
					if(res.data.error == 0) {

						that.formItem.ka = res.data.data
					} else {
						this.$Message.error(res.data.msg);
					}
				})

			//参与人	
			that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.members,
//					data: qs.stringify(tokens) //传参变量
				})
				.then(function(members) {
					if(members.data.error == 0) {
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