<template>
	<div class="subshop">
		<!--false-->
		<transition name="slide-fade">
			<div class="subshop_f_top" v-show="tab_show">

				<div class="f_top_div">
					<div>
						<div class="subshop_li">全部类别</div>
						<div @click="tab_show = !tab_show"><img src="../../assets/img/img_vx/service_h_top.png" /></div>
					</div>
					<div class="subshop_flaset">
						<ul ref="rrr">
							<li  v-for='(item ,index) in lists' :class="{subshop_li_f : index == num}" @click="tab_li(index)">
									{{item}}
							</li>
						</ul>
					</div>
				</div>
			</div>
		</transition>
		<!--true-->
		<div class="subshop_t_top">
			<div>
				<!--<span v-for='(item ,index) in lists' :class="{subshop_li : index == num_true}" @click="tab_li_true(index)">
					
					{{item}}
				</span>-->
				<ul ref="ddd" :style="ostyle">
					<li v-for='(item ,index) in lists' class="aaa" :class="{subshop_li : index == num}" @click="tab_li(index)">
						{{item}}
					</li>
				</ul>
			</div>
			<div @click="tab_show = !tab_show"><img src="../../assets/img/img_vx/service_s_bottom.png" /></div>
		</div>

		<div class="box">
			<div style="height: 14rem;">
				dasfadsfdsaf
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				lists: [
					'全部', '我', '你', '我们你的', '阿斯顿发射点给', '你', '我们你的', '我们你的你', '我们你的', '阿斯顿发射点给', '我们你的', '我们你的',
				],
//				flase_lists:[
//				'全部', '我', '你', '我们你的', '阿斯顿发射点给', '你', '我们你的', '我们你的你', '我们你的', '阿斯顿发射点给', '我们你的', '我们你的',
//				],
				num: 0,
//				num_false:0,
				tab_show: true,
				ostyle:{
					transform: ''
				}
			}
		},
		mounted() { //生命周期 
  			
		},
		methods: { //方法
			tab_li(index) {
				this.num = index;
				let allEles = document.querySelectorAll('.aaa');
				this.ostyle = {transform: 'translate(-'+allEles[index].offsetLeft+'px,0)'}
				console.log(this.ostyle);
				
			},
//			tab_li_false(index) {
//				this.num_false = index
//			},
		},

	}
</script>

<style scoped>
	.subshop {
		padding: 0 0.12rem;
	}
	
	.subshop_f_top {
		position: absolute;
		top: 2.8rem;
		right: 0;
		left: 0;
		bottom: 0;
		background: rgba(0, 0, 0, .1);
		z-index: 9999;
	}
	
	.f_top_div {
		background: #fff;
	}
	
	.f_top_div div:nth-child(1) {
		height: .3rem;
		line-height: .3rem;
		padding: 0 0.12rem;
		display: flex;
		align-items: center;
		justify-content: space-between;
		border-bottom: 0.01rem solid #f8f8f8;
	}
	
	.f_top_div div:nth-child(1) img {}
	
	.subshop_t_top {
		height: .35rem;
		line-height: .35rem;
		display: flex;
		justify-content: space-between;
	}
	
	.subshop_t_top ul {
		min-width: 2rem;
		height: .35rem;
		line-height: .35rem;
		display: -webkit-box;
        overflow-x: auto;
            /*适应苹果*/
        -webkit-overflow-scrolling:touch;
	}
	
	.subshop_t_top ul li {
		margin: 0 .1rem;
	}
	 .subshop_t_top ul::-webkit-scrollbar {
            display: none;
        }
     .subshop_t_top::-webkit-scrollbar {
            display: none;
        }
	.subshop_t_top>div:nth-child(1){
		flex: 0 0 3.1rem;
		 overflow-x: auto;
	}
	.subshop_t_top div:nth-child(2) {
		width: .35rem;
		text-align: center;
	}
	.subshop_flaset ul{
		padding: .12rem 0;
		overflow: hidden;
		display: flex;
		flex-wrap: wrap;
	}
	.subshop_flaset ul li {
		height: .3rem;
		line-height: .3rem;
		text-align: center;
		padding: 0rem 0.1rem;
		margin: 0 0.05rem .1rem;
		border-radius: 0.02rem;
		background: #f2f3f7;
		border-radius: 0.02rem;
		border: 0.01rem solid #f2f3f7;
	}
	.subshop_li {
		color: #18b4ed;
	}
	.subshop_li_f{
		color: #18b4ed;
		border: 0.01rem solid #18b4ed !important;
		background: #fff !important;
	}
	/* 可以设置不同的进入和离开动画 */
	/* 设置持续时间和动画函数 */
	
	.slide-fade-enter-active {
		transition: all .5s ease;
	}
	
	.slide-fade-leave-active {
		transition: all .5s cubic-bezier(1.0, 0.5, 0.8, 1.0);
	}
	
	.slide-fade-enter,
	.slide-fade-leave-to
	/* .slide-fade-leave-active for below version 2.1.8 */
	
	{
		transform: translateY(-30px);
		opacity: 0;
	}
	
	.box {
		position: absolute;
		top: 3.2rem;
		left: 0;
		right: 0;
		bottom: 0;
		padding: 0 .12rem;
		height: calc(100% - 3.2rem);
		overflow: auto;
	}
</style>