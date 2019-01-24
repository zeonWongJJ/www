<template>
	<div class="leftMenu_box">
		<div class="leftMenu">
			<Menu :theme="theme3" active-name="1" width='190px' border-right='0px'>
				<MenuGroup>
					<!--<MenuItem name="1">
						<span @click="tasks">任务</span>
					</MenuItem>-->
					<MenuItem name="1">
							<span @click="planned">计划</span>
					</MenuItem>
					<MenuItem name="2">
						<span @click="structure">结构</span>
					</MenuItem>
					<!--<MenuItem name="3">
						<span @click="achievements">绩效</span>
					</MenuItem>
					<MenuItem name="4">
						<span @click="notify">通知</span>
					</MenuItem>
					<MenuItem name="5">
						<span @click="dynamic">动态</span>
					</MenuItem>-->
					<MenuItem name="6">
						<a href="http://192.168.1.200:10000/#/index" target="_blank">API</a>
					</MenuItem>
					<MenuItem name="7">
						<a href="http://192.168.1.200:8000/index.php/login" target="_blank">云盘</a>
					</MenuItem>
				</MenuGroup>
			</Menu>
		</div>
	</div>
</template>

<script>

	export default {
		data() {
			return {
				theme3: 'light'

			}
		},

		methods: {
			tasks() {
				let that = this;
				that.$router.push({
					path: 'my_task'
				})
			},
			structure() {
				let that = this;
				that.$router.push({
					path: 'struc_left'
				})
			},
			planned() {
				let that = this;
				that.$router.push({
					path: 'plan_x'
				})
			},
			achievements() {
				let that = this;
				that.$router.push({
					path: 'achievements'
				})
			},
			notify(){
				let that = this;
				that.$router.push({
					path: 'systemNoti'
				})
			},
				dynamic(){
				let that = this;
				that.$router.push({
					path: 'friends_dynamic'
				})
			},
		}
	}
</script>

<style type="text/css">
	.leftMenu .ivu-menu-vertical .ivu-menu-item-group-title {
		height: 0px !important;
	}
		.ivu-menu-light.ivu-menu-vertical .ivu-menu-item-active:not(.ivu-menu-submenu) {
		background: #0ab3e9 !important;
		border-right: none !important;
		color: #FFFFFF !important;
	}
			.ivu-menu-light.ivu-menu-vertical .ivu-menu-item-active:not(.ivu-menu-submenu) span{
		color: #FFFFFF !important;
	}
</style>
<style scoped>
	.leftMenu .ivu-menu-vertical.ivu-menu-light:after {
		width: 0;
	}
	
	.leftMenu .ivu-menu-item-group {
		width: 190px !important;
	}
	
	.ivu-menu-item {
		padding: 0 !important;
	}
	
	.ivu-menu {
		position: absolute;
		left: 0;
		top: 0px;
		bottom: 0;
	}
	

	
	.leftMenu {
		position: absolute;
		left: 0;
		top: 90px;
		bottom: 0;
		width: 190px;
		border-right: 0px;
		
	}
	
	.leftMenu span,.leftMenu a{
		display: block;
		line-height: 85px;
		text-align: center;
		border-bottom: 1px solid #eee;
		font-size: 22px;
		color: #495060;
	}
	.tit{
		position: relative;
		width: 980px;
		height: 90px;
	}
</style>