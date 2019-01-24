<template>
  <Card title="后台操作记录">
    <Table :columns="columns" :data="data"></Table>
  </Card>
</template>

<script>
export default {
  name: 'adminLog',
  mounted () {
    this.getAdminLogList()
  },
  data () {
    return {
      page: 1,
      data: [],
      columns: [
        {
          title: '日志记录时间',
          key: 'log_at'
        },
        {
          title: '日志记录IP',
          key: 'log_ip'
        },
        {
          title: '日志内容',
          key: 'log_content'
        },
        {
          title: '操作管理员',
          key: 'user_nicename'
        }
      ]
    }
  },
  methods: {
    getAdminLogList (page = 1) {
      this.$http('admin.log.list', {
        rows: 30,
        page
      }).then(rs => {
        this.data = rs.data
      })
    }
  }
}
</script>

<style scoped>

</style>
