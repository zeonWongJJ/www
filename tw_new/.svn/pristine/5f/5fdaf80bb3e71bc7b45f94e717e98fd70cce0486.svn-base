<template>
  <div>
    <Button type="primary" style="margin-bottom: 10px" icon="md-add" size="small" @click="showModal = true">新增流程</Button>
    <Table :columns="columns" :data="initServiceFlows"></Table>
    <div style="margin: 10px 0;overflow: hidden">
      <div style="float: right;">
        <Page size="small" :total="100" :current="1" @on-change="changePage"></Page>
      </div>
    </div>
    <Modal
      v-model="showModal"
      title="新增服务流程"
      @on-ok="ok">
      <Form :model="formItem" :label-width="80" :rules="ruleValidate" ref="itemForm">
        <FormItem label="流程标题" prop="flow_title">
          <Input v-model="formItem.flow_title" placeholder="流程标题名称"></Input>
        </FormItem>
        <FormItem label="流程封面图" prop="flow_cover">
          <Upload
            ref="upload"
            name="image"
            :format="['jpg','jpeg','png', 'gif']"
            :max-size="2048"
            :action="uploadAction"
            :on-remove="handleRemoveFile"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            :before-upload="handleBeforeUpload"
            :on-success="handleSuccessUpload">
            <Button icon="ios-cloud-upload-outline">上传图片</Button>
          </Upload>
        </FormItem>
        <FormItem label="排序" prop="flow_sort">
          <Input v-model="formItem.flow_sort" placeholder="排序"></Input>
        </FormItem>
        <FormItem label="流程描述" prop="flow_content">
          <Input v-model="formItem.flow_content" type="textarea" :autosize="{minRows: 2, maxRows: 5}"
                 placeholder="流程描述描述"></Input>
        </FormItem>
      </Form>
    </Modal>
    <Modal title="图片查看" v-model="visible">
      <img :src="currentSrc" v-if="visible" style="width: 100%">
    </Modal>
  </div>
</template>

<script>
export default {
  name: 'initServiceFlows',
  props: {
    isUpdate: {
      type: Boolean,
      default() {
        return false
      }
    },
    /**
     * 渲染的数据列表
     */
    initServiceFlows: {
      type: Array,
      default () {
        return []
      }
    }
  },
  data () {
    return {
      serviceId: parseInt(this.$route.query.id || 0),
      uploadAction: window.config.api_prefix + '/upload.image',
      visible: false,
      currentSrc: '',
      showModal: false,
      formItem: {
        flow_title: '',
        flow_content: '',
        flow_cover: '',
        flow_sort: 1
      },
      columns: [
        {
          title: '流程标题',
          key: 'flow_title'
        },
        {
          title: '设备图片',
          key: 'flow_cover',
          render: (h, params) => {
            return h('img', {
              domProps: {
                src: `${window.config.api_prefix}/${params.row.flow_cover}`
              },
              style: {
                width: '50px',
                height: '50px',
                padding: '8px'
              },
              on: {
                click: () => {
                  this.currentSrc = `${window.config.api_prefix}/${params.row.flow_cover}`
                  this.visible = true
                }
              }
            })
          }
        },
        {
          title: '排序',
          key: 'flow_sort'
        },
        {
          title: '操作',
          key: '_action',
          render: (h, params) => {
            return h('Button', {
              props: {
                type: 'warning',
                size: 'small'
              },
              style: {
                marginRight: '5px'
              },
              on: {
                click: () => {
                  if (this.isUpdate && this.serviceId) {
                    this.$http(`service.flow.delete-${params.row.id}`).then(() => {
                      this.initServiceFlows.splice(params.index, 1)
                    })
                  } else {
                    this.initServiceFlows.splice(params.index, 1)
                    this.$emit('on-add-item', this.initServiceFlows)
                  }
                }
              }
            }, '移除')
          }
        }
      ],
      ruleValidate: {
        flow_title: [
          {
            required: true,
            message: '流程标题必填'
          }
        ],
        flow_cover: [
          {
            required: true,
            message: '流程封面图'
          }
        ]
      }
    }
  },
  methods: {
    handleBeforeUpload () {
      if (this.formItem.flow_cover) {
        this.$Notice.warning({
          title: '最多允许上传一张图片，如果需要重新上传请移除已上传的图片'
        })
        return false
      }
      return true
    },
    handleMaxSize (file) {
      this.$Notice.warning({
        title: '文件体积过大',
        desc: '文件  ' + file.name + ' 超过最多允许的上传大小.'
      });
    },
    handleRemoveFile (file) {
      // console.log(file)
      this.formItem.flow_cover = ''
    },
    handleFormatError (file) {
      this.$Notice.warning({
        title: '文件类型不允许上传',
        desc: '文件' + file.name + '类型不允许上传'
      })
    },
    handleSuccessUpload (response) {
      if (response.error === 0) {
        this.formItem.flow_cover = response.data.path
      }
    },
    ok () {
      this.$refs['itemForm'].validate((valid) => {
        if (valid) {
          let arr = {}
          if (this.isUpdate && this.serviceId) {
            this.$http(`service.flow.add-${this.serviceId}`, this.formItem).then(() => {
              Object.keys(this.formItem).forEach(key => {
                arr[key] = this.formItem[key]
              })
              this.initServiceFlows.push(arr)
              this.$refs['itemForm'].resetFields()
              this.$refs['upload'].clearFiles()
            })
          } else {
            Object.keys(this.formItem).forEach(key => {
              arr[key] = this.formItem[key]
            })
            this.initServiceFlows.push(arr)
            this.$emit('on-add-item', this.initServiceFlows)
            this.$refs['itemForm'].resetFields()
            this.$refs['upload'].clearFiles()
          }
        } else {
          this.$Message.error('验证未通过')
        }
      })
    },
    changePage (page) {
    }
  }
}
</script>

<style scoped>

</style>
