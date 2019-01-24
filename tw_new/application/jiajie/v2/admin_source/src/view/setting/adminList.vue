<template>
  <Card title="管理员列表">
    <Button type="primary" size="small" style="margin-bottom: 10px;" @click="showModal = true;modalTitle = '新增管理员';delete adminForm.id">新增管理员</Button>
    <Table :columns="columns" :data="data"></Table>
    <Modal
      @on-ok="handlePostAdmin"
      :title="modalTitle"
      v-model="showModal">
      <Form v-model="adminForm" :label-width="100" ref="form">
        <FormItem prop="user_nicename" label="管理员姓名">
          <Input v-model="adminForm.user_nicename"></Input>
        </FormItem>
        <FormItem prop="user_name" label="管理员用户名">
          <Input v-model="adminForm.user_name"></Input>
        </FormItem>
        <FormItem prop="user_phone" label="管理员手机号码">
          <Input v-model="adminForm.user_phone"></Input>
        </FormItem>
        <FormItem prop="user_email" label="管理员邮箱地址">
          <Input v-model="adminForm.user_email"></Input>
        </FormItem>
        <FormItem prop="user_sex" label="管理员性别">
          <RadioGroup v-model="adminForm.user_sex">
            <Radio label="1">男</Radio>
            <Radio label="2">女</Radio>
          </RadioGroup>
        </FormItem>
        <FormItem prop="user_password" label="管理员登录密码">
          <Input v-model="adminForm.user_password"></Input>
          <span>留空则为不修改</span>
        </FormItem>
      </Form>
    </Modal>
  </Card>
</template>

<script>
export default {
  name: 'adminList',
  data () {
    return {
      showModal: false,
      modalTitle: '新增管理员',
      data: [],
      page: 1,
      adminForm: {
        user_nicename: '',
        user_name: '',
        user_phone: '',
        user_email: '',
        is_enable: true
      },
      watch: {
        showModal (n) {
          if (!n) {
            this.$refs['form'].resetFields()
          }
        }
      },
      columns: [
        {
          title: '管理员姓名',
          key: 'user_nicename'
        },
        {
          title: '管理员用户名',
          key: 'user_name'
        },
        {
          title: '管理员手机号码',
          key: 'user_phone'
        },
        {
          title: '管理员是否开启',
          key: 'is_enable',
          render: (h, params) => {
            return h('i-switch', {
              props: {
                value: params.row.is_enable == 1
              },
              on: {
                'on-change': () => {
                  this.$http(`admin.enable-${params.row.user_id}`).catch(e => {
                    this.$Message.info('切换失败')
                    this.getAdminList()
                  })
                }
              }
            })
          }
        },
        {
          title: '操作',
          key: '_action',
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
                    this.$http(`admin.get-${params.row.user_id}`).then(rs => {
                      this.adminForm['is_enable'] = rs.data['is_enable'] == 1
                      rs.data['user_sex'] = parseInt(rs.data)
                      Object.keys(this.adminForm).forEach(key => {
                        this.adminForm[key] = rs.data[key] || ''
                      })
                      this.adminForm['id'] = params.row.user_id
                      this.modalTitle = '修改管理员'
                      this.showModal = true
                    })
                  }
                }
              }, '修改'),
              h('Button', {
                props: {
                  type: 'primary',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.$Modal.confirm({
                      title: '确认删除',
                      content: '<p>该操作不可逆，请确认删除</p>',
                      onOk: () => {
                        this.handleRemoveAdmin(params.row.user_id, params.index)
                      }
                    })
                  }
                }
              }, '删除')
            ])
          }
        }
      ]
    }
  },
  mounted () {
    this.getAdminList()
  },
  methods: {
    handlePostAdmin () {
      let api
      if (this.adminForm.id) {
        api = `admin.update-${this.adminForm.id}`
      } else {
        api = 'admin.add'
      }
      this.$http(api, this.adminForm).then(rs => {
        this.getAdminList(this.page)
        this.$refs['form'].resetFields()
      })
    },
    getAdminList (page = 1) {
      this.$http('admin.list', {
        rows: 30,
        page
      }).then(rs => {
        this.data = rs.data
      })
    },
    handleRemoveAdmin (id, index) {
      this.$http(`admin.delete-${id}`).then(() => {
        this.data.splice(index, 1)
      })
    }
  }
}
</script>

<style scoped>

</style>
