<template>
	<Card title="店员管理">
		<Table :columns="columns" :data="data"></Table>
	    <Modal
	      :mask-closable="false"
	      v-model="showIncomeModal"
	      width="80"
	      title="店员金额变动明细">
	      <search-order></search-order>
	      <Table :columns="incomeColumns" :data="incomeData"></Table>
	      <Page :total="40" size="small" show-elevator show-sizer style="margin-top: 10px;" />
	    </Modal>
	</Card>
</template>

<script>
import StaffIncomeMixin from './staffIncome'
import SearchOrder from './components/searchOrder'
export default {
  name: 'staffList',
  components: {
   	SearchOrder,
  },
  mixins: [
    StaffIncomeMixin
  ],
  data() {
    return {
      storeId: parseInt(this.$route.query.storeId || 0),
      storeSex: '',
      columns: [
        {
          title: '店员名字',
          key: 'staff_name',
          align: 'center'
        },
        {
          title: '店员等级',
          key: 'staff_lavel',
          align: 'center'
        },
        {
          title: '店员身份',
          key: 'user_type',
          align: 'center',
          render: (h, params) => {
            let user_type
            switch (parseInt(params.row['user_type'])) {
              case 1:
                user_type = '清洁师'
                    break
              case 2:
                user_type = '店铺管理员'
                    break
              case 3:
                user_type = '店主'
            }
            return h('span', user_type)
          }
        },
        {
          title: '店员性别',
          key: 'staff_sex',
          align: 'center'
        },
        {
          title: '店员电话',
          key: 'staff_tel',
          align: 'center'
        },
        {
          title: '操作',
          key: 'staff_tel',
          align: 'center',
          render: (h, params) => {
            return h('div', [
              h('Button', {
                props: {
                  type: 'primary',
                  size: 'small'
                },
                style: {
                  marginRight: '5px'
                },
                on: {
                  click: () => {
                    this.showDetail(params,params.index);
                  }
                }
              }, '查看订单'),
              h('Button', {
                props: {
                  type: 'primary',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.$http(`store.income.log-${params.row.user_id}`).then(rs => {
                      this.incomeData = rs.data
                      this.showIncomeModal = true
                    })
                  }
                }
              }, '金额明细')
            ]);
          }
        }
      ],
      data: []
    }
  },
  mounted() {
    if(this.storeId) {
      this.$http(`store.clerk.list-${this.storeId}`).then(rs => {
        this.data = rs.data
        //				this.data.forEach( (val,i,data) =>{
        //					this.storeSex = data[i].staff_sex == 0 ? '男' : '女'
        //				})
      })
    }

  },
  methods:{
    showDetail(params,index){
      this.$http(`staff.service.record-${params.row.user_id}`).then(rs => {
        console.log(rs)
      })
    },
    /**
     * 查看店员的收益明细
     * @param staffId
     */
    showIncomeDetail (staffId) {

    }
  }
}
</script>
