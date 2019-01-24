<template>
	<div>

		<div>
			<ul class="lists_ul">
				<li v-for="(item,index) in lists" :data="lists" @click="eee(item,index)">
					{{item.project_name}}
					<div class="lists_ul_div" v-show="index == isshow">
						<div v-for="(isitem,index) in item.structure" class="inst_div">
							<div @click="selectStyle(index)">
								{{isitem.structure_name}}
							</div>
						</div>
						<div class="inst_div div_inp">
							<input type="text" v-model="qqqq" name="" id="" value="" />
							<input type="button" name="" id="" value="添加" @click="aaa(item,index)" />
						</div>
						<!--@click="selectStyle(index)"-->
					</div>
				</li>
			</ul>
		</div>

	</div>
</template>
<script>
	import api from '@/api/api'
	export default {
		data() {
			return {
				isActive: 0,
				lists: [],
				inst: [],
				isshow: -1,
				qqqq: '',
				structure: [],
				parent_id: '', //父级id
				project_name: '', //父级name
			}
		},

		created() {
			this.olist()
		},
		mounted() {

		},
		methods: {
			eee(item, index) {
				let that = this
				//				alert(item.project_name)
				that.project_name = item.project_name
				that.parent_id = item.project_id
				that.structure = that.lists[index].structure
				if(item.project_name == that.lists[index].project_name) {
					that.isshow = index
				}
			},

			aaa(item, index) {
				let that = this
				let val = {}
				val.project_id = that.parent_id
				val.structure_name = that.qqqq
				var qs = require('qs');
				that.axios({
						method: 'post',
						url: api.structure_insert,
						data: qs.stringify(val)
					})
					.then(function(res) {
						if(res.data.error == 0) {
							let liname = {}
							liname.structure_name = that.qqqq;
							liname.structure_id = res.data.data.structure_id;
							item.structure.push(liname)
							that.qqqq = '';
							that.$Message.success(res.data.msg)
						} else {
							that.$Message.error(res.data.msg)
						}
					})
			},

			selectStyle(index) {　
				let that = this;
				that.isActive = index;
				var structureId = that.structure[index].structure_id;
				var projectId = that.parent_id
				var structureName = that.structure[index].structure_name;
				this.$router.push({
					path: "/old_structure",
					query: {
						structureId,
						projectId,
						structureName
					}
				});
			},
			olist() {
				let that = this;
				that.axios({
						method: 'post',
						url: api.projects,
					})
					.then(function(val) {
						if(val.data.error == 0) {
							that.lists = val.data.data
						} else {
							that.$Message.error(val.data.msg)
						}

					})
			}

		},

	}
</script>
<style scoped>
	.lists_ul {
		padding: 30px 20px;
	}
	
	.lists_ul>li {
		width: 250px;
		line-height: 64px;
		background: #fff;
		border-radius: 10px;
		margin: 0 0 20px 10px;
		font-size: 20px;
		text-align: center;
		float: left;
	}
	
	.lists_ul_div {
		background: #0ab3e9;
	}
	
	.inst_div{
		font-size: 14px;
		height: 44px;
		line-height: 44px;
		color: #fff;
	}
	.div_inp{
		display: flex;
		padding: 5px;
		color: #333;
	}
	.div_inp input:nth-child(1) {
		flex: 1;
		border: 1px solid #8888;
		border-right: 0;
		border-radius: 4px 0 0 4px;
		padding: 0 10px;
	}
	
	.div_inp input:nth-child(2) {
		color: #333;
		background-color: #fff;
		display: inline-block;
		padding: 6px 12px;
		margin-bottom: 0;
		line-height: 1.42857143;
		text-align: center;
		white-space: nowrap;
		vertical-align: middle;
		-ms-touch-action: manipulation;
		touch-action: manipulation;
		cursor: pointer;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 0 4px 4px 0;
	}
</style>