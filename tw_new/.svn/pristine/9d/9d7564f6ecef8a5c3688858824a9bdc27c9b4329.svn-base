<template>
	<div class="plan_deta">

		<div class="test-1">
			<div class="task_details_header">
				<div class="return_blue"></div>
				<div class="header_text">计划详情</div>
			</div>
			<!--计划-->
			<ul class="plan_rele">
				<li v-for='(ten,index) in dax_bj'>
					<div>
						<div class="rele_le">计划 {{index+1}}</div>
						<div class="rele_ri">
							<p>
								<span class="rele_ri_span">{{ten.plan_name}}</span>
								<span @click.stop="oisshow(ten,index)" v-if="ten.tasks != ''">
								<span>
									展开任务
								</span>
								</span>
							</p>

							<div class="tasks_li" :class="'tasks_li' + index">
								<div v-for="(itas,index) in ten.tasks">
									<div class="span_colco ">&nbsp;>&nbsp;&nbsp;任务&nbsp;&nbsp;&nbsp;&nbsp;</div>
									<div>{{itas.task_title}} {{itas.task_id}}</div>
									<div>&nbsp;&nbsp;&nbsp;&nbsp; <span class="span_colco"></span>&nbsp;&nbsp; <span class="span_colco" @click.stop="task_remove_plan(itas,index,ten.plan_sub_id)">删除</span> </div>
								</div>
							</div>
						</div>
					</div>
				</li>
			</ul>
			<!--其他内容-->
			<ul class="plan_other">
				<li v-if="plan_type == 1">
					<div class="rele_le">评分</div>
					<div class="rele_ri_fen" v-if="plan_score == 0">暂无评分</div>
					<div class="rele_ri_fen" v-else>{{plan_score}}</div>
				</li>
				<li>
					<div class="rele_le">关联项目</div>
					<div class="rele_ri">
						<span v-for="name in plan_project_names">
							 {{name}}
						</span>
						
					</div>
				</li>
				<li>
					<div class="rele_le">计划工期</div>
					<div class="rele_ri">{{plan_time_limit}}</div>
				</li>
				<li>
					<div class="rele_le">参与人</div>
					<div class="rele_ri">
						<span v-for="name in real_name" > {{name.real_name}} , </span>
					</div>
				</li>
			</ul>
			<div class="padd">
				<eva-luate :name="real_name" :kid="this.$route.query.oid_details"></eva-luate>

			</div>
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
				real_name: '', //会员名字
				dax_bj: [], //编辑计划列表
				real_name: [], //real_name
				plan_project_names: [], //plan_project_names
				plan_time_limit: '', //时间
				tasks: [], //任务计划
				plan_sub_id: '', //plan_sub_id
				index: '',
				isshow: false,
				plan_type:'',
				plan_score : this.$route.query.plan_score,
			}
		},

		methods: {
			//拿数据
			oplan_children() {
				let that = this
				let liform = {};
				liform.plan_id = this.$route.query.oid_details
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
							that.dax_bj = arre
							for(var j = 0; j < arre.length; j++) {
								let plan_project_names = arre[j].plan_project_names
								let real_name = arre[j].plan_belonged_data
								let plan_time_limit = arre[j].plan_time_limit
								let date = plan_time_limit * 1000
								let datas = new Date(date);
								let date_value = datas.getFullYear() + '-' + (datas.getMonth() + 1) + '-' + datas.getDate()
								let idsu = arre[j].plan_sub_id
								that.riod_ress = arre[j].plan_type
								let plan_ids = arre[j].plan_project_ids.split(",");
								let plan_belonged = arre[j].plan_belonged.split(",");
								that.real_name = real_name
								that.plan_project_names = plan_project_names
								that.plan_time_limit = date_value
								that.plan_sub_id = arre[j].plan_sub_id
								that.plan_type = arre[j].plan_type
									console.log('------------asdfasdf---------------------', 	that.plan_sub_id)
							}

						} else {
							that.$Message.error(data.msg)
						}
					})
			},
			task_remove_plan(itas, index,id) {
				let that = this
				let liform = {};
				liform.task_id = itas.task_id
				liform.plan_sub_id = id
				console.log('---------------------`12121------------',itas)
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.task_remove_plan,
						data: qs.stringify(liform) //传参变量
					})
					.then(function(res) {
						let data = res.data
						if(data.error == 0) {
							  itas.splice(index, 1);

						} else {
							that.$Message.error(data.msg)
						}
					})
			},
			oisshow(tem, index) {
				let that = this
			
				that.index = index
				that.plan_sub_id = that.dax_bj[index].plan_sub_id
				$('.tasks_li' + index).toggle()

			},
			oshow(index) {
				let that = this

			}

		},
		created() {

		},
		mounted() {
			this.oplan_children()
		}

	}
</script>
<style scoped>
	.plan_deta {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: #fff;
		border-left: 1px solid #f9f9f9;
	}
	
	.tasks_li {
		display: none;
	}
	
	.tasks_li>div {
		display: flex;
		background: #f8f8f8;
		font-size: 14px;
		padding: 8px;
		border-radius: 5px;
		margin-top: 10px;
	}
	
	.tasks_li>div div:nth-child(2) {
		flex: 0 0 595px;
	}
	
	.plan_rele {
		margin: 20px 0;
	}
	
	.plan_rele li {
		margin: 20px 0;
	}
	
	.plan_rele>li>div {
		display: flex;
	}
	
	.rele_le {
		width: 170px;
		text-align: center;
		font-size: 16px;
		padding: 10px 0;
	}
	
	.rele_ri {
		font-size: 15px;
		width: 800px;
		border: 1px solid #eee;
		padding: 10px;
		border-radius: 5px;
	}
	.rele_ri p {
		display: flex;
	}
	.rele_ri p span:nth-child(2){
		font-size: 14px;
		color: #0ab3e9 ;
	}
	.span_colco {
		color: #00C1DE;
	}
	
	.rele_ri_span {
		width: 700px;
	}
	
	.plan_other {
		border-bottom: 1px solid #eee;
	}
	
	.plan_other>li {
		display: flex;
		margin: 20px 0;
	}
	
	.rele_ri_fen {
		width: 50px;
		text-align: center;
		font-size: 14px;
		padding: 10px;
		border-radius: 5px;
		border: 1px solid #f63;
	}
	
	.task_details_header {
		height: 44px;
		border-bottom: 1px solid rgba(186, 233, 249, .8);
		display: flex;
		align-items: center;
		color: #0ab3e9;
		margin-bottom: 35px;
	}
	
	.return_blue {
		width: 8px;
		height: 12px;
		background: url(../../assets/img/return_bllue.png);
		margin: 0 7px 0 25px;
	}
</style>