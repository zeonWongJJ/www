<template>
  <div>
    <detail :is-update="true" :service-id="serviceId"></detail>
  </div>
</template>

<script>
import detail from './component/detail'
export default {
  name: 'serviceUpdate',
  components: {
    detail
  },
  data () {
    return {
      serviceId: parseInt(this.$route.query.id || 0)
    }
  }
}
</script>

<style scoped>

</style>
