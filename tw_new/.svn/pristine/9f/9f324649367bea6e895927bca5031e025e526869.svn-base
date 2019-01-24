<template>
  <div>
    <Button type="primary" style="margin-bottom: 10px" icon="md-add" size="small" @click="showModal = true">新增项目
    </Button>
    <Table :columns="columns" :data="initServiceItem"></Table>
    <div style="margin: 10px 0;overflow: hidden">
      <div style="float: right;">
        <Page size="small" :total="100" :current="1"
              @on-change="changePage"></Page>
      </div>
    </div>
    <Modal
      v-model="showModal"
      title="新增服务项目"
      @on-ok="ok">
      <Form :model="formItem" :label-width="80" :rules="ruleValidate" ref="itemForm">
        <FormItem label="项目名称" prop="item_name">
          <Input v-model="formItem.item_name" placeholder="服务项目名称"></Input>
        </FormItem>
        <FormItem label="收费单价" prop="item_change">
          <Input v-model="formItem.item_change" placeholder="服务收费单价"
                 style="width: 300px;"></Input>
        </FormItem>
        <FormItem label="收费单位">
          <Input v-model="selectedUnit" :disabled="true" style="width: 90px;"></Input>
        </FormItem>
        <FormItem label="项目描述" prop="item_desc">
          <Input v-model="formItem.item_desc"
                 type="textarea"
                 :autosize="{minRows: 2, maxRows: 5}"
                 placeholder="服务项目描述"></Input>
        </FormItem>
      </Form>
    </Modal>
  </div>
</template>

<script>
const ruleValidate = {
  item_name: [
    {
      required: true,
      message: '服务项目名称必填'
    }
  ],
  item_change: [
    {
      required: true,
      message: '服务收费单价必填'
    }
  ]
}
export default {
  name: 'ServiceItem',
  props: {
    selectedUnit: {
      type: String,
      default() {
        return '元/次'
      }
    },
    initServiceItem: {
      type: Array,
      default () {
        return []
      }
    },
    isUpdate: {
      type: Boolean,
      default() {
        return false
      }
    }
  },
  data() {
    return {
      ruleValidate,
      serviceId: parseInt(this.$route.query.id || 0),
      showModal: false,
      columns: [
        {
          title: '项目名称',
          key: 'item_name'
        },
        {
          title: '项目收费',
          key: 'item_change',
          render: (h, params) => {
            return h('span', `${params.row.item_change}${this.selectedUnit}`)
          }
        },
        {
          title: '操作',
          key: '_action',
          render: (h, params) => {
            return h('div', [
              h('Button', {
                props: {
                  type: 'warning',
                  size: 'small'
                },
                style: {
                  marginRight: '5px'
                },
                on: {
                  click: () => {
                    console.log(params.row)
                    if (this.isUpdate && this.serviceId) {
                      this.$http(`service.item.delete-${params.row.id}`).then(() => {
                        this.initServiceItem.splice(params.index, 1)
                      })
                    } else {
                      this.initServiceItem.splice(params.index, 1)
                      this.$emit('on-add-item', this.initServiceItem)
                    }
                  }
                }
              }, '移除')
            ])
          }
        }
      ],
      formItem: {
        item_name: '',
        item_desc: '',
        item_change: '',
        is_show: true
      }
    }
  },
  methods: {
    ok () {
      this.$refs['itemForm'].validate((valid) => {
        if (valid) {
          if (this.isUpdate && this.serviceId) {
            this.$http(`service.item.add-${this.serviceId}`, this.formItem).then(rs => {
              this.afterOK()
            })
          } else {
            this.afterOK()
          }
        } else {
          this.$Message.error('验证未通过')
        }
      })
    },
    afterOK () {
      let arr = {}
      Object.keys(this.formItem).forEach(key => {
        arr[key] = this.formItem[key]
      })
      this.initServiceItem.push(arr)
      this.$emit('on-add-item', this.initServiceItem)
      this.$refs['itemForm'].resetFields()
    },
    changePage(page = 1) {
    }
  }
}
</script>
