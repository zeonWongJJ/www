<template>
	<div class="evaluate">
			<div class="tit_box">
			<ul class="tit_box_ul">
				<li @click="journal">日志</li>
				<li @click="doubt">疑问</li>
				<li class="tit_box_li">建议</li>
				<li @click="bugs">bug</li>
			</ul>
		</div>
			<div v-if="list ==''">
						<div class="task_details_header">
							<div>
								<div class="return_blue"></div>
								<div class="header_text">任务详情</div>
								<div class="return_blue"></div>
								<div class="header_text">动作记录</div>
							</div>
							<div>
								<div @click="aaaa()">
									发布动作记录
								</div>
							</div>
						</div>
						<p style="text-align: center;margin-top: 50px;">暂无评论</p>
					</div>
					<div class="evaluate_box test-1" v-else>
						<div class="task_details_header">
							<div>
								<div class="return_blue"></div>
								<div class="header_text">任务详情</div>
								<div class="return_blue"></div>
								<div class="header_text">动作记录</div>
							</div>
							<div>
								<div @click="aaaa()">
									发布动作记录
								</div>
							</div>
						</div>
						<div class="evaluate_con" v-for="(item,index) in list" v-if="item.task_record_type == 2" :key='index'>
							<div class="evaluate_con_img">
								<div>
									<img src="../../../assets/img/erweima.png" />
								</div>
							</div>
							<div class="evaluate_con_com">
								<div>{{item.my_name}} <span>{{item.task_record_add_date}}</span></div>
								<div>{{item.task_record_desc}}</div>
							</div>
							<div class="evaluate_con_p" @click="oeval(item,index)">
								<img src="../../../assets/img/reply.png" />
							</div>
							<div>
								<s-eval :taskId='item.task_id' :type='item.task_record_type' :department='item.department' :indexVal='index_val' :idsi="item.task_record_id" :ishow='item.parent_id' :divp='list'></s-eval>
							</div>
						</div>
					</div>
		
	</div>
</template>

<script>
	import api from '@/api/api'
	import evaLuate from '@/page/subcomponent/task_detail_s'
	export default {
		data() {
			return {
			
			}
		},
components: {
			evaLuate
		},
		methods: {
				journal() {
				let that = this;
				that.$router.push({
					path: 'journal'
				})
			},
			doubt() {//疑问
				let that = this;
				that.$router.push({
					path: 'doubt'
				})
			},
			proposal() {
				let that = this;
				that.$router.push({
					path: 'proposal'
				})
			},
			bugs() {
				let that = this;
				that.$router.push({
					path: 'bugs'
				})
			},

		
		},
		mounted() {
		}
	}
</script>


<style scoped>

	.tit_box {
		position: absolute;
		top: -85px;
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
	.zj_lise{
		background:#e4f6fd ;
		overflow: auto;
	}
</style>
