<template>
	<div>
		<!--<div class="tit_box">
			<ul class="tit_box_ul">
				<!--<li class="tit_box_li"  @click="my_task()">好友动态 </li>
				<li @click.stop="mydynamic">我的动态</li>
				<li @click="dynamic">动态信息</li
				<li v-for="(item,index) in lists" :class="{tit_box_li : index == num}" @click="linum(item,index)">
					{{item.name}}
				</li>
			</ul>
		</div>-->
		<div>
			<eva-luate :num="num"></eva-luate>
		</div>
	</div>
</template>

<script>
	import api from '@/api/api'
	import evaLuate from '@/page/dynamic/dynamic_pl'
	export default {
		components: {
			evaLuate
		},
		data() {
			return {
				num: 0,
			
			}
		},
		
watch: {
    num(newValue, oldValue) {
//      console.log(newValue)
		
    }
},
		mounted() { //生命周期 
		this.linum()
		},
		methods: { //方法
			
			linum(item,index){
				let that = this;
				that.num = index
				
				
				
				
				
				
				
				
			},
			friends_dynamic() {
				let that = this;
				that.$router.push({
					path: 'friends_dynamic'
				})
			},
			mydynamic() {
				let that = this;
				that.$router.push({
					path: 'mydynamic'
				})
			},
			dynamic() {
				let that = this;
				that.$router.push({
					path: 'dynamic'
				})
			},

		},

	}
</script>

<style scoped>
	.tit_box {
		position: absolute;
		top: -88px;
		left: 0px;
		height: 85px;
		margin: 0 0 0 50px;
		border-bottom: 1px solid rgba(186, 233, 249, .5);
		z-index: 999;
	}
	
	.tit_box_ul {
		display: flex;
		width: 800px;
		margin: 0 auto;
	}
	
	.tit_box_ul li {
		text-align: center;
		font-size: 18px;
		width: 160px;
		line-height: 85px;
		height: 85px;
		position: relative;
	}
	
	.tit_box_ul li:hover:before {
		content: "";
		position: absolute;
		bottom: 0;
		left: 30px;
		height: 2px;
		width: 100px;
		background-color: #0ab3e9;
	}
	
	.tit_box_li {
		color: #0ab3e9;
	}
	
	.tit_box_li:before {
		content: "";
		position: absolute;
		bottom: 0;
		left: 30px;
		height: 2px;
		width: 100px;
		background-color: #0ab3e9;
	}
</style>