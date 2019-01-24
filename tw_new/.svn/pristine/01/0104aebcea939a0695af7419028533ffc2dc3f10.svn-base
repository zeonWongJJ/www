<template>
  <Table :stripe="true" size="small" border :columns="columns" :data="data"></Table>
</template>

<script>
export default {
  name: 'TreeTable',
  data () {
    return {
      columns: [
        {
          title: '分类名称',
          key: 'cat_name'
        },
        {
          title: '分类编号',
          key: 'cat_name'
        },
        {
          title: '分类图标',
          key: 'cate_icon'
        },
        {
          title: '是否显示',
          key: 'cate_is_show'
        },
        {
          title: '操作',
          key: '_action'
        }
      ],
      data: []
    }
  },
  props: {
    cateList: {
      type: Array,
      default () {
        return []
      }
    }
  }
}
</script>

<style scoped>

</style>
