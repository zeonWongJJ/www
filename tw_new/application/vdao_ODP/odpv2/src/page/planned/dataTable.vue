<template>
	<Card>
		<div class='ivu-table ivu-table-border ivu-table-stripe'>
			<table border="1" style="border: 1px">
				<colgroup>
					<col width="150">
					<col width="300">
					<col width="457">
					<col width="200">
					<col width="80">
				</colgroup>
				<tr class="ivu-table-row">
					<th class="ivu-table-column-center">
						<div class="ivu-table-cell">
							<span>组员</span>
						</div>
					</th>
					<!--<th>
						<div class="ivu-table-cell">
							<span>组长</span>
						</div>
					</th>-->
					<th class="ivu-table-column-center">
						<div class="ivu-table-cell">
							<span>计划</span>
						</div>
					</th>
					<th class="ivu-table-column-center">
						<div class="ivu-table-cell">
							<span>进度说明及问题原因</span>
						</div>
					</th>
					<th class="ivu-table-column-center">
						<div class="ivu-table-cell">
							<span>时间</span>
						</div>
					</th>
					<th class="ivu-table-column-center">
						<div class="ivu-table-cell">
							<span>进度</span>
						</div>
					</th>
				</tr>
				<template v-for="(plan, index2) in planData">
					<tr class="ivu-table-row">
						<td class="ivu-table-column-center" :rowspan="plan.group_plan_list.length ">
							<pre>{{plan.group_info.group_info}}</pre>
						</td>
						<!--<td :rowspan="plan.group_plan_list.length ">{{plan.group_info.group_leader}}</td>-->
						<td class="ivu-table-column-center">{{plan.group_plan_list[0].plan_name}}</td>
						<td class="ivu-table-column-center">{{plan.group_plan_list[0].plan_discuss}}</td>
						<td class="ivu-table-column-center">{{plan.group_plan_list[0].date}}</td>
						<td class="ivu-table-column-center">{{plan.group_plan_list[0].progress}}%</td>
					</tr>
					<tr class="ivu-table-row" v-for="(planItem, index) in plan.group_plan_list" v-if="index">
						<td class="ivu-table-column-center">{{planItem.plan_name}}</td>
						<td class="ivu-table-column-center">{{planItem.plan_discuss}}</td>
						<td class="ivu-table-column-center">{{planItem.date}}</td>
						<td class="ivu-table-column-center">{{planItem.progress}}%</td>
					</tr>
				</template>
			
		</table>
		</div>
		
	</Card>
</template>

<script>
	export default {
		name: 'dataTable',
		props: {
			planData: {
				type: Object,
				default () {
					return {}
				}
			}
		},
		mounted () {
			console.log(this.planData)
		}
	}
</script>

<style>
</style>