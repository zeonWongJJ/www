<template>
	<div class="my_kask_x">
		<Breadcrumb v-if="this.$store.state.plan_type == 2">
			<BreadcrumbItem>个人计划</BreadcrumbItem>
			<BreadcrumbItem>{{plan_name}}</BreadcrumbItem>
			<BreadcrumbItem>{{name_x}}</BreadcrumbItem>
		</Breadcrumb>
		<Breadcrumb v-else>
			<BreadcrumbItem>公司计划</BreadcrumbItem>
			<BreadcrumbItem>{{plan_name}}</BreadcrumbItem>
		</Breadcrumb>
		<div class="tit_box">
			<ul class="plan_tit_box_ul">
				<li class="tit_box_li" v-if="this.$store.state.plan_type == 2">个人计划</li>
				<li @click="participate_plan_x" v-else>个人计划</li>
				<li class="tit_box_li" v-if="this.$store.state.plan_type == 1">公司计划</li>
				<li @click="participate_plan" v-else>公司计划</li>
				<li @click="goCollect">每周汇总</li>
			</ul>
		</div>
		<div class="butt">
			<div style="background: #fff;text-align: center;" @click="r_plian()" v-if=" model1 == '' ||  (this.$route.query.member_id_d == model1.member_id && model1)">添加计划</div>
			<div style="height: 60px;width: 300px; display: flex;align-items: center;" v-if="this.$store.state.plan_type == 2">
				<div style="margin-right:10px;font-size: 14px;">
					查看他人计划
				</div>
				<div>
					<Select v-model="model1" style="width:200px" @on-change="olist()">
						<Option v-for="(item,index) in cityList" :value="item" :key="index">{{ item.real_name }} </Option>
					</Select>
				</div>

			</div>

			<!--<div @click="add_o" v-if="isshow == true">未完成</div>
			<div v-if="isshow == false" class="bacolco">未完成</div>
			<div @click="add_o">已完成</div>-->
		</div>
		<div class="box_body test-1">
			<div v-if="myplan == undefined || myplan == '' " class="qk">

				暂无数据
			</div>
			<div class="com_box" v-for="(item,index) in myplan">
				<div class="ul_div">
					<div class="ul_div_time">
						<span v-if="item.progress == 100 ">
								<span v-if="item.progress == 100 && (item.progress_update_time > item.plan_time_limit)" style="background: #ff8400;">
									已完成
								</span>
						<span v-if="item.progress == 100 && (item.progress_update_time < item.plan_time_limit)">
									已完成
								</span>

						</span>
						<span v-else>
							<span v-if="item.time_difference.d < 0 " class="ul_div_time_r">
								已过期
							</span>
						<span v-else-if="item.time_difference.d <= 7  && item.time_difference.d >= 3   " class="ul_div_time_y">
								{{item.time_difference.d}}天{{item.time_difference.h}}时
							</span>
						<span v-else-if="item.time_difference.d <= 3  && (item.time_difference.d >= 0 &&  item.time_difference.h < 24  && item.time_difference.m < 60 && item.time_difference.s < 60)  " class="ul_div_time_r">
								{{item.time_difference.d}}天{{item.time_difference.h}}时
							</span>

						<span v-else>
								{{item.time_difference.d}}天{{item.time_difference.h}}时
							</span> +
						</span>

					</div>
					<div class="ul_div_time-stop">

						<span v-if="item.time_difference.d < 0 && item.progress == 100">
							<!--时间-->
						</span>
						<span v-else>
							剩余时间
						</span>
					</div>
					<div class="li_div" :class="{li_div_finish : item.progress == 100 }">
						<div>
							<p class="li_div_img">
								<!--<img src="../../assets/img/time.png"/>-->

							</p>
							<p class="li_div_text">
								<!--{{item.task_title}}-->
								{{item.plan_name}}
							</p>
						</div>
						<div class="jindut">
							<!--{{item.plan_desc}}-->
							<div class="bmf_jd jindut_box">
								<div class="">
									<Slider v-model="item.progress" show-tip="never" :tip-format="format" disabled></Slider>
								</div>
								<div>
									<span>{{item.progress}}%</span>
								</div>
							</div>
							<!--{{item.task_project_names}}-->
						</div>
						<div>
							{{item.real_name}}
						</div>
						<div>
							<!--<p class="li_div_img_ri" ></p>-->
							<!--<button @click="o_bianji(item,index)" v-if="item.progress != 100 &&( model1== '' ||  model1_men == men_id)">编辑</button>-->
							<button @click="o_bianji(item,index)">编辑</button>

							<button @click="o_iss_hh(item,index)" v-if="isshow == index">隐藏</button>
							<button @click="o_iss(item,index)" v-else>展开</button>
						</div>
					</div>

					<div class="" v-if="isshow == index" style="width: 980px; z-index: 9999;background: #f8f8f8;border-radius: 20px;padding: 10px 20px;">
						<div style="display: flex;position: relative;align-items: center; font-size: 16px;margin:10px 0 0px 20px  ; border-bottom: 1px solid #fff;padding:0 0 10px 0;">
							<div style="width: 100px;">发起人 :</div>
							<div>{{item.real_name}}</div>
							<div style="position: absolute;right: 44px;">
								<button class="but_r" @click="o_tianjia(item)">添加流程</button>
								<!--<button class="but_r" @click="o_tianjia(item)" v-if="item.progress != 100">添加流程</button>-->
							</div>
						</div>
						<div style="display: flex; font-size: 16px;margin:10px 0 0px 20px  ; border-bottom: 1px solid #fff;padding:0 0 10px 0;">
							<div style="width: 100px;">计划标题 :</div>
							<div>{{item.plan_name}}</div>
						</div>
						<div style="display: flex;  font-size: 16px;margin:10px 0 0px 20px  ; border-bottom: 1px solid #fff;padding:0 0 10px 0;word-wrap: break-word;white-space : normal">
							<div style="width: 100px;">计划描述 :</div>
							<!--<div style="width: 800px; min-height: 10px; display: none;" contenteditable="true">{{item.plan_desc}}</div>-->
							<!--<textarea style="width: 800px;height: 100%; overflow-y:visible ;text-indent:2em;background: #f8f8f8; "  rows="10" v-model="item.plan_desc"></textarea>-->
							<pre style="width: 800px;white-space: pre-wrap;word-wrap: break-word;">{{item.plan_desc}}</pre>

						</div>
						<div style="display: flex;  font-size: 16px;margin:10px 0 0px 20px  ; border-bottom: 1px solid #fff;padding:0 0 10px 0;">
							<div style="width: 100px;">发布时间 :</div>
							<div style="width: 800px;">{{item.add_date}}</div>
						</div>
						<div style="display: flex; font-size: 16px;margin:10px 0 0px 20px  ; border-bottom: 1px solid #fff;padding:0 0 10px 0;">
							<div style="width: 100px;">参与人 :</div>
							<div v-for="(dataitem,index) in  item.plan_belonged_data">{{dataitem.real_name}} , </div>
						</div>

						<div class="sata_box">
							<div class="bm_x_box" v-for="(itlist,index) in item.plan_process">
								<div class="bmf_x">{{itlist.group_name}}</div>
								<!--状态控制bm-x-----0----->
								<div v-if="itlist.status == -1" style="width: 100%;">
									<div @click="huif(item,itlist,index)">
										<div class="huifu">
											<span>
 											恢复流程
 											</span>
										</div>

									</div>
								</div>
								<div class="bm_x" v-if="itlist.status == 0">
									<div class="bmf_name">
									</div>
									<div class="bmf_jd bmf_jd1">
										<div class="">
										</div>
										<div>
										</div>
									</div>
									<div class="bmf_but bmf_but_flex">
										<div class="bmf_but_zb" @click="jies(item,itlist,index)">
											接手
										</div>
										<div class="bmf_but_js" @click="sishow(item,itlist,index)">
											指派
										</div>
										<div class="bmf_but_js" @click="qux(item,itlist,index)">
											删除流程
										</div>

									</div>
									<div class="bmf_but_img" @click="o_dzuo(item,itlist,index)">
										<span>
											动作记录
										</span>

									</div>
								</div>
								<!--状态控制bm-------0----->

								<!--状态控制bm-x-----1-2 L----->
								<div class="bm_x" style="background: #ffc324;" v-if="itlist.status == 1">
									<div class="bmf_name">

										<span v-if="itlist.real_name">{{itlist.real_name}}</span>
										<span v-else>{{real_name_x}}</span>
									</div>
									<div class="bmf_jd">
										<div class="">
											<Slider v-model="itlist.progress" disabled show-tip="never" :tip-format="format" @on-change="prog(item,itlist,index)"></Slider>
										</div>
										<div>
											<span>{{itlist.progress}}%</span>
											<!--<div class="progressNum">{{Number(item.task_progress)}}%</div>-->
										</div>
									</div>
									<div class="bmf_but bmf_but2" style="justify-content: flex-end;">
										<div class="bmf_but_js" @click="fangqi(item,itlist,index)">
											放弃
										</div>
									</div>
									<div class="bmf_but_img" @click="o_dzuo(item,itlist,index)">
										<span>
											动作记录
										</span>

									</div>
								</div>
								<!--状态控制bm-------1-2----->

								<!--状态控制bm-x----3  4----->
								<div class="bm_x" style="background: #0ab3e9;" v-if="itlist.status == 2">
									<div class="bmf_name">
										<span v-if="itlist.real_name">{{itlist.real_name}}</span>
										<span v-else>{{real_name_x}}</span>
									</div>
									<div class="bmf_jd">
										<div class="">
											<Slider v-model="itlist.progress" disabled show-tip="never" :tip-format="format"></Slider>
										</div>
										<div>
											<span>{{itlist.progress}}%</span>
										</div>
									</div>
									<div class="bmf_but bmf_but2" style="justify-content: flex-end;" @click="o_dzuo(item,itlist,index)">

									</div>
									<div class="bmf_but_img" @click="o_dzuo(item,itlist,index)">
										<span>
												动作记录
											</span>

									</div>
								</div>
								<!--状态控制bm-------3   4----->
							</div>

						</div>
						<!--//评论-->

						<div>
							评论区
							<div>
								<eva-luate :item_x="item"></eva-luate>
							</div>
						</div>

					</div>
				</div>

				<!--添加流程-->
				<div v-if="tianjia" class="divshow">
					<div class="divshow_div">
						<div class="divshow_divtit">
							添加流程(可多个)
						</div>
						<ul class="ul_Checkbox">
							<li v-for='(label,index) in members_group'>
								<div></div>
								<div>
									<input type="radio" :id="'label.group_id'+ label.group_id" :value="label.group_id" v-model="task_group_id">
									<label :for="'label.group_id'+label.group_id">{{label.group_name}}</label>
								</div>

							</li>
						</ul>

						<div class='divshow_but'>
							<button style="background: #00C1DE;" @click.stop="o_ttj(item,index)">确定选择</button>
							<button style="background: #ddd;" @click.stop="tianjia = false">取消</button>
						</div>
					</div>
				</div>

				<!--指派人-->
				<div v-if="assign" class="divshow">
					<div class="divshow_div">
						<div class="divshow_divtit">
							指派人
						</div>
						<ul class="ul_Checkbox">
							<li v-for='(label,index) in group_members_x'>
								<!--<div>{{label}}</div>-->
								<div>
									{{label.group.group_name}}
								</div>
								<div v-for='(labels,index) in label.list'>
									<div>
										<input type="radio" :id="'member_id'+labels.member_id" :value="labels.member_id" v-model="task_belonged">
										<label :for="'member_id'+labels.member_id">{{labels.real_name}}</label>
									</div>
								</div>
							</li>
						</ul>

						<div class='divshow_but'>
							<button style="background: #00C1DE;" @click.stop="iszhipa(item,index)">确定选择</button>
							<button style="background: #ddd;" @click.stop="assign = false">取消</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div v-show="!onshows" style="position: fixed;top: 0;left: 0;right: 0;bottom: 0;width: 100%;height: 100%;background: rgba(0,0,0,0); z-index: 999999;">

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
				stat: 1,
				isshow: -1,
				value: 25,
				jdt: '',
				list_bm: [],
				assign: false,
				label: [],
				task_belonged: [],
				myplan: [],
				//				v2
				group_members_x: [],
				members_group: [],
				men_id: this.$store.state.member_id,

				group_id: '',
				group_id_x: '',
				plan_index_x: '',
				plan_sub_id: '',
				itlist_status: '',
				items: {
					real_name: '',
					plan_name: '',
					plan_desc: '',
					plan_process: [],
					plan_belonged: [],
				},
				real_name_x: '',
				process_id_x: '',
				process_id_q: '',
				tianjia: false,
				task_group_id: [],
				cityList: [],
				model1: '',
				name_x: '',
				model1_men: '',
				plan_name: this.$route.query.plan_name,
				process_id: '',
				onshows: true,
			}
		},
		created() {
			this.o_iss()
		},
		mounted() {
			this.olist()

			let that = this;
			var qs = require('qs');
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
						that.group_members_x = members.data.data.list

					} else {
						that.$Message.error(members.data.msg);
					}
				})
			that.axios({
					method: 'post',
					url: api.members,
				})
				.then(function(val) {
					if(val.data.error == 0) {
						that.cityList = val.data.data.list

					} else {
						that.$Message.error(val.data.msg);
					}

				})
		},
		methods: {
			//每周汇总
			goCollect(){
				let that = this;
				that.$router.push({
					path: "weekCollect",
				});
			},
			olist() {
				let that = this;
				let list = {}
				that.name_x = that.model1.real_name
				that.model1_men = that.model1.member_id
				list.plan_id = that.$store.state.plan_id;
				list.type = that.$store.state.plan_type

				if(that.$route.query.member_id_d && that.model1 == '') {
					list.member_id = that.$route.query.member_id_d
				} else if(that.model1) {
					list.member_id = that.model1.member_id
				} else {
					list.member_id = that.$store.state.member_id
				}
				list.rows = 500

				let apis = ''
				if(that.$route.query.plan_type == 2) {
					apis = api.plan_personal_plans
				} else {
					apis = api.plan_company_plans
				}

				var qs = require('qs');
				that.axios({
						method: 'post',
						url: apis,
						data: qs.stringify(list)
					})
					.then(function(val) {
						if(val.data.error == 0) {
							that.myplan = val.data.data.list

						} else {
							that.$Message.error(val.data.msg);
						}

					})
				that.axios({
						method: 'post',
						url: api.member_group,
					})
					.then(function(val) {
						if(val.data.error == 0) {
							that.members_group = val.data.data.list

						} else {
							that.$Message.error(val.data.msg);
						}

					})

			},
			//			添加流程
			o_tianjia(item) {
				let that = this;
				that.tianjia = true
				that.task_group_id = []
				that.process_id = item.process_id
				that.plan_sub_id = item.plan_sub_id

			},
			//			添加流程/anniu 

			o_ttj() {
				let that = this;
				if(that.onshows) {
						that.onshows = false
				let list = {}
				list.plan_sub_id = that.plan_sub_id;
				list.group_id = that.task_group_id
				var qs = require('qs');
			
					that.axios({
							method: 'post',
							url: api.plan_process_add,
							data: qs.stringify(list)
						})
						.then(function(val) {
							if(val.data.error == 0) {
							
								setTimeout(() => {
									that.onshows = true
								}, 1000);
								that.olist()
								that.tianjia = false

							} else {
								that.$Message.error(val.data.msg);
								
//								that.onshows = false
								setTimeout(() => {
									that.onshows = true
								}, 1000);
							}
						})
				}

			},

			o_iss_hh(item, index) {
				let that = this
				that.isshow = -1
			},

			o_iss(item, index) {
				let that = this
				that.plan_sub_id = item.plan_sub_id
				that.isshow = index

			},
			r_plian() {
				//				if(this.$route.query.plan_id && this.$route.query.plan_type){
				//					let pula_id_x = this.$route.query.plan_id
				//					let plan_type_x = this.$route.query.plan_type
				//				}else{
				//					let pula_id_x = this.$store.state.plan_id
				//					let plan_type_x = this.$store.state.plan_type
				//				}
				let pula_id_x = this.$store.state.plan_id
				let plan_type_x = this.$store.state.plan_type

				this.$router.push({
					path: 'release_plan_x',
					query: {
						pula_id_x,
						plan_type_x
					}
				})
			},
			//			编辑
			o_bianji(item, index) {
				console.log(item)
				//				return
				//			if(this.$route.query.plan_id && this.$route.query.plan_type){
				//					let pula_id_x = this.$route.query.plan_id
				//					let plan_type_x = this.$route.query.plan_type
				//				}else{
				//					let pula_id_x = this.$store.state.plan_id
				//					let plan_type_x = this.$store.state.plan_type
				//				}
				this.$router.push({
					path: 'release_plan_x',
					query: {
						item
					}
				})
			},

			//			进度条
			format(val) {

			},
			//			进度条
			prog(item, itlist, index) {
				let that = this;

				let progres = {}
				if(that.process_id_x) {
					progres.process_id = that.process_id_x
				} else {
					progres.process_id = itlist.process_id
				}
				progres.member_id = that.$store.state.member_id
				progres.progress = itlist.progress
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.plan_process_progress,
						data: qs.stringify(progres) //传参变量
					})
					.then(function(prog) {
						if(prog.data.error == 0) {
							if(Number(itlist.progress) > 99) {
								itlist.status = 2

							} else {
								itlist.status = 1
							}
						} else {
							that.$Message.error(prog.data.msg);
						}
					})

			},

			//			指派
			sishow(item, itlist, index) {
				let that = this

				that.assign = true
				that.process_id = itlist.process_id
				that.group_id_x = itlist.group_id
				that.plan_index_x = itlist.status
				//				that.member_id = itlist.list.member_id

			},
			iszhipa(item, index) {
				let that = this

				let task_assign = {}
				task_assign.plan_sub_id = that.plan_sub_id
				task_assign.group_id = that.group_id_x
				task_assign.process_id = that.process_id
				task_assign.member_id = that.task_belonged
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.plan_progress_asign,
						data: qs.stringify(task_assign) //传参变量
					})
					.then(function(task_assign) {
						if(task_assign.data.error == 0) {
							that.assign = false
							that.onshows = true
							setTimeout(() => {
								that.onshows = false
							}, 500);

							that.real_name_x = task_assign.data.data.real_name
							that.plan_index_x = 1
							that.task_belonged = []
							that.olist()
							that.$Message.info('指派成功！');

						} else {
							that.$Message.error(task_assign.data.msg);
						}

					})

			},

			//			接手
			jies(item, itlist, index) {
				let that = this;
				let receive = {}
				receive.plan_sub_id = that.plan_sub_id
				receive.process_id = itlist.process_id
				receive.group_id = itlist.group_id
				receive.member_id = that.$store.state.member_id
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.plan_progress_receive,
						data: qs.stringify(receive) //传参变量
					})
					.then(function(task_receive) {
						if(task_receive.data.error == 0) {
							that.$Message.info('接手成功！');
							itlist.status = 1
							console.log(task_receive.data.data.real_name)
							that.real_name_x = task_receive.data.data.real_name
							that.process_id_x = task_receive.data.data.process_id

						} else {
							that.$Message.error(task_receive.data.msg);
						}

					})
			}, //			放弃
			fangqi(item, itlist, index) {
				let that = this;
				console.log('333', itlist)
				//				return
				let receive = {}

				receive.process_id = itlist.process_id
				receive.plan_sub_id = that.plan_sub_id
				receive.member_id = that.$store.state.member_id
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.plan_progress_giveup,
						data: qs.stringify(receive) //传参变量
					})
					.then(function(task_receive) {
						if(task_receive.data.error == 0) {
							itlist.status = 0
							itlist.progress = 0
							that.process_id_x = ''
							that.process_id = ''
							that.$Message.info('放弃成功')
						} else {
							that.$Message.error(task_receive.data.msg);
						}
					})
			},
			//			动作记录
			o_dzuo(item, itlist, index) {
				let that = this;
				that.$store.commit('process_id', itlist.process_id);
				that.$store.commit('progress', itlist.progress);
				//				let process_id = itlist.process_id

				that.$router.push({
					path: "/journal",
					//					query: {
					//						process_id
					//					}
				});
			},
			//			取消流程
			qux(item, itlist, index) {
				let that = this;
				let receive = {}
				receive.plan_sub_id = that.plan_sub_id
				receive.group_id = itlist.group_id
				receive.process_id = itlist.process_id
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.plan_progress_unwanted,
						data: qs.stringify(receive) //传参变量
					})
					.then(function(task_receive) {
						if(task_receive.data.error == 0) {
							item.plan_process.splice(index, 1)
							that.$Message.info('取消流程成功')
						} else {
							that.$Message.error(task_receive.data.msg);
						}
					})
			},
			//				回复流程
			huif(item, itlist, index) {
				let that = this;
				let receive = {}
				if(that.process_id_q) {
					receive.process_id = that.process_id_q
				} else {
					receive.process_id = itlist.process_id
				}
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.plan_progress_recovery,
						data: qs.stringify(receive) //传参变量
					})
					.then(function(task_receive) {
						if(task_receive.data.error == 0) {

							itlist.status = 0
							that.plan_sub_id = task_receive.data.data.plan_sub_id
							that.$Message.info('回复流程成功')
						} else {
							that.$Message.error(task_receive.data.msg);
						}
					})
			},
			participate_plan() {
				this.$router.push({
					path: 'company_plan_x'
				})
			},
			participate_plan_x() {
				this.$router.push({
					path: 'plan_x'
				})
			},
		}
	}
</script>

<style scoped>
	.tit_box {
		position: absolute;
		top: -88px;
		left: 0px;
		height: 85px;
		margin: 0 0 0 50px;
		border-bottom: 1px solid rgba(186, 233, 249, .5);
		z-index: 999;
	}
	
	.sata_box {
		margin: 20px 0 0 0;
	}
	
	.but_r {
		width: 100px;
		height: 34px;
		line-height: 34px;
		border-radius: 8px;
		border: 0;
		color: #fff;
		background: #0ab3e9;
		margin-top: -10px;
		font-size: .12rem;
	}
	
	.bm_x_box {
		width: 100%;
		height: 60px;
		display: flex;
		/*justify-content: space-between;*/
		align-items: center;
		background: #fff;
		font-size: 18px;
		border-radius: 50px;
		overflow: hidden;
		margin-bottom: 21px;
	}
	
	.bm_x {
		width: 100%;
		height: 60px;
		display: flex;
		/*justify-content: space-between;*/
		align-items: center;
		background: #f00;
		font-size: 18px;
		color: #fff;
	}
	
	.bmf_x {
		flex: 0 0 140px;
		text-align: center;
		background: #fff;
	}
	
	.bmf_name {
		flex: 0 0 160px;
		text-align: center;
	}
	
	.bmf_name span {
		background: #fff;
		color: #000;
		padding: 8px 20px;
		border-radius: 50px;
	}
	
	.bmf_jd {
		flex: 0 0 280px;
		margin: 0 10px;
		display: flex;
		align-items: center;
	}
	
	.bmf_jd1 {
		flex: 0 0 180px !important;
	}
	
	.bmf_jd>div:nth-child(2) {
		flex: 0 0 60px;
		text-align: center;
	}
	
	.bmf_but {
		flex: 0 0 280px;
		display: flex;
		/*justify-content: space-between;*/
		font-size: 14px;
	}
	
	.bmf_but_flex {
		display: flex;
		justify-content: space-between;
	}
	
	.bmf_but div {
		/*width: 80px;*/
		padding: 5px 15px;
		/*height: 34px;*/
		/*line-height: 34px;*/
		text-align: center;
		border-radius: 50px;
		cursor: pointer;
		/*margin-right: 20px;*/
	}
	
	.bmf_but2 {
		flex: 0 0 180px !important;
	}
	
	.bmf_but_zb {
		border: 2px solid #fff;
	}
	
	.bmf_but_js {
		border: 2px solid #fff;
	}
	
	.bmf_but_img {
		flex: 0 0 180px;
		text-align: center;
		font-size: 14px;
	}
	
	.bmf_but_img span {
		border: 2px solid #eee;
		padding: 5px 15px;
		border-radius: 50px;
		cursor: pointer;
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
	
	.plan_tit_box_ul {
		display: flex;
		width: 800px;
		margin: 0 auto;
	}
	
	.plan_tit_box_ul li {
		text-align: center;
		font-size: 18px;
		width: 350px;
		line-height: 85px;
		height: 85px;
		position: relative;
	}
	
	.plan_tit_box_ul li:hover:before {
		content: "";
		position: absolute;
		bottom: 0;
		left: 88px;
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
		left: 88px;
		height: 2px;
		width: 100px;
		background-color: #0ab3e9;
	}
	
	.box_body {
		position: absolute;
		top: 90px;
		width: 1090px;
		height: 90%;
		padding: 0 0 50px 0;
		/*overflow: auto;*/
		overflow: hidden;
		overflow-y: scroll;
		overflow-x: auto;
		z-index: 99;
	}
	
	.com_box {
		/*top: 0;*/
		/*width: 1050px;*/
		margin: 10px 0;
	}
	
	.ul_div {
		width: 99%;
		height: 99%;
		padding: 30px 55px;
		position: relative;
		transition: all 0.3s;
	}
	
	.ul_div:hover {
		transform: scale(1.01);
	}
	
	.ul_div:hover .li_div {
		box-shadow: 0 0 15px rgba(10, 179, 233, .2);
	}
	
	.ul_div:hover .li_div_img {
		width: 27px;
		height: 34px;
		background-image: url(../../assets/img/time.png);
		background-repeat: no-repeat;
	}
	
	.ul_div:hover .li_div_img_ri {
		width: 32px;
		height: 32px;
		background-image: url(../../assets/img/kasta_ri_h.png);
		background-repeat: no-repeat;
		cursor: pointer;
	}
	
	.ul_div_time {
		position: absolute;
		top: 0;
		left: 90px;
		width: 190px;
		height: 48px;
		line-height: 38px;
		text-align: center;
		font-size: 14px;
		/*background: #0ab3e9;*/
		border-radius: 30px;
		color: #fff;
		border: 5px solid #cef0fb;
		overflow: hidden;
	}
	
	.ul_div_time span {
		display: block;
		background: #0ab3e9;
	}
	
	.ul_div_time_y {
		background: #ffc900 !important;
	}
	
	.ul_div_time_r {
		background: #f00 !important;
	}
	
	.ul_div_time_f {
		background: #bbb !important;
	}
	
	.ul_div_time-stop {
		position: absolute;
		top: 10px;
		left: 300px;
		font-size: 10px;
		color: rgba(0, 0, 0, .3);
	}
	
	.li_div {
		width: 976px;
		height: 104px;
		line-height: 104px;
		border-radius: 20px;
		background: #fff;
		box-shadow: 0 0 5px rgba(10, 179, 233, .06);
		display: flex;
		align-items: center;
	}
	
	.li_div_finish {
		background: #0ab3e9 !important;
		color: #fff !important;
	}
	
	.li_div div:nth-child(1) {
		width: 345px;
		font-size: 32px;
		position: relative;
		display: flex;
		align-items: center;
	}
	
	.li_div_img {
		display: block;
		width: 25px;
		height: 32px;
		margin-top: 3px;
		margin-left: 35px;
		margin-right: 20px;
		background-image: url(../../assets/img/time_stop.png);
		background-repeat: no-repeat;
	}
	
	.li_div_text {
		width: 245px;
		font-size: 20px;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	
	.li_div>div:nth-child(1):before {
		content: "";
		position: absolute;
		top: 50%;
		right: 0px;
		height: 55px;
		width: 2px;
		margin: -27.5px 0 0 0;
		background-color: #0ab3e9;
	}
	
	.li_div div:nth-child(2) {
		width: 346px;
		/*padding: 0 10px;*/
		font-size: 16px;
		position: relative;
		text-align: center;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	/*.li_div div:nth-child(2):before {
		width: 315px;
		font-size: 22px;
		content: "";
		position: absolute;
		top: 50%;
		right: 0px;
		height: 55px;
		width: 2px;
		margin: -27.5px 0 0 0;
		background-color: #0ab3e9;
	}*/
	
	.li_div div:nth-child(3) {
		width: 105px;
		text-align: center;
		position: relative;
	}
	
	.li_div div:nth-child(3):before {
		content: "";
		position: absolute;
		top: 50%;
		left: 0px;
		height: 55px;
		width: 2px;
		margin: -27.5px 0 0 0;
		background-color: #0ab3e9;
	}
	
	.huifu {
		width: 90%;
		text-align: right;
	}
	
	.huifu span {
		padding: 8px 15px;
		border: 1px solid #FF0000;
		color: #f00;
		border-radius: 50px;
	}
	
	div.ul_but {
		display: flex;
		flex-wrap: wrap;
		width: 255px !important;
		margin-left: 80px;
		padding: 8px 0 0 0;
	}
	
	.ul_but span {
		display: block;
		margin: 0 5px 8px 0;
		width: 56px;
		height: 30px;
		line-height: 30px;
		font-size: 14px;
		text-align: center;
		border-radius: 15px;
	}
	
	.ul_but_1 {
		color: #0ab3e9;
	}
	
	.ul_but_1_h {
		background: #0ab3e9;
		color: #fff;
	}
	
	.ul_but_2 {
		color: #ffc324;
	}
	
	.ul_but_3 {
		color: #ff5b6e;
	}
	
	.ul_but_4 {
		color: #9b9b9b;
	}
	
	.li_div div:nth-child(4) {
		width: 150px;
		/*height: 134px;*/
		/*line-height: 134px;*/
		display: flex;
		flex-wrap: wrap;
		padding: 0 0 0 20px;
		margin-top: -8px;
	}
	
	.li_div div:nth-child(4) button {
		width: 100px;
		height: 34px;
		line-height: 34px;
		border-radius: 8px;
		border: 0;
		color: #fff;
		background: #0ab3e9;
		margin-top: 10px;
	}
	
	.li_div_img_ri {
		display: block;
		width: 30px;
		height: 30px;
		background-image: url(../../assets/img/kasta_ri.png);
		background-repeat: no-repeat;
	}
	
	.butt {
		padding: 0px 56px;
		display: flex;
		justify-content: flex-end;
		align-items: center;
		border-bottom: 1px solid rgba(10, 179, 233, .1);
		padding-bottom: 5px;
	}
	
	.butt div {
		width: 90px;
		height: 40px;
		line-height: 40px;
		font-size: 15px;
		cursor: pointer;
	}
	
	.butt div:nth-child(1) {
		/*background: #fff;*/
		border-radius: 6px;
		margin-right: 26px;
	}
	
	.butt div:nth-child(2) {
		/*background: #fff;
		border-radius: 6px 0 0 6px;
		box-shadow: 0 0 2px #0ab3e9;*/
	}
	
	.butt div:nth-child(3) {
		background: #0ab3e9;
		border-radius: 0 6px 6px 0;
		color: #fff;
	}
	
	.bacolco {
		background: #eee !important;
		color: #fff !important;
	}
	
	.qk {
		text-align: center;
		margin-top: 30px;
		color: #999;
		font-size: 14px;
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
		/*background: rgba(0, 0, 0, .2);*/
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
		z-index: 999999;
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
	
	.jindut_box {
		width: 230px !important;
	}
	
	.jindut .jindut_box>div:nth-child(2) {}
	
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
</style>
<style type="text/css">
	.ivu-breadcrumb {
		padding: 10px 0 0 20px !important;
	}
	
	.jindut .ivu-slider {
		width: 230px !important;
	}
	
	.jindut .ivu-tooltip-rel {
		top: -12px !important;
	}
	
	.jindut .ivu-slider-disabled .ivu-slider-button {
		border-color: #0ab3e9 !important;
	}
	
	.my_kask_x .ivu-slider-wrap {
		width: 230px !important;
	}
	
	.my_kask_x .ivu-slider-button-wrap {
		top: -10px !important;
	}
</style>