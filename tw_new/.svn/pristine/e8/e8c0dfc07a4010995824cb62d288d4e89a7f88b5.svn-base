<template>
  <div style="margin-bottom: 10px;">
    <Row style="margin-bottom: 10px;">
      <Button size="small" type="success" icon="md-add" @click="showModal = true;modalTitle='添加权限节点';ruleForm.parent_id = 0;delete ruleForm.id">添加权限节点</Button>
      <Button size="small" type="primary" v-if="isOwnPage" @click="props.isFold = !props.isFold">{{ props.isFold ? '展开' : '收起' }}</Button>
    </Row>
    <zk-table
      id="ruleTreeTable"
      ref="table"
      sum-text="sum"
      index-text="#"
      :selection-type="!isOwnPage"
      :data="ruleData"
      :columns="isOwnPage ? ownPageColumns : columns"
      :stripe="true"
      :border="true"
      :tree-type="true"
      :is-fold="props.isFold"
      :expand-type="false">
      <template slot="rule_enable" slot-scope="scope">
        <i-switch v-model="scope.row.rule_enable == 1" @on-change="handleChangeEnable(scope.row.id)">
          <Icon type="md-checkmark" slot="open"></Icon>
          <Icon type="md-close" slot="close"></Icon>
        </i-switch>
      </template>
      <template slot="rule_api" slot-scope="scope">
        <span>{{`${scope.row.rule_controller}/${scope.row.rule_action}/${scope.row.rule_router_param}`}}</span>
      </template>
      <template slot="_action" slot-scope="scope">
        <Button size="small" type="default" @click="handleUpdate(scope.row['id'] || 0)">修改</Button>
        <Button size="small" type="success" @click="handleAddSon(scope.row['id'] || 0)">添加下级</Button>
        <Button size="small" type="warning" @click="handleRemoveRule(scope.row['id'] || 0)">删除</Button>
      </template>
    </zk-table>
    <Modal
      @on-ok="handlePostRule"
      v-model="showModal"
      :title="modalTitle">
        <Form :label-width="100" v-model="ruleForm" ref="form">
          <FormItem prop="parent_id" label="规则所属上级id">
            <treeselect :value="ruleForm.parent_id || ruleData[0].id"
                        :searchable="false"
                        :multiple="false"
                        :options="ruleData"
                        placeholder="点击选择上级角色"
                        noChildrenText="该角色暂无下级"
                        ref="ruleSelect"
                        style="width: 300px;"/>
          </FormItem>
          <FormItem prop="rule_name" label="规则名称">
            <Input v-model="ruleForm.rule_name"></Input>
          </FormItem>
          <FormItem prop="rule_controller" label="规则所属控制器">
            <Input v-model="ruleForm.rule_controller"></Input>
          </FormItem>
          <FormItem prop="rule_action" label="规则所属方法">
            <Input v-model="ruleForm.rule_action"></Input>
          </FormItem>
          <FormItem prop="rule_router_param" label="规则路由参数">
            <Input v-model="ruleForm.rule_router_param"></Input>
          </FormItem>
          <FormItem prop="rule_enable" label="规则是否开启">
            <i-switch v-model="ruleForm.rule_enable" size="large">
              <span slot="open">开启</span>
              <span slot="close">关闭</span>
            </i-switch>
          </FormItem>
          <FormItem prop="rule_level" label="规则认证等级">
            <Select v-model="ruleForm.rule_level">
              <Option :value="1">只判断是否登录</Option>
              <Option :value="2">判断登录+权限</Option>
            </Select>
          </FormItem>
          <FormItem prop="rule_sort" label="菜单排序">
            <Input v-model="ruleForm.rule_sort"></Input>
            <span>数字越大排序越靠前</span>
          </FormItem>
        </Form>
    </Modal>
  </div>
</template>

<script>
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
const columns = [
  {
    label: '菜单名称',
    prop: 'label',
    width: 200
  },
  {
    label: '接口路由',
    type: 'template',
    template: 'rule_api',
    width: 160
  }
]
const ownPageColumns = columns.concat([
  {
    label: '鉴权等级',
    prop: 'rule_level'
  },
  {
    label: '是否开启',
    type: 'template',
    template: 'rule_enable'
  },
  {
    label: '排序',
    prop: 'rule_sort'
  },
  {
    label: '操作',
    type: 'template',
    template: '_action',
    width: 180
  }
])
export default {
  name: 'RuleTable',
  components: {
    Treeselect
  },
  props: {
    isOwnPage: {
      type: Boolean,
      default () {
        return false
      }
    }
  },
  watch: {
    showModal (n) {
      if (n) {
        this.ruleData.unshift({
          label: '==作为最上级==',
          id: 0,
          parent_id: 0
        })
      } else {
        if (this.ruleData[0].label === '==作为最上级==') {
          this.ruleData.shift()
        }
      }
    }
  },
  mounted () {
    this.getRuleTree()
  },
  data () {
    return {
      ruleCustom: {
        rule_name: [
          { required: true, message: '规则名称不能空', trigger: 'blur' }
        ],
        rule_controller: [
          { required: true, message: '规则所属控制器不能空', trigger: 'blur' }
        ],
        rule_action: [
          { required: true, message: '规则所属方法不能空', trigger: 'blur' }
        ]
      },
      ruleForm: {
        rule_name: '',
        rule_controller: '',
        rule_action: '',
        rule_router_param: '',
        rule_enable: true,
        parent_id: 0,
        rule_level: 1,
        is_menu: true,
        rule_sort: 50
      },
      showModal: false,
      modalTitle: '添加权限节点',
      ruleData: [],
      columns,
      ownPageColumns,
      props: {
        showRowHover: true,
        isFold: !this.isOwnPage,
        expandType: false
      }
    }
  },
  methods: {
    getRuleTree () {
      this.$http('auth.rule.list', {
        'data-set': 'tree',
        field: 'rule_name as label, rule_level, rule_enable, rule_sort, rule_controller, rule_action, rule_router_param'
      }).then(rs => {
        this.ruleData = rs.data
      })
    },
    handleAddSon (id) {
      this.ruleForm.parent_id = parseInt(id)
      this.showModal = true
      this.modalTitle = '添加子级'
    },
    handlePostRule () {
      let api
      if (this.ruleForm.id) {
        api = `auth.rule.update-${this.ruleForm.id}`
      } else {
        api = 'auth.rule.add'
      }
      this.ruleForm.parent_id = this.$refs['ruleSelect'].getValue()
      this.$http(api, this.ruleForm).then(() => {
        this.getRuleTree()
        this.$refs['form'].resetFields()
      })
    },
    handleUpdate (id) {
      if (id) {
        this.$http(`auth.rule.get-${id}`).then(rs => {
          rs.data['rule_level'] = parseInt(rs.data['rule_level'])
          rs.data['rule_enable'] = rs.data['rule_enable'] == 1
          Object.keys(this.ruleForm).forEach(key => {
            this.ruleForm[key] = rs.data[key] || ''
          })
          this.ruleForm['id'] = id
          this.showModal = true
          this.modalTitle = '修改规则'
        })
      }
    },
    handleRemoveRule (id) {
      if (id) {
        this.$Modal.confirm({
          title: '确认删除？',
          content: '<p>此操作不可逆，确定要删除吗？</p>',
          onOk: () => {
            this.$http(`auth.rule.delete-${id}`).then(() => {
              this.getRuleTree()
            })
          }
        })
      }
    },
    handleChangeEnable (id) {
      this.$http(`auth.rule.enable-${id}`).then(() => {
      }).catch(e => {
        this.$Message.info('操作失败')
        this.getRuleTree()
      })
    }
  }
}
</script>

<style scoped>

</style>
