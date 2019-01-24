<template>
  <div>
    <Card title="角色列表">
      <Button size="small" type="primary" icon="md-add" style="margin-bottom: 10px;" @click="showModal = true; modalTitle = '添加角色'">添加角色</Button>
      <zk-table
        id="roleTreeTable"
        ref="table"
        sum-text="sum"
        index-text="#"
        :selection-type="false"
        :data="roleData"
        :columns="columns"
        :stripe="true"
        :border="true"
        :tree-type="true"
        :is-fold="true"
        :expand-type="false">
        <template slot="_action" slot-scope="scope">
          <Button :disabled="loading" v-if="scope.row.id" size="small" type="default" @click.native="updateRow(scope.row.id)">修改信息</Button>
          <Button :disabled="loading" v-if="scope.row.id" size="small" type="default" @click.native="handleAllowRule(scope.row.id)">权限分配</Button>
          <Button :disabled="loading" v-if="scope.row.id" size="small" type="success" @click.native="addSon(scope.row['id'] || 0)">添加下级</Button>
          <Button :disabled="loading" v-if="scope.row.id" size="small" type="warning" @click.native="handleRemoveRole(scope.row['id'] || 0)">删除</Button>
        </template>
      </zk-table>
    </Card>
    <Modal
      :mask-closable="false"
      v-model="showModal"
      :title="modalTitle"
      @on-ok="ok">
        <Form ref="formInline" :model="ruleForm" :label-width="80">
          <FormItem prop="role_name" label="所属上级">
            <treeselect :value="ruleForm.parent_id || roleData[0].id"
                        :searchable="false"
                        :multiple="false"
                        :options="roleData"
                        placeholder="点击选择上级角色"
                        noChildrenText="该角色暂无下级"
                        ref="roleSelect"
                        style="width: 300px;"/>
          </FormItem>
          <FormItem prop="role_name" label="角色名称">
            <Input type="text" v-model="ruleForm.role_name" placeholder="角色名称"></Input>
          </FormItem>
          <FormItem prop="role_name" label="角色描述">
            <Input v-model="ruleForm.role_info" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="角色描述"></Input>
          </FormItem>
          <FormItem label="角色组状态">
            <i-switch v-model="ruleForm.role_status" size="large">
              <span slot="open">开启</span>
              <span slot="close">关闭</span>
            </i-switch>
          </FormItem>
        </Form>
    </Modal>
    <Modal
      v-model="showCheckBoxModal"
      title="分配权限"
      style="height: 800px;"
      @on-ok="handleAllowRule($store.state.auth.roleId, true)">
      <auth-tree-check-box ref="authTreeCheckBox"></auth-tree-check-box>
    </Modal>
  </div>
</template>

<script>
import AuthTreeCheckBox from './component/AuthTreeCheckBox'
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
export default {
  name: 'authIndex',
  components: {
    Treeselect,
    AuthTreeCheckBox
  },
  mounted() {
    this.getRoleData()
  },
  data() {
    return {
      ruleForm: {
        id: 0,
        parent_id: 0,
        role_name: '',
        role_info: '',
        role_status: true
      },
      loading: false,
      modalTitle: '新增角色',
      showModal: false,
      showCheckBoxModal: false,
      roleData: [],
      columns: [
        {
          label: '角色名称',
          prop: 'label'
        },
        {
          label: '操作',
          type: 'template',
          template: '_action',
          width: 300
        }
      ],
      buttonProps: {
        size: 'small'
      }
    }
  },
  methods: {
    getRoleData () {
      this.$http('auth.role.list', {
        'data-set': 'tree',
        'field': 'role_name as label'
      }).then(rs => {
        this.roleData = rs.data
        this.checkRoleHasTopper()
      })
    },
    ok (roleId = 0) {
      delete this.ruleForm.id
      if (roleId) {
        this.$http('auth.role.add', this.ruleForm).then(() => {
          this.getRoleData()
        })
      } else {
        this.$http(`auth.role.update-${roleId}`, this.ruleForm).then(() => {
          this.getRoleData()
        })
      }
    },
    checkRoleHasTopper () {
      if (this.roleData[0].label !== '==最顶级角色==') {
        this.roleData.unshift({
          id: 0,
          label: '==最顶级角色==',
          parent_id: 0,
        })
      }
    },
    /**
     * 更新角色
     * @param roleId 角色id
     */
    updateRow (roleId) {
      if (roleId) {
        this.loading = true
        this.modalTitle = '修改角色'
        this.checkRoleHasTopper()
        this.$http(`auth.role.get-${roleId}`).then(rs => {
          if (rs.data) {
            rs.data['role_status'] = rs.data['role_status'] === '1'
          }
          Object.keys(this.ruleForm).forEach(key => {
            this.ruleForm[key] = rs.data[key] || ''
          })
          this.loading = false
          this.showModal = true
        })
      }
      this.loading = false
    },
    addSon (parentId) {
      this.loading = true
      this.modalTitle = '添加下级角色'
      this.checkRoleHasTopper()
      Object.keys(this.ruleForm).forEach(key => {
        if (key === 'parent_id') {
          this.ruleForm[key] = parseInt(parentId)
        } else {
          this.ruleForm[key] = ''
        }
      })
      this.loading = false
      this.showModal = true
    },
    /**
     * 执行删除角色
     * @param id
     */
    handleRemoveRole (id) {
      if (id) {
        this.loading = true
        this.$http(`auth.role.delete-${id}`).then(() => {
          this.getRoleData()
          this.loading = false
        }).catch(err => {
          this.loading = false
          err.forEach(e => {
            this.$Message.warning(e)
          })
        })
      }
    },
    handleAllowRule (id, isPost = false) {
      if (isPost) {
        let _selectedNodes = []
        const selectedNodes = this.$refs['authTreeCheckBox'].$refs['tree'].getCheckedAndIndeterminateNodes()
        selectedNodes.forEach(node => {
          _selectedNodes.push(parseInt(node.id))
        })
        this.$http(`auth.role.assign-${id}`, {
          assign_ids: _selectedNodes
        }).then(rs => {

        })
      } else {
        this.$store.commit('SET_ROLE_ID', 0)
        this.$store.commit('SET_ROLE_ID', id)
        this.showCheckBoxModal = true
      }
    }
  }
}
</script>

<style lang="less" scoped>
  @import "./index.less";
</style>
