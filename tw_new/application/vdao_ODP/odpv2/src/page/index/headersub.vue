<template>
  <div class="header_box">
	    <div class="header_tab">
	    	<div class="tit_box">
					<ul class="tit_box_ul">
						<li :class="tit_box_li ">我的任务</li>
						<li @click="all_tasks">计划任务</li>
						<li @click="list_tasks">发布任务</li>
						<li @click="release_task">任务榜单</li>
						<li @click="planned_task">全部任务</li>
					</ul>
				</div>
	    </div>
  	</div>
   
  </div>
</template>

<script>
export default {
  data () {
    return {
    	
    }
  },
      mounted(){
    	   	},
    	methods: {
all_tasks() {
				let that = this;
				that.$router.push({
					path: 'all_tasks'
				})
			},
			list_tasks() {
				let that = this;
				that.$router.push({
					path: 'list_tasks'
				})
			},
			release_task() {
				let that = this;
				that.$router.push({
					path: 'release_task'
				})
			},
			planned_task() {
				let that = this;
				that.$router.push({
					path: 'planned_task'
				})
			},
  	}
}
</script>

<style scoped>

.tit_box {
		position: absolute;
		top: 0px;
		left: 220px;
		height: 85px;
		/*width: 100%;*/
		margin: 0 auto 50px;
		border-bottom: 1px solid rgba(186,233,249,.5);
	}
	
	.tit_box_ul {
		display: flex;
		width: 800px;
		margin: 0 auto;
	}
	
	.tit_box_ul>li {
		text-align: center;
		font-size: 18px;
		width: 160px;
		line-height: 85px;
		height: 85px;
		position: relative;
	}
	
	.tit_box_ul>li:hover:before {
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
