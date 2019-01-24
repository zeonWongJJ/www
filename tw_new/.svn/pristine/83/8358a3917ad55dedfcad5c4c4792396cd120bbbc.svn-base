<template>
  <div>
    <Card title="服务列表">
      <Button size="small" type="primary" icon="md-add" style="margin-bottom: 10px;" @click="$router.push({name: 'serviceInsert'})">添加新服务</Button>
      <Button size="small" type="warning" icon="md-trash" style="margin-bottom: 10px; margin-left: 5px;" @click="onTrashService">删除</Button>
      <Table :columns="columns" :data="serviceData" ref="serviceList"></Table>
      <div style="margin: 10px 0 80px 0;overflow: hidden">
        <div style="float: right;">
          <Page :page-size="30" show-sizer size="small" :total="total" :current="current" @on-change="changePage" show-total></Page>
        </div>
      </div>
    </Card>
  </div>
</template>

<script>
export default {
  name: 'serviceIndex',
  data () {
    return {
      columns: [
        {
          type: 'selection',
          key: 'id',
          width: 60,
          align: 'center'
        },
        {
          title: '服务名称',
          key: 'service_name'
        },
        {
          title: '所属店铺',
          key: 'store_name'
        },
        /*{
          title: '货号',
          key: 'id'
        },*/
        {
          title: '价格',
          key: 'service_remuneration'
        },
        {
          title: '上架',
          render: (h, params) => {
            return h('div', [
              h('i-switch', {
                props: {
                  size: 'large',
                  value: Boolean(params.row.service_status)
                },
                on: {
                  click: () => {
                    // this.show(params.index)
                  }
                }
              }, [
                h('span', {
                  slot: 'open'
                }, '下架'),
                h('span', {
                  slot: 'close'
                }, '上架')
              ])
            ])
          }
        },
        {
          title: '推荐排序',
          key: 'service_order'
        },
        {
          title: '操作',
          key: '_action',
          width: 200,
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
                    this.$router.push({
                      name: 'chargeStrategy',
                      query: {
                        id: params.row.id
                      }
                    })
                  }
                }
              }, '收费策略'),
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
                    this.$router.push({
                      name: 'serviceUpdate',
                      query: {
                        id: params.row.id
                      }
                    })
                  }
                }
              }, '修改'),
              h('Button', {
                props: {
                  type: 'warning',
                  size: 'small'
                }
              }, '删除')
            ])
          }
        }
      ],
      serviceData: [],
      total: 0,
      current: 0
    }
  },
  mounted () {
    this.getServiceList()
  },
  methods: {
    getServiceList (page = 1) {
      this.$http('service.list', {
        rows: 30,
        page
      }).then(rs => {
        this.serviceData = rs.data
        this.total = rs.count
        this.current = rs.append.page.current
      })
    },
    /**
     * 执行删除
     */
    onTrashService () {
      const selectionItems = this.$refs['serviceList'].getSelection()
      let items = []
      selectionItems.forEach(item => {
        items.push(item.id)
      })
      this.$http('service.delete', {
        id: items,
        soft_delete: 1 // 软删除
      }).then(() => {
        this.getServiceList(this.current)
      })
    },
    changePage (page) {
      this.current = page
      this.getServiceList(this.current)
    }
  }
}
</script>

<style lang="less" scoped>

</style>
