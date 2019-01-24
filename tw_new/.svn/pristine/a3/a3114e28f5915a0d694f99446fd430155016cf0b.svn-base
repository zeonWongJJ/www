<template>
  <Table :columns="rule" :data="commentList"></Table>
</template>

<script>
export default {
  name: 'list',
  data (){
    return {
      rule: [
        {
          title: '所属服务',
          key: 'service_name'
        },
        {
          title: '评论',
          key: 'comment_content'
        },
        {
          title: '评论时间',
          key: 'comment_add_time'
        },
        {
          title: '服务评分',
          key: 'comment_type_star'
        },
        {
          title: '技能评分',
          key: 'skill_star'
        },
        {
          title: '服务态度评分',
          key: 'attitude_star'
        },
        {
          title: '时间效率评分',
          key: 'time_efficiency_star'
        }
      ],
      commentList: []
    }
  },
  mounted () {
    this.getCommentList(this.$route.query.store_id)
  },
  methods :{
    getCommentList(id){
      let data = {};
      if (id) {
        data.condition = {
          'a.comment_store_id': id
        }
      }
      this.$http('comment.list',data).then(rs => {
        this.commentList = rs.data
      })
    }
  }
}
</script>

<style scoped>

</style>
