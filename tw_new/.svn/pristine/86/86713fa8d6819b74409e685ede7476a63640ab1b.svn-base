<template>
  <div>
    <Card>
      <Row style="margin-bottom: 10px;">
        <Col>
          <Button size="small" type="primary" icon="md-add" @click="showModal = true">新增服务分类</Button>
          <Button size="small" type="primary" @click="props.isFold = !props.isFold">{{ props.isFold ? '展开' : '收起' }}</Button>
        </Col>
      </Row>
      <zk-table
        ref="table"
        sum-text="sum"
        index-text="#"
        :data="cateList"
        :columns="columns"
        :stripe="true"
        :border="true"
        :tree-type="true"
        :is-fold="props.isFold"
        :expand-type="false"
        :selection-type="props.selectionType">
        <template slot="isShow" slot-scope="scope">
          <i-switch :loading="scope.row.loading" v-model="scope.row.cate_is_show_bool" @on-change="onSwitchChange(scope.row.id, scope.row._normalIndex)">
            <span slot="open">显</span>
            <span slot="close">隐</span>
          </i-switch>
        </template>
        <template slot="is_self_support" slot-scope="scope">
          <i-switch :loading="scope.row.loading" v-model="scope.row['is_self_support']" @on-change="onSwitchSelfSupport(scope.row.id, scope.row._normalIndex)">
            <span slot="open">是</span>
            <span slot="close">否</span>
          </i-switch>
        </template>
        <template slot="cover" slot-scope="scope">
          <img :src="api_key + '/' + scope.row['cate_cover']" width="35" height="35">
        </template>
        <template slot="cateTools" slot-scope="scope">
          <Button size="small" type="default" icon="md-create" @click="handleUpdateCate(scope.row.id)">修改</Button>
          <Button size="small" type="success" icon="md-add">添加下级</Button>
          <Button size="small" type="warning" icon="md-trash">删除</Button>
        </template>
      </zk-table>
      <Modal width="200" title="图标查看" v-model="visible">
        <img :src="cateIcon" v-if="visible" style="width: 100%">
      </Modal>
      <Modal
        @on-ok="handlePost"
        :title="modalTitle"
        v-model="showModal">
          <Form v-model="cateForm" :label-width="80">
            <FormItem prop="cat_name" label="上级分类">
              <treeselect :value="cateForm.parent_id || cateList[0].id"
                          :searchable="false"
                          :multiple="false"
                          :options="cateList"
                          placeholder="点击选择上级分类"
                          noChildrenText="该分类暂无下级"
                          ref="roleSelect"
                          style="width: 300px;"/>
            </FormItem>
            <FormItem prop="cat_name" label="栏目名称">
              <Input v-model="cateForm.cat_name"/>
            </FormItem>
            <FormItem prop="cate_sort" label="栏目排序">
              <Input v-model="cateForm.cate_sort"/>
            </FormItem>
            <FormItem prop="cate_icon" label="封面图">
              <div>
                <img v-if="cateForm['cate_cover']" :src="`${api_key}/${cateForm['cate_cover']}`" width="50" height="50">
              </div>
              <Upload
                :action="`${api_key}/upload.image`"
                name="image"
                :format="['jpg','jpeg','png']"
                :max-size="2048"
                :on-format-error="handleFormatError"
                :on-exceeded-size="handleMaxSize"
                :show-upload-list="false"
                :on-success="handleSuccess">
                <Button icon="ios-cloud-upload-outline">
                  <span>{{cateForm['cate_cover'] ? '重新上传' : '上传图片'}}</span>
                </Button>
              </Upload>
            </FormItem>
            <FormItem prop="cate_remark" label="栏目简介">
              <Input type="textarea" v-model="cateForm.cate_remark"/>
            </FormItem>
          </Form>
      </Modal>
    </Card>
  </div>
</template>

<script>
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
const api_key = window.config.api_prefix || 'http://jiajie-admin.7dugo.com'
export default {
  name: 'categoriesIndex',
  mounted () {
    this.getList()
  },
  components: {
    Treeselect
  },
  watch: {
    showModal (n) {
      if (n) {
        if (this.cateList[0].label !== '==一级分类==') {
          this.cateList.unshift({
            label: '==一级分类==',
            id: 0,
            parent_id: 0
          })
        }
      } else {
        this.cateList.shift()
      }
    }
  },
  data () {
    return {
      api_key,
      modalTitle: '添加服务分类',
      showModal: false,
      visible: false,
      assetsPrefix: this.$config.baseURL,
      cateList: [],
      columns: [
        {
          label: '分类名称',
          prop: 'label'
        },
        {
          label: '是否显示',
          prop: 'cate_is_show',
          headerAlign: 'center',
          width: 100,
          type: 'template',
          template: 'isShow'
        },
        {
            label: '自营分类',
            prop: 'is_self_support',
            headerAlign: 'center',
            width: 100,
            type: 'template',
            template: 'is_self_support'
        },
        {
            label: '分类封面',
            prop: 'cate_cover',
            headerAlign: 'center',
            width: 100,
            type: 'template',
            template: 'cover'
        },
        {
          label: '操作',
          prop: '_action',
          headerAlign: 'center',
          type: 'template',
          template: 'cateTools'
        }
      ],
      cateForm: {
        parent_id: 0,
        cat_name: '',
        pay_type: '',
        cate_cover: '',
        cate_is_show: '',
        cate_sort: '',
        cate_remark: ''
      },
      props: {
        showRowHover: true,
        isFold: true,
        expandType: false,
        selectionType: false
      }
    }
  },
  methods: {
    getList () {
      this.$http('category.list', {
        'data-set': 'tree',
        field: 'cat_name as label, cate_cover, cate_is_show, is_self_support'
      }).then(rs => {
        this.cateList = rs.data
      })
    },
    onSwitchSelfSupport (id, index) {
      index -= 1
      this.cateList[index].loading = true
      const oldSwitchState = this.cateList[index].cate_is_show_bool
      this.$http(`category.change.support-${id}`).then(rs => {
          this.cateList[index].loading = false
      }).catch(m => {
          m.forEach(e => {
              this.$Message.info(e)
          })
          this.cateList[index].cate_is_show_bool = oldSwitchState
      })
    },
    onSwitchChange (id, index) {
      index -= 1
      this.cateList[index].loading = true
      const oldSwitchState = this.cateList[index].cate_is_show_bool
      this.$http(`category.change.show-${id}`).then(() => {
        this.cateList[index].loading = false
      }).catch(m => {
        m.forEach(e => {
          this.$Message.info(e)
        })
        this.cateList[index].cate_is_show_bool = oldSwitchState
      })
    },
    handleUpdateCate (id) {
      this.$http(`category.get-${id}`).then(rs => {
        Object.keys(this.cateForm).forEach(key => {
          this.cateForm[key] = rs.data[key] || ''
        })
        this.cateForm.id = id
        this.showModal = true
        this.modalTitle = '修改服务分类'
      })
    },
    handleMaxSize (file) {
      this.$Notice.warning({
        title: '超过最大文件上传限制',
        desc: '文件  ' + file.name + ' 太大了, 最多允许上传大小 2M.'
      })
    },
    handleFormatError (file) {
      this.$Notice.warning({
        title: '文件格式不允许上传',
        desc: '文件 ' + file.name + ' 各位不允许上传'
      })
    },
    handleSuccess (res, file) {
      if (res.error === 0) {
        this.cateForm['cate_cover'] = res.data.path
      } else {
        this.$Notice.warning({
          title: '文件上传失败',
          desc: '文件  ' + file.name + ' 文件上传失败.'
        })
      }
    },
    handlePost () {
      let api
      if (this.cateForm.id) {
        api = `category.update-${this.cateForm.id}`
      } else {
        api = 'category.add'
      }
      this.$http(api, this.cateForm).then(() => {
        this.getList()
      })
    }
  }
}
</script>

<style lang="less" scoped>
@import "./assets/icon/iconfont.css";
.select-icon:hover {
  cursor: pointer;
}
.ivu-upload-list {
  display: none;
}
</style>
