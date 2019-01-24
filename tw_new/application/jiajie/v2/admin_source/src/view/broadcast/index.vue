<template>
    <Card title="轮播图片设置">
        <Row style="margin-bottom: 10px;">
            <Button size="small" type="success" icon="md-add" @click="addModalShow=true">新增轮播模板</Button>
        </Row>
        <Table :columns="columns" :data="data"></Table>
        <Modal
            v-model="addModalShow"
            title="轮播模板"
            @on-ok="addtemplate">
            <Form ref="formInline" :model="formInline" :rules="ruleInline" :label-width="85">
                <FormItem prop="slide_name" label="轮播模板主题">
                    <Input v-model="formInline.slide_name" placeholder="请输入轮播模板主题" style="width: 300px" />
                </FormItem>
                <FormItem prop="slide_href" label="轮播模板跳转链接">
                    <Input v-model="formInline.slide_href" placeholder="请输入轮播模板跳转链接" style="width: 300px" />
                </FormItem>
                <FormItem prop="slide_img_url" label="轮播图片">
                    <div class="demo-upload-list" v-for="item in uploadList">
                        <template v-if="item.status === 'finished'">
                            <img :src="item.url">
                            <div class="demo-upload-list-cover">
                                <Icon type="ios-eye-outline" @click.native="handleView(item.url)"></Icon>
                                <Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
                            </div>
                        </template>
                    </div>
                    <Upload
                            ref="upload"
                            :show-upload-list="false"
                            :default-file-list="defaultList"
                            :on-success="handleSuccess"
                            :format="['jpg','jpeg','png']"
                            :max-size="2048"
                            :on-format-error="handleFormatError"
                            :on-exceeded-size="handleMaxSize"
                            :before-upload="handleBeforeUpload"
                            multiple
                            name="image"
                            type="drag"
                            :action="`${api_prefix}/upload.image`"
                            style="display: inline-block;width:58px;">
                        <div style="width: 58px;height:58px;line-height: 58px;">
                            <Icon type="ios-camera" size="20"></Icon>
                        </div>
                    </Upload>
                </FormItem>
            </Form>

        </Modal>
        <Modal title="View Image" v-model="visible">
        <img :src="imgName" v-if="visible" style="width: 100%">
        </Modal>
    </Card>
</template>

<script>
    const api_prefix = window.config.api_prefix
export default {
name: 'broadcast',
mounted () {
  this.getList()
  this.formInline.uploadList = this.$refs.upload.fileList;
},
data () {
  return {
    api_prefix,
    imgName: '',
    visible: false,
    defaultList: [],
    uploadList: [],
    columns: [
      {
        title: '轮播模板主题',
        key: 'slide_name'
      },
      {
        title: '轮播图片路径',
        key: 'broadcast_url',
        render: (h, params) => {
          return h('img', {
            domProps: {
              src: `${api_prefix}/${params.row.slide_img_url}`
            },
            style: {
              width: '50px'
            }
          })
        }
      },
      {
        title: '轮播模板超链接',
        key: 'slide_href'
      }
      ],
    data: [],
    formInline: {
      slide_img_url:'',
      slide_name:'',
      slide_href:''
    },
    ruleInline:{
      slide_img_url: [
        { required: true, message: 'The name cannot be empty', trigger: 'blur' }
      ],
      slide_name: [
        { required: true, message: 'The name cannot be empty', trigger: 'blur' }
      ],
      slide_href: [
        { required: true, message: 'The name cannot be empty', trigger: 'blur' }
      ],
    },
    addModalShow:false,
  }
},
methods: {
  getList (page = 1) {
    this.$http('slide.list', {
      rows: 30,
      page
    }).then(rs=>{
      this.data = rs.data
    })
  },
  addtemplate(){
    this.$refs['formInline'].validate(v => {
      if (v) {
        this.formInline.slide_show_end_time = 0
        this.$http('slide.add', this.formInline).then(rs => {
          this.addModalShow = false
          this.data.push(this.formInline)
        })
      }
    })

  },
  handleView (name) {
    this.imgName = name
    this.visible = true
  },
  handleRemove (file) {
    const imgUrl = file.url.replace(api_prefix, '')
    this.$http('file.remove', {
      files: [imgUrl]
    }).then(rs => {
      if (rs.error == 0) {
        const fileList = this.$refs.upload.fileList
        this.formInline.uploadList.splice(fileList.indexOf(file), 1)
      }
    })
  },
  handleSuccess (res) {
    if (res.error == 0) {
      this.formInline.slide_img_url = res.data['path']
      this.uploadList = [];
      this.uploadList.push({
        name: res.data['source_name'],
        url: `${api_prefix}/${res.data['path']}`,
        status: 'finished'
      })
    }
  },
  handleFormatError (file) {
    this.$Notice.warning({
      title: 'The file format is incorrect',
      desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
    });
  },
  handleMaxSize (file) {
    this.$Notice.warning({
      title: 'Exceeding file size limit',
      desc: 'File  ' + file.name + ' is too large, no more than 2M.'
    });
  },
  handleBeforeUpload () {
    const check = this.formInline.uploadList.length < 5;
    if (!check) {
      this.$Notice.warning({
        title: 'Up to five pictures can be uploaded.'
      });
    }
    return check;
  }
}
  }
</script>

<style scoped>
    .demo-upload-list{
        display: inline-block;
        width: 60px;
        height: 60px;
        text-align: center;
        line-height: 60px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .demo-upload-list img{
        width: 100%;
        height: 100%;
    }
    .demo-upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .demo-upload-list:hover .demo-upload-list-cover{
        display: block;
    }
    .demo-upload-list-cover i{
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin: 0 2px;
    }
</style>