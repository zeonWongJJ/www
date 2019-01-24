<template>
	<div style="height: 100%;"> 
		<div class="a">
			<div class="header-fixed" v-show="!showAbs" :style="opacityStyle">
				<div class="header-fixed-back">景1111点详情</div>
			</div>
		</div>
		</div>
</template>

<script>
	export default {
		data() {
			return {
				showAbs: true,
				opacityStyle: {
					opacity: 0
				}
			}
		},
		methods: {
			handleScroll() {
				const top = document.documentElement.scrollTop
				if(top > 60) {
					let opacity = top / 140
					opacity = opacity > 1 ? 1 : opacity
					this.opacityStyle = {opacity}
					console.log('111')
					this.showAbs = false
				} else {
					this.showAbs = true
						console.log('111')
				}
			}
		},
		mounted() {
			window.addEventListener('scroll', this.handleScroll)
		},
		unmounted() {
			window.removeEventListener('scroll', this.handleScroll)
		}
	}
</script>

<style scoped>
	.a{
		width: 100%;
		height: 150%;
	}
	
	.header-fixed {
		position: fixed;
		z-index: 99999;
		top: 0;
		left: 0;
		right: 0;
		/*bottom: .5rem;*/
		height: .46rem;
		line-height: .46rem;
		text-align: center;
		color: #fff;
		background: #03B8CC;
		font-size: .22rem;
	}
	
	.header-fixed-back {
	}
</style>