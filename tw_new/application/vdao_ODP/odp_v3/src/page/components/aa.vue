<template>
	<div class="as">
		<h4 @click="ass()">
		爱我就点我吧dsfdfasdf
    </h4>
		<h4>
		爱我就点我吧asdfdf
    </h4>

	</div>
</template>

<script>
	export default {
		data() {
			return {

			}
		},
		methods: {
			ass() {
				let that = this;
				that.$router.push({
					path: '/main'
				})
			},

		}
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
	.as {
		margin: 100px;
	}
</style>