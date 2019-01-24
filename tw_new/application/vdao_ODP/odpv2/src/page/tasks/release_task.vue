<template>
	<div class="my_kask">
		<div class="tit_box">
			<ul class="tit_box_ul">
				<li @click="my_task">全部任务</li>
				<li @click="all_tasks">计划任务</li>
				<li @click="list_tasks">发布的任务</li>
				<li class="tit_box_li">任务榜单</li>
				<li @click="planned_task">我的任务</li>
			</ul>
		</div>
		<div class="butt">
			<div @click="releases">添加任务</div>
			<!--<div @click="add_o" v-if="isshow == true">未完成</div>
			<div v-if="isshow == false" class="bacolco">未完成</div>
			<div @click="add_o">已完成</div>-->
		</div>
		<div class="box_body test-1">
			<div class="com_box">
				<div v-if="list == ''" class="qk">
					暂无任务榜单
				</div>

				<div class="ul_div" v-for="item in list" @click="task_detail(item.task_id)">
					<div class="ul_div_time">
						{{item.task_date_limit}}
					</div>
					<div class="ul_div_time-stop">
						截止时间
					</div>
					<div class="li_div">
						<div>
							<p class="li_div_img">
								<!--<img src="../../assets/img/time.png"/>-->
							</p>
							<p class="li_div_text">
								{{item.task_title}}
							</p>
						</div>
						<div>
							{{item.task_project_names}}
						</div>
						<div>
							<div class="ul_but">
								<span v-for="itproc in item.task_procedures" :class="[ (itproc.status == -1) ? 'ul_but_4' : (itproc.status == 0) ? 'ul_but_3' : (itproc.status == 1) ? 'ul_but_2' : (itproc.status == 2) ? 'ul_but_1' : '']">{{itproc.department_name}}</span>
							</div>
						</div>
						<div>
							<p class="li_div_img_ri" @click.stop="add_o">
							</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default {
		data() {
			return {
				isshow: true,
				sishow: false,
				sishow1: false,
				sishow2: false,
				list: [],
			}
		},
		created() {
			this.add_lise()
		},
		methods: {
			add_lise() {
				let that = this;
				that.sishow = true
				that.sishow2 = false
				that.sishow1 = false
				let asa = {};
				asa.member_id = this.$store.state.member_id;
				asa.task_type = 4
				asa.rows = 500
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.tasks,
						data: qs.stringify(asa) //传参变量
					})
					.then(function(ress) {
						//						task_procedures
						//						console.log('-****************----------------',ress.data.data.task_procedures)
						that.list = ress.data.data

					})

			},
			add_o() {

				let that = this;
				that.isshow = false

			},
			task_detail(id) {
				let that = this;
				that.$router.push({
					path: 'task_detail',
					query: {
						task_id: id
					}
				})
			},
			releases() {
				let that = this;
				that.$router.push({
					path: 'releases'
				})
			},
			my_task() {
				let that = this;
				that.$router.push({
					path: 'my_task'
				})
			},
			all_tasks() {
				let that = this;
				that.$router.push({
					path: 'all_tasks'
				})
			},
			list_tasks() {
				let that = this;
				that.$router.push({
					path: 'list_tasks'
				})
			},

			planned_task() {
				let that = this;
				that.$router.push({
					path: 'planned_task'
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
		/*position: absolute;*/
		/*top: 0;*/
		/*width: 1050px;*/
		height: 220px;
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
		width: 170px;
		height: 58px;
		line-height: 48px;
		text-align: center;
		font-size: 20px;
		background: #0ab3e9;
		border-radius: 30px;
		color: #fff;
		border: 5px solid #cef0fb;
	}
	
	.ul_div_time-stop {
		position: absolute;
		top: 10px;
		left: 270px;
		font-size: 10px;
		color: rgba(0, 0, 0, .3);
	}
	
	.li_div {
		width: 976px;
		height: 134px;
		line-height: 134px;
		border-radius: 20px;
		background: #fff;
		box-shadow: 0 0 5px rgba(10, 179, 233, .06);
		display: flex;
		align-items: center;
	}
	
	.li_div div:nth-child(1) {
		width: 365px;
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
		width: 225px;
		font-size: 32px;
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
		width: 206px;
		font-size: 22px;
		position: relative;
		text-align: center;
	}
	
	.li_div div:nth-child(2):before {
		width: 215px;
		font-size: 22px;
		content: "";
		position: absolute;
		top: 50%;
		right: 0px;
		height: 55px;
		width: 2px;
		margin: -27.5px 0 0 0;
		background-color: #0ab3e9;
	}
	
	.li_div div:nth-child(3) {
		width: 305px;
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
		width: 100px;
		padding: 28px 0 0 30px;
	}
	
	.li_div_img_ri {
		display: block;
		width: 30px;
		height: 30px;
		background-image: url(../../assets/img/kasta_ri.png);
		background-repeat: no-repeat;
	}
	
	.butt {
		padding: 22px 56px;
		display: flex;
		justify-content: flex-end;
		border-bottom: 1px solid rgba(10, 179, 233, .1);
	}
	
	.butt div {
		width: 90px;
		height: 40px;
		line-height: 40px;
		text-align: center;
		font-size: 15px;
		cursor: pointer;
	}
	
	.butt div:nth-child(1) {
		background: #fff;
		border-radius: 6px;
		margin-right: 26px;
	}
	
	.butt div:nth-child(2) {
		background: #fff;
		border-radius: 6px 0 0 6px;
		box-shadow: 0 0 2px #0ab3e9;
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
</style>