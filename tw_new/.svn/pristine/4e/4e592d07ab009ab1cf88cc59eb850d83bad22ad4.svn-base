<template>
  <div>
    <Button type="primary"
            style="margin-bottom: 10px"
            icon="md-add" size="small"
            @click="showModal = true">新增服务标准</Button>
    <Table :columns="columns" :data="initServiceStandards"></Table>
    <Modal
      v-model="showModal"
      title="新增服务标准"
      @on-ok="ok">
      <Form :model="formItem" :label-width="100" ref="itemForm" :rules="ruleValidate">
        <FormItem label="服务标准描述" prop="standards_desc">
          <Input v-model="formItem.standards_desc" placeholder="流程标题名称"></Input>
        </FormItem>
        <FormItem label="服务标准封面图" prop="standards_cover">
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
            <Input v-model="formItem.standards_cover" v-show="false"></Input>
          </Upload>
        </FormItem>
        <FormItem label="排序" prop="standards_sort">
          <Input v-model="formItem.standards_sort" placeholder="排序"></Input>
        </FormItem>
      </Form>
    </Modal>
  </div>
</template>
<script>
/**
 * 表格字段定义
 * @type {*[]}
 */
const tableColumns = [
  {
    title: '服务标准描述',
    key: 'standards_desc'
  },
  {
    title: '服务标准封面图',
    key: 'standards_cover',
    render: (h, params) => {
      const img_prefix = uploadAction.replace(/upload\.image/, '')
      return h('img', {
        domProps: {
          src: `${img_prefix}/${params.row.standards_cover}`
        },
        style: {
          width: '50px',
          height: '50px',
          padding: '8px'
        },
        on: {
          click: () => {
            this.currentSrc = `${img_prefix}/${params.row.flow_cover}`
            this.visible = true
          }
        }
      })
    }
  },
  {
    title: '排序',
    key: 'standards_sort'
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
              this.$http(`${api_prefix}.delete-${params.row.id}`).then(() => {
                this.initServiceStandards.splice(params.index, 1)
              })
            } else {
              this.initServiceStandards.splice(params.index, 1)
              this.$emit('on-add-item', this.initServiceStandards)
            }
          }
        }
      }, '移除')
    }
  }
]
/**
 * 表单验证规则
 * @type {{standards_desc: {required: boolean, message: string}[], standards_cover: {required: boolean, message: string}[]}[]}
 */
const ruleValidate = {
  standards_desc: [
    {
      required: true,
      message: '服务标准描述必填'
    }
  ],
  standards_cover: [
    {
      required: true,
      message: '服务标准封面图必填'
    }
  ]
}
/**
 * post字段定义
 * @type {{standards_desc: string, standards_cover: string, service_id: number, standards_sort: number}}
 */
const formItem = {
  standards_desc: '',
  standards_cover: '',
  standards_sort: 50
}
const api_prefix = 'service.standard'
const uploadAction = (window.config.api_prefix || 'http://jiajie-server_v2.7dugo.com')  + '/upload.image'
export default {
  name: 'serviceStandards',
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
    initServiceStandards: {
      type: Array,
      default () {
        return []
      }
    }
  },
  data () {
    return {
      showModal: false,
      serviceId: this.$route.query.id,
      columns: tableColumns,
      ruleValidate,
      uploadAction,
      formItem
    }
  },
  methods: {
    handleBeforeUpload () {
      if (this.formItem.standards_cover) {
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
      this.formItem.standards_cover = ''
    },
    handleFormatError (file) {
      this.$Notice.warning({
        title: '文件类型不允许上传',
        desc: '文件' + file.name + '类型不允许上传'
      })
    },
    handleSuccessUpload (response) {
      if (response.error === 0) {
        this.formItem.standards_cover = response.data.path
      }
    },
    ok () {
      this.$refs['itemForm'].validate((valid) => {
        if (valid) {
          if (this.isUpdate && this.serviceId) {
            this.$http(`${api_prefix}.add-${this.serviceId}`, this.formItem).then(() => {
              this.afterOk()
            })
          } else {
            this.afterOk()
          }
        } else {
          this.$Message.error('验证未通过')
        }
      })
    },
    afterOk () {
      let arr = {}
      Object.keys(this.formItem).forEach(key => {
        arr[key] = this.formItem[key]
      })
      this.initServiceStandards.push(arr)
      this.$emit('on-add-item', this.initServiceStandards)
      this.$refs['itemForm'].resetFields()
      this.$refs['upload'].clearFiles()
    }
  }
}
</script>
