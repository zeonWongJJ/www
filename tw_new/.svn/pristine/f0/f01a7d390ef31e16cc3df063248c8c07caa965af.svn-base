<template>
	<div class="index">
		<div class="appHeader">
			<appHeader></appHeader>
		</div>
		<div class="warpper">
			<div class="leftMenu">
				<LeftMenu></LeftMenu>
			</div>
			<div class="content" id="content">
				<router-view></router-view>
			</div>
		</div>
	</div>
</template>

<script>
	import appHeader from '@/page/index/header'
	import LeftMenu from '@/page/index/left'
	export default {
		name: 'index',
		components: {
			appHeader,
			LeftMenu,
		},
		data() {
			return {

			}
		},
		methods: {
			//			ajax() {
			//				this.$store.dispatch('login')
			//				console.log("name: " + this.$store.state.user.user.name);
			//			}
		}
	}
</script>


<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
	.index {
		height: 100%;
		background: #fff;
		max-width: 100%;
		/*margin: 0 auto;*/
		position: relative;
		z-index: 99;
	}
	#content {
		max-width: 100%;
		min-height: 820px;
		position: fixed;
		top: 90px;
		left: 190px;
		right: 0px;
		bottom: 0px;
		/*overflow: hidden;*/
		background: #2A2735;
		z-index: 99;
		/*box-shadow: -1px 0 0 #000;*/
		
	}

	
</style>
