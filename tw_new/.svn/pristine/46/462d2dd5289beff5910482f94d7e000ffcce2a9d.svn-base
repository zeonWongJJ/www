export default {
  data () {
    return {
      showIncomeModal: false,
      incomeColumns: [
        {
          title: '记录时间',
          key: 'log_at',
          width: 150
        },
        {
          title: '订单编号',
          key: 'order_sn',
          width: 200
        },
        {
          title: '子订单',
          key: 'order_sub_sn',
          width: 100
        },
        {
          title: '资金变动',
          key: 'current_balance',
          width: 110,
          render: (h, params) => {
            const wallet_change_type = params.row['wallet_change_type'] == 1 ? '-' : '+'
            return h('span', `${wallet_change_type}${params.row['current_balance']}`)
          }
        },
        {
          title: '当前余额',
          key: 'current_balance',
          width: 110
        },
        {
          title: '变动描述',
          key: 'log_remark'
        }
      ],
      incomeData: []
    }
  }
}
