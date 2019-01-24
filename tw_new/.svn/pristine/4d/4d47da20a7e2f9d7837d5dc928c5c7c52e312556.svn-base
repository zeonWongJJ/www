<template>
	<div class="my_kask_x">

		<!--  最右侧   -->
		<div class="right_box">
			<div class="planName_box">
				<div class="planMon" :class="{ planCur:changePlan == index}" v-for="(item,index) in sinPlan.slice(0,3)" @click="plan_details(item,index)">{{item.plan_name}}</div>
				<div @click="moreMonth(index)" >更多</div>
				<div class="planMonShow" v-show="monShow">
					<img @click="closeMon()" src="../../../static/imgs/绩效.png" alt="" />
					<div :class="{ planCur:changePlan == index}"  v-for="(item,index) in sinPlan" @click="plan_details(item,index)" >{{item.plan_name}}</div>
				</div>	
			</div>
			<div class="plan_cate">
				<div class="planCate" :class="{ planCateCur:changeCate == index}" @click="planCate(index)" v-for="(item,index) in planChoice">{{item.name}}</div>
			</div>
			<div class="all_person">
				<div class="planPer" :class="{ planPerCur : changerPer == index }" v-for="(item,index) in cityList.slice(0,3)" @click="personl_name(item,plan_id,index)">{{ item.real_name }}</div>
				<div @click="morePer()" style="height:40px; line-height:40px; font-size:14px; text-align: center; color:#9e9ca5">更多</div>
				<div class="planPerShow" v-show="perShow">
					<img @click="closePer()" src="../../../static/imgs/绩效.png" alt="" />
					<div :class="{ planPerCur : changerPer == index }"  v-for="(item,index) in cityList" @click="personl_name(item,plan_id,index)" >{{item.real_name}}</div>
				</div>	
			</div>
			<div  class="addFlow" @click="o_tianjia(flow)" v-show="addFlow">添加流程</div>
			<!--<div class="addPlan" @click="r_plian()" v-if=" model1 == '' ||  (this.$route.query.member_id_d == model1.member_id && model1)">添加计划</div>-->
		</div>
		<!--  最右侧   -->

		<div class="box_body test-1">
			<div v-if="myplan == undefined || myplan == '' " class="qk">

				暂无数据
			</div>

			<div class="com_box" v-for="(item,index) in myplan">
				<div class="ul_div">

					<div  @click.stop="o_iss(item,index)" class="li_div" :class="{li_div_finish : item.progress == 100 }">
						<div>
							{{item.nav}}
						</div>
						<div>

							<p v-if="item.time_difference.d < 0 " class="li_div_text ul_div_time_r">
								{{item.plan_name}}
							</p>
							<p v-else-if="item.time_difference.d <= 7  && item.time_difference.d >= 3   " class="li_div_text ul_div_time_y">
								{{item.plan_name}}
							</p>
							<p v-else-if="item.time_difference.d <= 3  && (item.time_difference.d >= 0 &&  item.time_difference.h < 24  && item.time_difference.m < 60 && item.time_difference.s < 60)  " class="li_div_text ul_div_time_r">
								{{item.plan_name}}
							</p>
							<p v-else class="li_div_text">
								{{item.plan_name}}
							</p>
						</div>

						<div class="ul_div_time">
							
							<span v-if="item.progress == 100 ">
								<span v-if="item.progress == 100 && (item.progress_update_time > item.plan_time_limit)" style="background: #ff8400; color:white;">
									已完成
								</span>
							<span style="color:white;" v-if="item.progress == 100 && (item.progress_update_time < item.plan_time_limit)">
									已完成
								</span>

							</span>
							<span v-else>
							<em v-if="item.time_difference.d < 0 " class="ul_div_time_r">
								已过期
							</em>
							<span v-else-if="item.time_difference.d <= 7  && item.time_difference.d >= 3   " class="ul_div_time_y">
								{{item.time_difference.d}}天{{item.time_difference.h}}时
							</span>
							<span v-else-if="item.time_difference.d <= 3  && (item.time_difference.d >= 0 &&  item.time_difference.h < 24  && item.time_difference.m < 60 && item.time_difference.s < 60)  " class="ul_div_time_r">
								{{item.time_difference.d}}天{{item.time_difference.h}}时
							</span>

							<span v-else>
								{{item.time_difference.d}}天{{item.time_difference.h}}时
							</span>
							</span>

						</div>
						<div class="jindut">
							<!--{{item.plan_desc}}-->
							<div class="bmf_jd jindut_box">
								<div class="">
									<Slider v-model="item.progress" show-tip="never" :tip-format="format" disabled></Slider>
								</div>
								<div>
									<span style="color:#9158F5">{{item.progress}}%</span>

								</div>
							</div>
						</div>
						<div style="color:#9158F5">
							{{item.real_name}}
						</div>
						<div style="width:22%; display: flex; justify-content: flex-end; align-items: center;">
							<!--<div @click.stop="o_iss_hh(item,index)" v-if="isshow == index"><img style="width:15px; transform: rotate(180deg); cursor: pointer;" :src="btnSrcB" /></div>-->
							<!-- 置顶 -->
							<div @click.stop="upTop(item,index)" ><img style="width:15px; cursor: pointer; " :src="item.sort>0?btnSrcB:btnSrcD" alt="" /></div>
							<!-- 置顶 -->
							<!--编辑-->
							<div style="width:auto; margin:0 20px;" @click.stop="o_bianji(item,index)"><img style="width:18px; cursor: pointer;" :src="btnSrcA" alt="" /></div>
							<!--编辑-->
							<!-- 添加流程 -->
							<!--<div style="width:auto;" @click.stop="o_tianjia(item)">
								<img style="width:18px; cursor: pointer;" :src="btnSrcC" alt="" />
							</div>-->
							<!-- 添加流程 -->
						</div>
					</div>
					<!--v-if=" item.isShow"-->
					<div class="list_box" v-show="isshow == index">
						
						<div class="listTitle">
							<span>{{item.plan_name}}</span>
							<span>发起人 ：{{item.real_name}}</span>
							<span>发布时间 ：{{item.add_date}}</span>
						</div>
						<div class="listPart">
							参与人 :<span v-for="(dataitem,index) in  item.plan_belonged_data">{{dataitem.real_name}}</span>
						</div>
						<div class="listContent">
							<pre style="calc( 100% - 120px; ); line-height:24px; font-size:16px; color:#707070; white-space: pre-wrap;word-wrap: break-word;">{{item.plan_desc}}</pre>
						</div>

						<div>

							<div>
								<eva-luate :item_x="item"></eva-luate>
							</div>
						</div>

						<!--v-if='processCont==1'-->
						<div class="dataContainer" v-if='processCont==1'>

							<div class="processLeft">
								<ul>
									<li v-for="(itlist,index) in item.plan_process" :class="{ processCur:changeStyle == index}" @click="processIndex(itlist,item,index)">
										<div class="prolist_tit">
											<span>{{itlist.group_name}}</span>
											<span style="position: absolute; right:10px;">{{itlist.real_name}}</span>
										</div>
										<div class="proContent">
											<div class="progress_box">
												<div style="width:100%; text-align: center;">
													<i-Circle dashboard :size="120" :trail-width="5" :stroke-width="5" :percent="itlist.progress" stroke-linecap="round" stroke-color="#43a3fb">
														<div class="demo-Circle-custom">
															<span style="font-size:18px">{{itlist.progress}}%</span>
															<!--<div>{{}}条信息</div>-->
														</div>
													</i-Circle>
												</div>
												<div class="missionBtn" v-if="itlist.status == -1">
													<span @click="huif(item,itlist,index)">恢复流程</span>
												</div>
												<div class="missionBtn" v-if="itlist.status == 0">
													<span @click="jies(item,itlist,index)">接手</span>
													<span @click="sishow(item,itlist,index)">指派</span>
													<span @click="qux(item,itlist,index)">删除</span>
												</div>
												<div class="missionBtn" v-if="itlist.status == 1">
													<span @click="fangqi(item,itlist,index)">放弃</span>

												</div>
											</div>
										</div>
									</li>

								</ul>
							</div>
							<!-- 右边日志记录 -->
							<div class="processRight">
								<!--日志-->
								<div class="journalContainer">
									<div class="evaluateContainer" style="color:white;">
										<ul>
											<li class="evaList" v-for="(cont, index) in progresList">
												<div class="bigEva">
													<div class="evaLeft" v-if="cont.type == 1">
														<div style="background: #4DA1FF;"></div>
														<div style="color: #4DA1FF;">日志</div>
													</div>
													<div class="evaLeft" v-if="cont.type == 2">
														<div style="background: green;"></div>
														<div style="color: green;">疑问</div>
													</div>
													<div class="evaLeft" v-if="cont.type == 3">
														<div style="background: yellow;"></div>
														<div style="color: yellow;">建议</div>
													</div>
													<div class="evaLeft" v-if="cont.type == 4">
														<div style="background: #F51644;"></div>
														<div style="color: #F51644;">bug</div>
													</div>
													<div class="evaRight">
														<span>{{cont.add_date}}</span>
														<span>{{cont.my_name}}</span>
														<span v-if="cont.progress.indexOf('-')" style="color:#4DA1FF">进度  + {{cont.progress}}%</span>
														<span v-else style="color:#F51644">进度 {{cont.progress}}%</span>
														<pre style="width: calc( 100% - 50px );white-space: pre-wrap;word-wrap: break-word;">{{cont.content}}</pre>
													</div>
												</div>
												<!-- 二级评论回复  -->
												<div class="smallEva">
													<div class="smallReaply">
														<ul>
															<li class="reaplyList" v-for="(reply,index) in cont.children_discusses">
																<div class="bigEva">
																	<div class="evaLeft" v-if="cont.type == 1">
																		<div style="background: #4DA1FF;"></div>
																		<div style="color: #4DA1FF;">日志</div>
																	</div>
																	<div class="evaLeft" v-if="cont.type == 2">
																		<div style="background: green;"></div>
																		<div style="color: green;">疑问</div>
																	</div>
																	<div class="evaLeft" v-if="cont.type == 3">
																		<div style="background: yellow;"></div>
																		<div style="color: yellow;">建议</div>
																	</div>
																	<div class="evaLeft" v-if="cont.type == 4">
																		<div style="background: #F51644;"></div>
																		<div style="color: #F51644;">bug</div>
																	</div>
																	<div class="evaRight">
																		<span>{{reply.add_date}}</span>
																		<span>{{reply.my_name}}</span>
																		<!--<span>{{reply.progress}}  </span>-->
																		<span v-if="reply.progress.indexOf('-')" style="color:#4DA1FF">进度  + {{reply.progress}}%</span>
																		<span v-else style="color:#F51644">进度 {{reply.progress}}%</span>
																		<pre style="width: calc( 100% - 50px );white-space: pre-wrap;word-wrap: break-word;">{{reply.content}}</pre>
																	</div>
																</div>
															</li>
														</ul>
														<div class="smallEvaBox">
															<!--<input v-model="progresList[index].smallEva" />-->
															<template>
																<Input v-model="progresList[index].smallEva" size="default" placeholder="请输入回复评论..." type="textarea" />
															</template>
															<div class="selectContainer">
																<!--<div class="typeTit" @click="typeTit(index)" v-if="selectCur">{{SelectTypeName}}</div>-->
																<select class="typeChoice" @change="typeIndex(item,$event)">
																	<option v-for="item in typeList" @click="">{{item.value}}</option>
																</select>
															</div>
															<div class="typeProgress">
																<Slider v-model.number="typePro"></Slider>
																<span style="margin-left:20px;">{{typePro}}%</span>
															</div>
															<div class="release rep" @click="release(item,index,$event)">回复</div>
														</div>
													</div>

												</div>
												<!-- 二级评论回复  -->
											</li>
										</ul>

									</div>

									<!-- 一级评论 -->
									<div class="journalBox">
										<!--<input v-model="dataInput" />-->
										<template>
											<Input v-model="dataInput" size="larger" placeholder="请输入评论..." type="textarea" />
										</template>
										<div class="selectContainer">
											<!--<div class="typeTit" @click="typeTit()">{{SelectTypeName}}</div>-->
											<select class="typeChoice" @change="typeIndex(item,$event)">
												<option v-for="item in typeList">{{item.value}}</option>
											</select>
										</div>
										<div class="typeProgress">
											<Slider v-model="typePro"></Slider>
											<span style="margin-left:20px;">{{typePro}}%</span>
										</div>
										<div class="release" @click="release(item,index,$event)">发布</div>
									</div>
									<!-- 一级评论 -->
								</div>
								<!--日志-->
							</div>
							<!-- 右边日志记录 -->
						</div>

						<div style="text-align: center; color:white;" v-else>暂无流程信息，请手动添加流程...</div>
					</div>
				</div>

				<!--添加流程-->
				<div v-if="tianjia" class="divshow">
					<div class="divshow_div">
						<div class="divshow_divtit">
							添加流程
						</div>
						<ul class="ul_Checkbox">
							<li v-for='(label,index) in members_group'>
								<div>

								</div>
								<div>
									<input type="radio" :id="'label.group_id'+ label.group_id" :value="label.group_id" v-model="task_group_id">
									<label :for="'label.group_id'+label.group_id">{{label.group_name}}</label>
								</div>

							</li>
						</ul>

						<div class='divshow_but'>
							<button style="background: #707070;" @click.stop="o_ttj(item,index)">确定选择</button>
							<button style="background: none;border:1px solid #707070;" @click.stop="tianjia = false">取消</button>
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
		<div v-show="onshows" style="position: fixed;top: 0;left: 0;right: 0;bottom: 0;width: 100%;height: 100%;background: rgba(0,0,0,0); z-index: 999999;">

		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	import evaLuate from '@/page/subcomponent/task_detail_s'
	import jouRnal from '@/page/tasks/dz/journal'
	export default {
		components: {
			evaLuate,
			jouRnal,
		},
		data() {
			return {
				stat: 1,
				isshow: 'false',
				value: 25,
				jdt: '',
				list_bm: [],
				assign: false,
				label: [],
				task_belonged: [],
				myplan: [],
				comanyplan: [],
				//				v2
				group_members_x: [],
				members_group: [],
				men_id: this.$store.state.member_id,
				planChoice: [{
					name: "公司"
				}, {
					name: "个人"
				}],
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
				onshows: false,
				sinPlan: [],
				typeNum: '2',
				plan_id: '',
				person_memId: '0',
				changePlan: 0,
				changeCate: 1,
				changerPer: -1,
				typeList: [{
						value: '日志',
						index: 1,
						label: '日志'
					},
					{
						value: '疑问',
						index: 2,
						label: '疑问'
					},
					{
						value: '建议',
						index: 3,
						label: '建议'
					},
					{
						value: 'bug',
						index: 4,
						label: 'bug'
					},

				],
				pjoShow:'',
				firstPlanId: '', //保存初始化的大计划ID
				processCont: '', //是否存在详细信息的标识
				processInfo: '',
				flow:'',
				monShow:false,//月份显示
				perShow:false,//人员显示
				addFlow:false,//显示流程按钮
				btnSrcA: require('@/assets/img/编辑.png'),
				btnSrcB: require('@/assets/img/置顶.png'),
				btnSrcC: require('@/assets/img/加号.png'),
				btnSrcD:require('@/assets/img/置顶白色.png'),
				progresList: [],
				status: '',
				changeStyle: 0,
				SelectTypeName: '动作类型',
				showType: false,
				dataInput: '',
				dataInputSmall: [],
				typePro: 0,
				perName: '0',
				type_index: '1',
				selectCur: -1,
				olistId:'',
			}
		},
		created() {
			//			this.o_iss()
		},
		mounted() {
			let that = this;
			that.month(2);

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
						console.log(members.data.data.list,"sss");
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
			OnDataInputSmall(index, e) {
				console.log(index, e)
			},
			month(num) {
				let that = this;
				let list = {}
				list.member_id = that.$store.state.member_id;
				list.type = num;
				list.rows = 500
				var qs = require('qs');
				that.axios({
						method: 'post',
						url: api.plans_list,
						data: qs.stringify(list)
					})
					.then(function(val) {
						if(val.data.error == 0) {
							that.firstPlanId = val.data.data.list[0].plan_id;
							that.sinPlan = val.data.data.list;
							that.$store.commit('plan_type', val.data.data.list[0].plan_type);
							that.olist(val.data.data.list[0].plan_id);
							that.plan_id = val.data.data.list[0].plan_id
						} else {
							that.$Message.error(val.data.msg)
						}

					})
			},

			planCate(index) {
				let that = this;
				that.changePlan = 0;
				that.person_memId = 0;
				that.changerPer = -1;
				that.changeCate = index;
				if(index == 0) {
					that.typeNum = '1';
					that.month(1);
				} else {
					that.typeNum = '2';
					that.month(2);
				}
				that.monShow=false;
				that.perShow=false;
			},
			//点击月份
			plan_details(item, index) {
				let that = this
				that.changerPer = -1;
				let member_id_d = ''
				member_id_d = that.$store.state.member_id
				that.$store.commit('plan_id', item.plan_id);
				//				let plan_id = item.plan_id
				that.plan_id = item.plan_id;
				let plan_name = item.plan_name
				let plan_type = that.$store.state.plan_type;
				that.firstPlanId = item.plan_id
				that.olist(item.plan_id);
				that.changePlan = index;
				that.monShow=false;
				that.perShow=false;
			},
			//点击更多月份
			moreMonth(index){
				this.monShow=true;
			},
			//关闭月份
			closeMon(){
				this.monShow=false;
			},
			olist(plan_id) {
				let that = this;
				let list = {}
				that.name_x = that.model1.real_name
				that.model1_men = that.model1.member_id
				list.plan_id = plan_id;
				list.type = that.typeNum;
				if(that.person_memId == 0 || that.person_memId == undefined) {
					list.member_id = that.$store.state.member_id
				} else 
				{
					list.member_id = that.person_memId
				}

				list.rows = 500;
				let apis = ''

				if(that.typeNum == 2) {
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
							let data = val.data.data.list
							that.myplan = val.data.data.list
							data.forEach((item, index,data) => {
								data[index].progress = Number(item.progress)
							})
							
							var process;
							/* 获取初始化百分比数值  */
							/*for(var i in val.data.data.list) {
								for(var n in val.data.data.list[that.perName].plan_process) {
									
									process =  val.data.data.list[that.perName].plan_process[that.perName].progress 
									
									
								}
								
							}
							that.typePro = process;*/

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

			//			点击个人计划名单
			personl_name(item, planId, index) {
				this.changePlan = -1,
				this.changeCate = -1,
				this.person_memId = item.member_id;
				this.olist(planId);
				this.changerPer = index;
				this.monShow=false;
				this.perShow=false;
			},
			//显示更多人员名字
			morePer(){
				this.perShow=true;
			},
			//关闭人员显示
			closePer(){
				this.perShow=false;
			},

			//			添加流程
			o_tianjia(item) {
				let that = this;
				that.tianjia = true
				that.task_group_id = []
				that.process_id = item.process_id
				that.plan_sub_id = item.plan_sub_id
				that.monShow=false;
				that.perShow=false;
			},
			//			添加流程/anniu 

			o_ttj(item, index) {
				
				let that = this;
				let list = {}
				list.plan_sub_id = that.plan_sub_id;
				list.group_id = that.task_group_id
				console.log(that.plan_sub_id)
				var qs = require('qs');

				that.axios({
						method: 'post',
						url: api.plan_process_add,
						data: qs.stringify(list)
					})
					.then(function(val) {
						if(val.data.error == 0) {
							
							setTimeout(() => {
								
							}, 1000);
							that.olist(that.plan_id)
							that.tianjia = false
						} else {
							that.$Message.error(val.data.msg);

							//								that.onshows = false
							setTimeout(() => {
								
							}, 1000);
						}
					})
				

			},
			//隐藏详细信息
			o_iss_hh(item, index) {
				let that = this
				that.isshow = -1
			},
			//展开详细信息
			o_iss(item, index) {
				let that = this;
				that.flow=item;
				that.plan_sub_id = item.plan_sub_id;
				that.olistId=item.plan_id;
				if(item.plan_process.length == 0) {
					that.processCont = 0;
				} else {
					that.processCont = 1;
				}
				if( that.isshow == index ){
					that.isshow = -1;
					that.addFlow=false;
				}else{
					that.isshow = index
					that.addFlow=true;
				}
				that.monShow=false;
				that.perShow=false;
				that.list_rec(item.plan_process[0].process_id);
			},
			r_plian() {

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
				progres.progress = Number(itlist.progress)
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
							that.olist(that.olistId);
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
							itlist.status = 1
							that.real_name_x = task_receive.data.data.real_name
							that.process_id_x = task_receive.data.data.process_id
							that.$Message.info('接手成功！');
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
							that.olist(that.olistId);
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
							that.olist(that.olistId);
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
			processIndex(itlist, item, index) {
				this.perName = index;
				this.changeStyle = index;
				this.typePro = Number(item.plan_process[index].progress) 
				this.list_rec(item.plan_process[index].process_id);
			},
			typeTit(index) {
				this.selectCur = index;

			},
			typeIndex(item, e) {

				if(e.target.value == "日志") {
					this.type_index = 1;
				} else if(e.target.value == "疑问") {
					this.type_index = 2;
				} else if(e.target.value == "建议") {
					this.type_index = 3;
				} else if(e.target.value == "bug") {
					this.type_index = 4;
				}
				this.showType = false;
				this.SelectTypeName = item.value;
			},
			list_rec(process_id) {
				let that = this;
				let josn = {};
				josn.id = process_id;
				//				josn.id = that.detail.process_id
				josn.discuss_type = 2
				//				josn.type = 1
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
							var num;
							that.progresList = [];
							for(let i = 0; i < res.data.data.list.length; i++) {
								that.progresList.push(res.data.data.list[i]);
							}
						} else {
							that.$Message.error(res.data.msg)
						}
					})
			},
			//置顶
			upTop(item,index){
				var that = this;
				var arr = {};
				arr.id=item.plan_sub_id;//计划id
				var qs = require('qs');
				that.axios({
						method: 'post',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						url: api.plan_top,
						data: qs.stringify(arr) //传参变量
					})
					.then(function(res) {
						if(res.data.error == 0) {
							that.olist(that.firstPlanId);
							that.$Message.success('置顶成功');
						} else {
							that.$Message.error(res.data.msg);
						}

					})
			},
			//回复或评论
			release(item, index, e) {
				var that = this;
				var arr = {};
				var qs = require('qs');

				if(e.target.innerText == "发布") { //发布评论
					arr.content = that.dataInput;
				} else { //回复评论
					arr.discuss_id = that.progresList[index].discuss_id;
					arr.content = that.progresList[index].smallEva;
				}

				for(var i in item.plan_process) {
					arr.id = item.plan_process[that.perName].process_id;
				}
				arr.member_id = that.$store.state.member_id;
				arr.discuss_type = 2;
				arr.type = that.type_index;
				arr.progress = Number(that.typePro);
				console.log(Number(that.typePro));
				that.axios({
						method: 'post',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						url: api.plan_discuss,
						data: qs.stringify(arr) //传参变量
					})
					.then(function(res) {

						if(res.data.error == 0) {
							if(e.target.innerText == "发布") { //评论
								that.progresList.push(res.data.data.discuss)
								that.$Message.success('评论成功');
							} else { //回复
								that.list_rec(item.plan_process[that.perName].process_id)
								that.$Message.success('回复成功');
							}
							that.olist(that.firstPlanId);
							that.dataInput = '';
						} else {
							that.$Message.error(res.data.msg);
						}

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
		left: 125px;
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
		left: 125px;
		height: 2px;
		width: 100px;
		background-color: #0ab3e9;
	}
	
	.box_body {
		position: absolute;
		top: 40px;
		width: 100%;
		height: calc( 100% - 200px );
		padding: 0 0 50px 0;
		/*overflow: auto;*/
		/*overflow: hidden;*/
		overflow-y: scroll;
		overflow-x: auto;
		z-index: 99;
	}
	
	.com_box {
		/*top: 0;*/
		/*width: 1050px;*/
		margin: 15px 0;
	}
	
	.ul_div {
		width: 99%;
		height: 99%;
		padding: 2px 20px;
		position: relative;
		transition: all 0.3s;
		cursor: pointer;
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
		/*position: absolute;*/
		top: 0;
		left: 90px;
		width: 190px;
		margin-right: 20px;
		/*height: 48px;
		line-height: 38px;*/
		text-align: center;
		font-size: 14px;
		/*background: #0ab3e9;*/
		border-radius: 30px;
		color: #fff;
		overflow: hidden;
	}
	
	.ul_div_time span {
		display: block;
		color: #0ab3e9;
	}
	
	.ul_div_time_y {
		color: #ffc900 !important;
	}
	
	.ul_div_time_r {
		color: #f00 !important;
	}
	
	.ul_div_time_f {
		color: #bbb !important;
	}
	
	.ul_div_time-stop {
		position: absolute;
		top: 10px;
		left: 300px;
		font-size: 10px;
		color: rgba(0, 0, 0, .3);
	}
	
	.li_div {
		width: calc( 100% - 70px);
		border-radius: 2px;
		background: #3F3D49;
		box-shadow: 0 0 5px rgba(10, 179, 233, .06);
		display: flex;
		align-items: center;
		padding-left: 20px;
	}
	
	.li_div_finish {
		/*background: #0ab3e9 !important;*/
		color: #fff !important;
	}
	
	.li_div div:nth-child(1) {
		font-size: 14px;
		/*position: relative;*/
		display: flex;
		align-items: center;
		color: #0ab3e9;
	}
	.li_div>div:nth-child(1) {
		width: 16%;
	}
	.li_div>div:nth-child(2) {
		width: 16%;
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
		/*width: 245px;*/
		font-size: 14px;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		color: #0ab3e9;
	}
	
	.li_div div:nth-child(3) {
		width: 7%;
	}
	
	.li_div div:nth-child(4) {
		width: 28%;
		font-size: 16px;
		/*position: relative;*/
		text-align: center;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	
	.li_div div:nth-child(5) {
		width: 105px;
		text-align: center;
		/*position: relative;*/
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
		/*width: 5%;*/
		/*display: flex;*/
		padding: 0 0 0 5px;
		color: #0ab3e9;
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
		background: #2A2735;
		z-index: 999999;
		/*border:1px solid #707070;*/
	}
	
	.divshow_divtit {
		font-size: 16px;
		height: 54px;
		line-height: 54px;
		text-align: center;
		color:#707070;
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
		color:#707070;
	}
	
	.ul_Checkbox li>div:nth-child(1) {
		width: 80px;
		font-size: 15px;
		padding-left: 10px;
	}
	
	.jindut_box {
		width: 100% !important;
	}
	
	.jindut_box>div {
		width: 100%;
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
		border: 1px solid #707070;
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
	
	.right_box {
		width: 70px;
		height: 100%;
		right: 0;
		background: #3c394b;
		position: absolute;
		color: white;
		z-index: 999;
	}
	
	.planName_box,
	.plan_cate,
	.all_person,
	.addPlan,
	.addFlow {
		cursor: pointer;
		position: relative;
		border:1px solid #4DA1FF;
		margin-bottom: 20px;
	}
	.addPlan{
		border:1px solid rgb(158, 156, 165);
		/*border-top: none;*/
		margin-bottom: 0;
	}
	.addFlow{
		border:1px solid rgb(158, 156, 165);
		/*border-bottom: none;*/
		margin-bottom: 0;
	}
	
	.planName_box>div,
	.plan_cate>div,
	.all_person>div.planPer,
	.addPlan,
	.addFlow {
		height: 40px;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #9e9ca5;
		font-size: 14px;
	}
	
	.planName_box .planCur,
	.all_person .planPerCur,
	.plan_cate .planCateCur {
		color: #4DA1FF !important;
	}

	.planMonShow{
		width:400px;
		position: absolute;
		top:0;
		background:#3F3D49;
		left:-401px;
		cursor: default;
	}
	.planPerShow{
		width:800px;
		text-align: center;
		padding:30px 0;
		height:auto !important;
		position: absolute;
		/*display: block !important;*/
		left:-801px;
		top:0;
		background:#3F3D49;
	}
	.planMonShow>img,.planPerShow>img{
		width:16px;
		position: absolute;
		right:10px;
		cursor: pointer;
	}
	.planPerShow>img{
		top:8px;
	}
	.planMonShow>div,.planPerShow>div{
		margin:0 10px;
		cursor: pointer;
	}
	.planPerShow>div{
		/*width:20px;*/
		display: inline-block;
		color:#9e9ca5;
		margin-bottom: 5px;
		font-size:14px;
		
	}
	.list_box {
		width: calc( 100% - 40px);
		z-index: 9999;
		padding: 10px 20px;
	}
	
	.listTitle {
		margin-top: 20px;
	}
	
	.listTitle>span {
		font-size: 16px;
		margin-right: 40px;
		color: white;
	}
	
	.listPart {
		margin-top: 20px;
	}
	
	.listPart,
	.listPart>span {
		font-size: 14px;
		color: rgb(112, 112, 112);
	}
	
	.listPart>span {
		margin-left: 20px;
	}
	
	.dataContainer {
		display: flex;
	}
	
	.processLeft {
		width: 200px;
	}
	
	.processLeft>ul>li {
		margin-bottom: 20px;
		background: #3F3D49;
	}
	
	.prolist_tit {
		position: relative;
		height: 35px;
		line-height: 35px;
		background: #4DA1FF;
		/*display: flex;*/
		font-size: 14px;
		text-align: center;
		/*justify-content: center;*/
		/*border-top-left-radius: 10px;
		border-top-right-radius: 10px;*/
	}
	
	.processLeft div,
	.processLeft span {
		color: white;
	}
	
	.progress_box {
		height: 200px;
		padding: 15px 0px;
		border-bottom-left-radius: 10px;
		border-bottom-right-radius: 10px;
		flex-wrap:
	}
	
	.missionBtn {
		margin-top: 20px;
		text-align: center;
	}
	
	.missionBtn>span {
		cursor: pointer;
		border: 1px solid white;
		padding: 3px 8px;
		margin: 0 5px;
		border-radius: 8px;
	}
	
	.demo-Circle-custom {}
	
	.processRight {
		width: calc(100% - 50px);
		margin-left: 20px;
		background: #3F3D49;
		padding-top: 20px;
	}
	
	.journalContainer {}
	
	.selectContainer {
		border: 1px solid #707070;
		margin: 0 20px;
	}
	
	.selectContainer div,
	.selectContainer li {
		color: white;
		font-size: 14px;
	}
	
	.typeTit {
		height: 41px;
		padding: 0 15px;
		line-height: 41px;
	}
	
	.selectContainer>ul>li {
		height: 41px;
		line-height: 41px;
		;
		text-align: center;
		cursor: pointer;
	}
	
	.selectContainer>ul>li:hover {
		background: #2A2735;
	}
	
	.journalBox {
		width: 100%;
		display: flex;
		justify-content: flex-start;
		align-items: center;
		margin-top: 40px;
		padding-left: 10px;
		padding-bottom: 10px;
	}
	
	.journalBox>input {
		width: 35%;
		height: 34px;
		background: none;
		color: #707070;
		border: 1px solid #707070;
		color: white;
		font-size: 16px;
		margin-right: 20px;
	}
	
	.typeProgress {
		width: 30%;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}
	
	.typeProgress>span {
		color: #4DA1FF;
		font-size: 16px;
	}
	
	.release {
		width: 60px;
		height: 32px;
		text-align: center;
		line-height: 32px;
		color: white;
		border: 1px solid #707070;
		margin-left: 20px;
		cursor: pointer;
	}
	
	.evaList>div,
	.bigEva {
		width: 100%;
		position: relative;
		display: flex;
		justify-content: flex-start;
		align-items: center;
		margin-bottom: 10px;
		left: -10px;
	}
	
	.bigEva {
		left: 60px;
	}
	
	.smallEvaBox {
		width: 100%;
		position: relative;
		display: flex;
		justify-content: flex-start;
		align-items: center;
		margin-bottom: 10px;
	}
	
	.smallReaply {
		width: 100%;
	}
	
	.smallEvaBox {
		left: 80px;
	}
	
	.evaLeft {
		width:60px;
		text-align: center;
	}
	
	.evaLeft>div:nth-child(1) {
		width: 10px;
		height: 10px;
		display: inline-block;
	}
	
	.evaLeft>div:nth-child(2) {
		font-size: 10px;
	}
	
	.evaRight {
		width:calc( 100% - 60px );
		font-size: 14px;
		margin-left: 10px;
	}
	
	.evaRight>span {
		margin-right: 20px;
	}
	
	.evaRight>pre {
		margin-top: 6px;
		color: #999;
	}
	
	.smallEvaBox>input {
		width: 25%;
		height: 30px;
		background: none;
		color: #707070;
		border: 1px solid #707070;
		color: white;
		font-size: 14px;
		margin-right: 20px;
	}
	
	.typeChoice {
		background: none;
		padding: 2px;
		color: white;
		font-size: 14px;
	}
	
	.typeChoice>option {
		background: none;
		color: black;
	}
	
	.processCur {
		box-shadow: 0px 0px 30px 1px #3B8CF8, 0px 0px 3px #3B8CF8, 0px 0px 3px #3B8CF8, 0px 0px 3px #3B8CF8;
	}
	
</style>
<style type="text/css">
	.my_kask_x .ivu-slider-disabled .ivu-slider-bar {
		background: #fff !important;
		box-shadow: 0px 0px 30px 1px #9158F5, 0px 0px 3px #9158F5, 0px 0px 3px #9158F5, 0px 0px 3px #9158F5;
	}
	
	.my_kask_x .ivu-slider-disabled .ivu-slider-wrap {
		background: #898b8a;
		/*box-shadow:0px 0px 30px 1px #FF5722, 0px 0px 3px #FF5722, 0px 0px 3px #FF5722, 0px 0px 3px #FF5722;*/
	}
	
	.my_kask_x .ivu-slider-disabled .ivu-slider-button {
		display: none;
	}
	
	.my_kask_x .typeProgress .ivu-slider-bar {
		background: #fff !important;
		box-shadow: 0px 0px 30px 1px #3B8CF8, 0px 0px 3px #3B8CF8, 0px 0px 3px #3B8CF8, 0px 0px 3px #3B8CF8;
	}
	
	.my_kask_x .typeProgress .ivu-slider-wrap {
		background: #898b8a;
	}
	
	.my_kask_x .typeProgress .ivu-tooltip-rel {
		top: -10px !important;
	}
	.my_kask_x .smallEvaBox .ivu-input-wrapper{
		
	}
	.my_kask_x .smallEvaBox textarea.ivu-input,.my_kask_x .journalBox textarea.ivu-input {
		background: none !important;
		border: 1px solid #707070;
		color: white;
		height:24px;
	}
	
	.ivu-breadcrumb {
		padding: 10px 0 0 20px !important;
	}
	
	.jindut .ivu-slider {
		width: 100%;
	}
	
	.jindut .ivu-tooltip-rel {
		top: -12px !important;
	}
	
	.jindut .ivu-slider-disabled .ivu-slider-button {
		border-color: #0ab3e9 !important;
	}
	
	.my_kask_x .ivu-slider-wrap {
		width: 100%;
	}
	
	.my_kask_x .ivu-slider-button-wrap {
		top: 5px !important;
	}
	
	.journalContainer .ivu-input-wrapper {
		width: 40%;
	}
	
	.journalContainer .ivu-slider {
		width: 100% !important;
	}
</style>