<template>
	<Card title="需求管理">
		<Table :columns="columns" :data="data"></Table>
		<Modal
      title="查看店铺详情"
      :mask-closable="false"
      width="80"
      v-model="showItemModal">
      <Form :label-width="90" v-model="itemForm">
      		<FormItem  label="需求描述">
			      <Input v-model="itemForm.demand_info"   placeholder="需求描述"></Input>
			    </FormItem>
			    <FormItem  label="姓名">
			      <Input v-model="itemForm.demand_contact_name"   placeholder="姓名"></Input>
			    </FormItem>
			    <FormItem  label="电话">
			      <Input v-model="itemForm.demand_telephone"  placeholder="电话"></Input>
			    </FormItem>
			    <FormItem  label="需求地址名">
			      <Input v-model="itemForm.demand_address_name"  placeholder="需求地址名"></Input>
			    </FormItem>
			    <FormItem  label="门牌号">
			      <Input v-model="itemForm.demand_house_number" placeholder="门牌号"></Input>
			    </FormItem>
      </Form>
    </Modal>
    <Modal
      :mask-closable="false"
      v-model="showExampleModal"
      title="输入审核不通过的理由"
      @on-ok="toExamineStore(currentId, currentIndex, -1)">
      <Form ref="formInline" :model="form" :label-width="80">
        <FormItem prop="reason" label="拒绝理由">
          <Input v-model="form.reason" type="textarea" :autosize="{minRows: 2,maxRows: 5}" :placeholder="form.reason"></Input>
        </FormItem>
      </Form>
    </Modal>
    <Modal
	</Card>
</template>

<script>
	export default {
		name: "demandList",
		mounted() {
			this.getDemandList()
		},
		data() {
			return {
				showItemModal:false,
				showExampleModal:false,
				currentId: 0,
      	currentIndex: -1,
				form: {
	        reason: '请输入拒绝的理由'
	      },
				itemForm: {
	        demand_info: '',
	        contact_name: '',
	        demand_contact_name: '',
	        demand_telephone: '',
	        address_name:'',
	        demand_address_name: '',
	        demand_house_number:'',
	        
      	},
				columns: [{
						title: '需求描述',
						key: 'demand_info',
						align: 'center',
					},
					{
						title: '姓名',
						key: 'contact_name',
						align: 'center',
					},
					{
						title: '电话',
						key: 'demand_telephone',
						align: 'center',
					},
					{
						title: '地址',
						key: 'address_name',
						align: 'center',
					},
					{
						title: '需求地址',
						key: 'demand_address_name',
						align: 'center',
					},
					{
						title: '状态',
						key: 'demand_is_show',
						width: 100,
						align: 'center',
					},
					{
						title: '审核状态',
						key: 'demand_is_show',
						width: 300,
						align: 'center',
						render: (h, params) => {
							return h('div', [
								h('Button', {
									props: {
										type: 'primary',
										size: 'small'
									},
									style: {
										marginRight: '5px',
										display: (params.row.demand_is_show == 0 || params.row.demand_is_show == -1) ? 'inline-block' : 'none'
									},
									on: {
										click: () => {
											this.thePass(params,params.index,1)
										}
									}
								}, '通过'),
								h('Button', {
									props: {
										type: 'primary',
										size: 'small'
									},
									style: {
	                  marginRight: '5px',
	                  display: params.row.demand_is_show == 0 ? 'inline-block' : 'none'
                	},
									on: {
										click: () => {
											this.currentId = params.row.id
                    	this.currentIndex = params.index
                    	this.showExampleModal = true
										}
									}
								}, '拒绝审核'),
//								h('Button', {
//	                props: {
//	                  type: params.row.demand_is_show == 1 ? 'error' : 'success',
//	                  size: 'small'
//	                },
//	                style: {
//	                	marginRight: '5px',
//	                  display: (params.row.demand_is_show == 1 || params.row.demand_is_show == 2) ? 'inline-block' : 'none'
//	                },
//	                on: {
//	                  click: () => {
//	                    this.updateDemand(params.row.id, params.index)
//	                    console.log(params.row.id)
//	                  }
//	                }
//           		}, params.row.demand_is_show == 1 ? '禁用' : '解除禁用'),
								h('Button', {
                    props: {
                        type: 'error',
                        size: 'small'
                    },
                    on: {
                        click: () => {
                           this.tableList(params,params.index)
                        }
                    }
                }, '查看详情')
							]);
						}
					}
				],
				data: []
			}
		},
		methods: {
			getDemandList () {
				this.$http('demand.list').then(rs => {
					this.data = rs.data
				})
			},
			thePass (params,index,type){
				//默认0 1：已通过 0：未处理 2：未通过
				let dataId=this.data[index].id
				let status=this.data[index].demand_is_show
				let data = {
	        pass: type,
	        reason: this.form.reason
	      }
//				this.data[index].demand_is_show = status == 0 ? 1 : status == 2 ? 0 : 0
				this.$http( 'demand.examine-'+dataId , data ).then( rs=> {
						this.data[index].demand_is_show=type;
				})
			},
			/**
     * 需求启用、停用状态切换
     * @param 需求 id
     * @param index 数据index
     */
	    updateDemand (listId, index) {
				let status=this.data[index].demand_is_show
	      this.$http( 'demand.examine-'+ listId ).then(() => {
	        this.data[index].demand_is_show = status == 1 ? 2 : 1
	      })
	    },
			tableList (params,index){
				let dataId=this.data[index].id;
				this.showItemModal=true;
	      this.$http('demand.get-'+dataId).then(rs => {
					Object.keys(this.itemForm).forEach(k => {
		        this.itemForm[k] = rs.data[k] || ''
		      })
				})
	      
			}
		}
	}
</script>

<style scoped>

</style>