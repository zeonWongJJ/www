<template>
  <Card title="权限管理">
    <rule-table :isOwnPage="true"></rule-table>
  </Card>
</template>

<script>
import RuleTable from './component/RuleTable'
export default {
  name: 'ruleIndex',
  components: {
    RuleTable
  }
}
</script>

<style scoped>

</style>
