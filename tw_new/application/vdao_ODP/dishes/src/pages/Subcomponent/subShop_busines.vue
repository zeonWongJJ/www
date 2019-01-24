<template>
	<div class="subshop">
		<div class="box">
					<div>
						<div class="box_j">
							<h4>商家介绍</h4>
							<p>阿姨帮是一款预约日常保洁、大扫除、新居开荒、衣物干洗、鞋具洗护服务的手机软件，由北京智诚永拓信息技术有限公司开发并运营。预约后，客服将为客户安排阿姨上门服务，服务完毕后还可以对服务进行打分和评价，帮助公司不断改进阿姨的服务质量。</p>
						</div>
						<div class="box_add">
							<h4>商家信息</h4>
							<div class="box_add_div">
								<div>
									<img src="../../assets/img/img_vx/shop_busines.png"/>
								</div>
								<div>商家名称：广州市宏鑫家政服务有限公司</div>
							</div>
							<div class="box_add_div">
								<div>
									<img src="../../assets/img/img_vx/shop_add.png"/>
								</div>
								<div>
									所在城市：广东-广州
								</div>
							</div>
						</div>
					</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {

			}
		},
		mounted() {//生命周期 

		},
		methods: {//方法


		},
	
}
</script>

<style scoped>
	
	h4{
		margin: 0 ;
		padding: 0 ;
		font-size: .16rem;
	}
	p{
		margin: 0 ;
		padding: 0 ;
		font-size: .14rem;
	}
.box{
		position: absolute;
		top: 2.9rem;
		left: 0;
		right: 0;
		bottom: 0;
		padding: 0 .12rem;
		height: calc(100% - 3rem);
		overflow: auto;
				
	}
 .box_j{
 	box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
 	padding: 0.1rem 0 0.15rem 0;
 	
 }
  .box_j h4{
  	margin: 0 0 0.1rem 0;
 }
 
 .box_add{
 	padding: 0.1rem 0 0.15rem 0;
 	box-shadow: 2px 2px 10px rgba(224, 243, 250, 1);
 	
 }
  .box_add h4{
  	margin: 0 0 0.1rem 0;
 }
   .box_add_div{
   	height: .18rem;
  	margin: 0 0 0.1rem 0;
  	display: flex;
  	align-items: flex-start;
 }
  .box_add>div div{
  	align-items: center;
 }
 .box_add div img{
 	width: 0.16rem;
 	margin :0 .08rem ;
 	/*vertical-align:text-bottom;*/
 }
 
</style>