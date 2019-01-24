<template>
  <div>
    <Form :model="formItem" :label-width="100">
      <FormItem label="技能星级">
        <Rate v-model="formItem.skill_star" :disabled="false" />
      </FormItem>
      <FormItem label="服务态度星级">
        <Rate v-model="formItem.attitude_star" :disabled="false" />
      </FormItem>
      <FormItem label="时间效率星级">
        <Rate v-model="formItem.time_efficiency_star" :disabled="false" />
      </FormItem>
      <FormItem label="评价类型">
        {{formItem.comment_type_star}}
      </FormItem>
      <FormItem label="评论内容">
        <Input v-model="formItem.comment_content" type="textarea"></Input>
      </FormItem>
    </Form>
  </div>
</template>

<script>
export default {
  name: 'CommentItem',
  computed: {
    formItem () {
      return this.$store.state.order.comment || {}
    }
  }
}
</script>

<style scoped>

</style>
