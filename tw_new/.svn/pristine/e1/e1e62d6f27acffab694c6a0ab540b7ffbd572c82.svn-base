<template>
 <script id="editor" type="text/plain"></script>
</template>

<script>
import '../../../static/UEditor/ueditor.config.js'
import '../../../static/UEditor/ueditor.all.js'
import '../../../static/UEditor/lang/zh-cn/zh-cn.js'
export default {
  name: 'UE',
  data () {
    return {
      editor: null
    }
  },
  props: {
    defaultMsg: {
      type: String,
      default () {
        return ''
      }
    },
    config: {
      type: Object,
      default () {
        return {}
      }
    }
  },
  mounted () {
    const _this = this
    this.editor = UE.getEditor('editor', Object.assign({
      initialFrameWidth: null,
      initialFrameHeight: 200
    }, this.config)) // 初始化编辑器
    this.editor.addListener('ready', function () {
      _this.editor.setContent(_this.defaultMsg)
    })
  },
  methods: {
    getUEContent () {
      return this.editor.getContent()
    }
  },
  destroyed () {
    this.editor.destroy()
  }
}
</script>

<style>
</style>
