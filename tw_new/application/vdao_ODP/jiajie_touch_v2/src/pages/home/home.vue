<template>
	<div class="homes">
		<!--十秒预约-->
		<div class="heder">
			<div class="heder_div" @click="toFastReservation">
				<div class="heder_div_img">
					<img src="../../assets/img/home/home_t1.png" />
				</div>
				<div class="heder_div_text">
					10秒快速预约
				</div>
			</div>
			<div class="heder_div">
				<div class="heder_div_img">
					<img src="../../assets/img/home/home_t2.png" />
				</div>
				<div class="heder_div_text">
					发布需求
				</div>
			</div>
		</div>
		<!--轮播-->
		<div class="broadcast">
			<img src="../../assets/img/top.png" />
		</div>
		<!--中部-->
		<div class="box">
			<div class="centre">
				<div class="centre_div_le" @click="service_list()">
					<div class="centre_div_le_text">
						<h4>办公清洁</h4>
						<span>
								办公清洁办公清洁
							</span>
					</div>
					<div class="centre_div_le_img">
						<img src="../../assets/img/home/home_1.png" />
					</div>
				</div>
				<div class="centre_div_ri" @click="onShop()">
					<div>
						<div class="heder_div_img centre_div_ri_img">
							<img src="../../assets/img/home/home_3.png" />
						</div>
						<div class="centre_div_ri_text">
							<h4>家电清洁</h4>
							<span>拆洗无忧</span>
						</div>
					</div>
					<div>
						<div class="centre_div_ri_img2">
							<img src="../../assets/img/home/home_2.png" />
						</div>
						<div class="centre_div_ri_text">
							<h4>开荒清洁</h4>
							<span>快速入住新居</span>
						</div>
					</div>
				</div>
			</div>
				<!--9宫各-->
			<div class="centre_nai">
				<ul>
					<li class="centre_nai_li" v-for="item in list">
						<div class="centre_nai_li_img">
							<img :src="item.img"/>
						</div>
						<div class="centre_nai_li_text">
							<h4>{{item.name}}</h4>
							<span>{{item.name_can}}</span>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				list:[{
					name:'保姆月嫂',
					name_can:'口碑好阿姨',
					img:require('../../assets/img/home/home_4.png')
				},
				{
					name:'家庭理疗',
					name_can:'享受舒适手法',
					img:require('../../assets/img/home/home_6.png')
				},{
					name:'管道疏通',
					name_can:'专业疏通设备',
					img:require('../../assets/img/home/home_5.png')
				}]
			}
		},
		mounted() { //生命周期 

		},
		methods: { //方法
			toFastReservation(){
				this.$router.push({
					path:'/fastReservation'
				})
			},
			service_list(){
					this.$router.push({
					path:'/service_list'
				})
			},
			onShop(){
				this.$router.push({
					path:'/onshop'
					})
			},
		},

	}
</script>
<style scoped>
	h4 {
		margin: 0;
		padding: 0;
	}
	
	.homes {}
	
	.box {
		padding: 0 0.12rem;
	}
	
	.heder {
		padding: 0 0.12rem;
		margin: 0.15rem 0;
		display: flex;
		justify-content: space-between;
	}
	
	.heder>div {
		width: 1.7rem;
		height: 0.55rem;
		box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
		text-align: center;
		display: flex;
		align-items: center;
		border-radius: 0.05rem;
	}
	
	.heder_div_img img {
		width: 0.24rem;
		height: 0.24rem;
		margin: 0 .15rem;
	}
	
	.heder_div_text {
		font-size: .16rem;
		font-weight: 700;
	}
	
	.broadcast {
		height: 1.37rem;
		margin: 0 0 0.15rem 0;
	}
	
	.broadcast img {
		height: 1.37rem;
		width: 100%;
	}
	
	.centre {
		margin-bottom: .28rem;
		display: flex;
		justify-content: space-between;
	}
	
	.centre>div {
		width: 1.7rem;
		/*//185*/
		height: 1.95rem;
		text-align: center;
	}
	
	.centre_div_le {
		box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
	}
	
	.centre_div_le_text {
		margin-top: 0.15rem;
	}
	
	.centre_div_le_text h4 {
		font-size: 0.16rem;
		color: #18b4ed;
		margin-bottom: 0.05rem;
	}
	
	.centre_div_le_text span {
		font-size: 0.14rem;
		color: #b2b2b2;
	}
	
	.centre_div_le_img img {
		width: 1.14rem;
		height: 1.25rem;
	}
	
	.centre_div_ri>div {
		margin-bottom: .1rem;
		height: .925rem;
		box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
		display: flex;
		align-items: center;
	}
	
	.centre_div_ri .centre_div_ri_img img {
		width: .54rem !important;
		height: .42rem !important;
	}
	
	.centre_div_ri .centre_div_ri_img2 {
		width: .54rem;
		height: .42rem;
		margin: 0 .15rem;
	}
	
	.centre_div_ri .centre_div_ri_img2 img {
		width: .4rem !important;
		height: .58rem !important;
	}
	
	.centre_div_ri .centre_div_ri_text {
		text-align: left;
	}
	
	.centre_div_ri .centre_div_ri_text h4 {
		font-size: .16rem;
		margin-bottom: 0.05rem;
	}
	
	.centre_div_ri .centre_div_ri_text span {
		font-size: 0.14rem;
		color: #b2b2b2;
	}
	.centre_nai ul{
		display: flex;
		justify-content: space-between;
	}
	.centre_nai_li{
		width: 1.1rem;
		height: 1.1rem;
		box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
	
	}
	.centre_nai_li div{
		text-align: center;
	}
	.centre_nai_li_img img{
		width: .57rem;
		height: .375rem;
	}
	.centre_nai_li_text h4{
		font-size: .16rem;
		margin-bottom: 0.05rem;
	}
	.centre_nai_li_text span {
		font-size: 0.14rem;
		color: #b2b2b2;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
</style>
