<template>
  <div>
    <Row class="expand-row">
      <Col span="8">
        <span class="expand-key">服务的评论数: </span>
        <span class="expand-value">{{ row.service_comment_count }}</span>
      </Col>
      <Col span="8">
        <span class="expand-key">服务好评数: </span>
        <span class="expand-value">{{ row.service_hp_count }}</span>
      </Col>
      <Col span="8">
        <span class="expand-key">服务总得分: </span>
        <span class="expand-value">{{ row.service_score_count }}</span>
      </Col>
    </Row>
    <Row>
      <Col span="8">
        <span class="expand-key">销量: </span>
        <span class="expand-value">{{ row.service_sold }}</span>
      </Col>
    </Row>
  </div>
</template>

<script>
export default {
  name: 'ServiceExpand',
  props: {
    row: Object
  }
}
</script>

<style scoped>
  .expand-row{
    margin-bottom: 16px;
  }
</style>
