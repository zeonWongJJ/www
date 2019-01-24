<template>
	<div class="plan">
		  <Breadcrumb>
		        <BreadcrumbItem>公司计划</BreadcrumbItem>
		         <BreadcrumbItem></BreadcrumbItem>
		    </Breadcrumb>
		<div class="tit_box">
			<ul class="plan_tit_box_ul">
				<li @click="plan">个人计划</li>
				<li class="tit_box_li">公司计划</li>
				<li @click="goCollect">每周汇总</li>
			</ul>
		</div>
		<div class="myplan test-1">
			<!--<div class="butt">
				<div @click="plan_release">发布计划</div>
			</div>-->
			<div v-if="myplan == ''" class="qk">
				暂无计划
			</div>
			<div class="ul_div" v-for="(item,index) in myplan" v-else>
				<div class="li_div" @click="plan_details(item,index)">
					<div>
						<div class="plantype">
							<img v-if="item.plan_name" src="../../assets/img/week.png" />
							<!--<img v-if="item.plantype == 1 && !item.thisWeek" src="../../assets/img/week_old.png" />
							<img v-if="item.plantype == 2 && item.thisWeek" src="../../assets/img/ding.png" />
							<img v-if="item.plantype == 2 && !item.thisWeek" src="../../assets/img/ding_old.png" />-->
						</div>
						<div class="personBox">
							{{item.plan_name}}
						</div>
						<div class="progressBox">
							<template>
								<!--<div class="progress">
									<Slider v-model="item.progress" show-tip="never" disabled></Slider>
								</div>
								<div class="progressNum">{{item.progress}}%</div>-->
							</template>
						</div>
						<div class="btnBox">
							<template>
								<!--<div class="scoreNum btn" v-if="item.plan_achieve_score != 0 || item.plan_score != 0 ||item.total_score != 0">{{item.total_score}}分</div>-->
								<!--<div v-else class="score btn" @click="doScore = true,oplan_score(item,index)">评分</div>-->
									<div class="edit btn">查看</div>
							</template>
						</div>
					</div>
				</div>
			</div>
			<Modal v-model="doScore" @on-ok="ok" width="492px" height="287px" ok-text="确定" title="评分" @on-cancel="cancel">
				<div style="text-align: center;color: rgba(40,48,51,.5);font-size: 18px;">
					<p>计划制定评分</p>
					<Rate :count="starNum" show-text v-model="score1"><span style="color: #f5a623">{{ score1 }}</span></Rate>
					<p>计划完成量制定评分</p>
					<Rate :count="starNum" show-text v-model="score2"><span style="color: #f5a623">{{ score2 }}</span></Rate>
				</div>
			</Modal>
			<Modal v-model="donScore" width="492px" height="287px" ok-text="知道了" title="通知提醒">
				<p style="color: rgba(40,48,51,.5);font-size: 18px;text-align: center;">您没有此项评分权限哦</p>
				<div slot="footer" style="text-align: center;">
					<Button type="info" size="large" shape="circle" @click="donScore = false">知道了</Button>
				</div>
			</Modal>
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default {
		data() {
			return {
				starNum: 6,
				doScore: false,
				donScore: false,
				score1: 0,
				score2: 0,
				myplan: [],
				plan_id: 0,
				index: 0,
				plan_type:'',
			}
		},
		mounted() {
			this.olist()
		},
		methods: {
			olist() {
				let that = this;
				let list = {}
//				list.member_id = this.$store.state.member_id;
				list.type = 1
				list.rows = 500
				var qs = require('qs');
				that.axios({
						method: 'post',
						url: api.plans_list,
						data: qs.stringify(list)
					})
					.then(function(val) {
						if(val.data.error == 0) {
							that.myplan = val.data.data.list
							that.$store.commit('plan_type', val.data.data.list[0].plan_type);
							
						} else {
							that.$Message.error(val.data.msg);
						}

					})
			},
			//每周汇总
			goCollect(){
				let that = this;
				that.$router.push({
					path: "weekCollect",
				});
			},
			plan() {
				this.$router.push({
					path: 'plan_x'
				})
			},
			participate_plan() {
				this.$router.push({
					path: 'participate_plan'
				})
			},
			others_plan() {
				this.$router.push({
					path: 'others_plan'
				})
			},
			plan_release() {
				this.$router.push({
					path: 'plan_release'
				})
			},
			ok() {
				let that = this;
				let score = {}
				score.plan_id = that.plan_id
				score.plan_achieve_score = that.score1 //实现评分
				score.plan_score = that.score2 //计划评分
				var qs = require('qs');
				that.axios({
						method: 'post',
						header: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						url: api.plan_score,
						data: qs.stringify(score) //传参变量
					})
					.then(function(score) {
						if(score.data.error == 0) {
							that.$Message.success('评分成功');
							that.myplan[that.index].total_score = that.score1 + that.score2;
							that.score1 = 0;
							that.score2 = 0;
						} else {
							that.$Message.error(score.data.msg);
						}

					})
			},
			cancel() {
				let that = this;
				that.score1 = 0;
				that.score2 = 0;
			},
			plan_details(item, index) {
				let that = this
				that.$store.commit('plan_id', item.plan_id);
				let plan_id = item.plan_id
				let plan_type = that.$store.state.plan_type
				let plan_name = item.plan_name
				that.$router.push({
					path: 'plan_list_x',
					query:{
						plan_id,
						plan_type,
						plan_name
					}
				
				})
			},
		}
	}
</script>
<style>
	/*滑块样式*/
	
	.myplan .ivu-slider-wrap {
		background-color: rgba(255, 195, 36, .25);
	}
	
	.myplan .ivu-slider-bar {
		background: #ffc324;
	}
	
	.myplan .ivu-slider-button {
		border: 2px solid #ffc324;
	}
	/*滑块样式end*/
	/*对话框样式*/
	
	.myplan .ivu-modal {
		border-radius: 14px;
	}
	
	.myplan .ivu-modal-body {
		margin-top: 20px;
	}
	
	.myplan .ivu-modal-close {
		top: 14px;
	}
	
	.myplan .ivu-modal-header {
		padding: 0;
		height: 62px;
		line-height: 64px;
		background: #f5f5f5;
		border-bottom: none;
		border-radius: 14px;
	}
	
	.myplan .ivu-modal-header p,
	.ivu-modal-header-inner {
		font-size: 20px;
		font-weight: normal;
		color: #283033;
	}
	
	.myplan .ivu-modal-header-inner {
		margin-left: 20px;
	}
	
	.myplan .ivu-modal-footer {
		border-top: none;
		text-align: center;
	}
	/*对话框样式end*/
</style>
<style scoped>
	.myplan {
		position: absolute;
		top: 20px;
		width: 1090px;
		height: 100%;
		overflow: hidden;
		overflow-y: scroll;
		overflow-x: auto;
	}
	
	.myplan::-webkit-scrollbar-track {
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
	
	
	.tit_box_li:before {
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
	
	/**/
	
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
		background: #fff;
		color: #333;
		border-radius: 6px;
	}
	/*板块*/
	
	.ul_div {
		width: 99%;
		padding: 30px 55px;
		position: relative;
		transition: all 0.3s;
	}
	
	.li_div:hover {
		transform: scale(1.01);
		box-shadow: 0 0 15px rgba(10, 179, 233, .2);
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
	
	.li_div>div {
		text-align: center;
		display: flex;
		align-items: center;
	}
	
	.plantype {
		padding: 0 43px;
		display: flex;
		align-items: center;
	}
	
	.personBox {
		width: 279px;
		font-size: 30px;
		color: #283033;
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
		margin-right: 76px;
	}
	
	.progressBox {
		width: 269px;
		display: flex;
		align-items: center;
	}
	
	.progress {
		width: 139px;
	}
	
	.progressNum {
		margin-left: 10px;
		font-size: 20px;
		color: #ffc324;
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
		border: 2px solid rgba(10, 179, 233, .4);
		color: #0AB3E9;
		border-radius: 20px;
		font-size: 16px;
		line-height: 36px;
		cursor: pointer;
	}
	
	.eye {
		margin-left: 27px;
	}
	
	.btn.score {
		border: 2px solid rgba(255, 90, 110, .4);
		color: #ff5a6e;
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
		width: 101px;
		display: none;
		background: #fff;
		border-radius: 2px;
		position: relative;
		top: 21px;
		left: -79px;
		z-index: 999999;
		flex-direction: column;
		font-size: 16px;
		line-height: 52px;
		color: #283033;
	}
	
	.moreBox>div {
		cursor: pointer;
	}
	
	.more_more {
		height: 40px;
		width: 40px;
		margin: auto;
		background: url('../../assets/img/arrow_down.png') no-repeat;
		background-position: 10px 5px;
	}
	
	.qk {
		text-align: center;
		margin-top: 30px;
		color: #999;
		font-size: 14px;
	}
</style>