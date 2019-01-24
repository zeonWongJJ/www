<template>
	<div class="member">
		<div>
			<van-nav-bar title="会员中心">
				<!--<van-icon name="wap-nav" color="white"  />-->
			</van-nav-bar>
		</div>
		<div class="box">
			<!--tan-->
			<div class="bar_d" :class="{bar_d_2 : show}" :style="{height: store_status == 1 && staff_pass == 1 ? '2rem' : '2.42rem'}">
				<ul class="tan_x" v-show="store_status == 1 && staff_pass == 1">
					<li @click="onstore_true()" :class="{tan_x_li:show}">用户版</li>
					<li @click="onstore_show()" :class="{tan_x_li:!show}">商家版</li>
				</ul>

			</div>

			<!--显示二维码-->
			<van-popup v-model="show_ewm_plus">
				<img @click="show_ewm_plus = false" style="width:0.2rem; position: absolute; right:0.2rem; top:0.1rem" src="../../assets/img/cancel.png" alt="" />
				<div class="showView" @click="show_ewm_plus = false">
					<div class="code">
						<!--<img src="../../assets/img/img_vx/bar_con.png" />-->
						   <img :src="uploadFileUrl + user.user_qrcode"/>
						<!--一个商家的一个【普通的-->
						<!--<img src="../../assets/img/img_vx/bar_con.png"/> -->
					</div>
					<div class="bottom">下单出示会员码，可积累积分</div>
				</div>
			</van-popup>
			<transition name="slide-fade">
				<div class="personal" v-if="show" :style="{top: store_status == 1 && staff_pass == 1 ? '.4rem' : '.1rem'}">
					<!--头像-->
					<div class="personal_head_portrait">
						<div class="personal_head_portrait_img">
							<div class="personal_head_portrait_img_div">
								<div @click="pers">
									  <img :src="!user.user_pic ? imgs : $get_thumb_img(user.user_pic,150,150)" />
									   <!--<img :src="!user.user_pic ? imgs : user.user_pic" />-->
								</div>
								<div class="personal_head_portrait_text" v-if="user">
									<h4>{{user.user_nickname == '' ? '昵称' : user.user_nickname}}</h4>
									<span>ID：{{user.user_id}}</span>
								</div>
								  <div class="other" v-else @click="toLogin">
						            <div class="unLogin">登录/注册</div>
						          </div>
							</div>
							<div class="personal_head_portrait_ewm" @click="show_ewm_plus = true">
								<!--<img src="../../assets/img/img_vx/bar_con.png" />-->
								  <img :src="uploadFileUrl + user.user_qrcode"/>
								<p>会员专属码</p>

							</div>
						</div>
						<!--My amount 金额 balance-->
						<ul class="balance">
							<li @click="toBalance">
								<h4>{{user.user_balance}}</h4>
								<span>余额</span>
							</li>
							<li @click="toCredit">
								<h4>{{user.user_score}}</h4>
								<span>积分</span>
							</li>
							<li @click="myColl()">
								<h4>{{user.collect_count}}</h4>
								<span>收藏</span>
							</li>
						</ul>
					</div>
					<!--我的订单-->
					<div class="personal_order">
						<!--我的订单-->
						<div class="order">
							<div class="title"  @click="orders">
								<div>我的订单</div>
								<div class="right">查看全部 </div>
							</div>
							<div class="row"  >
								<div class="span" @click="onduiy(1)">
									<div class="top">待付款</div>
									<div>{{statistics['pending_pay'] || 0}}</div>
								</div>
								<div class="span" @click="onduiy(2)">
									<div class="top">待接单</div>
									<div>{{statistics['pending_order'] || 0}}</div>
								</div>
								<div class="span" @click="onduiy(3)">
									<div class="top">待服务</div>
									<div>{{statistics['pending_service'] || 0}}</div>
								</div>
								<div class="span" @click="onduiy(4)">
									<div class="top">待评价</div>
									<div>{{statistics['pending_comment'] || 0}}</div>
								</div>
								<div class="span" @click="onduiy(5)">
									<div class="top">已关闭</div>
									<div>{{statistics['closed'] || 0}}</div>
								</div>
							</div>
						</div>
					</div>
					<!--选项-->
					<ul class="option">
						<li class="option_li" @click="toMyfb">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/myfb.png" /></div>
									<div>我的发布</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
							<li class="option_li" @click="goStore" v-show="staff_pass == 0">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/index/shop_h.png" /></div>
									<div>申请店铺</div>
									<!--<div>{{store_type == 3 ? '我的店铺 ': '我的服务'}}</div>-->
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li" @click="toInviting">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/friend.png" /></div>
									<div>邀请好友</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li" @click="addss">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/address.png" /></div>
									<div>地址管理</div>
								</div>
								<div class="right"></div>
							</div>
						</li>

						<li class="option_li" @click="toMyeval">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/edit.png" /></div>
									<div>我的评价</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li" @click="toService">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/service.png" /></div>
									<div>联系客服</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li" @click="toAbout">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/about.png" /></div>
									<div>关于帮家洁</div>
								</div>
								<div class="right"></div>
							</div>
						</li>
						<li class="option_li" @click="setup()">
							<div class="label">
								<div class="left">
									<div class="logo"><img src="../../assets/img/index/set_up.png" /></div>
									<div>安全设置</div>
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
					<my-store></my-store>

				</div>
			</transition>
		</div>
		<loading :onshows='onshows' v-if="statistics == ''"></loading>
	</div>
</template>
<script>
	import api from '@/api/api'
	import utils from '@/utils/utils'
//	import myStore from '@/pages/store/myStore'
	import myStore from '@/pages/store/store'
	import loading from '@/components/Loading'
	export default {
		components: {
			myStore,
			loading
		},
		data() {
			return {
					onshows:true,// c转转
					showStore:false,
				show: true,
				show_money: true,
				show_ewm_plus: false,
				user: {},
				statistics: {},
				store_id:'',//店铺id
				imgs: require('../../../src/assets/img/logo_h.png'),
				store_type: '',
				uploadFileUrl:api.uploadFileUrl+'/',
				store_status:0,
				staff_pass:0,
			}
		},

		mounted() { //生命周期
			if(this.$store.state.store_show == false ){
				this.show = this.$store.state.store_show
			}
			else{

			}
			this.store_type = this.$store.state.store_type,
			this.init()
		},

		methods: { //方法
			onstore_show(){
				let that = this
				that.show = false
				if(that.show ==  false){
					that.$store.commit('store_show', true)
				}else{
//					that.show = true
				}
			},
			onstore_true(){
				let that = this
				that.show = true
				that.$store.commit('store_show', true)
			},
//			init() {
//				var that = this;
//				that.$fetch('user_info_get', {}, '', 'GET').then(rs => {
//					that.user = rs;
//					that.$store.commit('userPhone', rs.user_phone);
//
//				})
//			},
	init() {
        this.$fetch('user_info_get', {}, '', 'GET',1).then(rs =>{
            this.user = rs;
            this.$store.commit('userPhone', rs.user_phone);
            this.$fetch('user_order_statistics', {}).then(rs =>{
                this.statistics = rs
                this.onshows = true
                this.$fetch('user_store_info_get', {}, '', 'POST',1).then(rs =>{
					if(rs['staff_row'].staff_pass == 0){
						this.showStore = true
					}
                    this.store_id = rs.staff_row.store_id;
                    this.store_status = rs.staff_row.staff_status;
                    this.staff_pass = rs.staff_row.staff_pass
            }).catch(e =>{
            	this.showStore = true
            })
          })
        })
      },
			toBalance() {
				this.$router.push({
					path: '/balance',
					query: {
						value: this.user.user_balance
					}
				})
			},
			toCredit() {
				this.$router.push({
					path: '/credit',
					query: {
						value: this.user.user_score
					}
				})
			},
			gomyfb() {
				this.$router.push({
					path: '/myfb'
				})
			},
			orders() {
				this.$router.push({
					path: '/orders'
				})
			},
			toAbout() {
				this.$router.push({
					path: '/about'
				})
			},
			showCode() {
				this.show = true
			},
			addss() {
				this.$router.push({
					path: '/receadd'
				})
			},
			pers() {
				this.$router.push({
					path: '/pers'
				})
			},
			toMyeval() {
				this.$router.push({
					path: '/myeval'
				})
			},
			toMyfb(){
				this.$router.push({
					path: '/myfb',
						query: {
							order_type: 2
						}
				})
			},
			toService() {
				this.$router.push({
					path: '/service'
				})
			},
			setup() {
				this.$router.push({
					path: '/setup'
				})
			},
			pers() {
				this.$router.push({
					path: '/pers'
				})
			},
			myColl() {
				this.$router.push({
					path: 'myColl'
				})
			},
			toInviting() {
				if(utils.is_weixin()) {
					window.location.href = `http://www.7dugo.com/fuck.search.jiajie?user_id=${this.user.user_id}`
				} else {
					this.$router.push({
						path: '/inviting',
						query: {
							user_id: this.user.user_id
						}
					})
				}
			},
			onduiy(index) {
				let that = this
				that.$router.push({
					path: '/orders',
					query: {
						index
					}
				})

			},
			goStore() { //店铺
				var that = this;
				var qs = require('qs');
				//获取用户店铺状态
				that.$fetch('user_store_status', {}).then(rs => {
					var re = rs;
					that.$store.commit('store_status', re.status); //保存店铺状态
					//店铺状态 0 审核中 1 正常 2 关闭 -1 不通过审核 4没有店铺
					if(re.status == 0) {
						that.$dialog.alert({
							title: '提示',
							message: '店铺正在审核中,请耐心等待',
							confirmButtonText: "查看审核资料",
							showCancelButton: true
						}).then(() => {
							that.$router.push({
								path: '/storeApply',

							})
						}).catch(() => {

						});
					} else if(re.status == 1) {
						this.init();
					} else if(re.status == -1) {
						that.$dialog.alert({
							title: '提示',
							message: rs.reason,
							confirmButtonText: "重新申请",
						}).then(() => {
							that.$router.push({
								path: '/storeApply'
							})
						})
					} else if(re.status == 2) {
						that.$dialog.alert({
							title: '提示',
							message: '因违反相关规定暂时关闭',
							confirmButtonText: "确认",
						}).then(() => {

						})
					} else if(rs.status == 4) {
							that.$router.push({
								path: '/storeApply'
							})
//						that.$dialog.alert({
//							title: '提示',
//							closeOnClickOverlay: true,
//							message: '如果已有所属店铺则选择加盟店铺如没有则选择新开店铺',
//							confirmButtonText: "新开店铺",
////							cancelButtonText: "登录店铺",
//							showCancelButton: true
//						}).then(() => {
//							that.$router.push({
//								path: '/storeApply'
//							})
//						}).catch(() => {
////							that.$router.push({
////								path: '/storeApply',
////								query: {
////									storeSta: 1,
////								}
////							})
//						});
					}
				})
				//
			},
			  toLogin() {
		        this.$router.push({
		          path: '/login'
		        })
		      },

		},

	}
</script>
<style type="text/css">
	.member [class*=van-hairline]::after{
		border-bottom: 0 ;
	}
</style>
<style scoped>
	h4,
	p {
		padding: 0 0;
		margin: 0 0;
	}

	.member {
		/*position: relative;*/
	}

	.box {
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
		height: 2.42rem;
		width: 100%;
		/*background: #04A220;*/
		background: url(../../assets/img/img_vx/bar_con.png) no-repeat;
		background-size: 100% 100%;
		/*border-radius: 0 0 .5rem .5rem;*/
	}

	.bar_d_2 {
		height: 2rem;
		width: 100%;
		/*background: #04A220;*/
		background: url(../../assets/img/img_vx/bar_d.png) no-repeat;
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
		border-radius: .05rem;left: 50%;
    	margin-left: -1.75rem;
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
		left: 50%;
    	margin-left: -1.75rem;
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
