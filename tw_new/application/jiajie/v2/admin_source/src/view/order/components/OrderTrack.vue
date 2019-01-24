<template>
  <div>
    <Table :columns="columns" :data="data"></Table>
  </div>
</template>

<script>
export default {
  name: 'OrderTrack',
  computed: {
    orderSN () {
      return this.$store.state.order.orderSN || ''
    }
  },
  watch: {
    orderSN (n) {
      if (n) {
        this.getOrderActions(n)
      }
    }
  },
  data () {
    return {
      data: [],
      columns: [
        {
          title: '时间',
          key: 'log_at'
        },
        {
          title: '订单动作',
          key: 'log'
        }
      ]
    }
  },
  methods: {
    getOrderActions (n) {
      const orderSN = n || this.orderSN
      this.$http(`order.get.actions-${orderSN}`).then(rs => {
        this.data = rs.data
      })
    }
  }
}
</script>

<style scoped>

</style>
