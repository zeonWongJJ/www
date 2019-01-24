<template>
	<div class="structure">
		<div id="chart-container"></div>
		<div id="edit-panel">
			<div>
				<label>选择计划：</label><input type="text" id="selected-node" class="selected-node-group" readonly="readonly">
				<label>下级任务命名:</label>
				<ul id="new-nodelist">
					<li><input type="text" class="new-node"></li>
				</ul>
			<button class="btn" id="btn-add-nodes">添加</button>
			<button class="btn" id="btn-delete-nodes">删除</button>
			<button class="btn" id="btn-insert">发布任务</button>
			
			</div>
		</div>
		<div class="taskUl">
			<div class="taskLi" v-for="item in structure_task" @click="task_detail(item.task_id)"><span>任务：</span>{{item.task_title}}</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	import api from '@/api/api'
	export default {
		data() {
			return {
				chartData:{
					'structure_name': this.$route.query.structureName,
					'structure_id':this.$route.query.structureId,
					'project_id':this.$route.query.projectId,
					'progress': 0,
					'children': []
				},
				oc:null,
				structure_task:[],
				structure_id:null,
			}
		},
		mounted(){
			let that = this;
			let lists = {};
			lists.project_id = this.$route.query.projectId;
			lists.structure_id = this.$route.query.structureId
			var qs = require('qs');
			that.axios({
				method: 'post',
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				url: api.structure_sub,
				data: qs.stringify(lists) //传参变量
			})
			.then(function(res) {
				that.chartData.children = res.data.data;
				addd(that.chartData,that);
			})
		},
		methods:{
			task_detail(task_id) {
				let that = this;
				this.$router.push({
					path: "/task_detail",
					query: {
						task_id
					}
				});
			},
		}
	}
	//获取随机id
		var getId = function() {
			return(new Date().getTime()) * 1000 + Math.floor(Math.random() * 1001);
		};

		//orgchart的点击事件
		//点击.node
		
	function addd(data,vue){
		var $chartContainer = $('#chart-container');
		$chartContainer.empty();
		var oc = $chartContainer.orgchart({
			'data': data,
			'chartClass': 'edit-state',
			'exportButton': true,
			'parentNodeSymbol': '',
			'pan': true,
			'zoom': true,
			'nodeId':'structure_id',
			'nodeTitle':'structure_name',
			'exportButton':false,
			'createNode': function($node, data) {
				if(data.children) {
					delete data.children;
				}
				$node[0].dataset.source = JSON.stringify(data);
				var div;
				var progress = data.progress ? data.progress : 0;
				if(data.relationship == '001'||data.relationship == '000') {
						$node.addClass('parent');
					$node.css({
						'background': '#0ab3e9',
					}).find('.title').css('color', '#fff');
					div = '<div class="progress"><div class="leng" style="background:#86d8f6;border: 0;"><div style="width: ' + data.progress + '%;background: #fff;"></div></div><div style="color: #86d8f6;">' + data.progress + '%</div></div>'
				} else {
					div = '<div class="progress"><div class="leng"><div style="width: ' + progress + '%"></div></div><div>' + progress + '%</div></div>'
				}
				$node.append(div);
			
				$node.find('i.edge.topEdge,i.edge.leftEdge,i.edge.rightEdge').remove();
				if(!data.parent_id){
					$node.find('i.edge.bottomEdge').remove();
				}else{
					$node.find('i.edge.bottomEdge').click(function(){
						var check = $(this).attr('check');
						if(!check || check == ''){
							$(this).attr('check','check');
						}else{
							$(this).attr('check','');
						}
					})
				}
			}
		});
		oc.$chart.addClass('view-state');
		oc.$chartContainer.on('click', '.node', function() {
			var $node = $(this);
			$('#selected-node').val($node.find('.title').text()).data('node', $node);
			//获取节点任务列表
			if($node[0] === $('.orgchart').find('.node:first')[0]) {
				vue.structure_task = []
				vue.structure_id = null
				return;
			}
			var source = JSON.parse($node[0].dataset.source)
			var structure_id = source.structure_id;
			if(structure_id == vue.structure_id){
				return
			}
			var lists = {};
			lists.structure_id = structure_id;
			var qs = require('qs');
			vue.axios({
				method: 'post',
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				url: api.structure_tasks,
				data: qs.stringify(lists) //传参变量
			})
			.then(function(res) {
				if(res.data.error == 0) {
					if(res.data.data.length>0){
						vue.structure_task = res.data.data
						vue.structure_id = structure_id
					}else{
						vue.structure_task = []
					}
				}else{
					vue.$Message.error(res.data.msg);
				}
			})
		});
		//点击orgchart视图
		oc.$chartContainer.on('click', '.orgchart', function(event) {
			if(!$(event.target).closest('.node').length) {
				$('#selected-node').val('').data('node','');
				vue.structure_task = [];
				vue.structure_id = null;
			}
		});

		//添加按钮
	$('.node').on('click', function() {
		if(!$(this).is('.parent') ){
			$('.node').removeClass("border")
 			$(this).addClass("border")
		}
			
	});
		$('#btn-add-nodes').on('click', function() {
			var $chartContainer = $('#chart-container');
			var nodeVals = [];
			var validVal = $('#new-nodelist').find('.new-node').val().trim();
			if(validVal) {
				nodeVals.push(validVal);
			}
			var $node = $('#selected-node').data('node');
			if(!nodeVals.length) {
				vue.$Message.warning('请给下级任务一个命名');
				return;
			}
			var nodeType = 'children';
			
			if(nodeType !== 'parent' && !$('.orgchart').length) {
				vue.$Message.warning('Please creat the root node firstly when you want to build up the orgchart from the scratch');
				return;
			}
			if(nodeType !== 'parent' && !$node) {
				vue.$Message.warning('请选择计划');
				return;
			}
			var parent_id = JSON.parse($node[0].dataset.source).structure_id;
			var lists = {};
			lists.project_id = vue.$route.query.projectId;
			lists.structure_name = nodeVals[0];
			lists.parent_id = parent_id ? parent_id : 0;
			var qs = require('qs');
			vue.axios({
				method: 'post',
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				url: api.structure_insert,
				data: qs.stringify(lists) //传参变量
			})
			.then(function(res) {
				if(res.data.error == 0) {
					vue.$Message.success(res.data.msg+res.data.data.structure_id);
					var hasChild = $node.parent().attr('colspan') > 0 ? true : false;
					if(!hasChild) {
						var rel = nodeVals.length > 1 ? '110' : '100';
						oc.addChildren($node, nodeVals.map(function(item) {
							return {
								'structure_name': item,
								'relationship': rel,
								'structure_id':res.data.data.structure_id,
								'progress':0,
								'parent_id':parent_id
							};
						}));
//						var data = {};
//						data.structure_name = 'xxx';
//						data.relationship = rel;
//						data.structureId = res.data.data.structure_id;
//						data.progress = 0;
//						data.parent_id = parent_id;
//						oc.addChildren($node,data);
					} else {
						oc.addSiblings($node.closest('tr').siblings('.nodes').find('.node:first'), nodeVals.map(function(item) {
							return {
								'structure_name': item,
								'relationship': '110',
								'structure_id':res.data.data.structure_id,
								'progress':0,
								'parent_id':parent_id
							};
						}));
					}
					$('#chart-container').find('.node').eq(0).find('.edge').remove();
				} else {
					vue.$Message.error(res.data.msg)
				}
			})
		});

		//删除按钮
		$('#btn-delete-nodes').on('click', function() {
			var $node = $('#selected-node').data('node');
			if(!$node) {
				vue.$Message.warning('请选择计划');
				return;
			} else if($node[0] === $('.orgchart').find('.node:first')[0]) {
				vue.$Message.warning('首级不可删除')
				return;
			}
			var structure_id = JSON.parse($node[0].dataset.source).structure_id;
			var lists = {};
			lists.structure_id = structure_id;
			var qs = require('qs');
			vue.axios({
				method: 'post',
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				url: api.structure_delete,
				data: qs.stringify(lists) //传参变量
			})
			.then(function(res) {
				if(res.data.error == 0) {
					vue.$Message.success(res.data.msg);
					oc.removeNodes($node);
					$('#selected-node').val('').data('node', null);
				}else{
					vue.$Message.error(res.data.msg);
				}
			})
			
		});
		//跳转到发布任务
		$('#btn-insert').click(function(){
			var $node = $('#selected-node').data('node');
			if(!$node) {
				vue.$Message.warning('请选择计划');
				return;
			} else if($node[0] === $('.orgchart').find('.node:first')[0]) {
				vue.$Message.warning('首级不可选择')
				return;
			}
			var source = JSON.parse($node[0].dataset.source)
			var structure_id = source.structure_id;
			var structure_name = source.structure_name;
			vue.$router.push({
				path: "/releases",
				query: {
					structureId:structure_id,
					structureName: structure_name
				}
			});
		})
		
	}
</script>
<style>
	.structure #chart-container {
		position: relative;
		display: inline-block;
		top: 10px;
		left: 10px;
		height: 420px;
		width: calc(100% - 24px);
		border-radius: 5px;
		overflow: auto;
		line-height: 1;
		background: #fff;
	}
	
	.structure .orgchart {
		background: #fff;
		display: block;
	}
	
	.structure .orgchart .node {
		padding: 5px 15px;
	}
	
	.structure .orgchart .node .title {
		height: 30px;
		line-height: 30px;
		background: none;
	}
	
	.structure .orgchart .node .title .symbol {
		margin-top: 1px;
	}
	
	.structure #edit-panel{
	    position: relative;
	    display: inline-block;
	    top: 10px;
	    left: 10px;
	    width: calc(100% - 24px);
	    border-radius: 5px;
	    background: #fff;
	    padding: 10px;
	    margin-top: 10px;
	}
	
	.structure .taskUl{
	    position: relative;
	    display: inline-block;
	    top: 10px;
	    left: 10px;
	    width: calc(100% - 24px);
	    border-radius: 5px;
	    background: #fff;
	    padding: 0 10px;
	    margin-top: 10px;
	    font-size: 14px;
	}
	.structure .taskUl .taskLi{
		padding: 10px 0;
		cursor: pointer;
	}
	.structure .taskUl span{
		color: #0AB2E9;	
	}
	
	.structure #edit-panel .btn-inputs {
		font-size: 24px;
	}
	
	.structure #edit-panel.edit-state>:not(#chart-state-panel) {
		display: none;
	}
	
	.structure #edit-panel label {
		font-weight: bold;
		font-size: 14px;
	}
	
	.structure #edit-panel.edit-parent-node .selected-node-group {
		display: none;
	}
	
	.structure #chart-state-panel,
	.structure #selected-node,
	.structure #btn-remove-input {
		margin-right: 20px;
	}
	
	.structure #edit-panel button {
		background: #0ab3e9;
		color: #fff;
		display: inline-block;
		padding: 6px 12px;
		margin: 0 10px;
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
		border-radius: 4px;
	}
	
	.structure #edit-panel.edit-parent-node button:not(#btn-add-nodes) {
		display: none;
	}
	
	.structure #edit-panel button:hover,
	.structure .edit-panel button:focus,
	.structure .edit-panel button:active {
		
		border-color: #0ab3e9;
		box-shadow: 0 0 10px #0ab3e9;
	}
	#selected-node{
		font-size: 14px;
	}
	.structure #new-nodelist {
		display: inline-block;
		list-style: none;
		margin: -2px 20px 0 3px;
		padding: 0;
		vertical-align: text-top;
		border: 1px solid #8888;
		
	}
	
	.structure #new-nodelist>li{
		padding:1px 2px;
	}
	
	.structure .btn-inputs {
		vertical-align: sub;
	}
	
	.structure #edit-panel.edit-parent-node .btn-inputs {
		display: none;
	}
	
	.structure .btn-inputs:hover {
		text-shadow: 0 0 4px #fff;
	}
	
	.structure .radio-panel input[type='radio'] {
		display: inline-block;
		height: 24px;
		width: 24px;
		vertical-align: top;
	}
	
	.structure #edit-panel.view-state .radio-panel input[type='radio']+label {
		vertical-align: -webkit-baseline-middle;
	}
	
	.structure #btn-add-nodes {
		margin-left: 20px;
	}
	
	.structure .nodeName {
		display: inline-block;
		width: 100%;
		height: auto;
	}
	
	.structure .edge verticalEdge bottomEdge fa {
		background: #fff;
	}
	
	.structure .progress {
		width: 100%;
		margin-bottom: 2px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		color: #0ab3e9;
	}
	
	.structure .progress .leng {
		height: 4px;
		width: 100%;
		background: #e3f9ff;
		border-radius: 2px;
		border: 1px solid #0ab3e9;
	}
	
	.structure .progress .leng>div {
		height: 4px;
		background: #0ab3e9;
	}
	
	.structure .orgchart .node.focused,
	.structure .orgchart .node:hover {
		background: #e3f9ff;
	}
	
	.structure .node #edit-panel {
		display: inline-block;
	}
	
	.structure .orgchart .node {
		/*border: 1px solid #0ab3e9;*/
		border-radius: 5px;
		background: #e3f9ff;
		margin: 0 5px;
	}
	
	.structure .orgchart .lines .downLine {
		background-color: #b9d9e4;
	}
	
	.structure .orgchart .lines .topLine {
		border-top: 1px solid #b9d9e4;
	}
	
	.structure .orgchart .lines .leftLine {
		border-left: 1px solid #b9d9e4;
	}
	
	.structure .orgchart .lines .rightLine {
		border-right: 1px solid #b9d9e4;
	}
	
	.structure .orgchart .node .title {
		color: #576168;
	}
	
	.structure .orgchart .node .bottomEdge {
		top: -12px;
		bottom: auto;
		color: #bbbbbb;
		left: calc(50% - 6px);
		border: 1px solid #bbbbbb;
		border-radius: 50%;
		width: 10px;
		height: 10px;
		background: #ffffff;
		line-height: 0;
	}
	/*.edge.topEdge,.edge.rightEdge,.edge.leftEdge{
		display: none;
	}*/
	
	
	.structure .edge.verticalEdge.bottomEdge.fa:before {
		content: '-';
		line-height: 6px;
	}
	.structure .edge.verticalEdge.bottomEdge.fa[check = 'check']:before {
		content: '+';
		line-height: 10px;
	
	}
	.border{
		border: 2px solid #056382 !important;
		background: #fff !important;
	}
</style>