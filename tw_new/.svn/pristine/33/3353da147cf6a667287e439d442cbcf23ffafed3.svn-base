<template>
	<div class="shop">
		<div class="left_rigth">
			<div class="left_le">

			</div>
			<div class="left_ri">
				<img src="../../assets/img/img_vx/shop_ri.png" />
			</div>
		</div>

		<div class="shop_top">
			<div class="shop_top_img">
				<img src="../../assets/img/find_server/server_4.png" />
			</div>
			<div class="text title">宏鑫家政服务公司</div>
			<div class="text text_sapn">广州&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;服务次数100&nbsp;|&nbsp;&nbsp;&nbsp;好评率100%</div>
			<div class="text text_p"> <img src="../../assets/img/img_vx/shop_h_shou.png" />企业认证</div>
			<div class="shop_top_po po_top">收藏</div>
			<div class="shop_top_po po_bot"> <img src="../../assets/img/img_vx/shop_xx.png" />咨询</div>
		</div>
		<!--tab-->
		<ul class="tab_ul">
			<li class="tab_li"  v-for="(item,index) in list_tab"  @click="onTab(item.id,index)">
				<span :class="{tabli_h : index == num}" >{{item.name}}</span>
			</li>
		
		</ul>
			<shopsx :is='currentTab' keep-alive></shopsx>
	
	</div>
</template>

<script>
	import shopsx from '@/pages/Subcomponent/subShop';
	import evalsx from '@/pages/Subcomponent/subShop_eval';
	import busines from '@/pages/Subcomponent/subShop_busines';
	export default {
		components: {
			shopsx,
			evalsx,
			busines
		},
		data() {
			return {
				num:0,
				list_tab:[
				{
					name:'服务',
					id:'shopsx'
				},
				{
					name:'评价',
					id:'evalsx'
				}
				,{
					name:'商家',
					id:'busines'	
				}],
				currentTab:'shopsx',
				
				
			}
		},
		mounted() { //生命周期 

		},
		methods: { //方法
		onTab(item,index){
			this.currentTab = item
			this.num = index
		}
		},

	}
</script>

<style scoped>
	.tab_ul{
		display: flex;
		padding: 0.05rem 0;
		box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
	}
	.tab_li{
		width: 33.3%;
		height: .44rem;
		line-height: .44rem;
		text-align: center;
		font-size: .16rem;
		font-weight: 700;
	}
	.tabli_h{
		color: #18b4ed;
		border-bottom: .02rem solid #18b4ed;
	}
	.tab_li span{
		padding: 0 0 0.1rem 0;
		
		
	}
	.shop {
		width: 3.75rem;
		height: 100%;
		/*overflow: hidden;*/
	}
	
	.left_rigth {
		position: relative;
		width: 100%;
		height: .9rem;
		background: url(../../assets/img/img_vx/shop_top.png) no-repeat;
		background-size: 100% 100%;
	}
	
	.left_le {
		width: .35rem;
		height: .35rem;
		position: absolute;
		top: .1rem;
		left: 0.05rem;
		background: url(../../assets/img/img_vx/shop_le.png) no-repeat;
		background-size: .1rem .175rem;
		background-position: 50%;
	}
	
	.left_ri {
		width: .35rem;
		height: .35rem;
		border-radius: 50%;
		background: rgba(0, 0, 0, .2);
		position: absolute;
		top: .1rem;
		right: 0.12rem;
	}
	
	.left_ri img {
		padding: .07rem;
		width: .2rem;
		height: .2rem;
	}
	
	.shop_top {
		position: relative;
		height: 1.35rem;
		width: 100%;
		box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
	}
	
	.shop_top_img {
		position: absolute;
		top: -0.7rem;
		left: 50%;
		width: 1.07rem;
		height: 1.07rem;
		margin-left: -0.525rem;
		background: #fff;
		border-radius: 50%;
	}
	
	.shop_top_img img {
		margin: .03rem;
		width: 1.01rem;
		height: 1.01rem;
		border-radius: 50%;
	}
	.title {
		font-size: .18rem;
		font-weight: 700;
		padding-top: .4rem;
	}
	.text {
		text-align: center;
	}
	
	
	.text_sapn {
		font-size: .12rem;
		margin: .1rem 0 0.08rem 0;
	}
	
	.text_p {
		font-size: .14rem;
	}
	
	.text_p img {
		position: absolute;
		width: .16rem;
		left: 1.35rem;
		margin: 0 0.3rem 0 0;
	}
	
	.shop_top_po {
		position: absolute;
		right: 0;
		text-align: center;
		border-radius: .5rem 0 0 .5rem;
		padding: .05rem 0;
	}
	
	.po_top {
		top: .4rem;
		width: .65rem;
		border: .01rem solid #eee;
	}
	
	.po_bot {
		top: .8rem;
		width: .65rem;
		background: #1dd1f1;
		color: #fff;
	}
	
	.po_bot img {
		width: .15rem;
		margin-right: .05rem;
		vertical-align:middle;
	}
	.box{
		position: absolute;
		top: 0.44rem;
		left: 0;
		right: 0;
		/*bottom: 0;*/
		height: calc(100% - 3rem);
		overflow: auto;
		z-index: 9999;
				
	}
</style>