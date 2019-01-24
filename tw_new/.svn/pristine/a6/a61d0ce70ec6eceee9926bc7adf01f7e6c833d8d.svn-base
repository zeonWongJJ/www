<template>
  <Card title="配置列表">
    <Button style="margin-bottom: 10px;" size="small" type="primary" @click="showModal = true; modalTitle = '新增配置项'">添加配置</Button>
    <Table :columns="columns" :data="data"></Table>
    <Modal
      :title="modalTitle"
      v-model="showModal"
      @on-ok="handleAddConfig"
    >
      <Form v-model="configForm" :label-width="80" :mask-closeable="false">
        <FormItem prop="config_key" label="配置KEY">
          <Input v-model="configForm.config_key"/>
        </FormItem>
        <FormItem prop="config_key" label="配置项">
          <Input v-model="configForm.config_info"/>
        </FormItem>
        <FormItem prop="config_key" label="配置项类型">
          <i-select v-model="configForm.config_var_type">
            <Option value="string">文本</Option>
            <Option value="boolean">布尔值</Option>
          </i-select>
        </FormItem>
        <FormItem prop="config_key" label="配置值">
          <Input v-if="configForm.config_var_type == 'string'" v-model="configForm.config_value"/>
          <div v-else>
            <i-switch size="large" v-model="configForm.config_value">
              <span slot="open">开启</span>
              <span slot="close">关闭</span>
            </i-switch>
          </div>
        </FormItem>
        <FormItem prop="config_key" label="是否启用">
          <Input v-model="configForm.config_enable"/>
        </FormItem>
        <FormItem prop="config_key" label="配置备注">
          <Input type="textarea" v-model="configForm.config_remark"/>
        </FormItem>
      </Form>
    </Modal>
  </Card>
</template>

<script>
export default {
  name: 'configList',
  data () {
    return {
      showModal: false,
      modalTitle: '',
      configForm: {
          config_key: '',
          config_value: '',
          config_enable: 1,
          config_info: '',
          config_var_type: 'string',
          config_remark: ''
      },
      columns: [
        {
          title: '配置项',
          key: 'config_info'
        },
        {
          title: '配置值',
          key: 'config_value',
          render: (h, params) => {
            if (params.row['config_var_type'] === 'bool') {
              return h('i-switch', {
                props: {
                  type: 'primary',
                  value: params.row['config_value'] == 'true'
                },
                on: {
                  'on-change': value => {
                  }
                }
              })
            } else {
              return h('div', [
                h('Input', {
                  props: {
                    value: params.row['config_value']
                  },
                  style: {
                    display: 'inline-block',
                    float: 'left',
                    width: '60%'
                  }
                }),
                h('Button', {
                  props: {
                    type: 'primary'
                  },
                  style: {
                    marginLeft: '10px'
                  }
                }, '提交')
              ])
            }
          }
        },
        {
          title: '配置说明',
          key: 'config_remark'
        },
        {
          title: '启用',
          key: 'config_enable',
          width: 80,
          render: (h, params) => {
            return h('i-switch', {
              props: {
                type: 'primary',
                value: params.row['config_enable'] == '1'
              }
            })
          }
        }
      ],
      data: []
    }
  },
  mounted () {
    this.getConfigListData()
  },
  methods: {
    getConfigListData () {
      this.$http('config.list').then(rs => {
        this.data = rs.data
      })
    },
    handleAddConfig () {
      this.$http('config.add', this.configForm).then(() => {
        this.data.push(this.configForm)
      })
    }
  }
}
</script>

<style scoped>

</style>
