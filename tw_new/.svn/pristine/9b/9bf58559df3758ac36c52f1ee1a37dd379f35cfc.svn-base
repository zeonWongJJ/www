<template>
	<div class="index">
		<div class="content" id="content">
			<router-view></router-view>
		</div>
		<div class="bottomNav">
			<div class="navItem" @click="$router.push('dishes_home')" :class="{index : to == '/dishes_home'}">
				<div class="logo home"></div>
				<div>首页</div>
			</div>
			<div class="navItem" @click="$router.push('census')" :class="{index : to == '/census'}">
				<div class="logo xinx"></div>
				<div>统计</div>
			</div>
			<div class="navItem" @click="$router.push('dishes_memder')" :class="{index : to == '/dishes_memder'}">
				<div class="logo member"></div>
				<div>我的</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'index',
		data() {
			return {
        to:'/dishes_home',
			}
		},
		mounted() {},
    watch:{
		  $route(val){
        this.to = val.path
      }
    },
	}
</script>

<style scoped>
	.index {
		height: 100%;
    background: #fff;
		overflow: hidden;
	}

	.index::-webkit-scrollbar {
		width: 0px
	}

	.content {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: .5rem;
		overflow: auto;
		-webkit-overflow-scrolling: touch;
	}

	.content::-webkit-scrollbar {
		width: 0px
	}

	.bottomNav {
		position: absolute;
		bottom: 0;
		display: flex;
		z-index: 999;
		border-top: 2px solid #f8f8f8;
		align-items: flex-start;
		width: 100%;
		font-size: .11rem;
		height: .5rem;
	}

	.navItem {
		text-align: center;
		width: 33.3%;
		height: .5rem;
		display: flex;
		flex-direction: column;
		justify-content: center;
	}

	.navItem.index {
		color: #18B4ED;
	}

	.navItem .logo {
		margin: 0 auto;
		width: .2rem;
		height: .2rem;
	}
	/*导航栏图标*/

	.navItem .logo.home {
		background: url('../assets/img/index/home.png') no-repeat;
		background-position: center;
		background-size: .2rem .2rem;
	}

	.navItem.index .logo.home {
		background: url('../assets/img/index/home_index.png') no-repeat;
		background-position: center;
		background-size: .2rem .2rem;
	}
	.navItem .logo.xinx {
		background: url('../assets/img/img_vx/bottom_4.png') no-repeat;
		background-position: center;
		background-size: .2rem .2rem;
	}
	.navItem.index .logo.xinx {
		background: url('../assets/img/img_vx/bottom_4_h.png') no-repeat;
		background-position: center;
		background-size: .2rem .2rem;
	}

	.navItem .logo.member {
		background: url('../assets/img/index/member.png') no-repeat;
		background-position: center;
		background-size: .2rem .2rem;
	}

	.navItem.index .logo.member {
		background: url('../assets/img/index/member_index.png') no-repeat;
		background-position: center;
		background-size: .2rem .2rem;
	}
	/*导航栏图标end*/
</style>
