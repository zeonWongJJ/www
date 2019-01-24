<template>
  <div>
    <Button type="primary" style="margin-bottom: 10px" icon="md-add" size="small" @click="showModal = true">新增设备</Button>
    <Table :columns="columns" :data="equipmentItem"></Table>
    <Modal
      v-model="showModal"
      title="新增专业设备"
      @on-ok="ok">
      <Form :model="formItem" :label-width="80" ref="itemForm">
        <FormItem label="设备名称" prop="equipment_name">
          <Input v-model="formItem.equipment_name" placeholder="设备名称"></Input>
        </FormItem>
        <FormItem label="设备图片" prop="equipment_img">
          <Upload
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
        <FormItem label="排序" prop="equipment_sort">
          <Input v-model="formItem.equipment_sort" placeholder="排序"></Input>
        </FormItem>
        <FormItem label="设备描述" prop="equipment_content">
          <Input v-model="formItem.equipment_content" type="textarea" :autosize="{minRows: 2, maxRows: 5}"
                 placeholder="设备描述"></Input>
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
  name: 'ProfessionalEquipment',
  props: {
    isUpdate: {
      type: Boolean,
      default() {
        return false
      }
    }
  },
  mounted() {
    if (this.serviceId) {
      this.$http(`service.get-${this.serviceId}`).then(rs => {
        this.equipmentItem = rs.data['equipment_item'] || []
      })
    }
  },
  data () {
    return {
      visible: false,
      currentSrc: '',
      uploadAction: window.config.api_prefix + '/upload.image',
      serviceId: parseInt(this.$route.query.id || 0),
      showModal: false,
      equipmentItem: [],
      columns: [
        {
          title: '设备名称',
          key: 'equipment_name'
        },
        {
          title: '设备图片',
          key: 'equipment_content',
          render: (h, params) => {
            return h('img', {
              domProps: {
                src: `${window.config.api_prefix}/${params.row.equipment_img}`
              },
              style: {
                width: '50px',
                height: '50px',
                padding: '8px'
              },
              on: {
                click: () => {
                  this.currentSrc = `${window.config.api_prefix}/${params.row.equipment_img}`
                  this.visible = true
                }
              }
            })
          }
        },
        {
          title: '排序',
          key: 'equipment_sort'
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
                    this.$http(`service.equipment.delete-${params.row.id}`).then(() => {
                      this.equipmentItem.splice(params.index, 1)
                    })
                  } else {
                    this.equipmentItem.splice(params.index, 1)
                    this.$emit('on-add-item', this.equipmentItem)
                  }
                }
              }
            }, '移除')
          }
        }
      ],
      formItem: {
        equipment_name: '',
        equipment_content: '',
        equipment_img: '',
        equipment_sort: 50
      }
    }
  },
  methods: {
    handleBeforeUpload () {
      if (this.formItem.equipment_img) {
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
      this.formItem.equipment_img = ''
    },
    handleFormatError (file) {
      this.$Notice.warning({
        title: '文件类型不允许上传',
        desc: '文件' + file.name + '类型不允许上传'
      })
    },
    handleSuccessUpload (response) {
      if (response.error === 0) {
        this.formItem.equipment_img = response.data.path
      }
    },
    ok() {
      let arr = {}
      if (this.isUpdate && this.serviceId) {
        this.$http(`service.equipment.add-${this.serviceId}`, this.formItem).then(() => {
          Object.keys(this.formItem).forEach(key => {
            arr[key] = this.formItem[key]
          })
          this.equipmentItem.push(arr)
          this.$refs['itemForm'].resetFields()
        })
      } else {
        Object.keys(this.formItem).forEach(key => {
          arr[key] = this.formItem[key]
        })
        this.equipmentItem.push(arr)
        this.$emit('on-add-item', this.equipmentItem)
        this.$refs['itemForm'].resetFields()
      }
    }
  }
}
</script>

<style scoped>

</style>
