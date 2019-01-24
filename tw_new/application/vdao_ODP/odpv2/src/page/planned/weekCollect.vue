<template>
	<div class="weekContainer">
		<div class="tit_box">
			<ul class="plan_tit_box_ul">
				<li @click="plan">个人计划</li>
				<li @click="participate_plan">公司计划</li>
				<li class="tit_box_li">每周汇总</li>
			</ul>
		</div>
		<div class="content">
			<dataTable :planData="planData"></dataTable>
			<!--<Table highlight-row :align="center" ref="currentRowTable" :stripe="true" :border="true" :columns="columns3" :data="data1"></Table>-->
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	import dataTable from './dataTable'
	export default {
		data() {
			return {
				columns3: [{
						type: 'index',
						width: 60,
						align: 'center'
					},
					{
						title: '计划',
						key: 'plan_name'
					},
					{
						title: '动作记录',
						key: 'plan_discuss'
					},
					{
						title: '时间',
						key: 'date'
					},
					{
						title: '进度',
						key: 'progress',
						render: (h, param) => {
							return h('span', `${param.row.progress}%`)
						}
					},
				],
				data1: [],
				planData: []				
			}
		},
		components:{
			dataTable
		},
		mounted() {
			this.datalist()
		},
		methods: {
			handleClearCurrentRow() {
				this.$refs.currentRowTable.clearCurrentRow();
			},
			plan() {
				this.$router.push({
					path: 'plan_x'
				})
			},
			participate_plan() {
				this.$router.push({
					path: 'company_plan_x'
				})
			},
			datalist() {

				let that = this;
				let list={};
				var row=[];
				var qs = require('qs');
				list.rows = 500
				that.axios({
						method: 'post',
						url: api.plan_weekly,
				}).then(rs => {
						if (rs.data.error === 0) {
							console.log(rs.data.data.list)
							this.planData = rs.data.data.list
							row.push(rs.data.data.list);
						}
					this.data1=row
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
</style>