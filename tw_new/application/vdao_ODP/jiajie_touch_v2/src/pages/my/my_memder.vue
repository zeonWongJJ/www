<template>
	<div class="member">
		<div>
			<van-nav-bar title="会员中心"  >
				<!--<van-icon name="wap-nav" color="white"  />-->
			</van-nav-bar>
		</div>
		<div class="box">
			<!--tan-->
			<div class="bar_d" :class="{bar_d_2:!show}">
				<ul class="tan_x">
					<li @click="show = true" :class="{tan_x_li:show}">用户版</li>
					<li @click="show = false" :class="{tan_x_li:!show}">商家版</li>
				</ul>
			</div>
			
			<!--显示二维码-->
			<van-popup v-model="show_ewm_plus">
				<img @click="show_ewm_plus = false" style="width:0.2rem; position: absolute; right:0.2rem; top:0.1rem" src="../../assets/img/cancel.png" alt="" />
				<div class="showView" @click="show_ewm_plus = false">
					<div class="code">
						<img src="../../assets/img/img_vx/bar_con.png" />
						<!--一个商家的一个【普通的-->
						<!--<img src="../../assets/img/img_vx/bar_con.png"/> -->
					</div>
					<div class="bottom">下单出示会员码，可积累积分</div>
				</div>
			</van-popup>
			<transition name="slide-fade">
				<div class="personal" v-if="show">
					<!--头像-->
					<div class="personal_head_portrait">
						<div class="personal_head_portrait_img">
							<div class="personal_head_portrait_img_div">
								<div>
									<img src="../../assets/img/img_vx/bar_con.png" />
								</div>
								<div class="personal_head_portrait_text">
									<h4>非艳猪</h4>
									<span>ID：123123123</span>
								</div>
							</div>
							<div class="personal_head_portrait_ewm" @click="show_ewm_plus = true">
								<img src="../../assets/img/img_vx/bar_con.png" />
								<p>会员专属码</p>

							</div>
						</div>
						<!--My amount 金额 balance-->
						<ul class="balance">
							<li>
								<h4>1000</h4>
								<span>余额</span>
							</li>
							<li>
								<h4>10000</h4>
								<span>积分</span>
							</li>
							<li>
								<h4>1000000</h4>
								<span>收藏</span>
							</li>
						</ul>
					</div>
					<!--我的订单-->
					<div class="personal_order">
						<!--我的订单-->
						<div class="order">
							<div class="title">
								<div>我的订单</div>
								<div class="right">查看全部 </div>
							</div>
							<div class="row">
								<div class="span">
									<div class="top">待付款</div>
									<div>0</div>
								</div>
								<div class="span">
									<div class="top">待接单</div>
									<div>0</div>
								</div>
								<div class="span">
									<div class="top">待服务</div>
									<div>0</div>
								</div>
								<div class="span">
									<div class="top">待评价</div>
									<div>0</div>
								</div>
								<div class="span">
									<div class="top">已关闭</div>
									<div>0</div>
								</div>
							</div>
						</div>
					</div>
					<!--选项-->
					<ul class="option">
						<li class="option_li">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/friend.png" /></div>
									<div>邀请好友</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/address.png" /></div>
									<div>地址管理</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/edit.png" /></div>
									<div>我的评价</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/service.png" /></div>
									<div>联系客服</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/about.png" /></div>
									<div>关于家杰</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/index/set_up.png" /></div>
									<div>个人设置</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/index/shop_h.png" /></div>
									<div>我的店铺</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
					</ul>

				</div>
			</transition>
			<!--商家-->
			<transition name="slide-fade">
				<div class="business" v-if="!show">
					<!--头像-->
					<div class="business_head_portrait">
						<div>
							<div>
								<div class="business_head_text">
									<span>
										进入店铺主页
									</span>
								</div>
								<div class="business_head_img">
									<img src="../../assets/img/timg.png" />
								</div>
							</div>
							<div class="business_head_ewm" @click="show_ewm_plus = true">
								<img src="../../assets/img/top.png" />
							</div>
						</div>
						<div class="business_head_title">帮家洁清洁服务</div>
					</div>
					<!--我金额-->
					<div class="business_money">
						<div>
							<div v-if="show_money" class="business_money_number">
								<span>111111.00</span><img src="../../assets/img/img_vx/business_y_2.png" @click="show_money = false" />
							</div>
							<div v-if="!show_money" class="business_money_number">
								<span class="business_money_number_xx">******</span><img src="../../assets/img/img_vx/business_y_1.png" @click="show_money = true" />
							</div>
						</div>
						<div class="brief_intr_box">
							<span v-if="show_money" class="brief_intr">累计收入(元),其中昨日收入200.00元</span>
							<span v-if="!show_money" class="brief_intr">收入已隐藏</span>
						</div>
					</div>
					<!--我的订单-->
					<div class="personal_order">
						<!--店铺订单-->
						<div class="order">
							<div class="title">
								<div>店铺订单</div>
								<div class="right">查看全部 </div>
							</div>
							<div class="row">
								<div class="span">
									<div class="top">待付款</div>
									<div>0</div>
								</div>
								<div class="span">
									<div class="top">待接单</div>
									<div>0</div>
								</div>
								<div class="span">
									<div class="top">待服务</div>
									<div>0</div>
								</div>
								<div class="span">
									<div class="top">待评价</div>
									<div>0</div>
								</div>
								<div class="span">
									<div class="top">已关闭</div>
									<div>0</div>
								</div>
							</div>
						</div>
					</div>
					<!--选项-->
					<ul class="option">
						<li class="option_li">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/img_vx/business_2.png" /></div>
									<div>服务管理</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/img_vx/business_3.png" /></div>
									<div>订单管理</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/friend.png" /></div>
									<div>人员管理</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/edit.png" /></div>
									<div>评价管理</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/img_vx/business_4.png" /></div>
									<div>店铺管理</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
					</ul>
				</div>
			</transition>
		</div>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				show: true,
				show_money: true,
				show_ewm_plus: false,
			}
		},
		mounted() { //生命周期 

		},
		methods: { //方法

		},

	}
</script>
<style scoped>
	h4,
	p {
		padding: 0 0;
		margin: 0 0;
	}
	
	.member {}
	.box{
		position: absolute;
		top: .46rem;
		left: 0;
		right: 0;
		bottom: 0;
		height: calc(100% - 0.46rem);
		overflow: auto;
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
		transform: translateX(120px);
		opacity: 0;
	}
	
	.bar_d {
		height: 2rem;
		width: 100%;
		/*background: #04A220;*/
		background: url(../../assets/img/img_vx/bar_d.png) no-repeat;
		background-size: 100% 100%;
		/*border-radius: 0 0 .5rem .5rem;*/
	}
	
	.bar_d_2 {
		height: 2.42rem;
		width: 100%;
		/*background: #04A220;*/
		background: url(../../assets/img/img_vx/bar_con.png) no-repeat;
		background-size: 100% 100%;
	}
	
	.tan_x {
		display: flex;
		justify-content: center;
	}
	
	.tan_x li {
		font-size: .18rem;
		height: .4rem;
		line-height: .4rem;
		margin: 0 .3rem;
		color: #fff;
		/*border-bottom: 0.01rem solid #fff;*/
	}
	
	.tan_x_li {
		color: #fff;
		border-bottom: 0.01rem solid #fff;
	}
	/*个人*/
	
	.personal {
		position: absolute;
		top: .4rem;
		width: 3.51rem;
		margin: 0 0.12rem;
		border-radius: .05rem;
	}
	
	.personal_head_portrait {
		height: 1.62rem;
		margin-bottom: .15rem;
		background: #fff;
		border-radius: 0.05rem;
		box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
	}
	
	.personal_head_portrait_img {
		display: flex;
		justify-content: space-between;
		height: .9rem;
		align-items: center;
		padding-top: .1rem;
	}
	
	.personal_head_portrait_img_div {
		flex: 0 0 2.5rem;
		display: flex;
		align-items: center;
		/*justify-content: space-between;*/
	}
	
	.personal_head_portrait_text h4 {
		margin-bottom: .1rem;
	}
	
	.personal_head_portrait_img_div div img {
		width: .7rem;
		height: .7rem;
		border-radius: 50%;
		margin: 0 .15rem;
	}
	
	.personal_head_portrait_ewm {
		width: .7rem;
		text-align: center;
		font-size: .10rem;
		margin-right: .15rem;
	}
	
	.personal_head_portrait_ewm img {
		width: .35rem;
		height: .35rem;
		margin: 0 0 .1rem 0;
	}
	
	.balance {
		display: flex;
		justify-content: space-between;
	}
	
	.balance li {
		flex: 0 0 33.3%;
		text-align: center;
	}
	
	.balance li h4 {
		font-size: .16rem;
		margin-bottom: 0.1rem;
	}
	
	.balance li span {
		font-size: .12rem;
		color: #b2b2b2;
	}
	
	.personal_order {
		height: 1.42rem;
		margin-bottom: .17rem;
		background: #fff;
		border-radius: 0.05rem;
		box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
	}
	
	.order {
		background: #fff;
		padding: 0 .15rem;
	}
	
	.order .title {
		display: flex;
		justify-content: space-between;
		padding: .15rem 0;
		border-bottom: 1px solid #f5f5f5;
	}
	
	.order .title div:nth-child(1) {
		font-size: .16rem;
	}
	
	.order .right {
		display: flex;
		align-items: center;
		color: #B2B2B2;
	}
	/*订单的5大块*/
	
	.order .row {
		display: flex;
		padding: .15rem 0;
		text-align: center;
		margin-bottom: .1rem;
	}
	
	.order .row .top {
		margin-bottom: .1rem;
		color: #b2b2b2;
	}
	
	.order .row .span {
		width: 20%;
	}
	/*选择项*/
	
	.option_li {
		height: .55rem;
		margin-bottom: .05rem;
		background: #fff;
		border-radius: 0.05rem;
		box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
	}
	/*label*/
	
	.label {
		display: flex;
		justify-content: space-between;
		align-items: center;
		background: #fff;
		padding: .15rem;
		/*border-bottom: 1px solid #f5f5f5;*/
	}
	
	.label.bottom {
		margin-bottom: .1rem;
	}
	
	.label .left {
		display: flex;
		align-items: center;
	}
	
	.label .left .logo {
		height: .24rem;
		width: .24rem;
		margin-right: .1rem;
	}
	
	.label .left .logo>img {
		width: 100%;
		height: auto;
	}
	
	.right {
		display: flex;
		align-items: center;
		color: #999999;
	}
	
	.right:after {
		content: '';
		display: block;
		width: .07rem;
		height: .125rem;
		margin-left: .05rem;
		background: url(../../assets/img/right.png) no-repeat;
		background-position: center left;
		background-size: .07rem .125rem;
	}
	/*商家*/
	
	.business {
		position: absolute;
		top: .4rem;
		width: 3.51rem;
		margin: 0 0.12rem;
		/*background: #fff;*/
	}
	
	.business_head_portrait {
		height: 1.62rem;
		border-radius: 0.05rem;
	}
	
	.business_head_portrait div:nth-child(1) {
		display: flex;
		align-items: center;
		padding: .07rem 0 0 .045rem;
	}
	
	.business_head_text {
		width: 1.04rem;
		position: relative;
		/*margin: 0 0 0 0.15rem;*/
	}
	
	.business_head_text span {
		width: 1.04rem;
		height: .48rem;
		line-height: 0.48rem;
		border-radius: .48rem;
		border: 0.02rem solid #fff;
		font-size: .12rem;
		padding-left: .15rem;
		color: #fff;
		position: absolute;
		left: .1rem;
	}
	
	.business_head_img {
		width: 1.04rem;
		height: 1.04rem;
		border-radius: 50%;
		background: #18b4ed;
		border: 0.02rem solid #fff;
		position: relative;
		z-index: 999;
	}
	
	.business_head_img img {
		margin: 0.03rem;
		width: .98rem;
		height: .98rem;
		border-radius: 50%;
	}
	
	.business_head_ewm {
		margin-left: .54rem;
		width: .36rem;
		height: .36rem;
	}
	
	.business_head_ewm img {
		width: .36rem;
		height: .36rem;
	}
	
	.business_head_title {
		margin: .04rem 0 0 0;
		text-align: center;
		color: #fff;
		font-size: .2rem;
	}
	
	.business_money {
		height: .82rem;
		margin-bottom: .15rem;
		border-radius: 0.05rem;
		background: #fff;
		box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
		text-align: center;
		padding-top: .2rem;
	}
	
	.business_money_number_xx {
		/*font-size: .24rem !important;*/
	}
	
	.business_money_number {
		font-size: .2rem;
		font-weight: 700;
	}
	
	.business_money_number img {
		margin-left: .22rem;
		width: .2rem;
		height: .13rem;
	}
	
	.brief_intr_box {
		margin-top: .15rem;
	}
	
	.brief_intr {
		color: #B2B2B2;
		font-size: .12rem;
	}
	/*弹出的二维码*/
	
	.showView {
		padding: .25rem;
	}
	
	.showView .user {
		display: flex;
		align-items: center;
	}
	
	.showView .user>img {
		width: .81rem;
		height: .81rem;
		border-radius: 50%;
	}
	
	.showView .code {
		width: 2.5rem;
		height: 2.5rem;
	}
	
	.showView .code>img {
		width: 100%;
		height: 100%;
	}
	
	.showView .bottom {
		margin-top: .2rem;
		text-align: center;
	}
</style>