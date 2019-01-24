<template>
	<div class="four" ref="four">
		<div class="four_box">
			<div class="four_title">
				服务标准
			</div>

			<div class="four_con">
				<ul class="four_ul">
					<li class="four_li" v-for="(item,index) in serviceData.detail.service_standards">
						<div>
							<img :src="uploadFileUrl + item.standards_cover" />
						</div>
						<h4>
							{{item.standards_desc}}
						</h4>
						<div>
							<!--{{item.com}}-->
						</div>
					</li>
					<!--为了最后一行能左对齐-->
					<li class="four_li" style="height: 0px;visibility: hidden;"></li>
					<li class="four_li" style="height: 0px;visibility: hidden;"></li>
					<li class="four_li" style="height: 0px;visibility: hidden;"></li>
					<!--为了最后一行能左对齐-->
				</ul>
			</div>

			<div class="four_shop">
				<div class="shop_title">
					<div  class="shop_title_img">
						<img v-if="serviceData.store_info.store_pic" :src="uploadFileUrl + serviceData.store_info.store_pic"/>
						<img v-else :src="defaultStorePic"/>
					</div>
					<div  class="shop_title_text">
						<div class="h4_tit">
							<h4>{{serviceData.store_info.store_name}}</h4>
							<div @click="onshop_show()">
								<span v-if="!shop_show">收藏店铺</span>
								<span v-else>已收藏店铺</span>
							</div>
							
						</div>
						<div class="shop_title_auth">
							<div>
								<img src="../../assets/img/img_vx/shop_h_shou.png"/>
							</div>
							<div>
								企业认证
							</div>
						</div>
						<div class="shop_title_add">{{serviceData.store_info.city_name}}</div>
					</div>
				</div>
				<div class="shop_box">
					<ul class="shop_ul">
						<li class="shop_li">
							<div>{{serviceData.store_info.store_service_count}}</div>
							<div>全部服务</div>
						</li>
						<li class="shop_li">
							<div>{{serviceData.store_info.store_sold}}</div>
							<div>服务次数</div>
						</li>
						<li class="shop_li">
							<div>{{serviceData.store_info.favorable_rate}}%</div>
							<div>好评率</div>
						</li>
					</ul>
					<ul class="shop_ul">
						<!--<li class="shop_li">
							<span>在线联系</span>
						</li>-->
						<li class="shop_li" @click="call">
							<span>电话联系</span>
						</li>
						<!--<li class="shop_li">
							<span>进店看看</span>
						</li>-->
					</ul>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	export default {
		props:{
			serviceData:{
				type:Object,
				default:()=>{}
			}
		},
		data() {
			return {
				uploadFileUrl:api.uploadFileUrl +'/',
				defaultStorePic:require('@/assets/img/logo_h.png'),
				shop_show:false,
				click_false:true,
				list_three: [{
						img: require('../../assets/img/img_vx/bar_con.png'),
						title: '厨房',
						com:'厨房厨房'
						
					},
					{
						img: require('../../assets/img/img_vx/bar_con.png'),
						title: '厨房',
						com:'厨房厨房厨房厨房'
					},
					{
						img: require('../../assets/img/img_vx/bar_con.png'),
						title: '厨房',
						com:'厨房厨房厨房厨房厨房厨房厨房厨房厨房厨房厨房厨房'
					},
				]
			}
		},
		mounted() { //生命周期 
			this.onFour();
			this.shop_show = this.serviceData.store_collected;
			
		},
		methods: { //方法
			onshop_show(){
				if(this.click_false){
					this.click_false = false
					this.$fetch('user_collect',{collect_type:'STORE'},this.serviceData.row.store_id).then(rs=>{
						this.shop_show = !this.shop_show;
						this.$toast(this.shop_show ? '收藏成功' : '已取消收藏');
						setTimeout(()=>{
				        	this.click_false = true
				        },1000)
			        }).catch(e=>{
			        	this.click_false = true
			        })
				}
				
			},
			onFour() {
				let fourHeight = this.$refs.four.offsetHeight;
				this.$store.commit('fourH', fourHeight)
			},
			call() {
				window.location.href = "tel:" + this.serviceData.store_info.store_phone;
			},
		},

	}
</script>

<style scoped>
	.four{	background: #fff;}
	.four_box {
		margin-top: .15rem;
		padding: 0 .1rem;
		background: #fff;
	}
	.four_con  {
		margin-bottom: .15rem;
		padding:.1rem .1rem;
		box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
	}
	.four_shop{
		margin-bottom: .15rem;
		padding:.1rem .1rem;
		box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
			background: #fff;
	}
	.four_title {
		height: .4rem;
		line-height: .4rem;
		text-align: center;
		font-size: .16rem;
		font-weight: 700;
	}
	.shop_title{
		display: flex;
		
	}
	.shop_title_img{
		flex: 0 0 0.65rem;
	}
	.shop_title_img img{
		width: .7rem;
		height: .7rem;
	}
	.shop_title_text{
		flex: 0 0 77%;
		margin-left: 0.1rem;
	}
	.shop_title_auth{
		margin: 0.08rem 0 0 0;
		display: flex;
		align-items: center;
	}
	.shop_title_auth img{
		width: .18rem;
		margin:0 0.08rem;
	}
	.shop_title_add{
		margin:0 0.08rem;
	}
	.h4_tit{
		display: flex;
		justify-content: space-between;
		align-items: center;
	}
	.h4_tit h4{
		margin: 0 0;
		padding: 0 0;
		font-weight: 700;
		font-size: .16rem;
	}
	.h4_tit>div{
		color: #f10;
	}
	.shop_ul {
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
		margin: 0.1rem 0 .15rem 0;
	}
	.shop_li {
		width: 1.1rem;
		margin: 0 0 .1rem 0;
		text-align: center;
		font-size: .16rem;
		font-weight: 600;
	}
	.shop_li>div:nth-child(2){
		margin: 0.08rem  0 0.08rem 0 ;
	}
	.shop_li span{
		border: .01rem solid #f90;
		font-size: .14rem !important;
		font-weight: 500;
		border-radius: .5rem;
		padding: 0.08rem .1rem;
		color: #f90;
	}
	.four_ul {
		/*padding: .1rem;*/
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
		/*padding: 0 0.12rem;*/
	}
	
	.four_li {
		width: 33%;
		margin: 0 0 .1rem 0;
		text-align: center;
	}
	.four_li h4{
		margin: 0.05rem 0;
		padding: 0;
		font-size: .16rem;
		
	}
	.four_li>div:nth-child(2) {
		text-align: center;
		margin-top: .05rem;
	}
	
	.four_li>div:nth-child(1) {
		width: 100%;
		height: 1.05rem;
		border-radius: 50%
	}
	
	.four_li>div:nth-child(1) img {
		width: 1.05rem;
		height: 1.05rem;
		border-radius: 50%
	}
</style>