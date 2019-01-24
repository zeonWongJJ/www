<template>
	<div class="leftMenu_box">
		<div class="leftMenu">
			<Menu :theme="theme3" active-name="1" width='190px' border-right='0px'>
				<MenuGroup>
					<!--<MenuItem name="1">
						<span @click="tasks">任务</span>
					</MenuItem>-->
					<MenuItem name="1">
						<div class="menuCon" :class="{index : $store.state.path == '/plan_x'}" @click="planned">
							<!--<em class="MenuIcon iconJihua"></em>-->
							<span>计划</span>
						</div>
					</MenuItem>
					<MenuItem name="2">
						<div class="menuCon" @click="structure">
							<!--<em class="MenuIcon iconJiegou"></em>-->
							<span >结构</span>
						</div>
					</MenuItem>
					<!--<MenuItem name="3">
						<div class="menuCon" @click="achievements">
							<em class="MenuIcon iconJixiao"></em>
							<span >绩效</span>
						</div>
					</MenuItem>
					<MenuItem name="4">
						<div class="menuCon" @click="notify">
							<em class="MenuIcon iconTongZhi"></em>
							<span >通知</span>
						</div>
					</MenuItem>
					<MenuItem name="5">
						<div class="menuCon" @click="dynamic">
							<em class="MenuIcon Dongtai"></em>
							<span >动态</span>
						</div>
					</MenuItem>-->
					<MenuItem name="6">
						<div class="menuCon">
							<!--<em class="MenuIcon iconAPI"></em>-->
							<a href="http://192.168.1.200:10000/#/index" target="_blank">API</a>
						</div>
					</MenuItem>
					<MenuItem name="7">
						<div class="menuCon">
							<!--<em class="MenuIcon iconYunpan"></em>-->
							<a href="http://192.168.1.200:8000/index.php/login" target="_blank">云盘</a>
						</div>
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
//					path: 'plan_x'
					path: 'plan_list_x'
				})
			},
			achievements() {
				let that = this;
				that.$router.push({
					path: 'achievements'
				})
			},
			notify() {
				let that = this;
				that.$router.push({
					path: 'systemNoti'
				})
			},
			dynamic() {
				let that = this;
				that.$router.push({
					path: 'friends_dynamic'
				})
			},
		}
	}
</script>

<style type="text/css">
	/*body,html{ width:100%: height:100%; position: absolute; background: red; }*/
	.leftMenu .ivu-menu-vertical .ivu-menu-item-group-title {
		height: 0 !important;
	}
	
	.ivu-menu-light.ivu-menu-vertical .ivu-menu-item-active:not(.ivu-menu-submenu) {
		/*background: #0ab3e9 !important;*/
		border-right: none !important;
		color: #FFFFFF !important;
	}
	
	.ivu-menu-light.ivu-menu-vertical .ivu-menu-item-active:not(.ivu-menu-submenu) span {
		color: #4DA1FF !important;
	}
</style>
<style scoped>

	.leftMenu .ivu-menu-vertical.ivu-menu-light:after {
		width: 0;
	}
	
	.leftMenu .ivu-menu-item-group {
		width: 190px !important;
		
		background: #3C394B;
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
		display: flex;
		align-items: center;
	}
	.menuCon{
		text-align: center;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.menuCon>.MenuIcon{
		width:28px;
		height:28px;
		margin-right:10px;
		background-position: center;
	}
	.menuCon>.iconJihua{
		background: url('../../../static/imgs/事务.png') no-repeat;
		background-size: 35px 35px;
	}
	.menuCon.index .iconJihua{
		background: url('../../../static/imgs/动态点击.png') no-repeat;
	}
	.leftMenu span,
	.leftMenu a {
		/*display: block;*/
		line-height: 85px;
		/*border-bottom: 1px solid #eee;*/
		font-size: 18px;
		color: #9e9ca5;
	}
	
	.tit {
		position: relative;
		width: 980px;
		height: 90px;
	}
</style>