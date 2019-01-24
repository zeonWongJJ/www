<template>
	<div class="service_list">
		<div>
			<van-nav-bar title="服务列表" left-arrow @click-left="onClickLeft">
			</van-nav-bar>

		</div>
		<div class="service_list_box">
			<div class="box_top">
				<div class="box_title" v-for="(item,index) in title" @click="tab_title(index)">
					<span :class="{span_boeder : index == span_boeder_num}" v-if="options_list_h && index == 0">{{options_list_h}}</span>
					<span :class="{span_boeder : index == span_boeder_num}" v-else>{{item}}</span>
					<img src="../../assets/img/img_vx/service_h_tbottom.png" v-if="span_boeder_num == index && title_collapse == false" />
					<img src="../../assets/img/img_vx/service_s_bottom.png" v-if="span_boeder_num != index" />
					<img src="../../assets/img/img_vx/service_h_top.png" v-else-if="title_collapse == true" />
					<!--<span :class="{i_boeder : index == span_boeder_num}"></span>-->
				</div>
				<!--点击下拉-->
				<transition name="slide-fade">
					<div v-show="title_collapse" class="transition_box" @click="title_collapse = false">
						<transition name="slide-fade">
						<div class="box_title_collapse" v-show="title_collapse">
							<ul>
								<li class="collapse_li" v-for="(item,index) in options_list" :class="{collapse_li_h : index == options_list_num}" @click="on_options_list(item,index)">
									{{item}}
								</li>
							</ul>
						</div>
						</transition>
					</div>
				</transition>
			</div>
			<div class="box">

				<!--list-->
				<div class="box_list" >
					<ul>
						<li class="box_list_li" v-for="(item,index) in lists" @click="service_details(item,index)">
							<div class="box_list_li_img">
								<img src="../../assets/img/find_server/server_7.png" />
							</div>
							<div class="box_list_li_text">
								<div class="box_list_li_text_title">
									<h4>{{item.title}}</h4>
									<span>{{item.type}}</span>
								</div>
								<div class="box_list_li_text_com">
									<span>接单率{{item.com}}%</span>
									<span>平均30秒接单</span>
								</div>
								<div class="box_list_li_text_star">
									<span>评分<span>{{item.star}}</span></span>
								</div>
								<div class="box_list_li_text_money">
									<p>￥{{item.money}} </p><span>预约金</span>
								</div>
								<div class="box_list_li_text_company">
									<img src="../../assets/img/xx_m.png" />{{item.company}}
								</div>
							</div>
						</li>
					</ul>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				title: ['综合排序', '筛选'],
				title_collapse: false,
				span_boeder_num: 0,
				options_list_num: 0,
				options_list_h: '',
				options_list: ['综合排序', '销量最高', '评分最好', '接单快', '价格由高到低', '价格由低到高'],
				lists: [{
						title: '消毒柜和消费宁静按时的那两个法国军事',
						com: 90,
						star: 5,
						money: 1100,
						company: '家杰服务有限公司',
						type: '企业'
					},
					{
						title: '消毒柜的那两个法国军事',
						com: 50,
						star: 4.2,
						money: 1100,
						company: '家杰服务有限公司',
						type: '合作商'
					},
					{
						title: '消毒柜按时的那两个法国军事',
						com: 100,
						star: 5,
						money: 1100,
						company: '家杰服务有限公司',
						type: '企业'
					},
					{
						title: '消毒柜和消费',
						com: 100,
						star: 5,
						money: 1100,
						company: '家杰服务有限公司',
						type: '合作商'
					},
					{
						title: '消毒柜和消费宁静按时的那两个法国军事',
						com: 100,
						star: 4.8,
						money: 100,
						company: '家杰服务有限公司',
						type: '企业'
					},
				]
			}

		},
		mounted() { //生命周期 

		},
		methods: { //方法
			onClickLeft() {
				this.$router.back(-1)
			},
			tab_title(index) {
				this.span_boeder_num = index
				this.options_list_num = 0
				if(index == 0) {
					this.title_collapse = !this.title_collapse
				} else {
					this.title_collapse = false
				}

			},
			on_options_list(item, index) {
				this.options_list_num = index
				this.options_list_h = item
				console.log(this.options_list_h)
				this.title_collapse = false
			},
//			详情进入
			service_details(item,index){
				this.$router.push({
					path:'/service_details'
				})
			}

		},

	}
</script>

<style scoped>
	.service_list {}
	
	.service_list_box {
		position: absolute;
		top: .46rem;
		left: 0;
		right: 0;
		bottom: 0;
		height: calc(100% - 0.68rem);
		/*overflow: auto;*/
		/*margin-bottom: .15rem;*/
		background: #f5f5f5;
	}
	
	.box {
		position: absolute;
		top: .5rem;
		left: 0;
		right: 0;
		bottom: 0;
		height: calc(100% - 0.46rem);
		margin-top: .15rem;
		overflow: auto;
		background: #f5f5f5;
	}
	/* 可以设置不同的进入和离开动画 */
	/* 设置持续时间和动画函数 */
	
	.slide-fade-enter-active {
		transition: all .3s ease;
	}
	
	.slide-fade-leave-active {
		transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
	}
	
	.slide-fade-enter,
	.slide-fade-leave-to
	/* .slide-fade-leave-active for below version 2.1.8 */
	
	{
		transform: translateY(-30px);
		opacity: 0;
	}
	
	h4 {
		margin: 0 0;
		padding: 0 0;
		font-size: .16rem;
	}
	
	.box_top {
		display: flex;
		height: .54rem;
		background: #fff;
		margin-bottom: 0.12rem;
	}
	
	.box_title {
		width: 50%;
		height: .52rem;
		line-height: .52rem;
		text-align: center;
		border-bottom: .01rem solid #eee;
	}
	
	.box_title>span {
		font-size: .16rem;
		padding-bottom: .14rem;
		font-weight: 700;
	}
	
	.box_title>span>img {
		margin-left: .05rem;
		margin-top: -0.15rem;
		width: .12rem;
		/*height: .2rem;*/
	}
	
	.span_boeder {
		border-bottom: .02rem solid #18b4ed;
		color: #18b4ed;
	}
	
	.transition_box {
		position: fixed;
		top: .98rem;
		left: 0;
		right: 0;
		bottom: .55rem;
		width: 100%;
		background: rgba(0, 0, 0, .1);
		z-index: 55;
	}
	
	.box_title_collapse {
		position: absolute;
		top: 0rem;
		width: 100%;
		height: 3.05rem;
		background: #fff;
		z-index: 999;
	}
	
	.collapse_li {
		height: .5rem;
		line-height: .5rem;
		color: #707070;
		padding: 0 .15rem;
		border-bottom: 0.01rem solid #eee;
	}
	
	.collapse_li_h {
		color: #18b4ed;
	}
	
	.box_list {
		padding: 0 .12rem;
	}
	
	.box_list_li {
		background: #fff;
		display: flex;
		height: 1.52rem;
		padding-top: .15rem;
		border-radius: 0.03rem;
		margin-bottom: 0.12rem;
	}
	
	.box_list_li_img {
		flex: 0 0 .96rem;
	}
	
	.box_list_li_img img {
		margin-left: .1rem;
		border-radius: 0.05rem;
		width: .86rem;
		height: .86rem;
	}
	
	.box_list_li_text {
		width: 100%;
		margin-left: .14rem;
	}
	
	.box_list_li_text_title {
		position: relative;
	}
	
	.box_list_li_text_title h4 {
		width: 2rem;
		overflow: hidden;
		font-size: .16rem;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis
	}
	
	.box_list_li_text_title span {
		font-size: .12rem;
		border: solid #ff9c00 .01rem;
		padding: 0rem .03rem;
		border-radius: 0.03rem;
		color: #ff9c00;
		position: absolute;
		top: 0.02rem;
		right: 0.12rem;
	}
	
	.box_list_li_text_com span {
		color: #B2B2B2;
		font-size: .12rem;
	}
	
	.box_list_li_text_star {
		margin: 0.03rem 0;
	}
	
	.box_list_li_text_star>span {
		border: solid #ff9c00 .01rem;
		font-size: .12rem;
		color: #ff9c00;
		padding: 0 0 0.02rem .06rem;
		overflow: hidden;
		border-radius: 0.03rem;
	}
	
	.box_list_li_text_star>span span {
		display: inline-block;
		width: .27rem;
		font-size: .12rem;
		background: #ff9c00;
		color: #fff;
		text-align: center;
		padding: 0 0rem .02rem 0;
		margin-left: 0.01rem;
	}
	
	.box_list_li_text_money {
		display: flex;
		font-size: .18rem;
		color: #f00;
		align-items: center;
		margin: 0 0 0.15rem 0;
	}
	
	.box_list_li_text_money p {
		margin: 0 0.15rem 0 0;
		padding: 0 0;
	}
	
	.box_list_li_text_money span {
		font-size: .12rem !important;
		background: #f00;
		color: #fff;
		line-height: .15rem;
		padding: 0.02rem 0.05rem;
		border-radius: 0.03rem;
	}
	
	.box_list_li_text_company {
		padding: 0.1rem 0 0 0;
		border-top: 0.02rem solid #eee;
		font-size: .12rem;
	}
	
	.box_list_li_text_company img {
		width: .1rem;
	}
</style>