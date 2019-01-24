<template>
	<div class="find">
		<div>
			<van-nav-bar title="我的订单" left-arrow @click-left="onClickLeft" right-text="订单说明" @click-right="pointRule" />
		</div>
		<ul class="top_nav_ul">
			<li v-for="(item,index) in tabs" :class="{li_style:index == num}" @click="tab(index)">
				<div class="top_nav_img" @click="dad(item,(index == 0 || index == 2))">
					{{item.name}}
				</div>
			</li>
		</ul>
		<div class="top_nav">
			<!--<ul class="top_nav_ul">
        <li v-for="(item,index) in tabs" :class="{li_style:index == num}" @click="tab(index)">
          <div class="top_nav_img" @click="dad(item,(index == 0 || index == 2))">
            {{item.name}}
          </div>
        </li>
      </ul>-->

			<div class="commodity">
				<scroller :on-infinite="infinite" ref="list_com_order">
					<ul>
            <li v-if="list_com == ''" style="opacity: 0">
              暂无数据
            </li>
						<li v-else v-for="(its,index) in list_com" class="list_coms" @click="detailst(its,index)">
							<div class="com_com">
								<div style="position: relative;">
									<div v-if="its.order_detail.is_sys_order" class="sys" style="font-size:.12rem;position: absolute;top: 0;right: 0;background: #f00;color: #fff;">周期</div>
									<img src="../../assets/img/logo_h.png" v-if="its.order_detail.order_img == ''" />
									<img :src="uploadFileUrl + its.order_detail.order_img[0]" v-else/>
								</div>
								<div class="com_com_x">
									<!--<div class="com_com_ri" v-if="its.order_detail.order_type == 1">
									企业
								</div>-->
									<div class="com_com_x_tit">
										<div class="left">{{its.order_detail.order_name}}</div>
										<order-state :order_info="its" :is_store_page="false"></order-state>
									</div>
									<div class="com_com_x_ov" v-clampy="3" v-html="replaceStyle(its.order_detail.order_info)"></div>
									<div class="com_com_x_score2">
										<div>￥{{its.payment.order_amount}}</div>
									</div>
								</div>

							</div>
							<!--下单时间-->
							<div class="item_sj">
								<div>
									<div>下单时间 :</div>
									<div>{{its.time_record.add_time}}</div>
								</div>
								<div>
									<div>服务时间 :</div>
									<div>{{its.time_record.contact_appointment_at}}</div>
								</div>
								<div>
									<div style="width:1rem;">联系地址 :</div>
									<div>{{its.server_info.address_name}}{{its.server_info.house_number}}</div>
								</div>
								<div v-if="its.time_record.next_order_at">
									<div>下期服务时间 :</div>
									<div>{{its.time_record.next_order_at}}</div>
								</div>
							</div>

							<!--anniu-->
							<div class="but_coms" style="display: flex; justify-content:flex-end; align-items:center">
								<div v-if="its.order_detail['order_bis_state_dsc'].indexOf(['SET_UP', 'PENDING_ORDER', 'PENDING_ASSIGN', 'PENDING_DOOR']) && its.order_detail['order_bis_state_dsc'] != 'COMPLETED' && its.order_detail['order_bis_state_dsc'] != 'CLOSED'" class="but_coms_but1"
									 @click.stop="shows(its,index)">取消订单
								</div>
								<template v-if="its.order_detail['order_type'] != 4">
									<div v-if="its.order_detail['order_pay_state_dsc'] == 'PENDING_PAY'"
										 class="but_coms_but3"
										 @click.stop="ofgshow(its, index)">去支付
									</div>
								</template>
								<!--<div v-if="its.order_detail.order_is_peddling == 0 && its.order_detail.order_state == 0 && its.order_detail.order_rate == 0" class="but_coms_but3" @click.stop="call(its.server_info.telephone)">联系商家
							</div>-->
								<template v-if="its.order_detail['order_pay_state_dsc'] == 'PAY_SUCCESS'">
									<div v-if="its.order_detail['order_bis_state_dsc'] == 'PENDING_ASSIGN' || its.order_detail['order_bis_state_dsc'] ==  'PENDING_DOOR'"
										 class="but_coms_but4"
										 @click.stop="call(its.store_info.store_phone)">联系商家</div>
								</template>

								<!--<div v-else-if="its.order_is_peddling == 0 && its.order_state == 0" class="but_coms_but3" @click.stop="ofgshow(its, index)">去付款</div>-->
								<!--<div v-if="its.order_state == 1" class="but_coms_but3" @click.stop="ofgshow(its, index)"></div>-->

								<template v-if="its.order_detail['order_bis_state_dsc'] == 'PENDING_EVALUATE'">
									<div class="but_coms_but2" @click.stop="menvaluate(its,index)">评价</div>
									<!--<div class="but_coms_but4" @click.stop="eval">评价说明</div>-->
								</template>
								<div v-else-if="its.order_detail['order_pay_state_dsc'] == 'PAYING' || its.order_detail['order_bis_state_dsc'] == 'COMPLETED' || its.order_detail['order_bis_state_dsc'] == 'CLOSED'" class="but_coms_but1" @click.stop="shows(its,index)">
									删除订单
								</div>
							</div>
						</li>
					</ul>
				</scroller>
				<!--弹出窗-->
				<div class="po_box" v-show="isshow" @click.stop="xbut">
					<div class="po_box_div">
						<div class="po_box_div_tit">提示</div>
						<div class="po_box_div_com" v-if="oits_list.order_state == 0 || oits_list.order_state == 1 ||  oits_list.order_state == 5 || oits_list.order_state == 4">
							确定要删除此订单？
						</div>
						<div class="po_box_div_com" v-else-if="oits_list.order_state == 0 || oits_list.order_state == 1 || oits_list.order_state == 2">
							确定要取消此订单？
						</div>
						<div class="po_box_but">
							<div @click.stop="xbut">取消</div>
							<div @click.stop="spilits">确认</div>
						</div>
					</div>
				</div>
				<!--弹出窗-->
			</div>
		</div>

		<van-popup class='ruleBox' v-model="rule" position="right">
			<van-nav-bar class="" title="订单说明" left-arrow @click-left="closeLay"></van-nav-bar>
			<p>1.您发布的需求，在您指定的预约时间，如果仍然没有人接单（通常是因为价格过低），帮家洁平台将会自动将您的需求取消，如果您想使需求继续生效，可以通过修改，调整预约时间来使需求重新生效。</p>
			<p>2.您购买的产品，从产品的购买时间算起，逾期15天，如果您在15天内，没有操作确认收货的话，平台将自动确认为您已收货，并更新订单状态为已完成，请您务必及时关注您的订单。</p>
			<p>3.您购买的服务，从服务的开始时间算起，逾期3天，如果您在3天内，没有操作确认服务完成的话，平台将自动确认更新订单状态为服务完成，并请您务必及时关注您的订单。</p>
		</van-popup>
		<orderConfirmation v-model="payShow" :orderData="orderData" :orderType="4"></orderConfirmation>

	</div>
</template>

<script>
	import api from '@/api/api'
	import orderState from '@/components/orderState'
	import utils from '@/utils/utils'
	import orderConfirmation from '@/components/order_confirmation'
	export default {
		components: {
			orderState,
			orderConfirmation
		},
		data() {
			return {
				end: false,
				firstFinish: false,
				page: 1,
				price_type:'',
				wechat: false,
				onshows: true,
				uploadFileUrl: api.uploadFileUrl + '/',
				isshow: false,
				fgshow: false,
				rule: false,
				indexs: '',
				paylist: [{
						name: '支付宝',
						type: 'alipay',

					},
					{
						name: '微信',
						type: 'wechat',
					},
					{
						name: '银行',
						type: 'bankcard',
					}
				],
				tabs: [{
						name: '全部',
						id: 1
					},
					{
						name: '待付款',
						id: 2
					},
					{
						name: '待接单',
						id: 3
					},
					{
						name: '待服务',
						id: 4
					},
					{
						name: '待评价',
						id: 5
					},
				],
				num: 0, //tab
				numlist: 0, //综合
				numlist2: 0, //建议方式
				inishow: false,
				ids: '', //
				list_com: [],
				//				fglist:[
				//					{
				//						name: '支付宝',
				//						type: 'alipay',
				//						imgs: require('../../assets/img/alipay.png'),
				//					},
				//					{
				//						name: '微信',
				//						type: 'wechat',
				//						imgs: require('../../assets/img/wechat.png'),
				//					},
				//					{
				//						name: '银行',
				//						type: 'bankcard',
				//						imgs: require('../../assets/img/unionpay.png'),
				//					}
				//				],
				order_sign: '',
				order_sn: '',
				token: '',
				listits: {},
				oits_list: {},
				payShow:false,
				orderData:{},
			}
		},
		mounted() { //生命周期

//			for( let i = 0 ;i < this.paylist.length ;i++){
////
//							alert(this.paylist[i].type = this.listits.order_pay_way)
//			}

			if(this.$route.query.index) {
				this.num = this.$route.query.index
				this.tab(this.num);
			} else {
				this.listget()
			}
			this.token = this.$store.state.token
		},
		methods: { //方法
			//			打电话
			call(info) {
				if(info) {
					window.location.href = "tel:" + info
				} else {
					this.$toast('拨号失败！')
				}
			},
			replaceStyle(str) {
				const reg = /<[^<>]+>/g
				return str.replace(/&lt;/g, "<").replace(/&gt;/g, ">").replace(reg, '');
			},
			listget() {
				let that = this
				that.page = 1
				let forms = {}
				forms.page = that.page
				forms.condition = {
					"order_type <>": 3
				}
				that.$fetch('ouser_get_order', forms).then(rs => {
					that.page++ //请求页数自加
						that.list_com = rs; //覆盖本地数据
					if(rs.length != 10) { //如果数据长度小于10证明下次请求没有数据
						that.$refs.list_com_order.finishInfinite(true); //执行组件完成上拉方法(true代表没有数据)
						that.end = true
					} else {

						that.$refs.list_com_order.finishInfinite(false); //执行组件完成上拉方法(true代表没有数据)
					}
					that.firstFinish = true //标记已完成第一次上拉
				})
			},
			pointRule() {
				this.rule = true;
			},
			closeLay() {
				this.rule = false;
			},
			dad(item, index) {
				let that = this
				//				console.log(item)
				that.ids = item.id
				if(item.id == 1) {
					if(that.inishow == true) {
						that.inishow = false
					} else {
						that.inishow = !that.inishow
					}
				} else if(item.id == 3) {
					if(that.inishow == true) {
						that.inishow = false
					} else {
						that.inishow = !that.inishow
					}
				} else {
					that.inishow = false
				}
			},

			onClickLeft() {
				// this.$router.back(-1)
				this.$router.push({
					path: '/member'
				})
			},
			//详情
			detailst(its, index) {
				let that = this
				//还差个id
				that.$router.push({
					path: '/orderDetails',
					query: {
						//						its:JSON.stringify(its),
						order_snx: its.order_detail.order_sn
					}
				})
			},
			//tab
			//tab
			tab(index) {
				let that = this
				let lists = {}
				lists.rows = 9900;

				that.num = index;
				if(index == 1) {
					lists.condition = {
						"order_state": 0
					}
					that.$fetch('ouser_get_order', lists).then(rs => {
						that.list_com = rs
					})
				} else if(index == 2) {
					lists.condition = {
						"order_state": 1
					}
					that.$fetch('ouser_get_order', lists).then(rs => {
						that.list_com = rs
					})
				} else if(index == 3) {
					lists.condition = {
						"order_state": 2
					}
					that.$fetch('ouser_get_order', lists).then(rs => {
						that.list_com = rs
					})
				} else if(index == 4) {
					lists.condition = {
						"order_rate": 1,
						"order_comment_id": 0,
						"order_state": 3
					}
					that.$fetch('ouser_get_order', lists).then(rs => {
						that.list_com = rs
					})
				} else {
					lists.condition = {
						"order_type <>": 3
					}
					that.$fetch('ouser_get_order', lists).then(rs => {
						that.list_com = rs
					})
				}
			},

			menvaluate(its, index) {
				let that = this
				that.$router.push({
					path: '/menvaluate',
					query: {
						//						its:JSON.stringify(its)
						order_snx: its.order_detail.order_sn
					}
				})
			},

			//			支付
			ofgshow(its, index) {
				this.orderData.order_sn = its.order_detail.order_sn;
				this.orderData.total = Number(its.payment.order_amount);
				this.orderData.order_pay_way = its.payment.order_pay_way;
				this.orderData.order_deductible_type = its.payment.order_deductible_type;
				this.payShow = true;
			},
			//打开
			shows(its, index) {
				let that = this
				that.isshow = true
				that.indexs = index
				that.oits_list.order_state = its.order_detail.order_state
				that.oits_list.order_sn = its.order_detail.order_sn
			},
			// 刪除 or 取消
			spilits() {
				let that = this
				let url = ''
				var qs = require('qs');
				if(that.oits_list.order_state == 0 || that.oits_list.order_state == 1 || that.oits_list.order_state == 2) {
					// 取消走这里
					that.$fetch('user_cancel_order', {}, that.oits_list.order_sn).then(rs => {
						that.isshow = false
						that.tab(that.num)
						that.$toast('取消成功');
					}).catch(e=>{
						console.log(e);
						that.isshow = false
					})
				} else {
					that.$fetch('order_delete', {}, that.oits_list.order_sn).then(rs => {
						that.isshow = false
						that.tab(that.num)
						that.$toast('删除成功');
					}).catch(e=>{
						console.log(e);
						that.isshow = false
					})
				}
			},
			//			关闭
			xbut() {
				let that = this
				that.isshow = false
			},
			//			付款
			fgbut() {
				let that = this
				that.fgshow = false

			},
			fgxuz(fgitem, index) {
				let that = this
				that.num = index

			},
			qdfk() {
				let that = this
				if(that.onshows) {
					let order_sign = that.order_sign
					let order_sn = that.order_sn
					let price_type = that.price_type
					utils.pay(order_sn, order_sign,'orderDetails', 'orderDetails',price_type);
					that.onshows = false
					//					window.location.href = `http://jiajie-server.7dugo.com/order.pay?order_sign=${order_sign}&order_sn=${order_sn}`
				}
			},
			eval() {
				this.$dialog.alert({
					title: "评价说明",
					message: '订单如果逾期没有评价的话（默认从订单的服务开始时间算起，逾期时间为3天），平台将自动给予好评，逾期时间请参考订单的规则。',
				});
			},
			infinite(done) { //上拉方法
				var that = this;
				if(that.firstFinish) { //如果初始化完成才能继续上拉
					if(that.end) { //如果end == true代表已无数据
						setTimeout(() => {
							done(true) //true返回已无数据
						}, 1500)
						return
					} else {
						that.page = 1
						var lists = {
							page: that.page
						}
						that.$fetch('ouser_get_order', lists).then(rs => {
							setTimeout(() => {
								that.page++ //请求页数自加
									that.list_com = that.list_com.concat(rs); //合并至本地数据

								if(rs.length != 10) { //如果数据长度小于10证明下次请求没有数据
									setTimeout(() => {
										done(true) //true返回已无数据
									})
									that.end = true
								} else {
									setTimeout(() => {
										done()
									})
								}
							}, 1500)
						}).catch(e => {
							setTimeout(() => {
								done(true)
							})
						})
					}

				}
			},
		},
	}
</script>

<style scoped>
	.find {
		width: 100%;
		height: 100%;
		background: #f5f5f5;
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
	}

	.top_nav {
		position: relative;
		height: calc(100% - 1.05rem);
		overflow: auto;
	}

	.po_div {
		position: fixed;
		top: 1.02rem;
		left: 0;
		right: 0;
		bottom: 0;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, .2);
		z-index: 9999;
	}

	.top_nav_ul {
		display: flex;
		background: #fff;
		border-bottom: .02rem solid #eee;
	}
	/*下单时间*/

	.item_sj {
		padding: 0 0.2rem;
	}

	.item_sj>div {
		display: flex;
		justify-content: space-between;
		padding: 0.02rem 0;
		font-size: .12rem;
		color: #b2b2b2;
	}

	.top_nav_ul>li {
		text-align: center;
		height: .54rem;
		line-height: .54rem;
		flex: 0 0 20%;
		position: relative;
	}

	.li_style {
		color: #18B4ED;
	}

	.li_style:before {
		content: '';
		position: absolute;
		left: 50%;
		bottom: 0;
		background: #18b4ed;
		width: 0.12rem;
		margin-left: -0.06rem;
		margin-bottom: -0.02rem;
		height: 0.02rem;
	}

	.van-nav-bar {
		background: #18b4ed;
	}

	.top_nav_img {
		display: flex;
		align-items: center;
		justify-content: center;
	}
	/*.top_nav_img img{
        width: .1rem;
    }*/

	.spanimg {
		margin: .02rem 0 0 .05rem;
		width: .1rem;
		height: .1rem;
		background: url(../../../static/images/bot_s.png) no-repeat;
		background-size: .1rem;
	}

	.spanimg_s {
		margin: .02rem 0 0 .05rem;
		width: .1rem;
		height: .1rem;
		background: url(../../../static/images/bot_h.png) no-repeat;
		background-size: .1rem;
	}

	.spanimg_h {
		margin: .02rem 0 0 .05rem;
		width: .1rem;
		height: .1rem;
		background: url(../../../static/images/top_s.png) no-repeat;
		background-size: .1rem;
	}

	.po_div_li {
		height: .44rem;
		line-height: .44rem;
		padding: 0 .2rem;
		background: #fff;
		border-bottom: 0.01rem solid #eee;
	}

	.po_div_li span {
		display: block;
		height: .44rem;
		line-height: .44rem;
	}

	.po_div_li2 {
		background: #fff;
		display: flex;
		padding: .25rem 2.5%;
	}

	.po_div_li2_div {
		border: 0.01rem solid #eee;
		border-radius: .05rem;
		flex: 0 0 30%;
		padding: 2% 0;
		text-align: center;
	}

	.po_div_li2_div_h {
		display: block;
		border: 0.01rem solid #18B4ED;
		color: #18B4ED;
		border-radius: .05rem;
		padding: .08rem 0;
		text-align: center;
	}

	.po_div_li2 div:nth-child(2) {
		margin: 0 2.5%;
	}
	/*列表*/

	.commodity {
		background: #f5f5f5;
	}

	.commodity ul {
		background: #f5f5f5;
	}

	.list_coms {
		margin-top: .1rem;
		background: #fff;
	}

	.com_li {
		margin-bottom: 0.1rem;
		background: #fff;
		padding: 0 0 0.2rem 0;
	}

	.com_tit {
		font-size: .12rem;
		color: #b2b2b2;
	}

	.com_tit_img {
		display: flex;
		font-size: .14rem;
		font-weight: 600;
		align-items: flex-start;
	}

	.com_tit_img>div img {
		width: .15rem;
		height: .15rem;
		margin-top: .11rem;
		margin-right: .05rem;
	}

	.com_com {
		display: flex;
	}

	.com_com>div:nth-child(1) {
		flex: 0 0 .9rem;
		margin: .08rem;
		border-radius: .1rem;
		overflow: hidden;
	}

	.com_com>div:nth-child(1) img {
		width: .9rem;
		height: .9rem;
	}

	.com_com_x {
		position: relative;
		flex: 1;
		margin-top: .1rem;
		margin-right: .15rem;
	}

	.com_com_ri {
		position: absolute;
		top: -.06rem;
		right: 0.1rem;
		border: 0.01rem solid #ff9c0f;
		color: #ff9c0f;
		font-size: .12rem;
		border-radius: .05rem;
		padding: .01rem .03rem;
	}

	.com_com_x_tit {
		font-size: .16rem;
		display: flex;
		/*justify-content: space-between;*/
		align-items: center;
	}

	.com_com_x_tit>div:nth-child(1) {
		flex: 0 0 2rem;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}

	.com_com_x_ov {
		width: 2.55rem;
		font-size: .14rem;
		color: #707070;
		margin: 0.05rem 0;
	}

	.com_com_x_score {
		display: flex;
		font-size: .12rem;
		margin-bottom: .05rem;
	}

	.com_com_x_score_colco {
		color: #f00;
	}

	.com_com_x_score2 {
		display: flex;
	}

	.com_com_x_score2>div:nth-child(1) {
		font-size: .18rem;
		color: #f00;
		margin-right: .25rem;
	}

	.com_com_x_score2>div:nth-child(2) span {
		font-size: .10rem;
		color: #fff;
		background: #f00;
		border-radius: .05rem;
		padding: 0.015rem 0.063rem;
	}

	.but_coms {
		display: flex;
		justify-content: flex-end;
		padding: 0 .15rem;
		background: #fff;
	}

	.but_coms div {
		margin: .08rem 0 .08rem .1rem;
		flex: 0 0 .72rem;
		height: .14rem;
		line-height: .14rem;
		text-align: center;
		padding: .08rem .05rem;
		background: #fff;
		border: 0.01rem solid #B2B2B2;
		border-radius: .3rem;
		font-size: .12rem;
		color: #B2B2B2;
	}

	.but_coms_but1 {
		border: 0.01rem solid #B2B2B2 !important;
		color: #B2B2B2 !important;
	}

	.but_coms_but2 {
		border: 0.01rem solid #f00 !important;
		color: #f00 !important;
	}

	.but_coms_but3 {
		border: 0.01rem solid #f00 !important;
		color: #f00 !important;
	}

	.but_coms_but4 {
		border: 0.01rem solid #18b4ed !important;
		color: #18b4ed !important;
	}

	.po_box {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		width: 100%;
		/*height: 100%;*/
		background: rgba(0, 0, 0, .3);
		z-index: 9999;
	}

	.fug_box {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		width: 100%;
		/*height: 100%;*/
		background: rgba(0, 0, 0, .3);
		z-index: 9999;
	}

	.fug_box ul li {
		display: flex;
		justify-content: space-between;
		height: .55rem;
		line-height: .55rem;
		padding: 0 .1rem;
		background: #FFF;
		border-bottom: .01rem solid #eee;
		align-items: center;
	}

	.fug_box ul li div:nth-child(1) {
		display: flex;
		align-items: center;
	}

	.fug_box ul li div:nth-child(1) img {
		width: .24rem;
		height: .24rem;
		margin-right: .1rem;
	}

	.fg_imgsb {
		flex: 0 0 .2rem;
		height: .2rem;
		background: url(../../assets/img/checked.png) no-repeat;
		background-size: .18rem;
	}

	.po_box_div {
		position: absolute;
		top: 50%;
		left: 50%;
		width: 2.75rem;
		height: 1.9rem;
		background: #fff;
		border-radius: .1rem;
		margin: -0.95rem 0 0 -1.375rem;
	}

	.po_box_div_tit {
		color: #18B4ED;
		height: .5rem;
		line-height: .5rem;
		text-align: center;
		border-bottom: .01rem solid #eee;
	}

	.po_box_div_com {
		height: .85rem;
		line-height: .85rem;
		text-align: center;
		font-size: .16rem;
		border-bottom: .01rem solid #eee;
	}

	.po_box_but {
		display: flex;
	}

	.po_box_but div {
		flex: 0 0 49%;
		text-align: center;
		height: .5rem;
		line-height: .5rem;
	}

	.po_box_but div:nth-child(2) {
		border-left: .01rem solid #eee;
		color: #18B4ED;
	}

	.fug_box_po {
		position: absolute;
		/*height: 2.2rem;*/
		overflow: hidden;
		width: 90%;
		margin: 0 5%;
		background: #fff;
		bottom: .15rem;
		border-radius: .1rem;
	}

	.slide-fade-enter-active {
		transition: all .3s ease;
	}

	.slide-fade-leave-active {
		transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
	}

	.slide-fade-enter,
	.slide-fade-leave-to
	/* .slide-fade-leave-active for below version 2.1.8 */

	{
		transform: translateY(2rem);
		opacity: 0;
	}

	.fg_fangs {
		height: .44rem;
		line-height: .44rem;
		text-align: center;
		border-bottom: .01rem solid #eee;
	}

	.ruleBox {
		width: 100%;
		height: 100%;
		text-indent: 2em;
		font-size: 0.14rem;
	}

	.ruleBox p {
		color: #999;
		padding: 0 0.1rem;
		margin: 0.1rem 0;
	}

	.left {
		display: flex;
		align-items: center;
	}

</style>
<style type="text/css">
	.find .ruleBox .van-nav-bar__left {
		left: 0;
	}

	.find .van-dialog__message {
		font-size: 0.12rem !important;
	}

	.find .van-nav-bar__text {
		color: white;
		font-size: 0.12rem !important;
	}
</style>
