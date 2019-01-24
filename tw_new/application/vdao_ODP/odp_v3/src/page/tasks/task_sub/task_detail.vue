<template>
	<div class="my_kask_div">
		<div class="tit_box">
			<ul class="tit_box_ul">
				<li @click="my_task">全部任务</li>
				<li @click="all_tasks">计划任务</li>
				<li @click="list_tasks">发布任务</li>
				<li @click="release_task">任务榜单</li>
				<li @click="planned_task">我的任务</li>
			</ul>
		</div>
		<div class="box_body test-1">
			<div class="task_details_header">
				<div class="return_blue"></div>
				<div class="header_text">任务详情</div>
			</div>
			<div class="task_details_title">
				<div class="title">
					<span>{{josnt.task_title}}<span @click="omyAdd()" class="addPlan">添加到我的计划</span></span>
					<Modal v-model="myAdd" width="666px" ok-text="确认添加" title="添加到我的计划" @on-ok="jihuaok()" @on-cancel="cancel()">
				
						<div class="xm_ri test-1">
							<div>
								<ul>
									<li v-for="(daxlabel,index) in dax">
										<input type="checkbox" :id="'plan_id'+daxlabel.plan_sub_id" :value="daxlabel.plan_sub_id" v-model="picked">
										<label :for="'plan_id'+daxlabel.plan_sub_id">{{daxlabel.plan_name}}</label>
									</li>
								</ul>
							</div>
						</div>
					</Modal>
				</div>
				<div class="details">
					<div>
						任务描述：
					</div>
					<div >
						{{josnt.task_desc}}
					</div>
				</div>
				<!--完成日期-->
				<div class="details">
					<div>
						完成日期：
					</div>
					<div>
						{{josnt.task_add_date}}
					</div>
				</div>

				<!--关联项目-->
				<div class="details">
					<div>
						关联项目：
					</div>
					<div>
						<span v-if="josnt.task_project_ids == ''">  暂无关联项目</span>
						<span class="addSeparate" v-if="josnt.task_project_ids != ''" v-for="itemids in josnt.task_project_ids">{{itemids}}</span>
					</div>
				</div>
				<!--关联计划-->

				<div class="details">
					<div>
						关联计划：
					</div>
					<div>
						<span v-if="josnt.task_plan_ids == ''">  暂无关联计划</span>
						<span class="addSeparate" v-else v-for="itemi in josnt.task_plan_ids">{{itemi}}</span>
					</div>
				</div>
				<!--参与人-->
				<div class="details">
					<div>
						参与人：
					</div>
					<div>
						<span v-if="josnt.task_belonged == ''">  暂无参与人</span>
						<span class="addSeparate" v-else v-for="itembelo in josnt.task_belonged ">{{itembelo}}</span>
					</div>
				</div>
				<!--文件-->
				<div class="details">
					<div>
						文件资料：
					</div>
					<div>
						<span v-if="!josnt.task_file_urls">  暂无文件</span>
						<div v-else class="del_file">
							<div v-for="itfile in josnt.task_file_urls ">
								<a :href="uploadFileUrls + '/' +itfile" :download="itfile">{{itfile}}</a>
							</div>
						</div>
					</div>
				</div>
				<!--图片-->
				<div class="details">
					<div>
						图片资料：
					</div>
					<div>
						<span v-if="!josnt.task_pic_urls">  暂无图片</span>
						<div v-else class="del_file">
							<div v-for="itpic in josnt.task_pic_urls ">
								<a :href="uploadFileUrls + '/' + itpic" :download="itpic"><img :src="uploadFileUrls + '/' + itpic" /></a>
							</div>
						</div>
					</div>
				</div>

			</div>



			<div class="ul_div" v-for="(item,index) in detailsItem" :data="list_id">
				<div class="li_div">
					<div>
						<p class="li_div_text">{{item.department_name}}</p>
					</div>
					<div :class="getBgC(item.status)">
						<div class="personBox">
							<div class="person" v-if="item.status == 1 || item.status == 2">
								<span v-if="item.real_name">
									{{item.real_name}}	
								</span>
								<span v-else>
									{{real_na}}
								</span>
								<!--<span v-else>
									{{item.real_name}}
								</span>-->
							</div>
						</div>
						<div class="progressBox">
							<!--状态为3，4无进度条-->
							<div class="slider_box" v-if="item.status == 1 || item.status == 2">
								<div class="progress">
									<Slider v-model="item.task_progress" show-tip="never" :tip-format="format" @on-change="prog(index)"></Slider>
								</div>
								<div class="progressNum">{{Number(item.task_progress)}}%</div>
							</div>
						</div>
						<div class="btnBox">
							<!--状态为2，4无按钮-->
							<div v-if="item.status == 1">
								<div class="assign btn" @click="task_giveup(index)">放弃</div>
							</div>

							<div v-if="item.status == 2">
								<div class="assign btn" v-if="valueHalf!=''">{{ valueHalf }}</div>
								<div class="assign btn" @click="ostarer(index)" v-else>评分</div>
								<Modal v-model="starer" @on-ok="ok(index)">
									<div>
										<div class="scoreBox" style="text-align: center;">
											<p style="font-size:16px;margin-bottom: 10px;">评分</p>

											<!--<Rate allow-half v-model="valueHalf" on-change></Rate>-->
											<Rate v-model="valueHalf"></Rate>
											<div>
												<span style="color: #f5a623">{{ valueHalf }}</span>
											</div>
										</div>
									</div>
								</Modal>
							</div>

							<div class="assign_box" v-if="item.status == 0">
								<div class="assign btn" @click="sishow(index)">指派</div>
								<div class="accept btn" @click="task_receive(index)">接手</div>
							</div>

							<div v-if="item.status == 1">

							</div>
						</div>
						<div class="more">
							<div class="more_more">
								<div class="moreBox" v-if="item.status === 1">
									<!--<div @click.stop="toEvaluate(index)">发布动作记录</div>-->
									<div @click.stop="journal(index)">动作记录
										<div :class="{newAction:item.newAction}"></div>
									</div>
									<div @click="task_unwanted(index)">取消流程</div>
								</div>

								<div class="moreBox" v-if="item.status === 2">
									<!--<div @click.stop="toEvaluate(index)">发布动作记录</div>-->
									<div @click.stop="journal(index)">动作记录</div>
								</div>

								<div class="moreBox" v-if="item.status === 0">
									<!--<div @click.stop="toEvaluate(index)">发布动作记录</div>-->
									<div @click.stop="journal(index)">动作记录
										<div :class="{newAction:item.newAction}"></div>
									</div>
									<div @click="task_unwanted(index)">取消流程</div>
								</div>

								<div class="moreBox" v-if="item.status === -1">
									<div @click="task_recovery(index)">恢复流程</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div v-if="assign" class="divshow">
				<div class="divshow_div">
					<div class="divshow_divtit">
						指派人
					</div>
					<ul class="ul_Checkbox">
						<li v-for='(label,index) in assignItem'>
							<div>{{index}}</div>
							<div v-for='labels in label'>

								<div>
									<input type="radio" :id="labels.member_id" name="radios" :value="labels.member_id" v-model="task_belonged">
									<label :for="labels.member_id">{{labels.real_name}}</label>

								</div>
							</div>
						</li>
					</ul>
					<div class='divshow_but'>
						<button style="background: #00C1DE;" @click.stop="iszhipa()">确定选择</button>
						<button style="background: #ddd;" @click.stop="assign = !assign">取消</button>
					</div>
				</div>
			</div>
			<eva-luate :name="real_name" :kid="this.$route.query.task_id"></eva-luate>
		</div>

	</div>
</template>

<script>
	import api from '@/api/api'
	import evaLuate from '@/page/subcomponent/task_detail_s'
	export default {
		components: {
			evaLuate
		},
		data() {
			return {
				uploadFileUrls: api.uploadFileUrl,
				valueHalf: '', //评分
				task_id: '', //任务id
				member_id: '', //
				department_id: '', //会员id
				list_id: [],
				starer: false,
				isActive: 0,
				real_name: '', //会员名字
				task_belonged: [], //参与人
				josnt: {
					task_id: '', //任务id
					task_title: '', //任务变体
					task_desc: '', //编辑
					task_add_date:'',//s时间
					task_catchers: '', //部门
					task_plan_ids: [], //项目，
					task_project_ids: [], //计划
					task_belonged: [], //参与人
					task_file_urls: [], //文件
					task_pic_urls: [], //图片
				},
				label: [], //
				val: '', //进度
				myAdd: false,
				showMoreDetails: 1,
				assign: false,
				delClick: true,
				assignItem: [],
				datails: '',
				lenstat: '',
				detailsItem: [],
				iszhipa_id: '', //id
				status_sta: '', //指派状态
				dax: [], //计划列表
				picked: [], //m计划存组
				task_procedure_id: '', //返回的id
				real_na: '', //指派返回的名字
				sishow_index:'',
			}
		},
		mounted() {
			this.task_id = this.$route.query.task_id;
			this.$store.state.task_id = this.$route.query.task_id;
			this.member_id = this.$store.state.member_id;
			this.department_id = this.$store.state.department_id;
			this.real_name = this.$store.state.real_name;
			this.apipost()

			//			this.prog()
			//			this.task_giveup()
//						this.task_receive()
		},
		computed: {
			someDatails() {
				var len = this.josnt.task_desc.length;
				if(len > 4) {
					len = 4
				}
				return this.josnt.task_desc.slice(0, len)
			}
		},
		methods: {

			omyAdd() {
				let that = this
				that.myAdd = !that.myAdd
			},
			okinp() {
				let that = this;
				for(var t = 0; t < that.assignItem.length; t++) {}

			},
			format(val) {
				let that = this;
				let id_val = true
//				console.log('-----------------',val)
//				that.detailsItem.task_progress = val
			},
			jihuaok() {
				let that = this
				let okhae = {};
				okhae.task_id = that.task_id
				okhae.plan_sub_id = that.picked
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.task_tasktoplan,
						data: qs.stringify(okhae) //传参变量
					})
					.then(function(tasktoplan) {
						if(tasktoplan.data.error == 0){
							that.$Message.success('添加成功！');
						}
					})

			},
			//			指派
			sishow(index) {
				let that = this
				that.assign = !that.assign
				that.iszhipa_id = that.detailsItem[index].task_catcher;
				that.sishow_index = index;

			},
			iszhipa() {
				let that = this
				var index = that.sishow_index
				let task_assign = {}
				task_assign.task_id = that.task_id
				task_assign.task_member_id = that.task_belonged // 任务所属人
				task_assign.task_catcher = that.iszhipa_id
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.task_assign,
						data: qs.stringify(task_assign) //传参变量
					})
					.then(function(task_assign) {
						if(task_assign.data.error == 0) {
							that.detailsItem[index].real_name = task_assign.data.data.real_name
							that.assign = false
							that.detailsItem[index].status = 1;
							that.detailsItem[index].task_procedure_id = task_assign.data.data.task_procedure_id;
							
							that.$Message.info('指派成功！');

						} else {
							that.$Message.error(task_assign.data.msg);
						}

					})

			},
			cancel() {
				let that = this
				this.$Message.info('已取消');
				let arr = []
				that.picked = arr
			},
			
			all_tasks() {
				let that = this;
				that.$router.push({
					path: 'all_tasks'
				})
			},
			my_task() {
				let that = this;
				that.$router.push({
					path: 'my_task'
				})
			},
			journal(index) {
				let that = this;
				//				that.$router.push({
				//					path: 'journal'
				//				})
				that.isActive = index;
				let kid = that.task_id
				let department = that.detailsItem[index].task_catcher;
				this.$router.push({
					path: "/journal",
					query: {
						department,
						kid
					}
				});
			},
			list_tasks() {
				let that = this;
				that.$router.push({
					path: 'list_tasks'
				})
			},
			release_task() {
				let that = this;
				that.$router.push({
					path: 'release_task'
				})
			},
			planned_task() {
				let that = this;
				that.$router.push({
					path: 'planned_task'
				})
			},

			toEvaluate(index) {
				let that = this;
				let kid = that.task_id
				that.isActive = index;
				let department = that.detailsItem[index].task_catcher;
				this.$router.push({
					path: "/evaluate",
					query: {
						department,
						kid
					}
				});
			},
			getBgC(stat) {
				switch(stat) {
					case 1:
						return 'bg_yellow'
						break;
					case 2:
						return 'bg_blue'
						break;
					case 3:
						return 'bg_pink'
						break;
					case -1:
						return 'bg_gray'
						break;
					default:
//						console.log('getBgC方法出错，是不是stat参数有变？')
						return 'bg_pink'
				}
			},
			//			首次
			apipost() {
				let that = this;
				let josn = {}
				let plan_li = {}
				plan_li.member_id = this.$store.state.member_id;
				josn.task_id = that.task_id
				var qs = require('qs');
				that.axios({
					method: 'post',
					header: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					url: api.task_detail,
					data: qs.stringify(josn) //传参变量
				})
				.then(function(res) {
					that.josnt.task_id = res.data.data.task_id
					that.josnt.task_title = res.data.data.task_title
					that.josnt.task_desc = res.data.data.task_desc
					that.josnt.task_add_date = res.data.data.task_add_date
					that.josnt.task_file_urls = res.data.data.task_file_urls
					that.josnt.task_pic_urls = res.data.data.task_pic_urls
					that.josnt.task_member_id = res.data.data.task_member_id
					that.detailsItem = res.data.data.task_procedures
					if(res.data.data.task_project_ids_data){
						for(var q = 0;q<res.data.data.task_project_ids_data.length;q++){ //项目，
							that.josnt.task_project_ids.push(res.data.data.task_project_ids_data[q].project_name)
						}
					}
					if(res.data.data.task_plan_ids_data){
						for(var w = 0;w<res.data.data.task_plan_ids_data.length;w++){ //计划
							that.josnt.task_plan_ids.push(res.data.data.task_plan_ids_data[w].plan_name)
						}
					}
					if(res.data.data.task_belonged_data){
						for(var r = 0;r<res.data.data.task_belonged_data.length;r++){ //参与人
							that.josnt.task_belonged.push(res.data.data.task_belonged_data[r].real_name)
						}
					}
//					let catcher = res.data.data.task_catcher

				});
				//	参与人
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.members,
						
					})
					.then(function(members) {

						that.label = members.data.data
						var arr = that.label;
						var test = {};
						var typeKey = 'department_name';
						for(var i = 0; i < arr.length; i++) {
							var user = arr[i];
							var type = user[typeKey];
							if(!test[type]) test[type] = [];
							test[type].push(user);
						}
						that.assignItem = test

					});
				//	计划列表	
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.plans,
							data: qs.stringify(plan_li) //传参变量
					})
					.then(function(plans) {
						if(plans.data.error == 0) {
								that.dax = plans.data.data
					}else{
							that.$Message.error(plans.data.msg);
						}

					})

			},
			//			任务详情》接任务
			task_receive(index) {
				let that = this;
				let receive = {}
				receive.task_id = that.josnt.task_id
				receive.task_member_id = that.member_id
				receive.task_catcher = that.detailsItem[index].task_catcher
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.task_receive,
						data: qs.stringify(receive) //传参变量
					})
					.then(function(task_receive) {
						if(task_receive.data.error == 0) {
							that.detailsItem[index].real_name = that.real_name
							that.detailsItem[index].status = 1
							that.detailsItem[index].task_procedure_id = task_receive.data.data.task_procedure_id
						} else {
							that.$Message.error(task_receive.data.msg);
						}

					})
			},
			//流程
			prog(index) {
				let that = this;
				let number_prog = that.detailsItem[index].task_progress
				let task_procedure_id_n = ''
				if(!that.task_procedure_id) {
					task_procedure_id_n = that.detailsItem[index].task_procedure_id
				} else {
					task_procedure_id_n = that.task_procedure_id
				}
				let progres = {}
		
				progres.task_member_id = that.member_id
				progres.task_procedure_id = task_procedure_id_n
				progres.task_progress = Number(number_prog)
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.task_progress,
						data: qs.stringify(progres) //传参变量
					})
					.then(function(prog) {
						if(prog.data.error == 0) {
							if(Number(prog.data.data.progress) > 99) {
								that.detailsItem[index].status = 2

							} else {
								that.detailsItem[index].status = 1
							}
						} else {
							that.$Message.error(prog.data.msg);
						}
					})

			},
			//			任务详情》放弃任务
			task_giveup(index) {
				let that = this;
				let receive = {}
				receive.task_member_id = that.member_id
					if(!that.task_procedure_id) {
					receive.task_procedure_id = that.detailsItem[index].task_procedure_id
				} else {
					receive.task_procedure_id = that.task_procedure_id
				}
				receive.task_procedure_id = that.detailsItem[index].task_procedure_id
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.task_giveup,
						data: qs.stringify(receive) //传参变量
					})
					.then(function(task_giveup) {
						if(task_giveup.data.error == 0) {
							that.detailsItem[index].status = 0
						} else {
							that.$Message.error(task_giveup.data.msg);
						}

					})
			},
			//			取消流程
			task_unwanted(index) {
				let that = this;
				let task_unwanted = {}
				task_unwanted.task_id = that.josnt.task_id
				task_unwanted.task_catcher = that.detailsItem[index].task_catcher
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.task_unwanted,
						data: qs.stringify(task_unwanted) //传参变量
					})
					.then(function(task_unwanted) {
						if(task_unwanted.data.error == 0) {
							that.detailsItem[index].status = -1
							that.detailsItem[index].task_procedure_id = task_unwanted.data.data.task_procedure_id;
							that.$Message.success(task_unwanted.data.msg);
						} else {
							that.$Message.error(task_unwanted.data.msg);
						}

					})
			},
			//					会复流程
			task_recovery(index) {
				let that = this;
				let task_recovery = {}
				task_recovery.task_procedure_id = that.detailsItem[index].task_procedure_id
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.task_recovery,
						data: qs.stringify(task_recovery) //传参变量
					})
					.then(function(task_recovery) {
						if(task_recovery.data.error == 0) {
							that.detailsItem[index].status = 0;
							that.$Message.success(task_recovery.data.msg);
						} else {
							that.$Message.error(task_recovery.data.msg);
						}

					})
			},

			//			流程评分
			ostarer(index) {
				let that = this
				that.starer = !that.starer
				that.task_procedure_id = that.detailsItem[index].task_procedure_id
			},
			ok(index) {
				let that = this;
				let score = {}
				score.task_procedure_id = that.task_procedure_id
				score.task_score = that.valueHalf
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.task_procedure_score,
						data: qs.stringify(score) //传参变量
					})
					.then(function(score) {
						if(score.data.error == 0) {
							that.$Message.success('评分成功');
						} else {
							that.$Message.error(score.data.msg);
						}

					})
			},
		}
	}
</script>
<style type="text/css">
	/*.my_kask_div .ivu-slider-wrap {
		background: rgba(255, 255, 255, .5);
	}
	
	.my_kask_div .ivu-slider-bar {
		background: #fff;
	}
	
	.my_kask_div .ivu-slider-button {
		border: #fff;
	}
	
	.my_kask_div .ivu-slider-button:hover {
		transform: none;
	}
	
	.my_kask_div .ivu-modal {
		border-radius: 14px;
	}
	
	.my_kask_div .ivu-modal-body {
		margin-top: 20px;
	}
	
	.my_kask_div .ivu-modal-close {
		top: 14px;
	}
	
	.my_kask_div .ivu-modal-header {
		padding: 0;
		height: 62px;
		line-height: 64px;
		background: #f5f5f5;
		border-bottom: none;
		border-radius: 14px;
	}
	
	.my_kask_div .ivu-modal-header p,
	.my_kask_div .ivu-modal-header-inner {
		font-size: 20px;
		font-weight: normal;
		color: #283033;
	}
	
	.my_kask_div .ivu-modal-header-inner {
		margin-left: 20px;
	}
	
	.my_kask_div .ivu-modal-footer {
		border-top: none;
		text-align: center;
	}*/
</style>
<style scoped>
	.my_kask_div .ivu-slider {
		width: 100%;
	}
	
	.box_body {
		position: absolute;
		top: 0px;
		width: 1090px;
		height: 100%;
		overflow: hidden;
		overflow-y: scroll;
		overflow-x: auto;
		background: #f9f9f9;
	}
	
	.test-1::-webkit-scrollbar-track {
		/*滚动条里面轨道*/
		/*-webkit-box-shadow: inset 0 0 5px #b0c0d0;*/
		border-radius: 10px;
		background: #fff;
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
		background: url(../../../assets/img/return_bllue.png);
		margin: 0 7px 0 25px;
	}
	
	.task_details_title {
		/*min-height: 155px;*/
	}
	
	.title {
		margin: 35px auto 21px;
		font-size: 28px;
		width: 700px;
		letter-spacing: 1px;
		text-align: center;
	}
	
	.title>span {
		position: relative;
		color: #283033;
		text-align: center;
	}
	
	.title .addPlan {
		display: inline-block;
		background: #394044;
		color: #fff;
		position: absolute;
		font-size: 16px;
		line-height: 28px;
		width: 160px;
		height: 35px;
		line-height: 35px;
		border-radius: 17px;
		margin: 3px 0 3px 27px;
	}
	
	.details {
		width: 1054px;
		color: rgba(40, 48, 51, .6);
		letter-spacing: 1px;
		font-size: 14px;
		/*line-height: 20px;*/
		display: flex;
		margin: 15px 55px;
	}
	
	.details div:nth-child(1) {
		flex: 0 0 80px;
		line-height: 31px;
	}
	.details>div:nth-child(2) {
		width: 900px;
		padding: 5px ;
		border-radius: 5px;
		background: #fff;
	}
	.show_more_details {
		color: #0ab3e9;
		cursor: pointer;
	}
	
	.assign_box {
		display: flex;
	}
	
	.assign {
		margin-right: 15px;
	}
	/*板块*/
	
	.ul_div {
		width: 99%;
		padding: 15px 55px;
		position: relative;
		transition: all 0.3s;
	}
	
	.li_div:hover {
		transform: scale(1.01);
		box-shadow: 0 0 15px rgba(10, 179, 233, .2);
	}
	
	.li_div {
		width: 976px;
		height: 70px;
		line-height: 134px;
		border-radius: 20px;
		box-shadow: 0 0 5px rgba(10, 179, 233, .06);
		display: flex;
		align-items: center;
		overflow: hidden;
	}
	/*流程放弃背景灰色*/
	
	.bg_gray {
		background: #9B9B9B;
	}
	
	.bg_blue {
		background: #0ab3e9;
		/*蓝色*/
	}
	
	.bg_yellow {
		background: #ffc324;
		/*黄色*/
	}
	
	.bg_pink {
		background: #ff5b6e;
		/*粉色*/
	}
	
	.li_div>div:nth-child(1) {
		width: 153px;
		position: relative;
		text-align: center;
		background: #fff;
		border-radius: 20px 0 0 20px;
	}
	
	.li_div_text {
		font-size: 22px;
		line-height: 70px;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		color: rgba(40, 48, 51, .9);
	}
	
	.li_div>div:nth-child(2) {
		text-align: center;
		flex: 2;
		height: 134px;
		display: flex;
		align-items: center;
		color: #fff;
	}
	
	.personBox {
		width: 279px;
	}
	
	.person {
		width: 111px;
		height: 40px;
		border-radius: 29px;
		background: #fff;
		font-size: 18px;
		line-height: 40px;
		margin: 0 90px 0 60px;
		color: #283033;
	}
	
	.progressBox {
		width: 269px;
		display: flex;
		align-items: center;
	}
	
	.slider_box {
		display: flex;
	}
	
	.progress {
		width: 139px;
	}
	
	.progressNum {
		margin-left: 10px;
		font-size: 18px;
		line-height: 40px;
	}
	
	.btnBox {
		width: 179px;
		display: flex;
		flex-direction: row-reverse;
		align-items: center;
	}
	
	.btnBox .btn {
		width: 82px;
		height: 40px;
		border: 2px solid #fff;
		border-radius: 20px;
		font-size: 16px;
		line-height: 36px;
		cursor: pointer;
	}
	
	.btnBox .btn+.btn {
		margin-right: 15px;
	}
	
	.more {
		width: 86px;
		text-align: center;
	}
	
	.more_more:hover div.moreBox {
		display: flex;
	}
	
	.moreBox {
		width: 100px;
		display: none;
		background: #fff;
		border-radius: 2px;
		position: absolute;
		top: 0px;
		right: 0;
		z-index: 999999;
		flex-direction: column;
		font-size: 14px;
		line-height: 44px;
		color: #283033;
	}
	
	.moreBox>div {
		cursor: pointer;
		border-bottom: 1px solid #eee;
	}
	
	.more_more {
		height: 40px;
		width: 40px;
		margin: auto;
		background: url('../../../assets/img/arrow_down.png') no-repeat;
		background-position: 10px 5px;
	}
	
	.newAction {
		position: absolute;
		top: 13px;
		right: 15px;
		height: 8px;
		width: 8px;
		background: #f4523b;
		border-radius: 50%;
	}
	
	.listPlan {
		margin-bottom: 26px;
	}
	
	.listPlan>label {
		cursor: pointer;
	}
	
	.listPlan>label>input {
		display: none;
	}
	
	.listPlan>label>img,
	.listPlan>label>span {
		vertical-align: middle;
	}
	
	.listPlan>label>img {
		width: 24px;
		height: 24px;
	}
	
	.listPlan>label>span {
		font-size: 18px;
		margin-left: 14px;
	}
	
	.ul_Checkbox {
		padding: 10px 20px;
	}
	
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
		width: 100px;
		font-size: 15px;
		padding-left: 10px;
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
	
	.imgs_div {
		width: 960px;
		margin: 0 auto;
	}
	
	.imgs_div>div:nth-child(1) {
		margin: 25px 0;
	}
	
	.del_file {
		display: flex;
		/*flex-wrap: wrap;*/
	}
	
	.del_file>div {
		border: 1px solid #ddd;
		padding: 5px;
		border-radius: 5px;
	}
	.del_file>div img{
		width: 100px;
		max-height: 150px;
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
		background-image: url(../../../assets/img/g_check.png);
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
		background-image: url(../../../assets/img/g_check.png);
		background-size: 100% 100%;
	}
	
	.divshow {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		z-index: 999999;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, .2);
	}
	
	.divshow_div {
		position: absolute;
		top: 50%;
		left: 50%;
		border-radius: 10px;
		width: 660px;
		height: 460px;
		margin: -230px 0 0 -330px;
		background: #fff;
	}
	
	.divshow_divtit {
		font-size: 16px;
		height: 54px;
		line-height: 54px;
		text-align: center;
	}
	
	.divshow_but {
		position: absolute;
		bottom: 20px;
		width: 660px;
		text-align: center;
	}
	
	.divshow_but button {
		width: 120px;
		height: 44px;
		line-height: 44px;
		border: 0;
		border-radius: 10px;
		margin: 0 0 0 20px;
		color: #fff;
		font-size: 14px;
		cursor: pointer;
	}
	
	.addSeparate+.addSeparate:before{
		content: ',';
	}
</style>